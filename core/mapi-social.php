<?php
/**
 * Mindshare Theme API SOCIAL FUNCTIONS
 *
 *
 * @author     Mindshare Studios, Inc.
 * @copyright  Copyright (c) 2006-2015
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-social.php
 * @since      File available since Rev 72
 *
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

	if(empty($args['rss_uri'])) {
		// nothing was passed in so let's see if we can build the proper URL based on API settings
		$facebook_id = mapi_get_facebook_id();
		if($facebook_id) {
			$args['rss_uri'] = 'https://www.facebook.com/feeds/page.php?id='.$facebook_id.'&format=rss20';
		} else {
			return mapi_error(array('msg' => 'Facebook RSS URI is required'));
		}
	}

	// include WP RSS functions
	include_once(ABSPATH.WPINC.'/feed.php');

	// fetch the feed
	$rss = fetch_feed($args['rss_uri']);
	if(!is_wp_error($rss)) {
		$maxitems = $rss->get_item_quantity($args['num_items']);
		$rss_items = $rss->get_items(0, $maxitems);
	}

	// parse the feed
	if($maxitems != 0) {
		if($args['echo']) {
			echo '<ul class="mapi-facebook-rss">';
			foreach($rss_items as $item) {
				?>
				<?php if($item->get_title() != '') : ?>
					<li>
						<span class="mapi-fb-link"><a class="mapi-fb-link" href='<?php echo $item->get_permalink(); ?>' title='<?php echo 'Posted '.$item->get_date('m/d/y | g:i a'); ?>'><?php echo mapi_word_limit(mapi_strip_url($item->get_title()), $args['num_words']); ?></a>...</span><br /><span class="mapi-fb-meta">Posted to <a href="<?php mapi_option('facebook_uri'); ?>" title="Connect with <?php bloginfo('name'); ?> on Facebook" target="_blank">Facebook</a> on <?php echo $item->get_date('m/d/y @ g:i a'); ?></span>
					</li>
				<?php else : ?>
					<li>
						<span class="mapi-fb-link"><a class="mapi-fb-link" href='<?php echo $item->get_permalink(); ?>' title='<?php echo 'Posted '.$item->get_date('m/d/y | g:i a'); ?>'><?php echo mapi_word_limit(strip_tags(mapi_strip_url($item->get_description())), $args['num_words']); ?></a>...</span><br /><span class="mapi-fb-meta">Posted to <a href="<?php mapi_option('facebook_uri'); ?>" title="Connect with <?php bloginfo('name'); ?> on Facebook" target="_blank">Facebook</a> on <?php echo $item->get_date('m/d/y @ g:i a'); ?></span>
					</li>
				<?php endif; ?>
			<?php
			}
			echo '</ul>';
		} else {
			return $rss_items;
		}
	} else {
		return mapi_error(array('msg' => 'No Facebook status updates were found in the feed at '.$args['rss_uri'], 'echo' => TRUE, 'die' => FALSE));
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
		 data-href="<?php echo $args['href']; ?>"
		 data-send="<?php echo $args['send']; ?>"
		 data-layout="<?php echo $args['layout']; ?>"
		 data-width="<?php echo $args['width']; ?>"
		 data-show-faces="<?php echo $args['show_faces']; ?>"
		 data-action="<?php echo $args['action']; ?>"
		 data-colorscheme="<?php echo $args['colorscheme']; ?>"
		 data-font="<?php echo $args['font']; ?>">
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
		<?php
		// the post does not have featured image, use a default image
		if(!has_post_thumbnail(get_the_ID())) : ?>
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

	?>
	<!-- Google +1 button -->
	<div class="g-plusone mcms-social" data-size="<?php echo $args['width']; ?>" data-annotation="<?php echo $args['annotation']; ?>" data-href="<?php echo $args['href']; ?>"
		<?php if($args['annotation'] == 'inline') { ?> data-width="<?php echo $args['size']; ?>" <?php } ?>
		<?php if(!empty($args['callback'])) { ?> callback="<?php echo $var; ?>" <?php } ?>></div>
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

/**
 * Outputs Font Awesome social icon links wrapped in a DIV.
 *
 * @todo add Instagram
 * @todo add callback function to allow plugging in new networks?
 *
 * @param array  $networks        An array of the social networks to include. Currently supported options are: facebook, twitter, linkedin, google-plus, pinterest, tumblr, youtube, rss, email.
 * @param string $share_or_follow Whether to return "sharing" links or "follow" links. Valid options are: 'share' or 'follow'. Default is 'share'.
 * @param bool   $echo            Output or return the HTML. Default is TRUE.
 * @param bool   $js              Open links in a JavaScript popup window. Default is FALSE.
 *
 */
