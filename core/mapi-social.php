<?php
/**
 * Mindshare Theme API MISC SOCIAL FUNCTIONS
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-social.php
 * @since      File available since Rev 72
 */


/**
 * Adds a Google +1 Button to a page or post.
 *
 * @param array $args Settings array with following defaults:
 *                    'href' => get_permalink(get_the_ID()), // url to plus one
 *                    'width' => 'medium', // small, medium, standard, tall
 *                    'annotation' => 'none', // none, bubble, inline
 *                    'size' => 120, // 120 is smallest, default is 450
 *                    'callback' => NULL // JS callback function name, function(jsonParamObj)
 *
 * @see https://developers.google.com/+/plugins/+1button/
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

	?>
	<!-- Google +1 button -->
	<div class="g-plusone mcms-social" data-size="<?php echo $args[ 'width' ]; ?>" data-annotation="<?php echo $args[ 'annotation' ]; ?>" data-href="<?php echo $args[ 'href' ]; ?>"
		<?php if ($args[ 'annotation' ] == 'inline') { ?> data-width="<?php echo $args[ 'size' ]; ?>" <?php } ?>
		<?php if (!empty($args[ 'callback' ])) { ?> callback="<?php echo $var; ?>" <?php } ?>></div>
	<script type="text/javascript">
		(function() {
			var po = document.createElement('script');
			po.type = 'text/javascript';
			po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[ 0 ];
			s.parentNode.insertBefore(po, s);
		})();
	</script>
	<?php
}

/**
 * Adds a hidden div with HTML5 Microdata for posts.
 *
 * @see http://support.google.com/webmasters/bin/answer.py?hl=en&answer=99170 for info on rich snippets
 */
function mapi_rich_snippets() {

	$schema = apply_filters('mapi_rich_snippets_schema', 'https://data-vocabulary.org/Organization');
	$class = apply_filters('mapi_rich_snippets_class', 'microdata-meta hide contact');

	if (function_exists('mapi_option')) : ?>
		<div itemscope itemtype="<?php echo $schema; ?>" class="<?php echo $class; ?>">
			<?php if (mapi_get_option('sitename_txt')) : ?>
				<meta itemprop="name" content="<?php mapi_option('sitename_txt'); ?>" />
			<?php endif; ?>

			<?php if (mapi_get_option('phone_txt')) : ?>
				<meta itemprop="tel" content="<?php mapi_option('phone_txt'); ?>" />
			<?php endif; ?>
			<?php if (mapi_get_option('email')) : ?>
				<meta itemprop="email" content="<?php echo antispambot(mapi_get_option('email')) ?>" />
			<?php endif; ?>

			<meta itemprop="url" content="<?php echo home_url(); ?>" />

			<?php if (get_bloginfo('description')) : ?>
				<meta itemprop="description" content="<?php bloginfo('description') ?>" />
			<?php endif; ?>

			<?php if (mapi_get_option('gmaps_uri')) : ?>
				<meta itemprop="map" content="<?php mapi_option("gmaps_uri"); ?>" />
			<?php endif; ?>

			<address itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">

				<?php if (mapi_get_option('addr1_txt')) : ?>
					<span itemprop="streetAddress">
						<?php mapi_option('addr1_txt'); ?>
					</span><br />
				<?php endif; ?>

				<?php if (mapi_get_option('city_txt')) : ?>
					<span itemprop="addressLocality"><?php mapi_option('city_txt'); ?></span>,
				<?php endif; ?>

				<?php if (mapi_get_option('state')) : ?>
					<span itemprop="addressRegion"><?php mapi_option('state'); ?></span><br />
				<?php endif; ?>

				<?php if (mapi_get_option('zip_txt')) : ?>
					<span itemprop="postalCode"><?php mapi_option("zip_txt"); ?></span>
				<?php endif; ?>

				<?php if (mapi_get_option('country')) : ?>
					<span itemprop="addressCountry"><?php mapi_option("country"); ?></span>
				<?php endif; ?>
			</address>

			<?php if (mapi_get_option('lat_txt')) : ?>
				<span itemprop="geo" itemscope itemtype="https://data-vocabulary.org/Geo">
					<meta itemprop="latitude" content="<?php mapi_option('lat_txt'); ?>" />
					<meta itemprop="longitude" content="<?php mapi_option('long_txt'); ?>" />
				</span>
			<?php endif; ?>
		</div>
	<?php endif;
}

