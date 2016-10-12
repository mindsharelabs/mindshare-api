<?php
/**
 * deprecated.php
 * Contains deprecated code and functions. Kept for backward compatibility only.
 *
 * @created   9/9/12 3:24 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/downloads/mindshare-theme-api/
 */

/**
 * Checks for a TimThumb or mThumb configuration file (timthumb-config.php) in the root of the active theme.
 * This allows full user configuration of Timthumb without having to include the library in the theme itself.
 * See http://www.binarymoon.co.uk/2012/03/timthumb-configs/ for details.
 *
 * @see http://www.binarymoon.co.uk/2012/03/timthumb-configs/
 * @see https://github.com/mindsharestudios/mthumb
 */
function mapi_mthumb_config() {
	_deprecated_function(__FUNCTION__, '4.0');

	return FALSE;
}

/**
 * Grabs the latest tweets from a user's timeline.
 *
 * @deprecated
 * @see      : https://dev.twitter.com/docs/api/1/get/statuses/user_timeline
 *
 * @param $args array
 *
 * @internal param $screen_name (string) A Twitter screen name. Default is NULL.
 * @internal param int $num_items (integer) Number of Tweets to pull. Default is 4.
 * @internal param int $echo (boolean) Whether to output HTML or return a SimpleXMLElement for us in PHP. Default is TRUE.
 * @return SimpleXMLElement|string
 */

function mapi_tweets($args) {
	_deprecated_function(__FUNCTION__, '3.8', 'mapi_tweets_oauth');
	$defaults = array(
		'screen_name' => NULL,
		'num_items'   => 4,
		'echo'        => TRUE,
	);
	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	if (empty($screen_name)) {
		return mapi_error(array('msg' => 'A valid Twitter screen name is required'));
	}

	if (function_exists('simplexml_load_file')) {
		$url = 'https://api.twitter.com/1/statuses/user_timeline.xml?screen_name=' . $screen_name . '&count=' . $num_items;
		$tweets_xml = @ simplexml_load_file($url); // error supression added to prevent issues when Twitter is down
		if ($tweets_xml) {
			if ($echo) {
				echo '<ul class="mapi-twitter-feed mapi-twitter-rss">';
				$tweets = $tweets_xml->xpath("/statuses/status");
				foreach ($tweets as $tweet) : ?>
					<li>
						<span class="mapi-tweet-link"><?php echo $tweet->text; ?></span><br />
						<span class="mapi-tweet-meta">Posted to <a class="mapi-tweet-link" href='https://twitter.com/<?php echo $screen_name; ?>/status/<?php echo $tweet->id; ?>' title='<?php echo 'Posted ' . $tweet->created_at; ?>'>Twitter</a> on <?php echo $tweet->created_at; ?>
													  by <a href="https://twitter.com/<?php echo $screen_name; ?>" title="Connect with <?php bloginfo('name'); ?> on Twitter" target="_blank"><?php echo $screen_name; ?></a></span>
					</li>
					<?php
				endforeach;
				echo '</ul>';
			} else {
				return $tweets_xml;
			}
		} else {
			mapi_error(array('msg' => 'Could not retrieve Twitter XML: ' . $url, 'die' => FALSE, 'echo' => FALSE));
		}
	} else {
		mapi_error(array('msg' => 'The PHP function simplexml_load_file was not found.', 'die' => FALSE, 'echo' => FALSE));
	}
}

/**
 * Registers and enqueues the LESS.
 */
function mapi_less() {
	_deprecated_function(__FUNCTION__, '3.8');
	wp_deregister_script('mapi_less');
	wp_register_script('mapi_less', plugins_url('lib/lesscss/less.js', dirname(__FILE__)));
	wp_enqueue_script('mapi_less');
}

/**
 * Registers and enqueues the mapi.js file.
 *
 * @deprecated
 */
function mapi_js() {
	_deprecated_function(__FUNCTION__, '3.8');
}

/**
 * @deprecated
 */
function mapi_nav_above() {
	_deprecated_function(__FUNCTION__, '3.8');
	mapi_nav('above');
}

/**
 * @deprecated
 */
function mapi_nav_below() {
	_deprecated_function(__FUNCTION__, '3.8');
	mapi_nav();
}

/**
 * Deprecated, use mapi_facebook_posts() instead.
 *
 * @deprecated
 */
function mapi_facebook_rss($args = array()) {
	_doing_it_wrong(__FUNCTION__, '4.0');
	mapi_facebook_posts($args);
}

/**
 * @deprecated
 *
 * @param string $position
 */
