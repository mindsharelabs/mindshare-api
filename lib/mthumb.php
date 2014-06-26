<?php
// @todo figure out why loading WP and the config isn't working
//define('WP_USE_THEMES', FALSE);
//require('../../../../wp-load.php');

//define ('DEBUG_ON', FALSE);
//define ('DEBUG_LEVEL', 3);
//mapi_mthumb_config();

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
	'mindsharestudios.com'
);
define('ALLOW_EXTERNAL', TRUE);

// Caching
define('FILE_CACHE_DIRECTORY', '../../../uploads/cache/');
//define('FILE_CACHE_DIRECTORY',''); // leave blank for system directory
define('FILE_CACHE_TIME_BETWEEN_CLEANS', 172800); // 2 days
define('BROWSER_CACHE_MAX_AGE', 1728000); // 20 days

require('mthumb/mthumb.php');

