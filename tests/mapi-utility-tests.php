<?php
/*
 * Template Name: Mindshare Theme API Tests
 *
 * This file contains tests and is not used in production. Updated for 2014.
 * @link /wp-content/plugins/mindshare-api-master/tests/mapi-utility-tests.php
 */
include_once('../../../../wp-blog-header.php');
$q = new WP_Query(array('p=2'));
get_header();
?>
<div id="main" class="site-main">
	<div id="main-content" class="main-content">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<?php if($q->have_posts()) : ?>
					<?php while($q->have_posts()) : $q->the_post(); ?>
						<article <?php post_class() ?>>
							<header class="entry-header"><h1 class="entry-title"><?php the_title(); ?></h1></header>
							<div class="entry-content">
								<?php the_content(); ?>

								<?php mapi_var_dump(mapi_get_taxonomy_by_term(2, 'id'), FALSE); ?>

								<?php echo mapi_extract_domain('http://dev.mind.sh'); ?>

								<p>Preload Images:
									<?php
									$uploads = wp_upload_dir();
									echo $uploads['path'];
									mapi_preload($uploads['path']);
									?>
								</p>
								<p>Google Analytics code: <textarea><?php mapi_analytics(); ?></textarea>
								</p>

								<?php mapi_error(array('msg' => 'Logging this to console.', 'die' => FALSE, 'echo' => FALSE)) ?>
							</div>
						</article>
					<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
	<div id="secondary">
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

