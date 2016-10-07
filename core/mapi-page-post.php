<?php
/**
 * Mindshare Theme API PAGE & POST FUNCTIONS
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-page-post.php
 */

/**
 * Gets a post's slug by ID.
 *
 * @param int $id The post ID, optional. Defaults to the current post.
 *
 * @return string|bool Returns the the slug or FALSE if no post is found.
 */
function mapi_get_slug($id = NULL) {
	if (empty($id)) {
		$id = get_the_ID();
	}
	$post = get_post($id);
	if ($post) {
		return $post->post_name;
	} else {
		return FALSE;
	}
}

/**
 * Alias of mapi_slug_to_id. Retrieves the ID for a given slug.
 *
 * @param $slug string Required. The post slug.*
 *
 * @return int|bool Returns the ID or FALSE if no post is found.
 */
function mapi_get_id($slug) {
	mapi_slug_to_id($slug);
}

/**
 * Retrieves the post ID for a given slug.
 *
 * @param $slug string Required. The post slug.*
 *
 * @return int|bool Returns the ID or FALSE if no post is found.
 */
function mapi_slug_to_id($slug, $post_type = 'page') {
	$page = get_page_by_path($slug, $output = OBJECT, $post_type);
	if ($page) {
		return $page->ID;
	} else {
		return FALSE;
	}
}

/**
 * Recursively tests whether a page (or custom post type) is a child of a specific parent.
 *
 * @param int $parent_id ID of the parent.
 * @param int $check_id  ID to test. Defaults to the current post if not specified.
 *
 * @return bool Retruns TRUE if the $check_id is the child of $parent_id.
 */
function mapi_is_child_of($parent_id, $check_id = NULL) {
	global $post;
	if (is_object($post)) {
		if (!is_post_type_hierarchical($post->post_type)) {
			return FALSE;
		} else {
			if ($check_id == NULL) {
				$check_id = $post->ID;
			}
			$current = get_post($check_id);
			if ($current->post_parent != 0) {
				if ($current->post_parent != $parent_id) {
					return mapi_is_child_of($parent_id, $current->post_parent); // not that page, run again
				} else {
					return TRUE;
				}
			} else {
				return FALSE;
			}
		}
	} else {
		return FALSE;
	}
}

/**
 * Tests if the current post (or the post specified by $id) is a child.
 *
 * @param null|int $id
 *
 * @return bool
 */
function mapi_is_child($id = NULL) {
	global $post;

	if (!empty($id)) {
		$test_post = get_post($id);
	} else {
		$test_post = $post;
	}

	if ($test_post->post_parent) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Returns the ID of the topmost parent (ancestor) of a given post $id.
 *
 * @param $id
 *
 * @internal param $post
 * @return int The post ID, if no parents are found returns the ID of the given post.
 */
function mapi_get_top_parent_id($id) {
	if (mapi_is_child($id)) {
		$test_post = get_post($id);
		$ancestors = get_post_ancestors($test_post);
		$root = count($ancestors) - 1;

		return $ancestors[ $root ];
	} else {
		return $id;
	}
}

/**
 * Removes "Protected:" or "Private:" from post title using filters.
 *
 * @usage:
 *       add_filter('private_title_format', 'mapi_remove_title_prefix');
 *       add_filter('protected_title_format', 'mapi_remove_title_prefix');
 *
 * @param $content
 *
 * @return string
 */
function mapi_remove_title_prefix($content) {
	return '%s';
}

/**
 * @todo this function needs an overhaul.
 */
function mapi_list_children() {
	global $post;
	if ($post->post_parent) {
		$children = wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $post->post_parent . "&echo=0");
	} else {
		$children = wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $post->ID . "&echo=0");
	}
	if ($children) {
		echo '<ul class="list-children">';
		echo $children;
		echo '</ul>';
	} else {
		mapi_error(array('msg' => 'Found no child pages', 'die' => FALSE, 'echo' => FALSE));
	}
}

/**
 * Checks for an excerpt or generates one, can be used outside the loop. Allows limiting excerpt length to a specific
 * word-count automatically.
 *
 * @param int $excerpt_words Optional. Number of words in the excerpt. Default is 55.
 * @param int $id            Optional. The post ID to generate an excerpt for. Defaults to the current post.
 *
 * @return mixed|string
 */
function mapi_excerpt($excerpt_words = 55, $id = NULL) {
	// if ID is empty grab the global ID
	if (empty($id)) {
		$id = get_the_ID();
	}
	$post = get_post($id);
	$excerpt = $post->post_excerpt;

	// if no excerpt is specified, use the_content
	if (empty($excerpt)) {
		$excerpt = $post->post_content;
	}

	/**
	 * For post types other than "posts" that don't have the_content,
	 * generate excerpts from the first available 'wysiwyg' field from
	 * ACF if available.
	 */
	if (function_exists('get_field_objects')) {
		if (empty($excerpt) && $post->post_type != 'post') {
			$fields = get_field_objects();
			foreach ($fields as $field) {
				if ($field[ 'type' ] == 'wysiwyg') {
					$excerpt = $field[ 'value' ];
					break;
				}
			}
		}
	}

	// sanitize output
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = str_replace("\n", ' ', $excerpt);
	$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
	$excerpt = strip_tags($excerpt);

	// trim length by words
	$excerpt = mapi_word_limit($excerpt, $excerpt_words);

	return $excerpt;
}

