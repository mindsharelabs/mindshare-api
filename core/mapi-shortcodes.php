<?php
/**
 * Mindshare Theme API WORDPRESS SHORTCODES
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-shortcodes.php
 *
 */

/**
 *
 * Adds Mindshare API members only buttons to TinyMCE.
 *
 */
function mapi_member_btns() {
	if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	if(get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'mapi_add_tinymce_plugin');
		add_filter('mce_buttons', 'mapi_register_button');
	}
}

/**
 *
 * Adds Mindshare API members only buttons to TinyMCE.
 *
 */
function mapi_inline_post_btns() {
	if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	if(get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'mapi_add_tinymce_plugin');
		add_filter('mce_buttons', 'mapi_register_inline_post_buttons');
	}
}

/**
 * Registers buttons with TinyMCE.
 *
 * @param $buttons
 *
 * @return array
 */
function mapi_register_button($buttons) {
	array_push($buttons, "|", "visitor");
	array_push($buttons, "|", "member");
	array_push($buttons, "|", "access");
	return $buttons;
}

/**
 * Registers buttons with TinyMCE.
 *
 * @param $buttons
 *
 * @return array
 */
function mapi_register_inline_post_buttons($buttons) {
	array_push($buttons, "|", "inlinepost");
	array_push($buttons, "|", "inlineposts");
	return $buttons;
}

/**
 * Returns an array of plugins for TinyMCE.
 *
 * @param $plugin_array
 *
 * @return array
 */
function mapi_add_tinymce_plugin($plugin_array) {
	$plugin_array['visitor'] = plugins_url('js/mapi-tinymce.js', dirname(__FILE__));
	$plugin_array['member'] = plugins_url('js/mapi-tinymce.js', dirname(__FILE__));
	$plugin_array['access'] = plugins_url('js/mapi-tinymce.js', dirname(__FILE__));
	$plugin_array['inlinepost'] = plugins_url('js/mapi-tinymce.js', dirname(__FILE__));
	$plugin_array['inlineposts'] = plugins_url('js/mapi-tinymce.js', dirname(__FILE__));
	return $plugin_array;
}

function mapi_inline_posts_shortcode($atts, $content = NULL) {

	$parent_id = get_the_ID(); // check to prevent an infinite loop
	$args = shortcode_atts(
		array(
			'format'              => 'list',
			'author'              => NULL,
			'author_name'         => NULL,
			'cat'                 => NULL,
			'category_name'       => NULL,
			//				'category__and'       => NULL,
			//				'category__in'        => NULL,
			//				'category__not_in'    => NULL,
			'tag'                 => NULL,
			'tag_id'              => NULL,
			//				'tag__and'            => NULL,
			//				'tag__in'             => NULL,
			//				'tag__not_in'         => NULL,
			//				'tag_slug__and'       => NULL,
			//				'tag_slug__in'        => NULL,
			'p'                   => NULL,
			'name'                => NULL,
			'page_id'             => NULL,
			'pagename'            => NULL,
			'post_parent'         => NULL,
			'post_type'           => 'any',
			'post_status'         => NULL,
			'posts_per_page'      => NULL,
			'nopaging'            => NULL,
			'offset'              => NULL,
			'order'               => NULL,
			'orderby'             => NULL,
			'ignore_sticky_posts' => NULL,
			'year'                => NULL,
			'monthnum'            => NULL,
			'w'                   => NULL,
			'day'                 => NULL,
			'hour'                => NULL,
			'minute'              => NULL,
			'second'              => NULL,
			'meta_key'            => NULL,
			'meta_value'          => NULL,
			'meta_value_num'      => NULL,
			'meta_compare'        => NULL,
			's'                   => NULL,
		), $atts);
	$args = mapi_sanitize_array($args);
	$args = array_merge($args, array('post__not_in' => array($parent_id))); // remove the ID of the post we're embedding into
	$inline_query = new WP_Query($args);
	$format = $args['format'];
	//var_dump($format); die;
	if($inline_query->have_posts()) {
		/** @noinspection PhpUndefinedVariableInspection */
		if($format == 'list') {
			$content = '<ul class="mapi list-posts">';
		}
		while($inline_query->have_posts()) {
			$inline_query->the_post();

			// 'format' is the only non-WP_Query parameter.
			// It determines how the post(s) are returned:

			// list - return Title w/ Permalink in a UL

			// title_link_content - return Title w/ Permalink and Content
			// title_link_excerpt - return Title w/ Permalink and Excerpt

			// the_title - return Title only
			// the_excerpt - return Excerpt only
			// the_content - return Content only

			$link = '<a href="'.get_permalink().'" title="'.the_title_attribute(array('echo' => FALSE)).'" rel="bookmark">'.get_the_title().'</a>';
			$title = '<h1 class="mapi entry-title">'.$link.'</h1>';
			$excerpt = '<p>'.get_the_excerpt().'</p>';
			$body = apply_filters('the_content', get_the_content());
			if(!empty($body) && !is_feed()) {
				$body = do_shortcode($body); // process shortcodes within the inline posts
			}

			switch($format) {
				case 'the_title':
					$content .= $title;
					break;
				case 'the_content':
					$content .= $body;
					break;
				case 'the_excerpt':
					$content .= $excerpt;
					break;
				case 'list' :
					$content .= '<li>'.$link.'</li>';
					break;
				case 'title_excerpt':
					$content .= $title.$excerpt;
					break;
				case 'title_content':
					$content .= $title.$body;
					break;
			}
		}
		if($format == 'list') {
			$content .= '</ul>';
		}
	}
	wp_reset_query();
	if(!empty($content) && !is_feed()) {
		return do_shortcode($content); // process shortcodes within the inline posts
	}
	return '';
}

