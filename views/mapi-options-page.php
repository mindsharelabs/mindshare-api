<?php

$mapi_options = new mindshare_options_framework(
	array(
		 'project_name' => MAPI_PLUGIN_NAME,
		 'project_slug' => MAPI_PLUGIN_SLUG,
		 'menu'         => 'theme',
		 'page_title'   => wp_get_theme().' Theme Settings',
		 'menu_title'   => 'Theme Settings',
		 'capability'   => 'edit_theme_options',
		 'option_group' => MAPI_OPTIONS,
		 'id'           => MAPI_PLUGIN_SLUG.'-settings',
		 'fields'       => array(),
	)
);
$mapi_options->OpenTabs_container('');

$contact_options_label = 'Contact Info';
$social_options_label = 'Social Integration';
$location_options_label = 'Location Settings';


$mapi_options->TabsListing(
	array(
		 'links' =>
		 array(
			 sanitize_title($contact_options_label)  => __($contact_options_label),
			 sanitize_title($social_options_label)   => __($social_options_label),
			 sanitize_title($location_options_label) => __($location_options_label),

		 )
	)
);

/*
 * contact tab start
 */
global $current_user;
wp_get_current_user();

$mapi_options->OpenTab(sanitize_title($contact_options_label));
$mapi_options->Title($contact_options_label);
$mapi_options->addParagraph(
	'The following contact settings will be used by compatible themes. You can also implement them in your own custom themes using the template tags listed below each item. If you don\'t want to echo the value you can use the function <code>mapi_get_option()</code> in place of <code>mapi_option()</code>'
);
$mapi_options->addText(
	'sitename_txt',
	array(
		 'name' => 'Site Title',
		 'std'  => get_bloginfo('name'),
		 'desc' => '<strong>Alternative to:</strong> <code>&lt;?php bloginfo(\'name\'); ?&gt;</code>)<br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("sitename_txt"); ?&gt;</code>'
	)
);


$mapi_options->addParagraph('&nbsp;');
$mapi_options->addSubtitle('Primary Contact Info (e.g. physical address)');

