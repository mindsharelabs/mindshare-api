<?php
/**
 * mapi-facebook.php
 *
 * @created   10/5/16 11:16 AM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/
 */

/**
 * Retrieves public Facebook wall posts from a Page's timeline using the Facebook API. Replaces the deprecated mapi_facebook_rss() function.
 *
 * @todo add caching for remote requests?
 *
 * @param $args array [string]fb_app_id A Facebook app id, default: Mindshare's shared app
 * @param $args array [string]fb_app_secret A Facebook app secret, default: Mindshare's shared app secret
 * @param $args array [int]num_posts Number of posts to retrieve, default: 4
 * @param $args array [int]num_words Number of words per post to allow, default: 50
 * @param $args array [bool]echo Whether to echo or return the result, default: TRUE
 * @param $args array [array]auth Open graph authentication settings: graph_access_token, graph_access_token_secret. Default: Mindshare's FB app.
 *
 * @return array|bool|string
 */
function mapi_facebook_posts($args = array()) {

	$defaults = array(
		'facebook_id' => mapi_get_facebook_id(mapi_get_option('facebook_uri')),
		'num_posts'   => 4,
		'num_words'   => 55,
		'echo'        => TRUE,
		'auth'        => $settings = mapi_facebook_access_token(),
	);
	$args = wp_parse_args($args, $defaults);

	if (!$args[ 'facebook_id' ]) {
		mapi_error(array('msg' => 'Facebook page id is required'));

		return FALSE;
	}

	/**
	 * Open Graph endpoint URI
	 */
	$api_uri = "https://graph.facebook.com/";

	// Make the API call
	$result = wp_remote_get($api_uri . $args[ 'facebook_id' ] . "/posts?access_token=" . $settings[ 'graph_access_token' ] . '|' . $settings[ 'graph_access_token_secret' ]);

	$result = json_decode(wp_remote_retrieve_body($result), TRUE);
	if ($result === FALSE || empty($result[ 'data' ])) {
		mapi_error(array('msg' => 'Could not load Facebook posts. Check to make sure the user id provided is a page and not a user. Result: ' . $result));

		return FALSE;
	}

	// if echo is false return raw data
	if ($args[ 'echo' ] === FALSE) {
		return $post_result;
	}

	// else echo the HTML
	?>
	<ul class="mapi-fb-posts">
		<?php
		$fb_posts = array_slice($result[ 'data' ], 0, $args[ 'num_posts' ]);
		foreach ($fb_posts as $fb_post) {

			// We have to make another request with the post ID to get a large photo
			$post_result = wp_remote_retrieve_body(wp_remote_get($api_uri . "/" . $fb_post[ 'id' ] . "/"));
			$post_result = json_decode($post_result, TRUE);
			$post_date = date('M j, Y', strtotime($post_result[ 'created_time' ]));

			// There are two ways a facebook post can return an image
			$photo_url = NULL; // Reset optional variable
			if (isset($post_result[ 'object_id' ])) {
				$photo_url = $api_uri . $post_result[ 'object_id' ] . "/picture";
			} elseif (!empty($post_result[ 'picture' ])) {
				$photo_url = urldecode(preg_replace('/&cfs.*/', '', preg_replace('/.*url=/', '', $post_result[ 'picture' ]))); // @link http://stackoverflow.com/a/34741422
			}
			// if the current site uses SSL, we don't want to display insecure images
			if (is_ssl() && stristr($photo_url, 'http://')) {
				$photo_url = NULL;
			}

			// Parse the feed
			?>
			<li class="mapi-fb-post">

				<?php if ($post_result[ 'type' ] == 'video') : ?>
					<div class="mapi-fb-video">
						<?php echo wp_oembed_get($post_result[ 'source' ]); ?>
					</div>

				<?php elseif ($photo_url) : ?>
					<div class="mapi-fb-image">
						<?php if ($post_result[ 'link' ]) : ?><a href="<?php echo $post_result[ 'link' ]; ?>" title="Posted <?php echo $post_date; ?>"><?php endif; ?>
							<img src="<?php echo $photo_url; ?>" alt="<?php bloginfo('name'); ?>" style="max-width: <?php echo get_option('medium_size_w'); ?>px" />
							<?php if ($post_result[ 'link' ]) : ?></a><?php endif; ?>
					</div>

				<?php endif; ?>

				<?php
				// There are two ways facebook can return the post message, this check witch one is correct and assigns it to a variable.
				if (array_key_exists('message', $post_result) && isset($post_result[ 'message' ])) {
					$post_message = $post_result[ 'message' ];
				} elseif (array_key_exists('story', $post_result) && isset($post_result[ 'story' ])) {
					$post_message = $post_result[ 'story' ];
				}
				if ($post_message) : ?>
					<div class="mapi-fb-message">
						<span class="mapi-fb-status">
							<?php echo mapi_word_limit(mapi_strip_url($post_message), $args[ "num_words" ]); ?>
						</span>
						<small class="mapi-fb-meta">
							<br>Posted to <a href="<?php mapi_option('facebook_uri'); ?>" title="Connect with <?php bloginfo('name'); ?> ' on Facebook" target="_blank">Facebook</a> on <?php echo $post_date ?>
						</small>
					</div>
				<?php endif; ?>

			</li>

		<?php } // endforeach;
		?>
	</ul>
	<?php
}

