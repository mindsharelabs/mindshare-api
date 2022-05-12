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
$id = 'image-grid-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'image-grid';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$images = get_field('block_image_grid');
if($images) :
  $count = count($images);

  if($count == 1) :
    $classes = 'col-12';
  elseif($count == 2) :
    $classes = 'col-12 col-md-6';
  elseif($count % 3 == 0) :
    $classes = 'col-12 col-md-4';
  elseif($count % 4 == 0) :
    $classes = 'col-12 col-md-3';
  else :
    $classes = 'col-12 col-md-3';
  endif;

  echo '<div class="' . $className . ' row" id="' . $id . '">';
    foreach ($images as $key => $image) :
      echo '<div class="' . $classes . '">';
        echo '<div class="card d-flex flex-column h-100 text-center">';

          echo ($image['link'] ? '<a href="' . $image['link']['url'] . '">' : '');
            echo wp_get_attachment_image( $image['image']['id'], 'grid-image',false, array('class' => 'card-image-top w-100') );
          echo ($image['link'] ? '</a>' : '');

          if($image['title'] || $image['desc']) :
            echo '<div class="card-body p-2">';
              echo ($image['link'] ? '<a href="' . $image['link']['url'] . '">' : '');
              echo ($image['title'] ? '<h3>' . $image['title'] . '</h3>' : '');
              echo ($image['link'] ? '</a>' : '');
              echo ($image['desc'] ? $image['desc'] : '');
            echo '</div>';
          endif;
        echo '</div>';
      echo '</div>';
    endforeach;
  echo '</div>';

endif;
