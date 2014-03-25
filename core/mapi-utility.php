<?php
/**
 * Mindshare Theme API UTILITY FUNCTIONS
 *
 * @author     Mindshare Studios, Inc.
 * @copyright  Copyright (c) 2014
 * @link       http://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mcms-utility.php
 *
 * Gotta love utility functions!
 */

/**
 * Evaluates natural language strings to boolean equivalent
 *
 * All values defined as TRUE will return TRUE, anything else is FALSE.
 * Boolean values will be passed through.
 *
 * @since  0.6.7
 *
 * @param string $string        The natural language value
 * @param array  $true_synonyms A list strings that are TRUE
 *
 * @return boolean The boolean value of the provided text
 **/
function mapi_is_true($string, $true_synonyms = array('yes', 'y', 'true', '1', 'on', 'open', 'affirmative', '+', 'positive')) {
	if(is_array($string)) {
		return FALSE;
	}
	if(is_bool($string)) {
		return $string;
	}
	return in_array(strtolower(trim($string)), $true_synonyms);
}

/**
 *
 * Override the default [...] in the_excerpt.
 *
 * @param string $more
 *
 * @return string
 */
function mapi_excerpt_more($more = NULL) {
	if(empty($more)) {
		$more = __('Read more...', 'mapi');
	}
	$options = get_option(MAPI_OPTIONS);
	if(!empty($options['excerpt_more_txt'])) {
		$more = $options['excerpt_more_txt'];
	}
	return apply_filters('mapi_excerpt_more', '&nbsp;<a class="mapi excerpt-more" title="'.the_title_attribute('echo=0').'" href="'.get_permalink(get_the_ID()).'">'.$more.'</a>');
}

/**
 *
 * Cleanly limit a string to a set number of words.
 *
 * @param $string
 * @param $length
 *
 * @return string
 */
function mapi_word_limit($string, $length) {
	return implode(' ', array_slice(explode(' ', $string), 0, $length));
	//return implode(' ',array_slice(str_word_count($string,1),0,$length));
}

/**
 *
 * Gets the current URL.
 *
 * @return string
 */
