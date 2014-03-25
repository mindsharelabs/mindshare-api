<?php
/*
 * Template Name: Mindshare Theme API Tests
 *
 * This file contains tests and is not used in production.
 * @link /wp-content/plugins/mindshare-api/tests/mapi-attachment-tests.php
 */
include_once('../../../../wp-blog-header.php');
$q = new WP_Query(apply_filters('mapi_test_query', 'page_id=2'));
get_header();
?>
<div id="primary">
	<div id="content" role="main">
		<?php if($q->have_posts()) : ?>
			<?php while($q->have_posts()) : $q->the_post(); ?>

				<h1><?php the_title(); ?></h1>

				<?php //the_content(); ?>

				<?php mapi_featured_img(array('h' => 300, 'w' => 500, 'alt' => 'test', 'title' => 'ok!')); ?>

				<?php print_r(mapi_featured_img(array('h' => 300, 'w' => 600, 'echo'=> 0))); ?>

			<?php endwhile; endif; ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
