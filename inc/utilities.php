<?php

if (function_exists('add_image_size')) {
  add_image_size( 'loop-square', 350, 350, array('center', 'center'));
  add_image_size( 'loop-thumbnail', 350, 150, array('center', 'center'));
  add_image_size( 'loop-list-thumbnail', 350, 250, array('center', 'center'));
  add_image_size( 'vertical-media-image', 400, 490, array('center', 'center'));
  add_image_size( 'horizontal-media-image', 500, 400, array('center', 'center'));
  add_image_size( 'slide-image', 1100, 400, array('center', 'center'));
	add_image_size( 'grid-image', 400, 400, array('center', 'center'));
}


//


if(!function_exists('mapi_var_dump')) {
  function mapi_var_dump($var) {
    if (current_user_can('administrator') && isset($var)) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
  }
}

if(!function_exists('mapi_write_log')) {
	function mapi_write_log($message) {
	    if ( WP_DEBUG === true ) {
	        if ( is_array($message) || is_object($message) ) {
	            error_log( print_r($message, true) );
	        } else {
	            error_log( $message );
	        }
	    }
	}
}

add_action('after_setup_theme', function () {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
});



add_filter( 'mapi_block_wrappers', function($noWrapper) {
  $noWrapper[] = 'acf/image-slider';
  return $noWrapper;
}, 10, 1 );

function mapi_get_regisered_size_options() {
	$included_sizes = wp_get_registered_image_subsizes();
  $sizes = array();
  if($included_sizes) :
  	foreach ($included_sizes as $key => $size) :
      $sizes[$key] = ucwords(str_replace ('-', ' ', $key)) . ' ' . $size['width'] . ' x ' . $size['height'];
    endforeach;
  endif;
  return $sizes;
}
