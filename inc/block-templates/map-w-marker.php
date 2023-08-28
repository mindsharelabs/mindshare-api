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

// Load values and assing defaults.
$map_w_marker = get_field('map_w_marker');

if($map_w_marker['map_w_marker_locations']) :
  echo '<div class="acf-map ' . $className . '" id="' . $id . '" data-zoom="16">';
    // Load sub field values.
    foreach($map_w_marker['map_w_marker_locations'] as $location) :
      echo '<div class="marker" data-lat="' . esc_attr($location['latitude']) . '" data-lng="' . esc_attr($location['longitude']) . '">';
      echo '</div>';
      endforeach;
  echo '</div>';
endif;