function mapi_nav($position = 'below') {
	_deprecated_function(__FUNCTION__, '3.8');
	?>
	<div id="nav-<?php echo $position; ?>" class="navigation">
		<?php if (is_singular()) : ?>
			<div class="nav-previous"><?php next_post_link('&laquo; %link', '%title', TRUE) ?></div>
			<div class="nav-next"><?php previous_post_link('%link &raquo;', '%title', TRUE) ?></div>
		<?php elseif (is_search()) : ?>
			<?php if (get_next_posts_link('Previous Results')) : ?>
				<div class="nav-previous"><?php next_posts_link('Previous Results') ?></div>
			<?php endif; ?>
			<?php if (get_previous_posts_link('More Results')) : ?>
				<div class="nav-next"><?php previous_posts_link('More Results') ?></div>
			<?php endif; ?>
			<?php
		else : ?>
			<?php if (get_next_posts_link('Previous Entries')) : ?>
				<div class="nav-previous"><?php next_posts_link('Previous Entries') ?></div>
			<?php endif; ?>
			<?php if (get_previous_posts_link('Next Entries')) : ?>
				<div class="nav-next"><?php previous_posts_link('Next Entries') ?></div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Retrieves value of a custom field. or an optional string if the value is empty,
 * can send to an intermediary processing function as well. If the key passed in contains the
 * the text "url" the returned value will also have any special characters converted into HTML entities.
 *
 * @todo separate validation into separate functions, make optional
 *
 * @param string $key                    Required. The key for the custom field to retrieve.
 * @param int    $id                     Optional. Post ID. Defaults to the current post.
 * @param string $empty_str              Optional. String to return to the custom field value is empty.
 * @param string $processing_function    Optional. Name of a user-defined intermediary function to send the
 *                                       retrieved custom field value for processing before it gets returned.
 *
 * @deprecated
 * @return string
 */
function mapi_get_meta($key, $id = NULL, $empty_str = '', $processing_function = NULL) {
	_deprecated_function(__FUNCTION__, '3.8');
	if ($id == NULL) {
		$id = get_the_ID();
	}
	$meta = get_post_meta($id, $key, TRUE);

	// check if there's a value
	if (empty($meta)) {
		$meta = $empty_str;
	}

	// check if a processing function needs to be applied and run it
	if ($processing_function != NULL) {
		$meta = call_user_func($processing_function, $meta);
	}

	// check to see if we are spitting out a url, if so, convert HTML entities
	if (stristr($key, 'url') || stristr($key, 'email')) {
		return trim(htmlspecialchars($meta));
	} else {
		return trim($meta);
	}
}

/**
 * Bugfix: force "Insert Into Post" button to show up, applied to WP version 3.1 and lower
 *
 * @see http://wordpress.org/support/topic/insert-into-post-button-missing-for-some-picture
 *
 * @param $args
 *
 * @return array
 */
function mapi_force_send($args) {
	_deprecated_function(__FUNCTION__, '3.8');
	$args[ 'send' ] = TRUE;

	return $args;
}

global $wp_version;
if (version_compare($wp_version, MAPI_MIN_WP_VERSION, "<")) {
	add_filter('get_media_item_args', 'mapi_force_send');
}

/**
 * Puts the site offline for non-admins with a warning message. Originally designed for security audits,
 * but can be used for any time a site needs to go offline.
 *
 * @deprecated since version 0.6.7. Use mapi_maintenance_mode instead
 *
 * @param bool   $enabled Turns the offline mode on or off.
 * @param string $reason  A message explaining the downtime.
 */
function mapi_security_audit($enabled = FALSE, $reason) {
	_deprecated_function(__FUNCTION__, '3.8');
	mapi_maintenance_mode($enabled, 'Administrator', $reason);
}

/**
 * Fixes a bug in WordPress where the Link URL field does not save custom user input
 *
 * @deprecated since version 0.5
 *
 * @param $form_fields
 * @param $post
 *
 * @return mixed
 */
function mapi_replace_attachment_url($form_fields, $post) {
	_deprecated_function(__FUNCTION__, '3.8');
	if (isset($form_fields[ 'url' ][ 'html' ])) {
		$url = get_post_meta($post->ID, '_wp_attachment_url', TRUE);
		if (!empty($url)) {
			$form_fields[ 'url' ][ 'html' ] = preg_replace("/value='.*?'/", "value='$url'", $form_fields[ 'url' ][ 'html' ]);
		}
	}

	return $form_fields;
}

/**
 * Fixes a bug in WordPress where the Link URL field does not save custom user input
 *
 * @deprecated since version 0.5
 *
 * @param $post
 * @param $attachment
 *
 * @return mixed
 */
function mapi_save_attachment_url($post, $attachment) {
	_deprecated_function(__FUNCTION__, '3.8');
	if (isset($attachment[ 'url' ])) {
		update_post_meta($post[ 'ID' ], '_wp_attachment_url', esc_url_raw($attachment[ 'url' ]));
	}

	return $post;
}

/**
 * @deprecated since version 2.2
 */
function mapi_list_children_menu() {
	_deprecated_function(__FUNCTION__, '3.8');
	global $post;
	if ($post->post_parent) {
		$parent = get_page($post->post_parent);
		if (count($post->ancestors) > 1) {
			$depth = $post->ancestors[ 1 ];
			$parent = get_page($depth);
		} else {
			$depth = $post->post_parent;
		}
		$children .= wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $depth . "&echo=0&depth=1");
	} else {
		if (wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $post->ID . "&echo=0") != '') {
			$children .= wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $post->ID . "&echo=0&depth=1");
		}
	}
	if ($children) {
		echo $children;
	}
}

