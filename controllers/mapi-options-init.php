<?php
/**
 * mapi_options
 * Initialize options
 *
 * @author    Mindshare Labs, Inc.
 * @copyright Copyright (c) 2006-2016
 * @link      https://mindsharelabs.com/downloads/mindshare-theme-api/
 */

if (!class_exists('mapi_options')) :
	class mapi_options {

		/**
		 * @var        $options - holds all plugin options
		 */
		protected $options;

		public function __construct() {

			$this->options = get_option(MAPI_OPTIONS);

			do_action('mapi_options_init', $this->options);

			$this->set_error_display_options();
			$this->set_member_options();
			$this->set_inline_post_options();
			$this->set_style_options();
			$this->set_script_options();
			$this->set_misc_options();
		}

		/**
		 * set_error_display_options
		 */
		public function set_error_display_options() {

			if (current_user_can('manage_options')) {
				//if(!headers_sent()) {
				if (mapi_is_true(@$this->options[ 'error_display' ][ "enabled" ])) {
					@ini_set('display_errors', 1);

					if (mapi_is_true(@$this->options[ 'error_display' ][ 'error_display_notice' ])) {
						@error_reporting(E_ALL);
					} else {
						@error_reporting(E_ALL & ~E_NOTICE);
					}

					if (mapi_is_true(@$this->options[ 'error_display' ][ 'error_display_log' ])) {
						@ini_set('log_errors', 1);
						@ini_set('error_log', apply_filters('mapi_error_log_location', get_template_directory() . '/mapi_error_log.txt'));
					}
				}
				//}
			}
		}

		/**
		 * load requested JavaScript
		 */
		public function set_script_options() {

			if (!empty($this->options[ 'enable_adv_speed_options' ]) && !is_admin()) {
				if (!empty($this->options[ 'enable_adv_speed_options' ][ 'dequeue_scripts_txt' ])) {
					add_action('wp_enqueue_scripts', 'mapi_dequeue_scripts', 100);
				}
				if (!empty($this->options[ 'enable_adv_speed_options' ][ 'deregister_scripts_txt' ])) {
					add_action('wp_enqueue_scripts', 'mapi_deregister_scripts', 100);
				}
				if (!empty($this->options[ 'enable_adv_speed_options' ][ 'enqueue_scripts_txt' ])) {
					add_action('wp_enqueue_scripts', 'mapi_enqueue_scripts', 100);
				}
			}
			if (@$this->options[ 'load_jquery' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_jquery');
			}
			if (@$this->options[ 'load_bootstrap' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_bootstrap', 100);
			}
			if (@$this->options[ 'load_bootstrap_css' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_bootstrap_css', 100);
			}
			if (@$this->options[ 'load_font_awesome' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_font_awesome', 100);
			}
			if (@$this->options[ 'load_modernizr_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_modernizr', 50);
			}
			if (@$this->options[ 'load_backbone_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_backbone', 50);
			}
			if (@$this->options[ 'load_underscore_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_underscore', 50);
			}
			if (@$this->options[ 'load_leaflet_js' ] || @$this->options[ 'load_mapbox_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_mapbox', 100); // leaflet replaced by mapbox
			}
			if (@$this->options[ 'load_masonry_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_masonry', 100);
			}
			if (@$this->options[ 'load_isotope_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_isotope', 100);
			}
			if (@$this->options[ 'load_tiptip_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_tiptip', 100);
			}
			if (@$this->options[ 'load_fittext_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_fittext', 100);
			}
			if (@$this->options[ 'load_fitvids_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_fitvids', 100);
			}
			if (@$this->options[ 'load_flexslider' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_flexslider', 100);
			}
			if (@$this->options[ 'load_tinysort_js' ]) {
				add_action('wp_head', 'mapi_load_tinysort', 100);
			}
			if (@$this->options[ 'load_ieupdate' ] === TRUE || mapi_is_true(@$this->options[ 'load_ieupdate' ][ 'enabled' ])) {
				if (@empty($this->options[ 'load_ieupdate_version_txt' ])) {
					$this->options[ 'load_ieupdate_version_txt' ] = 10;
					update_option(MAPI_OPTIONS, $this->options);
				}
				if (empty($this->options[ 'load_ieupdate' ][ 'load_ieupdate_version_txt' ])) {
					$this->options[ 'load_ieupdate' ][ 'load_ieupdate_version_txt' ] = 10;
					update_option(MAPI_OPTIONS, $this->options);
				}
				add_action('wp_head', 'mapi_ie_warning');
			}

			if (@$this->options[ 'break_frames' ]) {
				add_action('wp_head', 'mapi_break_frames', 1);
			}

			if (mapi_is_true(@$this->options[ 'enable_adv_ga_options' ][ 'enabled' ])) {
				add_action('wp_head', 'mapi_analytics');
			}

			if (@$this->options[ 'external_links' ]) {
				add_action('wp_head', 'mapi_external_links', 100);
			}

			if (@$this->options[ 'load_mapi_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_js', 100);
			}

			/**
			 * DEPRECATED LIBRARIES AND SETTINGS (left for backward compatibility):
			 */
			if (@$this->options[ 'load_superfish_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_superfish', 100);
			}
			if (@$this->options[ 'load_swfobject_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_swfobject', 100);
			}
			if (@$this->options[ 'load_replacetext_js' ]) {
				add_action('wp_head', 'mapi_replacetext_js', 100);
			}
			if (@$this->options[ 'load_lettering_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_lettering', 100);
			}
			if (@$this->options[ 'load_pickadate_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_pickadate', 100);
			}
			if (@$this->options[ 'load_retina_js' ]) {
				add_action('wp_enqueue_scripts', 'mapi_load_retina', 100);
			}
			if (@$this->options[ 'load_easylistsplitter_js' ]) {
				add_action('wp_head', 'mapi_load_easylistsplitter', 100);
			}
			if (@$this->options[ 'menu_sort_reverse' ]) {
				// force nav menus to all display in the correct order
				add_filter('wp_nav_menu_objects', create_function('$menu', 'return array_reverse(array_reverse($menu ));'));
			}
		}

		/**
		 * Enable/disable shortcodes for inline posts
		 */
		public function set_inline_post_options() {
			if (@$this->options[ 'enable_inline_post_functions' ]) {
				add_action('init', 'mapi_inline_post_btns'); // add shortcode buttons to TinyMCE
			}
		}

		/**
		 * Enable/disable shortcodes for members-only content
		 */
		public function set_member_options() {
			if (@$this->options[ 'enable_member_functions' ]) {
				add_action('admin_init', 'mapi_member_btns'); // add member shortcode buttons to TinyMCE
			}
		}

		/**
		 * load any requested CSS
		 */
		public function set_style_options() {
			if (!empty($this->options[ 'enable_adv_speed_options' ]) && !is_admin()) {
				if (!empty($this->options[ 'enable_adv_speed_options' ][ 'dequeue_styles_txt' ])) {

					add_action('wp_print_styles', 'mapi_dequeue_css', 100);
				}
				if (!empty($this->options[ 'enable_adv_speed_options' ][ 'deregister_css_txt' ])) {

					add_action('wp_print_styles', 'mapi_deregister_css', 100);
				}
			}
		}

		/**
		 * Setup various additional options
		 */
		public function set_misc_options() {

			/**
			 * Register filters to encode exposed email addresses in
			 * posts, pages, excerpts, comments and widgets.
			 */
			if (@$this->options[ 'encode_email_addresses' ]) {
				$filters = apply_filters('mapi_email_encode_filters', array('the_content', 'the_excerpt', 'widget_text', 'comment_text', 'comment_excerpt'));
				foreach ($filters as $filter) {
					add_filter($filter, 'mapi_encode_emails', 100);
				}
			}
			if (@$this->options[ 'set_admin_color_scheme' ]) {
				add_filter('get_user_option_admin_color', 'mapi_set_admin_color_scheme', 5);
			}
			if (@$this->options[ 'enabled_htmlawed' ]) {
				add_filter('the_content', 'mapi_html_cleanup');
			}
			if (@$this->options[ 'suppress_login_errors' ]) {
				add_filter('login_errors', '__return_false'); // disable login errors
			}
			if (@$this->options[ 'auto_remove_large_images' ]) {
				add_filter('wp_generate_attachment_metadata', 'mapi_remove_large_image');
			}
			if (@$this->options[ 'remove_recent_comments_style' ]) {
				add_action('widgets_init', 'mapi_remove_recent_comments_style'); //[E]
			}
			if (!empty($this->options[ 'excerpt_more_txt' ])) {
				add_filter('excerpt_more', 'mapi_excerpt_more'); // change default more suffix from [...] to ...
			}

			if (!defined('MCMS_SHOW_CREDIT')) {
				if (@$this->options[ 'show_credit' ]) {
					define('MCMS_SHOW_CREDIT', TRUE);
				} else {
					define('MCMS_SHOW_CREDIT', FALSE);
				}
			}

			if (@$this->options[ 'html_compression' ]) {
				// fix incompatibility in Yoast's WordPress SEO if it has been set
				global $wpseo_front;
				if (has_action('get_header', array($wpseo_front, 'force_rewrite_output_buffer'))) {
					remove_action('get_header', array($wpseo_front, 'force_rewrite_output_buffer'));
				}
				add_action('get_header', 'mapi_compress_start', 100);
			}

			if (@$this->options[ 'wp_admin_bar_disabled' ]) {
				add_filter('show_admin_bar', '__return_false');
				remove_action('personal_options', '_admin_bar_preferences');
			}

			if (@$this->options[ 'allow_editors_edit_menus' ]) {
				$roleObject = get_role('editor');
				if (!$roleObject->has_cap('edit_theme_options')) {
					$roleObject->add_cap('edit_theme_options');
				}
			}

			if (@$this->options[ 'move_menus' ]) {
				add_action('admin_menu', 'mapi_admin_menu_nav_menus');
			}

			if (mapi_is_true(@$this->options[ 'maintenance_mode' ][ 'enabled' ])) {
				add_action('get_header', array($this, 'start_maintenance_mode'));
			}

			if (mapi_is_true(@$this->options[ 'custom_branding' ][ 'enabled' ])) {
				add_filter('login_headertitle', array($this, 'login_headertitle'));
				add_filter('login_headerurl', array($this, 'login_headerurl'));
				add_action('login_head', array($this, 'login_head'));
			}

			// Defaults without user override on options page (no user control)
			add_action('wp_head', 'mapi_set_contstants_js', 5);
			add_action('wp_footer', 'mapi_error_console');
			add_action('admin_head', 'mapi_set_contstants_js', 5);
			add_action('admin_menu', array($this, 'sort_dashboard_menu'), 9999);
			add_action('dashboard_glance_items', 'mapi_right_now_content_table_end');
			add_action('wp_dashboard_setup', 'mapi_remove_wpseo_dashboard_overview');
			add_action('wp_before_admin_bar_render', 'mapi_before_admin_bar_render');

			add_action('wp_enqueue_scripts', 'mapi_remove_version_scripts', 100);
			add_action('wp_print_footer_scripts', 'mapi_remove_version_scripts', 100);
			add_action('admin_print_styles', 'mapi_remove_version_styles', 100);
			add_action('wp_print_styles', 'mapi_remove_version_styles', 100);

			// embed actions and filters
			add_action('wp_enqueue_scripts', 'mapi_embed_css', 10);
			add_filter('embed_oembed_html', 'mapi_embed_html', 10, 3);
			add_filter('video_embed_html', 'mapi_embed_html'); // Jetpack

			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
			remove_action('wp_head', 'feed_links', 2);
			remove_action('wp_head', 'feed_links_extra', 3);
			remove_action('wp_head', 'index_rel_link');
			remove_action('wp_head', 'parent_post_rel_link');
			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'start_post_rel_link');
			remove_action('wp_head', 'wlwmanifest_link');

			add_filter('the_generator', '__return_false'); // hide the WP version
			remove_action('wp_head', 'wp_generator');
			add_filter('gform_enable_field_label_visibility_settings', '__return_true'); // enable gforms visibility settings

			add_filter('body_class', 'mapi_add_body_classes'); // add classes to body tag
			add_filter('body_class', 'mapi_add_os_body_class');

			// allow login by email or username
			remove_filter('authenticate', 'wp_authenticate_username_password', 20);
			add_filter('authenticate', 'mapi_email_login_authenticate', 20, 3);
			add_action('login_form', 'mapi_username_or_email_login');

			// delete deprecated credits tab options
			mapi_delete_option('credits');
		}

		public function start_maintenance_mode() {
			$role = @$this->options[ 'maintenance_mode' ][ 'maintenance_mode_role' ];
			if (empty($role)) {
				$role = 'Administrator';
			}

			if (isset($this->options[ 'maintenance_mode' ][ 'maintenance_mode_503' ]) && mapi_is_true(@$this->options[ 'maintenance_mode' ][ 'maintenance_mode_503' ])) {
				$use_503 = TRUE;
			} else {
				$use_503 = FALSE;
			}
			$message = @$this->options[ 'maintenance_mode' ][ 'maintenance_mode_message' ];
			$css = @$this->options[ 'maintenance_mode' ][ 'maintenance_mode_css' ];
			mapi_maintenance_mode(TRUE, $role, $message, $css, $use_503);
		}

		// login page changes
		public function login_headertitle() {
			$string = @$this->options[ 'custom_branding' ][ 'wp_login_title' ];

			return $string;
		}

		public function login_headerurl() {
			$string = esc_url_raw(@$this->options[ 'custom_branding' ][ 'wp_login_url' ]);

			return $string;
		}

		public function login_head() {
			$img_url = parse_url(@$this->options[ 'custom_branding' ][ 'wp_login_img' ][ 'src' ]);

			if (!empty($img_url[ 'path' ])) {
				$image = mapi_thumb(
					apply_filters(
						'mapi_login_image_args',
						array(
							'src' => $img_url[ 'path' ],
							'w'   => 300,
							'h'   => 72,
							'zc'  => 3,
							'ct'  => 0,
						)
					)
				);
				echo "<style type='text/css'>.login h1 a { height: 72px; width: 300px; background: url('" . html_entity_decode($image) . "') no-repeat top center !important; }</style>";
			}
		}

		// sort admin menus alphabetically
		public function sort_dashboard_menu() {
			global $submenu;
			function mapi_comparator($a, $b) {
				return strcasecmp($a[ 0 ], $b[ 0 ]);
			}

			// list any menus to sort

			$menus_to_sort = apply_filters('sort_dashboard_menus', array('tools.php', 'options-general.php'));

			foreach ($submenu as $key => $items) {
				if (!in_array($key, $menus_to_sort)) {
					continue;
				}
				usort($items, "mapi_comparator");
				$submenu[ $key ] = $items;
			}
		}
	}
endif;
