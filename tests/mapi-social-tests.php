<?php

/**
 * Template Name: Mindshare Theme API Tests
 *
 * This file contains tests and is not used in production.
 * @link /wp-content/plugins/mindshare-api/tests/mapi-social-tests.php
 * 
 * @created 8/22/13 2:21 PM
 * @author Mindshare Studios, Inc.
 * @copyright Copyright (c) 2014
 * @link http://mindsharelabs.com/downloads/mindshare-theme-api/
 * 
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

				<?php echo '<pre>'; var_dump(mapi_get_option('facebook_uri')); echo '</pre>'; ?>
				<?php echo '<pre>'; var_dump(mapi_facebook_lookup()); echo '</pre>'; ?>
				<?php echo '<pre>'; var_dump(mapi_get_facebook_id()); echo '</pre>'; ?>
				<p>mapi_facebook_id() = <?php mapi_facebook_id(); ?></p>
				<p>mapi_facebook_rss() = <?php mapi_facebook_rss(); ?></p>



			<?php endwhile; endif; ?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