function mapi_get_url() {
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")).$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

/**
 *
 * Checks to see if $text is in the current URL.
 *
 * @param $text
 *
 * @return bool
 */
function mapi_in_url($text) {
	if(stristr(mapi_get_url(), $text)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 *
 * Converts a server path to a URL.
 *
 * @param $file
 *
 * @return mixed
 */
function mapi_path_to_url($file) {
	return str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
}

/**
 * Detects the users browser using the User Agent string.
 *
 * @return array    Returns an associative array containing the 'user_agent' string, browser 'name', browser 'version', OS 'platform'
 *
 */

function mapi_browser_from_ua() {
	// based on http://www.php.net/manual/en/function.get-browser.php#101125

	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$browser_name = 'Unknown';
	$platform = 'Unknown';

	// First get the platform
	if(preg_match('/linux/i', $user_agent)) {
		$platform = 'Linux';
	} elseif(preg_match('/macintosh|mac os x/i', $user_agent)) {
		$platform = 'Mac';
	} elseif(preg_match('/windows|win32/i', $user_agent)) {
		$platform = 'Windows';
	}

	// Next get the name of the user agent yes seperately and for good reason
	if(preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
		$browser_name = 'Internet Explorer';
		$browser_name_short = "MSIE";
	} elseif(preg_match('/Firefox/i', $user_agent)) {
		$browser_name = 'Mozilla Firefox';
		$browser_name_short = "Firefox";
	} elseif(preg_match('/Chrome/i', $user_agent)) {
		$browser_name = 'Google Chrome';
		$browser_name_short = "Chrome";
	} elseif(preg_match('/Safari/i', $user_agent)) {
		$browser_name = 'Apple Safari';
		$browser_name_short = "Safari";
	} elseif(preg_match('/Opera/i', $user_agent)) {
		$browser_name = 'Opera';
		$browser_name_short = "Opera";
	} elseif(preg_match('/Netscape/i', $user_agent)) {
		$browser_name = 'Netscape';
		$browser_name_short = "Netscape";
	}

	// get the correct version number
	/** @noinspection PhpUndefinedVariableInspection */
	$known = array('Version', $browser_name_short, 'other');
	$pattern = '#(?<browser>'.join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if(!preg_match_all($pattern, $user_agent, $matches)) {
		// We have no matching number just continue
	}

	// see how many we have
	$i = count($matches['browser']);
	if($i != 1) {
		// We will have two since we are not using 'other' argument yet
		// See if version is before or after the name
		if(strripos($user_agent, "Version") < strripos($user_agent, $browser_name_short)) {
			$version = $matches['version'][0];
		} else {
			$version = $matches['version'][1];
		}
	} else {
		$version = $matches['version'][0];
	}

	// check if we have a number
	if($version == NULL || $version == "") {
		$version = "?";
	}

	return array(
		'user_agent' => $user_agent,
		'name'       => $browser_name,
		'version'    => $version,
		'platform'   => $platform,
		'pattern'    => $pattern
	);
}

/**
 *
 * Generates a CSS class name based on detected browser, depends on PHP Browser Detection plugin. Gracefully degrades
 * if the plugin isn't available.
 *
 * @param bool $show_major_version
 * @param bool $show_minor_version
 *
 * @return string
 */
function mapi_broswer_class($show_major_version = FALSE, $show_minor_version = FALSE) {
	if(function_exists('php_browser_info')) {
		$browser = php_browser_info();

		$class = $browser['browser'];
		if(!empty($browser['majorver']) && $show_major_version) {
			$class .= '-'.$browser['majorver'];
		}
		if(!empty($browser['minorver']) && $show_minor_version) {
			$class .= '-'.$browser['minorver'];
		}
		$class = strtolower($class);
	} else {
		// fallback on the builtin WP globals if the plugin is not found
		$class = implode(' ', mapi_add_body_classes());
	}
	return $class;
}

/**
 *
 * Uses builtin WP global variables by pushing them into the body_class array of CSS classes.
 *
 * @param array $classes
 *
 * @return array
 */
function mapi_add_body_classes($classes = array()) {
	global $is_lynx, $is_gecko, $is_winIE, $is_macIE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if($is_lynx) {
		$classes[] = 'lynx';
	}
	if($is_gecko) {
		$classes[] = 'gecko';
	}
	if($is_winIE) {
		$classes[] = 'win-ie';
	}
	if($is_macIE) {
		$classes[] = 'mac-ie';
	}
	if($is_winIE || $is_macIE) {
		$classes[] = 'ie';
	}
	if($is_opera) {
		$classes[] = 'opera';
	}
	if($is_NS4) {
		$classes[] = 'ns4';
	} // yeah right
	if($is_safari) {
		$classes[] = 'safari';
	}
	if($is_chrome) {
		$classes[] = 'chrome';
	}
	if($is_iphone) {
		$classes[] = 'iphone';
	}
	return $classes;
}

/**
 *
 * Provides an additional mechanism for outputting errors to the browser or the JavaScript console.
 *
 * @param $args array
 *
 * @return string
 *
 */
function mapi_error($args) {
	global $MAPI_ERRORS;
	if(!is_array($args)) {
		$msg = 'Fatal error: mapi_error must be passed an array.';
	}
	$defaults = array(
		'msg'  => 'An unspecified error occurred',
		'echo' => FALSE,
		'die'  => FALSE
	);
	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	$debug = debug_backtrace();
	$i = (empty($debug[1]["function"])) ? 0 : 1;

	$str = '';

	/** @noinspection PhpUndefinedVariableInspection */
	if($echo) {
		$str .= '<div id="message" class="error"><p><strong>';
	}
	$str .= "[".$debug[$i]["function"]."]";
	if($echo) {
		$str .= '</strong>';
	}

	/** @noinspection PhpUndefinedVariableInspection */
	@$str .= ": ".$msg." in ".$debug[$i]["file"]." on line ".$debug[$i]["line"];
	if($echo) {
		$str .= '</p></div>';
	}

	if($echo) {

		/** @noinspection PhpUndefinedVariableInspection */
		if($die) {
			die($str);
		} else {
			echo($str);
		}
	} else {
		$MAPI_ERRORS[] = $str; // add the error to the global array for later output
		//return $str;
	}
}

/**
 *
 * Outputs registered error message to the JavaScript console in wp_footer.
 *
 */
function mapi_error_console() {
	global $MAPI_ERRORS;
	if(count($MAPI_ERRORS) != 0) {
		echo '<script type="text/javascript">';
		foreach($MAPI_ERRORS as $error) {
			echo 'console.log("'.$error.'");';
		}
		echo '</script>';
	}
}

/**
 * Used for debugging, uses var_dump to output a variable wrapped in a pre tag.
 * Optionally, will stop PHP execution if $die is set to TRUE. Does nothing iif the current
 * user does not have the right $capability (defaults to 'manage_options').
 *
 * @param mixed  $var
 * @param bool   $die
 * @param string $capability
 */
function mapi_var_dump($var = NULL, $die = FALSE, $capability = 'manage_options') {
	if(current_user_can($capability)) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		if($die) {
			die;
		}
	}
}

/**
 * Useful for debugging.
 *
 */
function mapi_poop() {
	mapi_var_dump('Poop', TRUE);
}

/**
 * Just checking if @bryce is asleep. Or wrong.
 *
 */
function mapi_bryce() {
	mapi_var_dump(base64_decode('QnJ5Y2UgaXMgd3Jvbmch'), TRUE);
}

/**
 *
 *
 * Returns an array of file URLs for a given directory filterable by file extension(s).
 *
 * @todo make recursive (optionally)
 *
 * @param null   $dir
 * @param string $exts
 *
 * @return array
 */
function mapi_file_array_dir($dir = NULL, $exts = 'jpg,jpeg,png,gif') {
	if(!isset($dir)) {
		$dir = './';
		//mapi_error(array('msg' => $dir));
	}
	if(file_exists($dir)) {
		$files = array();
		$i = -1;
		$handle = opendir($dir);
		$exts = explode(',', strtolower($exts));
		while(FALSE !== ($file = readdir($handle))) {
			foreach($exts as $ext) {
				if(preg_match('/\.'.$ext.'$/i', $file, $test)) {
					$files[] = mapi_path_to_url($dir.$file);
					++$i;
				}
			}
		}
		closedir($handle);
		return $files;
	} else {
		return FALSE;
	}
}

/**
 *
 * Converts all numeric values in an associative array into integers.
 *
 * @param $value
 *
 * @return int
 */
function mapi_intval_array($value) {
	if(is_numeric($value)) {
		return intval($value);
	} else {
		return $value;
	}
}

/**
 *
 * Sanitizes an associative array removes keys with empty values and converts all numeric string values into integers.
 *
 * @param array $array The input array.
 *
 * @return array $array The sanitized array.
 */
function mapi_sanitize_array($array) {
	$array = @array_filter($array, 'strlen'); // remove NULLs
	$array = array_map('mapi_intval_array', $array); // cast numeric strings as integers
	return $array;
}

/**
 *
 * Preloads given assets in the background.
 *
 * @param null   $dir
 * @param string $exts
 */
function mapi_preload($dir = NULL, $exts = 'jpg,jpeg,png,gif') {
	$preload_var = 'preload_'.rand(); // create a random var name for us in JS
	$preload_arr = mapi_file_array_dir(trailingslashit($dir), $exts);
	?>
	<script type="text/javascript">
		if(typeof jQuery != 'undefined') {
			var <?php echo $preload_var?> = <?php echo json_encode($preload_arr); ?>;
			jQuery(<?php echo $preload_var; ?>).each(function() {
				jQuery('<img/>')[0].src = this;
				//console.log(this + ' loaded');
			});
		}
	</script>
<?php
}

/**
 *
 * Loads JavaScript to automatically highlight search terms on WordPress search results pages.
 *
 *
 */
function mapi_search_highlighter_js() {
	wp_deregister_script('mapi_search_highlighter_js');
	wp_register_script('mapi_search_highlighter_js', plugins_url('js/search-highlighter.js', dirname(__FILE__)));
	wp_enqueue_script('mapi_search_highlighter_js');
}

/**
 *
 *  Loads jQuery ReplaceText plguin.
 *
 */
function mapi_replacetext_js() {
	wp_deregister_script('mapi_replacetext_js');
	wp_register_script('mapi_replacetext_js', plugins_url('js/jquery.replacetext.js', dirname(__FILE__)));
	wp_enqueue_script('mapi_replacetext_js');
}

/**
 *
 * Prevents JavaScript errors if the console object is not defined.
 *
 * Based on code from Twitter.
 *
 */
function mapi_fix_console() {
	wp_deregister_script('mapi_fix_console_js');
	wp_register_script('mapi_fix_console_js', plugins_url('js/mapi-fix-console.js', dirname(__FILE__)));
	wp_enqueue_script('mapi_fix_console_js');
}

/**
 *
 * Helper function to get rid of inline CSS styling WordPress outputs for the recent comments widget.
 *
 */
function mapi_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

/**
 *
 * Outputs an HTML comment to disable HTML compression
 * (until this function is called again). Only relevant
 * when HTML compression is enabled in Developer Settings >
 * Performance Tuning > Minify HTML.
 *
 * @param bool $echo Whether to echo or return the HTML comment. Default is TRUE.
 *
 * @return string
 */
function mapi_toggle_html_compression($echo = TRUE) {
	$comment = '<!--compression-none-->';
	if($echo) {
		echo $comment;
	} else {
		return $comment;
	}
}

/**
 *
 * Gives an alert to users of older version of IE that they should update their browser.
 *
 */
function mapi_ie_warning() {
	$load_ieupdate = mapi_get_option('load_ieupdate');
	if(!empty($load_ieupdate['load_ieupdate_version_txt'])) {
		mapi_toggle_html_compression();
		?>
		<!--[if lt IE <?php echo $load_ieupdate['load_ieupdate_version_txt']; ?>]>
		<script type="text/javascript">
			var IE6UPDATE_OPTIONS = {
				icons_path: "<?php echo plugins_url('lib/ie6update/images/', dirname(__FILE__)); ?>",
				message:    "Internet Explorer is missing updates required to properly view this website. Click here to update your browser... "
			}
		</script>
		<script type="text/javascript" src="<?php echo plugins_url('lib/ie6update/ie6update.js', dirname(__FILE__)); ?>"></script>
		<![endif]-->
		<?php
		mapi_toggle_html_compression(); // @todo test w/o this
	}
}

/**
 *
 * Retrieve an option from the Theme API options array.
 *
 * @param null $name
 *
 * @return string
 */
function mapi_get_option($name = NULL) {
	if(empty($name)) {
		return mapi_error(array('msg' => 'Option name is NULL', 'echo' => FALSE, 'die' => FALSE));
	}

	$options = get_option(MAPI_OPTIONS);
	if($options && array_key_exists($name, $options)) {
		return $options[$name];
	} else {
		return mapi_error(array('msg' => 'get_option returned FALSE', 'echo' => FALSE, 'die' => FALSE));
	}
}

/**
 * Sets a Mindshare Theme API option in the database.
 *
 * @param $name
 * @param $value
 *
 * @return bool
 */
function mapi_update_option($name, $value) {
	$name = trim($name);
	if(empty($name)) {
		return FALSE;
	}

	$options = get_option(MAPI_OPTIONS);
	if($options) {
		$options[$name] = $value;
		return update_option(MAPI_OPTIONS, $options);
	}
}

/**
 * Add or sets a Mindshare Theme API option in the database.
 *
 * @param $name
 * @param $value
 *
 * @return bool
 */
function mapi_add_option($name, $value) {
	return mapi_update_option($name, $value);
}

/**
 * @param $name
 *
 * @return bool
 */
function mapi_delete_option($name) {
	$name = trim($name);
	if(empty($name)) {
		return FALSE;
	}

	$options = get_option(MAPI_OPTIONS);
	if($options) {
		$options[$name] = '';
		return update_option(MAPI_OPTIONS, $options);
	}
}

/**
 *
 * Echoes a given option from the Theme API options array.
 *
 * @param string $name
 */
function mapi_option($name = NULL) {
	echo mapi_get_option($name);
}

/**
 *
 * Unloads jQuery obviously.
 *
 */
function mapi_unload_jquery() {
	if(!is_admin()) {
		wp_deregister_script('jquery');
		wp_dequeue_script('jquery');
	}
}

/**
 *
 * Loads the version of jquery registered with WordPress.
 *
 */
function mapi_load_jquery() {
	if(!is_admin()) {
		wp_enqueue_script('jquery');
	}
}

/**
 *
 * Loads Bootstrap JS
 *
 */
function mapi_load_bootstrap() {
	if(!is_admin()) {
		wp_deregister_script('bootstrap');
		wp_register_script('bootstrap', plugins_url('lib/bootstrap/js/bootstrap.min.js', dirname(__FILE__)));
		wp_enqueue_script('bootstrap');
	}
}

/**
 *
 * Loads Bootstrap CSS
 *
 */
function mapi_load_bootstrap_css() {
	if(!is_admin()) {
		wp_deregister_style('bootstrap');
		wp_register_style('bootstrap', plugins_url('lib/bootstrap/css/bootstrap.min.css', dirname(__FILE__)));
		wp_enqueue_style('bootstrap');
	}
}

/**
 *
 * Loads Font Awesome
 *
 */
function mapi_load_font_awesome() {
	if(!is_admin()) {
		wp_deregister_style('font-awesome');
		wp_register_style('font-awesome', plugins_url('lib/font-awesome/css/font-awesome.min.css', dirname(__FILE__)));
		wp_enqueue_style('font-awesome');
	}
}

/**
 *
 * Loads Modernizr
 *
 */
function mapi_load_modernizr() {
	if(!is_admin()) {
		wp_deregister_script('modernizr');
		wp_register_script('modernizr', plugins_url('lib/modernizr/modernizr-latest.js', dirname(__FILE__)));
		wp_enqueue_script('modernizr');
	}
}

/**
 *
 * Loads Backbone
 *
 */
function mapi_load_backbone() {
	if(!is_admin()) {
		wp_enqueue_script('backbone');
	}
}

/**
 *
 * Loads Underscore
 *
 */
function mapi_load_underscore() {
	if(!is_admin()) {
		wp_enqueue_script('underscore');
	}
}

/**
 *
 * Loads Leaflet
 *
 */
function mapi_load_leaflet() {
	if(!is_admin()) {
		wp_deregister_style('leaflet');
		wp_register_style('leaflet', plugins_url('lib/leaflet/leaflet.css', dirname(__FILE__)));
		wp_enqueue_style('leaflet');

		wp_deregister_script('leaflet');
		wp_register_script('leaflet', plugins_url('lib/leaflet/leaflet.js', dirname(__FILE__)));
		wp_enqueue_script('leaflet');
	}
}


/**
 *
 * Loads Retina
 *
 */
function mapi_load_retina() {
	if(!is_admin()) {
		wp_deregister_script('retina');
		wp_register_script('retina', plugins_url('lib/retina/js/retina-1.1.0.min.js', dirname(__FILE__)));
		wp_enqueue_script('retina');
	}
}

/**
 *
 * Loads SWFObject
 *
 */
function mapi_load_swfobject() {
	if(!is_admin()) {
		wp_enqueue_script('swfobject');
	}
}

/**
 *
 * Loads Masonry
 *
 */
function mapi_load_masonry() {
	if(!is_admin()) {
		wp_enqueue_script('jquery-masonry');
	}
}

/**
 *
 * Loads Isotope
 *
 */
function mapi_load_isotope() {
	if(!is_admin()) {
		wp_deregister_script('isotope');
		wp_register_script('isotope', plugins_url('lib/isotope/jquery.isotope.min.js', dirname(__FILE__)));
		wp_enqueue_script('isotope');
	}
}

/**
 *
 * Loads Superfish
 *
 */
function mapi_load_superfish() {
	if(!is_admin()) {
		wp_deregister_script('superfish');
		wp_register_script('superfish', plugins_url('lib/superfish/superfish.js', dirname(__FILE__)));
		wp_enqueue_script('superfish');
	}
}

/**
 *
 * Loads pickadate
 *
 */
function mapi_load_pickadate() {
	if(!is_admin()) {
		wp_deregister_script('pickadate');
		wp_register_script('pickadate', plugins_url('lib/pickadate/picker.js', dirname(__FILE__)));
		wp_enqueue_script('pickadate');

		wp_deregister_script('pickadate-time');
		wp_register_script('pickadate-time', plugins_url('lib/pickadate/picker.time.js', dirname(__FILE__)));
		wp_enqueue_script('pickadate-time');

		wp_deregister_script('pickadate-date');
		wp_register_script('pickadate-date', plugins_url('lib/pickadate/picker.date.js', dirname(__FILE__)));
		wp_enqueue_script('pickadate-date');

		wp_deregister_script('pickadate-legacy');
		wp_register_script('pickadate-legacy', plugins_url('lib/pickadate/legacy.js', dirname(__FILE__)));
		wp_enqueue_script('pickadate-legacy');
	}
}

/**
 *
 * Loads Lettering
 *
 */
function mapi_load_lettering() {
	if(!is_admin()) {
		wp_deregister_script('lettering');
		wp_register_script('lettering', plugins_url('lib/lettering/jquery.lettering.js', dirname(__FILE__)));
		wp_enqueue_script('lettering');
	}
}

/**
 *
 * Loads FitVids
 *
 */
function mapi_load_fitvids() {
	if(!is_admin()) {
		wp_deregister_script('fitvids');
		wp_register_script('fitvids', plugins_url('lib/fitvids/jquery.fitvids.js', dirname(__FILE__)));
		wp_enqueue_script('fitvids');
	}
}

/**
 *
 * Loads FlexSlider
 *
 */
function mapi_load_flexslider() {
	if(!is_admin()) {
		wp_deregister_script('flexslider');
		wp_register_script('flexslider', plugins_url('lib/flexslider/jquery.flexslider-min.js', dirname(__FILE__)));
		wp_enqueue_script('flexslider');
	}
}

/**
 *
 * Loads FitText
 *
 */
function mapi_load_fittext() {
	if(!is_admin()) {
		wp_deregister_script('fittext');
		wp_register_script('fittext', plugins_url('lib/fittext/jquery.fittext.js', dirname(__FILE__)));
		wp_enqueue_script('fittext');
	}
}

/**
 *
 * Loads easyListSplitter
 *
 */
function mapi_load_easylistsplitter() {
	if(!is_admin()) {
		wp_deregister_script('easylistsplitter');
		wp_register_script('easylistsplitter', plugins_url('lib/easylistsplitter/jquery.easyListSplitter.js', dirname(__FILE__)));
		wp_enqueue_script('easylistsplitter');
	}
}

/**
 *
 * Loads TinySort
 *
 */
function mapi_load_tinysort() {
	if(!is_admin()) {
		wp_deregister_script('tinysort');
		wp_register_script('tinysort', plugins_url('lib/tinysort/jquery.tinysort.js', dirname(__FILE__)));
		wp_enqueue_script('tinysort');
	}
}

/**
 *
 * Loads jQuery BBQ
 *
 */
function mapi_load_bbq() {
	if(!is_admin()) {
		wp_deregister_script('bbq');
		wp_register_script('bbq', plugins_url('lib/jquery-bbq/jquery.ba-bbq.min.js', dirname(__FILE__)));
		wp_enqueue_script('bbq');
	}
}

/**
 *
 * Loads jQuery TipTip
 *
 */
function mapi_load_tiptip() {
	if(!is_admin()) {
		wp_deregister_script('tiptip');
		wp_register_script('tiptip', plugins_url('lib/tiptip/jquery.tipTip.minified.js', dirname(__FILE__)));
		wp_enqueue_script('tiptip');
	}
}

/**
 * Quickly dequeue all styles that are currently enqueued by WordPress.
 *
 * Usage: add_action('wp_print_scripts', 'mapi_remove_all_scripts', 100);
 *
 */
function mapi_remove_all_scripts() {
	global $wp_scripts;
	$wp_scripts->queue = array();
}

/**
 * Quickly dequeue all styles that are currently enqueued by WordPress.
 *
 * Usage: add_action('wp_print_styles', 'mapi_remove_all_styles', 100);
 *
 */
function mapi_remove_all_styles() {
	global $wp_styles;
	$wp_styles->queue = array();
}

/**
 *
 * Add JavaScript to break out of any HTML frames.
 *
 */
function mapi_break_frames() {
	?>
	<script type="text/javascript">
		//console.log(self.location.toString());
		if(top.location.toString() != self.location.toString()) {
			if(top.location.toString().indexOf('wp-admin/customize.php') == -1) {
				if(top.location != self.location) {
					top.location = self.location.href;
				}
			}
		}
	</script><?php
}

/**
 * Outputs an edit post link with built in support for custom post types. Used in place of the standard WordPress function edit_post_link()
 *
 */

function mapi_edit_link() {
	global $post;
	$label = get_post_type_object(get_post_type($post));
	$label = ucwords($label->labels->singular_name);
	if(!empty($label)) {
		return apply_filters('mapi_edit_link', edit_post_link('Edit '.$label, '<p class="mapi edit-link btn btn-xs btn-default">', '</p>'));
	} else {
		return apply_filters('mapi_edit_link', edit_post_link('Edit Page', '<p class="mapi edit-link btn btn-xs btn-default">', '</p>'));
	}
}

/**
 *
 * Automatically sets external (offsite) links to open in a new window or tab.
 *
 */
function mapi_external_links() {
	?>
	<script type="text/javascript">jQuery(document).ready(function() {
			jQuery("a[href^='http']:not([href*='" + document.domain + "'])").each(function() {
				jQuery(this).attr("target", "_blank");
			});
		});</script><?php
}

/**
 *
 * Helper function to set make some WordPress config options available in JavaScript.
 *
 */
function mapi_set_contstants_js() {
	?>
	<script type="text/javascript">var plugins_url = '<?php echo plugins_url(); ?>';
		var MAPI_PLUGIN_SLUG = '<?php echo MAPI_PLUGIN_SLUG; ?>';
		var MAPI_PLUGIN_NAME = '<?php echo MAPI_PLUGIN_NAME; ?>';</script><?php
}


/**
 *
 * Removes version numbers from script requests.
 *
 */
function mapi_remove_version_scripts() {
	global $wp_scripts;
	if(!is_a($wp_scripts, 'WP_Scripts')) {
		return;
	}
	foreach($wp_scripts->registered as $handle => $script) {
		$wp_scripts->registered[$handle]->ver = NULL;
	}
}

/**
 *
 * Removes version numbers from style requests.
 */
function mapi_remove_version_styles() {
	global $wp_styles;
	if(!is_a($wp_styles, 'WP_Styles')) {
		return;
	}
	foreach($wp_styles->registered as $handle => $style) {
		$wp_styles->registered[$handle]->ver = NULL;
	}
}

/**
 *
 * Remove nearly all URLs from a given string.
 *
 * @param string $string
 *
 * @return string
 */
function mapi_strip_url($string) {
	return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
}

/**
 *
 * Dequeues CSS from WordPress.
 *
 */
function mapi_dequeue_css() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['dequeue_styles_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['dequeue_styles_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['dequeue_styles_txt']);
	}
	foreach($arr as $item) {
		wp_dequeue_style($item);
	}
}