function mapi_social_links($networks = array(), $share_or_follow = 'share', $echo = TRUE, $js = FALSE) {

	if(empty($networks) || !is_array($networks)) {
		$networks = array(
			'facebook',
			'twitter',
			'linkedin',
			'google-plus',
			'pinterest',
			'tumblr',
			'youtube',
			'rss',
			'email'
		);
	}
	//mapi_var_dump($networks);
	if($share_or_follow == 'share') {
		$share = TRUE;
	} else {
		$share = FALSE;
	}
	if($echo == TRUE) {
		echo apply_filters('mapi_social_links_before', '<div class="mapi-social-links">');

		do_action('mapi_social_links_insert_before');

		foreach($networks as $network) {
			if($js == TRUE) {
				mapi_social_link_js(array('network' => $network, 'share' => $share));
			} else {
				mapi_social_link(array('network' => $network, 'share' => $share));
			}
		}

		do_action('mapi_social_links_insert_after');

		echo apply_filters('mapi_social_links_after', '</div>');
	} else {
		foreach($networks as $network) {
			mapi_social_link(array('network' => $network, 'share' => $share, 'echo' => FALSE));
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
	if(!is_array($args)) {
		return mapi_error(array('msg' => 'Fatal error: '.__FUNCTION__.' must be passed an array.'));
	}
	$defaults = array(
		'class'    => 'mapi-social-link',
		'echo'     => TRUE,
		'id'       => get_the_ID(),
		'network'  => NULL,
		'nofollow' => TRUE,
		'share'    => TRUE,
		'target'   => '_blank',
		'title'    => NULL,
	);
	$args = wp_parse_args($args, $defaults);

	if(empty($args['network'])) {
		return mapi_error(array('msg' => 'No social network was specified.'));
	} else {
		$args['network'] = trim(strtolower($args['network']));
	}

	if(empty($args['title'])) {
		if($args['share']) {
			$args['title'] = 'Share this '.get_post_type($args['id']).' on '.ucwords($args['network']);
		} else {
			$args['title'] = 'Follow '.get_bloginfo_rss('name').' on '.ucwords($args['network']);
		}
		if($args['network'] == 'rss') {
			$args['title'] = get_bloginfo_rss('name').' RSS feed';
		}
	}

	$link = '<a class="';

	$link .= $args['class'].' '.sanitize_title($args['network']).'" ';

	if($args['nofollow']) {
		$link .= 'rel="nofollow" ';
	}

	$link .= 'data-placement="top" ';
	$link .= 'target="'.$args['target'].'" ';
	$link .= 'title="'.apply_filters('mapi_social_link_title_attribute', $args['title']).'" ';
	$link .= 'href="';

	if($args['share']) {
		$link .= _mapi_social_share_href($args['network'], $args['id']);
	} else {
		$link .= _mapi_social_follow_href($args['network'], $args['id']);
	}

	// for the most part FA classes work, but not for "email"
	if($args['network'] == 'email') {
		$args['network'] = 'envelope-square';
	}
	$link .= '"><i class="fa fa-'.$args['network'].'">&nbsp;</i></a>';

	if($args['echo']) {
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
	if(!is_array($args)) {
		return mapi_error(array('msg' => 'Fatal error: '.__FUNCTION__.' must be passed an array.'));
	}
	$defaults = array(
		'class'    => 'mapi-social-link',
		'echo'     => TRUE,
		'id'       => get_the_ID(),
		'network'  => NULL,
		'nofollow' => TRUE,
		'share'    => TRUE,
		//'target'   => '_blank',
		'title'    => NULL,
	);
	$args = wp_parse_args($args, $defaults);

	$win_w = apply_filters('mapi_social_link_js_width', 626);
	$win_h = apply_filters('mapi_social_link_js_height', 436);

	if(empty($args['network'])) {
		return mapi_error(array('msg' => 'No social network was specified.'));
	} else {
		$args['network'] = trim(strtolower($args['network']));
	}

	if(empty($args['title'])) {
		if($args['share']) {
			$args['title'] = 'Share this '.get_post_type($args['id']).' on '.ucwords($args['network']);
		} else {
			$args['title'] = 'Follow '.get_bloginfo_rss('name').' on '.ucwords($args['network']);
		}
		if($args['network'] == 'rss') {
			$args['title'] = get_bloginfo_rss('name').' RSS feed';
		}
	}

	$link = PHP_EOL;
	$link .= '<a class="';

	$link .= $args['class'].' '.sanitize_title($args['network']).'" ';

	if($args['nofollow']) {
		$link .= 'rel="nofollow" ';
	}

	$link .= 'title="'.apply_filters('mapi_social_link_title_attribute', $args['title']).'" ';
	$link .= 'href="#" ';
	$link .= 'onclick="window.open(\'';

	if($args['share']) {
		$link .= _mapi_social_share_onclick($args['network'], $args['id']); // @TODO fix this stuff
	} else {
		$link .= _mapi_social_share_onclick($args['network'], $args['id']);
	}
	$link .= ",'mapi-share-dialog','width=".$win_w.",height=".$win_h.",left=20,top=20'); return false;";

	// for the most part FA classes work, but not for "email"
	if($args['network'] == 'email') {
		$args['network'] = 'envelope-square';
	}
	$link .= '"><i class="fa fa-'.$args['network'].'">&nbsp;</i></a>';

	if($args['echo']) {
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
	switch($network) {
		case 'twitter' :
			$href = 'http://twitter.com/home?status='.get_permalink($id);
			break;
		case 'facebook' :
			$href = 'http://www.facebook.com/sharer.php?u='.get_permalink($id).'&amp;t='.urlencode(get_the_title_rss($id));
			break;
		case 'google-plus' :
			$href = 'https://plus.google.com/share?url='.get_permalink($id);
			break;
		case 'pinterest' :
			$href = 'http://www.pinterest.com/pin/create/link/?url='.get_permalink($id).'&amp;media='.urlencode(mapi_get_attachment_image_src(mapi_get_attachment_id($id))).'&amp;description='.urlencode(get_the_title_rss($id));
			break;
		case 'linkedin' :
			$href = 'http://www.linkedin.com/shareArticle?mini=true&amp;url='.get_permalink($id).'&amp;title='.urlencode(get_the_title_rss($id));
			//&amp;summary={articleSummary}&amp;source={articleSource};
			break;
		case 'tumblr' :
			$href = 'http://www.tumblr.com/share/link?url='.urlencode(get_permalink($id)).'&amp;name='.urlencode(get_the_title_rss($id)); // &amp;description=
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
			$href = 'mailto:?body='.apply_filters('mapi_social_mailto_body', 'Check out this '.get_post_type().': '.get_permalink($id)).'&amp;subject='.get_the_title_rss($id);
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
	switch($network) {
		case 'twitter' :
			$onclick = "https://twitter.com/share?url='+encodeURIComponent(location.href)";
			break;
		case 'facebook' :
			$onclick = 'http://www.facebook.com/sharer.php?u=\'+encodeURIComponent(location.href)+\'&amp;t='.urlencode(get_the_title_rss($id)).'\'';
			break;
		case 'google-plus' :
			$onclick = 'https://plus.google.com/share?url='.get_permalink($id).'\'';
			break;
		case 'pinterest' :
			$onclick = 'http://www.pinterest.com/pin/create/link/?url='.get_permalink($id).'&amp;media='.urlencode(mapi_get_attachment_image_src(mapi_get_attachment_id($id))).'&amp;description='.urlencode(get_the_title_rss($id)).'\'';
			break;
		case 'linkedin' :
			$onclick = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=\'+encodeURIComponent(location.href)+\'&amp;title='.urlencode(get_the_title_rss($id)).'\'';
			break;
		case 'tumblr' :
			$onclick = 'http://www.tumblr.com/share/link?url='.urlencode(get_permalink($id)).'&amp;name='.urlencode(get_the_title_rss($id)).'\'';
			break;
		case 'youtube' :
			// youtube doesn't have a "share" feature so we'll use the "follow" format instead
			$onclick = _mapi_social_follow_href('youtube', $id).'\'';
			break;
		case 'rss' :
			// rss doesn't have a "share" feature so we'll use the "follow" format instead
			$onclick = _mapi_social_follow_href('rss', $id).'\'';
			break;
		case 'email' :
			$onclick = 'mailto:?body='.apply_filters('mapi_social_mailto_body', 'Check out this '.get_post_type().': '.get_permalink($id)).'&amp;subject='.get_the_title_rss($id).'\'';
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
	switch($network) {
		case 'twitter' :
			$href = mapi_get_option('twitter_uri');
			break;
		case 'facebook' :
			$href = mapi_get_option('facebook_uri');
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

	if(!class_exists('TwitterAPIExchange')) {
		require_once(MAPI_DIR_PATH.'/lib/twitter-api-php/TwitterAPIExchange.php');
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
			apply_filters('mapi_twitter_consumer_secret', "26l1pgAgmblBb8l5Vi6JD2ybmrTVHc5X5arBwiZAhskqzZI5ff")
	);

	$defaults = array(
		'screen_name' => NULL,
		'num_tweets'  => 4,
		'echo'        => TRUE,
		'oauth'       => $settings
	);
	$args = wp_parse_args($args, $defaults);

	if(empty($args['screen_name'])) {
		return mapi_error(array('msg' => 'A valid Twitter screen name is required.'));
	}

	//  Perform a GET request and echo the response, note: Set the GET field BEFORE calling buildOauth();
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name='.$args['screen_name'];
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$tweets = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());

	if($tweets) {
		$tweets = array_slice($tweets, 0, $args['num_tweets']);
		if($args['echo']) {
			echo '<ul class="mapi-twitter-feed mapi-twitter-rss">';
			foreach($tweets as $tweet) : ?>
				<li>
					<span class="mapi-tweet-link"><?php echo $tweet->text; ?></span><br />
						<span class="mapi-tweet-meta">Posted to <a class="mapi-tweet-link" href='https://twitter.com/<?php echo $args['screen_name']; ?>/status/<?php echo $tweet->id; ?>' title='<?php echo 'Posted '.$tweet->created_at; ?>'>Twitter</a> on <?php echo $tweet->created_at; ?>
													  by <a href="https://twitter.com/<?php echo $args['screen_name']; ?>" title="Connect with <?php bloginfo('name'); ?> on Twitter" target="_blank"><?php echo $args['screen_name']; ?></a></span>
				</li>
			<?php
			endforeach;
			echo '</ul>';
		} else {
			return $tweets;
		}
	} else {
		mapi_error(array('msg' => 'Could not retrieve Twitter timeline: '.$url, 'die' => FALSE, 'echo' => FALSE));
	}
}

/**
 *
 * Loads MAPI Social CSS
 *
 * <code>add_action('wp_enqueue_scripts', 'mapi_social_css');</code>
 *
 */
function mapi_social_css() {
	if(!is_admin()) {
		wp_deregister_style('mapi-social');
		wp_register_style('mapi-social', MAPI_DIR_URL.'css/social.css');
		wp_enqueue_style('mapi-social');
	}
}

