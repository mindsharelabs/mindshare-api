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

if($post_list_block) :
  $args = array(
    'posts_per_page' => $post_list_block['posts_per_page'],
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $post_list_block['categories'],
      ),
    )
  );

  $posts = new WP_Query($args);

  $type = $post_list_block['display_type'];
  if($posts->have_posts()) :
    echo '<div class="' . $className . ' row" id="' . $id . '">';
    $tools = array();

    while($posts->have_posts()) :
      $posts->the_post();


      echo '<div class="col-12 my-2 ' . ($type == 'list' ? '' : 'col-md-3') . ' ' . $type . '">';
        echo '<div class="card d-flex h-100 mb-3">';

          if($type == 'gallery') :
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
          elseif($type == 'list') :
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
                  echo '<p>' . get_the_excerpt() . '</p>';
                  echo '<a href="' . get_permalink() . '" class="btn btn-primary">Read More</a>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          elseif($type == 'card') :
            the_post_thumbnail( 'loop-thumbnail', array('class' => 'card-img-top') );
            echo '<div class="card-body">';
              echo '<h3><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';
              echo '<p>' . get_the_excerpt() . '</p>';

            echo '</div>';
            echo '<div class="card-footer text-right">';
              echo '<a href="' . get_permalink() . '" class="btn btn-primary text-end">Read More</a>';
            echo '</div>';
          endif;

        echo '</div>';
      echo '</div>';


    endwhile;
    echo '</div>';



  endif;
endif;
