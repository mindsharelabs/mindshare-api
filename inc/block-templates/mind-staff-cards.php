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
$id = 'mind-staff-cards-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-staff-cards';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$mind_staff_cards = get_field('mind_staff_cards');
if($mind_staff_cards['staff_cards']) :
  echo '<div class="' . $className . '" id="accordion' . $id . '">';
    echo '<div class="row justify-content-start">';
      foreach ($mind_staff_cards['staff_cards'] as $key => $card) :
        $card_classes = apply_filters('mind_staff_card_classes', 'col-12 col-md-6 col-lg-4 d-flex flex-column h-100 justify-content-between', $card);
        echo '<div class="' . $card_classes . '">';
            if($card['image']) :
              $classes = apply_filters('mind_staff_cards_image_classes', 'rounded-circle card-img-top', $card);
              $image_size = apply_filters( 'mind_staff_cards_image_size', 'grid-image', $card );

              if($card['staff_page_link']) :
                echo '<a href="' . $card['staff_page_link']['url'] . '" target="' . $card['staff_page_link']['target'] . '">';
              endif;
                echo wp_get_attachment_image( $card['image']['id'], $image_size, false, array('class'=> $classes) );
              if($card['staff_page_link']) :
                echo '</a>';
              endif;

            endif;

            $card_body_classes = apply_filters('mind_staff_card_body_classes', 'card_body', $card);
            echo '<div class="' . $card_body_classes . '">';
              if($card['staff_page_link']) :
                echo '<a href="' . $card['staff_page_link']['url'] . '" target="' . $card['staff_page_link']['target'] . '">';
              endif;


              $card_title_classes = apply_filters('mind_staff_card_title_classes', 'staff-name text-center mb-1');
              echo ($card['name'] ? '<h3 class="' . $card_title_classes .'">' . $card['name'] . '</h3>' : '');
              if($card['staff_page_link']) :
                echo '</a>';
              endif;
              echo ($card['title'] ? '<span class="staff-title text-center">' . $card['title'] . '</span>' : '');

              if($card['staff_links']) :
                echo '<div class="d-flex flex-row justify-content-center my-1">';
                  foreach ($card['staff_links'] as $key => $s_link) :
                    echo '<a class="p-2" href="' . $s_link['link']['url'] . '" target="' . $s_link['link']['target'] . '" title="' . $s_link['link']['title'] . '">';
                      echo '<i class="fa-lg ' . $s_link['icon'] . '"></i>';
                    echo '</a>';
                  endforeach;
                echo '</div>';
              endif;
              if($card['short_bio']) :
                echo '<div class="staff-bio">';
                  echo $card['short_bio'];
                echo '</div>';
              endif;
            echo '</div>';


        echo '</div>';

      endforeach;
    echo '</div>';
  echo '</div>';

endif;
