<?php
/**
 * SEO essentials — no settings sprawl, no upsells.
 *
 *   - <meta name="description"> on every page
 *   - Open Graph + Twitter card tags (title, description, url, image),
 *     with a site-wide default social image
 *   - a "Hide from search engines" switch per post (noindex + left out
 *     of the sitemap)
 *   - WordPress's built-in XML sitemap (/wp-sitemap.xml), trimmed: no
 *     user archives, no tag archives, no hidden posts
 *   - one small JSON-LD graph on the front page: Organization + WebSite
 *     (events, articles, etc. are left to the plugins that own them)
 *
 * Settings: Mindshare API Settings → SEO. Per post: the "Search &
 * sharing" box in the editor sidebar. With nothing filled in, a page
 * describes itself with its first paragraph and shares its featured
 * image, else its first image block, else the default social image.
 * Values are read straight from the options / post meta, so the front
 * end doesn't need ACF.
 *
 * Switches itself off when a full SEO plugin (Yoast, Rank Math,
 * SEOPress, AIOSEO, The SEO Framework) is active, so they never both
 * print tags. Force it either way with the `mapi_seo_enabled` filter.
 *
 * Filters:
 *   mapi_seo_enabled            bool
 *   mapi_seo_description        string, for the current page
 *   mapi_seo_image              attachment ID, for the current page
 *   mapi_seo_block_image        attachment ID found in a block (fallback
 *                               image when a post has no featured image)
 *   mapi_seo_image_size         image size for og:image ('1536x1536')
 *   mapi_seo_organization       Organization schema array
 *   mapi_seo_schema_graph       the whole front page graph
 *   mapi_seo_sitemap_taxonomies taxonomy names kept in the sitemap
 *
 * @package Mindshare_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is the module on? Off when another SEO plugin handles all of this.
 */
function mapi_seo_enabled() {
	$other = defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'SEOPRESS_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' );
	return (bool) apply_filters( 'mapi_seo_enabled', ! $other );
}

/**
 * An SEO setting (ACF options page; stored as options_{name}).
 */
function mapi_seo_option( $name ) {
	return get_option( 'options_mapi_seo_' . $name, '' );
}

/**
 * A post's SEO field (ACF; stored as plain post meta).
 */
function mapi_seo_meta( $post_id, $name ) {
	return get_post_meta( $post_id, 'mapi_seo_' . $name, true );
}

/**
 * Plain text, whitespace collapsed, cut to about 160 characters on a word.
 */
function mapi_seo_clean( $text, $length = 160 ) {
	$text = wp_strip_all_tags( strip_shortcodes( (string) $text ), true );
	$text = trim( preg_replace( '/\s+/', ' ', html_entity_decode( $text, ENT_QUOTES, 'UTF-8' ) ) );
	if ( mb_strlen( $text ) > $length ) {
		$text = mb_substr( $text, 0, $length );
		$text = preg_replace( '/\s+\S*$/u', '', $text ) . '…';
	}
	return $text;
}

