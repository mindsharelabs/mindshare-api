<?php

/**
 * Sub Navigation
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'mind-sub-page-list-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-sub-page-list';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assing defaults.
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => get_the_id(),
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$sub_pages = new WP_Query( $args );


if($sub_pages->have_posts()) :
	echo '<div class="' . $className . '" id="' . $id . '">';
		echo '<div class="row justify-content-start gy-2 gx-2">';
		while($sub_pages->have_posts()) :
			$sub_pages->the_post();
		  	
		     echo '<div class="col-6 col-md-4">';
		     	echo '<div class=" sub-page-item">';
			     	echo '<div class="row gx-0">';
			     		if(has_post_thumbnail(get_the_id())) :
				     		echo '<div class="col-2 page-image">';
				     			echo '<a href="' . get_permalink() . '">';
				     				the_post_thumbnail('loop-square');
				     			echo '</a>';
				     		echo '</div>';
				     	endif;
			     		echo '<div class="col page-title ps-2">';
			     			echo '<a href="' . get_permalink() . '">' . get_the_title() .  '</a>';
			     		echo '</div>';
			     	echo '</div>';
		     	echo '</div>';
		     echo '</div>';
		    	
		endwhile;
		echo '</div>';
	echo '</div>';
endif;
