<?php

/**
 * Logo Slider
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'mind-logo-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-logo-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$mind_logo_slides = get_field('mind_logo_slides');

if($mind_logo_slides['images']) :

  echo '<div class="' . $className . ' mb-2" id="' . $id . '">';
    echo '<div class="mapi-slider-container" data-id="' . $id . '">';
      foreach ($mind_logo_slides['images'] as $key => $image) :
        echo '<div class="image-slide h-100">';
          echo (isset($image['link']['url']) ? '<a href="' . $image['link']['url'] . '" title="' . $image['link']['title'] . '" target="_blank">' : '');
            echo wp_get_attachment_image( $image['image']['id'], 'thumbnail', array('class' => 'slide-image w-100') );
          echo (isset($image['link']['url']) ? '</a>' : '');
          echo '<div class="caption text-center">';
            echo $image['caption'];
          echo '</div>';
        echo '</div>';
      endforeach;

    echo '</div>';

    echo '<div class="slide-nav">';
      echo '<div class="buttons">';
        echo '<div class="interaction mapi-slide-prev"><i class="fas fa-angle-left"></i></div>';
        echo '<div class="interaction mapi-slide-dots"></div>';
        echo '<div class="interaction mapi-slide-next"><i class="fas fa-angle-right"></i></div>';
      echo '</div>';
    echo '</div>';

  echo '</div>';

endif;
