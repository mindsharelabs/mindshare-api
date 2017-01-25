Mindshare Theme API
=============

- Author: Mindshare Labs, Inc.
- License: GPL v3
- Copyright: 2006-2016
- Link: https://mindsharelabs.com/downloads/mindshare-theme-api/

Provides a library of additional template tags, 3rd-party libraries, and functions for WordPress themes and additional features for WordPress CMS websites.

# Changelog:

## 1.1.2
- Updated `Mindshare_API_Plugin_Updater` class to current version of EDD Plugin Updater

## 1.1.1
- Remove `mapi_change_email_defaults()` function because of conflict with Gravity Forms
- Bugfix for IE update setting

## 1.1.0
- Add `mapi_facebook_posts()` function
- Add `mapi_post_exists()` function
- Add fn `mapi_get_active_template()`
- Add fn `mapi_query_related()`
- Add function for responsive video embeds, `mapi_embed_html()`
- Add PHP.ini file to sysinfo
- Added Google, Gravity Forms  and Tribe plugins to the default exclusion list for minification",
- Change IE update nag to version 11
- Deprecate `mapi_facebook_rss()` function
- Deprecated pickadate.js and many older 3rd party libraries
- Disable WordPress 4.2+ inline support for Emojis (removed inline CSS/JS code from head, toggleable)
- Fix 'http' google font link on maintenance mode screen
- Migrated TGM Plugin activation and Twitter PHP API SDK to Composer
- Remove deprecated `get_currentuserinfo()` calls
- Remove deprecated params from TGMPA
- Rewrite `mapi_excerpt()` with improved CPT/ACF support
- Rewrite `mapi_money_format()` with trim zeros
- Update Bootstrap to 3.3.7
- Update copyright date and name
- Updated `mapi_facebook_lookup()` to use an Open Graph access token

## 1.0.1
- Premissions fix for mThumb

## 1.0
- Add extra mThumb params to `mapi_featured_img()`
- Add class filter to `mapi_featured_img()`
- Updated TGM-Plugin-Activation to 2.5.2
- Updated HTMLawed to beta9
- Updated all JSDelivr scripts
- Remove Yoast Dashboard widget
- Remove customizer from Admin bar

## 0.9
- Bug fix for moving nav menus to top

## 0.8.9
- Add Instagram to `mapi_social_links()`

## 0.8.8
- Minor fix for mapi_html_cleanup()
- Minor fix for mapi_social email links
- Add Instagram to supported social networks

## 0.8.7
- Added fn `mapi_is_reserved_ipv4()`
- Updated `mapi_rich_snippets()` to use current microdata formats
- Added `mapi_rich_snippets_schema` filter
- Added `mapi_rich_snippets_class` filter
- Made error reporting on `mapi_get_option` sensitive to WP_DEBUG setting
- Bugfix for `mapi_stop_compression()` and `mapi_start_compression()`
- Added `mapi_social_link_class` filter
- Added `mapi_compress_js` filter
- Added `mapi_compress_info` filter
- Added new filters to change the default WordPress email and from name for system generated messages

## 0.8.6
- Bugfix for automatic updates
- Speed improvements

## 0.8.5
- PHP notice fix in wp_login_img()
- Refactored most calls to the PHP function extract() to improve debugging and readability
- Added filters for all mapi_featured_img() defaults
- Improved mapi_data_uri() fn
- Fixes for non-standard WP installs, mod_userdir URIs, and mThumb

## 0.8.4
- PHP notice fix for mapi_browser_from_ua()
- Added optional filter to add custom post type to "Right Now" box
- Added fn mapi_has_role()
- Added fn mapi_current_user_has_role()

## 0.8.3
- Bugfix for mapi_edit_link()
- Tested custom search options

## 0.8.2
- Updated htmLawed
- Updated gitignore
- Updated Minify
- Updated RegDom library
- Updated TGM-Plugin-Activation
- Updated bfi_thumb
- Added option for changing admin color scheme
- Added jokes
- Bugfix for mapi_slug_to_id() for custom post types
- Bugfix for mapi_featured_image()
- Added fn mapi_check_server()
- Added API version to sysinfo page
- Fix for mapi_edit_link
- Added mapi_minify_exclude filter
- Added mapi_social_share_onclick filter
- Added mapi_social_links_insert_before action to allow plugging in new networks
- Added mapi_social_links_insert_after action to allow plugging in new networks
- Fixed is_external in minify class
- Fixed phpdocs for mapi_image and several other fns

## 0.8.1
- mThumb version number update to calm down some automated scanners that think this is an old version of TimThumb

## 0.8
Preparation for version 1.0 launch:
- Remove credits tab
- Minify JS files
- Fix favicon scaling
- Added new Twitter API Tweets function, mapi_tweets_oauth
- Added mapi_excerpt_more_text filter
- Update language on universal analytics
- Add CSS class for OS to body tag
- Added CDN version of all libs
- Update mThumb
- Added BFI_Thumb functions
- Added option to allow ediors acces to menus
- Added PHP modules to sys info
- Added mapi_get_nav_menu_item_children()

## 0.7.8
- Fix PHP notice on Blankout

## 0.7.7
- Security update

## 0.7.6
- Fixed issue with favicon not being set, fix for DB_HOST having port number, PHP 5.3 fix

## 0.7.5.1
- Bugfixes for the options framework

## 0.7.5
- Added fns mapi_console_log and mapi_die, fixed PHP notices, misc bugfixes, updated all external libraries, added options to set favicon and mapi_get_favicon_url() function

