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
    echo '<div class="row">';
      foreach ($mind_staff_cards['staff_cards'] as $key => $card) :
        echo '<div class="col-12 col-md-4 d-flex flex-column h-100 justify-content-between">';


            if($card['image']) :
              echo '<div class="rounded-circle w-75 border border-light border-3 my-3 mx-auto p-2">';
              if($card['staff_page_link']) :
                echo '<a href="' . $card['staff_page_link']['url'] . '" target="' . $card['staff_page_link']['target'] . '">';
              endif;
                echo wp_get_attachment_image( $card['image']['id'], 'grid-image', false, array('class'=> 'card-img-top rounded-circle') );
              if($card['staff_page_link']) :
                echo '</a>';
              endif;
              echo '</div>';
            endif;


            echo '<div class="card-body">';
              if($card['staff_page_link']) :
                echo '<a href="' . $card['staff_page_link']['url'] . '" target="' . $card['staff_page_link']['target'] . '">';
              endif;
              echo '<h3 class="staff-name text-center mb-1">' . $card['name'] . '</h3>';
              if($card['staff_page_link']) :
                echo '</a>';
              endif;
              echo '<h4 class="staff-name text-center h5">' . $card['title'] . '</h4>';

              if($card['staff_links']) :
                echo '<div class="d-flex flex-row justify-content-center my-1">';
                  foreach ($card['staff_links'] as $key => $s_link) :
                    echo '<a class="p-2" href="' . $s_link['link']['url'] . '" target="' . $s_link['link']['target'] . '" title="' . $s_link['link']['title'] . '">';
                      echo '<i class="fa-lg ' . $s_link['icon'] . '"></i>';
                    echo '</a>';
                  endforeach;
                echo '</div>';
              endif;
              echo '<div class="staff-bio">';
                echo $card['short_bio'];
              echo '</div>';
            echo '</div>';


        echo '</div>';

      endforeach;
    echo '</div>';
  echo '</div>';

endif;
