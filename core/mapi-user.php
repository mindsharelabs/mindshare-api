<?php
/**
 * mapi-user.php
 *
 * @created   3/6/14 12:43 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      http://www.mindsharelabs.com/documentation/
 *
 */

/**
 *
 * Sets the admin color scheme to "midnight" by default.
 * Override the default with another filter like so:
 *
 * <code>
 * add_filter('mapi_admin_color_scheme', 'mapi_my_admin_color_scheme', 5);
 * function mapi_my_admin_color_scheme() {
 *        return 'ectoplasm';
 * }
 * </code>
 *
 *
 * @param $color_scheme
 *
 * @return mixed|void
 */
function mapi_set_admin_color_scheme($color_scheme) {
	if('classic' == $color_scheme || 'fresh' == $color_scheme) {
		$color_scheme = 'midnight';
	}

	return apply_filters('mapi_admin_color_scheme', $color_scheme);
}

/**
 * Moves the Menus nav item to the top level of the WordPress Admin Menu
 * instead of being nested below the Appearance sub menu.
 *
 */
function mapi_admin_menu_nav_menus() {
	add_menu_page('Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', 'dashicons-networking', '6.55');
	add_submenu_page('nav-menus.php', 'All Menus', 'All Menus', 'edit_theme_options', 'nav-menus.php');
	add_submenu_page('nav-menus.php', 'Add New', 'Add New', 'edit_theme_options', '?action=edit&menu=0');
	add_submenu_page('nav-menus.php', 'Menu Locations', 'Menu Locations', 'edit_theme_options', '?action=locations');
	$menus = wp_get_nav_menus(array('orderby' => 'name'));
	foreach($menus as $menu) {
		add_submenu_page(
			'nav-menus.php', esc_attr(ucwords($menu->name)), esc_attr(ucwords($menu->name)), 'edit_theme_options', 'nav-menus.php?action=edit&amp;menu=' . $menu->term_id, '');
	}
}

/**
 * If an email address is entered in the username box, then look up the matching username and authenticate as per normal, using that.
 * Results of authenticating via wp_authenticate_username_password(), using the username found when looking up via email.
 *
 * @param string $user
 * @param string $username
 * @param string $password
 *
 * @return \WP_Error|\WP_User
 */
function mapi_email_login_authenticate($user, $username, $password) {
	if(!empty($username)) {
		$user = get_user_by('email', $username);
	}
	if($user) {
		$username = $user->user_login;
	}

	return wp_authenticate_username_password(NULL, $username, $password);
}

/**
 * Modify the string on the login page to prompt for username or email address
 */
function mapi_username_or_email_login() {
	?>
	<script type="text/javascript">
		// Form Label
		document.getElementById('loginform').childNodes[ 1 ].childNodes[ 1 ].childNodes[ 0 ].nodeValue = 'Username or Email';
		// Error Messages
		if (document.getElementById('login_error')) {
			document.getElementById('login_error').innerHTML = document.getElementById('login_error').innerHTML.replace('username', 'Username or Email');
		}
	</script><?php
}

/**
 * Returns the author ID for a given post ID, defaults to the current post.
 *
 * @param null $post_id
 *
 * @return int
 */
function mapi_get_author_id($post_id = NULL) {
	if(empty($post_id)) {
		$post_id = get_the_ID();
	}
	$post = get_post($post_id);
	$author_id = (int)$post->post_author;

	/*if($author_id === 0) {

	}*/

	return $author_id;
}

/**
 *
 * Checks see if the currently logged in user is the author of the current (or given) post ID
 *
 * @param null $post_id
 *
 * @return bool
 */
function mapi_is_user_author($post_id = NULL) {
	if(!is_user_logged_in() || (get_current_user_id() !== mapi_get_author_id($post_id)) || isset($_GET['public'])) {
		return FALSE;
	} else {
		return TRUE;
	}
}

/**
 *
 * Redirect non-admin users to $redirect
 *
 * @usage:
 *
 *       mapi_redirect_non_admins(home_url('/action/profile/'));
 *
 */
function mapi_redirect_non_admins($redirect) {
	global $pagenow;

	// allow acf_form uploader past our security, this may not be the best method need to research
	if('async-upload.php' == $pagenow) {
		return;
	}
	if(is_admin() && !current_user_can('manage_options') && !(defined('DOING_AJAX') && DOING_AJAX)) {
		wp_redirect($redirect);
		exit;
	}
}

/**
 * Returns the number of published posts a given user ID.
 *
 * @param $user_id
 * @param $post_type
 *
 * @return mixed|void
 */
function mapi_get_post_count($user_id, $post_type) {
	global $wpdb;
	$where = get_posts_by_author_sql($post_type, TRUE, $user_id);
	$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts $where");

	return apply_filters('get_usernumposts', $count, $user_id);
}

/**
 * Returns a TRUE if the current page is the registration screen.
 *
 * @return bool
 */
function mapi_is_register() {
	if(in_array($GLOBALS['pagenow'], array('wp-login.php')) && (isset($_GET['action']) && $_GET['action'] == 'register')) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Returns a TRUE if the current page is the lost password screen.
 *
 * @return bool
 */
function mapi_is_password_reset() {
	if(in_array($GLOBALS['pagenow'], array('wp-login.php')) && (isset($_GET['action']) && $_GET['action'] == 'lostpassword')) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Returns a TRUE if the current page is the user profile.
 *
 * @return bool
 */
function mapi_is_profile() {
	return in_array($GLOBALS['pagenow'], array('profile.php'));
}

/**
 * Returns a TRUE if the current page is the user edit screen.
 *
 * @return bool
 */
function mapi_is_user_edit() {
	return in_array($GLOBALS['pagenow'], array('user-edit.php'));
}

/**
 * Returns true if the current query is for the login page.
 *
 * @return bool
 */
function mapi_is_login() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php'));
}

/**
 * Tests to see if a user has a given WordPress User Role.
 *
 * @param $user string|object User Id or User Object
 * @param $role string The role to test for.
 *
 * @return bool|string True on success. False or error on failure.
 */
function mapi_has_role($user, $role) {

	if(empty($role)) {
		return mapi_error(array('msg' => 'No role was specified.', 'echo' => FALSE, 'die' => FALSE));
	}

	if(!is_object($user)) {
		$user = get_userdata($user);
	}

	if(!$user || !$user->exists()) {
		return FALSE;
	}

	if(in_array($role, (array)$user->roles)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 *
 * Tests to see if the logged in user has a given WordPress User Role.
 *
 * @param $role
 *
 * @return bool|string
 */
function mapi_current_user_has_role($role) {

	if(empty($role)) {
		return mapi_error(array('msg' => 'No role was specified.', 'echo' => FALSE, 'die' => FALSE));
	}

	$user = wp_get_current_user();

	return mapi_has_role($user, $role);
}
