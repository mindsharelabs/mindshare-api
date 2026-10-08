<?php

/**
 * Sub Page List
 *
 * Layouts:
 * - list:    small thumbnail + title (original layout, default)
 * - gallery: large image with the title beneath
 * - cover:   title centered over the image
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

$layout  = get_field('layout') ?: 'list';
$columns = (int) (get_field('columns') ?: 3);
$ratio   = get_field('image_ratio') ?: 'portrait';

// Create class attribute allowing for custom "className" and "align" values.
$className = 'mind-sub-page-list mind-sub-page-list--' . $layout;
if( 'list' !== $layout ) {
    $className .= ' cols-' . $columns . ' ratio-' . $ratio;
}
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
    'post_parent'    => ( is_numeric($post_id ?? null) && $post_id > 0 ) ? (int) $post_id : get_the_id(),
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 );


$sub_pages = new WP_Query( $args );


if($sub_pages->have_posts()) :

	if('list' === $layout) :

		echo '<div class="' . esc_attr($className) . '" id="' . esc_attr($id) . '">';
			echo '<div class="row justify-content-start gy-2 gx-2">';
			while($sub_pages->have_posts()) :
				$sub_pages->the_post();

			     echo '<div class="col-6 col-md-4">';
			     	echo '<div class="sub-page-item">';

						if(has_post_thumbnail(get_the_id())) :
							echo '<div class=" page-image">';
								echo '<a href="' . get_permalink() . '">';
									the_post_thumbnail('loop-square');
								echo '</a>';
							echo '</div>';
						endif;
						echo '<div class="page-title ps-2">';
							echo '<a href="' . get_permalink() . '">' . get_the_title() .  '</a>';
						echo '</div>';

			     	echo '</div>';
			     echo '</div>';

			endwhile;
			echo '</div>';
		echo '</div>';

	else :

		// Rendered width per breakpoint, so the browser picks a sensible srcset candidate.
		$sizes = sprintf('(max-width: 575px) 100vw, (max-width: 991px) 50vw, %dvw', ceil(100 / $columns));

		echo '<div class="' . esc_attr($className) . '" id="' . esc_attr($id) . '">';
			echo '<ul class="mind-sub-page-list__grid" role="list">';
			while($sub_pages->have_posts()) :
				$sub_pages->the_post();

				echo '<li class="mind-sub-page-list__item">';
					echo '<a class="mind-sub-page-list__link" href="' . esc_url(get_permalink()) . '">';
						echo '<span class="mind-sub-page-list__media">';
							if(has_post_thumbnail()) :
								the_post_thumbnail('large', array(
									'class'   => 'mind-sub-page-list__image',
									'sizes'   => $sizes,
									'alt'     => '',
									'loading' => $sub_pages->current_post < $columns ? 'eager' : 'lazy',
								));
							endif;
						echo '</span>';
						echo '<h3 class="mind-sub-page-list__title"><span>' . esc_html(get_the_title()) . '</span></h3>';
					echo '</a>';
				echo '</li>';

			endwhile;
			echo '</ul>';
		echo '</div>';

	endif;

	wp_reset_postdata();

elseif( $is_preview ) :
	echo '<p class="mind-sub-page-list__empty">' . esc_html__('Sub Page List: this page has no published sub pages yet.') . '</p>';
endif;
