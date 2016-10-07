<?php
/**
 * mapi-embed.php
 *
 * @created   9/30/16 2:08 PM
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/
 */

/**
 * Adds responsive container div to embeds. Enabled by default, turn off like so:
 * <code>
 * remove_filter('embed_oembed_html', 'alx_embed_html', 10);
 * remove_filter('video_embed_html', 'alx_embed_html', 10); // Jetpack
 * </code>
 *
 * @param $html
 *
 * @return string
 */
function mapi_embed_html($html) {
	return '<div class="mapi-video-container">' . $html . '</div>';
}

