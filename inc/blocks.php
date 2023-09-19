<?php
/**
* Register custom Gutenberg blocks category
*
*/
add_filter('block_categories_all', function ($categories, $post) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' 	=> 'mind-blocks',
				'title' => __('Mindshare Blocks', 'mindshare'),
				'icon' 	=> file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			),

		)
	);
}, 10, 2);

add_action('acf/init', function () {


	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		acf_register_block_type(array(
			'name'              => 'mind-sub-page-list',
			'title'             => __('Sub Page List'),
			'description'       => __('A block that displays all of the sub pages in a navigation latout.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-sub-page-list.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'navigation', 'sub', 'page', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		));

		acf_register_block_type(array(
			'name'              => 'mind-notice-block',
			'title'             => __('Notice Block'),
			'description'       => __('A block that displays a simple notice as a gutenberg block.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-notice-block.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'staff', 'cards', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		));


		acf_register_block_type(array(
			'name'              => 'mind-staff-cards',
			'title'             => __('Staff Cards'),
			'description'       => __('A block that displays a list of staff cards.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-staff-cards.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'staff', 'cards', 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		)
	);

		acf_register_block_type(array(
			'name'              => 'mind-button',
			'title'             => __('Theme Specific Button Group'),
			'description'       => __('One or more buttons that are theme specific and matche theme branding/colors.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-button.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'button', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
				'mode' => false,
				'jsx' => false
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mind-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mind-block-styles');});

			},
		)
	);

		acf_register_block_type(array(
			'name'              => 'image-and-content',
			'title'             => __('Image and Content'),
			'description'       => __('A media and image block. The Image aligns to the edge of the screen.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/media-and-image.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'media', 'image', 'fill', 'full', 'width', 'mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => true,
				'mode' => false,
				'jsx' => true
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);


		acf_register_block_type(array(
			'name'              => 'card-repeater-block',
			'title'             => __('Custom Card Repeater Block'),
			'description'       => __('A repeater block for a bootstrap card layout.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/card-repeater-block.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'cards', 'repeater','mind', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);


		acf_register_block_type(array(
			'name'              => 'post-list-block',
			'title'             => __('Post List Block'),
			'description'       => __('A gallery or list view for posts.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/post-list-block.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'posts', 'list', 'gallery', 'mapi', 'libraries', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

			},
		)
	);

		//Block: Map w/ Markers
		acf_register_block_type(array(
			'name'              => 'map-w-marker',
			'title'             => __('Map with Markers'),
			'description'       => __('A map block using the mapbox API.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/map-w-marker.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'call', 'action', 'brand', 'space', 'button', 'main'),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css', array(), MAPI_PLUGIN_VERSION );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				$google_maps_api = get_field('google_maps_api', 'options');
				wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . ($google_maps_api ? $google_maps_api : ''), array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('google-maps');

				wp_register_script('google-maps-clustering', 'https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js', array('jquery', 'google-maps'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('google-maps-clustering');

				wp_register_script('map-block-init', MAPI_URL . 'inc/js/map-init.js', array('jquery', 'google-maps', 'google-maps-clustering'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('map-block-init');
				wp_localize_script( 'map-block-init', 'map_param_data', array(
					'postID' => get_the_id(), // WordPress AJAX
					));


			},
		)
	);

		//Block: Image Slider
		acf_register_block_type(array(
			'name'              => 'image-slider',
			'title'             => __('Image Slider'),
			'description'       => __('This block displays an image slider with captions.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/image-slider.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'slider', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'slick-styles', MAPI_URL . 'inc/css/slick.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('slick-styles');});

				if(!is_admin()) :
					wp_register_script('slick-slider', MAPI_URL . 'inc/js/slick.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
					wp_enqueue_script('slick-slider');

					wp_register_script('image-slider-js', MAPI_URL. 'inc/js/image-slider.js', array('jquery', 'slick-slider'), MAPI_PLUGIN_VERSION, true);
					wp_enqueue_script('image-slider-js');

					// wp_localize_script( 'image-slider-js', 'sliderOptions', array(
					// 	'arrows' => get_field('mapi_slider_arrows', get_the_id()),
					// 	'dots' => get_field('mapi_slider_dots', get_the_id())
					// ));
				endif;

			},
		)
	);


		//Block: Logo Slider
		acf_register_block_type(array(
			'name'              => 'mind-logo-slider',
			'title'             => __('Logo Slider'),
			'description'       => __('This block displays multiple logos in an infite slideshow.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/mind-logo-slider.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'logo', 'sponsors', 'logos', 'slider', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'slick-styles', MAPI_URL . 'inc/css/slick.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('slick-styles');});

				if(!is_admin()) :
					wp_register_script('slick-slider', MAPI_URL . 'inc/js/slick.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
					wp_enqueue_script('slick-slider');

					wp_register_script('image-slider-js', MAPI_URL. 'inc/js/image-slider.js', array('jquery', 'slick-slider'), MAPI_PLUGIN_VERSION, true);
					wp_enqueue_script('image-slider-js');

					// wp_localize_script( 'image-slider-js', 'sliderOptions', array(
					// 	'arrows' => get_field('mapi_slider_arrows', get_the_id()),
					// 	'dots' => get_field('mapi_slider_dots', get_the_id())
					// ));
				endif;

			},
		)
	);

		//Block: Image Grid
		acf_register_block_type(array(
			'name'              => 'image-grid',
			'title'             => __('Image Grid'),
			'description'       => __('This block displays a grid of images with titles, captions and an optional link.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/image-grid.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'grid', 'gallery', 'image', 'captions', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){

					// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . 'inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});

				wp_register_style( 'lightbox-styles', MAPI_URL . 'inc/css/simple-lightbox.min.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('lightbox-styles');});

				//https://github.com/andreknieriem/simplelightbox
				wp_register_script('image-lightbox-js', MAPI_URL. 'inc/js/simple-lightbox.jquery.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('image-lightbox-js');


				wp_register_script('masonry-js', 'https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js', array('jquery'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('masonry-js');

				wp_register_script('lightbox-init', MAPI_URL. 'inc/js/lightbox-init.js', array('jquery', 'image-lightbox-js'), MAPI_PLUGIN_VERSION, true);
				wp_enqueue_script('lightbox-init');

			},
		)
	);

		//Block: Container
		acf_register_block_type(array(
			'name'              => 'container',
			'title'             => __('Container Block'),
			'description'       => __('A block that limits the width of content based on some selection criteria.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/container.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'container', 'width', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'preview',
			'supports'					=> array(
				'align' => true,
				'mode' => false,
				'jsx' => true
			),
		)
	);


		acf_register_block_type(array(
			'name'              => 'accordion-block',
			'title'             => __('Accordion'),
			'description'       => __('A repeating accordion block.'),
			'render_template'   => MAPI_ABSPATH . '/inc/block-templates/accordion-block.php',
			'category'          => 'mind-blocks',
			'icon'              => file_get_contents(MAPI_URL . 'inc/img/mind-icon.svg'),
			'keywords'          => array( 'accordion', 'repeater', 'collapse', 'Mindshare' ),
			'align'             => 'full',
			'mode'            	=> 'edit',
			'supports'					=> array(
				'align' => false,
			),
			'enqueue_assets' => function(){
				// We're just registering it here and then with the action get_footer we'll enqueue it.
				wp_register_style( 'mapi-block-styles', MAPI_URL . '/inc/css/block-styles.css' );
				add_action( 'get_footer', function () {wp_enqueue_style('mapi-block-styles');});
				//
				wp_register_script('bootstrap-js', MAPI_URL . 'inc/js/bootstrap/bootstrap.bundle.min.js', array('jquery'), MAPI_PLUGIN_VERSION);
				wp_enqueue_script('bootstrap-js');




			},
		)
	);




	}
}, 1);





if( function_exists('acf_add_local_field_group') ):
	add_action( 'acf/init', function() {

		global $_wp_additional_image_sizes;
		$args = array(
			'public' => true
		);
		$all_post_types = get_post_types($args, 'names', 'and' );

		//Block: Staff Cards
		acf_add_local_field_group(array(
			'key' => 'group_60908a6e732fb',
			'title' => 'Block: Staff Cards',
			'fields' => array(
				array(
					'key' => 'field_60908adc7c75d',
					'label' => 'Staff Cards',
					'name' => 'mind_staff_cards',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_60908ae97c75e',
							'label' => 'Staff Cards',
							'name' => 'staff_cards',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'collapsed' => '',
							'min' => 0,
							'max' => 0,
							'layout' => 'row',
							'button_label' => 'Add Staff',
							'sub_fields' => array(
								array(
									'key' => 'field_60908af17c75f',
									'label' => 'Image',
									'name' => 'image',
									'type' => 'image',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'array',
									'preview_size' => 'medium',
									'library' => 'all',
									'min_width' => '',
									'min_height' => '',
									'min_size' => '',
									'max_width' => '',
									'max_height' => '',
									'max_size' => '',
									'mime_types' => '',
								),
								array(
									'key' => 'field_60908af57c760',
									'label' => 'Name',
									'name' => 'name',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_60908afb7c761',
									'label' => 'Title',
									'name' => 'title',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
								),
								array(
									'key' => 'field_60908aff7c762',
									'label' => 'Short Bio',
									'name' => 'short_bio',
									'type' => 'textarea',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => '',
									'rows' => 3,
									'new_lines' => '',
								),
								array(
									'key' => 'field_60908b0b7c763',
									'label' => 'Staff Links',
									'name' => 'staff_links',
									'type' => 'repeater',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'collapsed' => '',
									'min' => 0,
									'max' => 0,
									'layout' => 'table',
									'button_label' => 'Add Link',
									'sub_fields' => array(
										array(
											'key' => 'field_60908b137c764',
											'label' => 'Icon',
											'name' => 'icon',
											'type' => 'text',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'default_value' => '',
											'placeholder' => '',
											'prepend' => '',
											'append' => '',
											'maxlength' => '',
										),
										array(
											'key' => 'field_60908b177c765',
											'label' => 'Link',
											'name' => 'link',
											'type' => 'link',
											'instructions' => '',
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '',
												'class' => '',
												'id' => '',
											),
											'return_format' => 'array',
										),
									),
								),
								array(
									'key' => 'field_60908de49bc1f',
									'label' => 'Staff Member Profile',
									'name' => 'staff_page_link',
									'type' => 'link',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array(
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'array',
								),
							),
),
),
),
),
'location' => array(
	array(
		array(
			'param' => 'block',
			'operator' => '==',
			'value' => 'acf/mind-staff-cards',
		),
	),
),
'menu_order' => 0,
'position' => 'normal',
'style' => 'default',
'label_placement' => 'top',
'instruction_placement' => 'label',
'hide_on_screen' => '',
'active' => true,
'description' => '',
));

		//Block: Theme Specific Buttons
acf_add_local_field_group(array(
	'key' => 'group_607de32bb0b5d',
	'title' => 'Block: Buttons',
	'fields' => array(
		array(
			'key' => 'field_607de32f51a5d',
			'label' => 'Theme Specific Buttons',
			'name' => 'mind_buttons',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_607de39051a62',
					'label' => 'Buttons',
					'name' => 'buttons',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_607de33b51a5f',
							'label' => 'Button Link',
							'name' => 'button_link',
							'type' => 'link',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
						),
						array(
							'key' => 'field_607de34151a60',
							'label' => 'Button Type',
							'name' => 'button_type',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'primary' => 'Primary',
								'secondary' => 'Secondary',
								'success' => 'Success',
								'danger' => 'Danger',
								'warning' => 'Warning',
								'info' => 'Info',
								'light' => 'Light',
								'dark' => 'Dark',
								'blank' => 'No Styling',
							),
							'default_value' => 'primary',
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_607de38351a61',
							'label' => 'Button Size',
							'name' => 'button_size',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'sm' => 'Small',
								'md' => 'Default',
								'lg' => 'Large',
							),
							'default_value' => false,
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
					),
				),
				array(
					'key' => 'field_607de3d951a63',
					'label' => 'Button Layout',
					'name' => 'button_layout',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'row' => 'Row',
						'column' => 'Column',
						'group' => 'Group',
					),
					'default_value' => 'row',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_607de79c35f0d',
					'label' => 'Button Alignment',
					'name' => 'button_alignment',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'start' => 'Left',
						'center' => 'Center',
						'end' => 'Right',
					),
					'default_value' => 'middle',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-button',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//Block: Media and Image
acf_add_local_field_group(array(
	'key' => 'group_60745cc009296',
	'title' => 'Block: Media and Image',
	'fields' => array(
		array(
			'key' => 'field_60745cc61d382',
			'label' => 'Image and Content',
			'name' => 'image_and_content',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_60745d0d1d384',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
						// array(
						// 	'key' => 'field_60745d1d1d385',
						// 	'label' => 'Content',
						// 	'name' => 'content',
						// 	'type' => 'wysiwyg',
						// 	'instructions' => '',
						// 	'required' => 0,
						// 	'conditional_logic' => 0,
						// 	'wrapper' => array(
						// 		'width' => '',
						// 		'class' => '',
						// 		'id' => '',
						// 	),
						// 	'default_value' => '',
						// 	'tabs' => 'all',
						// 	'toolbar' => 'full',
						// 	'media_upload' => 1,
						// 	'delay' => 0,
						// ),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-and-content',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Map w/ Marker *
acf_add_local_field_group(array(
	'key' => 'group_5fad8bfb7b985',
	'title' => 'Block: Map w/ Marker',
	'fields' => array(
		array(
			'key' => 'field_5fad8c0313f53',
			'label' => 'Map w/ Marker',
			'name' => 'map_w_marker',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5faqwafd34rfad',
					'label' => 'Map w/ Marker',
					'name' => 'map_w_marker_locations',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 1, 
					'max' => '',
					'layout' => 'block',
					'button_label' => 'Add Location',
					'sub_fields' => array(
						array(
							'key' => 'field_62iygauo8hp9ocv7d',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '33.3333333333%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_6p0987oyhasd',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '33.3333333333%',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					
					),
				),
			)
		)
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/map-w-marker',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Post List *
acf_add_local_field_group(array(
	'key' => 'group_5fe0ec87c4f81',
	'title' => 'Block: Post List Block',
	'fields' => array(
		array(
			'key' => 'field_5fe0ec8cc6a95',
			'label' => 'Post List Block',
			'name' => 'post_list_block',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5fe0ecc7c6a98',
					'label' => 'Display Type',
					'name' => 'display_type',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'gallery' => 'Gallery View',
						'list' => 'List View',
						'small' => 'Small List',
						'card' => 'Card View',
						'small_card' => 'Small Card View',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'list',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_5fe0ec9ac6a96',
					'label' => 'Categories',
					'name' => 'categories',
					'type' => 'taxonomy',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'taxonomy' => 'category',
					'field_type' => 'checkbox',
					'add_term' => 0,
					'save_terms' => 0,
					'load_terms' => 0,
					'return_format' => 'id',
					'multiple' => 0,
					'allow_null' => 0,
				),
				array(
					'key' => 'field_61a50fc393f4c',
					'label' => 'Post Types',
					'name' => 'post_type',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => $all_post_types,
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'vertical',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
				array(
					'key' => 'field_5fe0eca6c6a97',
					'label' => 'Posts to Show',
					'name' => 'posts_per_page',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/post-list-block',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Accordion *
acf_add_local_field_group(array(
	'key' => 'group_5faae62cc8b8e',
	'title' => 'Block: Accordion',
	'fields' => array(
		array(
			'key' => 'field_6asd3jk0a2314ad77ae9dd',
			'label' => 'First Accordion Start Open',
			'name' => 'mapi_first_accordion_open',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5faae6330b120',
			'label' => 'Accordions',
			'name' => 'accordions',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Accordion Item',
			'sub_fields' => array(
				array(
					'key' => 'field_5faae6380b121',
					'label' => 'Accordion Header',
					'name' => 'accordion_header',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5faae6400b122',
					'label' => 'Content',
					'name' => 'content',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
					'delay' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/accordion-block',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Slider Image
acf_add_local_field_group(array(
	'key' => 'group_5fa9944816d06',
	'title' => 'Block: Image Slider',
	'fields' => array(
		array(
			'key' => 'field_60a21341asdfb6f29',
			'label' => 'Slides Image Size',
			'name' => 'slide_image_size',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.3333333%',
				'class' => '',
				'id' => '',
			),
			'choices' => mapi_get_regisered_size_options(),
			'default_value' => false,
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_6vghjk0a2e977ae9dd',
			'label' => 'Show Arrows',
			'name' => 'mapi_slider_arrows',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.3333333%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_60a2e1sf977ae9dd',
			'label' => 'Show Dots',
			'name' => 'mapi_slider_dots',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33.3333333%',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fa994503d2ac',
			'label' => 'Images',
			'name' => 'block_image_slides',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Image',
			'sub_fields' => array(
				array(
					'key' => 'field_5fa994553d2ad',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5fa9945b3d2ae',
					'label' => 'Caption',
					'name' => 'caption',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-slider',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Image Grid *
acf_add_local_field_group(array(
	'key' => 'group_5fa9a845af0e5',
	'title' => 'Block: Image Grid',
	'fields' => array(
		array(
			'key' => 'field_6asd3jk1adyoupx123',
			'label' => 'Crop Grid Images to be Square?',
			'name' => 'crop_images',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fa9a85064f7b',
			'label' => 'Images',
			'name' => 'block_image_grid',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add Card',
			'sub_fields' => array(
				array(
					'key' => 'field_5fa9a85b64f7c',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				
				array(
					'key' => 'field_5fa9a86464f7e',
					'label' => 'Description',
					'name' => 'desc',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => 3,
					'new_lines' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/image-grid',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Container *
acf_add_local_field_group(array(
	'key' => 'group_5faca1b7c808b',
	'title' => 'Block: Container',
	'fields' => array(
		array(
			'key' => 'field_5faca1bcebcb7',
			'label' => 'Container Options',
			'name' => 'container_options',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5faca1daebcb8',
					'label' => 'Width',
					'name' => 'width',
					'type' => 'radio',
					'instructions' => 'This setting specifies the width on desktop devices, mobile devices will always be full width. Note: Odd numbers are used to ensure that the content is centered, based on Twitter Bootstrap',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						2 => '2 Columns',
						4 => '4 Columns',
						6 => '6 Columns',
						8 => '8 Columns',
						10 => '10 Columns',
						12 => '12 Columns (default)',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 12,
					'layout' => 'vertical',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_5faca3f4d2f06',
					'label' => 'Background Color',
					'name' => 'background_color',
					'type' => 'color_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/container',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

		//ACF Block Fields: Notice Block
acf_add_local_field_group(array(
	'key' => 'group_6123f24c91198',
	'title' => 'Block: Notice Block',
	'fields' => array(
		array(
			'key' => 'field_6123f25990ccf',
			'label' => 'Notice Block',
			'name' => 'mind_notice_block',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_6123f25e90cd0',
					'label' => 'Notice Type',
					'name' => 'notice_type',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'primary' => 'Primary',
						'secondary' => 'Secondary',
						'success' => 'Success',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'light' => 'Light',
						'dark' => 'Dark',
					),
					'default_value' => 'warning',
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'value',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_6123f2e58a2b0',
					'label' => 'Notice Content',
					'name' => 'notice_content',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
					'delay' => 0,
				),
				array(
					'key' => 'field_6123f3038a2b1',
					'label' => 'Notice Icon',
					'name' => 'notice_icon',
					'type' => 'text',
					'instructions' => 'fontawesome.com/icons EX: fas fa-check-circle',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'fas fa-check-circle',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-notice-block',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));


		//ACF Block Fields: Logo Slider
acf_add_local_field_group(array(
	'key' => 'group_625994542e350',
	'title' => 'Block: Logo Slider',
	'fields' => array(
		array(
			'key' => 'field_6259945849979',
			'label' => 'Logo Slides',
			'name' => 'mind_logo_slides',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_625994614997a',
					'label' => 'Images',
					'name' => 'images',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 1,
					'max' => 35,
					'layout' => 'row',
					'button_label' => 'Add Logo',
					'sub_fields' => array(
						array(
							'key' => 'field_625994664997b',
							'label' => 'Image',
							'name' => 'image',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_6259946a4997c',
							'label' => 'Link',
							'name' => 'link',
							'type' => 'link',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
						),
						array(
							'key' => 'field_6259946f4997d',
							'label' => 'Caption',
							'name' => 'caption',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/mind-logo-slider',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));



		//ACF Block Fields: Card Repeater Block
acf_add_local_field_group(array(
	'key' => 'group_601235336f5c3',
	'title' => 'Block: Card Repeater',
	'fields' => array(
		array(
			'key' => 'field_6012353a4f7d9',
			'label' => 'Block Card Repeater',
			'name' => 'block_card_repeater',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_612fafbads126dcc9',
					'label' => 'Number of Columns',
					'name' => 'num_columns',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'one' => 'One Column',
						'twelve' => 'Twelve Columns',
						'six' => 'Six Columns',
						'four' => 'Four Columns',
						'three' => 'Three Columns',
						'two' => 'Two Columns',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'three',
					'layout' => 'horizontal',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_601235414f7da',
					'label' => 'Cards',
					'name' => 'cards',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => 'Add Card',
					'sub_fields' => array(
						array(
							'key' => 'field_601235464f7db',
							'label' => 'Card Image',
							'name' => 'card_image',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_6012356sfqf7dc',
							'label' => 'Card Header',
							'name' => 'card_header',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_6012354b4f7dc',
							'label' => 'Card Body',
							'name' => 'card_body',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_601235524f7dd',
							'label' => 'Card Link',
							'name' => 'card_link',
							'type' => 'link',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'block',
				'operator' => '==',
				'value' => 'acf/card-repeater-block',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
}, 1);



endif;
