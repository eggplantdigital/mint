/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {
 	
	//Update social Shape 
	wp.customize( 'mint_social_shape', function( value ) {
		value.bind( function( newval ) {
			$( 'ul.ico-social' ).removeClass( 'circle' );
			$( 'ul.ico-social' ).removeClass( 'square' );
			$( 'ul.ico-social' ).removeClass( 'no-shape' );
			$( 'ul.ico-social' ).addClass( newval );
		} );
	} );
	
	//Update social Type 
	wp.customize( 'mint_social_type', function( value ) {
		value.bind( function( newval ) {
			$( 'ul.ico-social' ).removeClass( 'black' );
			$( 'ul.ico-social' ).removeClass( 'white' );
			$( 'ul.ico-social' ).removeClass( 'color' );
			$( 'ul.ico-social' ).addClass( newval );
		} );
	} );

	//Update social Size 
	wp.customize( 'mint_social_size', function( value ) {
		value.bind( function( newval ) {
			$( 'ul.ico-social' ).removeClass( 'small' );
			$( 'ul.ico-social' ).removeClass( 'medium' );
			$( 'ul.ico-social' ).removeClass( 'large' );
			$( 'ul.ico-social' ).addClass( newval );
		} );
	} );
	
} )( jQuery );