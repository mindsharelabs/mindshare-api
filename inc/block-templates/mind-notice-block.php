<?php

/**
 * Mind Notice Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'mind-notice-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-notice-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$mind_notice_block = get_field('mind_notice_block');
if($mind_notice_block['notice_content']) :
  echo '<div class="' . $className . '" id="accordion' . $id . '">';
    echo '<div class="alert alert-' . $mind_notice_block['notice_type'] . ' d-flex align-items-start" role="alert">';
      if($mind_notice_block['notice_icon']) :
        echo '<i class="' . $mind_notice_block['notice_icon'] . ' pe-4 fa-lg"></i>';
      endif;
      echo '<div ' . ($mind_notice_block['notice_icon'] ? '' : 'class="w-100"') . '>';
        echo $mind_notice_block['notice_content'];
      echo '</div>';
    echo '</div>';
  echo '</div>';

endif;
