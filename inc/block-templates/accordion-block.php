<?php

/**
 * Accordion Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'accordion-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'accordion-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$accordions = get_field('accordions');
if($accordions) :
  echo '<div class="' . $className . '" id="accordion' . $id . '">';
    foreach ($accordions as $key => $accordion) :
      echo '<div class="accordion-item">';

        echo '<h2 class="accordion-header" id="heading- ' . $key . ' ">';
          echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            echo $accordion['accordion_header'];
          echo '</button>';
        echo '</div>';

        echo '<div id="collapse' . $key . '" class="accordion-collapse collapse" aria-labelledby="heading' . $key . '" data-parent="#accordion' . $id . '">';
          echo '<div class="accordion-body">';
            echo $accordion['content'];
          echo '</div>';
        echo '</div>';

    endforeach;
  echo '</div>';

endif;
