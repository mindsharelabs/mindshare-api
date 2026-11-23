<?php

/**
 * Card Repeater Block
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

// Card title heading. The level comes from the block's "Heading Level" setting,
// or the mapi_card_repeater_heading_tag filter when it's left on "Default", so
// sites can fit the cards into their page's heading outline. The classes come
// from mapi_card_repeater_heading_class, which keeps the look independent of
// the level (e.g. an <h3> styled like an h4 with class "h4").
$allowed_heading_tags = array('h2', 'h3', 'h4', 'h5', 'h6');
$heading_level = isset($block_card_repeater['heading_level']) ? $block_card_repeater['heading_level'] : 'default';
$heading_tag = in_array($heading_level, $allowed_heading_tags, true)
  ? $heading_level
  : apply_filters('mapi_card_repeater_heading_tag', 'h2', $block);
if (!in_array($heading_tag, $allowed_heading_tags, true)) {
  $heading_tag = 'h2';
}
$heading_class = apply_filters('mapi_card_repeater_heading_class', 'mb-2 mt-1 text-center', $heading_tag, $block);

if($block_card_repeater) :
  echo '<div class="' . $className . '" id="' . $id . '">';
    echo '<div class="row">';
      foreach ($block_card_repeater['cards'] as $key => $card) :

        if($num_columns == 'one') :
          $class = 'col-12';
        elseif($num_columns == 'two') :
          $class = 'col-12 col-md-6 col-lg-6';
        elseif($num_columns == 'three') :
          $class = 'col-12 col-md-6 col-lg-4';
        elseif($num_columns == 'four') :
          $class = 'col-12 col-md-3 col-lg-3';
        elseif($num_columns == 'six') :
          $class = 'col-12 col-md-4 col-lg-2';
        elseif($num_columns == 'twelve') :
          $class = 'col-12 col-lg-1';
        else :
          $class = 'col-12 col-lg';
        endif;

        echo '<div class="col-12 mb-4 ' . $class . '">';
          echo '<div class="card d-flex flex-column h-100 justify-content-start">';

            if($card['card_image']) :
              if($card['card_link']) :
                echo '<a href="' . $card['card_link']['url'] . '" target="' . $card['card_link']['target'] . '">';
              endif;
              echo wp_get_attachment_image( $card['card_image']['id'], 'horizontal-media-image', false, array('class'=> 'card-img-top w-100') );
              if($card['card_link']) :
                echo '</a>';
              endif;
            endif;

            if($card['card_header'] || $card['card_body']) :
              echo '<div class="card-body">';
                if($card['card_header']) :

                  if($card['card_link']) :
                    echo '<a href="' . $card['card_link']['url'] . '" target="' . $card['card_link']['target'] . '">';
                  endif;
                    echo '<' . $heading_tag . ' class="' . esc_attr($heading_class) . '">' . $card['card_header'] . '</' . $heading_tag . '>';
                  if($card['card_link']) :
                    echo '</a>';
                  endif;

                endif;
                if($card['card_body']) :
                  echo $card['card_body'];
                endif;
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
