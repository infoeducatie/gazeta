// No Conflict
jQuery.noConflict();

// JustWrite Scripts
(function( $ ) {
	
	// Menu Drop-Down
	$('.superfish').superfish({ 
		delay:				300,
		speed:				'fast', 
		animation:			{opacity:'show',height:'show'},
		dropShadows:		false,
		cssArrows:			false,
		autoArrows:			true 
	});
	
	
	// Responsive Videos
	$('.single-content, .sidebar').fitVids();
	
	
	$(document).on('click', '.mobile-menu-button', function(event) {
		$('.mobile-menu-button').toggleClass('activated').find('i').toggleClass('fa-bars fa-times');
		$('.menu-main').toggleClass('menu-visible');
		$('li.mobile-drop-down').removeClass('mobile-drop-down');
		$('.mobile-menu').find('i').removeAttr('class').addClass('fa fa-angle-right');
		close_mini_sidebar();
		close_search_box();
		
		event.preventDefault();
	});
	
	$(document).on('click', '.sf-sub-indicator', function(event) {
		$(this).parent().parent().toggleClass('mobile-drop-down')
		.children().find('.mobile-drop-down')
		.removeClass('mobile-drop-down')
		.find('i').toggleClass('fa-angle-down fa-angle-right');
		
		$(this).find('i').toggleClass('fa-angle-right fa-angle-down')

		event.preventDefault();
	});
	
	function close_mobile_menu() {
		$('.mobile-menu-button').removeClass('activated').find('i').removeClass().addClass('fa fa-bars');
		$('.menu-main').removeClass('menu-visible');
		$('li.mobile-drop-down').removeClass('mobile-drop-down');
		$('.mobile-menu').find('i').removeAttr('class').addClass('fa fa-angle-right');
	}
	// -------------

	
	// Logo Position
	function logo_position() {
	
		var logo_w = $('.logo').width();
		
		if( $(window).width() < 1140 ) {
			$('.logo').css({
				'margin-left': -logo_w / 2,
			});
		} else {
			$('.logo').removeAttr( 'style' );
		}
		
		return;
		
	}
	logo_position();
	// -------------
	
	
	// Description Position
	$('.description').css('line-height', $('.logo').height() + 'px');
	// -------------
	
	
	// Slider
	var jcarousel = $('.slider');
	
	jcarousel
	.on('jcarousel:reload jcarousel:create', function () {
			var width = jcarousel.innerWidth();
			
			if (width >= 1150) {
				width = width / 1;
			} else if (width >= 650) {
				width = width / 2;
			}
			
			jcarousel.jcarousel('items').css('width', width + 'px');
		})
			
	.jcarousel({
		wrap: 'circular',
	})
	
	jcarousel.on('jcarousel:visiblein', 'li', function(event, carousel) {
		$(this).css('opacity', 1);
	});

	jcarousel.on('jcarousel:visibleout', 'li', function(event, carousel) {
		$(this).css('opacity', 0.5);
	});

	$('.prev-slide')
		.jcarouselControl({
			target: '-=1'
	});

	$('.next-slide')
		.jcarouselControl({
			target: '+=1'
	});

	$('.slider-pagination')
		.on('jcarouselpagination:active', 'a', function() {
			$(this).addClass('active');
		})
		.on('jcarouselpagination:inactive', 'a', function() {
			$(this).removeClass('active');
		})
		.on('click', function(e) {
			e.preventDefault();
		})
		.jcarouselPagination({
			perPage: 1,
			item: function(page) {
				return '<a href="#' + page + '"><span></span></a>';
			}
	});
	// -------------
	
	
	// Search Button
	$(document).on('click', '.search-button, .try-a-search', function(event) {
		$('.search-button').toggleClass('activated').find('i').toggleClass('fa-search fa-times');
		$('.search-wrap').toggleClass('search-visible');
		$('#header-search .search-field').val('').focus();
		close_mini_sidebar();
		close_mobile_menu();
		event.preventDefault();
	});
	
	function close_search_box() {
		$('.search-button').removeClass('activated');
		$('.search-button').find('i').removeClass().addClass('fa fa-search');
		$('.search-wrap').removeClass('search-visible');
		$('#header-search .search-field').blur();
	}
	// -------------
	
	
	// Back To Top
	$(".back-to-top").click(function () {
		$("html, body").animate({scrollTop: 0}, 50);
	});
	// -------------
	
	
	// Tabs Widget
	$('#ac-tabs-widget').idTabs(function(id){
		$(id).fadeIn(400); 
	});
	// -------------
	
	
	// Browse
	$(document).on('click', '#browse-more', function(event) {
		var cwp = $('#content-wrap').position();
		var cwp_total = cwp.top - parseInt($('.mini-sidebar').css('padding-top')) + parseInt($('.container').css('border-top-width')) + 1;
		$(this).toggleClass('activated');
		$('.mini-sidebar').toggleClass('browse-window-opened');
		$('.mini-sidebar').css({ 
			'display': 'block',
			'position':	'absolute'
		});
		if ($('.mini-sidebar').hasClass('browse-window-opened')) {
			$("html, body").animate({scrollTop: cwp_total}, 300);
		} else {
			$('.mini-sidebar').removeAttr('style');	
		}
		close_search_box();
		close_mobile_menu();
		event.preventDefault();
	});
	
	function close_mini_sidebar() {
		$('.mini-sidebar').removeClass('browse-window-opened');
		$('#browse-more').removeClass('activated');
		$('.mini-sidebar').removeAttr('style');
	}
	
	$(document).on('click', '.close-browse-by', function(event) {
		close_mini_sidebar();
		close_mobile_menu();
		event.preventDefault();
	});
	// -------------
	
	
	// Posts - Template 1 - Share Article
	$(document).on('click', '.post-share-temp1', function(event) {
		var share_id = $(this).attr('id');
		var share_wrap_width = $('.post-template-1 .details').width() - 50;
		$(this).css('display', 'none');
		$('#' + share_id + '-rm').css('margin-right', 48);
		$('#' + share_id + '-wrap').addClass('opened').css('height', 50).animate({
			'width': '92%'
			}, 500, function() { 
				$('#' + share_id + '-wrap .contents').css('display','block').animate({ 
					'opacity': 1,		
				}, 300);
		});
		event.preventDefault();
	});
	
	$(document).on('click', '.close-this-temp1', function(event) {
		var share_href = $(this).attr('href');
		var share_href_wrap = $(this).attr('href') + '-wrap';
		$(share_href_wrap + ' .contents').animate({ 
			'opacity': 0		
			}, 300, function(){ 
				$(this).css('display','none')
				$(share_href_wrap).animate({
					'width': 48,
					'height': 'auto'	
				}, 300, function(){ 
					$(share_href_wrap).removeClass('opened')
					$(share_href + '-rm').css('margin-right', 0);
					$(share_href).css('display', 'block'); 
				});
			});
		event.preventDefault();
	});
	// -------------
	
	
	// Remove Tag Style (widget)
	$('.tagcloud a').removeAttr('style');
	// -------------
	
	
	// Sticky Menu
	function sticky_menu() {
		var nav = $('.menu-wrap');
		
		nav_scrolled = false;
		spo_scrooled = false;
			
		if( !nav.hasClass('sticky-disabled') ) {
			if( $(window).width() > 1140 ) {
				$(window).scroll(function () {
					if (220 <= $(window).scrollTop() && !nav_scrolled && $(window).width() > 1140) {
						if( $('body').hasClass('admin-bar') ) {
							nav.removeAttr('style').addClass('visible').css('top', 28);
						} else {
							nav.removeAttr('style').addClass('visible')
						}
						nav_scrolled = true;
					}
					if (220 >= $(window).scrollTop() && nav_scrolled) {
						if( $('body').hasClass('admin-bar') ) {
							nav.removeClass('visible').css('top', 0);
						} else {
							nav.removeClass('visible');
						}
						nav_scrolled = false;      
					}
					if (320 <= $(window).scrollTop() && !spo_scrooled) {
						$('.header-social-icons').css('display', 'block').animate({'marginRight': 0}, 100);
						spo_scrooled = true;
					}
					if (320 >= $(window).scrollTop() && spo_scrooled) {
						$('.header-social-icons').animate({
							'marginRight': 20
						}, 100, function() { 
							$('.header-social-icons').hide().css({
								'marginRight': 0	
							});
						}).show();
						spo_scrooled = false;      
					}
				});
			} else {
				$('.menu-wrap').removeClass('visible'),
				nav_scrolled = false,
				$('.header-social-icons').removeAttr('style'),
				spo_scrooled = false;
			}
		}
		
		
	}
	sticky_menu();
	if( $('body').hasClass('admin-bar') ) { $('.visible').css('top', 100); }
	// -------------
	
	
	// On Window Resize
	$(window).resize(function() {
		
		if( $(window).width() >= 1600 ) {
			$('.mini-sidebar').removeClass('browse-window-opened');
			$('#browse-more').removeClass('activated');
			$('.mini-sidebar').removeAttr('style');
		}

		sticky_menu();	

		logo_position();
		
	});
	// -------------
	
	
})(jQuery);