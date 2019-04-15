<?php
/**
 * Custom functions that act independently of the theme templates
 * Eventually, some of the functionality here could be replaced by core features
 */

/**
 * Adds custom classes to the array of body classes.
 */
function designbiz_body_classes( $classes ) {

	// Adds a class of multi-author to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'multi-author';
	}

	// Adds a class if has featured image.
	if ( has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	// Adds a class on Full Width & Grid page templates.
	if ( is_page_template( 'page-templates/full-width-page.php' ) || is_page_template( 'page-templates/grid-page.php' ) || is_post_type_archive( 'jetpack-testimonial' ) || is_post_type_archive( 'jetpack-portfolio' ) ) {
		$classes[] = 'full-width-page';
	}

	// Adds a class on Full Width Narrow template.
	if ( is_page_template( 'page-templates/full-width-narrow-page.php' ) ) {
		$classes[] = 'full-width-narrow-page';
	}

	if ( is_singular() ) {

		// Adds a class if comments open
		if ( comments_open() || '0' != get_comments_number() ) {
			$classes[] = 'comments-open';
		}

	}

	if ( is_home() || is_singular() && !is_front_page() ) {

		// Adds a class for sidebar position
		$position = get_theme_mod( 'designbiz_sidebar_position' );
		switch ( $position ) {
			case 'left':
				$classes[] = 'left-sidebar';
				break;
			default :
				$classes[] = 'right-sidebar';
		}

	}

	if ( is_single() ) {

		// Adds a class for featured image stle
		$style = get_theme_mod( 'designbiz_featured_image_post_style' );
		switch ( $style ) {
			case 'standard':
				$classes[] = 'standard-featured-image-style';
				break;
			default :
				$classes[] = 'cover-featured-image-style';
		}

	}

	if ( is_page() && !is_page_template( 'page-templates/grid-page.php' ) && !is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'jetpack-testimonial' )  ) {

		// Adds a class for featured image stle
		$style = get_theme_mod( 'designbiz_featured_image_page_style' );
		switch ( $style ) {
			case 'standard':
				$classes[] = 'standard-featured-image-style';
				break;
			default :
				$classes[] = 'cover-featured-image-style';
		}

	}

	return $classes;
}
add_filter( 'body_class', 'designbiz_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 */
function designbiz_post_classes( $classes ) {

	// Adds a class if a post hasn't a thumbnail.
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-post-thumbnail';
	}

	// Replace hentry class with entry.
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'designbiz_post_classes' );

/**
 * Remove 'hentry' from post_class()
 */
function designbiz_remove_hentry( $class ) {
	$class = array_diff( $class, array( 'hentry' ) );
	return $class;
}
add_filter( 'post_class', 'designbiz_remove_hentry' );

/**
 * Change the excerpt more string.
 */
function designbiz_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'designbiz_excerpt_more' );

/**
 * Register custom contact info fields.
 */
function designbiz_contact_info_fields( $contactmethods ) {
	$contactmethods['twitter']     = esc_html__( 'Twitter URL', 'designbiz' );
	$contactmethods['facebook']    = esc_html__( 'Facebook URL', 'designbiz' );
	$contactmethods['gplus']       = esc_html__( 'Google Plus URL', 'designbiz' );
	$contactmethods['instagram']   = esc_html__( 'Instagram URL', 'designbiz' );
	$contactmethods['pinterest']   = esc_html__( 'Pinterest URL', 'designbiz' );
	$contactmethods['linkedin']    = esc_html__( 'Linkedin URL', 'designbiz' );

	// Remove default contacts
	unset( $contactmethods['aim'] );
	unset( $contactmethods['jabber'] );
	unset( $contactmethods['yim'] );

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'designbiz_contact_info_fields' );

/**
 * Extend archive title
 */
function designbiz_extend_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'designbiz_extend_archive_title' );

/**
 * Customize tag cloud widget
 */
function designbiz_customize_tag_cloud( $args ) {
	$args['largest']  = 13;
	$args['smallest'] = 13;
	$args['unit']     = 'px';
	$args['number']   = 20;
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'designbiz_customize_tag_cloud' );

/**
 * Remove role="navigation" from the_posts_pagination()
 */
function designbiz_navigation_markup_template( $template ) {
	return str_replace( ' role="navigation"', '', $template );
}
add_filter( 'navigation_markup_template', 'designbiz_navigation_markup_template' );
