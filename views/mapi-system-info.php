<?php
/**
 * mapi-system-info.php
 *
 * Forked from: SysInfo by Dave Donaldson http://wordpress.org/extend/plugins/sysinfo/
 *
 * @created   4/11/13 5:58 PM
 * @author    Mindshare Studios, Inc.
 * @copyright Copyright (c) 2014
 * @link      http://mindsharelabs.com/downloads/mindshare-theme-api/
 *
 */

require_once(MAPI_DIR_PATH.'/core/mapi-utility.php');

function mapi_system_info() {

	$theme = wp_get_theme();
	$browser = mapi_browser_from_ua();
	$plugins = get_plugins();
	$active_plugins = get_option('active_plugins', array());

	$sysinfo = "WordPress Version:      ".get_bloginfo('version')."\n";
	$sysinfo .= "PHP Version:            ".PHP_VERSION."\n";

	if(class_exists('mysqli')) {
		$mysqli_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
		$sysinfo .= "MySQL Version:          ".mysqli_get_server_info($mysqli_link)."\n";
	} else {
		$sysinfo .= "MySQL Version:          ".mysql_get_server_info()."\n";
	}

	$sysinfo .= "Web Server:             ".$_SERVER['SERVER_SOFTWARE']."\n";

	$sysinfo .= "WordPress URL:          ".get_bloginfo('wpurl')."\n";
	$sysinfo .= "Home URL:               ".get_bloginfo('url')."\n";

	$sysinfo .= "PHP cURL Support:       ";
	if(function_exists('curl_init')) {
		$sysinfo .= __('Yes', 'mapi')."\n";
	} else {
		$sysinfo .= __('No', 'mapi')."\n";
	}
	$sysinfo .= "PHP GD Support:         ";
	if(function_exists('gd_info')) {
		$sysinfo .= __('Yes', 'mapi')."\n";
	} else {
		$sysinfo .= __('No', 'mapi')."\n";
	}
	$sysinfo .= "PHP Memory Limit:       ".ini_get('memory_limit')."\n";
	$sysinfo .= "PHP Post Max Size:      ".ini_get('post_max_size')."\n";
	$sysinfo .= "PHP Upload Max Size:    ".ini_get('upload_max_filesize')."\n";

	$sysinfo .= "WP_DEBUG:               ";
	if(defined('WP_DEBUG')) {
		if(WP_DEBUG) {
			$sysinfo .= __('Enabled', 'mapi')."\n";
		} else {
			$sysinfo .= __('Disabled', 'mapi')."\n";
		}
	} else {
		$sysinfo .= __('Not set', 'mapi')."\n";
	}

	$sysinfo .= "Multi-Site Active:      ";
	if(is_multisite()) {
		$sysinfo .= __('Yes', 'mapi')."\n";
	} else {
		$sysinfo .= __('No', 'mapi')."\n";
	}

	$sysinfo .= "User Operating System:       ".$browser['platform']."\n";
	$sysinfo .= "User Browser:                ".$browser['name'].' '.$browser['version']."\n";
	$sysinfo .= "User Agent:             ".$browser['user_agent']."\n\n";

	$sysinfo .= "Active Theme:\n\n- ".$theme->get('Name')." ".$theme->get('Version')."\n  ".$theme->get('ThemeURI')."\n\n";

	$sysinfo .= "Active Plugins:\n\n";

	foreach($plugins as $plugin_path => $plugin) {
		// Only show active plugins
		if(in_array($plugin_path, $active_plugins)) {
			$sysinfo .= '- '.$plugin['Name'].' '.$plugin['Version']."\n";

			if(isset($plugin['PluginURI'])) {
				$sysinfo .= '  '.$plugin['PluginURI']."\n";
			}

			$sysinfo .= "\n";
		}
	}

	mapi_delete_option('sysinfo'); // required to prevent storing this HTML to the DB

	return $sysinfo;
}
