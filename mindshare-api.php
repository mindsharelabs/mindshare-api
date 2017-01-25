<?php
/*
Plugin Name: Mindshare Theme API
Plugin URI: https://mindsharelabs.com/downloads/mindshare-theme-api/
Description: Provides a library of additional template tags, 3rd-party libraries, and functions for WordPress themes and additional features for WordPress CMS websites.
Author: Mindshare Labs, Inc
Version: 1.1.2
Author URI: https://mind.sh/are/
Network: false
*/

/**
 * define constants & globals
 */
$MAPI_ERRORS = array();
$MAPI_TLD = ''; // global variable for grabbing the base URL w/o subdomains in mapi_external_links() to reduce processor/memory usage

if (!defined('MAPI_MIN_WP_VERSION')) {
	define('MAPI_MIN_WP_VERSION', '4.0');
}

if (!defined('MAPI_PLUGIN_NAME')) {
	define('MAPI_PLUGIN_NAME', 'Mindshare Theme API');
}

if (!defined('MAPI_UPDATE_URL')) {
	define('MAPI_UPDATE_URL', 'https://mindsharelabs.com');
}

if (!defined('MAPI_PLUGIN_SLUG')) {
	define('MAPI_PLUGIN_SLUG', dirname(plugin_basename(__FILE__))); // mindshare-api-master
}

if (!defined('MAPI_DIR_PATH')) {
	define('MAPI_DIR_PATH', plugin_dir_path(__FILE__)); // /.../wp-content/plugins/mindshare-api-master/
}

if (!defined('MAPI_DIR_URL')) {
	define('MAPI_DIR_URL', trailingslashit(plugins_url(NULL, __FILE__)));
}

if (!defined('MAPI_OPTIONS')) {
	define('MAPI_OPTIONS', 'mapi_options');
}

// cache folder for mapi_thumb within wp-content/uploads
if (!defined('BFITHUMB_UPLOAD_DIR')) {
	define('BFITHUMB_UPLOAD_DIR', 'cache');
}

// pre-0.7 version folder/file naming convention
if (!defined('MAPI_LEGACY_NAME')) {
	define('MAPI_LEGACY_NAME', 'mcms-api/mcms-api.php');
}

// check WordPress version
global $wp_version;
if (version_compare($wp_version, MAPI_MIN_WP_VERSION, "<")) {
	exit(MAPI_PLUGIN_NAME . ' requires WordPress ' . MAPI_MIN_WP_VERSION . ' or newer.');
}

