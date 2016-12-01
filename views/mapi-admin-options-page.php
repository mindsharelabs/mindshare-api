<?php

$mapi_options = new mindshare_options_framework(
	array(
		'project_name' => MAPI_PLUGIN_NAME,
		'project_slug' => MAPI_PLUGIN_SLUG,
		'menu'         => 'settings',
		'page_title'   => wp_get_theme() . ' Theme Developer Settings',
		'menu_title'   => 'Developer Settings',
		'capability'   => 'manage_options',
		'option_group' => MAPI_OPTIONS,
		'id'           => MAPI_PLUGIN_SLUG . '-admin-settings',
		'fields'       => array(),
	)
);
$mapi_options->OpenTabs_container('');

$dev_options_label = 'Developer Settings';
$speed_options_label = 'Performance Tuning';
$ga_options_label = 'Analytics Settings';
$misc_options_label = 'Misc. Settings';
$wp_options_label = 'WordPress Tweaks';
$lib_options_label = 'Libraries &amp; Plugins';
$sysinfo_options_label = 'System Information';
$import_options_label = 'Import &amp; Export';

$mapi_options->TabsListing(
	array(
		'links' =>
			array(
				sanitize_title($dev_options_label)     => __($dev_options_label),
				sanitize_title($speed_options_label)   => __($speed_options_label),
				sanitize_title($ga_options_label)      => __($ga_options_label),
				sanitize_title($misc_options_label)    => __($misc_options_label),
				sanitize_title($wp_options_label)      => __($wp_options_label),
				sanitize_title($lib_options_label)     => __($lib_options_label),
				sanitize_title($sysinfo_options_label) => __($sysinfo_options_label),
				sanitize_title($import_options_label)  => __($import_options_label),

			),
	)
);

/*
 * dev tab start
 */
$mapi_options->OpenTab(sanitize_title($dev_options_label));
$mapi_options->Title($dev_options_label);
$mapi_options->addSubtitle('Maintenance Mode');

$maintenance_mode[] = $mapi_options->addParagraph(
	'Drag this bookmarklet to your browser bookmarks bar to quickly bypass Maintenance Mode when it is turned on.<br /><a class="bookmarklet button button-primary button-large" href="javascript:(function()%7Bjavascript%3Avoid((function()%7Bvar%20loc%20%3D%20location.href%3B%20loc.indexOf(%22%3F%22)%20%3D%3D%20-1%20%3F%20(location.href%20%3D%20loc%2B%22%3Fmaintenance%3Dbypass%22)%20%3A%20(location.href%20%3D%20loc%2B%22%26maintenance%3Dbypass%22)%3B%7D)())%7D)()">Bypass Maintenance Mode</a>', TRUE
);

$maintenance_mode[] = $mapi_options->addRoles(
	'maintenance_mode_role',
	array('type' => 'select'),
	array('name' => 'User level required to view the site while maintenance mode is enabled:'),
	TRUE
);

if (locate_template('503.php')) {
	$maintenance_mode[] = $mapi_options->addCheckbox(
		'maintenance_mode_503',
		array(
			'name'  => 'Use <code>503.php</code> template',
			'std'   => FALSE,
			'style' => 'simple',
			'desc'  => 'If checked, the <strong>Offline Message</strong> below will be ignored and the contents of <code>503.php</code> (from current theme folder) will be displayed in its place.',
		),
		TRUE
	);
} else {
	$maintenance_mode[] = $mapi_options->addCheckbox(
		'maintenance_mode_503',
		array(
			'name'  => 'Use <code>503.php</code> Template',
			'desc'  => 'Create a file named <code>503.php</code> in your current theme folder in order to use this option.',
			'std'   => FALSE,
			'style' => 'simple',
		),
		TRUE
	);
}

$maintenance_mode[] = $mapi_options->addWysiwyg(
	'maintenance_mode_message',
	array(
		'std'   => '',
		'desc'  => 'Enter a message to display to logged out users while Maintenance Mode is active. Leave blank for default.',
		'style' => 'width:500px; height:400px',
		'name'  => 'Offline Message',
	),
	TRUE
);

