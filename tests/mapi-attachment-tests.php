<?php
/*
 * Template Name: Mindshare Theme API Tests
 *
 * This file contains tests and is not used in production.
 * @link /wp-content/plugins/mindshare-api-master/tests/mapi-attachment-tests.php
 */


include_once('../../../../wp-blog-header.php');
$q = new WP_Query(apply_filters('mapi_test_query', 'page_id=2'));
get_header();
?>
<div id="main" class="site-main">
	<div id="main-content" class="main-content">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<?php if($q->have_posts()) : ?>
					<?php while($q->have_posts()) : $q->the_post(); ?>

						<h1><?php the_title(); ?></h1>

						<h1><?php the_title(); ?></h1>

						<?php //the_content(); ?>

						<?php mapi_featured_img(array('h' => 300, 'w' => 500, 'alt' => 'test', 'title' => 'ok!')); ?>
						<?php mapi_var_dump(mapi_get_first_post_image_src(get_the_ID())); ?>
						<?php mapi_var_dump(mapi_get_first_post_image_src(666)); ?>

						<?php print_r(mapi_featured_img(array('h' => 300, 'w' => 600, 'echo' => 0))); ?>



					<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
	<div id="secondary">
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
