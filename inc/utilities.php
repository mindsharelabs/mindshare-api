<?php

if (function_exists('add_image_size')) {
  add_image_size( 'loop-square', 350, 350, array('center', 'center'));
  add_image_size( 'loop-thumbnail', 350, 150, array('center', 'center'));
  add_image_size( 'loop-list-thumbnail', 350, 250, array('center', 'center'));
  add_image_size( 'vertical-media-image', 400, 490, array('center', 'center'));
  add_image_size( 'horizontal-media-image', 500, 400, array('center', 'center'));
}



add_filter( 'render_block', 'mapi_block_wrapper', 10, 2 );
function mapi_block_wrapper( $block_content, $block ) {
  $noWrapper = array(
    'acf/map-w-marker',
    'core/cover',
    'core/button',
    'acf/container',
    'acf/image-and-content'
  );
  if(!in_array($block['blockName'], $noWrapper) && $block['blockName']) :
    $content = '<div class="container">';
      $content .= '<div class="row">';
        $content .= '<div class="col-12">';
          $content .= $block_content;
        $content .= '</div>';
      $content .= '</div>';
    $content .= '</div>';
  else :
    return $block_content;
  endif;
  return $content;
}

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