/**
 *
 * Deregisters CSS from WordPress.
 *
 */
function mapi_deregister_css() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['deregister_styles_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['deregister_styles_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['deregister_styles_txt']);
	}
	foreach($arr as $item) {
		wp_deregister_style($item);
	}
}

/**
 *
 * Dequeues JS from WordPress.
 *
 */
function mapi_dequeue_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['dequeue_scripts_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['dequeue_scripts_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['dequeue_scripts_txt']);
	}
	foreach($arr as $item) {
		wp_dequeue_script($item);
	}
}

/**
 *
 * Deregisters JS from WordPress.
 *
 */
function mapi_deregister_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['deregister_scripts_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['deregister_scripts_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['deregister_scripts_txt']);
	}
	foreach($arr as $item) {
		wp_deregister_script($item);
	}
}

/**
 *
 * Enqueues JS to WordPress.
 *
 */
function mapi_enqueue_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['enqueue_scripts_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['enqueue_scripts_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['enqueue_scripts_txt']);
	}
	foreach($arr as $item) {
		wp_enqueue_script($item);
	}
}

/**
 *
 * Registers JS to WordPress.
 *
 * (not currently implemented)
 *
 */
/*function mapi_register_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if(strpos($enable_adv_speed_options['register_scripts_txt'], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options['register_scripts_txt']);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options['register_scripts_txt']);
	}
	foreach($arr as $item) {
		//wp_register_script($item); // not currently supported, maybe finish for a future release
	}
}*/

