<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
    
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Group Coverage', 'twentyseventeen' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Free Cell', 'twentyseventeen' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'twentyseventeen' ),
		'id'            => 'sidebar-6',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'twentyseventeen' ),
		'id'            => 'sidebar-7',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Homepage Banner', 'twentyseventeen' ),
		'id'            => 'sidebar-8',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );
	
	//Custom Css
	//wp_enqueue_style( 'custom-style', get_theme_file_uri( '/assets/css/style.css' ), array(), '1.0' );
	
	wp_enqueue_script( 'custom-addtocart', get_theme_file_uri( '/assets/js/custom-addtocart.js' ), array( 'jquery' ), '2.1.2', true );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_enqueue_style( 'twentyseventeen-bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_enqueue_style( 'twentyseventeen-responsive', get_theme_file_uri( '/assets/css/responsive.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

    wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array(), '3.7.3' );
    
	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );


/*
 * Add woocommerce support
 */
 
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/*Add Theme Option Page*/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));	
}

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() && is_shop() ) {

		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'plan' ), // Don't display products in the knives category on the shop page
			'operator' => 'NOT IN'
		)));
	
	}

	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}

/*==============================================
	Remove Woocmmerce Single Product Action
================================================*/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

/*==============================================
	Remove Woocmmerce Single Product Action
================================================*/

// define the woocommerce_add_to_cart_validation callback 
function filter_woocommerce_add_to_cart_validation( $true, $product_id, $quantity ) { 
    // make filter magic happen here... 
	
	 global $woocommerce;
	 
	 foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
		$terms    = get_the_terms( $_product->id, 'product_cat' );
		$currnet_terms = get_the_terms( $product_id, 'product_cat' );

		// second level loop search, in case some items have several categories
		foreach ($terms as $term) {
			$_categoryid = $term->term_id;
			if ( $_categoryid === 17 && $currnet_terms[0]->term_id === 17){
				//category is in cart!
				$woocommerce->cart->remove_cart_item($cart_item_key);
			}
		}
	}	
    return $true; 
}         
// add the filter 
add_filter( 'woocommerce_add_to_cart_validation', 'filter_woocommerce_add_to_cart_validation', 10, 3 );
/*==============================================
	Remove Woocmmerce Single Product Action
================================================*/

/*==============================================
	Remove Cart Page 
================================================*/

// define the woocommerce_before_cart callback 
function action_woocommerce_before_cart( $wccm_before_checkout ) { 
    global $woocommerce;
	$url = $woocommerce->cart->get_checkout_url();
	echo '<script>document.location = "'.$url.'";</script>';
	exit;
}
         
// add the action 
add_action( 'woocommerce_before_cart', 'action_woocommerce_before_cart', 10, 1 ); 


/*==============================================
functions for global cart 
================================================*/
function cart_products($name = null){
	if( $name!=null ){
		global $woocommerce;
	
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			$terms    = get_the_terms( $_product->id, 'product_cat' );
			$remove_link = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $_product->id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
			foreach ($terms as $term) {
				$_categoryname = $term->name;
				if( strtolower($_categoryname) == strtolower($name)){
					echo '<div class="cart-detail">
							<div class="cart-left">
								<h4>'.get_the_title($_product->id).'</h4>
							</div>
							<div class="cart-right">
								<h4>'.wc_price($_product->get_price()).'</h4>
							</div>
							'.$remove_link.'
						</div>';
				}
			}
		}
	}
} 

function check_plan_in_cart(){
	global $woocommerce;
	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
		$terms    = get_the_terms( $_product->id, 'product_cat' );
		
		foreach ($terms as $term) {
			$_categoryname = $term->name;
			if( strtolower($_categoryname) == strtolower('Plan')){
				return true;
				exit;
			}
		}
	}
	return false;
}

function check_phone_in_cart(){
	global $woocommerce;
	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
		$terms    = get_the_terms( $_product->id, 'product_cat' );
		
		foreach ($terms as $term) {
			$_categoryname = $term->name;
			if( strtolower($_categoryname) == strtolower('Phone')){
				return true;
				exit;
			}
		}
	}
	return false;
}

/*=================================================
Order Submit Hook
===================================================*/

