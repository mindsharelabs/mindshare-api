<?php
/**
 * This file is used to return a random image from a specified directory
 * use the wrapper function mapi_random_img in mapi-attachment.php instead
 * of calling this file directly.
 *
 * @link https://mindsharelabs.com/documentation/mapi_random_img/
 *
 * @todo add in additional headers? ... header('Content-Type: image/gif');
 *
 */

if(isset($_GET['exts'])) {
	$exts = $_GET['exts'];
} else {
	$exts = 'jpg,jpeg,png,gif';
}

if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
} else {
	$dir = './';
}

if(isset($_GET['path'])) {
	$path = $_GET['path'];
} else {
	$path = dirname(__FILE__); // @todo needs testing
}

$files = array();
$i = -1;
$handle = opendir($path);
$exts = explode(',', $exts);
while(FALSE !== ($file = readdir($handle))) {
	foreach($exts as $ext) {
		if(preg_match('/\.'.$ext.'$/i', $file, $test)) {
			$files[] = $file;
			++$i;
		}
	}
}
closedir($handle);
mt_srand((double) microtime() * 1000000); // seed for PHP < 4.2
$rand = mt_rand(0, $i);
header('Location: '.$dir.$files[$rand]);
