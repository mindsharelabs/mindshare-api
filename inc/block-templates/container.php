<?php

/**
 * Container Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'container-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// This block has no align control (supports.align is false in the block
// registration) — it must always render full-bleed, so "alignfull" is
// added unconditionally rather than mirrored from $block['align'].
$className = 'container-block alignfull';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// Load values and assing defaults.
$container_options = get_field('container_options');

if(!$container_options) :
  $container_options['width'] = 12;
endif;

if($container_options['width'] != 12) :
  $offset = (12 - $container_options['width']) / 2;
else :
  $offset = 0;
endif;

if(!isset($container_options['background_color'])) :
  $container_options['background_color'] = '#fff';
endif;

if($container_options) :
  // Note: no Bootstrap "w-100" here — its "width: 100% !important" would
  // override alignfull's "width: auto" and fight the negative-margin
  // breakout, leaving the background narrower than the viewport.
  echo '<div class="' . $className . '" style="' . ($is_preview ? 'padding:10px;' : '') . 'background-color:' . $container_options['background_color'] . ';">';
    echo '<div class="container" id="' . $id . '">';
      echo '<div class="row">';
        echo '<div class="block-content col-12 py-2 offset-0 offset-md-' . $offset . ' col-md-' . $container_options['width'] . '">';
          echo '<InnerBlocks  />';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';

endif;
