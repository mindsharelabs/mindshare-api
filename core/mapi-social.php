<?php
/**
 * Mindshare Theme API SOCIAL FUNCTIONS
 *
 *
 * @author     Mindshare Studios, Inc.
 * @copyright  Copyright (c) 2014
 * @link       http://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-social.php
 * @since      File available since Rev 72
 *
 * @todo       Add Twitter API and Tweet button
 * @todo       Add Pinterest API
 *
 */

/**
 * Retrieves a Facebook username from a given URL or Facebook ID.
 *
 * @param null   $facebook_uri
 *
 * @param string $lookup_type
 *
 * @return bool|int
 */
function mapi_get_facebook_username($facebook_uri = NULL, $lookup_type = 'uri') {
	$facebook_lookup = mapi_facebook_lookup($facebook_uri, $lookup_type);
	if(empty($facebook_lookup->username)) {
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
 *
 * Retrieves a Facebook ID from a given URL or Facebook username.
 *
 * @param null   $facebook_uri
 *
 * @param string $lookup_type
 *
 * @return bool|int
 */
function mapi_get_facebook_id($facebook_uri = NULL, $lookup_type = 'uri') {
	$facebook_lookup = mapi_facebook_lookup($facebook_uri, $lookup_type);
	if(empty($facebook_lookup->id)) {
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
 *
 * @param string $lookup_type
 *
 * @return array|bool|mixed
 */
function mapi_facebook_lookup($facebook_uri = NULL, $lookup_type = 'uri') {
	if(!isset($facebook_uri)) {
		$facebook_uri = mapi_get_option('facebook_uri');
		$lookup_type = 'uri';
	}
	if(empty($facebook_uri)) {
		return FALSE;
	}

	if($lookup_type == 'username' || $lookup_type == 'id') {
		$facebook_lookup_uri = 'https://graph.facebook.com'.$facebook_uri;
	} else {
		$facebook_uri = parse_url($facebook_uri);
		$facebook_lookup_uri = 'https://graph.facebook.com'.$facebook_uri['path'];
	}

	$facebook_graph_api_request = wp_remote_get($facebook_lookup_uri);
	if(!is_a($facebook_graph_api_request, 'WP_Error')) {
		$response = json_decode(wp_remote_retrieve_body($facebook_graph_api_request));
		if(empty($response)) {
			return FALSE;
		} else {
			return $response;
		}
	} else {
		return FALSE;
	}
}

/**
 *
 * Returns or outputs recent status updates from Facebook in an unordered list HTML tag
 * with the CSS class "mapi-facebook-rss".
 *
 * @param array $args An array of settings that includes the following defaults:
 *                    'rss_uri' => NULL,
 *                    'num_items' => 4,
 *                    'num_words' => 7,
 *                    'echo' => TRUE
 *
 * @return string Formatted HTML string of Facebook status updates.
 */
function mapi_facebook_rss($args = array()) {

	$defaults = array(
		'rss_uri'   => NULL,
		'num_items' => 4,
		'num_words' => 7,
		'echo'      => TRUE
	);
	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	if(empty($rss_uri)) {
		// nothing was passed in so let's see if wee can build the proper URL based on API settings
		$facebook_id = mapi_get_facebook_id();
		if($facebook_id) {
			$rss_uri = 'https://www.facebook.com/feeds/page.php?id='.$facebook_id.'&format=rss20';
		} else {
			return mapi_error(array('msg' => 'Facebook RSS URI is required'));
		}
	}

	// include WP RSS functions
	include_once(ABSPATH.WPINC.'/feed.php');

	// fetch the feed
	$rss = fetch_feed($rss_uri);
	if(!is_wp_error($rss)) {
		$maxitems = $rss->get_item_quantity($num_items);
		$rss_items = $rss->get_items(0, $maxitems);
	}

	// parse the feed
	if($maxitems != 0) {
		if($echo) {
			echo '<ul class="mapi-facebook-rss">';
			foreach($rss_items as $item) {
				?>
				<?php if($item->get_title() != '') : ?>
					<li>
						<span class="mapi-fb-link"><a class="mapi-fb-link" href='<?php echo $item->get_permalink(); ?>' title='<?php echo 'Posted '.$item->get_date('m/d/y | g:i a'); ?>'><?php echo mapi_word_limit(mapi_strip_url($item->get_title()), $num_words); ?></a>...</span><br /><span class="mapi-fb-meta">Posted to <a href="<?php mapi_option('facebook_uri'); ?>" title="Connect with <?php bloginfo('name'); ?> on Facebook" target="_blank">Facebook</a> on <?php echo $item->get_date('m/d/y @ g:i a'); ?></span>
					</li>
				<?php else : ?>
					<li>
						<span class="mapi-fb-link"><a class="mapi-fb-link" href='<?php echo $item->get_permalink(); ?>' title='<?php echo 'Posted '.$item->get_date('m/d/y | g:i a'); ?>'><?php echo mapi_word_limit(strip_tags(mapi_strip_url($item->get_description())), $num_words); ?></a>...</span><br /><span class="mapi-fb-meta">Posted to <a href="<?php mapi_option('facebook_uri'); ?>" title="Connect with <?php bloginfo('name'); ?> on Facebook" target="_blank">Facebook</a> on <?php echo $item->get_date('m/d/y @ g:i a'); ?></span>
					</li>
				<?php endif; ?>
			<?php
			}
			echo '</ul>';
		} else {
			return $rss_items;
		}
	} else {
		return mapi_error(array('msg' => 'No Facebook status updates were found in the feed at '.$rss_uri, 'echo' => TRUE, 'die' => FALSE));
	}
}

/**
 *
 * Add a Facebook Like button to a page or post.
 *
 * @param array $args Settings array with the following defaults:
 *
 *          'href' => get_permalink(get_the_ID()), // url to like
 *          'width' => 120, // integer
 *          'send' => 'false', // boolean
 *          'show_faces' => 'false', // boolean
 *          'layout' => 'button_count', // standard, button_count, box_count
 *          'action' => 'like', // 'like', 'recommend'
 *          'colorscheme' => 'light', // light, dark
 *          'font' => 'segoe ui' // 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
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
	extract($args, EXTR_SKIP);

	?>
	<!-- Facebook Like button -->
	<div id="fb-root" class="mcms-social"></div>
	<script type="text/javascript">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if(d.getElementById(id)) {
				return;
			}
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="fb-like"
		 data-href="<?php echo $href; ?>"
		 data-send="<?php echo $send; ?>"
		 data-layout="<?php echo $layout; ?>"
		 data-width="<?php echo $width; ?>"
		 data-show-faces="<?php echo $show_faces; ?>"
		 data-action="<?php echo $action; ?>"
		 data-colorscheme="<?php echo $colorscheme; ?>"
		 data-font="<?php echo $font; ?>">
	</div>
<?php
}


/**
 * Adds Facebook Open Graph API stuff to head
 *
 */
function mapi_facebook_head() {
	if(is_singular()) : ?>
		<meta property="fb:admins" content="<?php mapi_facebook_id(); ?>" />
		<meta property="og:title" content="<?php echo get_the_title_rss(); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?php the_permalink_rss(); ?>" />
		<meta property="og:site_name" content="<?php bloginfo_rss('name'); ?>" />
		<?php if(!has_post_thumbnail(get_the_ID())) : // the post does not have featured image, use a default image ?>
			<meta property="og:image" content="<?php echo get_template_directory_uri().'/img/nothumb.gif'; ?>" />
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
	return $output.' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

/**
 *
 * Adds a Google +1 Button to a page or post.
 *
 * @param array $args Settings array with following defaults:
 *
 *          'href' => get_permalink(get_the_ID()), // url to plus one
 *          'width' => 'medium', // small, medium, standard, tall
 *          'annotation' => 'none', // none, bubble, inline
 *          'size' => 120, // 120 is smallest, default is 450
 *          'callback' => NULL // JS callback function name, function(jsonParamObj)
 *
 * @see https://developers.google.com/+/plugins/+1button/
 *
 */
function mapi_google_plus_one($args) {
	$defaults = array(
		'href'       => get_permalink(get_the_ID()), // url to plus one
		'width'      => 'medium', // small, medium, standard, tall
		'annotation' => 'none', // none, bubble, inline
		'size'       => 120, // 120 is smallest, default is 450
		'callback'   => NULL // JS callback function name, function(jsonParamObj)
	);
	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	?>
	<!-- Google +1 button -->
	<div class="g-plusone mcms-social" data-size="<?php echo $width; ?>" data-annotation="<?php echo $annotation; ?>" data-href="<?php echo $href; ?>"
		<?php if($annotation == 'inline') { ?> data-width="<?php echo $size; ?>" <?php } ?>
		<?php if(!empty($callback)) { ?> callback="<?php echo $var; ?>" <?php } ?>></div>
	<script type="text/javascript">
		(function() {
			var po = document.createElement('script');
			po.type = 'text/javascript';
			po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		})();
	</script>
<?php
}

/**
 *
 * Grabs the latest tweets from a user's timeline.
 *
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
	$defaults = array(
		'screen_name' => NULL,
		'num_items'   => 4,
		'echo'        => TRUE
	);
	$args = wp_parse_args($args, $defaults);
	extract($args, EXTR_SKIP);

	if(empty($screen_name)) {
		return mapi_error(array('msg' => 'A valid Twitter screen name is required'));
	}

	if(function_exists('simplexml_load_file')) {
		$url = 'https://api.twitter.com/1/statuses/user_timeline.xml?screen_name='.$screen_name.'&count='.$num_items;
		$tweets_xml = @ simplexml_load_file($url); // error supression added to prevent issues when Twitter is down
		if($tweets_xml) {
			if($echo) {
				echo '<ul class="mapi-twitter-feed mapi-twitter-rss">';
				$tweets = $tweets_xml->xpath("/statuses/status");
				foreach($tweets as $tweet) : ?>
					<li>
						<span class="mapi-tweet-link"><?php echo $tweet->text; ?></span><br />
						<span class="mapi-tweet-meta">Posted to <a class="mapi-tweet-link" href='https://twitter.com/<?php echo $screen_name; ?>/status/<?php echo $tweet->id; ?>' title='<?php echo 'Posted '.$tweet->created_at; ?>'>Twitter</a> on <?php echo $tweet->created_at; ?>
							by <a href="https://twitter.com/<?php echo $screen_name; ?>" title="Connect with <?php bloginfo('name'); ?> on Twitter" target="_blank"><?php echo $screen_name; ?></a></span>
					</li>
				<?php
				endforeach;
				echo '</ul>';
			} else {
				return $tweets_xml;
			}
		} else {
			mapi_error(array('msg' => 'Could not retrieve Twitter XML: '.$url, 'die' => FALSE, 'echo' => FALSE));
		}
	} else {
		mapi_error(array('msg' => 'The PHP function simplexml_load_file was not found.', 'die' => FALSE, 'echo' => FALSE));
	}
}

/**
 * Adds a hidden div with HTML5 Microdata for posts.
 *
 * @see http://support.google.com/webmasters/bin/answer.py?hl=en&answer=99170 for info on rich snippets
 *
 */
function mapi_rich_snippets() {
	if(function_exists('mapi_option')) : ?>
		<div itemscope itemtype="http://data-vocabulary.org/Organization" class="microdata-meta hide contact">
			<meta itemprop="name" content="<?php mapi_option('sitename_txt'); ?>" />
			<meta itemprop="tel" content="<?php mapi_option('phone_txt'); ?>" />
			<meta itemprop="email" content="<?php mapi_option('email'); ?>" />
			<meta itemprop="url" content="<?php echo home_url(); ?>" />
			<address itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
				<span itemprop="street-address"><?php mapi_option('addr1_txt'); ?> <?php mapi_option('addr2_txt'); ?></span> <span itemprop="locality"><?php mapi_option('city_txt'); ?></span>
				<span itemprop="region"><?php mapi_option('state'); ?></span> <span itemprop="postal-code"><?php mapi_option('zip_txt'); ?></span>
			</address>
			<span itemprop="geo" itemscope itemtype="http://data-vocabulary.org/Geo">
				<meta itemprop="latitude" content="<?php mapi_option('lat_txt'); ?>" />
				<meta itemprop="longitude" content="<?php mapi_option('long_txt'); ?>" />
			</span>
		</div>
	<?php endif;
}
