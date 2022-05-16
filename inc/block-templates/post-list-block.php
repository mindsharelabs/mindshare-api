<?php

/**
 * Post List Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'post-list-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'post-list-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$post_list_block = get_field('post_list_block');

if(!$post_list_block['posts_per_page']) :
  $post_list_block['posts_per_page'] = get_option( 'posts_per_page' );
endif;

if($post_list_block) :
  $args = array(
    'posts_per_page' => $post_list_block['posts_per_page'],
    'post_type' => (count($post_list_block['post_type']) > 0 ? $post_list_block['post_type'] : 'post'),
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $post_list_block['categories'],
      ),
    )
  );

  $med_container = 'col-md-4';



  if($post_list_block['posts_per_page'] % 2 == 0) {
    $med_container = 'col-md-6';
  }

  if($post_list_block['posts_per_page'] % 3 == 0) {
    $med_container = 'col-md-4';
  }

  if($post_list_block['posts_per_page'] % 12 == 0) {
    $med_container = 'col-md-4';
  }



  $posts = new WP_Query($args);

  $type = $post_list_block['display_type'];
  if($posts->have_posts()) :
    echo '<div class="' . $className . ' row" id="' . $id . '">';
    $tools = array();

          if($type == 'gallery') :

            while($posts->have_posts()) :
              $posts->the_post();
              echo '<div class="col-12 my-2">';
                echo '<div class="card d-flex h-100 mb-3">';
                  do_action('mind_before_post_card', get_the_id());
                  if(has_post_thumbnail()) :
                    the_post_thumbnail( 'loop-square', array('class' => 'card-img-top') );
                    echo '<a class="overlay" href="' . get_permalink() . '">';
                      echo '<h2>' . get_the_title(get_the_id()) . '</h2>';
                      echo '<p>' . get_the_excerpt() . '</p>';
                    echo '</a>';
                  else :
                    if(current_user_can('administrator')) :
                      echo '<pre>This post has no thumbnail, choose a different layout for this post to display.</pre>';
                    endif;
                  endif;
                  do_action('mind_after_post_card', get_the_id());
                echo '</div>';
              echo '</div>';
            endwhile;

          elseif($type == 'list') :


            while($posts->have_posts()) :
              $posts->the_post();
              echo '<div class="col-12 my-2 ' . ($type == 'list' ? '' : $med_container) . '">';
                echo '<div class="card d-flex h-100 mb-3">';
                  do_action('mind_before_post_card', get_the_id());
                  echo '<div class="row no-gutters">';
                    if(has_post_thumbnail()):
                      echo '<div class="col-12 col-md-4">';
                        echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
                          the_post_thumbnail( 'loop-list-thumbnail', array('class' => 'card-img-top') );
                        echo '</a>';
                      echo '</div>';
                    endif;
                    echo '<div class="col-12 col-md">';
                      echo '<div class="card-body">';
                        echo '<h3><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';



                        echo get_the_excerpt();
                      echo '</div>';
                      echo '<div class="card-footer border-0 background-transparent bg-transparent">';
                        echo '<a href="' . get_permalink() . '" class="btn btn-primary mt-3">Read More</a>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                  do_action('mind_after_post_card', get_the_id());
                echo '</div>';
              echo '</div>';
            endwhile;

          elseif($type == 'small') :
            echo '<ul>';
            while($posts->have_posts()) :
              $posts->the_post();
              echo '<li>';
                echo '<h3 class="h5 d-inline"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';
                echo ' - ' . get_the_excerpt();
              echo '</li>';
            endwhile;
            echo '</ul>';

          elseif($type == 'card') :

            while($posts->have_posts()) :
              $posts->the_post();
              echo '<div class="col-12 my-2 ' . ($type == 'list' ? '' : $med_container) . '">';
                echo '<div class="card d-flex h-100 mb-3">';
                  do_action('mind_before_post_card', get_the_id());
                  the_post_thumbnail( 'loop-thumbnail', array('class' => 'card-img-top') );
                  echo '<div class="card-body test-dark">';
                    echo '<h3><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';
                    $categories = get_the_category();
                    foreach( $categories as $category) {
                      $name = $category->name;
                      $category_link = get_category_link( $category->term_id );
                      echo '<a class="badge small bg-secondary text-light" href=' . $category_link . '>' . esc_attr( $name) . '</a>';
                    }
                    echo '<p class="text-dark mb-0">' . get_the_excerpt() . '</p>';

                  echo '</div>';
                  echo '<div class="card-footer text-center w-100">';
                    echo '<a href="' . get_permalink() . '">Read More</a>';
                  echo '</div>';
                  do_action('mind_after_post_card', get_the_id());
                echo '</div>';
              echo '</div>';

            endwhile;

          elseif($type == 'small_card') :

            while($posts->have_posts()) :
              $posts->the_post();
              echo '<div class="col-12 my-2 ' . ($type == 'list' ? '' : $med_container) . '">';
                echo '<div class="card d-flex h-100 mb-3">';
                  do_action('mind_before_post_card', get_the_id());
                  echo '<div class="card-body test-dark">';
                    echo '<span class="date small faded">' . get_the_date('F j, Y') . '</span>';
                    echo '<h3 class="h5"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';
                    echo '<p class="text-dark small mb-0">' . get_the_excerpt() . '</p>';
                  echo '</div>';
                  do_action('mind_after_post_card', get_the_id());
                echo '</div>';
              echo '</div>';

            endwhile;

          endif;
    echo '</div>';
  endif;
endif;
