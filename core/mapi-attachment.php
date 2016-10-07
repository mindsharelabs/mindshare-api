<?php
/**
 * Mindshare Theme API ATTACHMENT & IMAGE FUNCTIONS
 *
 *
 * @author     Mindshare Labs, Inc.
 * @copyright  Copyright (c) 2006-2016
 * @link       https://mindsharelabs.com/downloads/mindshare-theme-api/
 * @filename   mapi-attachment.php
 *
 *
 */

require_once(MAPI_DIR_PATH . 'lib/BFI_Thumb.php');

/**
 *
 * Resizes and outputs a WordPress featured image
 * wrapped in a div with the CSS class "mapi-featured-img"
 *
 * @param $args   array An array of image parameters suing the following defaults:
 *                'w'     => get_option('large_size_w', '1024'),
 *                'h'     => get_option('large_size_h', '1024'),
 *                'id'    => get_the_ID(),
 *                'echo'  => TRUE,
 *                'alt'   => mapi_get_attachment_image_title(),
 *                'title' => mapi_get_attachment_image_title(),
 *
 * @return array|string
 */
function mapi_featured_img($args = array()) {

	$defaults = array(
		'w'     => apply_filters('mapi_featured_img_w', get_option('large_size_w', '1170')),
		'h'     => apply_filters('mapi_featured_img_h', get_option('large_size_h', '1170')),
		'id'    => apply_filters('mapi_featured_img_id', get_the_ID()),
		'echo'  => apply_filters('mapi_featured_img_echo', TRUE),
		'alt'   => apply_filters('mapi_featured_img_alt', mapi_get_attachment_image_title()),
		'title' => apply_filters('mapi_featured_img_title', mapi_get_attachment_image_title()),
		'class' => apply_filters('mapi_featured_img_class', 'mapi-featured-img'),
		'q'     => apply_filters('mapi_thumb_q', 90), // quality 0-100
		'a'     => apply_filters('mapi_thumb_a', 'c'), // crop alignment c, t, l, r, b, tl, tr, bl, br	(c = center, t = top, b = bottom, r = right, l = left)
		'zc'    => apply_filters('mapi_thumb_zc', 1), // zoom/crop
		'f'     => apply_filters('mapi_thumb_f', NULL),
		's'     => apply_filters('mapi_thumb_s', 0), // sharpen 1 or 0
		'cc'    => apply_filters('mapi_thumb_cc', NULL), // canvas color ffffff
		'ct'    => apply_filters('mapi_thumb_ct', 1), // canvas transparency (overrides cc) 1 or 0
	);
	$args = wp_parse_args($args, $defaults);

	if (has_post_thumbnail($args[ 'id' ])) {
		$featured_img = wp_get_attachment_image_src(mapi_get_attachment_id($args[ 'id' ]), 'full');
		$args[ 'src' ] = $featured_img[ 0 ];
		$args[ 'img' ] = mapi_thumb(
			array(
				'src' => $args[ 'src' ],
				'w'   => $args[ 'w' ],
				'h'   => $args[ 'h' ],
				'id'  => $args[ 'id' ],
				'a'  => $args[ 'a' ],
				'zc'  => $args[ 'zc' ],
				'f'  => $args[ 'f' ],
				's'  => $args[ 's' ],
				'cc'  => $args[ 'cc' ],
				'ct'  => $args[ 'ct' ],
			)
		);
		if ($args[ 'echo' ] === TRUE) {
			echo apply_filters('mapi_featured_image_before', '<div class="' . $args[ 'class' ] . '">');
			?>
			<img alt="<?php echo $args[ 'alt' ]; ?>" <?php if ($args[ 'title' ]) : echo 'title="' . $args[ 'title' ] . '"'; endif; ?> src="<?php echo $args[ 'img' ]; ?>" />
			<?php
			echo apply_filters('mapi_featured_image_after', '</div>');
		} else {
			$image = array(
				'w'     => $args[ 'w' ],
				'h'     => $args[ 'h' ],
				'src'   => $args[ 'img' ],
				'alt'   => $args[ 'alt' ],
				'title' => $args[ 'title' ],
			);

			return apply_filters('mapi_featured_image', $image);
		}
	}

	return apply_filters('mapi_featured_image', FALSE); // no post thumbnail was found
}

