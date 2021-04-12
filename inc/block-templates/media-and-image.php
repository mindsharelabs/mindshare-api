<?php

/**
 * Image and Content
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'image-and-content-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'media-and-image-edge';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$image_and_content = get_field('image_and_content');


if($image_and_content) :
  echo '<div class="' . $className . '" id=" ' .  $id .'">';
    echo '<div class="image-edge-grid">';
      echo '<div class="image-edge-grid__content">';
        echo $image_and_content['content'];
      echo '</div>';
      echo '<div class="image-edge-grid__img">';
        echo wp_get_attachment_image( $image_and_content['image']['id'], 'vertical-media-image', false, array('class' => 'w-100') );
      echo '</div>';

    echo '</div>';
  echo '</div>';

endif;