## 0.7.4
Fixed mThumb PHP Notices, added Maintenance Mode bypass for wp-config.php, disabled minify builder, updated domains list for mapi_extract_domain, fix for 3.9 in options framework

## 0.7.3.1

Bugfix for PHP open tags, add fn mapi_get_file_extension, added mapi_get_host_by_ip and mapi_get_ip_by_host

## 0.7.2

Added filters for mapi_social_links functions, fixed link when clearing minify cache, added mapi_featured_img_with_caption fn, added mapi_tinymce_line_breaks fn, added mapi_nice_search_redirect fn, updated Isotope to v2.

## 0.7.1

Bugfixes for auto-deleting images, misc function additions, numerous bugfixes

## 0.7

Updated external libraries, add WP 3.8 auto-update, removed unloading of jQuery, migrated to GitHub, removed LESS, fixed mySQLi function call, added social links functions

## 0.6.9

 - Updated externals, fixed universal analytics, update break frames function to allow same domain frames, pull request for TGM plugin, added a ton of new mapi_ functions, removed Adaptive Images, updated TLD functions with new domain extensions, added Leaflet.js and Retina.js

## 0.6.8.6

 - Fix EDD, fix minify activate issue

## 0.6.8.5

 - Temp disable EDD

## 0.6.8.4

 - Bugfix

## 0.6.8.3

 - Bugfix (prevent minify message displaying on frontend)

## 0.6.8.2

 - Bugfixes

## 0.6.8.1

 - Minor tweaks, backward compat fixes

## 0.6.8

 - Add filters/actions, fixes for i8n, removed mapi.js, added mapi_var_dump, bugfixes, removed MSAD / added EDD, moved Analytics settings, added mapi_get_taxonomy_by_term, updates for WP 3.8

## 0.6.7.3

 - TimThumb fixes continued

## 0.6.7.2

 - Temporarily disabled mapi_mthumb_config

## 0.6.7.1

 - PHP notice fix, bugfix in mapi_mthumb_config

## 0.6.7

 -  bugfixes, externals updates, upgraded to Bootstrap 3, added Font Awesome, replaced wp_print_scripts with wp_enqueue_scripts, added maintenance mode bypass, updated mapi_single_term_title, added mapi_is_true, added mapi_update_option, added FB Open Graph functions, added htmLawed options

## 0.6.6.3

 -  bugfixes, updates externals, added functions mapi_single_term_title, mapi_delete_option, added 503.php option, started multisite compatibility updates

## 0.6.6.2

 -  bugfix in credits page display, update externals

## 0.6.6.1

 -  bugfix in set_error_display_options()

## 0.6.6

 -  updated pickadate.js, credits page, a bunch of additional custom fields, WP login screen branding

## 0.6.5

 -  added insert post shortcode, misc. bugfixes, added bootstrap and flexslider

## 0.6.4

 - Updated MSAD

## 0.6.3

 - Bugfix for Google Analytics, fixed menus sorting, fix for member shortcodes, re-add option to enqueue scripts, misc fixes for minification, added new category functions, split admin screens in to 2 sections, add offline message WYSIWYG field for maintenance mode + css

## 0.6.2

 - Fixed undefined indexes errors, added enhanced link attribution to GA, fixed issue with config clearing repeatedly

## 0.6.1

 - Fixed issue with text fields stripslashes, added auto update minify config on activation, added system information tab

## 0.6

 - Fixed PHP notices on options init, added Modernizr, SWFObject, Backbone, Underscore, Adaptive Images and much more

## 0.5.2

 - Updated MSAD lib to 0.4.2

 - bugfixes for update mechanism

## 0.5.1

 - Updated MSAD lib

## 0.5

 - scrapped ACF, many bugfixes

## 0.4.5

 - bugfixes

## 0.4.3.3

 - Updates to mapi_thumb_array

## 0.4.3.2

 - Updates to mapi_thumb

## 0.4.3.1

 - bugfixes, got rid of MAPI_DEBUG

## 0.4.3

 - bugfixes

## 0.4.2.1

 - minor change to CSS minify

## 0.4.2

 - Added GA function (mapi_analytics)

## 0.4.1

 - Fixed minify system, bugfixes, added maintenance mode

## 0.4

 - many minor changes, added js/css minify and caching system

## 0.3.2.1

 - Fixed ie update message bug

## 0.3.2

 - Removed auto update mechanism because it was slow

## 0.3.1

 - Fixed css issue in mapi_facebook_like

## 0.3

 - Revamped options framework, major rewrite

## 0.2.2

 - Added function mapi_get_term_children_by_slug

## 0.2.1

 - bugfix

## 0.2

 - converted to OOP

## 0.1.5

 - Added some new fields to options page, integrated mcms-compress plugin, added LESS.js

## 0.1.4.8

 - MINOR bugfix

## 0.1.4.7

 - Bugfix in security audit

## 0.1.4.5

 - Updates for WP 3.4

## 0.1.4.4

 - changed req role to 'edit_theme_options', added updated notice

## 0.1.4.3

 - bugfix in google + fn

## 0.1.4.2

 - headers_sent bugfix in mapi-options-init.php

## 0.1.4

 - bugfix in iPad detection

## 0.1.3

 - bugfix in slideshow functions

## 0.1.2

 - bugfix

## 0.1.1

 - bugfix

## 0.1

 - Ported from Blankout Theme