/**
 * Resizes and outputs a WordPress featured image with a caption. See mapi_featured_img for parameters.
 *
 * @uses  mapi_featured_img
 *
 * @since 0.7.2
 *
 * @param array $args
 */
function mapi_featured_img_with_caption($args = array()) {
	echo mapi_featured_img($args);
	if (mapi_get_attachment_image_caption()) {
		echo apply_filters('mapi_featured_img_caption', '<div class="caption">' . mapi_get_attachment_image_caption() . '</div>');
	}
}

/**
 *
 *
 * Retrieves the title field for a WordPress attachment
 *
 * @param int $attachment_id ID of the attachment
 *
 * @return bool|string returns false if no title is found, otherwise returns the title
 */
function mapi_get_attachment_image_title($attachment_id = NULL) {
	if ($attachment_id == NULL) {
		$attachment_id = mapi_get_attachment_id();
	}
	$image = wp_get_attachment_image_src($attachment_id);
	if ($image) {
		$attachment = get_post($attachment_id);

		$img_title = trim(strip_tags($attachment->post_excerpt)); // use caption field first
		if ($img_title == '') {
			$img_title = trim(strip_tags($attachment->post_title)); // use the title
		} elseif ($img_title == '') {
			$img_title = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', TRUE))); // use the alt
		}

		return apply_filters('mapi_attachment_image_title', $img_title);
	} else {
		return apply_filters('mapi_attachment_image_title', FALSE);
	}
}

/**
 * Retrieves the caption field from a WordPress attachment
 *
 * @param null $attachment_id ID of the attachment
 *
 * @return bool|string returns false if no title is found, otherwise returns the caption
 */
function mapi_get_attachment_image_caption($attachment_id = NULL) {
	if ($attachment_id == NULL) {
		$attachment_id = mapi_get_attachment_id();
	}
	if (wp_get_attachment_image_src($attachment_id)) {
		$attachment = get_post($attachment_id);

		$img_title = trim(strip_tags($attachment->post_excerpt));
		if (empty($img_title)) {
			return FALSE;
		} else {
			return apply_filters('mapi_attachment_image_caption', $img_title);
		}
	} else {
		return apply_filters('mapi_attachment_image_caption', FALSE);
	}
}

/**
 *
 * Retrieves the img src for a WordPress attachment
 *
 * @param int    $attachment_id ID of the desired attachment
 * @param string $dimensions    either a string keyword (thumbnail, medium, large or full)
 *                              or a 2-item array representing width and height in pixels, e.g. array(32,32)
 *
 * @return bool|string returns false if no image is found, otherwise src ULR is returned
 */
function mapi_get_attachment_image_src($attachment_id = NULL, $dimensions = NULL) {
	if ($attachment_id == NULL) {
		$attachment_id = mapi_get_attachment_id();
	}
	if ($dimensions == NULL) {
		$dimensions = 'full';
	}
	$image = wp_get_attachment_image_src($attachment_id, $dimensions);
	if ($image) {
		return apply_filters('mapi_attachment_image_src', $image[ 0 ]);
	} else {
		return apply_filters('mapi_attachment_image_src', FALSE);
	}
}

/**
 *
 *
 * Retrieve the ID of an attachment
 *
 * @param int $id
 *
 * @return int
 */
function mapi_get_attachment_id($id = NULL) {
	if (isset($id)) {
		return get_post_thumbnail_id($id);
	} else {
		return get_post_thumbnail_id(get_the_ID());
	}
}

/**
 * Check $post_id for the first image in the_content and returns its URL.
 * If no image is found it can return a fallback image specified by $fallback image.
 *
 * @param null|int    $post_id      A post ID.
 * @param null|string $fallback_img A URL for a fallback image if no image is found.
 *
 * @return bool|null
 */