// ---------------------------------------------------------------
// Fields: SEO settings page + the per-post "Search & sharing" box.
// ---------------------------------------------------------------
add_action(
	'acf/init',
	function () {
		if ( ! mapi_seo_enabled() || ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_options_sub_page(
			array(
				'page_title'  => 'SEO',
				'menu_title'  => 'SEO',
				'menu_slug'   => 'mindshare-seo',
				'parent_slug' => 'mindshare-settings',
				'capability'  => 'manage_options',
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_mapi_seo_settings',
				'title'    => 'SEO',
				'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'mindshare-seo' ) ) ),
				'fields'   => array(
					array(
						'key'   => 'field_mapi_seo_tab_sharing',
						'label' => 'Sharing',
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_mapi_seo_default_image',
						'label'         => 'Default social image',
						'name'          => 'mapi_seo_default_image',
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'instructions'  => 'Shown when a link to the site is shared and the page has no image of its own. 1200 × 630 px works everywhere.',
					),
					array(
						'key'          => 'field_mapi_seo_home_description',
						'label'        => 'Home page description',
						'name'         => 'mapi_seo_home_description',
						'type'         => 'textarea',
						'rows'         => 3,
						'instructions' => 'The front page\'s search and sharing description (about 150 characters). Empty: the site tagline (Settings → General).',
					),
					array(
						'key'   => 'field_mapi_seo_tab_org',
						'label' => 'Organization',
						'type'  => 'tab',
					),
					array(
						'key'          => 'field_mapi_seo_org_message',
						'label'        => '',
						'type'         => 'message',
						'message'      => 'Describes who runs the site, for search engines (structured data on the home page only). Leave anything you don\'t want published empty.',
					),
					array(
						'key'           => 'field_mapi_seo_org_type',
						'label'         => 'Type',
						'name'          => 'mapi_seo_org_type',
						'type'          => 'select',
						'choices'       => array(
							'Organization'  => 'Organization',
							'NGO'           => 'Nonprofit / NGO',
							'LocalBusiness' => 'Local business',
							'Corporation'   => 'Company',
						),
						'default_value' => 'Organization',
						'wrapper'       => array( 'width' => 50 ),
					),
					array(
						'key'          => 'field_mapi_seo_org_name',
						'label'        => 'Name',
						'name'         => 'mapi_seo_org_name',
						'type'         => 'text',
						'instructions' => 'Empty: the site title.',
						'wrapper'      => array( 'width' => 50 ),
					),
					array(
						'key'           => 'field_mapi_seo_org_logo',
						'label'         => 'Logo',
						'name'          => 'mapi_seo_org_logo',
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'thumbnail',
						'instructions'  => 'A square PNG or JPG, at least 112 px. Empty: the site icon.',
					),
					array(
						'key'     => 'field_mapi_seo_org_street',
						'label'   => 'Street address',
						'name'    => 'mapi_seo_org_street',
						'type'    => 'text',
						'wrapper' => array( 'width' => 50 ),
					),
					array(
						'key'     => 'field_mapi_seo_org_city',
						'label'   => 'City',
						'name'    => 'mapi_seo_org_city',
						'type'    => 'text',
						'wrapper' => array( 'width' => 50 ),
					),
					array(
						'key'     => 'field_mapi_seo_org_region',
						'label'   => 'State',
						'name'    => 'mapi_seo_org_region',
						'type'    => 'text',
						'wrapper' => array( 'width' => 33 ),
					),
					array(
						'key'     => 'field_mapi_seo_org_postal_code',
						'label'   => 'ZIP',
						'name'    => 'mapi_seo_org_postal_code',
						'type'    => 'text',
						'wrapper' => array( 'width' => 33 ),
					),
					array(
						'key'           => 'field_mapi_seo_org_country',
						'label'         => 'Country',
						'name'          => 'mapi_seo_org_country',
						'type'          => 'text',
						'default_value' => 'US',
						'wrapper'       => array( 'width' => 34 ),
					),
					array(
						'key'     => 'field_mapi_seo_org_email',
						'label'   => 'Email',
						'name'    => 'mapi_seo_org_email',
						'type'    => 'email',
						'wrapper' => array( 'width' => 50 ),
					),
					array(
						'key'     => 'field_mapi_seo_org_phone',
						'label'   => 'Phone',
						'name'    => 'mapi_seo_org_phone',
						'type'    => 'text',
						'wrapper' => array( 'width' => 50 ),
					),
					array(
						'key'          => 'field_mapi_seo_org_profiles',
						'label'        => 'Social profiles',
						'name'         => 'mapi_seo_org_profiles',
						'type'         => 'textarea',
						'rows'         => 4,
						'instructions' => 'One full URL per line (e.g. https://www.instagram.com/yourname).',
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'        => 'group_mapi_seo_post',
				'title'      => 'Search & sharing',
				'position'   => 'side',
				'menu_order' => 100,
				'location'   => array( array( array( 'param' => 'post_type', 'operator' => '!=', 'value' => 'attachment' ) ) ),
				'fields'     => array(
					array(
						'key'          => 'field_mapi_seo_description',
						'label'        => 'Description',
						'name'         => 'mapi_seo_description',
						'type'         => 'textarea',
						'rows'         => 4,
						'instructions' => 'Shown under the title in search results and link previews (about 150 characters). Empty: the excerpt or first paragraph.',
					),
					array(
						'key'           => 'field_mapi_seo_image',
						'label'         => 'Social image',
						'name'          => 'mapi_seo_image',
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'instructions'  => 'Empty: the featured image, then the site\'s default social image.',
					),
					array(
						'key'          => 'field_mapi_seo_noindex',
						'label'        => 'Hide from search engines',
						'name'         => 'mapi_seo_noindex',
						'type'         => 'true_false',
						'ui'           => 1,
						'instructions' => 'Asks search engines not to list this page and leaves it out of the sitemap.',
					),
				),
			)
		);
	}
);

/**
 * Front end hooks; added once all plugins have loaded, so the other SEO
 * plugins' constants exist.
 */
function mapi_seo_boot() {
	if ( ! mapi_seo_enabled() ) {
		return;
	}
	add_filter( 'wp_robots', 'mapi_seo_robots' );
	add_action( 'wp_head', 'mapi_seo_head', 1 );
	add_filter( 'wp_sitemaps_add_provider', 'mapi_seo_sitemap_providers', 10, 2 );
	add_filter( 'wp_sitemaps_taxonomies', 'mapi_seo_sitemap_taxonomies' );
	add_filter( 'wp_sitemaps_posts_query_args', 'mapi_seo_sitemap_posts' );
}
add_action( 'plugins_loaded', 'mapi_seo_boot', 20 );

// ---------------------------------------------------------------
// Description + image for the current page.
// ---------------------------------------------------------------

/**
 * The current page's description.
 */
function mapi_seo_description() {
	$text = '';

	if ( is_front_page() ) {
		$text = mapi_seo_option( 'home_description' );
		if ( ! $text && is_singular() ) {
			$text = mapi_seo_meta( get_queried_object_id(), 'description' );
		}
		if ( ! $text ) {
			$text = get_bloginfo( 'description' );
		}
	} elseif ( is_singular() || ( is_home() && get_option( 'page_for_posts' ) ) ) {
		$post = get_post( is_home() ? get_option( 'page_for_posts' ) : get_queried_object_id() );
		if ( $post ) {
			$text = mapi_seo_meta( $post->ID, 'description' );
			if ( ! $text && has_excerpt( $post ) ) {
				$text = $post->post_excerpt;
			}
			if ( ! $text ) {
				$text = mapi_seo_scan( $post )['text'];
			}
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$text = term_description();
	} elseif ( is_post_type_archive() ) {
		$type = get_post_type_object( get_query_var( 'post_type' ) );
		$text = $type ? $type->description : '';
	}

	if ( ! mapi_seo_clean( $text ) && ! is_search() && ! is_404() ) {
		$text = get_bloginfo( 'description' );
	}

	return mapi_seo_clean( apply_filters( 'mapi_seo_description', $text ) );
}

/**
 * The current page's social image (attachment ID, or 0).
 */
function mapi_seo_image_id() {
	$id = 0;
	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		$id      = (int) mapi_seo_meta( $post_id, 'image' );
		if ( ! $id ) {
			$id = (int) get_post_thumbnail_id( $post_id );
		}
		if ( ! $id ) {
			$id = mapi_seo_scan( get_post( $post_id ) )['image'];
		}
	}
	if ( ! $id ) {
		$id = (int) mapi_seo_option( 'default_image' );
	}
	if ( ! $id ) {
		$id = (int) get_option( 'site_icon' );
	}
	return (int) apply_filters( 'mapi_seo_image', $id );
}

/**
 * A post's first paragraph and first image, read from its blocks
 * (nested ones too, in order). Sites map their own blocks with the
 * `mapi_seo_block_image` filter (e.g. an ACF hero block's image field).
 *
 * @return array{text: string, image: int}
 */
function mapi_seo_scan( $post ) {
	static $cache = array();
	if ( ! $post ) {
		return array( 'text' => '', 'image' => 0 );
	}
	if ( isset( $cache[ $post->ID ] ) ) {
		return $cache[ $post->ID ];
	}

	$found = array( 'text' => '', 'image' => 0 );
	$walk  = static function ( $blocks ) use ( &$walk, &$found ) {
		foreach ( $blocks as $block ) {
			if ( empty( $block['blockName'] ) ) {
				continue;
			}
			// Paragraphs, until there's a sentence's worth of text.
			if ( 'core/paragraph' === $block['blockName'] && mb_strlen( $found['text'] ) < 80 ) {
				$found['text'] = trim( $found['text'] . ' ' . wp_strip_all_tags( $block['innerHTML'] ) );
			}
			if ( ! $found['image'] ) {
				$attrs = $block['attrs'];
				$id    = 0;
				if ( in_array( $block['blockName'], array( 'core/image', 'core/cover' ), true ) ) {
					$id = (int) ( $attrs['id'] ?? 0 );
				} elseif ( 'core/media-text' === $block['blockName'] ) {
					$id = (int) ( $attrs['mediaId'] ?? 0 );
				}
				$found['image'] = (int) apply_filters( 'mapi_seo_block_image', $id, $block );
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$walk( $block['innerBlocks'] );
			}
		}
	};
	if ( has_blocks( $post ) ) {
		$walk( parse_blocks( $post->post_content ) );
	} else {
		$found['text'] = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
	}

	return $cache[ $post->ID ] = $found; // phpcs:ignore
}

// ---------------------------------------------------------------
// <head>
// ---------------------------------------------------------------

/**
 * Noindex: hidden posts, author archives and attachment pages (search
 * results are already noindexed by WordPress).
 */
function mapi_seo_robots( $robots ) {
	$hidden = is_singular() && mapi_seo_meta( get_queried_object_id(), 'noindex' );
	if ( $hidden || is_author() || is_attachment() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}

/**
 * Description, Open Graph, Twitter card, and the front page schema.
 */
function mapi_seo_head() {
	if ( is_feed() || is_robots() || is_trackback() ) {
		return;
	}

	$description = mapi_seo_description();
	$title       = wp_get_document_title();
	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$url = get_permalink( get_queried_object_id() );
	} else {
		global $wp;
		$url = home_url( user_trailingslashit( $wp->request ) );
	}
	$title = html_entity_decode( $title, ENT_QUOTES, 'UTF-8' ); // esc_attr() below re-encodes
	$name  = html_entity_decode( wp_strip_all_tags( single_post_title( '', false ) ), ENT_QUOTES, 'UTF-8' );

	$tags = array(
		array( 'name', 'description', $description ),
		array( 'property', 'og:site_name', get_bloginfo( 'name' ) ),
		array( 'property', 'og:locale', str_replace( '-', '_', get_bloginfo( 'language' ) ) ),
		array( 'property', 'og:type', is_singular( 'post' ) ? 'article' : 'website' ),
		array( 'property', 'og:title', is_front_page() ? get_bloginfo( 'name' ) : ( $name ? $name : $title ) ),
		array( 'property', 'og:description', $description ),
		array( 'property', 'og:url', $url ),
	);

	if ( is_singular( 'post' ) ) {
		$tags[] = array( 'property', 'article:published_time', get_the_date( 'c', get_queried_object_id() ) );
		$tags[] = array( 'property', 'article:modified_time', get_the_modified_date( 'c', get_queried_object_id() ) );
	}

	$card  = 'summary';
	$image = mapi_seo_image_id();
	if ( $image ) {
		$src = wp_get_attachment_image_src( $image, apply_filters( 'mapi_seo_image_size', '1536x1536' ) );
		if ( $src ) {
			$tags[] = array( 'property', 'og:image', $src[0] );
			$tags[] = array( 'property', 'og:image:width', $src[1] );
			$tags[] = array( 'property', 'og:image:height', $src[2] );
			$alt    = get_post_meta( $image, '_wp_attachment_image_alt', true );
			if ( $alt ) {
				$tags[] = array( 'property', 'og:image:alt', $alt );
			}
			// Wide images get the large card; a square icon stays small.
			$card = $src[1] >= 600 && $src[1] > $src[2] ? 'summary_large_image' : 'summary';
		}
	}
	$tags[] = array( 'name', 'twitter:card', $card );

	echo "\n<!-- Mindshare SEO -->\n";
	foreach ( $tags as $tag ) {
		list( $attr, $key, $value ) = $tag;
		if ( '' === (string) $value ) {
			continue;
		}
		printf( '<meta %1$s="%2$s" content="%3$s">' . "\n", $attr, esc_attr( $key ), esc_attr( $value ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- $attr is one of two literals.
	}

	if ( is_front_page() ) {
		$graph = mapi_seo_schema_graph();
		if ( $graph ) {
			echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . "</script>\n";
		}
	}
	echo "<!-- / Mindshare SEO -->\n";
}

// ---------------------------------------------------------------
// Schema: Organization + WebSite (front page only).
// ---------------------------------------------------------------

/**
 * The Organization, from the SEO settings (empty values left out).
 */
function mapi_seo_organization() {
	$home = home_url( '/' );
	$org  = array(
		'@type' => mapi_seo_option( 'org_type' ) ? mapi_seo_option( 'org_type' ) : 'Organization',
		'@id'   => $home . '#organization',
		'name'  => mapi_seo_option( 'org_name' ) ? mapi_seo_option( 'org_name' ) : get_bloginfo( 'name' ),
		'url'   => $home,
	);

	$logo = (int) mapi_seo_option( 'org_logo' );
	if ( ! $logo ) {
		$logo = (int) get_option( 'site_icon' );
	}
	$logo_src = $logo ? wp_get_attachment_image_src( $logo, 'full' ) : false;
	if ( $logo_src ) {
		$org['logo'] = array(
			'@type'  => 'ImageObject',
			'url'    => $logo_src[0],
			'width'  => $logo_src[1],
			'height' => $logo_src[2],
		);
	}

	$address = array_filter(
		array(
			'streetAddress'   => mapi_seo_option( 'org_street' ),
			'addressLocality' => mapi_seo_option( 'org_city' ),
			'addressRegion'   => mapi_seo_option( 'org_region' ),
			'postalCode'      => mapi_seo_option( 'org_postal_code' ),
		)
	);
	if ( $address ) {
		$org['address'] = array( '@type' => 'PostalAddress' ) + $address + array_filter( array( 'addressCountry' => mapi_seo_option( 'org_country' ) ) );
	}

	$org['email']     = mapi_seo_option( 'org_email' );
	$org['telephone'] = mapi_seo_option( 'org_phone' );

	$profiles = preg_split( '/\s+/', (string) mapi_seo_option( 'org_profiles' ) );
	$org['sameAs'] = array_values( array_filter( array_map( 'esc_url_raw', $profiles ) ) );

	$org = (array) apply_filters( 'mapi_seo_organization', $org );
	return array_filter( $org, static fn( $v ) => '' !== $v && array() !== $v && null !== $v );
}

/**
 * The front page graph.
 */
function mapi_seo_schema_graph() {
	$home  = home_url( '/' );
	$org   = mapi_seo_organization();
	$graph = array(
		$org,
		array_filter(
			array(
				'@type'       => 'WebSite',
				'@id'         => $home . '#website',
				'url'         => $home,
				'name'        => get_bloginfo( 'name' ),
				'description' => get_bloginfo( 'description' ),
				'inLanguage'  => get_bloginfo( 'language' ),
				'publisher'   => array( '@id' => $org['@id'] ?? $home . '#organization' ),
			)
		),
	);
	return (array) apply_filters( 'mapi_seo_schema_graph', $graph );
}

// ---------------------------------------------------------------
// Sitemap (WordPress core's /wp-sitemap.xml).
// ---------------------------------------------------------------

/**
 * No user (author archive) sitemap.
 */
function mapi_seo_sitemap_providers( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}

/**
 * Categories and custom taxonomies stay; tags and post formats go.
 */
function mapi_seo_sitemap_taxonomies( $taxonomies ) {
	unset( $taxonomies['post_tag'], $taxonomies['post_format'] );
	return apply_filters( 'mapi_seo_sitemap_taxonomies', $taxonomies );
}

/**
 * Leave out posts marked "Hide from search engines".
 */
function mapi_seo_sitemap_posts( $args ) {
	$args['meta_query']   = isset( $args['meta_query'] ) ? (array) $args['meta_query'] : array(); // phpcs:ignore WordPress.DB.SlowDBQuery
	$args['meta_query'][] = array(
		'relation' => 'OR',
		array(
			'key'     => 'mapi_seo_noindex',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key'     => 'mapi_seo_noindex',
			'value'   => '1',
			'compare' => '!=',
		),
	);
	return $args;
}