/**
 *
 * Outputs Google Analytics code.
 *
 * @param null $ga_id                  (string)
 * @param null $allow_multiple_domains (string)
 * @param null $enhanced_link_attribution
 * @param null $universal_analytics
 *
 * @return string
 */
function mapi_analytics($ga_id = NULL, $allow_multiple_domains = NULL, $enhanced_link_attribution = NULL, $universal_analytics = NULL) {

	if(empty($ga_id)) {
		// no GA web property was passed, so grab the one from the API options page
		$ga_id = mapi_get_option('ga_acct_txt');
		if(empty($ga_id)) {
			mapi_error(array('msg' => 'No Google Analytics Web Property ID was found.', 'echo' => FALSE, 'die' => FALSE));
		}
	}

	if(empty($allow_multiple_domains)) {
		// allow_multiple_domains flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		$allow_multiple_domains = @$ga_adv_options['multiple_domains'];
	}
	if(empty($enhanced_link_attribution)) {
		// enhanced_link_attribution flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		$enhanced_link_attribution = @$ga_adv_options['enhanced_link_attribution'];
	}
	if(empty($universal_analytics)) {
		// allow_multiple_domains flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		$universal_analytics = @$ga_adv_options['universal_analytics'];
	}
	// get the base of the site domain (removing any subdomains, etc)
	$domain = mapi_extract_domain(home_url());

	$ga_code = "<script type=\"text/javascript\">";

	if(mapi_is_true($universal_analytics)) {
		$ga_code .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
		$ga_code .= "ga('create', '".$ga_id."', '".$domain."');";
		$ga_code .= "ga('send', 'pageview');";
	} else {

		$ga_code .= "var _gaq = _gaq || [];\n";
		if(mapi_is_true($enhanced_link_attribution)) {
			$ga_code .= "var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';\n";
			$ga_code .= "_gaq.push(['_require', 'inpage_linkid', pluginUrl]);\n";
		}
		$ga_code .= "\t_gaq.push(['_setAccount', '".$ga_id."']);\n\t_gaq.push(['_setDomainName', '".$domain."']);\n";
		if(mapi_is_true($allow_multiple_domains)) {
			$ga_code .= "\t_gaq.push(['_setAllowLinker', true]);\n";
		}
		$ga_code .= "\t_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();";
	}
	$ga_code .= "</script>";
	echo $ga_code;
}