function mapi_get_first_post_image_src($post_id = NULL, $fallback_img = NULL) {
	if ($post_id == NULL) {
		$post_id = get_the_ID();
	}
	$img_post = get_post($post_id);
	if ($img_post) {
		ob_start();
		ob_end_clean();
		preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $img_post->post_content, $matches);

		$first_img = @$matches[ 1 ][ 0 ];

		if (empty($first_img)) {
			// if no image was found use fallback image if one is available
			if (!empty($fallback_img)) {
				return $fallback_img;
			} else {
				return FALSE; // no luck return nothing
			}
		} else {
			return $first_img; // return the first image in the post
		}
	} else {
		return FALSE; // no post was found for $post_id
	}
}

/**
 *
 * Retrieve the Link URL field for an image in the media library
 *
 * @param null $id
 *
 * @return string Returns the Link URL field
 */
function mapi_get_link_url($id = NULL) {
	if ($id == NULL) {
		$id = get_the_ID();
	}

	return apply_filters('mapi_link_url', get_post_meta($id, '_wp_attachment_url', TRUE));
}

/**
 *
 *
 * Filter function for to change the WordPress Gallery shortcode title attribute
 *
 * @param $attr array Accepts an array with an image "title" and "alt"
 *
 * @return array Returns the modified array to WordPress' Gallery shortcode
 */
function mapi_gallery_filter($attr) {
	$attr[ 'alt' ] = get_bloginfo('name');
	$attr[ 'title' ] = __('Click for a larger image', 'mapi');

	return apply_filters('mapi_gallery_image_attributes', $attr);
}

/**
 *
 * Resizes any image using the mThumb library. Use this function instead of
 * including mThumb or TimThumb in your theme for easy updates and simple usage.
 *
 * @see http://www.binarymoon.co.uk/2012/02/complete-timthumb-parameters-guide/
 * @see https://github.com/mindsharestudios/mthumb
 *
 * @param        $src               (string|array) Required. Parameters can be passed as an array or individually. If passing individually this first param should be a URL to the image otherwise this
 *                                  param is an array of arguments. All other params are optional.
 * @param int    $w                 Width to resize in pixels
 * @param int    $h                 Height to resize in pixels
 * @param int    $q                 Quality of the resized image from 0-100
 * @param string $a                 Crop alignment. c = center, t = top, b = bottom, r = right, l = left.
 *                                  The positions can be joined to create diagonal positions
 * @param int    $zc                Zoom/crop method.    0 = Resize to Fit specified dimensions (no cropping)
 *                                  1 =    Crop and resize to best fit the dimensions (default)
 *                                  2 = Resize proportionally to fit entire image into specified dimensions, and add borders if required
 *                                  3 = Resize proportionally adjusting size of scaled image so there are no borders gaps
 * @param null   $f                 Filters. Separate multiple filters using a pipe character,
 *                                  specify arguments after a comma. Example: f=2|1,10
 *                                  1 = Negate - Invert colours
 *                                  2 = Grayscale - turn the image into shades of grey
 *                                  3 = Brightness - Adjust brightness of image. Requires 1 argument to specify the
 *                                  amount of brightness to add. Values can be negative to make the image darker.
 *                                  4 = Contrast - Adjust contrast of image. Requires 1 argument to specify the amount of
 *                                  contrast to apply. Values greater than 0 will reduce the contrast and less than 0 will
 *                                  increase the contrast.
 *                                  5 = Colorize/ Tint - Apply a colour wash to the image. Requires the most parameters of all
 *                                  filters. The arguments are RGBA
 *                                  6 = Edge Detect - Detect the edges on an image
 *                                  7 = Emboss - Emboss the image (give it a kind of depth), can look nice when combined
 *                                  with the colorize filter above.
 *                                  8 = Gaussian Blur - blur the image, unfortunately you can't specify the amount,
 *                                  but you can apply the same filter multiple times (as shown in the demos)
 *                                  9 = Selective Blur - a different type of blur. Not sure what the difference is,
 *                                  but this blur is less strong than the Gaussian blur.
 *                                  10 = Mean Removal - Uses mean removal to create a "sketchy" effect.
 *                                  11 = Smooth - Makes the image smoother.
 * @param int    $s                 Sharpen the image. Accepts the number 1 only.
 * @param null   $cc                Canvas colour. Hexadecimal color value (#ffffff) for images with transparent
 *                                  backgrounds.
 * @param int    $ct                Canvas transparency. Set to 1 (true) to use a transparent background and ignore cc.
 *
 * @return string Returns the URL of the newly resized/filtered image.
 */
