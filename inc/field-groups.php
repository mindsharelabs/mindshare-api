<?php

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title' 	=> 'Custom Popup',
    'menu_title'	=> 'Custom Popup',
    'menu_slug' 	=> 'website-popup',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));

  acf_add_options_page(array(
    'page_title' 	=> 'API Settings',
    'menu_title'	=> 'Mindshare API Settings',
    'menu_slug' 	=> 'mindshare-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));

}

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group( array(
		'key' => 'group_64592a3034ae7',
		'title' => '3rd Party APIs',
		'fields' => array(
			array(
				'key' => 'field_64592a30882f1',
				'label' => 'Google Maps API',
				'name' => 'google_maps_api',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 'AIzaSyDf942BZzWwDifk88ZzA68yhGZ46lCutQI',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_64592aafedd83',
				'label' => 'Facet WP API',
				'name' => 'facet_wp_api',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '6034a621ec91fb6f728dc2ba74c66a3c',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'mindshare-settings',
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
	) );




acf_add_local_field_group(array(
	'key' => 'group_615f2e5af07c6',
	'title' => 'Popup Options',
	'fields' => array(
		array(
			'key' => 'field_615f2f803a703',
			'label' => 'Enable Modal',
			'name' => 'enable_modal',
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
			'key' => 'field_615f2e8e3a6fc',
			'label' => 'Popup Header',
			'name' => 'popup_header',
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
			'key' => 'field_615f2e963a6fd',
			'label' => 'Popup Content',
			'name' => 'popup_content',
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
			'key' => 'field_615f2ea53a6fe',
			'label' => 'Popup Link',
			'name' => 'popup_link',
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
			'key' => 'field_615f2eae3a6ff',
			'label' => 'Popup Options',
			'name' => 'popup_options',
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
					'key' => 'field_615f2eb73a700',
					'label' => 'Position',
					'name' => 'position',
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
						'centered' => 'Centered',
						'top' => 'Top',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'top',
					'layout' => 'vertical',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_615f2ef63a701',
					'label' => 'Size',
					'name' => 'size',
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
						'sm' => 'Small',
						'md' => 'Medium',
						'lg' => 'Large',
						'xd' => 'Extra Large',
						'fullscreen' => 'Full Screen',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
				array(
					'key' => 'field_615f2f3c3a702',
					'label' => 'Behavior',
					'name' => 'behavior',
					'type' => 'radio',
					'instructions' => 'When backdrop is set to static, the modal will not close when clicking outside it.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'static' => 'Static Modal',
						'default' => 'Default',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'default_value' => 'default',
					'layout' => 'vertical',
					'return_format' => 'value',
					'save_other_choice' => 0,
				),
			),
		),
		array(
			'key' => 'field_615f2f8d3a704',
			'label' => 'Location Settings',
			'name' => 'location_settings',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'row',
			'sub_fields' => array(
				array(
					'key' => 'field_615f2f983a705',
					'label' => 'Show on Specific Pages',
					'name' => 'include_specific_pages',
					'type' => 'relationship',
					'instructions' => 'If no page is selected then popup will show on all pages.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => '',
					'taxonomy' => '',
					'filters' => array(
						0 => 'search',
						1 => 'post_type',
						2 => 'taxonomy',
					),
					'elements' => '',
					'min' => '',
					'max' => '',
					'return_format' => 'id',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'website-popup',
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

acf_add_local_field_group(array(
	'key' => 'group_61f31102439e1',
	'title' => 'API Options',
	'fields' => array(
		array(
			'key' => 'field_61f3110917ff1',
			'label' => 'Enable Scripts',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_61f3111417ff2',
			'label' => 'Enable Bootstrap',
			'name' => 'mind_enable_bootstrap',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'js' => 'Enable Bootstrap Javascript',
				'css' => 'Enable Bootstrap CSS',
			),
			'allow_custom' => 0,
			'default_value' => array(
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'mindshare-settings',
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
endif;



function mapi_generate_popup_cookie() {
  if(function_exists('get_current_screen')) :
    $screen = get_current_screen();
    if ($screen->id == 'toplevel_page_website-popup') {
      $cookie = wp_generate_password(12, false, false );
      update_option( 'mapi-website-popup-cookie', $cookie);
    }
  endif;
}
add_action('acf/save_post', 'mapi_generate_popup_cookie', 20);
