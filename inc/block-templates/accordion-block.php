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
  echo '<div class="' . $className . '">';


    echo '<div class="accordion" id="accordion' . $id . '">';
      foreach ($accordions as $key => $accordion) :
        echo '<div class="accordion-item">';

          echo '<h2 class="accordion-header" id="heading-' . $key . '-' . $id . '">';
            echo '<button class="accordion-button ' . ($key == 0 ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $key . '-' . $id . '" aria-expanded="' . ($key == 0 ? 'true' : 'false') . '" aria-controls="collapse' . $key . '-' . $id . '">';
              echo $accordion['accordion_header'];
            echo '</button>';
          echo '</h2>';

          echo '<div id="collapse' . $key . '-' . $id . '" class="accordion-collapse collapse ' . ($key == 0 ? 'show' : '') . '" aria-labelledby="heading' . $key . '-' . $id . '" data-bs-parent="#accordion' . $id . '">';
            echo '<div class="accordion-body">';
              echo $accordion['content'];
            echo '</div>';
          echo '</div>';

        echo '</div>';

      endforeach;
    echo '</div>';


  echo '</div>';

endif;
