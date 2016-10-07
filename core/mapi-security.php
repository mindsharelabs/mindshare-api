<?php
/**
 * Mindshare Theme API SECURITY & WORDPRESS USER FUNCTIONS
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-social.php
 * @since      File available since Rev 72
 */

/**
 * Puts the site offline for logged out users. Offline message
 * and user role required to view the site are both configurable.
 * To bypass maintenance mode and enable a specific page to be viewed while logged out
 * append any site URL with <code>?maintenance=bypass</code>.
 * You can also bypass maintenance mode from within wp-config.php like so:
 * <code>define('MAPI_MAINTENANCE_MODE_BYPASS', TRUE);</code>
 *
 * @param bool   $enabled
 * @param string $role
 * @param string $reason
 * @param string $css
 * @param bool   $use_503
 */
function mapi_maintenance_mode($enabled = FALSE, $role = 'Subscriber', $reason = '', $css = '', $use_503 = FALSE) {
	$bypass_key = apply_filters('mapi_maintenance_mode_bypass_key', 'bypass');
	if ((isset($_GET[ 'maintenance' ]) && $_GET[ 'maintenance' ] == $bypass_key)) {
		$enabled = FALSE;
	}
	if (defined('MAPI_MAINTENANCE_MODE_BYPASS') && MAPI_MAINTENANCE_MODE_BYPASS == TRUE) {
		$enabled = FALSE;
	}
	if (empty($css)) {
		require_once(MAPI_DIR_PATH . 'views/mapi-maintenance-mode-css.php');
		$css = $maintenance_mode_css;
	}
	$reason = stripslashes($reason);
	if (empty($reason)) {
		$reason = 'We\'re sorry, ' . get_bloginfo('name') . ' is currently undergoing scheduled maintenance.<br /><br /> We\'ll be back online shortly.';
	}
	if ($enabled) {
		if (!current_user_can(mapi_role_to_capability($role))) {
			if ($use_503 === TRUE && locate_template('503.php')) {
				// load the 503 template if it exists and the user has enabled it
				locate_template('503.php', TRUE, TRUE);
				die;
			} else {
				?>
				<!DOCTYPE HTML>
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title><?php bloginfo('name') ?> is temporarily offline for scheduled maintenance</title>
					<link href="https://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
					<style type="text/css">
						<?php echo stripslashes_deep($css); ?>
					</style>
					<?php
					$analytics = mapi_get_option('enable_adv_ga_options');
					if (mapi_is_true(@$analytics[ 'enabled' ])) {
						mapi_analytics();
					}
					?>
				</head>
				<body>
				<div id="content">
					<?php
					do_action('mapi_maintenance_mode_before');
					echo $reason;
					do_action('mapi_maintenance_mode_after');
					?>
				</div>
				</body>
				</html>
				<?php
				die;
			}
		} else {
			mapi_error(array('msg' => 'Maintenance mode is enabled.', 'echo' => FALSE, 'die' => FALSE));
		}
	}
}

/**
 * Takes a user Role and returns a Capability unique to that Role. Works with default WordPress roles only.
 *
 * @see    http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table
 *
 * @param $role (string)
 *
 * @return (string)
 */
function mapi_role_to_capability($role) {
	$roles = array(
		'Super Admin'   => 'manage_network',
		'Administrator' => 'edit_theme_options',
		'Editor'        => 'edit_others_posts',
		'Author'        => 'publish_posts',
		'Contributor'   => 'edit_posts',
		'Subscriber'    => 'read',
	);
	if (array_key_exists($role, $roles)) {
		return $roles[ $role ];
	} else {
		return $roles[ 'Subscriber' ];
		//return mapi_error(array('msg' => $role.' is not a default WordPress user Role.', 'echo' => FALSE, 'die' => FALSE));
	}
}

