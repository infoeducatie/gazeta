// Theme Customizer Settings
( function( $ ){
	
	// HEADER
	// - Logo Settings
	wp.customize('ac_logo_image',function( value ) {
        value.bind(function(to) {
            $('.logo-contents').empty().addClass('logo-image').prepend('<img src="' + to + '" alt="Logo" />');
        });
    });
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.logo-contents' ).removeClass('logo-image').html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.description' ).html( to );
		} );
	} );
	wp.customize('ac_color_logo', function( value ) {
        value.bind(function(to) {
            $('.logo a, .logo a:visited, .logo a:hover').css('color', to);
        });
    });
	wp.customize('ac_background_color_header', function( value ) {
        value.bind(function(to) {
            $('.header-wrap').css('background-color', to);
        });
    });
	wp.customize('ac_background_image_header', function( value ) {
        value.bind(function(to) {
            $('.header-wrap').css('background-image', 'url(' + to + ')');
        });
    });
	wp.customize('ac_border_color_header', function( value ) {
        value.bind(function(to) {
            $('.header-wrap').css('border-color', to);
        });
    });
	wp.customize('ac_color_description', function( value ) {
        value.bind(function(to) {
            $('.logo .description').css('color', to);
        });
    });
	
	
	// TOP MENU
	wp.customize('ac_border_color_top_menu', function( value ) {
        value.bind(function(to) {
            $('.menu-wrap').css('border-color', to);
        });
    });
	wp.customize('ac_border_color_top_menu_bot', function( value ) {
        value.bind(function(to) {
            $('.menu-wrap').css('border-bottom-color', to);
        });
    });
	wp.customize('ac_border_color_top_menu_inn', function( value ) {
        value.bind(function(to) {
            $('.menu-main, .menu-main > li, .menu-wrap .search-button, .browse-more, .mobile-menu-button, .mobile-menu > li, .mobile-menu .sf-sub-indicator, .menu-main .sub-menu, .menu-main .sub-menu a, .search-wrap.search-visible, .search-form .search-submit').css('border-color', to);
        });
    });
	wp.customize('ac_background_color_top_menu', function( value ) {
        value.bind(function(to) {
            $('.menu-main, .menu-main ul, .mobile-menu .sub-menu a, .menu-wrap, .menu-wrap, .menu-wrap .search-wrap, .menu-wrap .search-field').css('background-color', to);
        });
    });
	// TOP MENU COLORS
	wp.customize('ac_color_top_menu_links', function( value ) {
        value.bind(function(to) {
            $('.menu-main > li > a, .menu-wrap a.search-button, .menu-wrap a.browse-more, .menu-wrap a.mobile-menu-button, .menu-wrap .search-field').css('color', to);
        });
    });
	wp.customize('ac_color_top_menu_submenu_links', function( value ) {
        value.bind(function(to) {
            $('.menu-main .sub-menu a').css('color', to);
        });
    });
	wp.customize('ac_color_top_menu_links_hover', function( value ) {
        value.bind(function(to) {
			// .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a
            $('.menu-main a, .menu-wrap a.search-button, .menu-wrap a.browse-more, .menu-wrap a.mobile-menu-button, .mobile-drop-down > a, .mobile-drop-down > a:visited, .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a, .menu-wrap a.search-button.activated, .mobile-menu-button.activated').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_top_menu_links_active', function( value ) {
        value.bind(function(to) {
            $('.menu-wrap a.search-button.activated, .browse-more.activated, .menu-wrap a.mobile-menu-button.activated, .menu-main > li.current_page_item > a, .menu-main > li.current_page_ancestor > a, .menu-main > li.current-menu-item > a, .menu-main > li.current-menu-ancestor > a').css('color', to);
        });
    });
	
	
	// CONTENT
	wp.customize('ac_border_color_content', function( value ) {
        value.bind(function(to) {
            $('fieldset, .container, .sidebar, .main-page-title, .post-template-1 .details .p-share .contents .close-this-temp1, .posts-pagination, .page-links-wrap, .posts-pagination .paging-wrap, .page-links-wrap .page-links, .posts-pagination a, .page-links-wrap a, .page-links-wrap span, .comments-pagination, .comments-pagination .paging-wrap, .comments-pagination a, .posts-pagination span.current, .tabs-widget-navigation ul li a, .tabs-widget-navigation ul li a.selected:after, .mini-sidebar.browse-window-opened, .browse-by-wrap, .browse-window-opened:after, #wp-calendar, #wp-calendar tbody td, #wp-calendar thead th, .single-template-1 .details, .single-template-1 .single-content, .single-content blockquote, .comment-text blockquote, .single-content.featured-image:before, .sidebar .sidebar-heading:before, .sidebar .sidebar-heading:after, .ac-recent-posts li.full-width, .sidebar #recentcomments li, .tagcloud a, .slider-controls, .slide-btn, .slider-pagination a, .as-wrap, .share-pagination, .about-the-author, .about-share .title, .post-navigation, .post-navigation a, .ata-wrap .avatar-wrap, .clear-border, .post-navigation span, .content-wrap, .comments-title, .comment-avatar, .comment-main,  textarea, input, select, li .comment-reply-title small, .browse-more, .post-template-1 .details .post-small-button, .sidebar-heading, .tabs-widget-navigation, .sidebar .sidebar-heading, .sidebar .tabs-widget-navigation, .ac-popular-posts .position, .ac-twitter-widget-ul li.ac-twitter-tweet, select, table, th, td, pre, .posts-pagination span.dots, .comment-list li.pingback, .content-wrap #review-statistics .review-wrap-up .review-wu-right, .comments-area .user-comments-grades, .content-wrap #review-statistics .review-wrap-up, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top, .content-wrap #review-statistics .review-wu-bars, .content-wrap #review-statistics .review-wrap-up .review-wu-left .review-wu-grade, .wrap .cwp-popular-review').css('border-color', to);
        });
    });
	wp.customize('ac_border_color_content', function( value ) {
        value.bind(function(to) {
			$('.mini-sidebar, .sidebar, .mini-sidebar-bg').css({
				'box-shadow': '1px 0 0 ' + to,
				'-webkit-box-shadow': '1px 0 0 ' + to,
				'-moz-box-shadow': '1px 0 0 ' + to
			})
			$('.sidebar').css({
				'box-shadow': '-1px 0 0 ' + to,
				'-webkit-box-shadow': '-1px 0 0 ' + to,
				'-moz-box-shadow': '-1px 0 0 ' + to
			});
			$('.content-wrap #review-statistics .review-wu-bars').css({
				'box-shadow': '1px 1px 0 ' + to,
			});
			$('.comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider').css({
				'box-shadow': 'inset 0px 0px 5px ' + to,
			});
			$('.single-template-1 .featured-image-wrap').css({
				'box-shadow': '-8px 8px 0 ' + to,
				'-webkit-box-shadow': '-8px 8px 0 ' + to,
				'-moz-box-shadow': '-8px 8px 0 ' + to
			});
		});
    });
	wp.customize('ac_color_be5656', function( value ) {
        value.bind(function(to) {
            $('a, .post-small-button a, .kk, .share-pagination .title i').not('.logo a, .menu-main a, .slider a, .banner-small-title a, .ac-social-buttons-widget a, .post-template-1 .title a, .post-small-button .contents a, .detail a, .sidebar .details a, .tabs-widget-navigation a.selected, .slide-btn, .browse-more, .mobile-menu-button, .menu-wrap .search-button, .header-social-icons a, .close-browse-by, .footer-credits a, .back-to-top, .sidebar .tagcloud a, .sidebar .recentcomments a, .post-navigation a, .comment-list .vcard a').css('color', to);
        });
    });
	wp.customize('ac_border_color_be5656', function( value ) {
        value.bind(function(to) {
			$('abbr[title], .back-to-top, .close-browse-by, .tagcloud a:hover, .comment-main .comment-reply-link').css('border-color', to);
			$('.tagcloud a').hover(
				function() {
					$(this).css('border-color', to);	
				},
				function() {
					$(this).css('border-color', '');	
				}
			)
        });
    });
	wp.customize('ac_border_color_000000', function( value ) {
        value.bind(function(to) {
			$('.back-to-top, .close-browse-by, .comment-main a.comment-reply-link, li .comment-reply-title small, textarea, input, select').hover(
				function() {
					$(this).css('border-color', to);	
				},
				function() {
					$(this).css('border-color', '');	
				}
			)
			$('textarea, input, select').focus(
				function() {
					$(this).css('border-color', to);	
				},
				function() {
					$(this).css('border-color', '');	
				}
			)
        });
    });
	wp.customize('ac_border_color_666666', function( value ) {
        value.bind(function(to) {
           $('textarea, input, select').hover(
				function() {
					$(this).css('border-color', to);	
				},
				function() {
					$(this).css('border-color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_hover', function( value ) {
        value.bind(function(to) {
            $('a').not('.logo a, .menu-main a, .slider a, .banner-small-title a, .ac-social-buttons-widget a, .post-template-1 .title a, .post-small-button .contents a, .detail a, .sidebar .details a, .tabs-widget-navigation a.selected, .slide-btn, .browse-more, .mobile-menu-button, .menu-wrap .search-button, .header-social-icons a, .close-browse-by, .footer-credits a, .back-to-top, .sidebar .tagcloud a, .sidebar .recentcomments a, .post-navigation a.prev-post, .post-navigation a.next-post, .comment-list .vcard a').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_444', function( value ) {
        value.bind(function(to) {
            $('body, .comments-number, .comments-number:visited, .post-template-1 p, .single-template-1 .single-content, .post-template-1 .details .detail a, .single-template-1 .details .detail a, .post-template-1 .details .detail a:visited, .footer-credits .copyright, .comment-main .vcard .fn, .content-wrap #review-statistics .review-wrap-up .review-wu-right ul li, .content-wrap #review-statistics .review-wu-bars h3, .content-wrap .review-wu-bars span, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top .cwp-item-category a').css('color', to);
			$('.back-to-top, .close-browse-by, .tagcloud a, .post-navigation a.prev-post, .post-navigation a.next-post, .comment-main .vcard a.comment-edit-link').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_000', function( value ) {
        value.bind(function(to) {
            $('.sidebar-heading, .ac-popular-posts .position, .posts-pagination a.selected, .page-links-wrap a.selected, .comments-pagination a.selected, a.back-to-top, .footer-credits .blog-title, .post-template-1 .details .p-share .contents .close-this-temp1, .tabs-widget-navigation ul li a.selected, .browse-by-title, a.close-browse-by, .comment-main .vcard .fn a, .comment-main .vcard .fn a:visited, .comment-main .vcard a.comment-edit-link, .comment-main a.comment-reply-link, .search-form .search-submit:hover').css('color', to);
        });
    });
	wp.customize('ac_color_666', function( value ) {
        value.bind(function(to) {
            $('.normal-list .current_page_item a, .normal-list .current-menu-item a, .normal-list .current-post-parent a, .wp-caption, textarea, input, select, .main-page-title .page-title, blockquote cite, blockquote small').css('color', to);
        });
    });
	wp.customize('ac_color_222', function( value ) {
        value.bind(function(to) {
            $('.slider-controls a.slide-btn, .slider .title a, .slider .title a:visited, .slider .com:hover, .post-template-1 .title a, .post-template-1 .title a:visited, .ac-recent-posts a.title, .ac-popular-posts a.title, .ac-featured-posts .thumbnail .details .title, legend, .single-template-1 .title, .single-content h1, .single-content h2, .single-content h3, .single-content h4, .single-content h5, .single-content h6, .comment-text h1, .comment-text h2, .comment-text h3, .comment-text h4, .comment-text h5, .comment-text h6, .sidebar #recentcomments li a, .tagcloud a, .about-share .title, .post-navigation a.prev-post, .post-navigation a.next-post, label, .comment-reply-title, .page-404 h1, .main-page-title .page-title span ').css('color', to);
			$('.category > a, .sidebar .category > a, .sidebar #recentcomments a.url').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_333', function( value ) {
        value.bind(function(to) {
            $('.sidebar #recentcomments li a, .search-form .search-submit').css('color', to);
			$('.slider .title a, .post-template-1 .title a, .ac-recent-posts a.title, .ac-popular-posts a.title, .ac-featured-posts .thumbnail .details .title, .footer-credits .theme-author a,  .comment-main .vcard .fn a').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_bbb', function( value ) {
        value.bind(function(to) {
            $('.post-template-1 .details .detail, .single-template-1 .details .detail, .category > a, .sidebar .category > a,  .ac-twitter-tweet-time, .ac-featured-posts .thumbnail .details .category, .footer-credits .theme-author, .footer-credits .theme-author a, .footer-credits .theme-author a:visited, .post-template-1 .details .p-share .contents em, .sidebar #recentcomments, .sidebar #recentcomments a.url, .slider .date, .slider a.com, .banner-small-title, .banner-small-title a, .banner-small-title a:visited').css('color', to);
			$('a.slide-btn, .banner-small-title a').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_color_aaa', function( value ) {
        value.bind(function(to) {
            $('q, .single-content blockquote, .comment-text blockquote, .about-share .author, .post-navigation span, .comment-main .vcard a.comment-date, .not-found-header h2, .search-form .search-submit:active').css('color', to);
        });
    });
	wp.customize('ac_background_color_fff', function( value ) {
        value.bind(function(to) {
            $('body, .post-content, .content-wrap, .slider-pagination a, .slide-btn, .slider .title, .slider .com, .container, .ac-ad-title-300px:before, .post-template-1 .details .post-small-button, #wp-calendar, textarea, input, select, .banner-small-title a, .comment-list .comment-avatar, .ac-featured-posts .thumbnail .details').css('background-color', to);
        });
    });
	wp.customize('ac_background_color_be5656', function( value ) {
        value.bind(function(to) {
            $('.ac-popular-posts .the-percentage, .slider .category, .post-thumbnail .sticky-badge, .post-format-icon, button, .contributor-posts-link, input[type="button"], input[type="reset"], input[type="submit"]').css('background-color', to);
        });
    });
	wp.customize('ac_background_color_e1e1e1', function( value ) {
        value.bind(function(to) {
            $('.no-thumbnail, .featured-image-wrap, .add-some-widgets, .slider-pagination a span, .comment-list .children:before').css('background-color', to);
        });
    });
	wp.customize('ac_background_color_f7f7f7', function( value ) {
        value.bind(function(to) {
            $('ins, .slider-controls, .posts-pagination span.current, .page-links-wrap span, .tabs-widget-navigation ul li a.selected, .browse-more.activated, .about-share .title, .post-navigation a.next-post, .post-navigation a.prev-post, .post-navigation span, .comment-reply-title small, .search-form .search-submit, .ac-popular-posts .position, pre, .comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider, .comments-area .user-comments-grades .comment-meta-grade-bar, #review-statistics .review-wu-bars ul li').css('background-color', to);
			$('.posts-pagination span.current, .tagcloud a, .slide-btn, .page-links-wrap span').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_background_color_f2f2f2', function( value ) {
        value.bind(function(to) {
            $('mark, #wp-calendar tbody a, .tagcloud a').css('background-color', to);
			$('.post-navigation a, .comment-reply-title small, .search-form .search-submit').hover(
				function() {
					$(this).css('color', to);	
				},
				function() {
					$(this).css('color', '');	
				}
			)
        });
    });
	wp.customize('ac_background_color_000', function( value ) {
        value.bind(function(to) {
            $('.slider .date').css('background-color', to);
        });
    });
	
	
	// MINI-SIDEBAR
	wp.customize('ac_mini_first_title', function( value ) {
        value.bind(function(to) {
            $('#mini-first-title').text(to);
        });
    });
	wp.customize('ac_mini_second_title', function( value ) {
        value.bind(function(to) {
            $('#mini-second-title').text(to);
        });
    });
	wp.customize('ac_mini_second_title', function( value ) {
        value.bind(function(to) {
            $('#mini-second-title').text(to);
        });
    });
	
	
	// FOOTER
	wp.customize('ac_footer_logo_text', function( value ) {
        value.bind(function(to) {
            $('.footer-credits .blog-title').text(to);
        });
    });
	wp.customize('ac_footer_copyright_text', function( value ) {
        value.bind(function(to) {
            $('.footer-credits .copyright').text(to);
        });
    });

	
} )( jQuery )