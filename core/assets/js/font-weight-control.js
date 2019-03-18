/**
 * Add a listener to the Font Family control to the font weight control to new values.
 */

( function( api ) {
	
	// Extend the 'Select' controls.
	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			var control = this;
			
			// Check if the mint typography setting is being updated.
			if ( control.id.indexOf( 'font_family' ) > -1 ) {
				
				// When the mint typography settings is changed.
				control.setting.bind( 'change', function( value ) {
					
					// Change the font weight field to the correct options.
					control.setFontWeightField( value );
				});
			}
		},
		
		/**
		 * Set Font Weights
		 *
		 * Sets the <option> values for the font weight <select> field.
		 *
		 * @since Mint 1.1.0
		 * 
		 */		
		setFontWeightField: function( fontId ) {
			
			var controlid = this.id.replace("font_family", "font_weight");
			var control   = this.container.parent().find( "#customize-control-" + controlid + " select" );
			var output 	  = '<option value="">'+mintFontWeightDefault.theme_default+'</option>';
			
			if ( typeof mintAllFonts[ fontId ] !== "undefined" ) {
				_.each( mintAllFonts[ fontId ]['font_weights'], function( value ) {
					output += '<option value="' + value + '">' + value + '</option>';
				});				
			}

			// Build the new control output.
			control.empty().append( output );
		},
	} );
} )( wp.customize );