<?php
/**
 * Designbiz Theme Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function designbiz_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'designbiz_customize_partial_blogname',
		) );
	}

	// Register new section: Theme Options
	$wp_customize->add_section( 'designbiz_theme_options', array(
		'title'    => esc_html__( 'Designbiz Options', 'designbiz' ),
		'priority' => 130,
	) );

	// Register Custom RSS setting
	$wp_customize->add_setting( 'designbiz_custom_rss', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'designbiz_custom_rss', array(
		'label'             => esc_html__( 'Custom RSS', 'designbiz' ),
		'description'       => esc_html__( 'If you use 3rd party RSS service, place the URL here to change the default WordPress RSS URL.', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 1,
		'type'              => 'url'
	) );

	// Register Sidebar position setting
	$wp_customize->add_setting( 'designbiz_sidebar_position', array(
		'default'           => 'right',
		'sanitize_callback' => 'designbiz_sanitize_sidebar_position',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'designbiz_sidebar_position', array(
		'label'             => esc_html__( 'Sidebar Position', 'designbiz' ),
		'description'       => esc_html__( 'Applied to post or page that has sidebar.', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 3,
		'type'              => 'radio',
		'choices'           => array(
			'left'  => esc_html__( 'Left', 'designbiz' ),
			'right' => esc_html__( 'Right', 'designbiz' ),
		)
	) );

	// Register Thumbnail Aspect Ratio setting
	$wp_customize->add_setting( 'designbiz_thumbnail_style', array(
		'default'           => 'landscape',
		'sanitize_callback' => 'designbiz_sanitize_thumbnail_style',
	) );
	$wp_customize->add_control( 'designbiz_thumbnail_style', array(
		'label'             => esc_html__( 'Thumbnail Aspect Ratio', 'designbiz' ),
		'description'       => esc_html__( 'Applied to front-page, grid page template and portfolio section.', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 5,
		'type'              => 'radio',
		'choices'           => array(
			'landscape' => esc_html__( 'Landscape (4:3)', 'designbiz' ),
			'square'    => esc_html__( 'Square (1:1)', 'designbiz' ),
		)
	) );

	// Register Featured Image style setting
	$wp_customize->add_setting( 'designbiz_featured_image_page_style', array(
		'default'           => 'cover',
		'sanitize_callback' => 'designbiz_sanitize_featured_image_style',
	) );
	$wp_customize->add_control( 'designbiz_featured_image_page_style', array(
		'label'             => esc_html__( 'Page: Featured image style', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 7,
		'type'              => 'radio',
		'choices'           => array(
			'cover'     => esc_html__( 'Modern cover', 'designbiz' ),
			'standard'  => esc_html__( 'Standard', 'designbiz' ),
		)
	) );

	// Register Pages comment manager setting
	$wp_customize->add_setting( 'designbiz_page_comment', array(
		'default'           => 1,
		'sanitize_callback' => 'designbiz_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'designbiz_page_comment', array(
		'label'             => esc_html__( 'Pages: Enable comment on Pages', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 9,
		'type'              => 'checkbox'
	) );

	// Register Featured Image style setting
	$wp_customize->add_setting( 'designbiz_featured_image_post_style', array(
		'default'           => 'cover',
		'sanitize_callback' => 'designbiz_sanitize_featured_image_style',
	) );
	$wp_customize->add_control( 'designbiz_featured_image_post_style', array(
		'label'             => esc_html__( 'Posts: Featured image style', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 11,
		'type'              => 'radio',
		'choices'           => array(
			'cover'     => esc_html__( 'Modern cover', 'designbiz' ),
			'standard'  => esc_html__( 'Standard', 'designbiz' ),
		)
	) );

	// Register Post Tags setting
	$wp_customize->add_setting( 'designbiz_post_tags', array(
		'default'           => 1,
		'sanitize_callback' => 'designbiz_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'designbiz_post_tags', array(
		'label'             => esc_html__( 'Posts: Show post tags', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 13,
		'type'              => 'checkbox'
	) );

	// Register Author Box setting
	$wp_customize->add_setting( 'designbiz_author_box', array(
		'default'           => 1,
		'sanitize_callback' => 'designbiz_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'designbiz_author_box', array(
		'label'             => esc_html__( 'Posts: Show author box', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 15,
		'type'              => 'checkbox'
	) );

	// Register Next & Prev post setting
	$wp_customize->add_setting( 'designbiz_next_prev_post', array(
		'default'           => 1,
		'sanitize_callback' => 'designbiz_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'designbiz_next_prev_post', array(
		'label'             => esc_html__( 'Posts: Show next & prev post', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 17,
		'type'              => 'checkbox'
	) );

	// Register Posts comment manager setting
	$wp_customize->add_setting( 'designbiz_post_comment', array(
		'default'           => 1,
		'sanitize_callback' => 'designbiz_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'designbiz_post_comment', array(
		'label'             => esc_html__( 'Posts: Enable comment on Posts', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 19,
		'type'              => 'checkbox'
	) );

	// Register Footer Credits setting
	$default = '&copy; Copyright ' . date( 'Y' ) . ' <a href="' . esc_url( home_url() ) . '">' . esc_attr( get_bloginfo( 'name' ) ) . '</a> &middot; Designed by <a href="https://www.theme-junkie.com/">Theme Junkie</a>';
	$wp_customize->add_setting( 'designbiz_footer_credits', array(
		'default'           => $default,
		'sanitize_callback' => 'designbiz_sanitize_textarea',
	) );
	$wp_customize->add_control( 'designbiz_footer_credits', array(
		'label'             => esc_html__( 'Footer credits', 'designbiz' ),
		'section'           => 'designbiz_theme_options',
		'priority'          => 21,
		'type'              => 'textarea'
	) );

	// Register new section: Portfolio
	$wp_customize->add_section( 'designbiz_portfolio', array(
		'title'    => esc_html__( 'Portfolio', 'designbiz' ),
		'priority' => 130,
	) );

	// Register Portfolio title setting
	$wp_customize->add_setting( 'designbiz_portfolio_title', array(
		'default'           => esc_html__( 'Portfolio', 'designbiz' ),
		'sanitize_callback' => 'esc_attr',
	) );
	$wp_customize->add_control( 'designbiz_portfolio_title', array(
		'label'             => esc_html__( 'Portfolio Archive Title', 'designbiz' ),
		'section'           => 'designbiz_portfolio',
		'priority'          => 1,
		'type'              => 'text'
	) );

	// Register Footer Credits setting
	$wp_customize->add_setting( 'designbiz_portfolio_content', array(
		'default'           => '',
		'sanitize_callback' => 'esc_textarea',
	) );
	$wp_customize->add_control( 'designbiz_portfolio_content', array(
		'label'             => esc_html__( 'Portfolio Archive Content', 'designbiz' ),
		'section'           => 'designbiz_portfolio',
		'priority'          => 3,
		'type'              => 'textarea'
	) );

}
add_action( 'customize_register', 'designbiz_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function designbiz_customize_preview_js() {
	wp_enqueue_script( 'designbiz-customizer', get_template_directory_uri() . '/assets/js/customizer/customizer.js', array( 'customize-preview', 'jquery' ) );
}
add_action( 'customize_preview_init', 'designbiz_customize_preview_js' );

/**
 * Custom RSS feed url.
 */
