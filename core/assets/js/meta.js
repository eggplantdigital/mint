/*
 * Loads the custom metabox ColorPicker
 */
jQuery(document).ready(function ($) {	
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the choose image button is clicked.
    $('.mint-choose-image').click(function(e) {
			
        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });
        
        // Get the parent node.
        var parent  = $(this).parent();
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment ID to our custom image input field.
            $(parent).find( '.mint-image-upload-field' ).val( media_attachment.id );
            
            // Check if the placeholder is showing.
            if ( $(parent).find('.mint-image-display .placeholder').length > 0 ) {
	            
	            // Swap the placeholder for an image.
				$(parent).find('.mint-image-display .placeholder').removeClass('placeholder').addClass('mint-background-image-holder');

		        // Add the dashicon instead of the image.
		        $(parent).find('.mint-background-image-holder').html('<img src="'+media_attachment.url+'" id="preview-background-img" class="mint-background-image" />');
				
				// Show the close button.
				$(parent).find('.mint-image-remove').show();
				
            } else {
	            // Sends the attachment url to our custom image preview.
	            $(parent).find('.mint-background-image-holder img').attr('src', media_attachment.url);
			}
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
    
    // Runs when the remove image button is clicked.
    $('.mint-image-remove').click(function(e) {

        // Prevents the default action from occuring.
        e.preventDefault();
        
        // Get the parent node.
        var parent  = $(this).parent();
        
        // Change the holder class to 'placeholder'.
        $(parent).find('.mint-background-image-holder').addClass('placeholder').removeClass('mint-background-image-holder');
        
        // Add the dashicon instead of the image.
        $(parent).find('.placeholder').html('<span class="dashicons dashicons-format-image"></span>');
        
        // Clear the image input field.
        $(parent).parent().find('.mint-image-upload-field').val('');
        
        // Hide the close button.
        $(this).hide();
	});
	
	// Load the color picker on the mint input box selector
    $('.mint-select-color').wpColorPicker();

	/**
	 * Bind click event for .insert-post-type using event delegation
	 *
	 * @global wp.media.editor
	 */
	$('.insert-post-type').on("click", function(e) {
		e.preventDefault();
		
		options = {
			frame:    'post',
			state:    $(this).data('editor')
		};
		editor = $( e.currentTarget ).data('editor');
		
		wp.media.editor.open( editor, options );
	});
	
	/**
	 * Metabox Tabs
	 * Make the first tab selected when the page has loaded
	 */
	$(".mint-fields-section").hide();
		
	// Cycle through tab sets and select the first tab.
	$("ul.mint-tabs-nav").each(function() {
		$(this).find('li:first').addClass("active");
		$(this).nextAll('.mint-fields-section:first').show();
	});
 	
 	// Click the tab item.
    $( '.mint-tabs-nav li' ).click( function(e) {
		// Add an active class to the selected tab and remove others.
		var cTab = $(this).closest('li');
		cTab.siblings('li').removeClass("active");
		cTab.addClass("active");
		cTab.closest('ul.mint-tabs-nav').nextAll('.mint-fields-section').hide();
				
		// Find the data link value to identify the active tab + content.
		var activeTab = $(this).find('a').data("link");
		
		//Fade in the active ID content
		$('#'+activeTab).fadeIn();
		return false;
    });	
    
    $( '.mint-fa-modal .mint-fa a').on("click", function(e){
	    
		// Save current selected preview class
		var current_ico = $('.mint-fa-preview i.fa').attr('class');
		
		// Deselect and select new icon
		$('.mint-fa-modal .mint-fa.selected').removeClass('selected');
		$(this).parent().find('input').attr('checked', true);
		$(this).parent().addClass('selected'); 
		
		// Update Preview
		$('.mint-fa-preview i.fa').removeClass( current_ico );
		if ( $(this).data('id') != '' ) {
			$('.mint-fa-preview i').addClass('fa fa-'+ $(this).data('id')+' fa-2x');
		}
    });
    
    $( '#mint-change-category' ).change(function() {
		update_category( this.value );
	});
	
	function update_category( selected ) {
		$('.mint-fa-modal div.mint-fa[data-category*="' + selected + '"]').show();
		$('.mint-fa-modal div.mint-fa:not([data-category*="' + selected + '"])').hide();	
	}
	
    $( '.mint-fa-holder a.fa-clear').on("click", function(e){
		
		var current_ico = $('.mint-fa-preview i.fa').attr('class');
		
		$('.mint-fa-preview i.fa').removeClass( current_ico );
    
		$('.mint-fa-modal .mint-fa.selected').removeClass('selected');
		$(this).parent().find('input').attr('checked', false);
    });
});