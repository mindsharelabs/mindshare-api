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
$id = 'card-repeater-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'card-repeater-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$block_card_repeater = get_field('block_card_repeater');
if($block_card_repeater) :
  echo '<div class="' . $className . '" id="accordion' . $id . '">';
    echo '<div class="row">';
      foreach ($block_card_repeater['cards'] as $key => $card) :
        echo '<div class="col-12 col-md-4">';
          echo '<div class="card d-flex flex-column h-100 justify-content-between">';

            echo wp_get_attachment_image( $card['card_image']['id'], 'loop-thumbnail', false, array('class'=> 'card-img-top') );
            if($card['card_header']) :
              echo '<div class="card-header">';
                echo '<h4>' . $card['card_header'] . '</h4>';
              echo '</div>';
            endif;
            if($card['card_body']) :
              echo '<div class="card-body">';
                echo $card['card_body'];
              echo '</div>';
            endif;
            if($card['card_link']['url']) :
              echo '<div class="card-footer">';
                echo '<a href="' . $card['card_link']['url'] . '" target="' . $card['card_link']['target'] . '">' . $card['card_link']['title'] . '</a>';
              echo '</div>';
            endif;



          echo '</div>';
        echo '</div>';

      endforeach;
    echo '</div>';
  echo '</div>';

endif;