/**
 * Retrieves a Facebook username from a given URL or Facebook ID.
 *
 * @param null   $facebook_uri
 * @param string $lookup_type
 *
 * @return bool|int
 */
function mapi_get_facebook_username($facebook_uri = NULL, $lookup_type = 'uri') {
	$facebook_lookup = mapi_facebook_lookup($facebook_uri, $lookup_type);
	if (empty($facebook_lookup->username)) {
		return FALSE;
	} else {
		return intval($facebook_lookup->username);
	}
}

/**
 * Outputs a Facebook username from a given URL or Facebook ID.
 *
 * @param null   $facebook_uri
 * @param string $lookup_type
 */
function mapi_facebook_username($facebook_uri = NULL, $lookup_type = 'uri') {
	echo mapi_get_facebook_username($facebook_uri, $lookup_type);
}

/**
 * Retrieves a Facebook ID from a given URL or Facebook username.
 *
 * @param null   $facebook_uri
 * @param string $lookup_type
 *
 * @return bool|int
 */
function mapi_get_facebook_id($facebook_uri = NULL, $lookup_type = 'uri') {
	$facebook_lookup = mapi_facebook_lookup($facebook_uri, $lookup_type);
	if (empty($facebook_lookup->id)) {
		return FALSE;
	} else {
		return intval($facebook_lookup->id);
	}
}

/**
 * Outputs a Facebook ID from a given URL or Facebook username.
 *
 * @param null   $facebook_uri
 * @param string $lookup_type
 */
function mapi_facebook_id($facebook_uri = NULL, $lookup_type = 'uri') {
	echo mapi_get_facebook_id($facebook_uri, $lookup_type);
}

/**
 * Performs a Facebook Open Graph API lookup and returns a standard PHP object with the results.
 * Accepts a Facebook URL, ID, or username.
 *
 * @param null   $facebook_uri
 * @param string $lookup_type
 *
 * @return array|bool|mixed
 */
function mapi_facebook_lookup($facebook_uri = NULL, $lookup_type = 'uri') {
	if (!isset($facebook_uri)) {
		$facebook_uri = mapi_get_option('facebook_uri');
		$lookup_type = 'uri';
	}
	if (empty($facebook_uri)) {
		return FALSE;
	}

	if ($lookup_type == 'username' || $lookup_type == 'id') {
		$facebook_lookup_uri = 'https://graph.facebook.com/' . $facebook_uri;
	} else {
		$facebook_uri = parse_url($facebook_uri);
		$facebook_lookup_uri = 'https://graph.facebook.com/' . $facebook_uri[ 'path' ];
	}
	$token = mapi_facebook_access_token();
	$facebook_graph_api_request = wp_remote_get($facebook_lookup_uri . '?access_token=' . $token[ 'graph_access_token' ] . '|' . $token[ 'graph_access_token_secret' ]);

	//mapi_var_dump($facebook_graph_api_request, 1);

	if (!is_a($facebook_graph_api_request, 'WP_Error')) {
		$response = json_decode(wp_remote_retrieve_body($facebook_graph_api_request));

		if (empty($response)) {
			return FALSE;
		} else {
			return $response;
		}
	} else {
		return FALSE;
	}
}