/**
 *
 * Get the base TLD of a given domain (removing any subdomains, etc.)
 * Uses the Public Suffixes List
 *
 * @see https://github.com/Synchro/regdom-php
 *
 * @param $url (string)
 *
 * @return mixed|null|string
 */
function mapi_extract_domain($url) {
	$domain = parse_url($url);
	$domain = $domain['host'];
	require_once(MAPI_DIR_PATH.'lib/regdom-php/effectiveTLDs.inc.php');
	$tldTree = require_once(MAPI_DIR_PATH.'lib/regdom-php/regDomain.inc.php');
	$domain = getRegisteredDomain($domain, $tldTree);
	return $domain;
}

/**
 * Takes any phone number and returns a URI formatted version (for click to call links).
 *
 * @param $prefix (string) A prefix to add before $tel. Defaults to "+1".
 * @param $tel    (string) A phone number.
 *
 * @return string
 */
function mapi_tel_uri($tel, $prefix = "+1") {
	$tel = mapi_strip_nonnumeric($tel);
	return apply_filters('mapi_tel_uri', $prefix.$tel);
}

/**
 *
 * Removes all non-numeric characters from a string.
 *
 * @param $str
 *
 * @return mixed
 */
function mapi_strip_nonnumeric($str) {
	return preg_replace('/[^\d]/', '', $str);
}

