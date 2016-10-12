<?php
/**
 * Mindshare Theme API UTILITY FUNCTIONS
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mcms-utility.php
 *             Gotta love utility functions!
 */

/**
 * Evaluates natural language strings to boolean equivalent
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
	if (is_array($string)) {
		return FALSE;
	}
	if (is_bool($string)) {
		return $string;
	}

	return in_array(strtolower(trim($string)), $true_synonyms);
}

/**
 * Override the default [...] in the_excerpt.
 *
 * @param string $more
 *
 * @return string
 */
function mapi_excerpt_more($more = NULL) {
	if (empty($more)) {
		$more = __('Read more...', 'mapi');
	}
	$options = get_option(MAPI_OPTIONS);
	if (!empty($options[ 'excerpt_more_txt' ])) {
		$more = apply_filters('mapi_excerpt_more_text', $options[ 'excerpt_more_txt' ]);
	}

	return apply_filters('mapi_excerpt_more', '&nbsp;<a class="mapi excerpt-more" title="' . the_title_attribute('echo=0') . '" href="' . get_permalink(get_the_ID()) . '">' . $more . '</a>');
}

/**
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
 * Gets the current URL.
 *
 * @return string
 */
function mapi_get_url() {
	$s = empty($_SERVER[ "HTTPS" ]) ? '' : ($_SERVER[ "HTTPS" ] == "on") ? "s" : "";
	$protocol = substr(strtolower($_SERVER[ "SERVER_PROTOCOL" ]), 0, strpos(strtolower($_SERVER[ "SERVER_PROTOCOL" ]), "/")) . $s;
	$port = ($_SERVER[ "SERVER_PORT" ] == "80") ? "" : (":" . $_SERVER[ "SERVER_PORT" ]);

	return $protocol . "://" . $_SERVER[ 'SERVER_NAME' ] . $port . $_SERVER[ 'REQUEST_URI' ];
}

/**
 * Checks to see if $text is in the current URL.
 *
 * @param $text
 *
 * @return bool
 */
function mapi_in_url($text) {
	if (stristr(mapi_get_url(), $text)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Converts a server path to a URL.
 *
 * @param $file
 *
 * @return mixed
 */
function mapi_path_to_url($file) {
	return str_replace($_SERVER[ 'DOCUMENT_ROOT' ], '', $file);
}

/**
 * Detects the users browser using the User Agent string.
 *
 * @return array    Returns an associative array containing the 'user_agent' string, browser 'name', browser 'version', OS 'platform'
 */

function mapi_browser_from_ua() {
	// based on http://www.php.net/manual/en/function.get-browser.php#101125

	if (isset($_SERVER) && array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
		$user_agent = $_SERVER[ 'HTTP_USER_AGENT' ];
	} else {
		return FALSE;
	}

	$platform = 'Unknown';

	// First get the platform
	if (preg_match('/linux/i', $user_agent)) {
		$platform = 'Linux';
	} elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
		$platform = 'Mac';
	} elseif (preg_match('/windows|win32/i', $user_agent)) {
		$platform = 'Windows';
	}

	// Next get the name of the user agent yes separately and for good reason
	if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
		$browser_name = 'Internet Explorer';
		$browser_name_short = "MSIE";
	} elseif (preg_match('/Firefox/i', $user_agent)) {
		$browser_name = 'Mozilla Firefox';
		$browser_name_short = "Firefox";
	} elseif (preg_match('/Chrome/i', $user_agent)) {
		$browser_name = 'Google Chrome';
		$browser_name_short = "Chrome";
	} elseif (preg_match('/Safari/i', $user_agent)) {
		$browser_name = 'Apple Safari';
		$browser_name_short = "Safari";
	} elseif (preg_match('/Opera/i', $user_agent)) {
		$browser_name = 'Opera';
		$browser_name_short = "Opera";
	} elseif (preg_match('/Netscape/i', $user_agent)) {
		$browser_name = 'Netscape';
		$browser_name_short = "Netscape";
	} else {
		$browser_name = '';
		$browser_name_short = "";
	}

	// get the correct version number
	$known = array('Version', $browser_name_short, 'other');
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (@!preg_match_all($pattern, $user_agent, $matches)) {
		// We have no matching number just continue
	}

	// see how many we have
	$i = count($matches[ 'browser' ]);
	if ($i != 1) {
		// We will have two since we are not using 'other' argument yet
		// See if version is before or after the name
		if (strripos($user_agent, "Version") < strripos($user_agent, $browser_name_short)) {
			$version = @$matches[ 'version' ][ 0 ];
		} else {
			$version = @$matches[ 'version' ][ 1 ];
		}
	} else {
		$version = @$matches[ 'version' ][ 0 ];
	}

	// check if we have a number
	if ($version == NULL || $version == "") {
		$version = "?";
	}

	return array(
		'user_agent' => $user_agent,
		'name'       => $browser_name,
		'version'    => $version,
		'platform'   => $platform,
		'pattern'    => $pattern,
	);
}