function designbiz_custom_rss_url( $output, $feed ) {

	// Get the custom rss feed url
	$url = get_theme_mod( 'designbiz_custom_rss' );

	// Do not redirect comments feed
	if ( strpos( $output, 'comments' ) ) {
		return $output;
	}

	// Check the settings.
	if ( ! empty( $url ) ) {
		$output = esc_url( $url );
	}

	return $output;
}
add_filter( 'feed_link', 'designbiz_custom_rss_url', 10, 2 );

/**
 * Display theme documentation on customizer page.
 */
function designbiz_documentation_link() {

	// Enqueue the script
	wp_enqueue_script( 'designbiz-doc', get_template_directory_uri() . '/assets/js/customizer/doc.js', array(), '1.0.0', true );

	// Localize the script
	wp_localize_script( 'designbiz-doc', 'prefixL10n',
		array(
			'prefixURL'   => esc_url( 'http://docs.theme-junkie.com/designbiz/' ),
			'prefixLabel' => esc_html__( 'Documentation', 'designbiz' ),
		)
	);

}
add_action( 'customize_controls_enqueue_scripts', 'designbiz_documentation_link' );

/**
 * Render the site title for the selective refresh partial.
 *
 * Taken from Twenty Sixteen 1.2
 */
function designbiz_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Sanitize the Grid Thumbnail Aspect Ratio value.
 */
function designbiz_sanitize_thumbnail_style( $ratio ) {
	if ( ! in_array( $ratio, array( 'landscape', 'square' ) ) ) {
		$ratio = 'landscape';
	}
	return $ratio;
}

/**
 * Sanitize the Featured Image style value.
 */
function designbiz_sanitize_featured_image_style( $style ) {
	if ( ! in_array( $style, array( 'cover', 'standard' ) ) ) {
		$style = 'cover';
	}
	return $style;
}

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean (true|false).
 */
function designbiz_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Sanitize the Sidebar Position value.
 *
 * @param string $position.
 * @return string (left|right).
 */
function designbiz_sanitize_sidebar_position( $position ) {
	if ( ! in_array( $position, array( 'left', 'right' ) ) ) {
		$position = 'right';
	}
	return $position;
}

/**
 * Sanitize the Footer Credits
 */
function designbiz_sanitize_textarea( $text ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$text = $text;
	} else {
		$text = wp_kses_post( $text );
	}
	return $text;
}
