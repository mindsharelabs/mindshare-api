<?php
/**
 * Mindshare Theme API JS / CSS MINIFICATION
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mcms-minify.php
 *
 * Derived from http://omninoggin.com/wordpress-plugins/wp-minify-wordpress-plugin/
 *
 * Usage:
 * <code>
 * <!--compression-none-->
 * ... JS/CSS content here is left alone, other HTML is compressed, whitespace and comments are skipped ...
 * <!--compression-none-->
 * </code>
 *
 */

/**
 * Class mapi_minify
 *
 * Employs the Minify engine to combine and compress JS and CSS files to improve page load time.
 * This class is called directly by the Theme API. Typically there is no reason to use it directly.
 *
 */
if(!class_exists('mapi_minify')) :
	class mapi_minify {

		public $options, $cache_location_url, $cache_location_path;
		public $adv_options_on, $debug, $minify_config_location, $buffer_started = FALSE;
		public $url_len_limit = 2000;
		public $minify_limit = 50;
		public $default_exclude = array('cdn.jsdelivr.net', 'cdnjs.cloudflare.com');

		public function __construct() {

			$this->options = get_option(MAPI_OPTIONS);

			$this->debug = apply_filters('mapi_minify_debug', $this->debug);
			$this->url_len_limit = apply_filters('mapi_minify_url_len_limit', $this->url_len_limit);
			$this->minify_limit = apply_filters('mapi_minify_minify_limit', $this->minify_limit);
			$this->minify_config_location = apply_filters('mapi_minify_config_location', MAPI_DIR_PATH . 'lib/minify-config.php');
			$this->default_exclude = apply_filters('mapi_minify_exclude', $this->default_exclude);

			if(mapi_is_true(@$this->options['enable_adv_speed_options']['enabled'])) {
				$this->adv_options_on = TRUE;
			}

			$uploads = wp_upload_dir();
			$this->cache_location_url = apply_filters('mapi_minify_cache_url', trailingslashit($uploads['baseurl']) . 'minify-cache/');
			$this->cache_location_path = apply_filters('mapi_minify_cache_location', trailingslashit($uploads['basedir']) . 'minify-cache/');
			$this->change_minify_config_location();
			$this->maybe_create_cache_dir();
			/*if(is_admin()) {
				$this->request_handler();
			}*/

			// hook POST actions to mindshare options framework
			add_action('mindshare_options_framework_before_page', array($this, 'request_handler'));
			add_action('mindshare_options_framework_before_save', array($this, 'request_handler'));

			if(!is_admin() && !is_feed() && !defined('XMLRPC_REQUEST')) {
				// Don't minify if user passes minify-off=1 in GET parameter
				if(!(current_user_can('manage_options') && @$_GET['minify-off'] == 1)) {
					add_action('init', array($this, 'pre_content'), 99999);
					add_action('wp_footer', array($this, 'post_content'), 99999);
				}
			}
		}

		public function __toString() {
			return get_class($this);
		}

		/**
		 * check_dir_writable
		 *
		 * @param $dir
		 * @param $notify_cb
		 *
		 * @return bool
		 */
		public function check_dir_writable($dir, $notify_cb) {
			if(is_writable($dir)) {
				return TRUE;
			} else {
				// error and return false
				add_action('admin_notices', $notify_cb);

				return FALSE;
			}
		}

		/**
		 * notify
		 *
		 * @param      $message
		 * @param bool $error
		 */
		public function notify($message, $error = FALSE) {
			if(is_admin()) {
				if(!$error) {
					echo '<div class="updated fade"><p>' . $message . '</p></div>';
				} else {
					echo '<div class="error"><p>' . $message . '</p></div>';
				}
			}
		}

		/**
		 * clear_cache
		 *
		 */
		public function clear_cache() {
			if(is_dir($this->cache_location_path)) {
				if($dh = opendir($this->cache_location_path)) {
					while(FALSE !== ($obj = readdir($dh))) {
						//echo $obj;
						if($obj == '.' || $obj == '..') {
							continue;
						}
						unlink(trailingslashit($this->cache_location_path) . $obj);
					}
					closedir($dh);
				}
				if(isset($_POST['mapi_options_clear_cache_submit'])) {
					wp_die('Minify cache has been cleared. <a href="options-general.php?page=' . MAPI_PLUGIN_SLUG . '-admin-settings">Continue &raquo;</a>');
				} else {
					$this->notify('Minify cache has been cleared.');
				}
			} else {
				$this->notify('No cached files to delete.');
			}
		}

		/**
		 * request_handler
		 *
		 */
		public function request_handler() {
			if(isset($_POST['mapi_options_clear_cache_submit'])) {
				// if user wants to regenerate nonce
				check_admin_referer('clear-minify-cache');
				$this->clear_cache();
				exit;
			}

			// only check these on plugin settings page
			$this->check_dir_writable($this->cache_location_path, array($this, 'notify_cache_not_writable'));

			if($this->check_dir_writable($this->minify_config_location, array($this, 'notify_config_not_writable'))) {
				$this->check_minify_config();
			}
		}

		/**
		 * check_minify_config
		 *
		 */
		public function check_minify_config() {

			$this->options = get_option(MAPI_OPTIONS); // refresh the options
			if(!is_array($this->options)) {
				$this->options = array();
			}

			if(!array_key_exists('cache_interval', $this->options)) {
				$this->options['cache_interval'] = 432000;
			}

			$fname = $this->minify_config_location;
			$fsize = filesize($fname);
			if($fsize < 1) {
				$fsize = 512;
			}

			$fhandle = fopen($fname, 'r');
			$content = fread($fhandle, $fsize);

			$config_modified = FALSE;

			preg_match('/\/\/###WPM-CACHE-PATH-BEFORE###(.*)\/\/###WPM-CACHE-PATH-AFTER###/s', $content, $matches);
			$cache_path_code = @trim($matches[1]);
			$path = untrailingslashit($this->cache_location_path);
			if($cache_path_code != '$min_cachePath = "' . $path . '";') {
				$content = preg_replace(
					'/\/\/###WPM-CACHE-PATH-BEFORE###(.*)\/\/###WPM-CACHE-PATH-AFTER###/s',
					"//###WPM-CACHE-PATH-BEFORE###\n" . '$min_cachePath = "' . $path . "\";\n//###WPM-CACHE-PATH-AFTER###",
					$content);
				$config_modified = TRUE;
			}

			preg_match('/\/\/###WPM-CACHE-AGE-BEFORE###(.*)\/\/###WPM-CACHE-AGE-AFTER###/s', $content, $matches);
			$cache_age_code = @trim($matches[1]);
			if($cache_age_code != '$min_serveOptions[\'maxAge\'] = ' . @$this->options['cache_interval'] . ';') {
				$content = preg_replace(
					'/\/\/###WPM-CACHE-AGE-BEFORE###(.*)\/\/###WPM-CACHE-AGE-AFTER###/s',
					"//###WPM-CACHE-AGE-BEFORE###\n" . '$min_serveOptions[\'maxAge\'] = ' . @$this->options['cache_interval'] . ';' . "\n//###WPM-CACHE-AGE-AFTER###",
					$content);
				$config_modified = TRUE;
			}

			if($config_modified) {
				$this->notify_modified_minify_config();
				update_option('mapi_minify_config_set', 1);
			}

			$fhandle = fopen($fname, "w");
			fwrite($fhandle, $content);
			fclose($fhandle);
		}

		/**
		 * change_minify_config_location
		 *
		 */
		public function change_minify_config_location() {
			$filename = MAPI_DIR_PATH . 'lib/min/config.php';
			$current_contents = file_get_contents($filename);
			$new_contents = '<?php require_once("' . $this->minify_config_location . '"); ?>';
			if($current_contents != $new_contents) {
				file_put_contents($filename, $new_contents);
			}
		}

		/**
		 * maybe_create_cache_dir
		 *
		 */
		public function maybe_create_cache_dir() {
			if(!is_dir($this->cache_location_path)) {
				if(!mkdir($this->cache_location_path, 0755)) {
					$this->notify_cache_not_writable();
				}
			}
		}

		/**
		 * set_minify_config
		 *
		 * @param bool $nominify
		 * @param bool $firephp
		 */
		public function set_minify_config($nominify = FALSE, $firephp = FALSE) {
			if($nominify) {
				$nominify = 'true';
			} else {
				$nominify = 'false';
			}
			if($firephp) {
				$firephp = 'true';
			} else {
				$firephp = 'false';
			}
			$fname = $this->minify_config_location;
			$fhandle = fopen($fname, 'r');
			$content = fread($fhandle, filesize($fname));

			$content = preg_replace(
				'/\/\/###WPM-DEBUG-FLAG-BEFORE###(.*)\/\/###WPM-DEBUG-FLAG-AFTER###/s',
				"//###WPM-DEBUG-FLAG-BEFORE###\n" . '$min_allowDebugFlag = ' . $nominify . ";\n//###WPM-DEBUG-FLAG-AFTER###",
				$content);

			$content = preg_replace(
				'/\/\/###WPM-ERROR-LOGGER-BEFORE###(.*)\/\/###WPM-ERROR-LOGGER-AFTER###/s',
				"//###WPM-ERROR-LOGGER-BEFORE###\n" . '$min_errorLogger = ' . $firephp . ";\n//###WPM-ERROR-LOGGER-AFTER###",
				$content);

			$fhandle = fopen($fname, "w");
			fwrite($fhandle, $content);
			fclose($fhandle);
		}

		/**
		 * notify_cache_not_writable
		 *
		 */
		public function notify_cache_not_writable() {
			$this->notify(
				sprintf('%s: %s',
					__('Cache directory is not writable. Please grant your server write permissions to the directory', 'mapi'),
					$this->cache_location_path),
				TRUE);
		}

		/**
		 * notify_config_not_writable
		 *
		 */
		public function notify_config_not_writable() {
			$this->notify(
				sprintf('%s: %s',
					__('minify-config.php is not writable. Please grant your server write permissions to file', 'mapi'),
					$this->minify_config_location));
		}

		/**
		 * notify_orphan_options
		 *
		 */
		public function notify_orphan_options() {
			$this->notify(
				sprintf('%s',
					__('Some option settings are missing (possibly from plugin upgrade).', 'mapi')));
		}

		/**
		 * notify_modified_minify_config
		 *
		 */
		public function notify_modified_minify_config() {
			$this->notify(__('Minify configuration was updated automatically.', 'mapi'));
		}

		/**
		 * @param $url
		 * @param $cache_file
		 *
		 * @return mixed|string
		 */
		public function fetch_and_cache($url, $cache_file) {
			$ch = curl_init();
			$timeout = 5; // set to zero for no timeout
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_USERAGENT, 'WP-Minify');
			$content = curl_exec($ch);
			curl_close($ch);
			if($content) {
				if(is_array($content)) {
					$content = implode($content);
				}

				// save cache file
				$fh = fopen($cache_file, 'w');
				if($fh) {
					fwrite($fh, $content);
					fclose($fh);
				} else {
					// cannot open for write.  no error b/c something else is probably writing to the file.
				}

				return $content;
			} else {
				printf(
					'%s: ' . $url . '. %s<br/>',
					__('Error: Could not fetch and cache URL'),
					__('You might need to exclude this file in WP Minify options.')
				);

				return '';
			}
		}

		/**
		 * @param $url
		 * @param $cache_file
		 */
		public function refetch_cache_if_expired($url, $cache_file) {
			$cache_file_mtime = filemtime($cache_file);
			if((time() - $cache_file_mtime) > $this->options['cache_interval']) {
				$this->fetch_and_cache($url, $cache_file);
			}
		}

		/**
		 * @param     $url
		 * @param int $latest_modified
		 *
		 * @return array
		 */
		public function check_and_split_url($url, $latest_modified = 0) {
			$url_chunk = explode('?f=', $url);
			$base_url = array_shift($url_chunk);
			$files = explode(',', array_shift($url_chunk));
			$num_files = sizeof($files);

			if($this->url_needs_splitting($url, $files)) {
				$first_half = $this->check_and_split_url($base_url . '?f=' . implode(',', array_slice($files, 0, $num_files / 2)), $latest_modified);
				$second_half = $this->check_and_split_url($base_url . '?f=' . implode(',', array_slice($files, $num_files / 2)), $latest_modified);

				return $first_half + $second_half;
			} else {

				// append &debug if we need to
				if($this->adv_options_on) {
					if(mapi_is_true($this->options['enable_adv_speed_options']['debug_nominify'])) {
						$debug_string = '&debug=true';
					}
				} else {
					$debug_string = '';
				}

				// append base directory if needed
				$base = $this->get_base();
				if($base != '') {
					$base_string = '&b=' . $base; // weird issue when using &amp; -> throws 400 error
				} else {
					$base_string = '';
				}

				// get rid of any base directory specification in extra options
				$extra_minify_options = preg_replace('/(&|&amp;|\b)b=[^&]*/', '', trim($this->options['enable_adv_speed_options']['extra_minify_options']));
				if(trim($extra_minify_options) != '' && $this->adv_options_on) {
					$extra_string = '&' . $extra_minify_options;
				} else {
					$extra_string = '';
				}

				// append last modified time
				$latest_modified_string = '&m=' . $latest_modified;

				return array($base_url . '?f=' . implode(',', $files) . $debug_string . $base_string . $extra_string . $latest_modified_string);
			}
		}

		/**
		 * @param        $url
		 * @param string $type
		 *
		 * @return mixed|string
		 */
		public function fetch_content($url, $type = '') {
			$cache_file = $this->cache_location_url . md5($url) . $type;

			/** @noinspection PhpUnusedLocalVariableInspection */
			$content = "";
			if(file_exists($cache_file)) {
				// check cache expiration
				$this->refetch_cache_if_expired($url, $cache_file);

				$fh = fopen($cache_file, 'r');
				if($fh && filesize($cache_file) > 0) {
					$content = fread($fh, filesize($cache_file));
					fclose($fh);
				} else {
					// cannot open cache file so fetch it
					$content = $this->fetch_and_cache($url, $cache_file);
				}
			} else {
				// no cache file.  fetch from internet and save to local cache
				$content = $this->fetch_and_cache($url, $cache_file);
			}

			return $content;
		}

		/**
		 * @param $url
		 *
		 * @return mixed
		 */
		public function local_version($url) {
			$site_url = trailingslashit(get_option('siteurl'));
			$url = str_replace($site_url, '', $url); // relative paths only for local urls
			//$url = preg_replace('/^\//', '', $url); // strip front / if any
			$url = preg_replace('/\?.*/i', '', $url); // throws away parameters, if any
			return $url;
		}

		/**
		 * @param      $url
		 * @param bool $localize
		 *
		 * @return bool
		 */
		public function is_external($url, $localize = TRUE) {
			if($localize) {
				$url = $this->local_version($url);
			}
			if(substr($url, 0, 4) != 'http' && substr($url, 0, 2) != '//'
				&& (substr($url, -3, 3) == '.js' || substr($url, -4, 4) == '.css')
			) {
				return FALSE;
			} else {
				return TRUE;
			}
		}

		/**
		 * @param $src
		 *
		 * @return mixed|string
		 */
		public function get_js_location($src) {
			if($this->debug) {
				echo 'Script URL:' . $src . "<br/>\n";
			}

			$script_path = $this->local_version($src);
			if($this->is_external($script_path, FALSE)) {
				// fetch scripts if necessary
				$this->fetch_content($src, '.js');
				$location = $this->cache_location_url . md5($src) . '.js';
				if($this->debug) {
					echo 'External script detected, cached as:' . md5($src) . "<br/>\n";
				}
			} else {
				// if script is local to server
				$location = $script_path;
				if($this->debug) {
					echo 'Local script detected:' . $script_path . "<br/>\n";
				}
			}

			return $location;
		}

		/**
		 * @param $src
		 *
		 * @return mixed|string
		 */
		public function get_css_location($src) {
			if($this->debug) {
				echo 'Style URL:' . $src . "<br/>\n";
			}

			$css_path = $this->local_version($src);
			if($this->is_external($css_path, FALSE)) {
				// fetch scripts if necessary
				$this->fetch_content($src, '.css');
				$location = $this->cache_location_url . md5($src) . '.css';
				if($this->debug) {
					echo 'External css detected, cached as:' . md5($src) . "<br/>\n";
				}
			} else {
				$location = $css_path;
				// if css is local to server
				if($this->debug) {
					echo 'Local css detected:' . $css_path . "<br/>\n";
				}
			}

			return $location;
		}

		/**
		 * @param $url
		 * @param $locations
		 *
		 * @return bool
		 */
		public function url_needs_splitting($url, $locations) {
			if($url > $this->url_len_limit || count($locations) > $this->minify_limit) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		/**
		 * @param $locations
		 *
		 * @return array
		 */
		public function build_minify_urls($locations) {

			$minify_url = MAPI_DIR_URL . 'lib/min/?f=';

			$minify_url .= implode(',', $locations);
			$latest_modified = $this->get_latest_modified_time($locations);
			$minify_urls = $this->check_and_split_url($minify_url, $latest_modified);

			return $minify_urls;
		}

		/**
		 * @return string
		 */
		public function get_base_from_minify_args() {
			if(!empty($this->options['enable_adv_speed_options']['extra_minify_options']) && $this->adv_options_on) {
				if(preg_match('/\bb=([^&]*?)(&|$)/', trim($this->options['enable_adv_speed_options']['extra_minify_options']), $matches)) {
					return rtrim(trim($matches[1]), '\\/');
				}
			}

			return '';
		}

		/**
		 * @return string
		 */
		public function get_base_from_siteurl() {
			$site_url = trailingslashit(get_option('siteurl'));

			return rtrim(preg_replace('/^https?:\/\/.*?\//', '', $site_url), '\\/');
		}

		/**
		 * @return string
		 */
		public function get_base() {
			$base_from_min_args = $this->get_base_from_minify_args();
			if($base_from_min_args != '') {
				return $base_from_min_args;
			}

			return $this->get_base_from_siteurl();
		}

		/**
		 * @param array $locations
		 *
		 * @return int
		 */
		public function get_latest_modified_time($locations = array()) {
			$latest_modified = 0;
			if(!empty($locations)) {
				$base_path = trailingslashit($_SERVER['DOCUMENT_ROOT']);
				$base_path .= trailingslashit($this->get_base());

				foreach($locations as $location) {
					$path = $base_path . $location;
					$mtime = filemtime($path);
					if($latest_modified < $mtime) {
						$latest_modified = $mtime;
					}
				}
			}

			return $latest_modified;
		}

		/**
		 * @param $content
		 *
		 * @return array
		 */
		public function extract_css($content) {
			$css_locations = array();

			preg_match_all('/<link([^>]*?)>/i', $content, $link_tags_match);

			foreach($link_tags_match[0] as $link_tag) {
				if(strpos(strtolower($link_tag), 'stylesheet')) {
					// check CSS media type
					if(!strpos(strtolower($link_tag), 'media=')
						|| preg_match('/media=["\'](?:["\']|[^"\']*?(all|screen)[^"\']*?["\'])/', $link_tag)
					) {
						preg_match('/href=[\'"]([^\'"]+)/', $link_tag, $href_match);
						if($href_match[1]) {
							// include it if it is in the include list
							$include = FALSE;
							if($this->adv_options_on) {
								$inclusions = explode("\r\n", $this->options['enable_adv_speed_options']['css_include']);
							} else {
								$inclusions = array();
							}
							foreach($inclusions as $include_pat) {
								$include_pat = trim($include_pat);
								/** @noinspection PhpUndefinedVariableInspection */
								if(strlen($include_pat) > 0 && strpos($src_match[1], $include_pat) !== FALSE) {
									$include = TRUE;
									break;
								}
							}

							if(!$include) {
								// support external files?

								if($this->is_external($href_match[1])) {
									continue; // skip if we don't cache externals and this file is external
								}

								// do not include anything in excluded list
								$skip = FALSE;
								if($this->adv_options_on) {
									$exclusions = array_merge($this->default_exclude, explode("\r\n", $this->options['enable_adv_speed_options']['css_exclude']));
								} else {
									$exclusions = $this->default_exclude;
								}
								foreach($exclusions as $exclude_pat) {
									$exclude_pat = trim($exclude_pat);
									if(strlen($exclude_pat) > 0 && strpos($href_match[1], $exclude_pat) !== FALSE) {
										$skip = TRUE;
										break;
									}
								}
								if($skip) {
									continue;
								}
							}

							$content = str_replace($link_tag . '</link>', '', $content);
							$content = str_replace($link_tag, '', $content);
							$css_locations[] = $this->get_css_location($href_match[1]);
						}
					}
				}
			}

			$css_locations = array_unique($css_locations);

			return array($content, $css_locations);
		}

		/**
		 * @param $content
		 * @param $css_locations
		 *
		 * @return mixed
		 */
		public function inject_css($content, $css_locations) {
			if(count($css_locations) > 0) {

				// build minify URLS
				$css_tags = '';
				$minify_urls = $this->build_minify_urls($css_locations);

				foreach($minify_urls as $minify_url) {
					$minify_url = apply_filters('mapi_minify_css_url', htmlspecialchars($minify_url)); // Allow plugins to modify final minify URL
					$css_tags .= "<!--suppress ALL --><link rel='stylesheet' href='$minify_url' type='text/css' media='all' />";
				}

				$matches = preg_match('/<!--compression-none-->/', $content);

				if($matches) {
					$content = preg_replace('/<!--compression-none-->/', "$css_tags", $content, 1); // limit 1 replacement
				} else {
					// HTML5 has <header> tags so account for those in regex
					$content = preg_replace('/<head(>|\s[^>]*?>)/', "\\0\n$css_tags", $content, 1); // limit 1 replacement
				}
			}

			return $content;
		}

		/**
		 * @param $content
		 *
		 * @return array
		 */
		public function extract_conditionals($content) {
			preg_match_all('/<!--\[if[^\]]*?\]>.*?<!\[endif\]-->/is', $content, $conditionals_match);
			$content = preg_replace('/<!--\[if[^\]]*?\]>.*?<!\[endif\]-->/is', '###WPM-CSS-CONDITIONAL###', $content);

			$conditionals = array();
			foreach($conditionals_match[0] as $conditional) {
				$conditionals[] = $conditional;
			}

			return array($content, $conditionals);
		}

		/**
		 * @param $content
		 * @param $conditionals
		 *
		 * @return mixed
		 */
		public function inject_conditionals($content, $conditionals) {
			while(count($conditionals) > 0 && strpos($content, '###WPM-CSS-CONDITIONAL###')) {
				$conditional = array_shift($conditionals);
				$content = preg_replace('/###WPM-CSS-CONDITIONAL###/', $conditional, $content, 1);
			}

			return $content;
		}

		/**
		 * @param $content
		 *
		 * @return array
		 */
		public function extract_js($content) {

			$js_locations = array();

			preg_match_all('/<script([^>]*?)><\/script>/i', $content, $script_tags_match);

			foreach($script_tags_match[0] as $script_tag) {
				if(strpos(strtolower($script_tag), 'text/javascript') !== FALSE) {
					preg_match('/src=[\'"]([^\'"]+)/', $script_tag, $src_match);
					if($src_match[1]) {
						// include it if it is in the include list
						$include = FALSE;
						if($this->adv_options_on) {
							$inclusions = explode("\r\n", $this->options['enable_adv_speed_options']['js_include']);
						} else {
							$inclusions = array();
						}
						foreach($inclusions as $include_pat) {
							$include_pat = trim($include_pat);
							if(strlen($include_pat) > 0 && strpos($src_match[1], $include_pat) !== FALSE) {
								$include = TRUE;
								break;
							}
						}

						if(!$include) {
							// support external files?
							if($this->is_external($src_match[1])) {
								continue; // skip if we don't cache externals and this file is external
							}

							// do not include anything in excluded list
							$skip = FALSE;
							if($this->adv_options_on) {
								$exclusions = array_merge($this->default_exclude, explode("\r\n", $this->options['enable_adv_speed_options']['js_exclude']));
							} else {
								$exclusions = $this->default_exclude;
							}
							foreach($exclusions as $exclude_pat) {
								$exclude_pat = trim($exclude_pat);
								if(strlen($exclude_pat) > 0 && strpos($src_match[1], $exclude_pat) !== FALSE) {
									$skip = TRUE;
									break;
								}
							}
							if($skip) {
								continue;
							}
						}

						$content = str_replace($script_tag, '', $content);
						$js_locations[] = $this->get_js_location($src_match[1]);
					}
				}
			}

			$js_locations = array_unique($js_locations);

			return array($content, $js_locations);
		}

		/**
		 * inject_js
		 *
		 * @param $content
		 * @param $js_locations
		 *
		 * @return mixed
		 */
		public function inject_js($content, $js_locations) {
			if(count($js_locations) > 0) {
				// build minify URLS
				$js_tags = '';
				$minify_urls = $this->build_minify_urls($js_locations);

				foreach($minify_urls as $minify_url) {
					$minify_url = apply_filters('mapi_minify_js_url', htmlspecialchars($minify_url)); // Allow plugins to modify final minify URL
					$js_tags .= "<script type='text/javascript' src='$minify_url'></script>";
				}

				$matches = preg_match('/<!--compression-none-->/', $content);

				if($matches) {
					$content = preg_replace('/<!--compression-none-->/', "$js_tags", $content, 1); // limit 1 replacement
				} else {
					// HTML5 has <header> tags so account for those in regex
					$content = preg_replace('/<head(>|\s[^>]*?>)/', "\\0\n$js_tags", $content, 1); // limit 1 replacement

				}
			}

			return $content;
		}

		/**
		 * pre_content
		 *
		 */
		public function pre_content() {

			//$exclusions = array_merge($this->default_exclude, explode("\r\n", $this->options['enable_adv_speed_options']['uri_exclude']));
			$exclusions = $this->default_exclude; // uri pattern option is deprecated for now

			//if(!is_admin()) var_dump($exclusions); die;
			if(!empty($exclusions)) {
				foreach($exclusions as $exclude_pat) {
					$exclude_pat = trim($exclude_pat);
					if(strlen($exclude_pat) < 0) {

						return;
					}
				}
			}

			ob_start(array($this, 'modify_buffer'));

			// variable for sanity checking
			$this->buffer_started = TRUE;
		}

		/**
		 * @param $buffer
		 *
		 * @return mixed|void
		 */
		public function modify_buffer($buffer) {

			// minify JS (make sure to exclude IE conditionals)
			if($this->options['minify_js']) {
				list($buffer, $conditionals) = $this->extract_conditionals($buffer);
				list($buffer, $js_locations) = $this->extract_js($buffer);
				$buffer = $this->inject_js($buffer, $js_locations);
				$buffer = $this->inject_conditionals($buffer, $conditionals);
			}

			// minify CSS (make sure to exclude CSS conditionals)
			if($this->options['minify_css']) {
				list($buffer, $conditionals) = $this->extract_conditionals($buffer);
				list($buffer, $css_locations) = $this->extract_css($buffer);
				$buffer = $this->inject_css($buffer, $css_locations);
				$buffer = $this->inject_conditionals($buffer, $conditionals);
			}

			// get rid of empty lines
			$buffer = preg_replace('/\s*(\r?\n)(\r?\n)*/', '$1', $buffer);

			// minify HTML //maybe someday remove this?
			if(@$this->options['enable_html']) {
				if(!class_exists('Minify_HTML')) {
					require_once(MAPI_DIR_PATH . 'lib/min/lib/Minify/HTML.php');
				}
				$buffer = Minify_HTML::minify($buffer);
			}

			$buffer = apply_filters('mapi_minify_content', $buffer); // allow plugins to modify buffer

			return $buffer;
		}

		/**
		 *
		 */
		public function post_content() {
			// sanity checking
			if($this->buffer_started) {
				ob_end_flush();
			}
		}
	} // class mapi_minify
endif;

$mapi_minify = new mapi_minify();
