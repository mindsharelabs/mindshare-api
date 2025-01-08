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
$className = 'mapi-image-grid';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$images = get_field('block_image_grid');
$crop_images = get_field('crop_images');
if($images) :
  $count = count($images);

  $classes = 'col-12 col-md-6';

  ?>
  <div class="<?php echo $className; ?> row gy-1 gx-1" data-masonry='{"percentPosition": true }' id="<?php echo $id; ?>">
    
  <?php
    foreach ($images as $key => $image) :
      echo '<div class="' . $classes . '">';
        echo '<div class="card d-flex flex-column h-100 text-center">';
  
          echo '<a href="' . $image['image']['url'] . '">';
            echo wp_get_attachment_image( $image['image']['id'], ($crop_images ? 'loop-square' : 'grid-image'), false, array('class' => 'card-image-top w-100') );
          echo '</a>';

          if(isset($image['desc'])) :
            echo '<div class="card-body p-2">';
              echo ($image['desc'] ? $image['desc'] : '');
            echo '</div>';
          endif;
        echo '</div>';
      echo '</div>';
    endforeach;
  echo '</div>';

endif;