/**
 * Add a Facebook Like button to a page or post.
 *
 * @param array $args Settings array with the following defaults:
 *                    'href' => get_permalink(get_the_ID()), // url to like
 *                    'width' => 120, // integer
 *                    'send' => 'false', // boolean
 *                    'show_faces' => 'false', // boolean
 *                    'layout' => 'button_count', // standard, button_count, box_count
 *                    'action' => 'like', // 'like', 'recommend'
 *                    'colorscheme' => 'light', // light, dark
 *                    'font' => 'segoe ui' // 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
 *
 * @see https://developers.facebook.com/docs/reference/plugins/like/
 */
function mapi_facebook_like($args) {

	$defaults = array(
		'href'        => get_permalink(get_the_ID()), // url to like
		'width'       => 120, // integer
		'send'        => 'false', // boolean
		'show_faces'  => 'false', // boolean
		'layout'      => 'button_count', // standard, button_count, box_count
		'action'      => 'like', // 'like', 'recommend'
		'colorscheme' => 'light', // light, dark
		'font'        => 'segoe ui' // 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
	);
	$args = wp_parse_args($args, $defaults);

	?>
	<!-- Facebook Like button -->
	<div id="fb-root" class="mcms-social"></div>
	<script type="text/javascript">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[ 0 ];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="fb-like"
		 data-href="<?php echo $args[ 'href' ]; ?>"
		 data-send="<?php echo $args[ 'send' ]; ?>"
		 data-layout="<?php echo $args[ 'layout' ]; ?>"
		 data-width="<?php echo $args[ 'width' ]; ?>"
		 data-show-faces="<?php echo $args[ 'show_faces' ]; ?>"
		 data-action="<?php echo $args[ 'action' ]; ?>"
		 data-colorscheme="<?php echo $args[ 'colorscheme' ]; ?>"
		 data-font="<?php echo $args[ 'font' ]; ?>">
	</div>
	<?php
}

/**
 * Adds Facebook Open Graph API stuff to head
 */
function mapi_facebook_head() {
	if (is_singular()) : ?>
		<meta property="fb:admins" content="<?php mapi_facebook_id(); ?>" />
		<meta property="og:title" content="<?php echo get_the_title_rss(); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?php the_permalink_rss(); ?>" />
		<meta property="og:site_name" content="<?php bloginfo_rss('name'); ?>" />
		<?php
		// the post does not have featured image, use a default image
		if (!has_post_thumbnail(get_the_ID())) : ?>
			<meta property="og:image" content="<?php echo get_template_directory_uri() . '/img/nothumb.gif'; ?>" />
		<?php else : ?>
			<meta property="og:image" content="<?php echo esc_attr(mapi_get_attachment_image_src(NULL, 'medium')); ?>" />
		<?php endif; ?>
	<?php endif;
}

/**
 * Open Graph meta tags and language attributes (for IE)
 *
 * @param $output
 *
 * @return string
 */
function mapi_add_opengraph_doctype($output) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

/**
 * Returns a Mindshare API Open Graph access token
 *
 * @return array graph_access_token, graph_access_token_secret
 */
function mapi_facebook_access_token() {

	/**
	 * MAPI access token settings
	 */
	$settings = array(
		'graph_access_token'        =>
			apply_filters('mapi_facebook_graph_app_ID', "1175764625827481"),
		'graph_access_token_secret' =>
			apply_filters('mapi_facebook_graph_app_secret', "9b0b6f154e6fa8aeda2bce18bb86aaa5"),
	);

	return $settings;
}
