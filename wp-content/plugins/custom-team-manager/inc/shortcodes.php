<?php
//shortcode for team-members page
function ibn_custom_team_members($atts, $content = null) {
	extract(shortcode_atts(array(
		'num-cols' => 4,
		'pageid' => '',
		'category' => '',
		), $atts));

		// return string
	$team_members_output = '';
	$team_members_output = '<div id="id-cmt-wrapper" class="cmt-wrapper mobile">
		<div class="cmt-members">'; 
		if( !empty($content) ) { 
			$team_members_output .= '<header class="cmt-header">
					<h1 class="cmt-title">'. $content .'</h1>
			</header>';
		} 

		$mem_per_page = get_option( 'cmt_mem_per_page' );

		if(!empty($mem_per_page)){ $per_page = $mem_per_page; } else{ $per_page = -1; }
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if( $category != ''){
			$args = array(
				'post_type' => 'cmt-management-team',
				'tax_query' => array(
					array(
						'taxonomy' => 'cmt-team-category',
						'field'    => 'name',
						'terms'    => $category,
					)
				),
				'posts_per_page' => $per_page,
				'paged' => $paged
			);
		}else{
			$args = array(
				'post_type' => 'cmt-management-team',
				'posts_per_page' => $per_page,
				'paged' => $paged
			);
		}
		//query_posts( $args );
		$query = new WP_Query( $args );
		
 
		if( $query -> have_posts() ) {
			$loop = 1;
			$column = 4;
			$lastcolumn = 3;
		while( $query -> have_posts() ) {	$query -> the_post();
		 
			if($loop%2!=0 && $loop !=1) { $cls=" clearPad"; }
			else{ $cls=""; }
			if($loop == $column){ $cls.=" firstCol"; $column=$column + 3; }								
			if($loop == $lastcolumn){ $cls.=" lastCol"; $lastcolumn=$lastcolumn + 3; }								
		$team_members_output .= '
		<div class="col-one-fourth'. $cls .'">';
			
			// check if single page or not
			$profile_single = get_option( 'cmt_single_page' );
			
			
			if($profile_single == 0){  // is not single page
				$profile_link = get_post_permalink();
			}else{	// is single page.
				//which page to show profiles.

				if($pageid) {
					//$cmt_profile_page = $pageid;
					$page_slug = get_permalink( $pageid, false );
				}
				else{
					$cmt_profile_page = get_option( 'cmt_profile_page' );
					$page_slug = get_permalink( $cmt_profile_page['page_id'], false );
				}
				$name = get_the_title();
				$link = preg_replace('/\s+/', '-', $name); 
				
				
				$profile_link = $page_slug.'#'.$link;
				
		
			}
			
			if( has_post_thumbnail() ){ 
				$team_members_output .= '<a href="'. $profile_link .'">'.get_the_post_thumbnail(get_the_ID(), 'full') .'</a>';
			}
			$team_members_output .= '<a href="'. $profile_link .'"><h4 class="cmt-name">'.get_the_title() .'</h4></a>';
			
			$role = get_post_meta( get_the_ID(), 'cmt_member_role', true );
			if($role){
				$team_members_output .= '
				<p><strong><em>'. $role .'</em></strong></p>';
			}
			$gridview = get_option( 'cmt_show_gridview' );
			if( !$gridview ) { 
				$team_members_output .= '<p>'.get_the_excerpt().'</p><a class="cmt-full-profile" href="'.$profile_link .'">Full Profile ...</a>';
			}
		$team_members_output .= '</div>';
			
		$loop++;
		}	// endwhile - of the loop
		$team_members_output .= '<div class="clear"></div>';

		if(!get_option( 'cmt_ajax_load' )){ cmt_team_members_nav(); } 
		
/**
 * Load More members with AJAX if cmt_ajax_load is true
 */
 
	$ajax_load_result = get_option( 'cmt_ajax_load' );

	if($ajax_load_result){

 	// Add code to index pages.  && $post_type == 'cmt-management-team'
		if( !is_admin()  ) {	
			// Queue JS and CSS
			wp_enqueue_script(
				'cmt-load-more-members',
				plugin_dir_url( dirname(__FILE__)  ) . 'js/cmt-load-more-members.js',
				array('jquery'),
				CMT_VERSION,
				true
			);
		
			$count_posts = wp_count_posts('cmt-management-team');
			$published_posts = $count_posts->publish; 		
			// What page are we on? And what is the pages limit?

			$mem_per_page = get_option( 'cmt_mem_per_page' );
			$max = 0;
			if(!empty($mem_per_page)){
				$max = $published_posts / $mem_per_page;
				if($published_posts % $mem_per_page != 0) { $max = $max + 1; }
			}
			$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
			
			// Add some parameters for the JS.
			wp_localize_script(
				'cmt-load-more-members',
				'cmt_data',
				array(
					'startPage' => $paged,
					'maxPages' => $max,
					'nextLink' => next_posts($max, false)
				)
			);
		}
	}
		}else{	// end if
			$team_members_output = 'There is no member added yet. Please add members through Management Team on Dashboard';
		} 	
		
		wp_reset_postdata(); 
		
		$team_members_output .= '</div>
	</div>';
	return $team_members_output;
} 	// END function
function register_shortcodes(){
   add_shortcode('team-members', 'ibn_custom_team_members');
}
add_action( 'init', 'register_shortcodes');


