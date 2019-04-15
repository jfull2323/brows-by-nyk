<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom hooks and Theme settings.
 */

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @since  1.0.0
 */
function designbiz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'designbiz_content_width', 704 );
}
add_action( 'after_setup_theme', 'designbiz_content_width', 0 );

if ( ! function_exists( 'designbiz_fullwidth_content_width' ) ) :

	function designbiz_fullwidth_content_width() {
		global $content_width;

		if ( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/full-width-page.php' ) || is_page_template( 'page-templates/grid-page.php' ) ) {
			$content_width = 1070;
		}
	}

endif;
add_action( 'template_redirect', 'designbiz_fullwidth_content_width' );

if ( ! function_exists( 'designbiz_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0.0
 */
function designbiz_theme_setup() {

	// Make the theme available for translation.
	load_theme_textdomain( 'designbiz', trailingslashit( get_template_directory() ) . 'languages' );

	// Add custom stylesheet file to the TinyMCE visual editor.
	add_editor_style( array( 'assets/css/editor-style.css', designbiz_fonts_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Declare image sizes.
	add_image_size( 'designbiz-thumbnail-landscape', 728, 557, true );
	add_image_size( 'designbiz-thumbnail-square', 728, 728, true );
	add_image_size( 'designbiz-featured', 704, 350, true );
	add_image_size( 'designbiz-featured-full', 1070, 500, true );
	add_image_size( 'designbiz-hero', 1280, 710, true );

	// Register custom navigation menu.
	register_nav_menus(
		array(
			'primary'  => esc_html__( 'Primary Location', 'designbiz' ),
			'footer'   => esc_html__( 'Footer Location', 'designbiz' )
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-list', 'search-form', 'comment-form', 'gallery', 'caption'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'designbiz_custom_background_args', array(
		'default-color' => 'ffffff'
	) ) );

	// Enable support for Custom Logo
	add_theme_support( 'custom-logo', array(
		'height'      => 26,
		'width'       => 200,
		'flex-width' => true,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Enable support for Excerpt on Pages.
	 * See http://codex.wordpress.org/Excerpt
	 */
	add_post_type_support( 'page', 'excerpt' );

}
endif; // designbiz_theme_setup
add_action( 'after_setup_theme', 'designbiz_theme_setup' );

/**
 * Registers custom widgets.
 *
 * @since 1.0.0
 * @link  http://codex.wordpress.org/Function_Reference/register_widget
 */
function designbiz_widgets_init() {

	// Register recent posts thumbnail widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-recent.php';
	register_widget( 'Designbiz_Recent_Widget' );

	// Register popular posts thumbnail widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-popular.php';
	register_widget( 'Designbiz_Popular_Widget' );

	// Register random posts thumbnail widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-random.php';
	register_widget( 'Designbiz_Random_Widget' );

	// Register video widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-video.php';
	register_widget( 'Designbiz_Video_Widget' );

	// Register social widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-social.php';
	register_widget( 'Designbiz_Social_Widget' );

	// Register Grid Front-page widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-fp-grid.php';
	register_widget( 'Designbiz_Featured_Pages_Grid_Widget' );

	// Register Portfolio widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-portfolio.php';
	register_widget( 'Designbiz_Portfolio_Widget' );

	// Register Testimonials widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-testimonial.php';
	register_widget( 'Designbiz_Testimonial_Widget' );

	// Register CTA widget.
	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-call-action.php';
	register_widget( 'Designbiz_Call_Action_Widget' );

}
add_action( 'widgets_init', 'designbiz_widgets_init' );

/**
 * Registers widget areas and custom widgets.
 *
 * @since 1.0.0
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function designbiz_sidebars_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary', 'designbiz' ),
			'id'            => 'primary',
			'description'   => esc_html__( 'Main sidebar that appears on the right.', 'designbiz' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page', 'designbiz' ),
			'id'            => 'front-page',
			'description'   => esc_html__( 'Use this widget area to display widgets on your Front Page', 'designbiz' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'designbiz' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'The footer sidebar 1st column.', 'designbiz' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'designbiz' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'The footer sidebar 2nd column.', 'designbiz' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'designbiz' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'The footer sidebar 3rd column.', 'designbiz' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'designbiz_sidebars_init' );

/**
 * Register Google fonts.
 *
 * @since  1.0.0
 * @return string
 */
function designbiz_fonts_url() {

	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'designbiz' ) ) {
		$fonts[] = 'Lato:400,400i,700,700i';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'designbiz' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Custom template tags for this theme.
 */
require trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Enqueue scripts and styles.
 */
require trailingslashit( get_template_directory() ) . 'inc/scripts.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Require and recommended plugins list.
 */
require trailingslashit( get_template_directory() ) . 'inc/plugins.php';

/**
 * Customizer.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

/**
 * Demo importer
 */
require trailingslashit( get_template_directory() ) . 'inc/demo/demo-importer.php';