// deny direct access
if (!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

// make sure a few WP functions are available
if (!function_exists('is_plugin_active')) {
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

// EDD updater
if (!class_exists('Mindshare_API_Plugin_Updater')) {
	// load our custom updater
	include_once(MAPI_DIR_PATH . 'lib/Mindshare_API_Plugin_Updater.php');
}

/**
 * Mindshare_API class
 * wrapper class for the API
 *
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/downloads/mindshare-theme-api/
 */
if (!class_exists("Mindshare_API")) :
	class Mindshare_API {

		/**
		 * Instance of the mapi_options class
		 *
		 * @var object
		 */
		private $options;

		/**
		 * This version number for the Mindshare Auto Update library
		 * This value is returned when this class or its children if they are
		 * treated as a string (via __toString())
		 *
		 * @var string
		 */
		private $class_version = '1.1.2';

		/**
		 * Used for automatic updates
		 *
		 * @var string
		 */
		private $license_key = 'mapi-free-license';

		/**
		 * Instantiate the API
		 */
		function __construct() {

			if (is_multisite()) {
				register_activation_hook(__FILE__, array($this, '_check_network_activation'));
			}

			add_filter('acf_settings', array($this, 'acf_init'));
			add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
			add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
			add_action('admin_init', array($this, 'check_update'));
			add_action('after_setup_theme', array($this, 'load_api'));
			add_action('plugins_loaded', array($this, 'load_textdomain'));
			add_filter('auto_update_plugin', '__return_true'); // WP 3.8+ auto updates

			// include the TGM_Plugin_Activation class
			require_once(MAPI_DIR_PATH . 'vendor/tgm/plugin-activation/class-tgm-plugin-activation.php');
			add_action('tgmpa_register', array($this, 'register_required_plugins'));
		}

		/**
		 * The version number for this class (Mindshare Auto Update)
		 *
		 * @return string
		 */
		public function __toString() {
			return MAPI_PLUGIN_NAME . ' ' . $this->class_version;
		}

		/**
		 * Register the plugin text domain for translation
		 */
		public function load_textdomain() {
			load_plugin_textdomain('mapi', FALSE, MAPI_PLUGIN_SLUG);
		}

		/**
		 * Prevent Network Activation in a WordPress Multisite install
		 *
		 * @param $network_wide
		 */
		public function _check_network_activation($network_wide) {
			if (!$network_wide) {
				return;
			}
			deactivate_plugins(plugin_basename(__FILE__), TRUE, TRUE);
			header('Location: ' . network_admin_url('plugins.php?deactivate=true'));
			exit;
		}

		/**
		 * Configure auto install routine for any additional plugins
		 */
		public function register_required_plugins() {

			$plugins = apply_filters(
				'mapi_register_required_plugins',
				array(
					// include a plugin from the WordPress Plugin Repository
					array(
						'name'     => 'PHP Browser Detection',
						'slug'     => 'php-browser-detection',
						'required' => FALSE,
					),
				)
			);

			$config = array(
				'domain'       => 'mapi', // Text domain
				'default_path' => '', // Default absolute path to pre-packaged plugins
				'menu'         => 'install-required-plugins', // Menu slug
				'has_notices'  => TRUE, // Show admin notices or not
				'is_automatic' => TRUE, // Automatically activate plugins after installation or not
				'message'      => '', // Message to output right before the plugins table
				'strings'      => array(
					'page_title'                      => __('Install Required Plugins', 'mapi'),
					'menu_title'                      => __('Install Plugins', 'mapi'),
					'installing'                      => __('Installing Plugin: %s', 'mapi'),
					// %1$s = plugin name
					'oops'                            => __('Something went wrong with the plugin API.', 'mapi'),
					'notice_can_install_required'     => _n_noop('The Mindshare Theme API requires the following plugin: %1$s.', 'The Mindshare Theme API requires the following plugins: %1$s.'),
					// %1$s = plugin name(s)
					'notice_can_install_recommended'  => _n_noop('To take full advantage of the Mindshare Theme API please install the following plugin: %1$s.', 'To take full advantage of the Mindshare Theme API please install the following plugins: %1$s.'),
					// %1$s = plugin name(s)
					'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'),
					// %1$s = plugin name(s)
					'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'),
					// %1$s = plugin name(s)
					'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'),
					// %1$s = plugin name(s)
					'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'),
					// %1$s = plugin name(s)
					'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'),
					// %1$s = plugin name(s)
					'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'),
					// %1$s = plugin name(s)
					'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins'),
					'activate_link'                   => _n_noop('Activate installed plugin', 'Activate installed plugins'),
					'return'                          => __('Return to Required Plugins Installer', 'mapi'),
					'plugin_activated'                => __('Plugin activated successfully.', 'mapi'),
					'complete'                        => __('All plugins installed and activated successfully. %s', 'mapi'),
					// %1$s = dashboard link
					'nag_type'                        => 'updated'
					// Determines admin notice type - can only be 'updated' or 'error'
				),
			);
			tgmpa($plugins, $config);
		}

		/**
		 * Check for available updates
		 */

		public function check_update() {

			$edd_active = get_option('mapi_license_status');

			// EDD updates are already activated for this site, so exit
			if ($edd_active != 'valid') {

				$response = wp_remote_get(
					add_query_arg(
						array(
							'edd_action' => 'activate_license',
							'license'    => $this->license_key,
							'item_name'  => urlencode(MAPI_PLUGIN_NAME), // the name of our product in EDD
							'url'        => home_url(),
						),
						MAPI_UPDATE_URL
					),
					array(
						'timeout'   => 15,
						'sslverify' => FALSE,
					)
				);

				// make sure the response came back okay
				if (is_wp_error($response)) {
					return FALSE;
				}

				// decode the license data
				$license_data = json_decode(wp_remote_retrieve_body($response));

				// $license_data->license will be either "valid" or "invalid"
				if (is_object($license_data)) {
					update_option('mapi_license_status', $license_data->license);
				}
			}

			$mindshare_api_updater = new Mindshare_API_Plugin_Updater(
				MAPI_UPDATE_URL,
				__FILE__,
				array(
					'version'   => $this->class_version, // current version number
					'license'   => $this->license_key,
					'item_name' => MAPI_PLUGIN_NAME, // name of this plugin
					'author'    => 'Mindshare Labs, Inc.',
				)
			);
		}

		/**
		 * Add settings link to plugins page
		 *
		 * @param $links
		 * @param $file
		 *
		 * @return array
		 */
		public function plugin_action_links($links, $file) {
			if ($file == plugin_basename(__FILE__)) {
				$settingslink = '<a href="themes.php?page=' . MAPI_PLUGIN_SLUG . '-settings" title="Theme Settings">Theme</a> | <a href="options-general.php?page=' . MAPI_PLUGIN_SLUG . '-admin-settings" title="Developer Settings">Developer</a>';
				array_unshift($links, $settingslink);
			}

			return $links;
		}

		/**
		 * Add meta links to plugins page
		 *
		 * @param $links
		 * @param $file
		 *
		 * @return array
		 */
		public function plugin_row_meta($links, $file) {
			if ($file == plugin_basename(__FILE__)) {
				$links = array_merge(
					$links,
					array(
						sprintf(
							'<a href="https://mindsharelabs.com/topics/mindshare-theme-api/" title="%1$s" target="_blank">%1$s</a>',
							esc_html__('Function Reference', 'mapi')
						),
						sprintf(
							'<a href="https://github.com/mindsharestudios/mindshare-api/" title="%1$s" target="_blank">%1$s</a>',
							esc_html__('GitHub', 'mapi')
						),
						sprintf(
							'<a href="http://mind.sh/are/donate/" title="%1$s" target="_blank">%1$s</a>',
							esc_html__('Donate', 'mapi')
						),
					)
				);
			}

			return $links;
		}

		/**
		 * Check saved options, perform related actions
		 */
		public function options_init() {
			// load existing options
			include_once('controllers/mapi-options-init.php');
			$this->options = new mapi_options($this); // filterable using 'mapi_options_init'

			// load the options framework
			include_once('lib/mindshare-options-framework/mindshare-options-framework.php');
			include_once('views/mapi-system-info.php');
			//include_once('views/mapi-credits.php');
			include_once('views/mapi-options-page.php');
			include_once('views/mapi-admin-options-page.php');
		}

		/**
		 * Initialize Advanced Custom Fields options
		 *
		 * @param $options
		 *
		 * @return array
		 */
		public function acf_init($options) {
			$options = array(
				'activation_codes' => array(
					'repeater'         => 'QJF7-L4IX-UCNP-RF2W',
					'options_page'     => 'OPN8-FA4J-Y2LW-81LS',
					'flexible_content' => 'FC9O-H6VN-E4CL-LT33',
					'gallery'          => 'GF72-8ME6-JS15-3PZC',
				),
			);

			return apply_filters('mapi_acf_init', $options);
		}

		/**
		 * All systems go, load the API.
		 * Runs on 'init' action.
		 */
		public function load_api() {

			do_action('mapi_start');

			include_once('core/mapi-admin.php');
			include_once('core/mapi-utility.php');
			include_once('core/mapi-query.php');
			include_once('core/mapi-attachment.php');
			include_once('core/mapi-category.php');
			include_once('core/mapi-compression.php');
			include_once('core/mapi-minify.php');
			include_once('core/mapi-mobile.php');
			include_once('core/mapi-page-post.php');
			include_once('core/mapi-search.php');
			include_once('core/mapi-security.php');
			include_once('core/mapi-shortcodes.php');
			include_once('core/mapi-social.php');
			include_once('core/mapi-facebook.php');
			include_once('core/mapi-embed.php');
			include_once('core/mapi-taxonomy.php');
			include_once('core/mapi-theme.php');
			include_once('core/mapi-user.php');
			include_once('core/mapi-email.php');

			// deprecated functions
			include_once('core/deprecated.php');

			// check the minify cache
			if (isset($mapi_minify) && is_a($mapi_minify, 'mapi_minify')) {
				$config_set = get_option('mapi_minify_config_set');
				if ($config_set != 1) {
					if (is_writable($mapi_minify->minify_config_location)) {
						$mapi_minify->check_minify_config();
					}
				}
			}

			$this->options_init();

			do_action('mapi_end');
		}
	}
endif;

// check to make sure old version is not going to cause conflicts
if (!is_plugin_active(MAPI_LEGACY_NAME)) {
	$mapi = new Mindshare_API();
} else {
	deactivate_plugins(array(MAPI_LEGACY_NAME));
	function upgrade_admin_notice() {
		?>
		<div class="updated">
			<p><?php _e('Upgrading the ' . MAPI_PLUGIN_NAME . ' is complete. <a href="plugins.php">Please refresh</a>.', 'mapi'); ?></p>
		</div>
		<?php
	}

	add_action('admin_notices', 'upgrade_admin_notice');
}
