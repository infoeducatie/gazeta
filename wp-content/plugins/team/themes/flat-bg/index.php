<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

function team_body_flat_bg($post_id)
	{
		
		$team_member_social_icon = get_option( 'team_member_social_icon' );	

		$team_bg_img = get_post_meta( $post_id, 'team_bg_img', true );
		
		$team_themes = get_post_meta( $post_id, 'team_themes', true );
		$team_masonry_enable = get_post_meta( $post_id, 'team_masonry_enable', true );
		
		$team_grid_item_align = get_post_meta( $post_id, 'team_grid_item_align', true );		
		$team_item_text_align = get_post_meta( $post_id, 'team_item_text_align', true );
	
		$team_total_items = get_post_meta( $post_id, 'team_total_items', true );		
		$team_pagination_display = get_post_meta( $post_id, 'team_pagination_display', true );

		$team_content_source = get_post_meta( $post_id, 'team_content_source', true );
		$team_content_year = get_post_meta( $post_id, 'team_content_year', true );
		$team_content_month = get_post_meta( $post_id, 'team_content_month', true );
		$team_content_month_year = get_post_meta( $post_id, 'team_content_month_year', true );
		
		$team_taxonomy = 'team_group';
		$team_taxonomy_category = get_post_meta( $post_id, 'team_taxonomy_category', true );	
		
		$team_posttype = 'team_member';

		$team_post_ids = get_post_meta( $post_id, 'team_post_ids', true );

		$team_items_title_color = get_post_meta( $post_id, 'team_items_title_color', true );			
		$team_items_title_font_size = get_post_meta( $post_id, 'team_items_title_font_size', true );		

		$team_items_position_color = get_post_meta( $post_id, 'team_items_position_color', true );
		$team_items_position_font_size = get_post_meta( $post_id, 'team_items_position_font_size', true );

		$team_items_content = get_post_meta( $post_id, 'team_items_content', true );
		$team_items_content_color = get_post_meta( $post_id, 'team_items_content_color', true );
		$team_items_content_font_size = get_post_meta( $post_id, 'team_items_content_font_size', true );

		$team_items_excerpt_count = get_post_meta( $post_id, 'team_items_excerpt_count', true );		
		$team_items_excerpt_text = get_post_meta( $post_id, 'team_items_excerpt_text', true );	

		$team_items_thumb_size = get_post_meta( $post_id, 'team_items_thumb_size', true );
		$team_items_link_to_post = get_post_meta( $post_id, 'team_items_link_to_post', true );		
		$team_items_max_width = get_post_meta( $post_id, 'team_items_max_width', true );		
		$team_items_thumb_max_hieght = get_post_meta( $post_id, 'team_items_thumb_max_hieght', true );
		
		$team_items_margin = get_post_meta( $post_id, 'team_items_margin', true );

		$team_items_social_icon_width = get_post_meta( $post_id, 'team_items_social_icon_width', true );		
		$team_items_social_icon_height = get_post_meta( $post_id, 'team_items_social_icon_height', true );
		
		$team_items_custom_css = get_post_meta( $post_id, 'team_items_custom_css', true );		
		

		$team_items_popup_content = get_post_meta( $post_id, 'team_items_popup_content', true );
		$team_items_popup_excerpt_count = get_post_meta( $post_id, 'team_items_popup_excerpt_count', true );
		$team_items_popup_excerpt_text = get_post_meta( $post_id, 'team_items_popup_excerpt_text', true );

		if(!isset($team_content_source)){
				$team_content_source = 'latest';
			}

		if(!isset($team_items_content)){
				$team_items_content = 'excerpt';
			}
	
		if(!isset($team_items_excerpt_count)){
				$team_items_excerpt_count = 30;
			}	
	
		if(!isset($team_items_excerpt_text)){
				$team_items_excerpt_text = 'Read More';
			}	
				
				
	
		if ( get_query_var('paged') ) {
		
			$paged = get_query_var('paged');
		
		} elseif ( get_query_var('page') ) {
		
			$paged = get_query_var('page');
		
		} else {
		
			$paged = 1;
		
		}	
				
				
		$team_body = '';
		$team_body = '<style type="text/css"></style>';
		
		
		
		$team_body .= '
		<div  class="team-container" style="background-image:url('.$team_bg_img.');text-align:'.$team_grid_item_align.';">
		<ul  id="team-'.$post_id.'" class="team-items team-'.$team_themes.'">';
		
		global $wp_query;
		


		
		if(($team_content_source=="latest"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $team_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $team_total_items,
						'paged' => $paged,
						
						) );
			
			
			}		
		
		elseif(($team_content_source=="older"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $team_posttype,
						'orderby' => 'date',
						'order' => 'ASC',
						'posts_per_page' => $team_total_items,
						'paged' => $paged,
						
						) );

			}		

		elseif(($team_content_source=="year"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $team_posttype,
						'year' => $team_content_year,
						'posts_per_page' => $team_total_items,
						'paged' => $paged,
						) );

			}

		elseif(($team_content_source=="month"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $team_posttype,
						'year' => $team_content_month_year,
						'monthnum' => $team_content_month,
						'posts_per_page' => $team_total_items,
						'paged' => $paged,
						
						) );

			}

		else
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $team_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $team_total_items,
						'paged' => $paged,
						
						) );
			
			
			}

								
		
		if ( $wp_query->have_posts() ) :
		
		
		
		$i=0;
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		$team_member_position = get_post_meta(get_the_ID(), 'team_member_position', true );
		$team_member_social_links = get_post_meta( get_the_ID(), 'team_member_social_links', true );	
		
		$team_member_link_to_post = get_post_meta( get_the_ID(), 'team_member_link_to_post', true );
	
		$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_thumb_size );
		$team_thumb_url = $team_thumb['0'];
		
		
		
		
		if($i%2==0)
			{
				$even_odd = "even";
			}
		else
			{
				$even_odd = "odd";
			}
			
			
		
		$team_body.= '<li style="width:'.$team_items_max_width.';text-align:'.$team_item_text_align.';margin:'.$team_items_margin.'" class="team-item '.$even_odd.'" >';
		$team_body.= '<div class="team-post">';		
		
		
		if(!empty($team_thumb_url))
			{
			$team_body.= '<div style="height:'.$team_items_thumb_max_hieght.';" class="team-thumb">';
			
			if($team_items_link_to_post == 'yes')
				{
				$team_body.= '<a href="'.get_permalink(get_the_ID()).'"><img src="'.$team_thumb_url.'" /></a>';
				}
			else if($team_items_link_to_post == 'custom')
				{
					if(!empty($team_member_link_to_post))
						{
						$team_body.= '<a href="'.$team_member_link_to_post.'"><img src="'.$team_thumb_url.'" /></a>';
						}
					else
						{
						$team_body.= '<a href="#"><img src="'.$team_thumb_url.'" /></a>';
						}
					
				}
			else if($team_items_link_to_post == 'popup')
				{
					$team_body.= '<img teamid="'.get_the_ID().'" class="team-popup" src="'.$team_thumb_url.'" />';
					
				}
				
			else
				{
				$team_body.= '<img src="'.$team_thumb_url.'" />';
				}
			$team_body.= '</div>';
			}


		if($team_items_link_to_post == 'yes')
			{
			$team_body.= '<a href="'.get_permalink(get_the_ID()).'"><div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.get_the_title().'
			</div></a>';
			}
		else if($team_items_link_to_post == 'custom')
			{
		
			if(!empty($team_member_link_to_post))
				{
				$team_body.= '<a href="'.$team_member_link_to_post.'"><div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.get_the_title().'
			</div></a>';
				}
			else
				{
				$team_body.= '<a href="#"><div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.get_the_title().'
			</div></a>';
				}
			}
			
		else if($team_items_link_to_post == 'popup')
			{
				
				$team_body.= '<div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.get_the_title().'
			</div>';
				
				
			$content = apply_filters('the_content', get_the_content());
			
			
			if($team_items_popup_content=='full')
				{
					$popup_content = $content;
				}
			elseif($team_items_popup_content=='excerpt')
				{
					$popup_content = wp_trim_words( $content , $team_items_popup_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_popup_excerpt_text.'</a>' );
				}
				
				
				
				$team_body .= '<div class="team-popup-box team-popup-box-'.get_the_ID().'">';	
				$team_body.= '<div class="team-slide team-slide-'.get_the_ID().'">';	
				$team_body.= '<div class="team-slide-thumb "><img src="'.$team_thumb_url.'" /></div>';
				$team_body.= '<div class="team-slide-content"><span class="team-slide-title">'.get_the_title().'</span><span class="team-slide-position">'.$team_member_position.'</span><hr />'.$popup_content.'</div>';
				$team_body .= '</div>';	
				$team_body .= '</div>';	
			}
			
			
		else
			{
			$team_body.= '<div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.get_the_title().'
			</div>';
			}
			
			if(!empty($team_member_position))
				{
					$team_body.= '<div class="team-position" style="color:'.$team_items_position_color.';font-size:'.$team_items_position_font_size.'">'.$team_member_position.'
					</div>';
				}

			
			$team_body.= '<div class="team-social" >';
			
			
			$team_member_social_field = get_option( 'team_member_social_field' );
			
			if(empty($team_member_social_field))
				{
					$team_member_social_field = array("skype"=>"skype","email"=>"email","website"=>"website", "facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");
					
				}
			
			
            foreach ($team_member_social_field as $value) {
                if(!empty($value) && !empty($team_member_social_links[$value]))
                    {
						
						if(!empty($team_member_social_icon[$value]))
							{
							$icon_bg = 'style="background-image:url('.$team_member_social_icon[$value].')"';
							}
						else
							{
							$icon_bg = '';
							}
						
						
						
					if($value == 'website')
						{
							$team_body.= '<span '.$icon_bg.' class="website">
								<a target="_blank" href="'.$team_member_social_links[$value].'"></a>
							</span>';
						}
					elseif($value == 'email')
						{
							$team_body.= '<span '.$icon_bg.' class="email">
								<a target="_blank" href="mailto:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
					elseif($value == 'skype')
						{
							$team_body.= '<span '.$icon_bg.' class="skype">
								<a  title="'.$value.'" target="_blank" href="skype:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
					elseif($value == 'mobile')
						{
							$team_body.= '<span '.$icon_bg.' class="mobile">
								<a  title="'.$value.'" target="_blank" href="tel:'.$team_member_social_links[$value].'"></a>
							</span>';
						}
						
						
					else
						{
							$team_body.= '<span '.$icon_bg.' class="'.$value.'" >
								<a target="_blank" href="'.$team_member_social_links[$value].'"> </a>
							</span>';
						}					
						

                    
                    }
            }

			$team_body.= '</div>';
			
			
			
			$team_body.= '<div class="team-content" style="color:'.$team_items_content_color.';font-size:'.$team_items_content_font_size.';">';
				
			
			$content = apply_filters('the_content', get_the_content());
			
			
			if($team_items_content=='full')
				{
					$team_body.= $content;
				}
			elseif($team_items_content=='excerpt')
				{
					$team_body.= wp_trim_words( $content , $team_items_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );
				}			
			$team_body.= '</div>';
			
			$team_body.= '</div>

		</li>';
		
		
		$i++;
		
		endwhile;
		
		
		
		$team_body .= '</ul>';
				

		
		
		
		
		
		wp_reset_query();
		endif;
		

			
		$team_body .= '</div>';
		
		if($team_masonry_enable == 'yes' )
			{
				$team_body .= '<script>
					jQuery(document).ready(function($) {
					  var container = document.querySelector(".team-items");
					  var msnry = new Masonry( container, {isFitWidth: true
					
					  });
					});
					</script>';		

				// masonry css to center align
				$team_body .= '<style type="text/css">
				
						.team-items {
						  margin: 0 auto !important;
						}
						</style>
						';
			}

		
		if(!empty($team_items_social_icon_width) || !empty($team_items_social_icon_height))
			{
				$team_body .= '<style type="text/css">
				
						#team-'.$post_id.' .team-social span {
						  width: '.$team_items_social_icon_width.' !important;
						  height:'.$team_items_social_icon_height.' !important;
						}
						</style>
						';	
			}
			
		if(!empty($team_items_custom_css))
			{
				$team_body .= '<style type="text/css">'.$team_items_custom_css.'</style>
						';	
			}
			
		
		return $team_body;

		
	}