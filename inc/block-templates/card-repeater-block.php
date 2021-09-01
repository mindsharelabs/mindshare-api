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
$num_columns = $block_card_repeater['num_columns'];
if($block_card_repeater) :
  echo '<div class="' . $className . '" id="accordion' . $id . '">';
    echo '<div class="row">';
      foreach ($block_card_repeater['cards'] as $key => $card) :

        if($num_columns == 'one') :
          $class = 'col-12 col-lg-12';
        elseif($num_columns == 'two') :
          $class = 'col-12 col-lg-6';
        elseif($num_columns == 'three') :
          $class = 'col-12 col-lg-4';
        elseif($num_columns == 'four') :
          $class = 'col-12 col-lg-3';
        elseif($num_columns == 'six') :
          $class = 'col-12 col-lg-2';
        elseif($num_columns == 'twelve') :
          $class = 'col-12 col-lg-1';
        else :
          $class = 'col-12 col-lg';
        endif;

        echo '<div class="col-12 mb-4 ' . $class . '">';
          echo '<div class="card d-flex flex-column h-100 justify-content-between">';

            if($card['card_image']) :
              if($card['card_link']) :
                echo '<a href="' . $card['card_link']['url'] . '" target="' . $card['card_link']['target'] . '">';
              endif;
              echo wp_get_attachment_image( $card['card_image']['id'], 'loop-thumbnail', false, array('class'=> 'card-img-top') );
              if($card['card_link']) :
                echo '</a>';
              endif;
            endif;
            if($card['card_header']) :
              echo '<div class="card-header">';
                if($card['card_link']) :
                  echo '<a href="' . $card['card_link']['url'] . '" target="' . $card['card_link']['target'] . '">';
                endif;
                  echo '<h4>' . $card['card_header'] . '</h4>';
                if($card['card_link']) :
                  echo '</a>';
                endif;
              echo '</div>';
            endif;
            if($card['card_body']) :
              echo '<div class="card-body">';
                echo $card['card_body'];
              echo '</div>';
            endif;
            if($card['card_link']) :
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