/**
 *
 * Creates a shortcode to insert content for a given page/post ID.
 * Will process any additional shortcodes in the inserted post content.
 *
 * @usage:
 * [inline-post id="2"]
 *
 * @param      $atts
 * @param null $content
 *
 * @return null|string
 */
function mapi_inline_post_shortcode($atts, $content = NULL) {
	$atts['p'] = $atts['id'];
	unset($atts['id']);
	return mapi_inline_posts_shortcode($atts, $content = NULL);
}

/**
 * Checks for appropriate users permissions (logged out visitors).
 *
 * @usage:
 * [visitor]Some content for the people just browsing your site.[/visitor]
 *
 * @param      $atts
 * @param null $content
 *
 * @return string Executes the shortcode content or returns an empty string.
 */
function mapi_visitor_check_shortcode($atts, $content = NULL) {
	if((!is_user_logged_in() && !is_null($content)) || is_feed()) {
		return do_shortcode($content);
	}
	return '';
}

/**
 *
 * Checks for appropriate users permissions (logged in users).
 *
 * @usage:
 * [member]This is members-only content.[/member]
 *
 * @param      $atts
 * @param null $content
 *
 * @return string Executes the shortcode content or returns an empty string.
 */
function mapi_member_check_shortcode($atts, $content = NULL) {
	if(is_user_logged_in() && !is_null($content) && !is_feed()) {
		return do_shortcode($content);
	}
	return '';
}

/**
 * Checks for appropriate users permissions (logged in users with specific roles/capability). The default capability is 'read'.
 *
 * @usage:
 * [access capability="switch_themes"]The currently logged-in user can switch themes.[/access]
 *
 * @param      $attr
 * @param null $content
 *
 * @return string Executes the shortcode content or returns an empty string.
 */
function mapi_access_check_shortcode($attr, $content = NULL) {
	extract(shortcode_atts(array('capability' => 'read'), $attr));
	/** @noinspection PhpUndefinedVariableInspection */
	if(current_user_can($capability) && !is_null($content) && !is_feed()) {
		return do_shortcode($content);
	}
	return '';
}

// enable shortcodes, these need to be called ahead of mapi_options in order to be registered in time
add_shortcode('inline-post', 'mapi_inline_post_shortcode'); // add inline post shortcode
add_shortcode('inline-query', 'mapi_inline_posts_shortcode'); // add inline post shortcode

add_shortcode('access', 'mapi_access_check_shortcode'); // add access level shortcode
add_shortcode('member', 'mapi_member_check_shortcode'); // add member shortcode
add_shortcode('visitor', 'mapi_visitor_check_shortcode'); // add visitor shortcode

