jQuery(document).ready(function($) {


	//change opacity on hover
	$('.cmt-members .col-one-fourth').hover(function(){
		$('.col-one-fourth').css('opacity', '0.45');
		$(this).css('opacity', '1.0');
	},function(){
		$('.col-one-fourth').css('opacity', '1.0');
	});

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(cmt_data.startPage) + 1;

	// The maximum number of pages the current query can return.
	var max = parseInt(cmt_data.maxPages);
		
	// The link of the next page of members.
	var nextLink = cmt_data.nextLink;

	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new members to load.
	 */
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('.cmt-members')
			.append('<div id="cmt-newpage" class="cmt-nav-placeholder-'+ pageNum +'"></div>')
			.append('<p id="cmt-load-members"><a href="#">Load More Members</a></p>');
			
		// Remove the traditional navigation.
		$('.members-navigation').remove();
	}
	
	
	/**
	 * Load more when the link is clicked.
	 */
	$('#cmt-load-members a').click(function() {
	
		// Are there more Members to load?
		if(pageNum <= max) {
		
			// Show that we're working.
			$(this).text('Loading Members...');
			
			$('.cmt-nav-placeholder-'+ pageNum).load(nextLink + ' .cmt-members',
				function() {
				
				    var target = $('.cmt-nav-placeholder-'+ pageNum);
	
					if( target.length ) {
						//event.preventDefault();
						$('html, body').animate({
							scrollTop: target.offset().top - 50
						}, 500);
					}
					
					// Update page number and nextLink.
					pageNum++;
					nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
										
					// Update the button message.
					if(pageNum <= max) {
						// Add a new placeholder, for when user clicks again.
						$('#cmt-load-members')
						.before('<div class="cmt-nav-placeholder-'+ pageNum +'"></div>')
						$('#cmt-load-members a').text('Load More Members');
					} else {
						$('#cmt-load-members a').text('No more Members to load.');
					}
				}
			);
		} else {
			$('#cmt-load-members a').append('.');
		}	
		
		return false;
	});
});