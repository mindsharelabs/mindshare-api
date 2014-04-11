<?php

$mapi_options = new mindshare_options_framework(
	array(
		 'project_name' => MAPI_PLUGIN_NAME,
		 'project_slug' => MAPI_PLUGIN_SLUG,
		 'menu'         => 'settings',
		 'page_title'   => wp_get_theme().' Theme Developer Settings',
		 'menu_title'   => 'Developer Settings',
		 'capability'   => 'manage_options',
		 'option_group' => MAPI_OPTIONS,
		 'id'           => MAPI_PLUGIN_SLUG.'-admin-settings',
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
$credits_options_label = 'Credits';
$import_options_label = 'Import &amp; Export';

$mapi_options->TabsListing(
	array(
		 'links' =>
		 array(
			 sanitize_title($dev_options_label)     => __($dev_options_label),
			 sanitize_title($speed_options_label)   => __($speed_options_label),
			 sanitize_title($ga_options_label)       => __($ga_options_label),
			 sanitize_title($misc_options_label)    => __($misc_options_label),
			 sanitize_title($wp_options_label)      => __($wp_options_label),
			 sanitize_title($lib_options_label)     => __($lib_options_label),
			 sanitize_title($sysinfo_options_label) => __($sysinfo_options_label),
			 sanitize_title($import_options_label)  => __($import_options_label),
			 sanitize_title($credits_options_label) => __($credits_options_label),
		 )
	)
);

/*
 * dev tab start
 */
$mapi_options->OpenTab(sanitize_title($dev_options_label));
$mapi_options->Title($dev_options_label);
$mapi_options->addSubtitle('Maintenance Mode');

$maintenance_mode[] = $mapi_options->addRoles(
	'maintenance_mode_role',
	array('type' => 'select'),
	array('name' => 'User level required to view the site while maintenance mode is enabled:'),
	TRUE
);

if(locate_template('503.php')) {
	$maintenance_mode[] = $mapi_options->addCheckbox(
		'maintenance_mode_503',
		array(
			 'name'  => 'Use <code>503.php</code> template',
			 'std'   => FALSE,
			 'style' => 'simple',
			 'desc'  => 'If checked, the <strong>Offline Message</strong> below will be ignored and the contents of <code>503.php</code> (from current theme folder) will be displayed in its place.'
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
			 'style' => 'simple'
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
		 'name'  => 'Offline Message'
	),
	TRUE
);

require_once(MAPI_DIR_PATH.'/views/mapi-maintenance-mode-css.php'); // default CSS for offline mode
$maintenance_mode[] = $mapi_options->addCode(
	'maintenance_mode_css',
	array(
		 'std'    => $maintenance_mode_css,
		 'desc'   => 'Enter custom CSS for Maintenance Mode screen.',
		 //'style' => 'width:500px; height:400px',
		 'syntax' => 'css',
		 'name'   => 'Offline CSS'
	),
	TRUE
);

$mapi_options->addCondition(
	'maintenance_mode',
	array(
		 'name'   => 'Enable maintenance mode',
		 'std'    => FALSE,
		 'fields' => $maintenance_mode,
		 'desc'   => 'Temporarily takes the site offline.'
	)
);
$mapi_options->addSubtitle('Debugging Options');
$error_options[] = $mapi_options->addCheckbox(
	'error_display_notice',
	array(
		 'name'  => 'Also display PHP notices',
		 'std'   => FALSE,
		 'style' => 'simple'
	),
	TRUE
);
$error_options[] = $mapi_options->addCheckbox(
	'error_display_log',
	array(
		 'name'  => 'Also log error messages to <code><a title="View source in new tab" href="'.get_bloginfo('template_url').'/mapi_error_log.txt" target="_blank">mapi_error_log.txt</a></code> in current theme directory',
		 'std'   => FALSE,
		 'style' => 'simple'
	),
	TRUE
);
$mapi_options->addCondition(
	'error_display',
	array(

		 'name'   => 'Display PHP error messages to logged in Administrators',
		 'std'    => FALSE,
		 'fields' => $error_options
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
		 'desc' => '<strong>Format:</strong> <code>UA-XXXXX-Y</code><br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("ga_acct_txt"); ?&gt;</code>'
	)
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'universal_analytics',
	array(
		 'name'  => 'Use  <a href="https://support.google.com/analytics/answer/2790010?hl=en&ref_topic=2790009" target="_blank" title="View documentation">Universal Analytics (beta)</a> tracking code instead of the standard asynchronous code?',
		 'style' => 'simple',
		 'std'   => FALSE
	),
	TRUE
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'multiple_domains',
	array(
		 'name'  => 'Allow tracking of <a href="https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSite" target="_blank" title="View documentation">multiple top-level domains</a>?',
		 'style' => 'simple',
		 'std'   => FALSE
	),
	TRUE
);
$adv_ga_options[] = $mapi_options->addCheckbox(
	'enhanced_link_attribution',
	array(
		 'name'  => 'Enable <a href="https://support.google.com/analytics/answer/2558867" target="_blank" title="View documentation">Enhanced Link Attribution</a> sitewide?',
		 'style' => 'simple',
		 'std'   => FALSE
	),
	TRUE
);
$mapi_options->addCondition(
	'enable_adv_ga_options',
	array(

		 'name'   => 'Automatically add Google Analytics tracking code',
		 'std'    => FALSE,
		 'fields' => $adv_ga_options,
		 'desc'   => '<strong>Note:</strong> <a href="https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSite#domainSubDomains" title="View documentation" target="_blank">Tracking multiple subdomains</a> is supported by default.<br /><strong>Template tag:</strong> <code>&lt;?php mapi_analytics(); ?&gt;</code>'
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
		 'std'  => 10
	),
	TRUE
);
$mapi_options->addCondition(
	'load_ieupdate',
	array(

		 'name'   => 'Show Internet Explorer update nag',
		 'desc'   => '(visitors with IE versions lower than number above will be politely alerted to update)',
		 'fields' => $condition_load_ie,
		 'std'    => TRUE
	)
);
$mapi_options->addCheckbox(
	'break_frames',
	array(
		 'name' => 'Break out of HTML frames',
		 'std'  => FALSE
	)
);
$mapi_options->addCheckbox(
	'enable_member_functions',
	array(
		 'name' => 'Enable members-only TinyMCE shortcodes',
		 'desc' => 'This adds three new buttons to the WYSIWYG editor that insert shortcodes to create "members-only" or "visitors-only" content.',
		 'std'  => FALSE
	)
);

$mapi_options->addCheckbox(
	'enable_inline_post_functions',
	array(
		 'name' => 'Enable TinyMCE shortcodes for inserting the contents of other posts',
		 'desc' => 'This adds two new shortcodes buttons to the WYSIWYG editor that allow you to insert the content of another post or WP_Query into any other post.',
		 'std'  => FALSE
	)
);

$mapi_options->addCheckbox(
	'external_links',
	array(
		 'name' => 'Automatically open external links in a new window/tab',
		 'desc' => 'Inserts a jQuery snippet that will open all external links in a new window or tab.',
		 'std'  => TRUE
	)
);
$mapi_options->addCheckbox(
	'auto_remove_large_images',
	array(
		 'name' => 'Automatically delete full size images on upload',
		 'std'  => FALSE,
		 'desc' => 'This replaces uploaded fullsize images according to the largest size specified by your <a href="options-media.php">Media settings</a>. In other words, high resolution uploads in the Media Library are replaced with WordPress\' "large" size images. Enabling this does not effect images that have already been uploaded.'
	)
);

$mapi_options->addCheckbox(
	'show_credit',
	array(
		 'name' => 'Show Mindshare Studios credit as an HTML comment',
		 'std'  => TRUE
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
		 'std'  => 'Powered by '.get_bloginfo('name'),
		 'desc' => 'Enter a custom title for the login screen. <strong>Default:</strong> Powered by WordPress',
		 'name' => 'WordPress Login Title'
	),
	TRUE
);

$custom_branding[] = $mapi_options->addText(
	'wp_login_url',
	array(
		 'std'  => home_url('/'),
		 'desc' => 'Enter a custom URL for the login screen. <strong>Default:</strong> http://wordpress.org',
		 'name' => 'WordPress Login Title'
	),
	TRUE
);

$custom_branding[] = $mapi_options->addImage(
	'wp_login_img',
	array(
		 'std'  => '',
		 'desc' => 'Upload a custom logo image for the login screen. <strong>Standard dimensions:</strong> 300px x 72px',
		 'name' => 'WordPress Login Image'
	),
	TRUE
);

$mapi_options->addCondition(
	'custom_branding',
	array(
		 'name'   => 'Enable custom branding',
		 'std'    => FALSE,
		 'fields' => $custom_branding,
		 'desc'   => 'Replaces the default WordPress branding on the login screen.'
	)
);

$mapi_options->addSubtitle('Misc. WordPress Settings');

$mapi_options->addText(
	'excerpt_more_txt',
	array(
		 'name' => 'Excerpt "more" text',
		 'desc' => 'Customize the text displayed at the end of <code>the_excerpt</code> and add a link to the full post. Leave blank to disable. WordPress default: <code>[...]</code>',
		 'std'  => '...'
	)
);

$mapi_options->addCheckbox(
	'enabled_htmlawed',
	array(
		 'name' => 'Cleanup HTML tags in the_content before output',
		 'std'  => FALSE,
		 'desc' => 'This enables <a href="http://goo.gl/OHgmij" title="View documentation" target="_blank">htmLawed</a> to purify HTML entered by users. By default this strips DIV tags, inline styles, and empty tags. You can override and change any settings by creating a PHP file in the current theme folder called <code>htmlawed-config.php</code>'
	)
);

$mapi_options->addCheckbox(
	'suppress_login_errors',
	array(
		 'name' => 'Hide Login Errors',
		 'std'  => FALSE,
		 'desc' => 'This suppresses error messages on the WordPress login screen.'
	)
);

$mapi_options->addCheckbox(
	'wp_admin_bar_disabled',
	array(
		 'name' => 'Disable WordPress Toolbar',
		 'std'  => FALSE,
		 'desc' => 'Turns off the WordPress Toolbar sitewide and removes the option from the user profile page.'
	)
);

$mapi_options->addCheckbox(
	'menu_sort_reverse',
	array(
		 'name' => 'Reverse sort order for <code>wp_nav_menu</code>',
		 'std'  => FALSE,
		 'desc' => 'Useful only when CSS floated menu items appear in reverse order.'
	)
);

$mapi_options->addCheckbox(
	'remove_recent_comments_style',
	array(
		 'name' => 'Remove inline recent comments CSS from header',
		 'desc' => 'This removes some (typically) unneeded inline CSS from your HEAD added by WordPress.',
		 'std'  => TRUE
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

$mapi_options->addSubtitle('Libraries');
$mapi_options->addCheckbox(
	'load_jquery',
	array(
		 'name' => 'Load jQuery <code><a title="View source in new tab" href="view-source:'.includes_url('js/jquery/jquery.js').'" target="_blank">jquery.js</a></code>',
		 'std'  => TRUE,
		 'desc' => 'Enqueues the jQuery library bundled with WordPress. View <a href="http://api.jquery.com/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_bootstrap',
	array(
		 'name' => 'Load Bootstrap JS <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/bootstrap/js/bootstrap.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">bootstrap.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Twitter Bootstrap library (JS only). View <a href="http://twbs.github.io/bootstrap/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_bootstrap_css',
	array(
		 'name' => 'Load Bootstrap CSS <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/bootstrap/css/bootstrap.min.css', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">bootstrap.min.css</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Twitter Bootstrap library (CSS only). View <a href="http://twbs.github.io/bootstrap/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_modernizr_js',
	array(
		 'name' => 'Load Modernizr <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/modernizr/modernizr-latest.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">modernizr-latest.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="http://modernizr.com/docs/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_backbone_js',
	array(
		 'name' => 'Load Backbone <code><a title="View source in new tab" href="view-source:'.includes_url('js/backbone.min.js').'" target="_blank">backbone.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Backbone library bundled with WordPress. View <a href="http://backbonejs.org/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_underscore_js',
	array(
		 'name' => 'Load Underscore <code><a title="View source in new tab" href="view-source:'.includes_url('js/underscore.min.js').'" target="_blank">underscore.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Underscore library bundled with WordPress. View <a href="http://underscorejs.org/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_mapbox_js',
	array(
		'name' => 'Load Mapbox <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/mapbox/mapbox.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">mapbox.min.js</a></code> and <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/mapbox/mapbox.min.css', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">mapbox.min.css</a></code>',
		'std'  => FALSE,
		'desc' => 'Enqueues the Mapbox mapping library. View <a href="https://www.mapbox.com/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_retina_js',
	array(
		'name' => 'Load Retina <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/retina/js/retina-1.1.0.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">retina.js</a></code>',
		'std'  => FALSE,
		'desc' => 'Enqueues the Retina library. View <a href="http://retinajs.com/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addSubtitle('jQuery Plugins');

$mapi_options->addCheckbox(
	'load_bbq',
	array(
		 'name' => 'Load jQuery BBQ plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/jquery-bbq/jquery.ba-bbq.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.ba-bbq.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/cowboy/jquery-bbq/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_easylistsplitter_js',
	array(
		 'name' => 'Load jQuery easyListSplitter plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/easylistsplitter/jquery.easyListSplitter.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.easyListSplitter.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="http://www.madeincima.it/en/articles/resources-and-tools/easy-list-splitter-plugin/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_fittext_js',
	array(
		 'name' => 'Load jQuery FitText plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/fittext/jquery.fittext.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.fittext.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/davatron5000/FitText.js" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_fitvids_js',
	array(
		 'name' => 'Load jQuery FitVids plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/fitvids/jquery.fitvids.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.fitvids.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/davatron5000/FitVids.js" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_flexslider',
	array(
		 'name' => 'Load jQuery FlexSlider plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/flexslider/jquery.flexslider-min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.flexslider-min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/woothemes/FlexSlider" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_isotope_js',
	array(
		 'name' => 'Load jQuery Isotope plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/isotope/jquery.isotope.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.isotope.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="http://isotope.metafizzy.co/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_lettering_js',
	array(
		 'name' => 'Load jQuery Lettering plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/lettering/jquery.lettering.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.lettering.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/davatron5000/Lettering.js" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_masonry_js',
	array(
		 'name' => 'Load jQuery Masonry plugin <code><a title="View source in new tab" href="view-source:'.includes_url('js/jquery/jquery.masonry.min.js').'" target="_blank">jquery.masonry.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Masonry jQuery plugin bundled with WordPress. View <a href="http://masonry.desandro.com/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_pickadate_js',
	array(
		 'name' => 'Load jQuery pickadate plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/pickadate/picker.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">picker.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/amsul/pickadate.js" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_replacetext_js',
	array(
		 'name' => 'Load jQuery ReplaceText plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('js/jquery.replacetext.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.replacetext.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/cowboy/jquery-replacetext" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_search_highlighter_js',
	array(
		 'name' => 'Load jQuery Search Highligther plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('js/search-highlighter.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">search-highlighter.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Automatically highlights search terms on WordPress search results pages.'
	)
);

$mapi_options->addCheckbox(
	'load_tinysort_js',
	array(
		 'name' => 'Load jQuery TinySort plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/tinysort/jquery.tinysort.min.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.tinysort.min.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/Sjeiti/TinySort" target="_blank">documentation &rsaquo;</a>'
	)
);
$mapi_options->addCheckbox(
	'load_tiptip_js',
	array(
		 'name' => 'Load jQuery TipTip plugin <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/tiptip/jquery.tipTip.minified.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">jquery.tipTip.minified.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'View <a href="https://github.com/drewwilson/TipTip" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addSubtitle('Utilities');

$mapi_options->addCheckbox(
	'load_font_awesome',
	array(
		 'name' => 'Load Font Awesome <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/font-awesome/css/font-awesome.min.css', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">font-awesome.min.css</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the CSS and font files for Font Awesome. View <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_superfish_js',
	array(
		 'name' => 'Load Superfish <code><a title="View source in new tab" href="view-source:'.plugins_url('lib/superfish/superfish.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">superfish.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the Superfish drop down menu JavaScript. View <a href="https://github.com/joeldbirch/superfish/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'load_swfobject_js',
	array(
		 'name' => 'Load SWFObject <code><a title="View source in new tab" href="view-source:'.includes_url('js/swfobject.js').'" target="_blank">swfobject.js</a></code>',
		 'std'  => FALSE,
		 'desc' => 'Enqueues the SWFObject library bundled with WordPress. View <a href="https://code.google.com/p/swfobject/" target="_blank">documentation &rsaquo;</a>'
	)
);

$mapi_options->addCheckbox(
	'fix_console',
	array(
		 'name' => 'Load <code><a title="View source in new tab" href="view-source:'.plugins_url('js/mapi-fix-console.js', MAPI_DIR_PATH.'/'.MAPI_PLUGIN_SLUG.'.php').'" target="_blank">mapi-fix-console.js</a></code>',
		 'std'  => TRUE,
		 'desc' => 'Adds JavaScript to prevent any errors from calls to <code>console.log</code> in production environments (recommended).'
	)
);

$mapi_options->CloseTab();

/*
 * speed tab start
 */
$mapi_options->OpenTab(sanitize_title($speed_options_label));
$mapi_options->Title($speed_options_label);

$mapi_options->addCheckbox(
	'minify_js',
	array(
		 'name' => 'Minify JavaScript',
		 'desc' => 'This option automatically combines and compresses all registered JS files from your theme and all other WordPress plugins.',
		 'std'  => FALSE
	));
$mapi_options->addCheckbox(
	'minify_css',
	array(
		 'name' => 'Minify CSS',
		 'desc' => 'This option automatically combines and compresses all properly registered CSS files.',
		 'std'  => FALSE
	));
$mapi_options->addCheckbox(
	'html_compression',
	array(
		 'name' => 'Minify HTML',
		 'std'  => FALSE,
		 'desc' => 'This option reduces page size by stripping whitespace and HTML comments, excluding IE conditional comments. Wrap content you don\'t want compressed in your theme files with: <code>&lt;!--compression-none--&gt;</code>'
	)
);
$mapi_options->addText(
	'cache_interval',
	array(
		 'name' => 'Minify cache expiration (in seconds)',
		 'std'  => 432000,
		 'desc' => 'The default is 432000 (120 hours).'
	)
);
$mapi_options->addParagraph(
	'<span class="at-label"><label for="cache_interval">Clear minify cache</label></span>'.wp_nonce_field('clear-minify-cache', '_wpnonce', TRUE, FALSE).'<input class="button-secondary" type="submit" name="mapi_options_clear_cache_submit" value="Clear Cache Now" />'
);
$speed_adv_options[] = $mapi_options->addParagraph('<strong>Caution:</strong> disabling this clears all Advanced Performance Tuning options below, so you may want to export your settings first.', TRUE);
$speed_adv_options[] = $mapi_options->addSubtitle('Advanced JavaScript Options', TRUE);

$speed_adv_options[] = $mapi_options->addTextarea(
	'dequeue_scripts_txt',
	array(
		 'name' => 'Dequeue JS',
		 'desc' => 'Enter a list of JS handles to send to <code>wp_dequeue_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.'
	), TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'deregister_scripts_txt',
	array(
		 'name' => 'Deregister JS',
		 'desc' => 'Enter a list of JS handles to send to <code>wp_deregister_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.'
	), TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'enqueue_scripts_txt',
	array(
		 'name' => 'Enqueue JS',
		 'desc' => 'Enter a list of JS handles to send to <code>wp_enqueue_script</code> (one per line). Note that this setting is not related to JS minification and will take effect whether minification is used or not.'
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
		 'desc' => 'Enter a list of CSS handles to send to <code>wp_dequeue_style</code> (one per line). Note that this setting is not related to CSS minification and will take effect whether minification is used or not.<br /><strong>Examples:</strong> gforms_css,shadowbox-css,shadowbox-extras,shopp.catalog,shopp,shopp.colorbox'
	),
	TRUE);
$speed_adv_options[] = $mapi_options->addTextarea(
	'deregister_styles_txt',
	array(
		 'name' => 'Deregister CSS',
		 'desc' => 'Enter a list of CSS handles to send to <code>wp_deregister_style</code> (one per line). Note that this setting is not related to CSS minification and will take effect whether minification is used or not.'
	),
	TRUE);

$speed_adv_options[] = $mapi_options->addSubtitle('Advanced Minify Options', TRUE);
$speed_adv_options[] = $mapi_options->addCheckbox(
	'debug_nominify',
	array(
		 'name'  => 'Combine JS only - no minification (safe mode)',
		 'std'   => FALSE,
		 'style' => 'simple',
		 'desc'  => 'If checked, files are not compressed. Useful for debugging JS issues, not recommended for production.'
	),
	TRUE
);
$speed_adv_options[] = $mapi_options->addTextarea(
	'js_exclude',
	array(
		 'name' => 'Exclude JS from minification (by URI pattern)',
		 'desc' => 'JavaScript URI patterns to exclude from minify (one per line). Example: \'jquery\' matches all JS files with \'jquery\' in the filename.'
	), TRUE);

$speed_adv_options[] = $mapi_options->addTextarea(
	'css_exclude',
	array(
		 'name' => 'Exclude CSS from minification (by URI pattern)',
		 'desc' => 'CSS URI patterns to exclude from minify (one per line). Example: \'style\' matches all JS files with \'style\' in the filename.'
	),
	TRUE);
/*$speed_adv_options[] = $mapi_options->addTextarea(
	'uri_exclude',
	array(
		 'name' => 'Exclude URI patterns from minification',
		 'desc' => 'URI patterns to exclude from minify parsing (one per line).'
	),
	TRUE);*/
//$speed_adv_options[] = $mapi_options->addTextarea('js_include', array('name' => 'Minify External JS','desc' => 'Minify and cache JavaScript files from an external domain. The external files must already be present within a script tag in your HTML (one per line).'), TRUE);

//$speed_adv_options[] = $mapi_options->addTextarea('css_include', array('name' => 'Minify External CSS','desc' => 'Minify and cache CSS files from an external domain. The external files must already be present within a CSS link tag in your HTML (one per line).'), TRUE);
$speed_adv_options[] = $mapi_options->addText(
	'extra_minify_options',
	array(
		 'name' => 'Minify Engine Tweaking/Tuning',
		 'std'  => '',
		 'desc' => 'Extra arguments to pass to the minify engine. This value will get appended to the minify URL "<em>/min/?f=file1.js,file2.js</em>"'
	),
	TRUE
);
$mapi_options->addCondition(
	'enable_adv_speed_options',
	array(

		 'name'   => 'Enable Advanced '.$speed_options_label.' options',
		 'std'    => FALSE,
		 'fields' => $speed_adv_options
	)
);

$mapi_options->addSubtitle('Troubleshooting Minify Errors');
$mapi_options->addParagraph('Combining and compressing all JS and CSS files can be a huge performance boost! <strong>IMPORTANT: Test your site after you turn this on - not all JavaScript and CSS files can be automatically minified</strong> (if they contain errors or seriously hackish code).');
$mapi_options->addParagraph('If you encounter problems after enabling one of the options above try narrowing down which JS or CSS file(s) are causing trouble using the <strong>Advanced Minify Options</strong> above. Also keep in mind that if you have a lot of JS and CSS files to compress, the minify processor may run out of memory on depending on your PHP configuration. Running out of memory may result in a minify builder login prompt being displayed when viewing the site. To fix this you can either increase the memory available to PHP or exclude one or more files from minification.');
$mapi_options->addParagraph('While logged in to WordPress you can temporarily disable minification of JS and CSS files by appending this $_GET variable to any URL: <code>?minify-off=1</code>');
$mapi_options->addParagraph('If you have errors after enabling HTML compression you can partially disable HTML compression by wrapping content you don\'t want compressed in your theme files within two HTML comments like so:<br /> <code>&lt;!--compression-none--&gt;<br />this won\'t get compressed<br />&lt;!--compression-none--&gt;</code>.');

$mapi_options->CloseTab();

/*
 * tab start
 */
$mapi_options->OpenTab(sanitize_title($sysinfo_options_label));
$mapi_options->Title($sysinfo_options_label);
$mapi_options->addParagraph('<a class="button-primary" href="#" onclick="window.open(\''.MAPI_DIR_URL.'views/mapi-phpinfo.php\',\'PHPInfo\',\'width=800,height=600,scrollbars=1\');return FALSE;">PHP Info</a>');
$mapi_options->addTextarea(
	'sysinfo',
	array(
		 'name' => $sysinfo_options_label,
		 'desc' => 'This information can be useful when you are debugging problems with you WordPress installation.',
		 'std'  => mapi_system_info()
	)
);
$mapi_options->CloseTab();

/*
 * tab start
 */
$mapi_options->OpenTab(sanitize_title($credits_options_label));
$mapi_options->Title($credits_options_label);
$mapi_options->addTextarea(
	'credits',
	array(
		 'name' => $credits_options_label,
		 'desc' => 'The '.MAPI_PLUGIN_NAME.' Team thanks the developers and free software projects listed above.',
		 'std'  => mapi_credits()
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
		 'content' => '<p>API documentation is available online at <a href="http://mindsharelabs.com/topics/mindshare-theme-api/" target="_blank">http://mindsharelabs.com/topics/mindshare-theme-api/</a></p>'
	)
);
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-support-tab',
		 'title'   => 'API Support',
		 'content' => '<p>Get support on the Mindshare Labs forums: <a href="http://mindsharelabs.com/forums/" target="_blank">http://mindsharelabs.com/forums/</a></p><p>To get premium one-on-one support, contact us: <a href="http://mind.sh/are/contact/">http://mind.sh/are/contact/</a></p>'
	)
);
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-themes-tab',
		 'title'   => 'Get More Themes',
		 'content' => '<p>Download compatible free and premium themes from the Mindshare Labs: <a href="http://mindsharelabs.com/" target="_blank">http://mindsharelabs.com/</a></p>'
	)
);
$secure_tab_content = "<p>Get the Mindshare Team to secure and protect your WordPress site for $9.95/month: <a href='http://mind.sh/are/wordpress-security-and-backup-service/check/?url=".get_bloginfo("url")."&amp;active=0&amp;sale=1&amp;d=".str_replace(
		array(
			 "http://",
			 "https://"
		),
		"",
		get_home_url())."' target='_blank'>http://mind.sh/are/wordpress-security-and-backup-service/</a></p>";
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-security-tab',
		 'title'   => 'Protect Your Site',
		 'content' => $secure_tab_content
	)
);
