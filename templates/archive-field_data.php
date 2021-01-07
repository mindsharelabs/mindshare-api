<?php

get_header();

echo '<div class="container">';
    if(have_posts()) :
      echo '<div class="row">';
        echo '<div class="col-12 mb-2">';
          echo '<h1 class="display-4 my-5 header_font text-center">Coded Field Data</h1>';
        echo '</div>';
      echo '</div>';

      echo '<div class="row">';
        echo '<div class="col-12 my-5">';
          echo do_shortcode( '[post_type_intro field="content" posttype=field_data]');
        echo '</div>';
      echo '</div>';


      echo '<div class="row">';
        echo '<div class="col-12 text-right small">';
          echo '<a href="#" class="csv-export btn btn-sm btn-info">Download Data</a>';
        echo '</div>';
      echo '</div>';

      echo '<div class="row">';
        echo '<div class="col-12 col-md-4">';
            echo '<span class="tax-label"><strong>Dimension Category: </strong><br/></span>';
          echo facetwp_display( 'facet', 'dimension_category' );
        echo '</div>';
        echo '<div class="col-12 col-md-4">';
            echo '<span class="tax-label"><strong>Code: </strong><br/></span>';
          echo facetwp_display( 'facet', 'quote_code' );
        echo '</div>';


        echo '<div class="col-12 col-md-4">';
            echo '<span class="tax-label"><strong>Topic Description: </strong><br/></span>';
          echo facetwp_display( 'facet', 'document_description' );
        echo '</div>';

      echo '</div>';

      echo '<div class="row">';
        while(have_posts()) :
          the_post();
          include 'loops/loop-field_data.php';
        endwhile;
      echo '</div>';

      echo '<div class="row">';
        echo '<div class="col-12 text-center">';
          echo facetwp_display( 'facet', 'field_data_pagination' );
        echo '</div>';
      echo '</div>';

    endif;


echo '</div>';



get_footer();