/**
 * Outputs Font Awesome social icon links wrapped in a DIV.
 *
 * @todo add callback function to allow plugging in new networks?
 *
 * @param array  $networks        An array of the social networks to include. Currently supported options are: facebook, twitter, instagram, linkedin, google-plus, pinterest, tumblr, youtube, rss, email.
 * @param string $share_or_follow Whether to return "sharing" links or "follow" links. Valid options are: 'share' or 'follow'. Default is 'share'.
 * @param bool   $echo            Output or return the HTML. Default is TRUE.
 * @param bool   $js              Open links in a JavaScript popup window. Default is FALSE.
 */
function mapi_social_links($networks = array(), $share_or_follow = 'share', $echo = TRUE, $js = FALSE) {

	if (empty($networks) || !is_array($networks)) {
		$networks = array(
			'facebook',
			'twitter',
			'instagram',
			'linkedin',
			'google-plus',
			'pinterest',
			'tumblr',
			'youtube',
			'rss',
			'email',
		);
	}
	//mapi_var_dump($networks);
	if ($share_or_follow == 'share') {
		$share = TRUE;
	} else {
		$share = FALSE;
	}

	$mapi_social_links_class = apply_filters('mapi_social_link_class', 'mapi-social-link');
	if ($echo == TRUE) {
		echo apply_filters('mapi_social_links_before', '<div class="mapi-social-links">');

		do_action('mapi_social_links_insert_before');

		foreach ($networks as $network) {
			if ($js == TRUE) {
				mapi_social_link_js(array('network' => $network, 'share' => $share, 'class' => $mapi_social_links_class));
			} else {
				mapi_social_link(array('network' => $network, 'share' => $share, 'class' => $mapi_social_links_class));
			}
		}

		do_action('mapi_social_links_insert_after');

		echo apply_filters('mapi_social_links_after', '</div>');
	} else {
		foreach ($networks as $network) {
			mapi_social_link(array('network' => $network, 'share' => $share, 'echo' => FALSE, 'class' => $mapi_social_links_class));
		}
	}
}

/**
 * Returns or outputs a social link for a post.
 *
 * @param $args array [string]class    CSS class for the A tag.
 * @param $args array [bool]echo    Echo or return link.
 * @param $args array [string]id    Post ID for share/like button.
 * @param $args array [string]network Social network name. Must match Font Awesome naming conventions.
 * @param $args array [bool]nofollow        Output nofollow attribute.
 * @param $args array [string]share         Output a share or follow us link href.
 * @param $args array [string]target     Link target attribute.
 * @param $args array [string]title         Link title attribute.
 *
 * @return string
 */
function mapi_social_link($args) {
	if (!is_array($args)) {
		return mapi_error(array('msg' => 'Fatal error: ' . __FUNCTION__ . ' must be passed an array.'));
	}
	$defaults = array(
		'class'    => apply_filters('mapi_social_link_class', 'mapi-social-link'),
		'echo'     => TRUE,
		'id'       => get_the_ID(),
		'network'  => NULL,
		'nofollow' => TRUE,
		'share'    => TRUE,
		'target'   => '_blank',
		'title'    => NULL,
	);
	$args = wp_parse_args($args, $defaults);

	if (empty($args[ 'network' ])) {
		return mapi_error(array('msg' => 'No social network was specified.'));
	} else {
		$args[ 'network' ] = trim(strtolower($args[ 'network' ]));
	}

	if (empty($args[ 'title' ])) {
		if ($args[ 'share' ]) {
			$args[ 'title' ] = 'Share this ' . get_post_type($args[ 'id' ]) . ' on ' . ucwords($args[ 'network' ]);
		} else {
			$args[ 'title' ] = 'Follow ' . get_bloginfo_rss('name') . ' on ' . ucwords($args[ 'network' ]);
		}
		if ($args[ 'network' ] == 'rss') {
			$args[ 'title' ] = get_bloginfo_rss('name') . ' RSS feed';
		}
	}

	$link = '<a class="';

	$link .= $args[ 'class' ] . ' ' . sanitize_title($args[ 'network' ]) . '" ';

	if ($args[ 'nofollow' ]) {
		$link .= 'rel="nofollow" ';
	}

	$link .= 'data-placement="top" ';
	$link .= 'target="' . $args[ 'target' ] . '" ';
	$link .= 'title="' . apply_filters('mapi_social_link_title_attribute', $args[ 'title' ]) . '" ';
	$link .= 'href="';

	if ($args[ 'share' ]) {
		$link .= _mapi_social_share_href($args[ 'network' ], $args[ 'id' ]);
	} else {
		$link .= _mapi_social_follow_href($args[ 'network' ], $args[ 'id' ]);
	}

	// for the most part FA classes work, but not for "email"
	if ($args[ 'network' ] == 'email') {
		$args[ 'network' ] = 'envelope-square';
	}
	$link .= '"><i class="fa fa-' . $args[ 'network' ] . '">&nbsp;</i></a>';

	if ($args[ 'echo' ]) {
		echo apply_filters('mapi_social_link', $link);
	} else {
		return apply_filters('mapi_social_link', $link);
	}
}