require_once(MAPI_DIR_PATH . 'views/mapi-maintenance-mode-css.php'); // default CSS for offline mode
$maintenance_mode[] = $mapi_options->addCode(
	'maintenance_mode_css',
	array(
		'std'    => $maintenance_mode_css,
		'desc'   => 'Enter custom CSS for Maintenance Mode screen.',
		//'style' => 'width:500px; height:400px',
		'syntax' => 'css',
		'name'   => 'Offline CSS',
	),
	TRUE
);

$mapi_options->addCondition(
	'maintenance_mode',
	array(
		'name'   => 'Enable maintenance mode',
		'std'    => FALSE,
		'fields' => $maintenance_mode,
		'desc'   => 'Temporarily takes the site offline.',
	)
);
$mapi_options->addSubtitle('Debugging Options');
$error_options[] = $mapi_options->addCheckbox(
	'error_display_notice',
	array(
		'name'  => 'Also display PHP notices',
		'std'   => FALSE,
		'style' => 'simple',
	),
	TRUE
);
$error_options[] = $mapi_options->addCheckbox(
	'error_display_log',
	array(
		'name'  => 'Also log error messages to <code><a title="View source in new tab" href="' . get_bloginfo('template_url') . '/mapi_error_log.txt" target="_blank">mapi_error_log.txt</a></code> in current theme directory',
		'std'   => FALSE,
		'style' => 'simple',
	),
	TRUE
);
$mapi_options->addCondition(
	'error_display',
	array(

		'name'   => 'Display PHP error messages to logged in Administrators',
		'std'    => FALSE,
		'fields' => $error_options,
	)
);

$mapi_options->CloseTab();

$mapi_options->OpenTab(sanitize_title($ga_options_label));
$mapi_options->Title($ga_options_label);

$mapi_options->addParagraph('Google Analytics settings.');

$mapi_options->addText(
	'ga_acct_txt',
	array(
		'name' => 'Google Analytics Web Property ID',
		'std'  => NULL,
		'desc' => '<strong>Format:</strong> <code>UA-XXXXX-Y</code><br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("ga_acct_txt"); ?&gt;</code>',
	)
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'universal_analytics',
	array(
		'name'  => 'Use  <a href="https://support.google.com/analytics/answer/2790010?hl=en&ref_topic=2790009" target="_blank" title="View documentation">Universal Analytics</a>. Uncheck for legacy asynchronous code.',
		'style' => 'simple',
		'std'   => TRUE,
	),
	TRUE
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'multiple_domains',
	array(
		'name'  => 'Allow tracking of <a href="https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSite" target="_blank" title="View documentation">multiple top-level domains</a>?',
		'style' => 'simple',
		'std'   => FALSE,
	),
	TRUE
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'enhanced_link_attribution',
	array(
		'name'  => 'Enable <a href="https://support.google.com/analytics/answer/2558867" target="_blank" title="View documentation">Enhanced Link Attribution</a> sitewide?',
		'style' => 'simple',
		'std'   => FALSE,
	),
	TRUE
);
$mapi_options->addCondition(
	'enable_adv_ga_options',
	array(

		'name'   => 'Automatically add Google Analytics tracking code',
		'std'    => FALSE,
		'fields' => $adv_ga_options,
		'desc'   => '<strong>Note:</strong> <a href="https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSite#domainSubDomains" title="View documentation" target="_blank">Tracking multiple subdomains</a> is supported by default.<br /><strong>Template tag:</strong> <code>&lt;?php mapi_analytics(); ?&gt;</code>',
	)
);
$mapi_options->CloseTab();

/*
 * misc tab start
 */
$mapi_options->OpenTab(sanitize_title($misc_options_label));
$mapi_options->Title('Miscellaneous Settings');

