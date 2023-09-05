<?php

/**
 * Map w/ Marker
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'map-w-marker-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'map-w-marker';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}



echo '<script> var locations = []; </script>';

// Load values and assing defaults.
$map_w_marker = get_field('map_w_marker');
if($map_w_marker['map_w_marker_locations']) :
  echo '<div class="acf-map ' . $className . '" id="' . $id . '" data-zoom="16"></div>';
    // Load sub field values.
  echo '<script>';
    foreach($map_w_marker['map_w_marker_locations'] as $location) :
      if($location['latitude'] && $location['longitude']) :

          echo 'var newItem = {
            lat: ' . (float)esc_attr($location['latitude']) . ',
            lng: ' . (float)esc_attr($location['longitude']) . ',
          };';

          echo 'locations.push(newItem);';
      endif;
    endforeach;
  echo '</script>';

endif;
