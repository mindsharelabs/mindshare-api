<?php

function dbi_add_settings_page() {
    add_options_page( '3rd Party APIs', '3rd Party APIs', 'manage_options', 'mapi-api', 'mapi_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'dbi_add_settings_page' );




function mapi_render_plugin_settings_page() {
    echo '<h2>3rd Party API Keys</h2>';
    echo '<form action="options.php" method="post">';
        settings_fields( 'mapi_plugin_options' );
        do_settings_sections( 'mapi_api_plugin' );
        echo '<input name="submit" class="button button-primary" type="submit" value="' . esc_attr( 'Save' ) . '" />';
    echo '</form>';

}






add_action( 'admin_init', function () {
    register_setting( 'mapi_plugin_options', 'mapi_plugin_options');
    add_settings_section( 'api_settings', 'API Settings', 'dbi_plugin_section_text', 'mapi_api_plugin' );

    add_settings_field( 'mapi_google_api_key', 'Google API Key', function () {
    	$options = get_option( 'mapi_plugin_options' );
    	mapi_write_log($options);
	    echo "<input id='dbi_plugin_setting_api_key' name='mapi_plugin_options[mapi_google_api_key]' type='text' value='" . esc_attr( (isset($options['mapi_google_api_key']) ? $options['mapi_google_api_key'] : '') ) . "' />";
	}, 'mapi_api_plugin', 'api_settings' );

	add_settings_field( 'mapi_facetwp_api_key', 'Facet WP API Key', function () {
    	$options = get_option( 'mapi_plugin_options' );
	    echo "<input id='dbi_plugin_setting_api_key' name='mapi_plugin_options[mapi_facetwp_api_key]' type='text' value='" . esc_attr( (isset($options['mapi_facetwp_api_key']) ? $options['mapi_facetwp_api_key'] : '') ) . "' />";
	}, 'mapi_api_plugin', 'api_settings' );



});

// add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )





function dbi_plugin_section_text() {
    echo '<p>Here you can set all the options for using the API</p>';
}