$condition_load_ie[] = $mapi_options->addText(
	'load_ieupdate_version_txt',
	array(
		'name' => 'Minimum supported version of Internet Explorer',
		'std'  => 11,
	),
	FALSE
);
$mapi_options->addCondition(
	'load_ieupdate',
	array(
		'name'   => 'Show Internet Explorer update nag',
		'desc'   => '(visitors with IE versions lower than number above will be politely alerted to update)',
		'fields' => $condition_load_ie,
		'std'    => FALSE,
	)
);

$mapi_options->addCheckbox(
	'break_frames',
	array(
		'name' => 'Break out of HTML frames',
		'std'  => FALSE,
	)
);
$mapi_options->addCheckbox(
	'enable_member_functions',
	array(
		'name' => 'Enable members-only TinyMCE shortcodes',
		'desc' => 'This adds three new buttons to the WYSIWYG editor that insert shortcodes to create "members-only" or "visitors-only" content.',
		'std'  => FALSE,
	)
);

$mapi_options->addCheckbox(
	'enable_inline_post_functions',
	array(
		'name' => 'Enable TinyMCE shortcodes for inserting the contents of other posts',
		'desc' => 'This adds two new shortcodes buttons to the WYSIWYG editor that allow you to insert the content of another post or WP_Query into any other post.',
		'std'  => FALSE,
	)
);

$mapi_options->addCheckbox(
	'external_links',
	array(
		'name' => 'Automatically open external links in a new window/tab',
		'desc' => 'Inserts a jQuery snippet that will open all external links in a new window or tab.',
		'std'  => TRUE,
	)
);
$mapi_options->addCheckbox(
	'auto_remove_large_images',
	array(
		'name' => 'Automatically delete full size images on upload',
		'std'  => FALSE,
		'desc' => 'This replaces uploaded fullsize images according to the largest size specified by your <a href="options-media.php">Media settings</a>. In other words, high resolution uploads in the Media Library are replaced with WordPress\' "large" size images. Enabling this does not effect images that have already been uploaded.',
	)
);

$mapi_options->addCheckbox(
	'show_credit',
	array(
		'name' => 'Show Mindshare Labs credit as an HTML comment',
		'std'  => TRUE,
	)
);
$mapi_options->CloseTab();

/*
 * wp tab start
 */
$mapi_options->OpenTab(sanitize_title($wp_options_label));
$mapi_options->Title($wp_options_label);

$mapi_options->addSubtitle('Custom Branding');

$custom_branding[] = $mapi_options->addParagraph('<strong>Caution:</strong> disabling this clears any previously saved Custom Branding options, so you may want to export your settings first.', TRUE);

$custom_branding[] = $mapi_options->addText(
	'wp_login_title',
	array(
		'std'  => 'Powered by ' . get_bloginfo('name'),
		'desc' => 'Enter a custom title for the login screen. <strong>Default:</strong> Powered by WordPress',
		'name' => 'WordPress Login Title',
	),
	TRUE
);

$custom_branding[] = $mapi_options->addText(
	'wp_login_url',
	array(
		'std'  => home_url('/'),
		'desc' => 'Enter a custom URL for the login screen. <strong>Default:</strong> http://wordpress.org',
		'name' => 'WordPress Login Title',
	),
	TRUE
);

$custom_branding[] = $mapi_options->addImage(
	'wp_login_img',
	array(
		'std'  => '',
		'desc' => 'Upload a custom logo image for the login screen.<br /><strong>Standard dimensions:</strong> 300px x 72px',
		'name' => 'WordPress Login Image',
	),
	TRUE
);
$custom_branding[] = $mapi_options->addImage(
	'mapi_favicon',
	array(
		'std'  => '',
		'desc' => 'Upload a custom favicon image. Use a transparent PNG for best results.<br /><strong>Standard dimensions:</strong> 96px x 96px<br /><br />',
		'name' => 'Favicon Image',
	),
	TRUE
);

$mapi_options->addCondition(
	'custom_branding',
	array(
		'name'   => 'Enable custom branding',
		'std'    => FALSE,
		'fields' => $custom_branding,
		'desc'   => 'Replaces the default WordPress branding on the login screen.',
	)
);

$mapi_options->addSubtitle('WordPress Content Settings');

