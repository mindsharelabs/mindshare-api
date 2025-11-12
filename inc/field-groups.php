<?php

add_action('init', 'mindshare_api_init');
function mindshare_api_init() {
if( function_exists('acf_add_options_page') ) {
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

}