function mapi_thumb($src, $w = NULL, $h = NULL, $q = 90, $a = 'c', $zc = 1, $f = NULL, $s = 0, $cc = NULL, $ct = 1) {
	if (!is_array($src)) {
		$src = array(
			'src' => $src,
			'w'   => $w,
			'h'   => $h,
			'q'   => $q,
			'a'   => $a,
			'zc'  => $zc,
			'f'   => $f,
			's'   => $s,
			'cc'  => $cc,
			'ct'  => $ct
		);
	}

	return mapi_thumb_array($src);
}

/**
 *
 * Upgraded version of mapi_thumb. Do not call this function directly, use mapi_thumb with an array instead.
 *
 * @param $args array [string]src   apply_filters('mapi_thumb_src', $args['src'])
 * @param $args array [int]w        apply_filters('mapi_thumb_w', get_option('thumbnail_size_w'))
 * @param $args array [int]h        apply_filters('mapi_thumb_h', NULL) // get_option('thumbnail_size_h')
 * @param $args array [int]q        apply_filters('mapi_thumb_q', 90) // quality 0-100
 * @param $args array [string]a     apply_filters('mapi_thumb_a', 'c') // crop alignment c, t, l, r, b, tl, tr, bl, br    (c = center, t = top, b = bottom, r = right, l = left)
 * @param $args array [int]zc       apply_filters('mapi_thumb_zc', 1) // zoom/crop
 * @param $args array [string]f     apply_filters('mapi_thumb_f', NULL) // filters (can be combined) f=FILTER_ID,FILTER_PARAM,FILTER_PARAM|FILTER_ID,FILTER_PARAM
 * @param $args array [int]s        apply_filters('mapi_thumb_s', 0) // sharpen 1 or 0
 * @param $args array [string]cc    apply_filters('mapi_thumb_cc', NULL) // canvas color ffffff
 * @param $args array [string]ct    apply_filters('mapi_thumb_ct', 1) // canvas transparency (overrides cc) 1 or 0
 *
 * @return string
 */
function mapi_thumb_array($args) {

	$defaults = array(
		'src' => apply_filters('mapi_thumb_src', $args[ 'src' ]),
		'w'   => apply_filters('mapi_thumb_w', get_option('thumbnail_size_w')),
		'h'   => apply_filters('mapi_thumb_h', NULL), //get_option('thumbnail_size_h'),
		'q'   => apply_filters('mapi_thumb_q', 90), // quality 0-100
		'a'   => apply_filters('mapi_thumb_a', 'c'), // crop alignment c, t, l, r, b, tl, tr, bl, br	(c = center, t = top, b = bottom, r = right, l = left)
		'zc'  => apply_filters('mapi_thumb_zc', 1), // zoom/crop
		//		0	Resize to Fit specified dimensions (no cropping)
		//		1	Crop and resize to best fit the dimensions (default)
		// 		2	Resize proportionally to fit entire image into specified dimensions, and add borders if required
		// 		3	Resize proportionally adjusting size of scaled image so there are no borders gaps)
		'f'   => apply_filters('mapi_thumb_f', NULL), // filters (can be combined) f=FILTER_ID,FILTER_PARAM,FILTER_PARAM|FILTER_ID,FILTER_PARAM
		//		1 = Negate - Invert colours
		// 		2 = Grayscale - turn the image into shades of grey
		//		3 = Brightness - Requires 1 argument to specify the amount of brightness to add. Values can be negative to make the image darker.
		//		4 = Contrast - Requires 1 argument to specify the amount of contrast to apply. Values greater than 0 will reduce the contrast and less than 0 will increase the contrast.
		//		5 = Colorize/ Tint - Requires the most parameters of all filters. The arguments are RGBA
		//		6 = Edge Detect - Detect the edges on an image
		//		7 = Emboss - Emboss the image (give it a kind of depth), can look nice when combined with the colorize filter above.
		//		8 = Gaussian Blur - blur the image, unfortunately you can't specify the amount, but you can apply the same filter multiple times (as shown in the demos)
		//		9 = Selective Blur - a different type of blur. Not sure what the difference is, but this blur is less strong than the Gaussian blur.
		//		10 = Mean Removal - Uses mean removal to create a "sketchy" effect.
		//		11 = Smooth - Makes the image smoother.
		's'   => apply_filters('mapi_thumb_s', 0), // sharpen 1 or 0
		'cc'  => apply_filters('mapi_thumb_cc', NULL), // canvas color ffffff
		'ct'  => apply_filters('mapi_thumb_ct', 1) // canvas transparency (overrides cc) 1 or 0
	);
	$args = wp_parse_args($args, $defaults);

	if (empty($args[ 'src' ])) {
		return mapi_error(array( 'msg' => 'Parameter "src" cannot be empty', 'echo' => FALSE, 'die' => FALSE ));
	} else {
		$img_src = plugins_url('lib/mthumb.php', dirname(__FILE__)) . '?src=' . $args[ 'src' ] . '&amp;w=' . $args[ 'w' ] . '&amp;h=' . $args[ 'h' ] . '&amp;q=' . $args[ 'q' ] . '&amp;a=' . $args[ 'a' ] . '&amp;zc=' . $args[ 'zc' ] . '&amp;f=' . $args[ 'f' ] . '&amp;s=' . $args[ 's' ] . '&amp;cc=' . $args[ 'cc' ] . '&amp;ct=' . $args[ 'ct' ];

		return apply_filters('mapi_thumb', $img_src);
	}
}

