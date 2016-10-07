<?php
/**
 * mapi-query.php
 *
 * @created   10/7/16 4:04 PM
 * @author    Mindshare Studios, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/
 */

/**
 * Query a relationship between posts.
 *
 * @todo TEST in production
 *
 * @param $args param null $id Post ID
 * @param $args param string $post_type Post type to query.
 * @param $args param null $meta_key Mete kay to check for.
 *
 * @return \WP_Query
 */
function mapi_query_related($args) {

	if (!is_array($args)) {
		return mapi_error(array('msg' => 'Fatal error: ' . __FUNCTION__ . ' must be passed an array.'));
	}

	$defaults = array(
		'id'             => get_the_ID(),
		'post_type'      => get_post_type(),
		'meta_key'       => NULL,
		'posts_per_page' => get_option('posts_per_page'),
	);
	$args = wp_parse_args($args, $defaults);

	$query_args = apply_filters('mapi_get_related_filter', array(
		'post_type'      => $args[ 'post_type' ],
		'posts_per_page' => $args[ 'posts_per_page' ],
		'meta_query'     => array(
			array(
				'key'     => $args[ 'meta_key' ],
				'value'   => '"' . $args[ 'id' ] . '"',
				'compare' => 'LIKE',
			),
		),
	));

	$result = new WP_Query($query_args);

	return $result;
}
