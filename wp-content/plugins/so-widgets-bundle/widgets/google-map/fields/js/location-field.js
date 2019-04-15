/* global jQuery, sowbForms, soLocationField */

window.sowbForms = window.sowbForms || {};

sowbForms.LocationField = function () {
	return {
		init: function ( element ) {
			
			if ( typeof google.maps.places === 'undefined' ) {
				console.error( 'SiteOrigin Google Maps Widget: Failed to load the places library.' );
				return;
			}
			
			var $inputField = $( element ).find( '.siteorigin-widget-location-input' );
			var $valueField = $( element ).find( '.siteorigin-widget-input' );
			var autocomplete = new google.maps.places.Autocomplete( $inputField.get( 0 ) );
			
			var getSimplePlace = function ( place ) {
				var promise = new $.Deferred();
				var simplePlace = { name: place.name };
				simplePlace.address = place.hasOwnProperty( 'formatted_address' ) ? place.formatted_address : '';
				if ( place.hasOwnProperty( 'geometry' ) ) {
					simplePlace.location = place.geometry.location.toString();
					promise.resolve( simplePlace );
				} else {
					var addr = { address: place.hasOwnProperty( 'formatted_address' ) ? place.formatted_address : place.name };
					new google.maps.Geocoder().geocode( addr,
						function ( results, status ) {
							if ( status === google.maps.GeocoderStatus.OK ) {
								simplePlace.location = results[ 0 ].geometry.location.toString();
								promise.resolve( simplePlace );
							} else {
								promise.reject( status );
							}
						} );
				}
				return promise;
			};
			
			var onPlaceChanged = function () {
				var place = autocomplete.getPlace();
				
				getSimplePlace( place )
				.done( function ( simplePlace ) {
					$valueField.val( JSON.stringify( simplePlace ) )
					$valueField.trigger( 'change' );
				} )
				.fail( function ( status ) {
					console.warn( 'SiteOrigin Google Maps Widget: Geocoding failed for "' + place.name + '" with status: ' + status );
				} );
			};

			autocomplete.addListener( 'place_changed', onPlaceChanged );
			
			$inputField.on( 'change', function () {
				$valueField.val( JSON.stringify( { name: $inputField.val() } ) );
				$valueField.trigger( 'change' );
			} );
			
			if ( $valueField.val() ) {
				// Attempt automatic migration
				var place = {};
				try {
					var parsed = JSON.parse( $valueField.val() );
					if ( ! parsed.hasOwnProperty( 'location' ) ) {
						if ( parsed.hasOwnProperty( 'address' ) ) {
							place.name = parsed.address;
						}
					}
				} catch ( error ) {
					// Let's just try use the value directly.
					place.name = $valueField.val();
				}
				if ( place.hasOwnProperty( 'name' ) && place.name !== 'null') {
					if ( ! sowbForms.mapsMigrationLogged ) {
						console.info( 'SiteOrigin Google Maps Widget: Starting automatic migration of location. Please wait a moment...' );
						sowbForms.mapsMigrationLogged = true;
					}
					var delay = 100;
					function callGetSimplePlace( place, field ) {
						getSimplePlace( place )
						.done( function ( simplePlace ) {
							field.val( JSON.stringify( simplePlace ) );
							field.trigger( 'change' );
							sowbForms._geocodeQueue.shift();
							if ( sowbForms._geocodeQueue.length > 0 ) {
								var next = sowbForms._geocodeQueue[ 0 ];
								setTimeout( function () {
									callGetSimplePlace( next.place, next.field );
								}, delay );
							} else {
								console.info( 'SiteOrigin Google Maps Widget: Location fields updated. Please save the post to complete the migration.' );
							}
						} )
						.fail( function ( status ) {
							if ( status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT ) {
								if ( ! sowbForms.hasOwnProperty( 'overQueryLimitCount' ) ) {
									sowbForms.overQueryLimitCount = 1;
								} else {
									sowbForms.overQueryLimitCount++;
								}

								if ( sowbForms.overQueryLimitCount < 3 ) {
									// The Google Maps Geocoding API docs say rate limits are 50 requests per second,
									// but in practice it seems the limit is much lower.
									var next = sowbForms._geocodeQueue[ 0 ];
									// Progressively increase the delay to try avoid hitting the rate limit.
									delay = delay * 10;
									setTimeout( function () {
										callGetSimplePlace( next.place, next.field );
									}, delay );
								} else {
									console.warn( 'SiteOrigin Google Maps Widget: Automatic migration of old address failed with status: ' + status );
									console.info( 'SiteOrigin Google Maps Widget: Please save this post and open the form to try again.' );
								}
							}
						} );
					}
					sowbForms._geocodeQueue.push( { place: place, field: $valueField } );
					if ( sowbForms._geocodeQueue.length === 1 ) {
						setTimeout( function () {
							callGetSimplePlace( place, $valueField );
						}, delay );
					}
				}
			}
		}
	};
};

