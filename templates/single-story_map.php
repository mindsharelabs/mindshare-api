<?php
get_header();


do_action('before_storymap_content');
if(have_posts()) :
  while(have_posts()) :
    the_post();

    echo '<div class="container-fluid my-3">';
      echo '<div class="row mb-5">';
        echo '<div class="col-12 mb-3">';
          echo '<h1 class="display-3">' . get_the_title() . '</div>';
        echo '</div>';

        echo '<div class="col-12 mb-3">';
          the_content();
        echo '</div>';

        echo '<div class="col-12 pb-5">';
          echo '<div id="mapdiv" style="width: 100%; height: 600px;"></div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';

  endwhile;
endif;
do_action('after_storymap_content');
get_footer();
