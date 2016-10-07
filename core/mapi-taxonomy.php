<?php
/**
 * Mindshare Theme API TAXONOMY & TERM FUNCTIONS
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mcms-taxonomy.php
 *
 */

/**
 *
 * Retrieve an array of all child terms based on a parent term slug for a given taxonomy.
 *
 * @param string $taxonomy Required. Taxonomy to query.
 * @param string $slug     Required. The term slug to query.
 *
 * @return mixed Returns an array term children or FALSE on failure.
 */
function mapi_get_term_children_by_slug($taxonomy, $slug) {
	if(!isset($taxonomy) || !isset($slug)) {
		return mapi_error(array('die' => FALSE, 'echo' => FALSE, 'msg' => 'A required parameter was not provided.'));
	} else {
		$term = get_term_by('slug', $slug, $taxonomy);
		$term_id = $term->term_id;
		$terms = get_term_children($term_id, $taxonomy);
		if($terms) {
			return $terms;
		} else {
			return FALSE;
		}
	}
}

/**
 *
 * Generates a select (dropdown) navigation menu for a custom taxonomy and adds the required JavaScript.
 * A wrapper for mapi_cat_dropdown.
 *
 * @param string $show_option_all Optional. A string to use for the "All" option.
 * @param int    $parent_cat      Optional. Limits the dropdown to a specific parent category/taxonomy.
 * @param string $taxonomy        Optional. Defaults to "category".
 *
 * @return string|void
 */
function mapi_tax_dropdown($show_option_all = '', $parent_cat = 0, $taxonomy) {
	if(!isset($taxonomy)) {
		return mapi_error(array('die' => TRUE, 'msg' => 'A required parameter $taxonomy was not provided.'));
	} else {
		mapi_cat_dropdown($show_option_all = '', $parent_cat = 0, $taxonomy);
	}
}

/**
 *
 * Retrieves the term title for a given post ID.
 *
 * @param string $post_id  Optional. Defaults to the current post.
 * @param string $taxonomy Optional. Defaults to "category".
 *
 * @return string|bool  Returns the term title on success, returns FALSE if no term title is found.
 */

function mapi_single_term_title($post_id = '', $taxonomy = 'category') {
	if(empty($post_id)) {
		$post_id = get_the_ID();
	}
	$single_term_title = single_term_title('', FALSE);

	$terms = get_the_terms($post_id, $taxonomy);

	if($terms) {
		$term = reset($terms);
		if(!empty($term->name)) {
			return $term->name;
		}
	} elseif(!empty($single_term_title)) {
		return $single_term_title;
	} else {
		return FALSE;
	}
}

/**
 * Surprisingly, there is no WP function to lookup a taxonomy from just a `term_id`.
 * If you ever don't know the taxonomy for a term ID you can use this function to get
 * the taxonomy name or ID.
 *
 * @param int    $term_id
 *
 * @param string $return What to return. Valid options are 'name' or 'id'.
 *
 * @return bool|object
 */
function mapi_get_taxonomy_by_term($term_id, $return = 'name') {

	$all_taxonomies = get_taxonomies();

	if(!empty($all_taxonomies) && isset($term_id)) {
		// loop through all taxonomies
		foreach($all_taxonomies as $tax) {
			// check if the term exists in each taxonomy
			$term_result = term_exists($term_id, $tax);
			if(!empty($term_result) && !is_a($term_result, 'WP_Error')) {

				// we found a match!
				$term_meta = get_term($term_result['term_id'], $tax, ARRAY_A);
				if($return == 'name') {
					return $term_meta['taxonomy'];
				} else {
					return $term_meta['term_taxonomy_id'];
				}
			}
		}
	} else {
		return FALSE;
	}
}

/**
 *
 * Retrieves the term ID for a given post ID.
 *
 * @param string $post_id  Optional. Defaults to the current post.
 * @param string $taxonomy Optional. Defaults to "category".
 *
 * @return string|bool  Returns the term title on success, returns FALSE if no term title is found.
 */

function mapi_single_term_id($post_id = NULL, $taxonomy = 'category') {
	if(empty($post_id)) {
		$post_id = get_the_ID();
	}
	$terms = get_the_terms($post_id, $taxonomy);

	if($terms) {
		$term = reset($terms);
		if(!empty($term->term_id)) {
			return $term->term_id;
		}
	} else {
		return FALSE;
	}
}
