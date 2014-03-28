<?php
/*
 * Template Name: Mindshare Theme API Tests
 *
 * This file contains tests and is not used in production.
 * @link /wp-content/plugins/mindshare-api-master/tests/mapi-template-parts-tests.php
 */
include_once('../../../../wp-blog-header.php');
$q = new WP_Query(apply_filters('mapi_test_query', array('post_type' => 'post', 'posts_per_page' => 3, 'paged' => get_query_var('paged'))));
get_header();
?>
<div id="primary">
	<div id="content" role="main">
		<?php mapi_nav_above(); ?>
		<?php if($q->have_posts()) : ?>
			<?php while($q->have_posts()) : $q->the_post(); ?>
				<?php get_template_part('content', get_post_format()); ?>
			<?php endwhile; endif; ?>
		<?php mapi_nav_below(); ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
