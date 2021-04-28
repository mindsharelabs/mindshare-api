<?php
/*
Plugin Name: Mindshare Theme API
Plugin URI: https://mind.sh/are
Description: Provides a library of additional template tags, 3rd-party libraries, Gutenberg BLocks, and functions for WordPress themes and additional features for WordPress CMS websites.
Author: Mindshare Labs, Inc
Version: 2.2.4
Author: Mindshare Labs, Inc
Author URI: https://mind.sh/are
Network: false
*/

class mapiPlugin {
  protected static $instance = NULL;

  public function __construct() {
    if ( !defined( 'MAPI_PLUGIN_FILE' ) ) {
    	define( 'MAPI_PLUGIN_FILE', __FILE__ );
    }
    //Define all the constants
    $this->define( 'MAPI_ABSPATH', dirname( MAPI_PLUGIN_FILE ) . '/' );
    $this->define( 'MAPI_URL', plugin_dir_url( __FILE__ ));
    $this->define( 'MAPI_PLUGIN_VERSION', '2.2.4');
    $this->define( 'MAPI_PREPEND', 'mapi_');
		//TODO: Change this to options
    $this->define( 'GOOGLE_MAPS_API_KEY', 'AIzaSyC0Wo2IFDzXPY18ERmsgXjKljUl1wh9Dl8');

    $this->includes();

	}
  public static function get_instance() {
    if ( null === self::$instance ) {
  		self::$instance = new self;
  	}
  	return self::$instance;
  }
  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }
  private function includes() {
    include_once MAPI_ABSPATH . 'inc/utilities.php';

		//Required Plugins
		require_once 'inc/plugin-activation.class.php';
		require_once 'inc/require-plugins.php';
    //General

    include_once MAPI_ABSPATH . 'inc/blocks.php';
    include_once MAPI_ABSPATH . 'inc/scripts-and-styles.php';
    include_once MAPI_ABSPATH . 'inc/widgets.php';
    include_once MAPI_ABSPATH . 'inc/ajax.php';
  }


}//end of class


new mapiPlugin();





/**
 * Deactivation hook.
 */
function mapi_deactivate() {

}
register_deactivation_hook( __FILE__, 'mapi_deactivate' );