//shortcode for team-members-profile page
function ibn_custom_team_members_profile($atts, $content = null) {
	extract(shortcode_atts(array(
		'num_cols' => 4,
		'category'	=> '',
		), $atts));

	$team_members_output = '';
	$team_members_output .= '<div id="id-cmt-wrapper" class="cmt-wrapper">
	<div id="cmt-content">';
		if( !empty($content) ) { 
			$team_members_output .= '<header class="cmt-header">
					<h1 class="cmt-title">'. $content .'</h1>
			</header>';
		}
		$team_members_output .= '<div id="cmt-profile-content">';
		
		$mem_per_page = get_option( 'cmt_mem_per_page' );

		if(!empty($mem_per_page)){ $per_page = $mem_per_page; } else{ $per_page = -1; }
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		if( $category != ''){
			$args = array(
				'post_type' => 'cmt-management-team',
				'tax_query' => array(
					array(
						'taxonomy' => 'cmt-team-category',
						'field'    => 'name',
						'terms'    => $category,
					)
				),
				'posts_per_page' => $per_page,
				'paged' => $paged
			);
		}else{
			$args = array(
				'post_type' => 'cmt-management-team',
				'posts_per_page' => $per_page,
				'paged' => $paged
			);
		}
		//query_posts( $args );
		$query = new WP_Query( $args );
		if( $query -> have_posts() ) {
			$loop = 1;
			$column = 1;
			while( $query -> have_posts() ) {  $query -> the_post();
		
		
				$name = get_the_title(); 
				$link = preg_replace('/\s+/', '-', $name); 
			
				$team_members_output .= '<div id="'. $link .'" class="cmt_profile">';
				if( has_post_thumbnail() ){
					$team_members_output .= '<div class="cmt_profile_pic">'.
						get_the_post_thumbnail(get_the_ID(), 'full alignleft').'
					</div>';
				}
				$team_members_output .= '
				<strong><span style="display: block; padding-top: 5px;">'. get_the_title() .'</span></strong>';
				$role = get_post_meta( get_the_ID(), 'cmt_member_role', true );
				if($role){
					$team_members_output .= '
					<p><strong><em>'. $role .'</em></strong></p>';
				}
				
				$team_members_output .= '<p>'. get_the_content() .'</p>
				<div class="clear"></div>';
				
					//Show member's facebook
				$facebook = get_post_meta( get_the_ID() , 'cmt_member_facebook', true );					  
				if( !empty($facebook) ){  
					$team_members_output .= '<a target="_blank" title="Facebook Profile" href="'.$facebook .'"><img class="cmt-social" src="'. plugins_url( 'images/facebook.png', dirname(__FILE__)  ) .'" alt="" width="40" height="40" border="0" /></a>';
				}
					//Show member's twitter
				$twitter = get_post_meta( get_the_ID() , 'cmt_member_twitter', true );					  
				if( !empty($twitter) ){  
					$team_members_output .= '<a target="_blank" title="Twitter Profile" href="'. $twitter .'"><img class="cmt-social" src="'. plugins_url( 'images/twitter.png', dirname(__FILE__)  ) .'" alt="" width="40" height="40" border="0" /></a>';
				
				}
					//Show member's linkedin
				$linkedin = get_post_meta( get_the_ID() , 'cmt_member_linkedin', true );					  
				if( !empty($linkedin) ){  
					$team_members_output .= '<a target="_blank" title="LinkedIn Profile" href="'. $linkedin .'"><img class="cmt-social" src="'. plugins_url( 'images/linkedin.png', dirname(__FILE__)  ) .'" alt="" width="40" height="40" border="0" /></a>';
				
				}
				$team_members_output .= '</div>
				<div class="clear"></div>';
			}	// end of the loop. 
		}else{	// end if
			$team_members_output .= 'There is no member added yet. Please add members through Management Team on Dashboard.';
		} 	
		wp_reset_postdata(); 
		$team_members_output .= '</div>				
	</div>
</div>';

	return $team_members_output;
}	// END function
function register_shortcodes_members_profile(){
   add_shortcode('team-members-profile', 'ibn_custom_team_members_profile');
}
add_action( 'init', 'register_shortcodes_members_profile');

// to show some content
function cmt_content_func( $atts, $content="" ) {
    return $content;
}
add_shortcode( 'cmt-content', 'cmt_content_func' );

?>