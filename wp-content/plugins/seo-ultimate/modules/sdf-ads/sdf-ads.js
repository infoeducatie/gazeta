/*global jQuery:false, alert */
(function($) { 
    "use strict";
jQuery(document).ready(function($) {
	
	$('#sdf-promo-carousel').hide();
	$('#sdf_dashboard_widget .inside').hide();
	var sds_promo_blog_post = $('#sds_promo_blog_post').html();
	var banners_remote = 'https://s3.amazonaws.com/sdfimages/seoultimatebanner/seo_ultimate_banners_jsonp_764.json';

	$.ajax({
		url: banners_remote,
		dataType: 'jsonp',
		jsonp: false,
		jsonpCallback: 'sdfbanners'
	})
	.done(function (data) {
		var sdf_carousel = '';
		if (data.enabled === true) {
			var shuffled_banners = shuffleArray(data.banners);
			var shuffled_slides = shuffleArray(data.slides);
			// check if it's cloud hosted banner
			var banner_img = shuffled_banners[0].banner_img
			if(banner_img.indexOf('https://') == -1) banner_img = suModulesSdfAdsSdfAdsL10n.sdf_banners_url + banner_img;
			sdf_carousel = sdf_carousel + "<a href=\"" + shuffled_banners[0].banner_link + "\" rel=\"nofollow\" target=\"_blank\"><img src=\"" + banner_img + "\" alt=\"Slide "+ i +"\"></a>";
			sdf_carousel = sdf_carousel + "<div id=\"sdfCarousel\" class=\"carousel slide\"><ol class=\"carousel-indicators\">";
					
			var active_indicator = '';
			for ( var i = 0; i < shuffled_slides.length; i++ ) {
				if (i == 0) active_indicator = ' class=\"active\"';
				else active_indicator = '';
				sdf_carousel = sdf_carousel + "<li data-target=\"#sdfCarousel\" data-slide-to=\""+ i +"\""+ active_indicator +"></li>";
			};
			sdf_carousel = sdf_carousel + "<li data-target=\"#sdfCarousel\" data-slide-to=\""+ i +"\"></li>";
			sdf_carousel = sdf_carousel + "</ol><div class=\"carousel-inner\">";
			
			
			for ( var i = 0; i < shuffled_slides.length; i++ ) {
				if (i == 0) active_indicator = ' active';
				else active_indicator = '';
				sdf_carousel = sdf_carousel + "<div class=\"item"+ active_indicator +"\"><div class=\"container\"><div class=\"carousel-caption\">"+ shuffled_slides[i].slide_cap + "<p><a class=\"btn btn-large btn-warning\" href=\""+ shuffled_slides[i].slide_link + "\" rel=\"nofollow\" target=\"_blank\">Read More</a></p></div></div></div>";
			};
			sdf_carousel = sdf_carousel + "<div class=\"item\"><div class=\"container\"><div class=\"carousel-caption\">"+ sds_promo_blog_post + "</div></div></div>";
			sdf_carousel = sdf_carousel + "</div><a class=\"left carousel-control\" href=\"#sdfCarousel\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a><a class=\"right carousel-control\" href=\"#sdfCarousel\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a></div>";
			
			$('#sdf-promo-carousel').html(sdf_carousel).delay(500).fadeIn(600).carousel({ interval:8000 });
			
			// dashboard widget
			$('#sdf_dashboard_widget h3.hndle span').html(data.dashboard_widget[0].title);
			$('#sdf_dashboard_widget .inside').html(data.dashboard_widget[0].content);
			setTimeout(function(){
				$('#sdf_dashboard_widget .inside').fadeIn(600);
			},800);
		}	
	})
	.fail(function (data) {
		$('#sdf-promo-carousel').delay(500).fadeIn(600).carousel({ interval:8000 });
	});	

});

	$.fn.animate_show_el = function(anim_duration) 
	{		
		$(this).css( {overflow:"hidden"}).animate({height:"auto", opacity:1}, anim_duration, 
			function(){ $(this).css({display:"inline-block", overflow:"visible", visibility:"visible", position:"relative", height:"auto"}); });
	};
	
	$.fn.animate_hide_el = function(anim_duration) 
	{		
		$(this).css({overflow:"hidden"}).animate({height:0, opacity:0}, anim_duration,
			function(){ $(this).css({display:"none", overflow:"visible", visibility:"hidden", position:"absolute"}); });
	};
 
})(jQuery);

/**
 * Randomize array element order in-place.
 * Using Fisher-Yates shuffle algorithm.
 */
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
    return array;
}