<?php
/**
 * mapi-email.php
 *
 * @created   4/27/15 4:43 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/
 */

/**
 * Allows overriding the default from email for WordPress messages (new user registration. etc.)
 *
 * @param $email_old
 *
 * @return mixed|void
 */
function mapi_change_default_email($email_old) {
	$email_new = apply_filters('mapi_default_email', 'no-reply@' . mapi_extract_domain(home_url()));
	if (is_email($email_new)) {
		return $email_new;
	} else {
		return $email_old;
	}
}

/**
 * Allows overriding the default from name for WordPress email messages.
 * Default: get_bloginfo('name')
 *
 * @param $from_name
 *
 * @return mixed
 */
function mapi_change_default_email_name($from_name) {

	$from_name_new = apply_filters('mapi_default_email_name', get_bloginfo('name'));
	$from_name_new = trim($from_name_new);

	if (!empty($from_name_new)) {
		return $from_name_new;
	} else {
		return $from_name;
	}
}