/**
 * Generates a CSS class name based on detected browser, depends on PHP Browser Detection plugin. Gracefully degrades
 * if the plugin isn't available. Also adds a class for post-type and slug (since 0.7.1).
 *
 * @since 0.7.1
 *
 * @param bool $show_major_version
 * @param bool $show_minor_version
 *
 * @return string
 */
function mapi_broswer_class($show_major_version = FALSE, $show_minor_version = FALSE) {
	if (function_exists('php_browser_info')) {
		$browser = php_browser_info();

		$class = $browser[ 'browser' ];
		if (!empty($browser[ 'majorver' ]) && $show_major_version) {
			$class .= '-' . $browser[ 'majorver' ];
		}
		if (!empty($browser[ 'minorver' ]) && $show_minor_version) {
			$class .= '-' . $browser[ 'minorver' ];
		}
		$class = strtolower($class);
	} else {
		// fallback on the builtin WP globals if the plugin is not found
		$class = implode(' ', mapi_add_body_classes());
	}

	return $class;
}

/**
 * Uses builtin WP global variables by pushing them into the body_class array of CSS classes.
 *
 * @param array $classes
 *
 * @return array
 */
function mapi_add_body_classes($classes = array()) {
	global $is_lynx, $is_gecko, $is_winIE, $is_macIE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $post;
	if ($is_lynx) {
		$classes[] = 'lynx';
	}
	if ($is_gecko) {
		$classes[] = 'gecko';
	}
	if ($is_winIE) {
		$classes[] = 'win-ie';
	}
	if ($is_macIE) {
		$classes[] = 'mac-ie';
	}
	if ($is_winIE || $is_macIE) {
		$classes[] = 'ie';
	}
	if ($is_opera) {
		$classes[] = 'opera';
	}
	if ($is_NS4) {
		$classes[] = 'ns4';
	} // yeah right
	if ($is_safari) {
		$classes[] = 'safari';
	}
	if ($is_chrome) {
		$classes[] = 'chrome';
	}
	if ($is_iphone) {
		$classes[] = 'iphone';
	} // add post "type-slug"
	if (isset($post)) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

/**
 * Adds a CSS class for a users' Operating System to the BODY tag.
 *
 * @param $classes
 *
 * @return array
 */
function mapi_add_os_body_class($classes) {
	if (stristr($_SERVER[ 'HTTP_USER_AGENT' ], "iphone") || stristr($_SERVER[ 'HTTP_USER_AGENT' ], "ipad")) {
		$classes[] = 'ios';
	} elseif (stristr($_SERVER[ 'HTTP_USER_AGENT' ], "android")) {
		$classes[] = 'android';
	} elseif (stristr($_SERVER[ 'HTTP_USER_AGENT' ], "mac")) {
		$classes[] = 'osx';
	} elseif (stristr($_SERVER[ 'HTTP_USER_AGENT' ], "linux")) {
		$classes[] = 'linux';
	} elseif (stristr($_SERVER[ 'HTTP_USER_AGENT' ], "windows")) {
		$classes[] = 'windows';
	}

	return $classes;
}

/**
 * Provides an additional mechanism for outputting errors to the browser or the JavaScript console.
 *
 * @param $args array [string]msg    An error message to output to the user.
 * @param $args array [bool]echo     TRUE outputs the error to the screen, FALSE to the JS console. Default FALSE.
 * @param $args array [bool]die      TRUE stops script execution, FALSE allows execution to continue. Default FALSE.
 *
 * @return string
 */
function mapi_error($args) {
	global $MAPI_ERRORS;
	if (!is_array($args)) {
		$args[ 'msg' ] = 'Fatal error: mapi_error must be passed an array.';
	}
	$defaults = array(
		'msg'  => 'An unspecified error occurred',
		'echo' => FALSE,
		'die'  => FALSE,
	);
	$args = wp_parse_args($args, $defaults);

	$debug = debug_backtrace();
	$i = (empty($debug[ 1 ][ "function" ])) ? 0 : 1;

	$str = '';

	/** @noinspection PhpUndefinedVariableInspection */
	if ($args[ 'echo' ]) {
		$str .= '<div id="message" class="error"><p><strong>';
	}
	$str .= "[" . $debug[ $i ][ "function" ] . "]";
	if ($args[ 'echo' ]) {
		$str .= '</strong>';
	}

	/** @noinspection PhpUndefinedVariableInspection */
	@$str .= ": " . $args[ 'msg' ] . " in " . $debug[ $i ][ "file" ] . " on line " . $debug[ $i ][ "line" ];
	if ($args[ 'echo' ]) {
		$str .= '</p></div>';
	}

	if ($args[ 'echo' ]) {

		/** @noinspection PhpUndefinedVariableInspection */
		if ($args[ 'die' ]) {
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
 * Stops PHP execution and outputs an error message.
 *
 * @param $msg
 */
function mapi_die($msg) {
	mapi_error(array(
				   'msg'  => $msg,
				   'echo' => TRUE,
				   'die'  => TRUE,
			   ));
}

/**
 * Outputs a message to the JavaScript console.
 *
 * @param $msg
 */
function mapi_console_log($msg) {
	mapi_error(array(
				   'msg'  => $msg,
				   'echo' => FALSE,
				   'die'  => FALSE,
			   ));
}

/**
 * Outputs a mustache to the JavaScript console.
 * Needs tob e hooked to an early action, for example 'init'.
 *
 * @param $msg
 */
function mapi_kirts($msg = NULL) {
	global $MAPI_ERRORS;
	if ($msg == "happy") {
		$msg = ":{)"; // unusual
	} else {
		$msg = ':{'; // normal
	}
	$MAPI_ERRORS[] = $msg;
}

/**
 * Outputs registered error message to the JavaScript console in wp_footer.
 */
function mapi_error_console() {
	global $MAPI_ERRORS;
	if (count($MAPI_ERRORS) != 0) {
		echo '<script type="text/javascript">';
		foreach ($MAPI_ERRORS as $error) {
			echo 'console.log("' . $error . '");';
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
	if (current_user_can($capability)) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		/** @var bool $die */
		if ($die) {
			die;
		}
	}
}

/**
 * Useful for debugging.
 */
function mapi_poop() {
	mapi_var_dump('Poop', TRUE);
}

/**
 * Returns an array of file URLs for a given directory filterable by file extension(s).
 *
 * @todo use SPL
 *
 * @param null   $dir
 * @param string $exts
 *
 * @return array
 */
function mapi_file_array_dir($dir = NULL, $exts = 'jpg,jpeg,png,gif') {
	if (!isset($dir)) {
		$dir = './';
		//mapi_error(array('msg' => $dir));
	}
	if (file_exists($dir)) {
		$files = array();
		$i = -1;
		$handle = opendir($dir);
		$exts = explode(',', strtolower($exts));
		while (FALSE !== ($file = readdir($handle))) {
			foreach ($exts as $ext) {
				if (preg_match('/\.' . $ext . '$/i', $file, $test)) {
					$files[] = mapi_path_to_url($dir . $file);
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
 * Outputs a file extension for a given string filename.
 *
 * @param $file_name
 *
 * @return string
 */
function mapi_get_file_extension($file_name) {
	return substr(strrchr($file_name, '.'), 1);
}

/**
 * Converts all numeric values in an associative array into integers.
 *
 * @param $value
 *
 * @return int
 */
function mapi_intval_array($value) {
	if (is_numeric($value)) {
		return intval($value);
	} else {
		return $value;
	}
}

/**
 * Search a multidimensional array for a value.
 *
 * @param mixed $needle   What to search for.
 * @param array $haystack Array to search within.
 * @param bool  $strict   Whether to use strict type checking or not.
 *
 * @return bool
 */
function mapi_in_array_r($needle, $haystack, $strict = FALSE) {
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && mapi_in_array_r($needle, $item, $strict))) {
			return TRUE;
		}
	}

	return FALSE;
}

/**
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
 * Preloads given assets in the background.
 *
 * @param null   $dir
 * @param string $exts
 */
function mapi_preload($dir = NULL, $exts = 'jpg,jpeg,png,gif') {
	$preload_var = 'preload_' . rand(); // create a random var name for us in JS
	$preload_arr = mapi_file_array_dir(trailingslashit($dir), $exts);
	?>
	<script type="text/javascript">
		if (typeof jQuery != 'undefined') {
			var <?php echo $preload_var?> = <?php echo json_encode($preload_arr); ?>;
			jQuery(<?php echo $preload_var; ?>).each(function() {
				jQuery('<img/>')[ 0 ].src = this;
				//console.log(this + ' loaded');
			});
		}
	</script>
	<?php
}

/**
 * Helper function to get rid of inline CSS styling WordPress outputs for the recent comments widget. Updated to also remove WP 4.2+ inline Emoji code.
 */
function mapi_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets[ 'WP_Widget_Recent_Comments' ], 'recent_comments_style'));

	// REMOVE WP EMOJI
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
}

/**
 * Gives an alert to users of older version of IE that they should update their browser.
 */
function mapi_ie_warning() {
	$load_ieupdate = mapi_get_option('load_ieupdate');
	if (!empty($load_ieupdate[ 'load_ieupdate_version_txt' ])) {
		mapi_toggle_html_compression();
		?>
		<!--[if lt IE <?php echo $load_ieupdate['load_ieupdate_version_txt']; ?>]>
		<script type="text/javascript">
			var IE6UPDATE_OPTIONS = {
				icons_path: "<?php echo plugins_url('lib/ie6update/images/', dirname(__FILE__)); ?>",
				message: "Internet Explorer is missing updates required to properly view this website. Click here to update your browser... "
			}
		</script>
		<script type="text/javascript" src="<?php echo plugins_url('lib/ie6update/ie6update.js', dirname(__FILE__)); ?>"></script>
		<![endif]-->
		<?php
		mapi_toggle_html_compression();
	}
}

/**
 * Retrieve an option from the Theme API options array.
 *
 * @param null $name
 *
 * @return string
 */
function mapi_get_option($name = NULL) {
	if (empty($name)) {
		return mapi_error(array('msg' => 'Option name is NULL', 'echo' => FALSE, 'die' => FALSE));
	}

	$options = get_option(MAPI_OPTIONS);
	if ($options && array_key_exists($name, $options)) {
		return $options[ $name ];
	} else {
		if (current_user_can('manage_options') && WP_DEBUG) {
			mapi_error(array('msg' => 'get_option returned FALSE. Your code expects a value here but the user hasn\'t set one on the options page.', 'echo' => FALSE, 'die' => FALSE));
		}

		return FALSE;
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
	if (empty($name)) {
		return FALSE;
	}

	$options = get_option(MAPI_OPTIONS);
	if ($options) {
		$options[ $name ] = $value;

		return update_option(MAPI_OPTIONS, $options);
	} else {
		return FALSE;
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
	if (empty($name)) {
		return FALSE;
	}

	$options = get_option(MAPI_OPTIONS);
	if ($options) {
		$options[ $name ] = '';

		return update_option(MAPI_OPTIONS, $options);
	} else {
		return FALSE;
	}
}

/**
 * Echoes a given option from the Theme API options array.
 *
 * @param string $name
 */
function mapi_option($name = NULL) {
	echo mapi_get_option($name);
}

/**
 * Unloads jQuery obviously.
 */
function mapi_unload_jquery() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_dequeue_script('jquery');
	}
}

/**
 * Loads the version of jquery registered with WordPress.
 */
function mapi_load_jquery() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
}

/**
 * Loads Bootstrap JS
 */
function mapi_load_bootstrap() {
	if (!is_admin()) {
		wp_deregister_script('bootstrap');
		wp_register_script('bootstrap', '//cdn.jsdelivr.net/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('bootstrap');
	}
}

/**
 * Loads Bootstrap CSS
 */
function mapi_load_bootstrap_css() {
	if (!is_admin()) {
		wp_deregister_style('bootstrap');
		wp_register_style('bootstrap', '//cdn.jsdelivr.net/bootstrap/3.3.7/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap');
	}
}

/**
 * Loads Font Awesome
 */
function mapi_load_font_awesome() {
	if (!is_admin()) {
		wp_deregister_style('font-awesome');
		wp_register_style('font-awesome', '//cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css');
		wp_enqueue_style('font-awesome');
	}
}

/**
 * Loads Modernizr
 */
function mapi_load_modernizr() {
	if (!is_admin()) {
		wp_deregister_script('modernizr');
		wp_register_script('modernizr', '//cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js', array('jquery'));
		wp_enqueue_script('modernizr');
	}
}

/**
 * Loads Backbone
 */
function mapi_load_backbone() {
	if (!is_admin()) {
		wp_enqueue_script('backbone');
	}
}

/**
 * Loads Underscore
 */
function mapi_load_underscore() {
	if (!is_admin()) {
		wp_enqueue_script('underscore');
	}
}

/**
 * Loads Mapbox
 */
function mapi_load_mapbox() {
	if (!is_admin()) {
		wp_deregister_style('mapbox-css');
		wp_register_style('mapbox-css', '//api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.css');
		wp_enqueue_style('mapbox-css');

		wp_deregister_script('mapbox-js');
		wp_register_script('mapbox-js', '//api.tiles.mapbox.com/mapbox.js/v2.2.4/mapbox.js');
		wp_enqueue_script('mapbox-js');
	}
}

/**
 * Loads Masonry
 */
function mapi_load_masonry() {
	if (!is_admin()) {
		wp_enqueue_script('jquery-masonry');
	}
}

/**
 * Loads Isotope
 */
function mapi_load_isotope() {
	if (!is_admin()) {
		wp_deregister_script('isotope');
		wp_register_script('isotope', '//cdn.jsdelivr.net/isotope/2.2.2/isotope.pkgd.min.js');
		wp_enqueue_script('isotope');
	}
}

/**
 * Loads Superfish
 */
function mapi_load_superfish() {
	if (!is_admin()) {
		wp_deregister_script('superfish');
		wp_register_script('superfish', '//cdn.jsdelivr.net/superfish/1.7.7/js/superfish.min.js');
		wp_enqueue_script('superfish');
	}
}

/**
 * Loads FitVids
 */
function mapi_load_fitvids() {
	if (!is_admin()) {
		wp_deregister_script('fitvids');
		wp_register_script('fitvids', '//cdn.jsdelivr.net/fitvids/1.1.0/jquery.fitvids.js', array('jquery'));
		wp_enqueue_script('fitvids');
	}
}

/**
 * Loads FlexSlider
 */
function mapi_load_flexslider() {
	if (!is_admin()) {
		wp_deregister_script('flexslider');
		wp_register_script('flexslider', '//cdn.jsdelivr.net/flexslider/2.6.0/jquery.flexslider-min.js', array('jquery'));
		wp_enqueue_script('flexslider');
		//wp_register_style('flexslider', '//cdn.jsdelivr.net/flexslider/2.2.2/flexslider.css');
		//wp_enqueue_style('flexslider');
	}
}

/**
 * Loads FitText
 */
function mapi_load_fittext() {
	if (!is_admin()) {
		wp_deregister_script('fittext');
		wp_register_script('fittext', '//cdn.jsdelivr.net/fittext/1.2/jquery.fittext.js', array('jquery'));
		wp_enqueue_script('fittext');
	}
}

/**
 * Loads TinySort
 */
function mapi_load_tinysort() {
	if (!is_admin()) {
		wp_deregister_script('tinysort');
		wp_register_script('tinysort', '//cdnjs.cloudflare.com/ajax/libs/tinysort/2.2.4/tinysort.min.js', array('jquery'));
		wp_enqueue_script('tinysort');
		wp_deregister_script('tinysort-char');
		wp_register_script('tinysort-char', '//cdnjs.cloudflare.com/ajax/libs/tinysort/2.2.4/tinysort.charorder.min.js', array('jquery, tinysort'));
		wp_enqueue_script('tinysort-char');
	}
}

/**
 * Loads jQuery TipTip
 */
function mapi_load_tiptip() {
	if (!is_admin()) {
		wp_deregister_script('tiptip');
		wp_register_script('tiptip', '//cdn.jsdelivr.net/tiptip/1.3/jquery.tipTip.minified.js');
		wp_enqueue_script('tiptip');
	}
}

/**
 * Quickly dequeue all styles that are currently enqueued by WordPress.
 * Usage: add_action('wp_print_scripts', 'mapi_remove_all_scripts', 100);
 */
function mapi_remove_all_scripts() {
	global $wp_scripts;
	$wp_scripts->queue = array();
}

/**
 * Quickly dequeue all styles that are currently enqueued by WordPress.
 * Usage: add_action('wp_print_styles', 'mapi_remove_all_styles', 100);
 */
function mapi_remove_all_styles() {
	global $wp_styles;
	$wp_styles->queue = array();
}

/**
 * Add JavaScript to break out of any HTML frames.
 */
function mapi_break_frames() {
	?>
	<script type="text/javascript">
		//console.log(self.location.toString());
		if (top.location.toString() != self.location.toString()) {
			if (top.location.toString().indexOf('wp-admin/customize.php') == -1) {
				if (top.location != self.location) {
					top.location = self.location.href;
				}
			}
		}
	</script><?php
}

/**
 * Outputs an edit post link with built in support for custom post types. Used in place of the standard WordPress function edit_post_link()
 */
function mapi_edit_link() {
	global $post;
	if (current_user_can('edit_post', $post->ID)) {
		$label = get_post_type_object(get_post_type($post));
		$label = ucwords($label->labels->singular_name);
		if (!empty($label)) {
			$label = 'Edit ' . $label;
		} else {
			$label = 'Edit Page';
		}

		return apply_filters('mapi_edit_link', '<p class="mapi edit-link btn btn-xs btn-default"><a href="' . get_edit_post_link() . '">' . $label . '</a></p>');
	} else {
		return FALSE;
	}
}

/**
 * Automatically sets external (offsite) links to open in a new window or tab. Updated to allow subdomains from the same TLD.
 * Manually override the target by setting the data-target attribute to any valid frame/window target.
 */
function mapi_external_links() {
	global $MAPI_TLD;
	if (!isset($MAPI_TLD) || empty($MAPI_TLD)) {
		$MAPI_TLD = mapi_extract_domain(mapi_get_url());
	}
	?>
	<script type="text/javascript">jQuery(document).ready(function() {
			jQuery("a[href^='http']:not([href*='<?php echo $MAPI_TLD; ?>'])").each(function() {
				if (jQuery(this).attr('data-target')) {
					jQuery(this).attr("target", jQuery(this).data('target'));
				} else {
					jQuery(this).attr("target", "_blank");
				}
			});
		});</script><?php
}

/**
 * Helper function to set make some WordPress config options available in JavaScript.
 */
function mapi_set_contstants_js() {
	?>
	<script type="text/javascript">var plugins_url = '<?php echo plugins_url(); ?>';
		var MAPI_PLUGIN_SLUG = '<?php echo MAPI_PLUGIN_SLUG; ?>';
		var MAPI_PLUGIN_NAME = '<?php echo MAPI_PLUGIN_NAME; ?>';</script><?php
}

/**
 * Removes version numbers from script requests.
 */
function mapi_remove_version_scripts() {
	global $wp_scripts;
	if (!is_a($wp_scripts, 'WP_Scripts')) {
		return;
	}
	foreach ($wp_scripts->registered as $handle => $script) {
		$wp_scripts->registered[ $handle ]->ver = NULL;
	}
}

/**
 * Removes version numbers from style requests.
 */
function mapi_remove_version_styles() {
	global $wp_styles;
	if (!is_a($wp_styles, 'WP_Styles')) {
		return;
	}
	foreach ($wp_styles->registered as $handle => $style) {
		$wp_styles->registered[ $handle ]->ver = NULL;
	}
}

/**
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
 * Dequeues CSS from WordPress.
 */
function mapi_dequeue_css() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if (strpos($enable_adv_speed_options[ 'dequeue_styles_txt' ], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options[ 'dequeue_styles_txt' ]);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options[ 'dequeue_styles_txt' ]);
	}
	foreach ($arr as $item) {
		wp_dequeue_style($item);
	}
}

/**
 * Deregisters CSS from WordPress.
 */
function mapi_deregister_css() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if (strpos($enable_adv_speed_options[ 'deregister_styles_txt' ], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options[ 'deregister_styles_txt' ]);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options[ 'deregister_styles_txt' ]);
	}
	foreach ($arr as $item) {
		wp_deregister_style($item);
	}
}

