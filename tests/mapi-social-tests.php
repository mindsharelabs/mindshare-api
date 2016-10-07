<?php

/**
 * Template Name: Mindshare Theme API Tests
 * This file contains tests and is not used in production.
 *
 * @link      /wp-content/plugins/mindshare-api-master/tests/mapi-social-tests.php
 * @created   8/22/13 2:21 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/downloads/mindshare-theme-api/
 */

include_once('../../../../wp-blog-header.php');
$q = new WP_Query(apply_filters('mapi_test_query', 'page_id=2'));
get_header();
?>
<?php print_r(get_intermediate_image_sizes()); ?>

<div id="main" class="site-main">
	<div id="main-content" class="main-content">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<?php if ($q->have_posts()) : ?>
					<?php while ($q->have_posts()) : $q->the_post(); ?>

						<h1><?php the_title(); ?></h1>

						<?php //mapi_var_dump(mapi_get_option('facebook_uri')); ?>
						<?php //mapi_var_dump(mapi_facebook_lookup()); ?>
						<?php mapi_var_dump(mapi_get_facebook_id('mindsharestudios')); ?>
						<p>mapi_facebook_id() = <?php mapi_facebook_id(); ?></p>
						<p>mapi_facebook_posts() = <?php mapi_facebook_posts(array('facebook_id' => 'mindsharestudios')); ?></p>

						<?php //mapi_social_link(array('network' => 'facebook')); ?>
						<?php //mapi_social_links(); ?>
						<?php //mapi_tweets_oauth(array('screen_name' => 'mindsharestatus', 'num_tweets' => 6)); ?>

					<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
	<div id="secondary">
	</div>
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
