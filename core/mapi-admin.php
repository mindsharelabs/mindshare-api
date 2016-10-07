<?php
/**
 *
 * Mindshare Theme API WordPress Admin area functions
 *
 * mapi-admin.php
 *
 * @created   4/28/14 10:46 AM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      http://www.mindsharelabs.com/documentation/
 *
 */

/**
 * Editor double line break in TinyMCE
 *
 * @usage: add_filter('tiny_mce_before_init', 'mapi_tinymce_line_breaks');
 *
 * @param $init
 *
 * @return mixed
 */
function mapi_tinymce_line_breaks($init) {
	$init[ "forced_root_block" ] = FALSE;
	$init[ "force_br_newlines" ] = TRUE;
	$init[ "force_p_newlines" ] = FALSE;
	$init[ "convert_newlines_to_brs" ] = TRUE;

	return $init;
}

/**
 * Add all custom post types to the "Right Now" box on the Dashboard
 *
 * Usage: add_action('dashboard_glance_items', 'mapi_right_now_content_table_end');
 *
 */
function mapi_right_now_content_table_end() {
	$post_types = get_post_types(array('show_in_nav_menus' => TRUE, '_builtin' => FALSE), 'objects');

	foreach ($post_types as $post_type => $post_type_obj) {
		$num_posts = wp_count_posts($post_type);
		if ($num_posts && $num_posts->publish) {
			printf(
				'<li class="%1$s-count"><a href="edit.php?post_type=%1$s">%2$s %3$s</a></li>',
				$post_type,
				number_format_i18n($num_posts->publish),
				$post_type_obj->label
			);
		}
	}
}

/**
 * Remove Yoast SEO Dashboard Widget
 *
 */
function mapi_remove_wpseo_dashboard_overview() {
	remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
}

/**
 * Remove customizer from Admin bar
 */
function mapi_before_admin_bar_render() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu('customize');
}
