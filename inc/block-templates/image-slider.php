<?php

/**
 * Image Slider
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'image-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'image-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$images = get_field('block_image_slides');
$slide_image_size = get_field('slide_image_size');

if($images) :
  echo '<div class="' . $className . ' mb-2" id="' . $id . '">';
    echo '<div class="mapi-slider-container" data-id="' . $id . '" dots="' . (get_field('mapi_slider_dots') ? 'true' : 'false') . '" arrows="' . (get_field('mapi_slider_arrows') ? 'true' : 'false') . '">';
      foreach ($images as $key => $image) :
        echo '<div class="image-slide">';
          echo wp_get_attachment_image( $image['image']['id'], $slide_image_size, array('class' => 'slide-image w-100') );
          echo '<div class="caption text-center">';
            echo $image['caption'];
          echo '</div>';
        echo '</div>';
      endforeach;

    echo '</div>';


    echo '<div class="slide-nav">';
      echo '<div class="buttons">';
        echo (get_field('mapi_slider_arrows') ? '<div class="interaction mapi-slide-prev"><i class="fas fa-angle-left"></i></div>' : '');
        echo (get_field('mapi_slider_dots') ? '<div class="interaction mapi-slide-dots"></div>' : '');
        echo (get_field('mapi_slider_arrows') ? '<div class="interaction mapi-slide-next"><i class="fas fa-angle-right"></i></div>' : '');
      echo '</div>';
    echo '</div>';

  echo '</div>';

endif;
