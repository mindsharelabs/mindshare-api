<?php

/**
 * Staff Cards
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
  echo '<div class="' . $className . '" id="' . $id . '">';
    echo '<div class="row justify-content-start gy-3">';
      foreach ($mind_staff_cards['staff_cards'] as $key => $card) :
        $card_classes = apply_filters('mind_staff_card_classes', 'col-12 col-md-6 col-lg-4 d-flex flex-column h-100 justify-content-between', $card, $mind_staff_cards['staff_cards']);
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

            $card_body_classes = apply_filters('mind_staff_card_body_classes', 'card-body', $card);
            echo '<div class="' . $card_body_classes . '">';
              if($card['staff_page_link']) :
                echo '<a href="' . $card['staff_page_link']['url'] . '" target="' . $card['staff_page_link']['target'] . '">';
              endif;


              $card_title_classes = apply_filters('mind_staff_card_title_classes', 'staff-name text-center mb-1');
              echo ($card['name'] ? '<h3 class="' . $card_title_classes .' notranslate">' . $card['name'] . '</h3>' : '');
              if($card['staff_page_link']) :
                echo '</a>';
              endif;
              echo ($card['title'] ? '<span class="staff-title d-block">' . $card['title'] . '</span>' : '');


              $show_link_button = apply_filters('mind_staff_card_show_link_button', true, $card);

              if($card['staff_links'] && $show_link_button) :

                $staff_link_classes = apply_filters('mind_staff_card_link_classes', 'd-flex flex-row justify-content-center my-1 card-links', $card);
                echo '<div class="' . $staff_link_classes . '">';
                  foreach ($card['staff_links'] as $key => $s_link) :

                    echo (isset($s_link['label']) ?  '<span class="label">' . $s_link['label'] . '</span>': '');
                    echo '<a 
                      href="' . (isset($s_link['link']['url']) ? $s_link['link']['url'] : '') . '"
                      target="' . (isset($s_link['link']['target']) ? $s_link['link']['target'] : '') . '"
                      title="' . (isset($s_link['link']['title']) ? $s_link['link']['title'] : '') . '">';

                     
                      echo '<span class="link-title">' . (isset($s_link['link']['title']) ? $s_link['link']['title'] : '') . '</span>';

                    echo '</a>';

                  endforeach;
                echo '</div>';
              endif;
              if($card['short_bio']) :
                do_action('mind_sbefore_taff_card_bio', $card);
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
