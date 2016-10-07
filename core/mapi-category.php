<?php
/**
 * Mindshare Theme API CATEGORY FUNCTIONS
 *
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-category.php
 *
 */

/**
 *
 * Retrieves a category ID from a given category slug.
 *
 * @param $cat_slug string A category slug.
 *
 * @return int Returns a category ID.
 */
function mapi_cat_slug_to_id($cat_slug) {
	$cat = get_category_by_slug($cat_slug);
	if($cat) {
		return $cat->term_id;
	} else {
		return FALSE;
	}
}

/**
 *
 * Retrieves category id of current cat archive page.
 *
 * @return int Returns category id.
 */
function mapi_get_cat_id() {
	if(is_category()) {
		return get_cat_ID(mapi_single_cat_title(get_the_ID()));
	} else {
		return FALSE;
	}
}

/**
 *
 * A replacement for the default search form restricted to categories assigned to post_id.
 *
 * @todo Rewrite this for taxonomies
 *
 * @param string $post_id  Optional. Defaults to the current post ID.
 * @param string $template Optional. PHP filename (relative to active theme directory) to use for the
 *                         category search form. Defaults to "searchform-cat.php".
 *
 * @return boolean Returns false if the template file is not found, otherwise the template file is included.
 */
function mapi_cat_search_form($post_id = '', $template = '') {
	if(empty($post_id)) {
		$post_id = get_the_ID();
	}
	if(empty($template)) {
		$template = get_template_directory().'/searchform-cat.php';
	} else {
		$template = get_template_directory().'/'.$template.'.php';
	}

	$cat_str = '';
	foreach((get_the_category($post_id)) as $category) {
		$cat_str .= $category->cat_ID.',';
	}
	// remove trailing comma
	$cat_str = substr($cat_str, 0, -1);

	// require the template file
	if(file_exists($template)) {
		require($template);
	} else {
		return FALSE;
	}
}

/**
 *
 * Retrieves the category title for a given post ID.
 *
 * @param string $post_id Optional. defaults to the current post.
 *
 * @return string|bool Returns the  category title on success, returns FALSE if no category title is found.
 */
function mapi_single_cat_title($post_id = '') {
	return apply_filters('mapi_single_cat_title', mapi_single_term_title($post_id, 'category'));
}

/**
 * Echoes the parent category name, optionally with a link.
 *
 * @param bool $link If TRUE the category name will include a hyperlink. Default: TRUE.
 *
 * @return bool|string Returns a string with the category name on success, FALSE on failure.
 */
function mapi_single_category_parent($link = TRUE) {
	return mapi_get_single_category_parent(TRUE, $link);
}

/**
 * Returns or echoes the parent category name, optionally with a link.
 *
 * @param bool $echo If TRUE the result will be echoed. Default: FALSE.
 * @param bool $link If TRUE the category name will include a hyperlink. Default: FALSE.
 *
 * @return bool|string Returns a string with the category name on success, FALSE on failure.
 */
function mapi_get_single_category_parent($echo = FALSE, $link = FALSE) {
	$output = '';
	$category = get_queried_object(); // get the current category
	$parent_category = get_category($category->category_parent);
	if(is_wp_error($parent_category)) {
		return FALSE; // no parent was found
	} else {
		$parent_category_name = $parent_category->name;

		if($link) {
			$parent_category_link = get_category_link($parent_category->term_id);
			$output .= '<a href="'.esc_url($parent_category_link).'" title="'.$parent_category_name.'">'.$parent_category_name.'</a>';
		} else {
			$output .= $parent_category_name;
		}
		if($echo) {
			echo apply_filters('mapi_single_category_parent', $output);
		} else {
			return apply_filters('mapi_single_category_parent', $output);
		}
	}
}

/**
 *
 * Generates a select (dropdown) navigation menu for a category or custom taxonomy and adds the required JavaScript
 *
 * @todo test to see if name / id should be changed... use case multiple dropdowns on one page
 *
 * @param string $show_option_all Optional. A string to use for the "All" option.
 * @param int    $parent_cat      Optional. Limits the dropdown to a specific parent category/taxonomy.
 * @param string $taxonomy        Optional. Defaults to "category".
 */
function mapi_cat_dropdown($show_option_all = '', $parent_cat = 0, $taxonomy = 'category') {
	$selected_cat = isset($_GET['cat']) ? $_GET['cat'] : '0';
	$args = array(
		"selected"           => $selected_cat,
		"id"                 => "mcms-".$taxonomy."-dropdown",
		"class"              => "mcms-dropdown",
		"use_desc_for_title" => 0,
		"hide_if_empty"      => TRUE,
		"orderby"            => "name",
		"show_option_all"    => $show_option_all,
		"child_of"           => $parent_cat,
		"taxonomy"           => $taxonomy
	);
	wp_dropdown_categories($args);
	?>
	<script type="text/javascript">
		var dropdown = document.getElementById("cat");
		function onCatChange() {
			if(dropdown.options[dropdown.selectedIndex].value > 0) {
				location.href = "/category/blog/?cat=" + dropdown.options[dropdown.selectedIndex].value;
			}
		}
		dropdown.onchange = onCatChange;
	</script>
<?php
}