/**
 * Returns an HTML unordered list tag (with the CSS class "list-posts") of the selected posts. Accepts either an array
 * of options of individual parameters. Passing in an array is the preferred method, please use an array for better forward
 * compatibility. All arguments are optional.
 *
 * @todo make post type array an option - to include multiple types
 *
 * @param int    $num                Number of posts to return. Default is 2.
 * @param int    $cat                The category to pull posts from. Default is 1.
 * @param string $type               The post type to include. Default is "post".
 * @param bool   $show_excerpt       Whether to show an excerpt of the each post in the list.
 * @param int    $excerpt_length     Length of the excerpt in words. Default is 10.
 * @param bool   $show_more_link     Whether or not to include a "Read more" link after each excerpt. Default is FALSE.
 * @param string $more_text          Text to use for the read more link. Default is "Read more"
 * @param string $more_before        Text or HTML to include before the read more link. Default is "&hellip;" (an ellipsis).
 * @param string $more_after         Text or HTML to include after the read more link. Default is "&raquo;".
 * @param string $content_or_excerpt Whether to allow HTML and apply the_content filters to excerpt or to return
 *                                   a standard plain text excerpt.
 * @param bool   $echo               Whether to echo the result or return it a string to PHP for further manipulation.
 * @param null   $slug               Allows retrieval of a single specific page by it's slug. Default is NULL.
 */
function mapi_list_posts($num = 2, $cat = 1, $type = 'post', $show_excerpt = FALSE, $excerpt_length = 10, $show_more_link = FALSE, $more_text = 'Read more', $more_before = '&hellip;', $more_after = '&raquo;', $content_or_excerpt = 'excerpt', $echo = FALSE, $slug = NULL) {
	if (is_array($num)) {
		mapi_list_posts_array($num);
	} else {
		$args = array(
			'num'                => $num,
			'cat'                => $cat,
			'type'               => $type,
			'show_excerpt'       => $show_excerpt,
			'excerpt_length'     => $excerpt_length,
			'show_more_link'     => $show_more_link,
			'more_text'          => $more_text,
			'more_before'        => $more_before,
			'more_after'         => $more_after,
			'content_or_excerpt' => $content_or_excerpt,
			'echo'               => $echo,
			'slug'               => $slug,
		);
		mapi_list_posts_array($args);
	}
}

/**
 * Provides the core functionality for mapi_list_posts. Use mapi_list_posts instead.
 *
 * @param $args
 *
 * @return string
 */
function mapi_list_posts_array($args) {
	$defaults = array(
		'num'                => 2,
		'cat'                => 1,
		'type'               => 'post',
		'show_excerpt'       => FALSE,
		'excerpt_length'     => 10,
		'show_more_link'     => FALSE,
		'more_text'          => 'Read more',
		'more_before'        => '&hellip;',
		'more_after'         => '&raquo;',
		'content_or_excerpt' => 'excerpt',
		'echo'               => FALSE,
		'slug'               => NULL,
	);
	$args = wp_parse_args($args, $defaults);

	if ($args[ 'type' ] == 'page') {
		// get a single page by its slug
		if (!isset($args[ 'slug' ])) {
			mapi_error(array('msg' => 'no page slug was defined'));
		} else {
			$posts = get_posts("post_type=" . $args[ 'type' ] . "&name=" . $args[ 'slug' ]);
		}
	} else {
		$posts = get_posts("post_type=" . $args[ 'type' ] . "&numberposts=" . $args[ 'num' ] . "&cat=" . $args[ 'cat' ]);
	}
	$str = '<ul class="mapi list-posts">';
	foreach ($posts as $post) {
		$str .= '<li><span class="link"><a href="' . get_permalink($post->ID) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></span>';
		if ($args[ 'show_excerpt' ]) {
			if ($args[ 'content_or_excerpt' ] == 'excerpt') {
				$str .= '<span class="excerpt">' . mapi_excerpt($excerpt_length, $post->ID) . '</span>';
			}
			if ($args[ 'content_or_excerpt' ] == 'content') {
				$content = apply_filters('the_content', $post->post_content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$str .= '<span class="excerpt">' . $content . '</span>';
			}
		}
		if ($args[ 'show_more_link' ]) {
			$str .= '<span class="more">' . $args[ 'more_before' ] . '<a class="more" href="' . get_permalink($post->ID) . '" title="' . the_title_attribute(array('echo' => 0)) . '">' . $args[ 'more_text' ] . '</a>' . $args[ 'more_after' ] . '</span>';
		}
	}
	$str .= '</li></ul>';
	if ($args[ 'echo' ]) {
		echo $str;
	} else {
		return $str;
	}
}

/**
 * Test if a post exists for a given post ID.
 *
 * @param        $id
 * @param string $post_type
 *
 * @return bool
 */
function mapi_post_exists($id, $post_type = 'post') {
	return $post_type === get_post_type($id) ? TRUE : FALSE;
}
