<?php

/**
 * Tabs Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'tabs-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'tabs-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$tabs = get_field('tabs');

if($tabs) :
  echo '<div class="' . $className . '">';

    // Tab switching relies on Bootstrap's Tab JS component, which the
    // theme already enqueues site-wide (functions.php: bootstrap-min) —
    // see the accordion block for the same convention.
    echo '<ul class="nav nav-tabs tabs-block__nav flex-column flex-md-row" id="nav-' . $id . '" role="tablist">';
      foreach ($tabs as $key => $tab) :
        $active  = ($key == 0);
        $tab_id  = 'tab-' . $key . '-' . $id;
        $pane_id = 'pane-' . $key . '-' . $id;

        echo '<li class="nav-item" role="presentation">';
          echo '<button class="nav-link' . ($active ? ' active' : '') . '" id="' . $tab_id . '" data-bs-toggle="tab" data-bs-target="#' . $pane_id . '" type="button" role="tab" aria-controls="' . $pane_id . '" aria-selected="' . ($active ? 'true' : 'false') . '">';
            echo esc_html(!empty($tab['tab_label']) ? $tab['tab_label'] : 'Tab ' . ($key + 1));
          echo '</button>';
        echo '</li>';
      endforeach;
    echo '</ul>';

    echo '<div class="tab-content tabs-block__content" id="content-' . $id . '">';
      foreach ($tabs as $key => $tab) :
        $active  = ($key == 0);
        $tab_id  = 'tab-' . $key . '-' . $id;
        $pane_id = 'pane-' . $key . '-' . $id;

        echo '<div class="tab-pane fade' . ($active ? ' show active' : '') . '" id="' . $pane_id . '" role="tabpanel" aria-labelledby="' . $tab_id . '" tabindex="0">';
          echo (isset($tab['tab_content']) ? $tab['tab_content'] : '');
        echo '</div>';
      endforeach;
    echo '</div>';

  echo '</div>';

endif;