/**
 * Returns or outputs a social link for a post that opens with a JavaScript popup..
 *
 * @param $args array [string]class    CSS class for the A tag.
 * @param $args array [bool]echo    Echo or return link.
 * @param $args array [string]id    Post ID for share/like button.
 * @param $args array [string]network Social network name. Must match Font Awesome naming conventions.
 * @param $args array [bool]nofollow        Output nofollow attribute.
 * @param $args array [string]share         Output a share or follow us link href.
 * @param $args array [string]target     Link target attribute.
 * @param $args array [string]title         Link title attribute.
 *
 * @return string
 */
function mapi_social_link_js($args) {
	if (!is_array($args)) {
		return mapi_error(array('msg' => 'Fatal error: ' . __FUNCTION__ . ' must be passed an array.'));
	}
	$defaults = array(
		'class'    => apply_filters('mapi_social_link_class', 'mapi-social-link'),
		'echo'     => TRUE,
		'id'       => get_the_ID(),
		'network'  => NULL,
		'nofollow' => TRUE,
		'share'    => TRUE,
		//'target'   => '_blank',
		'title'    => NULL,
	);
	$args = wp_parse_args($args, $defaults);

	// no popup option makes sense for 'follow' button, so we'll bail out to the other fn
	if (!$args[ 'share' ]) {
		return mapi_social_link($args);
	}

	$win_w = apply_filters('mapi_social_link_js_width', 626);
	$win_h = apply_filters('mapi_social_link_js_height', 436);

	if (empty($args[ 'network' ])) {
		return mapi_error(array('msg' => 'No social network was specified.'));
	} else {
		$args[ 'network' ] = trim(strtolower($args[ 'network' ]));
	}

	if (empty($args[ 'title' ])) {

		$args[ 'title' ] = 'Share this ' . get_post_type($args[ 'id' ]) . ' on ' . ucwords($args[ 'network' ]);

		if ($args[ 'network' ] == 'rss') {
			$args[ 'title' ] = get_bloginfo_rss('name') . ' RSS feed';
		}
	}

	$link = PHP_EOL;
	$link .= '<a class="';

	$link .= $args[ 'class' ] . ' ' . sanitize_title($args[ 'network' ]) . '" ';

	if ($args[ 'nofollow' ]) {
		$link .= 'rel="nofollow" ';
	}

	$link .= 'title="' . apply_filters('mapi_social_link_title_attribute', $args[ 'title' ]) . '" ';
	$link .= 'href="#" ';
	$link .= 'onclick="window.open(\'';

	$link .= _mapi_social_share_onclick($args[ 'network' ], $args[ 'id' ]);

	$link .= ",'mapi-share-dialog','width=" . $win_w . ",height=" . $win_h . ",left=20,top=20'); return false;";

	// for the most part FA classes work, but not for "email"
	if ($args[ 'network' ] == 'email') {
		$args[ 'network' ] = 'envelope-square';
	}
	$link .= '"><i class="fa fa-' . $args[ 'network' ] . '">&nbsp;</i></a>';

	if ($args[ 'echo' ]) {
		echo apply_filters('mapi_social_link', $link);
	} else {
		return apply_filters('mapi_social_link', $link);
	}
}

/**
 * Builds required HREF for sharing on various social networks.
 *
 * @param $network
 * @param $id
 *
 * @return string
 */