$mapi_options->addText(
	'business_txt',
	array(
		 'name' => 'Primary Organization / Business Name',
		 'std'  => get_bloginfo('name'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("business_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'name_txt',
	array(
		 'name' => 'Primary Contact Name',
		 'std'  => $current_user->display_name,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("name_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'email',
	array(
		 'name' => 'Primary Contact Email',
		 'std'  => get_option('admin_email'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("email"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'phone_txt',
	array(
		 'name' => 'Phone',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("phone_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'fax_txt',
	array(
		 'name' => 'Fax',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("fax_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr1_txt',
	array(
		 'name' => 'Address (line 1)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr1_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr2_txt',
	array(
		 'name' => 'Address (line 2)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'city_txt',
	array(
		 'name' => 'City',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("city_txt"); ?&gt;</code>'
	)
);
$mapi_options->addUSStates(
	'state',
	array(
		 'name' => 'State (US)',
		 'std'  => array(''),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("state"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'region_txt',
	array(
		 'name' => 'Region / Province / Non US State',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("region_txt"); ?&gt;</code>'
	)
);
$mapi_options->addCountry(
	'country',
	array(
		 'name' => 'Country',
		 'std'  => array('US'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("country"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'zip_txt',
	array(
		 'name' => 'Zip / Postal code',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("zip_txt"); ?&gt;</code>'
	)
);

$mapi_options->addParagraph('&nbsp;');
$mapi_options->addSubtitle('Secondary Contact Info (e.g. postal address)');
$mapi_options->addParagraph('The Secondary Contact Info section is useful for organizations with separate postal and physical addresses, or business with multiple locations.');

$mapi_options->addText(
	'business2_txt',
	array(
		 'name' => 'Secondary Organization / Business Name',
		 'std'  => get_bloginfo('name'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("business2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'name2_txt',
	array(
		 'name' => 'Secondary Contact Name',
		 'std'  => $current_user->display_name,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("name2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'secondary_email',
	array(
		 'name' => 'Secondary Contact Email',
		 'std'  => get_option('admin_email'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("secondary_email"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'phone2_txt',
	array(
		 'name' => 'Phone',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("phone2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'fax2_txt',
	array(
		 'name' => 'Fax',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("fax2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr21_txt',
	array(
		 'name' => 'Address (line 1)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr21_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr22_txt',
	array(
		 'name' => 'Address (line 2)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr22_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'city2_txt',
	array(
		 'name' => 'City',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("city2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addUSStates(
	'secondary_state',
	array(
		 'name' => 'State (US)',
		 'std'  => array(''),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("secondary_state"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'region2_txt',
	array(
		 'name' => 'Region / Province / Non US State',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("region2_txt"); ?&gt;</code>'
	)
);
$mapi_options->addCountry(
	'secondary_country',
	array(
		 'name' => 'Country',
		 'std'  => array('US'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("secondary_country"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'zip2_txt',
	array(
		 'name' => 'Zip / Postal code',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("zip2_txt"); ?&gt;</code>'
	)
);

$mapi_options->addParagraph('&nbsp;');
$mapi_options->addSubtitle('Tertiary Contact Info');
$mapi_options->addParagraph('The Tertiary Contact Info section is primarily useful for larger organizations with multiple locations.');

$mapi_options->addText(
	'business3_txt',
	array(
		 'name' => 'Tertiary Organization / Business Name',
		 'std'  => get_bloginfo('name'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("business3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'name3_txt',
	array(
		 'name' => 'Tertiary Contact Name',
		 'std'  => $current_user->display_name,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("name3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'tertiary_email',
	array(
		 'name' => 'Tertiary Contact Email',
		 'std'  => get_option('admin_email'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("tertiary_email"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'phone3_txt',
	array(
		 'name' => 'Phone',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("phone3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'fax3_txt',
	array(
		 'name' => 'Fax',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("fax3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr31_txt',
	array(
		 'name' => 'Address (line 1)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr31_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'addr32_txt',
	array(
		 'name' => 'Address (line 2)',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("addr32_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'city3_txt',
	array(
		 'name' => 'City',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("city3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addUSStates(
	'tertiary_state',
	array(
		 'name' => 'State (US)',
		 'std'  => array(''),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("tertiary_state"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'region3_txt',
	array(
		 'name' => 'Region / Province / Non US State',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("region3_txt"); ?&gt;</code>'
	)
);
$mapi_options->addCountry(
	'tertiary_country',
	array(
		 'name' => 'Country',
		 'std'  => array('US'),
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("tertiary_country"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'zip3_txt',
	array(
		 'name' => 'Zip / Postal code',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("zip3_txt"); ?&gt;</code>'
	)
);

$mapi_options->CloseTab();


/*
 * social tab start
 */
$mapi_options->OpenTab(sanitize_title($social_options_label));
$mapi_options->Title($social_options_label);
$mapi_options->addParagraph(
	'The following social media settings will be used by compatible themes. You can also implement them in your own custom themes using the template tags listed below each item. If you don\'t want to echo the value you can use the function <code>mapi_get_option()</code> in place of <code>mapi_option()</code>'
);

// tumblr,
$mapi_options->addSubtitle('Social Networks');

$mapi_options->addText(
	'facebook_uri',
	array(
		 'name' => 'Facebook URL',
		 'std'  => NULL,
		 'desc' => '<strong>Example:</strong> <em>http://www.facebook.com/pages/xxxx</em><br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("facebook_uri"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'facebook_rss_uri',
	array(
		 'name' => 'Facebook RSS URL',
		 'std'  => NULL,
		 'desc' => '<strong>Example:</strong> <em>https://www.facebook.com/feeds/page.php?id=xxxx&format=rss20</em><br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("facebook_rss_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'google_plus_uri',
	array(
		 'name' => 'Google+ URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("google_plus_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'linkedin_uri',
	array(
		 'name' => 'LinkedIn URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("linkedin_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'twitter_uri',
	array(
		 'name' => 'Twitter URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("twitter_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'tumblr_uri',
	array(
		'name' => 'Tumblr URL',
		'std'  => NULL,
		'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("tumblr_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'twitter_username_slug',
	array(
		 'name' => 'Twitter Username',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("twitter_username_slug"); ?&gt;</code>'
	)
);

$mapi_options->addSubtitle('Photo Sharing Sites');

$mapi_options->addText(
	'pinterest_uri',
	array(
		 'name' => 'Pinterest URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("pinterest_uri"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'pinterest_username_slug',
	array(
		 'name' => 'Pinterest Username',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("pinterest_username_slug"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'instagram_id_slug',
	array(
		 'name' => 'Instagram User ID',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("instagram_id_slug"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'photostream_uri',
	array(
		 'name' => 'Other Photo Sharing Profile URL',
		 'std'  => NULL,
		 'desc' => '(e.g. Flickr)<br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("photostream_uri"); ?&gt;</code>'
	)
);

$mapi_options->addSubtitle('Video Sharing Sites');

$mapi_options->addText(
	'youtube_uri',
	array(
		 'name' => 'YouTube URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("youtube_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'vimeo_uri',
	array(
		 'name' => 'Vimeo URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("vimeo_uri"); ?&gt;</code>'
	)
);

$mapi_options->addText(
	'videostream_uri',
	array(
		 'name' => 'Other Video Sharing Profile URL',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("videostream_uri"); ?&gt;</code>'
	)
);


$mapi_options->CloseTab();

/*
 * location tab start
 */
$mapi_options->OpenTab(sanitize_title($location_options_label));
$mapi_options->Title($location_options_label);
$mapi_options->addParagraph(
	'The following location settings will be used by compatible themes. You can also implement them in your own custom themes using the template tags listed below each item. If you don\'t want to echo the value you can use the function <code>mapi_get_option()</code> in place of <code>mapi_option()</code>'
);
$mapi_options->addText(
	'gmaps_uri',
	array(
		 'name' => 'Google Maps URL',
		 'std'  => NULL,
		 'desc' => '(typically a link to Google Maps for directions, e.g. <em>http://maps.google.com/maps?xxxx</em>)<br /><strong>Template tag:</strong> <code>&lt;?php mapi_option("gmaps_uri"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'lat_txt',
	array(
		 'name' => 'Latitude',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("lat_txt"); ?&gt;</code>'
	)
);
$mapi_options->addText(
	'long_txt',
	array(
		 'name' => 'Longitude',
		 'std'  => NULL,
		 'desc' => '<strong>Template tag:</strong> <code>&lt;?php mapi_option("long_txt"); ?&gt;</code>'
	)
);
//$mapi_options->addText('gmaps_api_key_txt', array('name' => 'Google Maps API Key', 'std' => NULL, 'desc' => '(deprecated, no longer used by Google left in for legacy support)'));
$mapi_options->CloseTab();


/*
 * Help Tabs
 */
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-help-tab',
		 'title'   => 'API Documentation',
		 'content' => '<p>API documentation is available online at <a href="https://mindsharelabs.com/topics/mindshare-theme-api/" target="_blank">https://mindsharelabs.com/topics/mindshare-theme-api/</a></p>'
	)
);
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-support-tab',
		 'title'   => 'API Support',
		 'content' => '<p>Get support on the Mindshare Labs forums: <a href="https://mindsharelabs.com/forums/" target="_blank">https://mindsharelabs.com/forums/</a></p><p>To get premium one-on-one support, contact us: <a href="http://mind.sh/are/contact/">http://mind.sh/are/contact/</a></p>'
	)
);
$mapi_options->HelpTab(
	array(
		 'id'      => 'mapi-themes-tab',
		 'title'   => 'Get More Themes',
		 'content' => '<p>Download compatible free and premium themes from the Mindshare Labs: <a href="https://mindsharelabs.com/" target="_blank">https://mindsharelabs.com/</a></p>'
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
