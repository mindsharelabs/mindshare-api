<?php
/**
 * mapi-theme.php
 * 
 * @created 3/21/14 2:54 PM
 * @author Mindshare Studios, Inc.
 * @copyright Copyright (c) 2014
 * @link http://www.mindsharelabs.com/documentation/
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
				echo base64_decode($c);
			}
		}
	}
	mapi_toggle_html_compression();
}
