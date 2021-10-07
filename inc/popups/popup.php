<?php

add_action('wp_footer', function() {
  if(get_field('enable_modal', 'options')) :


      $header = get_field('popup_header', 'options');
      $content = get_field('popup_content', 'options');
      $link = get_field('popup_link', 'options');
      $options = get_field('popup_options', 'options');

      echo '<div class="modal fade" id="mindModal" ' . ($options['behavior'] == 'static' ? 'data-bs-backdrop="static"' : '') . ' data-bs-keyboard="false" tabindex="-1" aria-labelledby="mindModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog ' . ($options['position'] == 'centered' ? 'modal-dialog-centered' : '') . ' modal-' . $options['size'] . '">';
          echo '<div class="modal-content">';
            echo '<div class="modal-header">';
              echo '<h3 class="modal-title" id="mindModalLabel">' . $header . '</h3>';
              echo '<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>';
            echo '</div>';
            echo '<div class="modal-body">' . $content . '</div>';
            if($link) :
              echo '<div class="modal-footer d-flex text-center justify-content-center">';
                echo '<a href="' . $link['url'] . '" target="' . $link['target'] . '" title="' . $link['title'] . '" class="btn btn-lg btn-secondary">' . $link['title'] . '</a>';
              echo '</div>';
            endif;
          echo '</div>';
        echo '</div>';
      echo '</div>';



  endif;
}, 1);