/**
 * Dequeues JS from WordPress.
 */
function mapi_dequeue_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if (strpos($enable_adv_speed_options[ 'dequeue_scripts_txt' ], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options[ 'dequeue_scripts_txt' ]);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options[ 'dequeue_scripts_txt' ]);
	}
	foreach ($arr as $item) {
		wp_dequeue_script($item);
	}
}

/**
 * Deregisters JS from WordPress.
 */
function mapi_deregister_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if (strpos($enable_adv_speed_options[ 'deregister_scripts_txt' ], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options[ 'deregister_scripts_txt' ]);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options[ 'deregister_scripts_txt' ]);
	}
	foreach ($arr as $item) {
		wp_deregister_script($item);
	}
}

/**
 * Enqueues JS to WordPress.
 */
function mapi_enqueue_scripts() {
	$enable_adv_speed_options = mapi_get_option('enable_adv_speed_options');
	// check to see if there is comma delimiting in the textarea
	// this format is still silently supported for backward compatibility
	if (strpos($enable_adv_speed_options[ 'enqueue_scripts_txt' ], ',') !== FALSE) {
		$arr = explode(',', $enable_adv_speed_options[ 'enqueue_scripts_txt' ]);
	} else {
		$arr = explode("\r\n", $enable_adv_speed_options[ 'enqueue_scripts_txt' ]);
	}
	foreach ($arr as $item) {
		wp_enqueue_script($item);
	}
}