/**
 * Cleanup the_content output with htmLawed. Fully configurable by
 * adding a file called 'htmlawed-config.php' to the theme directory.
 * By default this will remove DIV tags and STYLE or ALIGN attributes,
 * see htmLawed docs for help and other options http://goo.gl/OHgmij
 * Only applied when enabled via Developer Settings > WordPress Tweaks >
 * Cleanup HTML tags in the_content before output
 *
 * @link http://goo.gl/OHgmij
 *
 * @param $content
 *
 * @return mixed|void
 */
function mapi_html_cleanup($content) {
	require_once(MAPI_DIR_PATH . 'lib/htmLawed/htmLawed.php');

	if (file_exists(get_template_directory() . '/htmlawed-config.php')) {
		include(get_template_directory() . '/htmlawed-config.php');
	} else {
		// add bootstrap classes in place of inline styles
		//$content = str_ireplace('style="text-align: right;"', 'class="pull-right"', $content);
		//$content = str_ireplace('style="text-align: left;"', 'class="pull-left"', $content);

		$content = htmLawed($content, array('elements' => '* -div', 'deny_attribute' => 'style, align'));

		// remove all empty p tags, even those with $nbsp;, <br>, etc.
		$content = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $content);
	}

	return apply_filters('mapi_html_clean', $content);
}

/**
 * Searches for plain email addresses in given $string and
 * encodes them (by default) with the help of mapi_encode_str().
 * Regular expression is based on based on John Gruber's Markdown.
 * http://daringfireball.net/projects/markdown/
 *
 * @param string $string Text with email addresses to encode
 *
 * @return string $string Given text with encoded email addresses
 */
function mapi_encode_emails($string) {

	// abort if $string doesn't contain a @-sign
	if (apply_filters('mapi_at_sign_check', TRUE)) {
		if (strpos($string, '@') === FALSE) {
			return $string;
		}
	}

	// override encoding function with the 'mapi_method' filter
	$method = apply_filters('mapi_method', 'mapi_encode_str');

	// override regex pattern with the 'mapi_regexp' filter
	$regexp = apply_filters(
		'mapi_regexp',
		'{
			(?:mailto:)?
			(?:
				[-!#$%&*+/=?^_`.{|}~\w\x80-\xFF]+
			|
				".*?"
			)
			\@
			(?:
				[-a-z0-9\x80-\xFF]+(\.[-a-z0-9\x80-\xFF]+)*\.[a-z]+
			|
				\[[\d.a-fA-F:]+\]
			)
		}xi'
	);

	return preg_replace_callback(
		$regexp,
		create_function(
			'$matches',
			'return ' . $method . '($matches[0]);'
		),
		$string
	);
}

/**
 * Encodes each character of the given string as either a decimal
 * or hexadecimal entity, in the hopes of foiling most email address
 * harvesting bots.
 * Based on Michel Fortin's PHP Markdown:
 *   http://michelf.com/projects/php-markdown/
 * Which is based on John Gruber's original Markdown:
 *   http://daringfireball.net/projects/markdown/
 * Whose code is based on a filter by Matthew Wickline, posted to
 * the BBEdit-Talk with some optimizations by Milian Wolff.
 *
 * @param string $string Text with email addresses to encode
 *
 * @return string $string Given text with encoded email addresses
 */
function mapi_encode_str($string) {

	$chars = str_split($string);
	$seed = mt_rand(0, (int) abs(crc32($string) / strlen($string)));

	foreach ($chars as $key => $char) {

		$ord = ord($char);

		if ($ord < 128) { // ignore non-ascii chars

			$r = ($seed * (1 + $key)) % 100; // pseudo "random function"

			if ($r > 60 && $char != '@') {
				;
			} // plain character (not encoded), if not @-sign
			else {
				if ($r < 45) {
					$chars[ $key ] = '&#x' . dechex($ord) . ';';
				} // hexadecimal
				else {
					$chars[ $key ] = '&#' . $ord . ';';
				}
			} // decimal (ascii)

		}
	}

	return implode('', $chars);
}