$mapi_options->addText(
	'excerpt_more_txt',
	array(
		'name' => 'Excerpt "more" text',
		'desc' => 'Customize the text displayed at the end of <code>the_excerpt</code> and add a link to the full post. Leave blank to disable. WordPress default: <code>[...]</code>',
		'std'  => apply_filters('mapi_excerpt_more_text', 'Read more &rsaquo;'),
	)
);

$mapi_options->addCheckbox(
	'encode_email_addresses',
	array(
		'name' => 'Obfuscate email addresses',
		'std'  => TRUE,
		'desc' => 'Encodes email addresses in HTML output to hide them from most spam harvesters. By default this will be applied to the following filters: the_content, the_excerpt, widget_text, comment_text, comment_excerpt. Set different filters using the mapi_email_encode_filters filter.',
	)
);

$mapi_options->addCheckbox(
	'enabled_htmlawed',
	array(
		'name' => 'Cleanup HTML tags in the_content before output',
		'std'  => FALSE,
		'desc' => 'This enables <a href="http://goo.gl/OHgmij" title="View documentation" target="_blank">htmLawed</a> to purify HTML entered by users. By default this strips DIV tags, inline styles, and empty tags. You can override and change any settings by creating a PHP file in the current theme folder called <code>htmlawed-config.php</code>',
	)
);

$mapi_options->addSubtitle('Misc. WordPress Settings');

$mapi_options->addCheckbox(
	'set_admin_color_scheme',
	array(
		'name' => 'Override WordPress admin color scheme',
		'std'  => TRUE,
		'desc' => 'This sets the admin colorl scheme to "midnight" by default for users. The default scheme can be changed using the <code>mapi_admin_color_scheme</code> filter.',
	)
);

$mapi_options->addCheckbox(
	'suppress_login_errors',
	array(
		'name' => 'Hide Login Errors',
		'std'  => FALSE,
		'desc' => 'This suppresses error messages on the WordPress login screen.',
	)
);

$mapi_options->addCheckbox(
	'allow_editors_edit_menus',
	array(
		'name' => 'Allow Editors to access Menus',
		'std'  => FALSE,
		'desc' => 'Enables editing of WordPress menus for users with the Editor role.',
	)
);

$mapi_options->addCheckbox(
	'move_menus',
	array(
		'name' => 'Move Menus to top level',
		'std'  => FALSE,
		'desc' => 'Moves the Menus link out from under Appearance to the top level of the WordPress Admin Menu.',
	)
);

$mapi_options->addCheckbox(
	'wp_admin_bar_disabled',
	array(
		'name' => 'Disable WordPress Toolbar',
		'std'  => FALSE,
		'desc' => 'Turns off the WordPress Toolbar sitewide and removes the option from the user profile page.',
	)
);

$mapi_options->addCheckbox(
	'remove_recent_comments_style',
	array(
		'name' => 'Remove inline recent comments CSS and WP 4.2+ Emoji code from header',
		'desc' => 'This removes some (typically) unneeded inline JS/CSS from your HEAD added by WordPress.',
		'std'  => TRUE,
	)
);

$mapi_options->CloseTab();

/*
 * lib tab start
 */
$mapi_options->OpenTab(sanitize_title($lib_options_label));
$mapi_options->Title($lib_options_label);

$mapi_options->addParagraph(
	'Quickly and easily add the most common (and cool!) JavaScript and jQuery libraries and utilities.
	The Mindshare Theme API is updated regularly with the latest versions so you don\'t need to worry
	about bundling old third-party code into your custom themes. Just turn a feature on and it will be
	automatically inlcuded in your theme.'
);
$mapi_options->addParagraph(
	'<span title="Bundled with WordPress" class="dashicons dashicons-wordpress" style="margin-bottom: 3px;"></span> = Bundled with WordPress<br /><span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span> = Loaded via CDN'
);

