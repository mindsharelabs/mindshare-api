<?php

/**
 * Image and Content
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'mind-button-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-button';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$mind_buttons = get_field('mind_buttons');
$alignment = $mind_buttons['button_alignment'];

if($mind_buttons) :
  echo '<div class="' . $className . ' text-' . $alignment . '" id=" ' .  $id .'">';


        if($mind_buttons['buttons']) :
          switch ($mind_buttons['button_layout']) {
            case 'group':

              echo '<div class="btn-group" role="group">';
                foreach ($mind_buttons['buttons'] as $key => $button) :
                  echo '<a
                    href="' . esc_url($button['button_link']['url']) . '"
                    title="' . esc_attr($button['button_link']['title']) . '"
                    class="btn btn-' . $button['button_type'] . ' btn-' . $button['button_size'] . '"
                    target="' . esc_attr($button['button_link']['target']) . '">' . html_entity_decode($button['button_link']['title']) . '</a>';
                endforeach;
              echo '</div>';

              break;
            case 'row':

              if($alignment == 'start') :
                $align_text = 'justify-content-start';
              elseif($alignment == 'center') :
                $align_text = 'justify-content-center';
              elseif($alignment == 'end') :
                $align_text = 'justify-content-end';
              endif;

              echo '<div class="buttons d-flex flex-wrap flex-row ' . $align_text . '" role="group">';
                foreach ($mind_buttons['buttons'] as $key => $button) :
                  echo '<a
                    href="' . esc_url($button['button_link']['url']) . '"
                    title="' . esc_attr($button['button_link']['title']) . '"
                    class="m-1 btn btn-' . $button['button_type'] . ' btn-' . $button['button_size'] . '"
                    target="' . esc_attr($button['button_link']['target']) . '">' . html_entity_decode($button['button_link']['title']) . '</a>';
                endforeach;
              echo '</div>';




              break;
            case 'column':

              if($alignment == 'start') :
                $align_text = 'offset-0';
              elseif($alignment == 'center') :
                $align_text = 'offset-0 offset-md-4';
              elseif($alignment == 'end') :
                $align_text = 'offset-0 offset-md-8';
              endif;

              echo '<div class="d-grid gap-1 col-12 col-md-4 ' . $align_text . '" role="group">';
                foreach ($mind_buttons['buttons'] as $key => $button) :
                  echo '<a
                    href="' . esc_url($button['button_link']['url']) . '"
                    title="' . esc_attr($button['button_link']['title']) . '"
                    class="m-1 d-block btn btn-' . $button['button_type'] . ' btn-' . $button['button_size'] . '"
                    target="' . esc_attr($button['button_link']['target']) . '">' . html_entity_decode($button['button_link']['title']) . '</a>';
                endforeach;
              echo '</div>';
              break;
          }


        endif;
  echo '</div>';

endif;