/**
 * Registers JS to WordPress.
 * (not currently implemented)
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

	if (empty($ga_id)) {
		// no GA web property was passed, so grab the one from the API options page
		$ga_id = mapi_get_option('ga_acct_txt');
		if (empty($ga_id)) {
			mapi_error(array('msg' => 'No Google Analytics Web Property ID was found.', 'echo' => FALSE, 'die' => FALSE));
		}
	}

	if (empty($allow_multiple_domains)) {
		// allow_multiple_domains flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		if (array_key_exists('multiple_domains', $ga_adv_options)) {
			$allow_multiple_domains = @$ga_adv_options[ 'multiple_domains' ];
		}
	}
	if (empty($enhanced_link_attribution)) {
		// enhanced_link_attribution flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		if (array_key_exists('enhanced_link_attribution', $ga_adv_options)) {
			$enhanced_link_attribution = @$ga_adv_options[ 'enhanced_link_attribution' ];
		}
	}
	if (empty($universal_analytics)) {
		// allow_multiple_domains flag was not passed, so grab the one from the API options page
		$ga_adv_options = mapi_get_option('enable_adv_ga_options');
		if (array_key_exists('universal_analytics', $ga_adv_options)) {
			$universal_analytics = @$ga_adv_options[ 'universal_analytics' ];
		}
	}
	// get the base of the site domain (removing any subdomains, etc)
	$domain = mapi_extract_domain(home_url());

	$ga_code = "<script type=\"text/javascript\">";

	if (mapi_is_true($universal_analytics)) {
		$ga_code .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
		$ga_code .= "ga('create', '" . $ga_id . "', '" . $domain . "');";
		$ga_code .= "ga('send', 'pageview');";
	} else {

		$ga_code .= "var _gaq = _gaq || [];\n";
		if (mapi_is_true($enhanced_link_attribution)) {
			$ga_code .= "var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';\n";
			$ga_code .= "_gaq.push(['_require', 'inpage_linkid', pluginUrl]);\n";
		}
		$ga_code .= "\t_gaq.push(['_setAccount', '" . $ga_id . "']);\n\t_gaq.push(['_setDomainName', '" . $domain . "']);\n";
		if (mapi_is_true($allow_multiple_domains)) {
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
	$domain = $domain[ 'host' ];
	require_once(MAPI_DIR_PATH . 'lib/regdom-php/effectiveTLDs.inc.php');
	$tldTree = require_once(MAPI_DIR_PATH . 'lib/regdom-php/regDomain.inc.php');
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

	return apply_filters('mapi_tel_uri', $prefix . $tel);
}

/**
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
 * Turns a number into a USD formatted string. Example: 1200.25 becomes $1,200.25.
 *
 * @param      $number
 * @param bool $trim_zeros
 *
 * @return mixed|string
 */
