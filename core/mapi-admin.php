<?php
/**
 *
 * Mindshare Theme API WORDPRESS ADMIN AREA FUNCTIONS
 *
 * mapi-admin.php
 *
 * @created   4/28/14 10:46 AM
 * @author    Mindshare Studios, Inc.
 * @copyright Copyright (c) 2014
 * @link      http://www.mindsharelabs.com/documentation/
 *
 */

/**
 * Editor double line break in TinyMCE
 *
 * @usage: add_filter('tiny_mce_before_init', 'mapi_tinymce_line_breaks');
 *
 * @param $init
 *
 * @return mixed
 */
function mapi_tinymce_line_breaks($init) {
	$init["forced_root_block"] = FALSE;
	$init["force_br_newlines"] = TRUE;
	$init["force_p_newlines"] = FALSE;
	$init["convert_newlines_to_brs"] = TRUE;
	return $init;
}