/**
 *
 * Returns a nicely formatted US phone number e.g. (555) 555-5555
 *
 * @param $tel
 *
 * @return mixed
 */
function mapi_phone_format($tel) {
	$tel = mapi_strip_nonnumeric($tel);
	return apply_filters('mapi_phone_format', preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $tel));
}

/**
 * Money formatter
 *
 * Turns a number into a USD formatted string. Example: 1200.25 becomes $1,200.25.
 *
 */

function mapi_money_format($number) {
	setlocale(LC_MONETARY, 'en_US');
	return money_format('%(#10n', $number);
}

/**
 * Disable Quick Edit on admin screens.
 *
 * @usage:
 *       add_filter('post_row_actions', 'mapi_remove_quick_edit', 10, 1);
 *
 * @param $actions
 *
 * @return mixed
 */
function mapi_remove_quick_edit($actions) {
	unset($actions['inline hide-if-no-js']);
	return $actions;
}

/**
 * Lists all hooked functions (optionally filterable by a given tag)
 *
 * @link http://www.wprecipes.com/list-all-hooked-wordpress-functions
 *
 * @param bool $tag A tag referencing a hook or filter.
 */
function mapi_list_hooked_functions($tag = FALSE) {
	global $wp_filter;
	if($tag) {
		$hook[$tag] = $wp_filter[$tag];
		if(!is_array($hook[$tag])) {
			mapi_error(array('msg' => "Nothing found for '$tag' hook", 'echo' => TRUE));
			return;
		}
	} else {
		$hook = $wp_filter;
		ksort($hook);
	}
	echo '<pre>';
	foreach($hook as $tag => $priority) {
		echo "<br /><strong>$tag</strong><br />";
		ksort($priority);
		foreach($priority as $priority => $function) {
			echo $priority;
			foreach($function as $name => $properties) {
				echo "\t$name<br />";
			}
		}
	}
	echo '</pre>';
	return;
}