function mapi_money_format($number, $trim_zeros = FALSE) {

	setlocale(LC_MONETARY, 'en_US');

	if ($number == 0) {
		return '';
	} else {

		$number = money_format('%(#1n', $number);

		if ($trim_zeros) {
			$number = str_ireplace(".00", "", $number);
		}

		return $number;
	}
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
	unset($actions[ 'inline hide-if-no-js' ]);

	return $actions;
}

/**
 * Lists all hooked functions (optionally filterable by a given tag)
 *
 * @link http://www.wprecipes.com/list-all-hooked-wordpress-functions
 *
 * @param bool $tag A tag referencing a hook or filter.
 *
 * @return string
 */
function mapi_list_hooked_functions($tag = FALSE) {
	global $wp_filter;
	if ($tag) {
		$hook[ $tag ] = $wp_filter[ $tag ];
		if (!is_array($hook[ $tag ])) {
			return mapi_error(array('msg' => "Nothing found for '$tag' hook", 'echo' => TRUE));
		}
	} else {
		$hook = $wp_filter;
		ksort($hook);
	}
	echo '<pre>';
	foreach ($hook as $tag => $priorities) {
		echo "<br /><strong>$tag</strong><br />";
		ksort($priorities);
		foreach ($priorities as $priority => $function) {
			echo $priority;
			foreach ($function as $name => $properties) {
				echo "\t$name<br />";
			}
		}
	}
	echo '</pre>';
}

