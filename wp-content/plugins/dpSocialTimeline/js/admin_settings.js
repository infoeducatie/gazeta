jQuery(function($) {

	var $overlay = $('<div>').addClass('dpSocialTimeline_Overlay').click(function(){
		hideOverlay();
	});
	
	function serializeForm(form) {
		var o = {};
		var a = form.serializeArray();
		$.each(a, function() {
			if (o[this.name]) {
			   if (!o[this.name].push) {
				   o[this.name] = [o[this.name]];
			   }
			   o[this.name].push(this.value || '');
			} else {
			   o[this.name] = this.value || '';
			}
		});
		return o;	
	}
	
	dosort();
	function dosort(){

		$('#dp_ui_content .dp-sortable').sortable({
				placeholder: 'sortable-placeholder',
				items: '> .postbox',
				handle: '> .hndle',
				cursor: 'move',
				distance: 2,
				tolerance: 'pointer',
				forcePlaceholderSize: true,
				helper: 'clone',
				opacity: 0.7,
				
				start: function(event, ui) {
					$('body').css({
						WebkitUserSelect: 'none',
						KhtmlUserSelect: 'none'
					});
				},
				
				stop: function(event, ui) {
					ui.item.parent().removeClass('temp-border');
					$('body').css({
						WebkitUserSelect: '',
						KhtmlUserSelect: ''
					});
				}
		});
		
		$('.btn_custom_delete').unbind('click');
		$('.btn_custom_delete').click(function() {
			if(confirm("Are you sure?")) {
				$(this).closest('.slidebox').remove();
			}
		});
		
		$('.btn_social_delete').unbind('click');
		$('.btn_social_delete').click(function() {
			if(confirm("Are you sure?")) {
				$(this).closest('.slidebox').remove();
			}
		});
		
		
	}
	
	$('#dp_ui_content .handlediv').each(function() {
		toggleSlide($(this));			
	});
		
	function toggleSlide(target) {
		target.click(function() {
			var panel = target.parent();
			$(panel.find('.dp_inside')[0]).slideToggle();
		});
	}
	
	function rand (min, max) {

		var argc = arguments.length;
		if (argc === 0) {
			min = 0;
			max = 2147483647;
		} else if (argc === 1) {
			throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
		}
		return Math.floor(Math.random() * (max - min + 1)) + min;

	}
	
	$('#dp_uni_btn_add_social').click(function() {
		
		if($('#clone_add_social').length) {
			reg = new RegExp($('#clone_add_social').find('.social_nonce').val(), 'g');
			
			$('#dp_timelines_social').append($($('#clone_add_social').html().replace(reg, rand())).clone());
			dosort();

			$('#dp_ui_content .handlediv').each(function() {
				$(this).unbind('click');
				toggleSlide($(this));			
			});
		}
	});
	
	$('#dp_uni_btn_add_custom').click(function() {
		
		if($('#clone_add_custom').length) {
			reg = new RegExp($('#clone_add_custom').find('.custom_nonce').val(), 'g');

			$('#dp_timelines_custom').append($($('#clone_add_custom').html().replace(reg, rand())).clone());
			dosort();
			
			$('#dp_ui_content .handlediv').each(function() {
				$(this).unbind('click');
				toggleSlide($(this));			
			});
		}
	});
	
}); 