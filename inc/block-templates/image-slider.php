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
if($images) :
  echo '<div class="' . $className . ' mb-2" id="' . $id . '">';
    foreach ($images as $key => $image) :
      echo '<div class="image-slide">';
        echo wp_get_attachment_image( $image['image']['id'], 'slide-image', array('class' => 'slide-image') );
        echo '<div class="caption text-center">';
          echo $image['caption'];
        echo '</div>';
      echo '</div>';
    endforeach;
  echo '</div>';

endif;