/**
 * Loads pickadate.js
 *
 * @deprecated
 */
function mapi_load_pickadate() {
	_deprecated_function(__FUNCTION__, '4.6');
	if (!is_admin()) {
		wp_deregister_script('pickadate');
		wp_register_script('pickadate', '//cdn.jsdelivr.net/jquery.pickadate.js/4.0.0-0/ui-pickadate.min.js', array('jquery'));
		wp_enqueue_script('pickadate');

		wp_deregister_script('pickadate-shadow');
		wp_register_script('pickadate-shadow', '//cdn.jsdelivr.net/jquery.pickadate.js/4.0.0-0/shadow.min.js', array('jquery'));
		wp_enqueue_script('pickadate-shadow');

		wp_deregister_script('pickadate-picker');
		wp_register_script('pickadate-picker', '//cdn.jsdelivr.net/jquery.pickadate.js/4.0.0-0/ui-picker.min.js', array('jquery'));
		wp_enqueue_script('pickadate-picker');

		wp_deregister_style('pickadate-css');
		wp_register_style('pickadate-css', '//cdn.jsdelivr.net/jquery.pickadate.js/4.0.0-0/css/styles.css');
		wp_enqueue_style('pickadate-css');
	}
}

/**
 * Loads Retina
 *
 * @deprecated
 */
function mapi_load_retina() {
	_deprecated_function(__FUNCTION__, '4.6');
	if (!is_admin()) {
		wp_deregister_script('retina');
		wp_register_script('retina', '//cdn.jsdelivr.net/retinajs/1.3.0/retina.min.js');
		wp_enqueue_script('retina');
	}
}

/**
 * Loads jQuery BBQ
 *
 * @deprecated
 */
function mapi_load_bbq() {
	_deprecated_function(__FUNCTION__, '4.6');
}

/**
 * Loads easyListSplitter
 *
 * @deprecated
 */
function mapi_load_easylistsplitter() {
	_deprecated_function(__FUNCTION__, '4.6');
	if (!is_admin()) {
		wp_deregister_script('easylistsplitter');
		wp_register_script('easylistsplitter', '//cdn.jsdelivr.net/easylistsplitter/1.0.2/jquery.easyListSplitter.js', array('jquery'));
		wp_enqueue_script('easylistsplitter');
	}
}

/**
 * Loads Lettering
 *
 * @deprecated
 */
function mapi_load_lettering() {
	_deprecated_function(__FUNCTION__, '4.6');
	if (!is_admin()) {
		wp_deregister_script('lettering');
		wp_register_script('lettering', '//cdn.jsdelivr.net/lettering/0.7.0/jquery.lettering.min.js', array('jquery'));
		wp_enqueue_script('lettering');
	}
}

/**
 *  Loads jQuery ReplaceText plguin.
 *
 * @deprecated
 */
function mapi_replacetext_js() {
	_deprecated_function(__FUNCTION__, '4.6');
}

/**
 * Loads JavaScript to automatically highlight search terms on WordPress search results pages.
 *
 * @deprecated
 */
function mapi_search_highlighter_js() {
	_deprecated_function(__FUNCTION__, '4.6');
}

/**
 * Prevents JavaScript errors if the console object is not defined.
 *
 * @deprecated
 */
function mapi_fix_console() {
	_deprecated_function(__FUNCTION__, '4.6');
}

/**
 * Loads SWFObject
 *
 * @deprecated
 */
function mapi_load_swfobject() {
	_deprecated_function(__FUNCTION__, '4.6');
	if (!is_admin()) {
		wp_enqueue_script('swfobject');
	}
}

/**
 * Not intended for general use in themes. Get query variables. Used to highlight search terms via JavaScript.
 *
 * @deprecated
 */
function mapi_query() {
	_deprecated_function(__FUNCTION__, '4.6');
}
