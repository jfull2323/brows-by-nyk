<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 */

/**
 * Jetpack setup
 */
function designbiz_jetpack_setup() {

	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'site-main',
		'footer_widgets' => array(
			'footer-1',
			'footer-2',
			'footer-3'
		),
		'footer'         => 'page',
	) );

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Add theme support for Testimonial CPT.
	 */
	add_theme_support( 'jetpack-testimonial' );

	/**
	 * Add theme support for Portfolio CPT.
	 */
	add_theme_support( 'jetpack-portfolio' );

}
add_action( 'after_setup_theme', 'designbiz_jetpack_setup' );

/**
 * Remove jetpack social share
 */
function designbiz_jetpack_remove_share() {
	remove_filter( 'the_content', 'sharing_display',19 );
	remove_filter( 'the_excerpt', 'sharing_display',19 );
	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
add_action( 'init', 'designbiz_jetpack_remove_share' );
