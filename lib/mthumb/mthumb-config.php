<?php
/**
 * mthumb-config.php
 *
 * Example mThumb configuration file.
 *
 * @created   4/2/14 11:52 AM
 * @author    Mindshare Studios, Inc.
 * @copyright Copyright (c) 2006-2015
 * @link      http://www.mindsharelabs.com/documentation/
 *
 */

$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../../../../'); // tilde support for mthumb, in default WP install this should result in the same value as ABSPATH
//var_dump($_SERVER['DOCUMENT_ROOT']); die;

global $ALLOWED_SITES;

// Max sizes
if(!defined('MAX_WIDTH')) {
	define('MAX_WIDTH', 3600);
}
if(!defined('MAX_HEIGHT')) {
	define('MAX_HEIGHT', 3600);
}
if(!defined('MAX_FILE_SIZE')) {
	define ('MAX_FILE_SIZE', 20971520); // 20MB
}
// External Sites
$ALLOWED_SITES = array(
	'flickr.com',
	'staticflickr.com',
	'picasa.com',
	'img.youtube.com',
	'upload.wikimedia.org',
	'photobucket.com',
	'imgur.com',
	'imageshack.us',
	'tinypic.com',
	'mind.sh',
	'mindsharelabs.com',
	'mindsharestudios.com'
);