function _mapi_social_share_href($network, $id) {
	switch ($network) {
		case 'twitter' :
			$href = 'http://twitter.com/home?status=' . get_permalink($id);
			break;
		case 'facebook' :
			$href = 'http://www.facebook.com/sharer.php?u=' . get_permalink($id) . '&amp;t=' . urlencode(get_the_title_rss($id));
			break;
		case 'instagram' :
			// instagram doesn't have a "share" feature so we'll use the "follow" format instead
			$href = _mapi_social_follow_href('instagram', $id);
			break;
		case 'google-plus' :
			$href = 'https://plus.google.com/share?url=' . get_permalink($id);
			break;
		case 'pinterest' :
			$href = 'http://www.pinterest.com/pin/create/link/?url=' . get_permalink($id) . '&amp;media=' . urlencode(mapi_get_attachment_image_src(mapi_get_attachment_id($id))) . '&amp;description=' . urlencode(get_the_title_rss($id));
			break;
		case 'linkedin' :
			$href = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . get_permalink($id) . '&amp;title=' . urlencode(get_the_title_rss($id));
			//&amp;summary={articleSummary}&amp;source={articleSource};
			break;
		case 'tumblr' :
			$href = 'http://www.tumblr.com/share/link?url=' . urlencode(get_permalink($id)) . '&amp;name=' . urlencode(get_the_title_rss($id)); // &amp;description=
			break;
		case 'youtube' :
			// youtube doesn't have a "share" feature so we'll use the "follow" format instead
			$href = _mapi_social_follow_href('youtube', $id);
			break;
		case 'rss' :
			// rss doesn't have a "share" feature so we'll use the "follow" format instead
			$href = _mapi_social_follow_href('rss', $id);
			break;
		case 'email' :
			$href = 'mailto:?body=' . urlencode(apply_filters('mapi_social_mailto_body', 'Check out this ' . get_post_type() . ': ' . get_permalink($id)) . '&subject=' . get_the_title_rss($id));
			break;
	}

	return apply_filters('mapi_social_share_href', $href, $network);
}

/**
 * Builds required JavScript onclick window.open event for sharing on various social networks.
 *
 * @param $network
 * @param $id
 *
 * @return string
 */
function _mapi_social_share_onclick($network, $id) {
	switch ($network) {
		case 'twitter' :
			$onclick = "https://twitter.com/share?url='+encodeURIComponent(location.href)";
			break;
		case 'facebook' :
			$onclick = 'https://www.facebook.com/sharer.php?u=\'+encodeURIComponent(location.href)+\'&amp;t=' . urlencode(get_the_title_rss($id)) . '\'';
			break;
		case 'google-plus' :
			$onclick = 'https://plus.google.com/share?url=' . get_permalink($id) . '\'';
			break;
		case 'pinterest' :
			$onclick = 'https://www.pinterest.com/pin/create/link/?url=' . get_permalink($id) . '&amp;media=' . urlencode(mapi_get_attachment_image_src(mapi_get_attachment_id($id))) . '&amp;description=' . urlencode(get_the_title_rss($id)) . '\'';
			break;
		case 'linkedin' :
			$onclick = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=\'+encodeURIComponent(location.href)+\'&amp;title=' . urlencode(get_the_title_rss($id)) . '\'';
			break;
		case 'tumblr' :
			$onclick = 'https://www.tumblr.com/share/link?url=' . urlencode(get_permalink($id)) . '&amp;name=' . urlencode(get_the_title_rss($id)) . '\'';
			break;
		case 'youtube' :
			// youtube doesn't have a "share" feature so we'll use the "follow" format instead
			$onclick = _mapi_social_follow_href('youtube', $id) . '\'';
			break;
		case 'rss' :
			// rss doesn't have a "share" feature so we'll use the "follow" format instead
			$onclick = _mapi_social_follow_href('rss', $id) . '\'';
			break;
		case 'email' :
			$onclick = 'mailto:?body=' . urlencode(apply_filters('mapi_social_mailto_body', 'Check out this ' . get_post_type() . ': ' . get_permalink($id)) . '&amp;subject=' . get_the_title_rss($id)) . '\'';
			break;
		case 'instagram' :
			mapi_console_log('Instagram doesn\'t have a share feature, so no link has been output');
			break;
	}

	return apply_filters('mapi_social_share_onclick', $onclick, $network);
}

/**
 * Builds required HREF for following on various social networks.
 *
 * @param $network
 * @param $id
 *
 * @return string
 */
function _mapi_social_follow_href($network, $id) {
	switch ($network) {
		case 'twitter' :
			$href = mapi_get_option('twitter_uri');
			break;
		case 'facebook' :
			$href = mapi_get_option('facebook_uri');
			break;
		case 'instagram' :
			$href = "https://instagram.com/" . mapi_get_option('instagram_id_slug'); // @TODO make this match the others?
			break;
		case 'google-plus' :
			$href = mapi_get_option('google_plus_uri');
			break;
		case 'pinterest' :
			$href = mapi_get_option('pinterest_uri');
			break;
		case 'linkedin' :
			$href = mapi_get_option('linkedin_uri');
			break;
		case 'tumblr' :
			$href = mapi_get_option('tumblr_uri');
			break;
		case 'youtube' :
			$href = mapi_get_option('youtube_uri');
			break;
		case 'rss' :
			$href = get_feed_link(); //rss2
			break;
		case 'email' :
			$href = _mapi_social_share_href('email', $id); //rss2
			break;
	}

	return apply_filters('mapi_social_follow_href', $href, $network);
}

