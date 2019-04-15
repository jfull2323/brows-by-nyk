/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Sidebar position.
	wp.customize( 'designbiz_sidebar_position', function( value ) {
		value.bind( function( to ) {
			if ( 'left' === to ) {
				$( 'body' ).removeClass( 'right-sidebar' ).addClass( 'left-sidebar' );
			} else {
				$( 'body' ).removeClass( 'left-sidebar' ).addClass( 'right-sidebar' );
			}
		} );
	} );

} )( jQuery );
