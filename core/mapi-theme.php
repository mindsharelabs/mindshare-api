<?php
/**
 * mapi-theme.php
 *
 * @created   3/21/14 2:54 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      http://www.mindsharelabs.com/documentation/
 *
 */

/**
 * Optionally displays a credit message in compatible themes when enabled in the Mindshare Theme API
 * (Settings > Developer Settings > Misc. Settings > Show Credit)
 *
 */
function mapi_copyright() {
	mapi_toggle_html_compression();
	echo '<!-- Copyright '.date('Y').' '.get_bloginfo('name').' -->';
	$c = 'PCEtLSBXZWIgZGVzaWduLCBkZXZlbG9wbWVudCwgYW5kIFNFTyBieSBodHRwOi8vbWluZC5zaC9hcmUvIC0tPgoJPG1ldGEgbmFtZT0iYXV0aG9yIiBjb250ZW50PSJNaW5kc2hhcmUgU3R1ZGlvcywgSW5jLiIgLz4KCQ==';
	if(isset($_GET['credit'])) {
		if($_GET['credit'] == 1) {
			echo base64_decode($c);
		} elseif(function_exists('mapi_get_option')) {
			if(mapi_get_option('show_credit') == TRUE || $_GET['credit'] == 1) {
				echo PHP_EOL.base64_decode($c).PHP_EOL;
			}
		}
	}
	mapi_toggle_html_compression();
}

/**
 * Returns the URL to a user specified favicon sized to 96 x 96.
 *
 * @return string
 */
function mapi_get_favicon_url() {
	$favicon = mapi_get_option('custom_branding');
	if($favicon != NULL && array_key_exists('mapi_favicon', $favicon)) {
		$favicon = $favicon['mapi_favicon']['src'];
		if(!empty($favicon)) {
			$string = mapi_thumb(array('src' => esc_url_raw($favicon), 'w' => 96, 'h' => 96, 'zc' => 1, 'ct' => 1));

			return $string;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

/**
 *
 * Outputs an array of child menu_item post object for a
 * given page ID, if that page appears in the nav menu.
 *
 * This function only grabs first level children, grandchildren are ignored
 * which is sad for them.
 *
 * @param        $menu
 * @param string $parent_id
 *
 * @return array|bool Returns an array of menu_item post objects or FALSE.
 */
function mapi_get_nav_menu_item_children($menu, $parent_id = '') {

	if(empty($parent_id)) {
		return mapi_error(array('msg' => 'A menu parent ID is required.'));
	}

	$full_menu = wp_get_nav_menu_items($menu);
	$children = array();
	// check if we have a valid nav menu
	if($full_menu) {
		foreach($full_menu as $item) {
			// test if the nav menu item is matched with the given parent post ID
			if($parent_id == $item->object_id) {
				$menu_parent = $item->ID;
			}
			if(isset($menu_parent) && $item->menu_item_parent == $menu_parent) {
				$children[] = $item;
			}
		}

		return $children;
	} else {
		return FALSE;
	}
}
