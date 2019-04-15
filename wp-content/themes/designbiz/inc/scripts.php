<?php
/**
 * Enqueue scripts and styles.
 */

/**
 * Loads the theme styles & scripts.
 */
function designbiz_enqueue() {

	// Load plugins stylesheet
	wp_enqueue_style( 'designbiz-plugins-style', trailingslashit( get_template_directory_uri() ) . 'assets/css/plugins.min.css' );

	// Fonts
	wp_enqueue_style( 'designbiz-fonts', designbiz_fonts_url() );

	// if WP_DEBUG and/or SCRIPT_DEBUG turned on, load the unminified styles & script.
	if ( ! is_child_theme() && WP_DEBUG || SCRIPT_DEBUG ) {

		// Load main stylesheet
		wp_enqueue_style( 'designbiz-style', get_stylesheet_uri() );

		// Load custom js plugins.
		wp_enqueue_script( 'designbiz-plugins', trailingslashit( get_template_directory_uri() ) . 'assets/js/plugins.min.js', array( 'jquery' ), null, true );

		// Load custom js methods.
		wp_enqueue_script( 'designbiz-main', trailingslashit( get_template_directory_uri() ) . 'assets/js/main.js', array( 'jquery' ), null, true );

	} else {

		// Load main stylesheet
		wp_enqueue_style( 'designbiz-style', trailingslashit( get_template_directory_uri() ) . 'style.min.css' );

		// Load custom js plugins.
		wp_enqueue_script( 'designbiz-scripts', trailingslashit( get_template_directory_uri() ) . 'assets/js/designbiz.min.js', array( 'jquery' ), null, true );

	}

	// If child theme is active, load the stylesheet.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'designbiz-child-style', get_stylesheet_uri() );
	}

	// Load comment-reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Loads HTML5 Shiv
	wp_enqueue_script( 'designbiz-html5', trailingslashit( get_template_directory_uri() ) . 'assets/js/html5shiv.min.js', array( 'jquery' ), null, false );
	wp_script_add_data( 'designbiz-html5', 'conditional', 'lte IE 9' );

}
add_action( 'wp_enqueue_scripts', 'designbiz_enqueue' );

/**
 * js / no-js script.
 * @copyright http://www.paulirish.com/2009/avoiding-the-fouc-v3/
 */
function designbiz_no_js_script() {
?>
<script>document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'js');</script>
<?php
}
add_action( 'wp_head', 'designbiz_no_js_script', 20 );

/**
 * Add background-image to hero area.
 */
function designbiz_hero_background() {

	if ( is_page_template( 'page-templates/front-page.php' ) || is_singular() ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'designbiz-hero' );
		$css = '.hero { background-image: url(' . esc_url( $thumbnail[0] ) . '); }';
		wp_add_inline_style( 'designbiz-style', $css );
	}

	// Jetpack testimonial archive
	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
	if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
		$thumbnail = wp_get_attachment_image_src( (int)$jetpack_options['featured-image'], 'designbiz-hero' );
		$css = '.hero { background-image: url(' . esc_url( $thumbnail[0] ) . '); }';
		wp_add_inline_style( 'designbiz-style', $css );
	}

}
add_action( 'wp_enqueue_scripts', 'designbiz_hero_background' );