/**
 * Converts a HEX value into an array of its RGB equivalents.
 *
 * @param $hex_color string Examples: '#FFCC00' or 'FFCC00'
 *
 * @return array|bool Array of RGB value with keys 'red', 'green', and 'blue'. FALSE if no valid hexadecimal value was passed.
 */
function mapi_hex_to_rgb($hex_color) {
	if ($hex_color[ 0 ] == '#') {
		$hex_color = substr($hex_color, 1);
	}
	if (strlen($hex_color) == 6) {
		list($r, $g, $b) = array($hex_color[ 0 ] . $hex_color[ 1 ], $hex_color[ 2 ] . $hex_color[ 3 ], $hex_color[ 4 ] . $hex_color[ 5 ]);
	} elseif (strlen($hex_color) == 3) {
		list($r, $g, $b) = array($hex_color[ 0 ] . $hex_color[ 0 ], $hex_color[ 1 ] . $hex_color[ 1 ], $hex_color[ 2 ] . $hex_color[ 2 ]);
	} else {
		return FALSE;
	}
	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);

	return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Converts a given file (and MIME type) to data URI.
 *
 * @param        $file
 * @param string $mime
 *
 * @return string
 */
function mapi_data_uri($file, $mime = '') {
	if (function_exists('mime_content_type')) {
		return 'data: ' . mime_content_type($file) . ';base64,' . base64_encode(file_get_contents($file));
	} else {
		return 'data: ' . $mime . ';base64,' . base64_encode(file_get_contents($file));
	}
}

