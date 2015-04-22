jQuery(document).ready(function($) {
	
	//Tooltips
	jQuery('#cff-admin .cff-tooltip-link').click(function(){
		jQuery(this).closest('tr').find('.cff-tooltip').slideToggle();
	});

	//Check Access Token length
	jQuery("#cff_access_token").change(function() {

		var cff_token_string = jQuery('#cff_access_token').val(),
			cff_token_check = cff_token_string.indexOf('|');

  		if ( (cff_token_check == -1) && (cff_token_string.length < 50) && (cff_token_string.length !== 0) ) {
  			jQuery('.cff-profile-error.cff-access-token').fadeIn();
  		} else {
  			jQuery('.cff-profile-error.cff-access-token').fadeOut();
  		}

	});

	//Is this a page, group or profile?
	var cff_page_type = jQuery('.cff-page-type select').val(),
		$cff_page_type_options = jQuery('.cff-page-options'),
		$cff_profile_error = jQuery('.cff-profile-error.cff-page-type');

	//Should we show anything initially?
	if(cff_page_type !== 'page') $cff_page_type_options.hide();
	if(cff_page_type == 'profile') $cff_profile_error.show();

	//When page type is changed show the relevant item
	jQuery('.cff-page-type').change(function(){
		cff_page_type = jQuery('.cff-page-type select').val();

		if( cff_page_type !== 'page' ) {
			$cff_page_type_options.fadeOut(function(){
				if( cff_page_type == 'profile' ) {
					$cff_profile_error.fadeIn();
				} else {
					$cff_profile_error.fadeOut();
				}
			});
			
		} else {
			$cff_page_type_options.fadeIn();
			$cff_profile_error.fadeOut();
		}
	});


	//When 'Dispay albums from your Photos page' is checked then show the options
	var cff_album_source = jQuery('#cff_albums_source select').val();
	if( cff_album_source == 'photospage' ) {
		jQuery('.cff-album-source-options').show();
	} else {
		jQuery('.cff-album-source-options').hide();
	}

	jQuery('#cff_albums_source select').change(function(){
		cff_album_source = jQuery(this).val();

		if( cff_album_source == 'photospage' ) {
			jQuery('.cff-album-source-options').slideDown();
		} else {
			jQuery('.cff-album-source-options').slideUp();
		}
	});


	//Show narrow option when Full-width layout is selected
	function toggleMediaOptions(){
		if( $('.cff-full').hasClass('cff-layout-selected') ){
			$('.cff-media-position').fadeIn();
		} else {
			$('.cff-media-position').fadeOut();
		}
	}
	toggleMediaOptions();



	//Choose events source
	var $cff_events_only_options = jQuery('.cff-events-only-options'),
		checked = jQuery("#post-types input.cff-post-type:checkbox:checked");
	
	//Hide page source option initially
	$cff_events_only_options.hide();

	//Show if only events are checked
	if (checked.length === 1 && checked[0].id === 'cff_show_event_type') {
		$cff_events_only_options.slideDown();
	}

	//On change check whether only events is checked or not
	jQuery("#post-types").change(function() {
	    var checked = jQuery("#post-types input.cff-post-type:checkbox:checked");
	    if (checked.length === 1 && checked[0].id === 'cff_show_event_type') {
	        $cff_events_only_options.slideDown();
	    } 
	    else {
	        $cff_events_only_options.slideUp();
	    }
	});


	//Albums only
	var $cff_albums_only_options = jQuery('.cff-albums-only-options');
	
	//Hide page source option initially
	$cff_albums_only_options.hide();

	//Show if only events are checked
	if (checked.length === 1 && checked[0].id === 'cff_show_albums_type') {
		$cff_albums_only_options.slideDown();
	}

	//On change check whether only events is checked or not
	jQuery("#post-types").change(function() {
	    var checked = jQuery("#post-types input.cff-post-type:checkbox:checked");
	    if (checked.length === 1 && checked[0].id === 'cff_show_albums_type') {
	        $cff_albums_only_options.slideDown();
	    } 
	    else {
	        $cff_albums_only_options.slideUp();
	    }
	});


	//Header icon
	//Icon type
	//Check the saved icon type on page load and display it
	jQuery('#cff-header-icon-example').removeClass().addClass('fa fa-' + jQuery('#cff-header-icon').val() );
	//Change the header icon when selected from the list
	jQuery('#cff-header-icon').change(function() {
	    var $self = jQuery(this);

	    jQuery('#cff-header-icon-example').removeClass().addClass('fa fa-' + $self.val() );
	});

	//Test Facebook API connection button
	jQuery('#cff-api-test').click(function(e){
		e.preventDefault();
		//Show the JSON
		jQuery('#cff-api-test-result textarea').css('display', 'block');
	});


	//If 'Others only' is selected then show a note
	var $cffOthersOnly = jQuery('#cff-others-only');

	if ( jQuery("#cff_show_others option:selected").val() == 'onlyothers' ) $cffOthersOnly.show();
	
	jQuery("#cff_show_others").change(function() {
		if ( jQuery("#cff_show_others option:selected").val() == 'onlyothers' ) {
			$cffOthersOnly.show();
		} else {
			$cffOthersOnly.hide();
		}
	});

	//Selecting a post layout
	jQuery('.cff-layout').click(function(){
        var $self = jQuery(this);
        $self.addClass('cff-layout-selected').find('#cff_preset_layout').attr('checked', 'checked');
        $self.siblings().removeClass('cff-layout-selected');
        toggleMediaOptions();
    });

    //Add the color picker
	if( jQuery('.cff-colorpicker').length > 0 ) jQuery('.cff-colorpicker').wpColorPicker();

	//Show clear cache message when changing only events options
	// jQuery("#cff-admin .cff-please-clear-cache input, #cff-admin .cff-please-clear-cache select").change(function() {
	// 	jQuery('.cff-clear-cache-notice').show();
	// });


});