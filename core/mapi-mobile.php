<?php
/**
 * Mindshare Theme API MOBILE DEVICE FUNCTIONS
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-mobile.php
 *
 */

/**
 *
 * Alias for mapi_is_mobile, created because mapi_is_mobile can be easily confused with mapi_is_mobile_active,
 * added word 'device' to the function name for clarity.
 *
 * @param bool $include_iphone Optional. Whether to include iPhones as mobile devices. Default is TRUE.
 * @param bool $include_ipad   Optional. Whether to include iPads as mobile devices. Default is FALSE.
 *
 * @return bool
 */
function mapi_is_mobile_device($include_iphone = TRUE, $include_ipad = FALSE) {
	return mapi_is_mobile($include_iphone, $include_ipad);
}

/**
 *
 * Tests to see if the current site visitor is using a mobile device based on user agent.
 *
 * @param bool $include_iphone Optional. Whether to include iPhones as mobile devices. Default is TRUE.
 * @param bool $include_ipad   Optional. Whether to include iPads as mobile devices. Default is FALSE.
 *
 * @return bool Returns TRUE if the user is visiting the site from a mobile device, otherwise FALSE.
 */
function mapi_is_mobile($include_iphone = TRUE, $include_ipad = FALSE) {

	if(!$include_iphone && preg_match("/iphone/i", $_SERVER["HTTP_USER_AGENT"])) {
		return FALSE;
	}

	if(!$include_ipad && preg_match("/ipad/i", $_SERVER["HTTP_USER_AGENT"])) {
		return FALSE;
	}

	// check the server headers to see if they're mobile friendly
	if(isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
		return TRUE;
	}

	// if the http_accept header supports wap then it's a mobile too
	if(preg_match("/wap\.|\.wap/i", $_SERVER["HTTP_ACCEPT"])) {
		return TRUE;
	}

	if(isset($_SERVER["HTTP_USER_AGENT"])) {
		$user_agents = array(
			"midp",
			"j2me",
			"avantg",
			"docomo",
			"novarra",
			"palmos",
			"palmsource",
			"240x320",
			"opwv",
			"chtml",
			"pda",
			"windows\ ce",
			"mmp\/",
			"blackberry",
			"mib\/",
			"symbian",
			"wireless",
			"nokia",
			"hand",
			"mobi",
			"phone",
			"cdm",
			"up\.b",
			"audio",
			"SIE\-",
			"SEC\-",
			"samsung",
			"HTC",
			"mot\-",
			"mitsu",
			"sagem",
			"sony",
			"alcatel",
			"lg",
			"erics",
			"vx",
			"NEC",
			"philips",
			"mmm",
			"xx",
			"panasonic",
			"sharp",
			"wap",
			"sch",
			"rover",
			"pocket",
			"benq",
			"java",
			"pt",
			"pg",
			"vox",
			"amoi",
			"bird",
			"compal",
			"kg",
			"voda",
			"sany",
			"kdd",
			"dbt",
			"sendo",
			"sgh",
			"gradi",
			"jb",
			"\d\d\di",
			"moto"
		);
		foreach($user_agents as $user_string) {
			if(preg_match("/".$user_string."/i", $_SERVER["HTTP_USER_AGENT"])) {
				return TRUE;
			}
		}
	}

	return FALSE;
}

/**
 *
 * Tests whether a visitor is using a mobile device or not and stores the result in a cookie (with key "mobile" and
 * the value of either "on" or "off", the cookie key is filterable with the tag 'mapi_mobile_cookie').
 *
 * Useful for displaying a separate mobile version of a site (mobile-first responsive layouts are great - but not
 * always appropriate.) This must be called before headers are sent to the browser (e.g. before the HTML tag in
 * header.php.)
 *
 * The function can either be set to add a CSS class of "mobile" on the BODY tag or to require a PHP file from the
 * theme directory. The CSS class applied is filterable with the tag 'mapi_mobile_class'.
 *
 * Allows users/developers to override any previously set choice by appending ?mobile=on or ?mobile=off to the
 * current URL. Useful for debugging.
 *
 * @param string $action             Optional. Mechanism of action. Valid values are "class" (add a "mobile" CSS class to the BODY
 *                                   tag) or "require" (require a PHP file from the theme directory.). Defaults to "class".
 * @param bool   $include_iphone     Optional. Whether to include iPhones as mobile devices. Default is TRUE.
 * @param bool   $include_ipad       Optional. Whether to include iPads as mobile devices. Default is FALSE.
 * @param string $template_file_slug Optional. Basename of the PHP file to include from the theme folder. Default is
 *                                   "mobile" (the .php suffix is added by the function.)
 *
 * @return string
 */