$mapi_options->addSubtitle('Libraries');
$mapi_options->addCheckbox(
	'load_jquery',
	array(
		'name' => 'jQuery <span title="Bundled with WordPress" class="dashicons dashicons-wordpress" style="margin-bottom: 3px;"></span>',
		'std'  => TRUE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_bootstrap',
	array(
		'name' => 'Bootstrap (JS only) <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_bootstrap_css',
	array(
		'name' => 'Bootstrap (CSS only) <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_font_awesome',
	array(
		'name' => 'Font Awesome <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_modernizr_js',
	array(
		'name' => 'Modernizr <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_backbone_js',
	array(
		'name' => 'Backbone <span title="Bundled with WordPress" class="dashicons dashicons-wordpress" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_underscore_js',
	array(
		'name' => 'Underscore <span title="Bundled with WordPress" class="dashicons dashicons-wordpress" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_mapbox_js',
	array(
		'name' => 'Mapbox <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addSubtitle('jQuery Plugins');

$mapi_options->addCheckbox(
	'load_fittext_js',
	array(
		'name' => 'jQuery FitText plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_fitvids_js',
	array(
		'name' => 'jQuery FitVids plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_flexslider',
	array(
		'name' => 'jQuery FlexSlider plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_isotope_js',
	array(
		'name' => 'jQuery Isotope plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_masonry_js',
	array(
		'name' => 'jQuery Masonry plugin <span title="Bundled with WordPress" class="dashicons dashicons-wordpress" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->addCheckbox(
	'load_tinysort_js',
	array(
		'name' => 'jQuery TinySort plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);
$mapi_options->addCheckbox(
	'load_tiptip_js',
	array(
		'name' => 'jQuery TipTip plugin <span title="Loaded via CDN" class="dashicons dashicons-cloud" style="margin-bottom: 3px;"></span>',
		'std'  => FALSE,
		'desc' => '',
	)
);

$mapi_options->CloseTab();

/*
 * speed tab start
 */
$mapi_options->OpenTab(sanitize_title($speed_options_label));
$mapi_options->Title($speed_options_label . ' <small>(disable during dev/testing!)</small>');

$mapi_options->addCheckbox(
	'minify_js',
	array(
		'name' => 'Minify JavaScript',
		'desc' => 'Automatically combine and compress all registered JS files (from theme and WordPress plugins.)',
		'std'  => FALSE,
	));
$mapi_options->addCheckbox(
	'minify_css',
	array(
		'name' => 'Minify CSS',
		'desc' => 'Automatically combine and compress all registered CSS files.',
		'std'  => FALSE,
	));

$mapi_options->addCheckbox(
	'html_compression',
	array(
		'name' => 'Minify HTML',
		'std'  => FALSE,
		'desc' => 'Strip whitespace and HTML comments, excluding IE conditional comments. Enable for production. Wrap content you don\'t want compressed in your theme files with: <code>mapi_stop_compression()</code> and <code>mapi_start_compression()</code>',
	)
);
$mapi_options->addText(
	'cache_interval',
	array(
		'name' => 'Minify cache expiration (in seconds)',
		'std'  => 432000,
		'desc' => 'Default is 432000 seconds (120 hours).',
	)
);
$mapi_options->addParagraph(
	'<span class="at-label"><label for="cache_interval">Clear minify cache</label></span>' . wp_nonce_field('clear-minify-cache', '_wpnonce', TRUE, FALSE) . '<input class="button-secondary" type="submit" name="mapi_options_clear_cache_submit" value="Clear Cache Now" />'
);
$speed_adv_options[] = $mapi_options->addParagraph('<strong>Caution:</strong> disabling this clears all Advanced Performance Tuning options below, so you may want to export your settings first.', TRUE);
$speed_adv_options[] = $mapi_options->addSubtitle('Advanced JavaScript Options', TRUE);

$speed_adv_options[] = $mapi_options->addTextarea(
	'dequeue_scripts_txt',
	array(
		'name' => 'Dequeue JS',
		'desc' => 'Enter a list of JS handles to send to <code>wp_dequeue_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.',
	), TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'deregister_scripts_txt',
	array(
		'name' => 'Deregister JS',
		'desc' => 'Enter a list of JS handles to send to <code>wp_deregister_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.',
	), TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'enqueue_scripts_txt',
	array(
		'name' => 'Enqueue JS',
		'desc' => 'Enter a list of JS handles to send to <code>wp_enqueue_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.',
	), TRUE);
/*$speed_adv_options[] = $mapi_options->addTextarea(
	'register_scripts_txt',
	array(
		 'name' => 'Register JS',
		 'desc' => 'Enter a list of JS handles to send to <code>wp_register_script</code> (one per line).'
	), TRUE);*/
$speed_adv_options[] = $mapi_options->addSubtitle('Advanced CSS Options', TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'dequeue_styles_txt',
	array(
		'name' => 'Dequeue CSS',
		'desc' => 'Enter a list of CSS handles to send to <code>wp_dequeue_style</code> (one per line). Note that this setting is not related to CSS minification and will take effect whether minification is used or not.<br /><strong>Examples:</strong> gforms_css,shadowbox-css,shadowbox-extras,shopp.catalog,shopp,shopp.colorbox',
	),
	TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'deregister_styles_txt',
	array(
		'name' => 'Deregister CSS',
		'desc' => 'Enter a list of CSS handles to send to <code>wp_deregister_style</code> (one per line). Note that this setting is not related to CSS minification and will take effect whether minification is used or not.',
	),
	TRUE);

$speed_adv_options[] = $mapi_options->addSubtitle('Advanced Minify Options', TRUE);
$speed_adv_options[] = $mapi_options->addCheckbox(
	'debug_nominify',
	array(
		'name'  => 'Combine JS only - no minification (safe mode)',
		'std'   => FALSE,
		'style' => 'simple',
		'desc'  => 'If checked, files are not compressed. Useful for debugging JS issues, not recommended for production.',
	),
	TRUE
);
$speed_adv_options[] = $mapi_options->addTextarea(
	'js_exclude',
	array(
		'name' => 'Exclude JS from minification (by URI pattern)',
		'desc' => 'JavaScript URI patterns to exclude from minify (one per line). Example: \'jquery\' matches all JS files with \'jquery\' in the filename.',
		'std'  => "google\ngravity\ntribe",
	),
	TRUE
);

$speed_adv_options[] = $mapi_options->addTextarea(
	'css_exclude',
	array(
		'name' => 'Exclude CSS from minification (by URI pattern)',
		'desc' => 'CSS URI patterns to exclude from minify (one per line). Example: \'style\' matches all JS files with \'style\' in the filename.',
		'std'  => "google\ngravity\ntribe",
	),
	TRUE);

$speed_adv_options[] = $mapi_options->addText(
	'extra_minify_options',
	array(
		'name' => 'Minify Engine Tweaking/Tuning',
		'std'  => '',
		'desc' => 'Extra arguments to pass to the minify engine. This value will get appended to the minify URL "<em>/min/?f=file1.js,file2.js</em>"',
	),
	TRUE
);
$mapi_options->addCondition(
	'enable_adv_speed_options',
	array(

		'name'   => 'Enable Advanced ' . $speed_options_label . ' options',
		'std'    => TRUE,
		'fields' => $speed_adv_options,
	)
);

$mapi_options->addSubtitle('Troubleshooting Minify Errors <span class="dashicons dashicons-sos"></span>');
$mapi_options->addParagraph('Combining and compressing all JS and CSS files can be a huge performance boost! Enable for production, disable during development, troubleshooting and testing. <strong>IMPORTANT: Test your site after you turn this on - not all JavaScript and CSS files can be automatically minified</strong> (if they contain errors or poorly formatted code).');
$mapi_options->addParagraph('If you encounter problems after enabling one of the options above try narrowing down which JS or CSS file(s) are causing trouble using the <strong>Advanced Minify Options</strong> above. Also keep in mind that if you have a lot of JS and CSS files to compress, the minify processor may run out of memory on depending on your PHP configuration. Running out of memory may result in a minify builder login prompt being displayed when viewing the site. To fix this you can either increase the memory available to PHP or exclude one or more files from minification.');
$mapi_options->addParagraph('While logged in to WordPress you can temporarily disable minification of JS and CSS files by appending this $_GET variable to any URL: <code>?minify-off=1</code> you can also add this bookmarklet to your browser to assist in debugging: <br /><a class="bookmarklet button button-primary button-large" href="javascript:(function()%7Bjavascript%3Avoid((function()%7Bvar%20loc%20%3D%20location.href%3B%20loc.indexOf(%22%3F%22)%20%3D%3D%20-1%20%3F%20(location.href%20%3D%20loc%2B%22%3Fminify-off%3D1%22)%20%3A%20(location.href%20%3D%20loc%2B%22%26minify-off%3D1%22)%3B%7D)())%7D)()">JS/CSS Minify Off</a>');
$mapi_options->addParagraph('If you have errors after enabling HTML compression you can partially disable HTML compression by wrapping content you don\'t want compressed in your theme files within two PHP functions like so:<br /> <code>&lt;?php mapi_stop_compression(); ?&gt;<br />this won\'t get compressed<br />&lt;?php mapi_start_compression(); ?&gt;</code>');

$mapi_options->CloseTab();

/*
 * tab start
 */
$mapi_options->OpenTab(sanitize_title($sysinfo_options_label));
$mapi_options->Title($sysinfo_options_label);
$mapi_options->addParagraph('<a class="button-primary" href="#" onclick="window.open(\'' . MAPI_DIR_URL . 'views/mapi-phpinfo.php\',\'PHPInfo\',\'width=800,height=600,scrollbars=1\');return FALSE;">PHP Info</a>');
$mapi_options->addTextarea(
	'sysinfo',
	array(
		'name' => $sysinfo_options_label,
		'desc' => 'This information can be useful when you are debugging problems with you WordPress installation.',
		'std'  => mapi_system_info(),
	)
);
$mapi_options->CloseTab();

/*
 * tab start
 */
$mapi_options->OpenTab(sanitize_title($import_options_label));
$mapi_options->Title($import_options_label);
$mapi_options->addImportExport();
$mapi_options->CloseTab();

/*
 * Help Tabs
 */
$mapi_options->HelpTab(
	array(
		'id'      => 'mapi-help-tab',
		'title'   => 'API Documentation',
		'content' => '<p>API documentation is available online at <a href="https://mindsharelabs.com/topics/mindshare-theme-api/" target="_blank">https://mindsharelabs.com/topics/mindshare-theme-api/</a></p>',
	)
);
$mapi_options->HelpTab(
	array(
		'id'      => 'mapi-support-tab',
		'title'   => 'API Support',
		'content' => '<p>Get support on the Mindshare Labs forums: <a href="https://mindsharelabs.com/forums/" target="_blank">https://mindsharelabs.com/forums/</a></p><p>To get premium one-on-one support, contact us: <a href="http://mind.sh/are/contact/">http://mind.sh/are/contact/</a></p>',
	)
);
$mapi_options->HelpTab(
	array(
		'id'      => 'mapi-themes-tab',
		'title'   => 'Get More Themes',
		'content' => '<p>Download compatible free and premium themes from the Mindshare Labs: <a href="https://mindsharelabs.com/" target="_blank">https://mindsharelabs.com/</a></p>',
	)
);
$secure_tab_content = "<p>Get the Mindshare Team to secure and protect your WordPress site for $9.95/month: <a href='http://mind.sh/are/wordpress-security-and-backup-service/check/?url=" . get_bloginfo("url") . "&amp;active=0&amp;sale=1&amp;d=" . str_replace(
		array(
			"http://",
			"https://",
		),
		"",
		get_home_url()) . "' target='_blank'>http://mind.sh/are/wordpress-security-and-backup-service/</a></p>";
$mapi_options->HelpTab(
	array(
		'id'      => 'mapi-security-tab',
		'title'   => 'Protect Your Site',
		'content' => $secure_tab_content,
	)
);