sowbForms.setupLocationFields = function () {
	if ( google && google.maps && google.maps.places ) {
		$( '.siteorigin-widget-field-type-location' ).each( function ( index, element ) {
			if ( ! $( element ).data( 'initialized' ) ) {
				new sowbForms.LocationField().init( element );
				$( element ).data( 'initialized', true );
			}
		} );
	}
};

// Called by Google Maps API when it has loaded.
function sowbAdminGoogleMapInit() {
	sowbForms.mapsInitializing = false;
	sowbForms.mapsInitialized = true;
	sowbForms.setupLocationFields();
}

( function ( $ ) {
	
	$( document ).on( 'sowsetupformfield', '.siteorigin-widget-field-type-location', function () {
		
		sowbForms._geocodeQueue = sowbForms._geocodeQueue || [];
		
		var $locationField = $( this );
		if ( $locationField.is( ':not(:visible)' ) ) {
			return;
		}
		
		if ( sowbForms.mapsInitializing ) {
			return;
		}
		
		if ( sowbForms.mapsInitialized ) {
			sowbForms.setupLocationFields();
			return;
		}
		sowbForms.mapsInitializing = true;
		
		var apiKey = $locationField.find( '.location-field-data' ).data( 'apiKey' );
		
		if ( ! apiKey ) {
			sowbForms.displayNotice(
				$( this ).closest( '.siteorigin-widget-form' ),
				soLocationField.missingApiKey,
				'',
				[
					{
						label: soLocationField.globalSettingsButtonLabel,
						url: soLocationField.globalSettingsButtonUrl,
					}
				],
				$locationField
			);
			console.warn( 'SiteOrigin Google Maps Widget: Could not find API key. Google Maps API key is required.' );
			apiKey = '';
		}
		
		// This allows us to "catch" Google Maps API errors and do a bit of custom handling. Currently this is just
		// checking for invalid API key errors.
		if ( window.console && window.console.error ) {
			var errLog = window.console.error;
			
			sowbForms.checkMapsApiInvalidKeyError = function ( error ) {
				var matchError;
				if ( typeof error === 'string' ) {
					matchError = error.match( /^Google Maps.*API (error|warning): (.*)/ );
					if ( matchError === null ) {
						// This occurs when the API key has been restricted to prevent use of certain APIs.
						matchError = error.match( /^This API project is not authorized to use this API/ );
					}
					if ( matchError.length === 3 ) {
						matchError = matchError[ 2 ];
					} else if ( matchError.length === 1 ) {
						matchError = 'ApiNotActivatedMapError';
					}
				}
				if ( matchError ) {
					switch ( matchError ) {
						case 'InvalidKeyMapError':
							sowbForms.displayNotice(
								$( this ).closest( '.siteorigin-widget-form' ),
								soLocationField.invalidApiKey,
								'',
								[
									{
										label: soLocationField.globalSettingsButtonLabel,
										url: soLocationField.globalSettingsButtonUrl,
									}
								],
								$locationField
							);
							break;
						case 'ApiNotActivatedMapError':
							sowbForms.displayNotice(
								$( this ).closest( '.siteorigin-widget-form' ),
								soLocationField.apiNotEnabled,
								'',
								[],
								$locationField
							);
							break;
					}
				}
				errLog.apply( window.console, arguments );
			}.bind( this );
			
			window.console.error = sowbForms.checkMapsApiInvalidKeyError;
		}
		
		// Try to load even if API key is missing to allow Google Maps API to provide it's own warnings/errors about missing API key.
		var apiUrl = 'https://maps.googleapis.com/maps/api/js?key=' + apiKey + '&libraries=places&callback=sowbAdminGoogleMapInit';
		$( 'body' ).append( '<script async type="text/javascript" src="' + apiUrl + '">' );
	} );

} )( jQuery );
