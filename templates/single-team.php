<?php
get_header();
$links = get_field('links');
if(have_posts()) : while(have_posts()) : the_post(); ?>
  <main role="main" aria-label="Content" <?php post_class(); ?>>
    <section class="container my-5">
      <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
        <?php
        echo '<div class="col-md-4 col-12">';
          if(has_post_thumbnail( )) :
            the_post_thumbnail( 'large', array('class' => 'w-100 post-thumb') );
          endif;
          if($links) :
            echo '<h5 class="mt-3 border-bottom">Get In Touch</h5>';
            echo '<div class="d-flex flex-row w-100 my-2">';
              foreach ($links as $key => $link) :
                echo '<a href="' . $link['url']['url'] . '" class="px-2" title="' . $link['url']['title'] . '" target="' . $link['url']['target'] .'">';
                  echo '<i class="fa-2x ' . $link['icon'] . '"></i>';
                echo '</a>';
              endforeach;

            echo '</div>';
          endif;
        echo '</div>';

         ?>
        <div class="col">
          <h1 class="my-0"><?php the_title(); ?></h1>
          <h3 class="mt-0 mb-3"><?php the_field('titlejob'); ?></h3>
          <hr>
          <?php the_content(); ?>

          <?php mapi_post_edit(); // Always handy to have Edit Post Links available ?>
        </div>
      </article>
    </section>
  </main>
<?php endwhile; endif;

get_footer();