/**
 * Generates a random alphanumeric string of the given length.
 *
 * @param int $length int Default is 16.
 *
 * @return string
 */
function mapi_random_string($length = 16) {
	$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$len = strlen($salt);
	$random_string = '';
	mt_srand(10000000 * (double) microtime());
	for ($i = 0; $i < $length; $i++) {
		$random_string .= $salt[ mt_rand(0, $len - 1) ];
	}

	return $random_string;
}

/**
 * Returns a user's IP address, even behind a proxy server.
 *
 * @return mixed
 */
function mapi_get_ip() {
	if (!empty($_SERVER[ 'HTTP_CLIENT_IP' ])) {
		$ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
	} elseif (!empty($_SERVER[ 'HTTP_X_FORWARDED_FOR' ])) {
		$ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
	} else {
		$ip = $_SERVER[ 'REMOTE_ADDR' ];
	}

	return $ip;
}

/**
 * Looks up a hostname using an IP address.
 *
 * @param $ip
 *
 * @return string
 */
function mapi_get_host_by_ip($ip) {
	if (function_exists('gethostbyaddr')) {
		return gethostbyaddr($ip);
	} else {
		return mapi_error(array('msg' => 'gethostbyaddr() not available.'));
	}
}

/**
 * Looks up an IP address using a hostname.
 *
 * @param $host
 *
 * @return string
 */
