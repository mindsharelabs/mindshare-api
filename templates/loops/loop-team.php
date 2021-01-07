<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-4 col-lg-3 mb-3'); ?>>
  <div class="card h-100 team-card">
    <?php
    if(has_post_thumbnail( )) :
      the_post_thumbnail( get_the_id(), 'medium');
    endif;
    ?>
    <div class="card-body text-center">
      <h4 class="section-title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      </h4>
      <?php echo (get_field('titlejob') ? '<h5>' . get_field('titlejob') . '</h5>' : ''); ?>
    </div>
    <div class="overlay text-center">
      <h4 class="section-title mb-2">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
      </h4>
      <small><?php the_excerpt(); ?></small>
      <a href="<?php the_permalink(); ?>" class="btn btn-white d-block border mt-2" title="<?php the_title_attribute(); ?>">Read More <i class="fa fa-arrow-right"></i></a>
    </div>
  </div>
</article>