// define the woocommerce_checkout_order_processed callback 
function action_woocommerce_checkout_order_processed( $array ) { 
    // make action magic happen here... 
	if( isset($_REQUEST) ){
		$data = array();
		$data['billing_first_name'] = $_REQUEST['billing_first_name'];
		$data['billing_last_name']  = $_REQUEST['billing_last_name'];
		$data['billing_company']    = $_REQUEST['billing_company'];
		$data['billing_country']    = $_REQUEST['billing_country'];
		$data['billing_address_1']  = $_REQUEST['billing_address_1'];
		$data['billing_address_2']  = $_REQUEST['billing_address_2'];
		$data['billing_city']       = $_REQUEST['billing_city'];
		$data['billing_state']      = $_REQUEST['billing_state'];
		$data['billing_postcode']   = $_REQUEST['billing_postcode'];
		$data['billing_phone']      = $_REQUEST['billing_phone'];
		$data['billing_email']      = $_REQUEST['billing_email'];
		$data['billing_pre']        = $_REQUEST['billing_pre'];
		$data['invoice_pre']        = $_REQUEST['invoice_pre'];
		$data['shipping_pre']       = $_REQUEST['shipping_pre'];
		$data['shipping_info']      = $_REQUEST['shipping_info'];
		$data['newsletter']         = $_REQUEST['newsletter'];
		$data['referred']           = $_REQUEST['referred'];
		
		$data = json_encode($data);
		unset( $_COOKIE['order_data'] );
		setcookie( 'order_data', '', time() - ( 15 * 60 ) );
		setcookie( 'order_data', $data, 30 * DAYS_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}	
}
         
// add the action 
add_action( 'woocommerce_checkout_order_processed', 'action_woocommerce_checkout_order_processed', 10, 1 ); 

/*==================================================
woocommerce_email_order_meta
====================================================*/

// define the woocommerce_email_order_meta callback 
/* function action_woocommerce_email_order_meta( $order, $sent_to_admin, $plain_text, $email ) { 
    
	if( isset($_COOKIE['order_data']) && $_COOKIE['order_data']!='' ){
	
		$order_data = json_decode(stripslashes($_COOKIE['order_data']));
		$billing_pre = '';
		if( !empty($order_data['billing_pre']) ){
			$billing_pre = implode(",",$order_data['billing_pre']);
		}
		
		$invoice_pre = '';
		if( !empty($order_data['invoice_pre']) ){
			$invoice_pre = implode(",",$order_data['invoice_pre']);
		}
		
		$shipping_pre = '';
		if( !empty($order_data['shipping_pre']) ){
			$shipping_pre = implode(",",$order_data['invoice_pre']);
		}
		
		$shipping_info = '';
		if( !empty($order_data['shipping_info']) ){
			$shipping_info = implode(",",$order_data['shipping_info']);
		}
		
		$newsletter = '';
		if( !empty($order_data['newsletter']) ){
			$newsletter = implode(",",$order_data['newsletter']);
		}
		
		$referred = '';
		if( !empty($order_data['referred']) ){
			$referred = implode(",",$order_data['referred']);
		}
		
		echo '<h3> Additional Information </h3>
				<table class="form-table">
					<tr>
						<td>How would you like to pay? </td>
						<td>'.$billing_pre.'</td>
					</tr>
					<tr>
						<td>How would you like to receive your invoice? </td>
						<td>'.$invoice_pre.'</td>
					</tr>
					<tr>
						<td>Shipping Address </td>
						<td>'.$billing_pre.'</td>
					</tr>
					<tr>
						<td>How did you hear about us? </td>
						<td>'.$shipping_info.'</td>
					</tr>
					<tr>
						<td>Would you like to receive our monthly e-newsletter? </td>
						<td>'.$newsletter.'</td>
					</tr>
					<tr>
						<td>Were you referred by someone? </td>
						<td>'.$referred.'</td>
					</tr>
				</table>';
		
	}
	
} 
         
// add the action 
add_action( 'woocommerce_email_order_meta', 'action_woocommerce_email_order_meta', 10, 4 );  */


function mode_theme_update_mini_cart() {
  echo wc_get_template( 'cart/mini-cart.php' );
  die();
}
add_filter( 'wp_ajax_nopriv_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );
add_filter( 'wp_ajax_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );


/* Admin Email Filter */
function filter_woocommerce_email_order_meta_fields( $array, $sent_to_admin, $order ) {     
	
	if( isset($_COOKIE['order_data']) && $_COOKIE['order_data']!='' ){
	
		$order_data = json_decode(stripslashes($_COOKIE['order_data']));
		$billing_pre = '';
		
		if( !empty($order_data['billing_pre']) ){
			$billing_pre = implode(",",$order_data['billing_pre']);
			array_push($array,array(
				'label' => 'How would you like to pay?',
				'value' => $billing_pre
			)); 
		}
		
		$invoice_pre = '';
		if( !empty($order_data['invoice_pre']) ){
			$invoice_pre = implode(",",$order_data['invoice_pre']);
			array_push($array,array(
				'label' => 'How would you like to receive your invoice?',
				'value' => $invoice_pre
			));
		}
		
		$shipping_pre = '';
		if( !empty($order_data['shipping_pre']) ){
			$shipping_pre = implode(",",$order_data['invoice_pre']);
			array_push($array,array(
				'label' => 'Shipping Address',
				'value' => $shipping_pre
			));
		}
		
		$shipping_info = '';
		if( !empty($order_data['shipping_info']) ){
			$shipping_info = implode(",",$order_data['shipping_info']);
			array_push($array,array(
				'label' => 'How did you hear about us?',
				'value' => $shipping_info
			));
		}
		
		$newsletter = '';
		if( !empty($order_data['newsletter']) ){
			$newsletter = implode(",",$order_data['newsletter']);
			array_push($array,array(
				'label' => 'Would you like to receive our monthly e-newsletter?',
				'value' => $newsletter
			));
		}
		
		$referred = '';
		if( !empty($order_data['referred']) ){
			$referred = implode(",",$order_data['referred']);
			array_push($array,array(
				'label' => 'Were you referred by someone?',
				'value' => $referred
			));
		}
		
		return $array;
	}
	
    return $array; 
} 
         
// add the filter 
add_filter( 'woocommerce_email_order_meta_fields', 'filter_woocommerce_email_order_meta_fields', 10, 3 ); 


/* Single Product */
// define the woocommerce_single_product_summary callback 
function action_woocommerce_single_product_summary() { 
    echo '<div class="prefrence-info detail-items">
			<div class="form-group">
				<label for="inputEmail"><h4>Keep Your Existing Phone Number?</h4> </label>
				<div class="check-select-prefrence">
					<span class="button-checkbox check-preference">
						<button type="button" class="btn btn-lg btn-default" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;yes</button>
						<input type="checkbox" class="hidden" name="existing_ph_no[]" value="yes">
					</span>
				</div>
				<div class="check-select-prefrence">
					<span class="button-checkbox check-preference">
						<button type="button" class="btn btn-lg btn-default" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;No</button>
						<input type="checkbox" class="hidden" name="existing_ph_no[]" value="no">
					</span>
				</div>
			</div>
			
			<div class="form-group">
				<label for="inputEmail"><h4>Protect Your Device:</h4> </label>
					<p>Safeguard this device from spills, drops and hardware failures with a protection plan from our partner, SquareTrade.</p>
			</div>
			
			<div class="form-group">
				<label for="inputEmail"><h4>I want to protect my device with SquareTrade</h4> </label>
				<div class="check-select-prefrence">
					<span class="button-checkbox check-preference">
						<button type="button" class="btn btn-lg btn-default" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;yes  $2.00 Monthly</button>
						<input type="checkbox" class="hidden" name="protect_dev[]" value="yes  $2.00 Monthly">
					</span>
				</div>
				<div class="check-select-prefrence">
					<span class="button-checkbox check-preference">
						<button type="button" class="btn btn-lg btn-default" data-color="primary"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;No, I don\'t want</button>
						<input type="checkbox" class="hidden" name="protect_dev[]" value="No, I don\'t want">
					</span>
				</div>
			</div>
			
			<p><b>NOTE:</b> You can cancel your protection plan at any time.</p>
		</div>';
}
         
// add the action 
add_action( 'woocommerce_before_add_to_cart_button', 'action_woocommerce_single_product_summary', 20 ); 