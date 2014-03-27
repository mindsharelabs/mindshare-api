<?php
/**
 * mapi-credits.php
 *
 * @created   5/1/13 9:54 PM
 * @author    Mindshare Studios, Inc.
 * @copyright Copyright (c) 2014
 * @link      http://mindsharelabs.com/downloads/mindshare-theme-api/
 *
 */


function mapi_credits() {

	$credits = '

  ______   __  __     ______     __   __     __  __     ______
 /\__  _\ /\ \_\ \   /\  __ \   /\ "-.\ \   /\ \/ /    /\  ___\
 \/_/\ \/ \ \  __ \  \ \  __ \  \ \ \-.  \  \ \  _"-.  \ \___  \
    \ \_\  \ \_\ \_\  \ \_\ \_\  \ \_\\\\"\_\  \ \_\ \_\  \/\_____\
     \/_/   \/_/\/_/   \/_/\/_/   \/_/ \/_/   \/_/\/_/   \/_____/

	WordPress, http://wordpress.org
	jQuery, http://jquery.com
	Twitter Bootstrap, http://twbs.github.io/bootstrap/
	Mindshare Studios, Inc., http://mind.sh/are/
	ANAGR.AM, http://anagr.am/
	Damian Taggart, http://damiantaggart.com/
	Bryce Corkins, http://brycecorkins.com/
	Geet Jacobs, http://www.geetdesign.com/
	Abid Omar, http://goo.gl/tUpSc
	Ohad Raz, http://goo.gl/A0jcdk
	Steven Vachon, http://goo.gl/ib95K9
	Jutin Tadlock, http://goo.gl/2z4K6
	Mark James, http://goo.gl/UH9DVe
	PHP Labware, http://goo.gl/OHgmij

	and many others!
';

	mapi_delete_option('credits'); // required to prevent storing this HTML to the DB

	return $credits;

}

add_action('admin_head', 'credits_css');
function credits_css() {
	?>
	<style type="text/css">
		textarea#credits {
			font-family: Consolas, 'Courier New', Courier, monospace;
			font-size: 14px;
			width: 600px;
			height: 500px;
			background-color: #f9f9f9;
			margin-top: 15px;
		}
	</style>
<?php
}
