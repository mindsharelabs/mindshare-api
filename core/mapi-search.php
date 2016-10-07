<?php
/**
 * Mindshare Theme API SEARCH FUNCTIONS
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-search.php
 *
 */

/**
 *
 * Not intended for general use in themes. Gets the current search term (to be used in JavaScript).
 *
 * @return mixed
 */
function mapi_get_search_query() {
	if(isset($_SERVER['HTTP_REFERER'])) {
		$referrer = urldecode($_SERVER['HTTP_REFERER']);
		$query_array = array();

		if(preg_match('@^http://(.*)?\.?(google|yahoo|lycos|bing|ask|baidu|youdao).*@i', $referrer)) {
			$query = preg_replace('/^.*(&q|query|p|wd)=([^&]+)&?.*$/i', '$2', $referrer);
		} else {
			$query = get_search_query();
		}
		preg_match_all('/([^\s"\']+)|"([^"]*)"|\'([^\']*)\'/', $query, $query_array);

		return $query_array[0];
	} else {
		return FALSE;
	}
}

/**
 *
 * Not intended for general use in themes. Get query variables. Used to highlight search terms via JavaScript.
 *
 */
function mapi_query() {
	global $mapi_do_extend;

	$areas = apply_filters('mapi_search_highlight_containers', array('div.page', 'div.post', 'article.page', 'article.post')); // Using the tag 'body' is known to cause conflicts
	// js >> var mapi_ids = new Array("'.$id'","#main","#wrapper");
	$terms = mapi_get_search_query();
	$filtered = array();
	if($terms) {
		foreach($terms as $term) {
			$term = esc_attr(trim(str_replace(array('"', '\'', '%22'), '', $term)));
			if(!empty($term)) {
				$filtered[] = '"' . $term . '"';
			}
		}
		if(count($filtered) > 0) {
			$mapi_do_extend = TRUE;
			echo '<script type="text/javascript">var mapi_query = new Array(' . implode(',', $filtered) . ');var mapi_areas = new Array("' . implode('","', $areas) . '");</script>';
		}
	}
}

/**
 * Replaces the GET variable 's' with a nice URL, like 'search'.
 *
 * @usage:
 *
 * add_action('template_redirect', 'mapi_nice_search_redirect');
 * //add_filter('mapi_search_base', 'my_search_page_slug');
 *
 */
function mapi_nice_search_redirect() {
	global $wp_rewrite;

	if(!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
		return;
	}
	$search_base = apply_filters('mapi_search_base', $wp_rewrite->search_base);

	if(is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === FALSE) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}