function mapi_get_ip_by_host($host) {
	if (function_exists('gethostbyname')) {
		return gethostbyname($host);
	} else {
		return mapi_error(array('msg' => 'gethostbyname() not available.'));
	}
}

/**
 * Returns a lowercase string with the web server software.
 * Currently supports "apache", "nginx", and "other".
 *
 * @return string
 */
function mapi_check_server() {
	if (array_key_exists('SERVER_SOFTWARE', $_SERVER)) {
		$server = $_SERVER[ 'SERVER_SOFTWARE' ];
		if (stripos($server, 'nginx') !== FALSE) {
			$server = 'nginx';
		} elseif (stripos($server, 'apache') !== FALSE) {
			$server = 'apache';
		} else {
			$server = 'other';
		}
	}

	return $server;
}

/**
 * Checks an IPv4 address to see if it is a public IP or an internal (reserved) IP address.
 *
 * @param $ip
 *
 * @return bool
 */
function mapi_is_reserved_ipv4($ip) {
	$reserved_ips = array(
		// not an exhaustive list
		'167772160'  => 184549375, // 10.0.0.0 - 10.255.255.255
		'3232235520' => 3232301055, // 192.168.0.0 - 192.168.255.255 
		'2130706432' => 2147483647, // 127.0.0.0 - 127.255.255.255 
		'2851995648' => 2852061183, // 169.254.0.0 - 169.254.255.255 
		'2886729728' => 2887778303, // 172.16.0.0 - 172.31.255.255 
		'3758096384' => 4026531839, // 224.0.0.0 - 239.255.255.255 
	);
	$ip_long = sprintf('%u', ip2long($ip));
	foreach ($reserved_ips as $ip_start => $ip_end) {
		if (($ip_long >= $ip_start) && ($ip_long <= $ip_end)) {
			return TRUE;
		}
	}

	return FALSE;
}

/**
 * Outputs the active PHP template being used by the current query if the logged in user has a given capability.
 *
 * @param string $capability
 * @param bool   $echo
 *
 * @return string
 */
function mapi_get_active_template($capability = 'manage_options', $echo = TRUE) {
	global $template;
	if (current_user_can($capability)) {

		if ($echo) {
			echo '<code>';
			basename($template);
			echo '</code>';
		} else {
			return basename($template);
		}
	}
}