/**
 * Retrieves public Tweets from a user's timeline using the new Twitter OAuth API. Replaces the deprecated mapi_tweets function.
 *
 * @todo add caching?
 *
 * @param $args array [string]screen_name A Twitter screen name, default: NULL
 * @param $args array [int]num_tweets Number of Tweets to retrieve, default: 4
 * @param $args array [bool]echo Whether to echo or return the result, default: TRUE
 * @param $args array [array]oauth Filterable array of OAuth settings for Twitter API app. Optional.
 *
 * @return array|mixed
 */
function mapi_tweets_oauth($args) {

	if (!class_exists('TwitterAPIExchange')) {
		require_once(MAPI_DIR_PATH . 'vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
	}

	//  Set access tokens here - see: https://dev.twitter.com/apps/
	$settings = array(
		'oauth_access_token'        =>
			apply_filters('mapi_twitter_oauth_access_token', "45686564-2vwoGVrN88RScUl6TOqr5guSYBbzQ3DOWAbWLRq7R"),
		'oauth_access_token_secret' =>
			apply_filters('mapi_twitter_oauth_access_token_secret', "g1J8oT2il0ruIJtbr2zyZqM2O59m2PKvN6CdPeYealu1c"),
		'consumer_key'              =>
			apply_filters('mapi_twitter_consumer_key', "wOgvxmU8JYXjfXGnolhXsNtPV"),
		'consumer_secret'           =>
			apply_filters('mapi_twitter_consumer_secret', "26l1pgAgmblBb8l5Vi6JD2ybmrTVHc5X5arBwiZAhskqzZI5ff"),
	);

	$defaults = array(
		'screen_name' => NULL,
		'num_tweets'  => 4,
		'echo'        => TRUE,
		'oauth'       => $settings,
	);
	$args = wp_parse_args($args, $defaults);

	if (empty($args[ 'screen_name' ])) {
		return mapi_error(array('msg' => 'A valid Twitter screen name is required.'));
	}

	//  Perform a GET request and echo the response, note: Set the GET field BEFORE calling buildOauth();
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name=' . $args[ 'screen_name' ];
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$tweets = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());

	if ($tweets) {
		$tweets = array_slice($tweets, 0, $args[ 'num_tweets' ]);
		if ($args[ 'echo' ]) {
			echo '<ul class="mapi-twitter-feed mapi-twitter-rss">';
			foreach ($tweets as $tweet) : ?>
				<li>
					<span class="mapi-tweet-link"><?php echo $tweet->text; ?></span><br />
					<span class="mapi-tweet-meta">Posted to <a class="mapi-tweet-link" href='https://twitter.com/<?php echo $args[ 'screen_name' ]; ?>/status/<?php echo $tweet->id; ?>' title='<?php echo 'Posted ' . $tweet->created_at; ?>'>Twitter</a> on <?php echo $tweet->created_at; ?>
												  by <a href="https://twitter.com/<?php echo $args[ 'screen_name' ]; ?>" title="Connect with <?php bloginfo('name'); ?> on Twitter" target="_blank"><?php echo $args[ 'screen_name' ]; ?></a></span>
				</li>
				<?php
			endforeach;
			echo '</ul>';
		} else {
			return $tweets;
		}
	} else {
		mapi_error(array('msg' => 'Could not retrieve Twitter timeline: ' . $url, 'die' => FALSE, 'echo' => FALSE));
	}
}

/**
 * Loads MAPI Social CSS
 * <code>add_action('wp_enqueue_scripts', 'mapi_social_css');</code>
 */
function mapi_social_css() {
	if (!is_admin()) {
		wp_deregister_style('mapi-social');
		wp_register_style('mapi-social', MAPI_DIR_URL . 'css/social.css');
		wp_enqueue_style('mapi-social');
	}
}

/**
 * Loads MAPI Embed CSS
 * <code>add_action('wp_enqueue_scripts', 'mapi_embed_css');</code>
 */
function mapi_embed_css() {
	if (!is_admin()) {
		wp_deregister_style('mapi-embed');
		wp_register_style('mapi-embed', MAPI_DIR_URL . 'css/embed.css');
		wp_enqueue_style('mapi-embed');
	}
}

