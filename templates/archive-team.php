<?php get_header(); ?>

<main role="main" aria-label="Content">
  <section <?php post_class('container team-section'); ?>>
    <div class="row my-3">
      <?php
      $object = get_queried_object();
      if(have_posts()) :
        while (have_posts()) : the_post();
          include 'loops/loop-team.php';
        endwhile;
      endif;
      ?>
      </div>
      <?php get_template_part('pagination'); ?>
    </div>
  </section>
</main>
<?php get_footer();