function mapi_mobile_header($action = 'class', $include_iphone = TRUE, $include_ipad = FALSE, $template_file_slug = 'mobile') {
	if(headers_sent()) {
		return mapi_error(
			array(
				 'msg'  => 'Headers already sent, mobile headers could not be sent.',
				 'echo' => FALSE,
				 'die'  => FALSE
			)
		);
	}
	$mobile_cookie = apply_filters('mapi_mobile_cookie', "mobile");
	if(mapi_is_true($_GET['mobile']) || mapi_is_mobile($include_iphone, $include_ipad)) {
		setcookie($mobile_cookie, 'on', time() + 60 * 60 * 24 * 365, '/', '.'.parse_url(get_bloginfo('url'), PHP_URL_HOST));
	}
	if(!mapi_is_true($_GET['mobile'])) {
		setcookie($mobile_cookie, 'off', time() + 60 * 60 * 24 * 365, '/', '.'.parse_url(get_bloginfo('url'), PHP_URL_HOST));
	}
	if(mapi_is_mobile_active()) {
		$action == 'require' ? require(get_template_directory().'/'.$template_file_slug.'.php') : add_filter('body_class', 'mapi_add_body_mobile_class');
	}
}

/**
 *
 *
 * Helper function to add CSS classes to the body tag. Not intended to be called directly.
 *
 * @param $classes
 *
 * @return array
 */
function mapi_add_body_mobile_class($classes) {
	$classes[] = apply_filters('mapi_mobile_class', 'mobile');
	return $classes;
}

/**
 *
 *
 * Tests to see if a user is currently viewing the mobile or non-mobile version of the site. This is useful if you
 * need to if a visitor with a mobile device is viewing the desktop site or vice versa. To check if a user is
 * using a mobile device see the function mapi_is_mobile_device.
 *
 * Allows users/developers to override any previously set choice by appending ?mobile=on or ?mobile=off to the
 * current URL. Useful for debugging.
 *
 * @return bool Returns TRUE if the user is currently viewing the mobile version, otherwise FALSE.
 */
function mapi_is_mobile_active() {
	// 1. if the cookie is set to ON and the get var is not 'off', go mobile
	if(mapi_is_true($_COOKIE[apply_filters('mapi_mobile_cookie', "mobile")]) && $_GET['mobile'] != 'off') {
		return TRUE;
	}
	// 2. if we automatcially detect a mobile device, and the get var and cookie are both 'off', go mobile
	if(mapi_is_mobile() && $_GET['mobile'] != 'off' && $_COOKIE[apply_filters('mapi_mobile_cookie', "mobile")] != 'off') {
		return TRUE;
	}
	// 3. if just get var is set to 'on', go mobile
	if(mapi_is_true($_GET['mobile'])) {
		return TRUE;
	}
	return FALSE;
}

/**
 *
 * Outputs an HTML hyperlink so users can toggle between the mobile and non-mobile version of a site.
 *
 * @param string $before            Text or HTML to output before the link.
 * @param string $after             Text or HTML to output after the link.
 * @param string $link_text_full    Link text for accessing the non-mobile site.
 * @param string $link_text_mobile  Link text for accessing the mobile site.
 * @param string $title_text_full   Link title attribute for accessing the non-mobile site.
 * @param string $title_text_mobile Link title attribute for accessing the mobile site.
 */
function mapi_mobile_link($before = '<li class="mcms-mobile-link">', $after = '</li>', $link_text_full = 'Full Website', $link_text_mobile = 'Mobile Website', $title_text_full = 'Switch to our full website', $title_text_mobile = 'Switch to our mobile website') {
	if(mapi_is_mobile_active()) {
		echo apply_filters('mapi_mobile_link_off', $before.'<a href="?mobile=off" title="'.$link_text_full.'">'.$link_text_full.'</a>'.$after);
	} else {
		echo apply_filters('mapi_mobile_link_on', $before.'<a href="?mobile=on" title="'.$link_text_mobile.'">'.$link_text_mobile.'</a>'.$after);
	}
}
