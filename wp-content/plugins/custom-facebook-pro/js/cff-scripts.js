(function($){ 

	//Toggle comments
	jQuery('#cff a.cff-view-comments').unbind('click').bind('click', function(){
		jQuery(this).closest('.cff-item').find('.cff-comments-box').slideToggle();
	});

	//Set paths for query.php
	if (typeof cffsiteurl === 'undefined' || cffsiteurl == '') cffsiteurl = window.location.host + '/wp-content/plugins';
	var locatefile = true,
		url = cffsiteurl + "/custom-facebook-feed-pro/query.php";
	
	//Loop through each item
	jQuery('#cff .cff-item').each(function(){

		var $self = jQuery(this);

		//Wpautop fix
		if( $self.find('.cff-viewpost-link, .cff-viewpost-facebook, .cff-viewpost').parent('p').length ){
			//Don't unwrap event only viewpost link
			if( !$self.hasClass('event') ) $self.find('.cff-viewpost-link, .cff-viewpost-facebook, .cff-viewpost').unwrap('p');
		}
		if( $self.find('.cff-photo').parent('p').length ){
			$self.find('p .cff-photo').unwrap('p');
			$self.find('.cff-album-icon').appendTo('.cff-photo:last');
		}
		if( $self.find('.cff-event-thumb').parent('p').length ){
			$self.find('.cff-event-thumb').unwrap('p');
		}
		if( $self.find('.cff-vidLink').parent('p').length ){
			$self.find('.cff-vidLink').unwrap('p');
		}
		if( $self.find('.cff-link').parent('p').length ){
			$self.find('.cff-link').unwrap('p');
		}
		if( $self.find('.cff-viewpost-link').parent('p').length ){
			$self.find('.cff-viewpost-link').unwrap('p');
		}
		if( $self.find('.cff-viewpost-facebook').parent('p').length ){
			$self.find('.cff-viewpost-facebook').unwrap('p');
		}

		if( $self.find('iframe').parent('p').length ){
			$self.find('iframe').unwrap('p');
		}
		if( $self.find('.cff-author').parent('p').length ){
			$self.find('.cff-author').eq(1).unwrap('p');
			$self.find('.cff-author').eq(1).remove();
		}
		$self.find('.cff-view-comments').eq(1).remove();

		//Expand post
		var	expanded = false,
			$post_text = $self.find('.cff-post-text .cff-text'),
			text_limit = $self.closest('#cff').attr('rel');
		if (typeof text_limit === 'undefined' || text_limit == '') text_limit = 99999;
		
		//If the text is linked then use the text within the link
		if ( $post_text.find('a.cff-post-text-link').length ) $post_text = $self.find('.cff-post-text .cff-text a');
		var	full_text = $post_text.html();
		if(full_text == undefined) full_text = '';
		var short_text = full_text.substring(0,text_limit);

		//If the short text cuts off in the middle of a <br> tag then remove the stray '<' which is displayed
		var lastChar = short_text.substr(short_text.length - 1);
		if(lastChar == '<') short_text = short_text.substring(0, short_text.length - 1);

		//Cut the text based on limits set
		$post_text.html( short_text );
		//Show the 'See More' link if needed
		if (full_text.length > text_limit) $self.find('.cff-expand').show();
		//Click function
		$self.find('.cff-expand a').unbind('click').bind('click', function(e){
			e.preventDefault();
			var $expand = jQuery(this),
				$more = $expand.find('.cff-more'),
				$less = $expand.find('.cff-less');
			if (expanded == false){
				$post_text.html( full_text );
				expanded = true;
				$more.hide();
				$less.show();
			} else {
				$post_text.html( short_text );
				expanded = false;
				$more.show();
				$less.hide();			
			}
		});


		//AJAX
		//Set the path to query.php
		var post_id = $self.attr('id'),
			url = cffsiteurl + "/custom-facebook-feed-pro/query.php?id=" + post_id;

		//If the file can be found then load in likes and comments
		if (locatefile == true){
			var $likesCountSpan = $self.find('.cff-likes .cff-count'),
				$commentsCountSpan = $self.find('.cff-comments .cff-count');

			//If the likes or comment counts are above 25 then replace them with the query.php values
			if( $likesCountSpan.find('.cff-replace').length ) $likesCountSpan.load(url + '&type=likes');
			if( $commentsCountSpan.find('.cff-replace').length ) $commentsCountSpan.load(url + '&type=comments');

			var $likesCount = $self.find('.cff-comment-likes .cff-comment-likes-count');
			if( $likesCount.length ) {
				$likesCount.load(url + '&type=likes', function(){
					$likesCount.text( $likesCount.text() -2 );
				});
			}
		} else {
			$self.find('.cff-replace').show();
			$self.find('.cff-loader').hide();
		}


		//Only show 4 latest comments
		var $showMoreComments = $self.find('.cff-show-more-comments'),
			$comment = $self.find('.cff-comment');

		if ( $showMoreComments.length ) {
			$comment.hide();
			var commentCount = $comment.length;
			//Show latest 4 comments
			$comment.slice(commentCount-4).show();
			//Show all on click
			$showMoreComments.unbind('click').bind('click', function(){
				$comment.show();
				jQuery(this).hide();
			});
		}


		//If a shared link image is 1x1 (after it's loaded) then hide it and add class (as php check for 1x1 doesn't always work)
		$self.find('.cff-link img').load(function() {
			var $cffSharedLink = $self.find('.cff-link');
			if( $cffSharedLink.find('img').width() < 2 ) {
				$cffSharedLink.hide().siblings('.cff-text-link').addClass('cff-no-image');
			}
		});


		if(cfflinkhashtags == 'true'){
			//Wrap hashtags
			var str = $self.find('.cff-text').html(),
				regex = /(?:\s|^)(?:#(?!\d+(?:\s|$)))(\w+)(?=\s|$)/gi,
				linkcolor = $self.find('.cff-text').attr('rel');

			function replacer(hash){
				var replacementString = $.trim(hash);
				return ' <a href="https://www.facebook.com/hashtag/'+ replacementString.substring(1) +'" target="_blank" style="color: #' + linkcolor + '">' + replacementString + '</a>';
			}
			$self.find('.cff-text').html( str.replace( regex , replacer ) );
		}


	});


	if( !$('#cff').hasClass('cff-disable-narrow') ){
		//Allow us to make some tweaks when the feed is narrow
		function cffCheckWidth(){
			var $cff = $('#cff');
			if( $cff.innerWidth() < 400 ){
				$cff.addClass('narrow');
			} else {
				$cff.removeClass('narrow');
			}
		}
		cffCheckWidth();

		//Only check the width once the resize event is over
		var cffdelay = (function(){
			var cfftimer = 0;
				return function(cffcallback, cffms){
				clearTimeout (cfftimer);
				cfftimer = setTimeout(cffcallback, cffms);
			};
		})();
		$(window).resize(function() {
		    cffdelay(function(){
		    	cffCheckWidth();
		    	cffResizeAlbum();
		    }, 500);
		});
	}



	//Albums only

	//Resize image height
	function cffResizeAlbum(){
		var cffAlbumWidth = $('.cff-album-item').eq(0).find('a').innerWidth();
		$('.cff-album-item a').css('height', cffAlbumWidth);
	}
	cffResizeAlbum();


})(jQuery);








/*!
imgLiquid v0.9.944 / 03-05-2013
https://github.com/karacas/imgLiquid
*/

var imgLiquid = imgLiquid || {VER: '0.9.944'};
imgLiquid.bgs_Available = false;
imgLiquid.bgs_CheckRunned = false;
imgLiquid.injectCss = '.cff-album-cover img {visibility:hidden}';


(function ($) {

	// ___________________________________________________________________

	function checkBgsIsavailable() {
		if (imgLiquid.bgs_CheckRunned) return;
		else imgLiquid.bgs_CheckRunned = true;

		var spanBgs = $('<span style="background-size:cover" />');
		$('body').append(spanBgs);

		!function () {
			var bgs_Check = spanBgs[0];
			if (!bgs_Check || !window.getComputedStyle) return;
			var compStyle = window.getComputedStyle(bgs_Check, null);
			if (!compStyle || !compStyle.backgroundSize) return;
			imgLiquid.bgs_Available = (compStyle.backgroundSize === 'cover');
		}();

		spanBgs.remove();
	}


	// ___________________________________________________________________

	$.fn.extend({
		imgLiquid: function (options) {

			this.defaults = {
				fill: true,
				verticalAlign: 'center',			//	'top'	//	'bottom' // '50%'  // '10%'
				horizontalAlign: 'center',			//	'left'	//	'right'  // '50%'  // '10%'
				useBackgroundSize: true,
				useDataHtmlAttr: true,

				responsive: true,					/* Only for use with BackgroundSize false (or old browsers) */
				delay: 0,							/* Only for use with BackgroundSize false (or old browsers) */
				fadeInTime: 0,						/* Only for use with BackgroundSize false (or old browsers) */
				removeBoxBackground: true,			/* Only for use with BackgroundSize false (or old browsers) */
				hardPixels: true,					/* Only for use with BackgroundSize false (or old browsers) */
				responsiveCheckTime: 500,			/* Only for use with BackgroundSize false (or old browsers) */ /* time to check div resize */
				timecheckvisibility: 500,			/* Only for use with BackgroundSize false (or old browsers) */ /* time to recheck if visible/loaded */

				// CALLBACKS
				onStart: null,						// no-params
				onFinish: null,						// no-params
				onItemStart: null,					// params: (index, container, img )
				onItemFinish: null,					// params: (index, container, img )
				onItemError: null					// params: (index, container, img )
			};


			checkBgsIsavailable();
			var imgLiquidRoot = this;

			// Extend global settings
			this.options = options;
			this.settings = $.extend({}, this.defaults, this.options);

			// CallBack
			if (this.settings.onStart) this.settings.onStart();


			// ___________________________________________________________________

			return this.each(function ($i) {

				// MAIN >> each for image

				var settings = imgLiquidRoot.settings,
				$imgBoxCont = $(this),
				$img = $('img:first',$imgBoxCont);
				if (!$img.length) {onError(); return;}


				// Extend settings
				if (!$img.data('imgLiquid_settings')) {
					// First time
					settings = $.extend({}, imgLiquidRoot.settings, getSettingsOverwrite());
				} else {
					// Recall
					// Remove Classes
					$imgBoxCont.removeClass('imgLiquid_error').removeClass('imgLiquid_ready');
					settings = $.extend({}, $img.data('imgLiquid_settings'), imgLiquidRoot.options);
				}
				$img.data('imgLiquid_settings', settings);


				// Start CallBack
				if (settings.onItemStart) settings.onItemStart($i, $imgBoxCont, $img); /* << CallBack */


				// Process
				if (imgLiquid.bgs_Available && settings.useBackgroundSize)
					processBgSize();
				else
					processOldMethod();


				// END MAIN <<

				// ___________________________________________________________________

				function processBgSize() {

					// Check change img src
					if ($imgBoxCont.css('background-image').indexOf(encodeURI($img.attr('src'))) === -1) {
						// Change
						$imgBoxCont.css({'background-image': 'url("' + encodeURI($img.attr('src')) + '")'});
					}

					$imgBoxCont.css({
						'background-size':		(settings.fill) ? 'cover' : 'contain',
						'background-position':	(settings.horizontalAlign + ' ' + settings.verticalAlign).toLowerCase(),
						'background-repeat':	'no-repeat'
					});

					$('a:first', $imgBoxCont).css({
						'display':	'block',
						'width':	'100%',
						'height':	'100%'
					});

					$('img', $imgBoxCont).css({'display': 'none'});

					if (settings.onItemFinish) settings.onItemFinish($i, $imgBoxCont, $img); /* << CallBack */

					$imgBoxCont.addClass('imgLiquid_bgSize');
					$imgBoxCont.addClass('imgLiquid_ready');
					checkFinish();
				}

				// ___________________________________________________________________

				function processOldMethod() {

					// Check change img src
					if ($img.data('oldSrc') && $img.data('oldSrc') !== $img.attr('src')) {

						/* Clone & Reset img */
						var $imgCopy = $img.clone().removeAttr('style');
						$imgCopy.data('imgLiquid_settings', $img.data('imgLiquid_settings'));
						$img.parent().prepend($imgCopy);
						$img.remove();
						$img = $imgCopy;
						$img[0].width = 0;

						// Bug ie with > if (!$img[0].complete && $img[0].width) onError();
						setTimeout(processOldMethod, 10);
						return;
					}


					// Reproceess?
					if ($img.data('imgLiquid_oldProcessed')) {
						makeOldProcess(); return;
					}


					// Set data
					$img.data('imgLiquid_oldProcessed', false);
					$img.data('oldSrc', $img.attr('src'));


					// Hide others images
					$('img:not(:first)', $imgBoxCont).css('display', 'none');


					// CSSs
					$imgBoxCont.css({'overflow': 'hidden'});
					$img.fadeTo(0, 0).removeAttr('width').removeAttr('height').css({
						'visibility': 'visible',
						'max-width': 'none',
						'max-height': 'none',
						'width': 'auto',
						'height': 'auto',
						'display': 'block'
					});


					// CheckErrors
					$img.on('error', onError);
					$img[0].onerror = onError;


					// loop until load
					function onLoad() {
						if ($img.data('imgLiquid_error') || $img.data('imgLiquid_loaded') || $img.data('imgLiquid_oldProcessed')) return;
						if ($imgBoxCont.is(':visible') && $img[0].complete && $img[0].width > 0 && $img[0].height > 0) {
							$img.data('imgLiquid_loaded', true);
							setTimeout(makeOldProcess, $i * settings.delay);
						} else {
							setTimeout(onLoad, settings.timecheckvisibility);
						}
					}


					onLoad();
					checkResponsive();
				}

				// ___________________________________________________________________

				function checkResponsive() {

					/* Only for oldProcessed method (background-size dont need) */

					if (!settings.responsive && !$img.data('imgLiquid_oldProcessed')) return;
					if (!$img.data('imgLiquid_settings')) return;

					settings = $img.data('imgLiquid_settings');

					$imgBoxCont.actualSize = $imgBoxCont.get(0).offsetWidth + ($imgBoxCont.get(0).offsetHeight / 10000);
					if ($imgBoxCont.sizeOld && $imgBoxCont.actualSize !== $imgBoxCont.sizeOld) makeOldProcess();

					$imgBoxCont.sizeOld = $imgBoxCont.actualSize;
					setTimeout(checkResponsive, settings.responsiveCheckTime);
				}

				// ___________________________________________________________________

				function onError() {
					$img.data('imgLiquid_error', true);
					$imgBoxCont.addClass('imgLiquid_error');
					if (settings.onItemError) settings.onItemError($i, $imgBoxCont, $img); /* << CallBack */
					checkFinish();
				}

				// ___________________________________________________________________

				function getSettingsOverwrite() {
					var SettingsOverwrite = {};

					if (imgLiquidRoot.settings.useDataHtmlAttr) {
						var dif = $imgBoxCont.attr('data-imgLiquid-fill'),
						ha =  $imgBoxCont.attr('data-imgLiquid-horizontalAlign'),
						va =  $imgBoxCont.attr('data-imgLiquid-verticalAlign');

						if (dif === 'true' || dif === 'false') SettingsOverwrite.fill = Boolean (dif === 'true');
						if (ha !== undefined && (ha === 'left' || ha === 'center' || ha === 'right' || ha.indexOf('%') !== -1)) SettingsOverwrite.horizontalAlign = ha;
						if (va !== undefined && (va === 'top' ||  va === 'bottom' || va === 'center' || va.indexOf('%') !== -1)) SettingsOverwrite.verticalAlign = va;
					}

					if (imgLiquid.isIE && imgLiquidRoot.settings.ieFadeInDisabled) SettingsOverwrite.fadeInTime = 0; //ie no anims
					return SettingsOverwrite;
				}

				// ___________________________________________________________________

				function makeOldProcess() { /* Only for old browsers, or useBackgroundSize seted false */

					// Calculate size
					var w, h, wn, hn, ha, va, hdif, vdif,
					margT = 0,
					margL = 0,
					$imgCW = $imgBoxCont.width(),
					$imgCH = $imgBoxCont.height();


					// Save original sizes
					if ($img.data('owidth')	=== undefined) $img.data('owidth',	$img[0].width);
					if ($img.data('oheight') === undefined) $img.data('oheight', $img[0].height);


					// Compare ratio
					if (settings.fill === ($imgCW / $imgCH) >= ($img.data('owidth') / $img.data('oheight'))) {
						w = '100%';
						h = 'auto';
						wn = Math.floor($imgCW);
						hn = Math.floor($imgCW * ($img.data('oheight') / $img.data('owidth')));
					} else {
						w = 'auto';
						h = '100%';
						wn = Math.floor($imgCH * ($img.data('owidth') / $img.data('oheight')));
						hn = Math.floor($imgCH);
					}

					// Align X
					ha = settings.horizontalAlign.toLowerCase();
					hdif = $imgCW - wn;
					if (ha === 'left') margL = 0;
					if (ha === 'center') margL = hdif * 0.5;
					if (ha === 'right') margL = hdif;
					if (ha.indexOf('%') !== -1){
						ha = parseInt (ha.replace('%',''), 10);
						if (ha > 0) margL = hdif * ha * 0.01;
					}


					// Align Y
					va = settings.verticalAlign.toLowerCase();
					vdif = $imgCH - hn;
					if (va === 'left') margT = 0;
					if (va === 'center') margT = vdif * 0.5;
					if (va === 'bottom') margT = vdif;
					if (va.indexOf('%') !== -1){
						va = parseInt (va.replace('%',''), 10);
						if (va > 0) margT = vdif * va * 0.01;
					}


					// Add Css
					if (settings.hardPixels) {w = wn; h = hn;}
					$img.css({
						'width': w,
						'height': h,
						'margin-left': Math.floor(margL),
						'margin-top': Math.floor(margT)
					});


					// FadeIn > Only first time
					if (!$img.data('imgLiquid_oldProcessed')) {
						$img.fadeTo(settings.fadeInTime, 1);
						$img.data('imgLiquid_oldProcessed', true);
						if (settings.removeBoxBackground) $imgBoxCont.css('background-image', 'none');
						$imgBoxCont.addClass('imgLiquid_nobgSize');
						$imgBoxCont.addClass('imgLiquid_ready');
					}


					if (settings.onItemFinish) settings.onItemFinish($i, $imgBoxCont, $img); /* << CallBack */
					checkFinish();
				}

				// ___________________________________________________________________

				function checkFinish() { /* Check callBack */
					if ($i === imgLiquidRoot.length - 1) if (imgLiquidRoot.settings.onFinish) imgLiquidRoot.settings.onFinish();
				}


			});
		}
	});
})(jQuery);


// Inject css styles ______________________________________________________
!function () {
	var css = imgLiquid.injectCss,
	head = document.getElementsByTagName('head')[0],
	style = document.createElement('style');
	style.type = 'text/css';
	if (style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		style.appendChild(document.createTextNode(css));
	}
	head.appendChild(style);
}();


jQuery(".cff-album-cover").imgLiquid({fill:true});