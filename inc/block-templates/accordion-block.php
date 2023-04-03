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
$first_open = get_field('mapi_first_accordion_open');

if($accordions) :
  echo '<div class="' . $className . '">';


    echo '<div class="accordion" id="accordion' . $id . '">';
      foreach ($accordions as $key => $accordion) :

        $open = ($key == 0 ? $first_open : false);

        echo '<div class="accordion-item">';

          echo '<h2 class="accordion-header mt-0 mb-0" id="heading-' . $key . '-' . $id . '">';
            echo '<button class="accordion-button text-start ' . ($open ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $key . '-' . $id . '" aria-expanded="' . ($open ? 'true' : 'false') . '" aria-controls="collapse' . $key . '-' . $id . '">';
              echo (isset($accordion['accordion_header']) ? $accordion['accordion_header'] : 'Accordion ' . $key);
            echo '</button>';
          echo '</h2>';

          echo '<div id="collapse' . $key . '-' . $id . '" class="accordion-collapse collapse ' . ($open ? 'show' : '') . '" aria-labelledby="heading' . $key . '-' . $id . '" data-bs-parent="#accordion' . $id . '">';
            echo '<div class="accordion-body">';
              echo (isset($accordion['content']) ? $accordion['content'] : '');
            echo '</div>';
          echo '</div>';

        echo '</div>';

      endforeach;
    echo '</div>';


  echo '</div>';

endif;