/** Uses WP's Image Editor Class to resize and filter images
 *
 * @param string $src    The local image URL to manipulate
 * @param array  $args   The options to perform on the image. Keys and values supported:
 * @param        $args   array [int]width pixels
 * @param        $args   array [int]height pixels
 * @param        $args   array [int]opacity 0-100
 * @param        $args   array [string] color HEX color #000000-#ffffff
 * @param        $args   array [bool]grayscale
 * @param        $args   array [bool]negate
 * @param        $args   array [bool]crop
 * @param        $args   array [bool] crop_only
 * @param        $args   array [bool]crop_x
 * @param        $args   array [bool]crop_y
 * @param        $args   array [bool]crop_width
 * @param        $args   array [bool]crop_height
 * @param        $args   array [int]quality 1-100
 *
 * @param        $single boolean, if false then an array of data will be returned
 *
 * @return array|string containing the url of the resized modified image
 */
function mapi_image($src = '', $args = array(), $single = TRUE) {

	$defaults = array(
		'width'       => apply_filters('mapi_thumb_w', get_option('thumbnail_size_w')),
		'height'      => apply_filters('mapi_thumb_h', NULL), //get_option('thumbnail_size_h'),
		'quality'     => apply_filters('mapi_thumb_q', 90), // quality 0-100
		'opacity'     => apply_filters('mapi_thumb_q', 100), //  0-100
		'color'       => apply_filters('mapi_thumb_q', '#ffffff'), // #000000-#ffffff
		'grayscale'   => apply_filters('mapi_thumb_grayscale', FALSE),
		'negate'      => apply_filters('mapi_thumb_negate', FALSE),
		'crop'        => apply_filters('mapi_thumb_crop', FALSE),
		'crop_only'   => apply_filters('mapi_thumb_crop_only', FALSE),
		'crop_x'      => apply_filters('mapi_thumb_crop_x', FALSE),
		'crop_y'      => apply_filters('mapi_thumb_crop_width', FALSE),
		'crop_width'  => apply_filters('mapi_thumb_crop_width', FALSE),
		'crop_height' => apply_filters('mapi_thumb_crop_height', FALSE),
	);
	$args = wp_parse_args($args, $defaults);

	$src = apply_filters('mapi_thumb_src', $src);

	if (empty($src)) {
		return mapi_error(array( 'msg' => 'Parameter "src" cannot be empty', 'echo' => FALSE, 'die' => FALSE ));
	} else {
		$img_src = bfi_thumb($src, $args, $single);

		return apply_filters('mapi_thumb', $img_src);
	}
}

