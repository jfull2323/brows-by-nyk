( function ( $ ) {

	/**
	 * Document ready
	 */
	$( function () {

		// Responsive video
		$( '.hentry, .widget' ).fitVids();

		/**
		 * Image scroll animations
		 */
		$img = $( '.site-content img, .site-footer img' );
		$img.addClass( 'hide-img' );
		$img.one( 'inview', function () {
			$( this ).addClass( 'show-img' );
		} );

	} );

	/**
	 * Add custom class when scrolling
	 */
	$( window ).scroll( function() {
		if ( window.scrollY > 0 ) {
			$( ".site-header" ).addClass( "slide-animate" );
		} else {
			$( ".site-header" ).removeClass( "slide-animate" );
		}
	} );

}( jQuery ) );
