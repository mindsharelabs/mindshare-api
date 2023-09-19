<?php
/*
Plugin Name: Mindshare Theme API
Plugin URI: https://mind.sh/are
Description: Provides a library of additional template tags, 3rd-party libraries, Gutenberg Blocks, and functions for WordPress themes and additional features for WordPress CMS websites.
Author: Mindshare Labs, Inc
Version: 2.8.2
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
    $this->define( 'MAPI_PLUGIN_VERSION', '2.8.2');
    $this->define( 'MAPI_PREPEND', 'mapi_');
    $this->define( 'ACF_PRO_LICENSE', 'b3JkZXJfaWQ9MzI5NTN8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTA3LTA3IDE1OjU4OjE5');



   
    $this->define('MIND_ACF_PATH', MAPI_ABSPATH . '/includes/acf/' );
    $this->define('MIND_ACF_URL', MAPI_URL . '/includes/acf/' );



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

    if( ! class_exists('ACF') ) :
      include_once MIND_ACF_PATH . 'acf.php';
      // Customize the url setting to fix incorrect asset URLs.
      add_filter('acf/settings/url', function ( $url ) {
        return MIND_ACF_URL;
      });

      // (Optional) Hide the ACF admin menu item.
      add_filter('acf/settings/show_admin', function ( $show_admin ) {
          return true;
      });
    endif;


    include_once MAPI_ABSPATH . 'inc/utilities.php';
    include_once MAPI_ABSPATH . 'inc/multiple-roles.php';
    // Include the ACF plugin.

		//Required Plugins
		require_once 'inc/plugin-activation.class.php';
		require_once 'inc/require-plugins.php';


    //General
    include_once MAPI_ABSPATH . 'inc/field-groups.php';
    include_once MAPI_ABSPATH . 'inc/blocks.php';
    include_once MAPI_ABSPATH . 'inc/scripts-and-styles.php';
    include_once MAPI_ABSPATH . 'inc/widgets.php';
    include_once MAPI_ABSPATH . 'inc/ajax.php';
    // include_once MAPI_ABSPATH . 'inc/popups/popup.php';
    include_once MAPI_ABSPATH . 'inc/options.php';



  }


}//end of class


new mapiPlugin();





/**
 * Deactivation hook.
 */
function mapi_deactivate() {

}
register_deactivation_hook( __FILE__, 'mapi_deactivate' );