/**
 *
 * returns a randomly selected image from a specified directory/path
 *
 * @param array $args    Settings array that includes the following defaults:
 *                       'dir' => $upload_dir['baseurl'],
 *                       'path' => $upload_dir['path'],
 *                       'height' => get_option('large_size_h'),
 *                       'width' => get_option('large_size_w'),
 *                       'alt' => get_bloginfo('name').' - '.get_bloginfo('description'),
 *                       'echo' => TRUE
 *
 * @return string Returns the URL to the random selected image.
 *
 * * @example:
 *  <code>
 *           api_random_img(array(
 *  'dir' => get_bloginfo('template_directory').'/img/random/',
 *  'path' => TEMPLATEPATH.'/img/random/',
 *  'width' => 80,
 *  'height' => 80,
 *  'alt' => 'my alt'
 * ));
 * </code>
 *
 */
function mapi_random_img($args) {
	$upload_dir = wp_upload_dir();
	$defaults = array(
		'dir'    => apply_filters('mapi_random_image_dir', $upload_dir[ 'baseurl' ]),
		'path'   => apply_filters('mapi_random_image_path', $upload_dir[ 'path' ]),
		'height' => apply_filters('mapi_random_image_height', get_option('large_size_h')),
		'width'  => apply_filters('mapi_random_image_width', get_option('large_size_w')),
		'alt'    => apply_filters('mapi_random_image_alt', get_bloginfo('name') . ' - ' . get_bloginfo('description')),
		'echo'   => TRUE
	);
	$args = wp_parse_args($args, $defaults);

	$src = plugins_url('core/mapi-random.img.php', dirname(__FILE__)) . '?dir=' . $args[ 'dir' ] . '&amp;path=' . $args[ 'path' ];

	if ($args[ 'echo' ]) {
		do_action('mapi_random_image_before');
		?>
		<img class="mapi-random-img" src="<?php echo $src ?>" width="<?php echo $args[ 'width' ] ?>" height="<?php echo $args[ 'height' ] ?>" alt="<?php echo $args[ 'alt' ] ?>" title="<?php echo $args[ 'alt' ] ?>" />
		<?php
		do_action('mapi_random_image_after');
	} else {
		return apply_filters('mapi_random_image', $src);
	}
}

/**
 *
 * Deletes full size images when uploaded via WordPress, replaces the Large size image as the full size.
 *
 * @uses apply_filters() Calls 'wp_generate_attachment_metadata' on file path.
 *
 * @param $image_data
 *
 * @return mixed
 */
function mapi_remove_large_image($image_data) {
	// if there is no large image : return
	if (!isset($image_data[ 'sizes' ][ 'large' ])) {
		return $image_data;
	}
	$upload_dir = wp_upload_dir();

	// if using year/month folders
	if (get_option('uploads_use_yearmonth_folders')) {
		// paths to the uploaded image and the large image

		$sub_dir_array = explode('/', $image_data[ 'file' ]);
		$sub_dir = $sub_dir_array[ 0 ] . '/' . $sub_dir_array[ 1 ]; // eg. 2014/03

		$uploaded_image_location = $upload_dir[ 'basedir' ] . '/' . $image_data[ 'file' ];
		$large_image_location = $upload_dir[ 'basedir' ] . '/' . $sub_dir . '/' . $image_data[ 'sizes' ][ 'large' ][ 'file' ];
		// no year/month folders
	} else {
		// paths to the uploaded image and the large image
		$uploaded_image_location = $upload_dir[ 'basedir' ] . '/' . $image_data[ 'file' ];
		$large_image_location = $upload_dir[ 'path' ] . '/' . $image_data[ 'sizes' ][ 'large' ][ 'file' ];
	}

	// delete the uploaded image
	unlink($uploaded_image_location);

	// rename the large image
	rename($large_image_location, $uploaded_image_location);

	// update image metadata and return them
	$image_data[ 'width' ] = $image_data[ 'sizes' ][ 'large' ][ 'width' ];
	$image_data[ 'height' ] = $image_data[ 'sizes' ][ 'large' ][ 'height' ];
	unset($image_data[ 'sizes' ][ 'large' ]);

	return $image_data;
}
