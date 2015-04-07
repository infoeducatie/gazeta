jQuery(document).ready(function($) {

  // Admin slider
  var w = $('.dcwss-container .postbox-container').width();
  var slides = $('#dcwss-slider .dcwss-slide');
  var n = slides.length + 1;
  
  slides.wrapAll('<div id="dcwss-slide-wrap"></div>').css({'float' : 'left','width' : w});
  $('#dcwss-slide-wrap').css({width: (w*n)});
  
	$('.dcwss-container .nav-tab').click(function(e){
		$('#message').slideUp();
		$('.dcwss-container .nav-tab').removeClass('nav-tab-active');
		var i = $(this).index('.dcwss-container .nav-tab');
		$(this).addClass('nav-tab-active');
		$('#dcwss-slide-wrap').stop().animate({'marginLeft' : -w*i+'px'});
		e.preventDefault();
	});
	$('.dcwss-container #message.fade').hide();

	defaulttextFunction();
	
	$('.button-primary').click(function(){
		$(".defaultText").each(function() {
			if ($(this).val() == $(this).attr('title')) {
				$(this).val('');
			}
		});
	});
	var rel = $('.dcwss-sortable-li:first').attr('rel');
	$('#network-tab-container .network-tab').hide();
	$('#network-tab-container .network-tab[rel="'+rel+'"]').fadeIn();
	$('.dcwss-sortable-li:first').addClass('active');
		
	$('.dcwss-sortable-li a').click(function(e){
		var a = $(this).parent();
		var rel = a.attr('rel');
		$('#network-tab-container .network-tab').hide();
		$('#network-tab-container .network-tab[rel="'+rel+'"]').fadeIn();
		$('.dcwss-sortable-li').removeClass('active');
		$('.dcwss-sortable-li[rel="'+rel+'"]').addClass('active');
		e.preventDefault();
	});

	$('.network-header .dcwss-switch-link a').click(function(e){
		var p = $(this).parent().parent();
		var c = p.parent();
		if($(this).hasClass('link-true')){
			$('.text-input-id',p).fadeOut();
			$('.dcwss-options-edit',p).fadeOut();
			$('.icon-bg, h4',c).animate({opacity: 0.6},300);
		} else {
			$('.text-input-id',p).fadeIn();
			$('.dcwss-options-edit',p).fadeIn();
			$('.icon-bg, h4',c).animate({opacity: 1},300);
		}
		e.preventDefault();
	});
	$('.dcwss-help').click(function(e){
		var i = $(this).index('.dcwss-help');
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.dcwss-help-text').slideUp();
		} else {
			$('.dcwss-help').removeClass('active');
			$('.dcwss-help-text').slideUp();
			$(this).addClass('active').fadeOut();
			$('.dcwss-help-text:eq('+i+')').slideToggle(300);
		}
		e.preventDefault();
	});
	$('.dcwss-close').click(function(e){
		var i = $(this).index('.dcwss-close');
		$('.dcwss-help-text:eq('+i+')').slideToggle();
		$('.dcwss-help:eq('+i+')').removeClass('active').fadeIn();
		$('#dcwss-slider').animate({height: h+'px'},400);
		e.preventDefault();
	});
	
	// Image swap
	$(".img-swap").hover(
          function(){this.src = this.src.replace("_off","_on");},
          function(){this.src = this.src.replace("_on","_off");
     });
	$('ul.dcwp-rss li:last').addClass('last');
	$('#dcwss-tbl tr:odd').addClass('odd');
	$('.dc-stream-delete').click(function(e){
		var rel = $(this).attr('rel');
		var data = {
			action: 'dcwss_stream_delete',
			id: rel
		};
		$('#dcwss-tbl tr[rel="'+rel+'"]').animate({opacity:0.5,background:'#fef2f2'});
		$.post(ajaxurl, data, function(response) {
			$('#dcwss-tbl tr[rel="'+rel+'"]').slideUp().remove();
		});
		e.preventDefault();
	});
	$('.dc-stream-add').click(function(e){
				$('#stream-id').val('');
				var name = $('#dc-stream-input').val();
				var data = {
					action: 'dcwss_stream',
					name: name,
					form: $('#dcwss_streams').serialize()
				};
				
				$.post(ajaxurl, data, function(response) {
					$('#dcwss-response').html('Stream ID - '+response+' saved');
					window.location = 'options-general.php?page=social-stream&stream='+response;
				});
				return false;
			});
	$('.dc-stream-edit').click(function(e){	
				$('#dcwss-response').empty();
				var rel = $('#stream-id').val();
				var data = {
					action: 'dcwss_stream_edit',
					id: rel,
					form: $('#dcwss_streams').serialize()
				};
				
				$.post(ajaxurl, data, function(response) {
					$('#dcwss-response').html(response);
				});
				return false;
			});
			
	var fixed = $('.dcwss-switch-link.link-fixed a.active').attr('rel');
	if(fixed == 'true'){
		$('#feed-item-widths').slideDown();
	}
	
	$('.dcwss-switch-link.link-fixed a').click(function(){
		if($(this).hasClass('link-true')){
			$('#feed-item-widths').slideUp();
		} else {
			$('#feed-item-widths').slideDown();
		}
	});
	
	$('.dcwss-switch-link.link-skin a').click(function(){
		if($(this).hasClass('link-true')){
			$('.default-styles').slideUp();
		} else {
			$('.default-styles').slideDown();
		}
	});
			
	$('.dcwss-switch-link a').live('click',function(){
		var $tag = $(this).parent();
		$('a',$tag).toggleClass('active');
		var rel = $('a.active',$tag).attr('rel');
		$tag.next('.dc-switch-value').val(rel);
		if($tag.hasClass('dcwss-types-link')){
			var typeList = [];
			$('.dcwss-types-link').each(function(){
				if($(this).next('.dc-switch-value').val() == 'true'){
					var rel = $(this).next('.dc-switch-value').attr('rel');
					typeList.push(rel);
				}
			});
			$('#dcwss_types').val(typeList);
		} else if ($tag.hasClass('dcwss-network-widget')){
			var networkList = [];
			$('.dcwss-network-widget').each(function(){
				if($(this).next('.dc-switch-value').val() == 'true'){
					var rel = $(this).next('.dc-switch-value').attr('rel');
					networkList.push(rel);
				}
			});
			$('#dcwss_types').val(typeList);
			$('dcwss-network-list').val(networkList);
		}
		return false;
	});
	

	$('#dcwss-sortable li.dcwss-sortable-li:odd').addClass('odd');
			$('.dcwss-select-stats').change(function(){
				//alert('ok');
				var $form = $(this).parent('form');
				$('.dcwss-loading',$form).show();
				var url = $form.attr('action');
				$.post(url, $form.serialize() ,function(data){
					$('.dcwp-response',$form).html(data);
					$('.dcwss-loading',$form).fadeOut(100,function(){
						var url=document.URL.split('&')[0];
						if(url != ''){
							window.location = url;
						} else {
							location.reload();
						}
					});
				});
			});

	// Widgets
	var v = $('.dcwss-widget-select').val();
	$('.dcwss-hide.'+v).show();
	$('.dcwss-widget-select').change(function(){
		v = $(this).val();
		$('.dcwss-hide').slideUp();
			$('.dcwss-hide.'+v).slideDown();
	});
});
function defaulttextFunction(){
	jQuery(".defaultText").focus(function(srcc) {
		if (jQuery(this).val() == jQuery(this)[0].title) {
			jQuery(this).removeClass("defaultTextActive").val("");
		}
	});
	jQuery(".defaultText").blur(function(){
		if (jQuery(this).val() == "") {
			jQuery(this).addClass("defaultTextActive").val(jQuery(this)[0].title);
		}
	});
	jQuery(".defaultText").each(function() {
		if (jQuery(this).val() != jQuery(this)[0].title) {
			jQuery(this).removeClass("defaultTextActive");
		}
		if (jQuery(this).val() == "") {
			jQuery(this).val(jQuery(this)[0].title).addClass("defaultTextActive");
		}
	});
}