<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 

    $team_version = get_option('team_version');
	$team_member_social_field = get_option( 'team_member_social_field' );


	if(empty($team_member_social_field))
		{
			$team_member_social_field =		array(
												"facebook"=>"facebook",						
												"twitter"=>"twitter",						
												"googleplus"=>"googleplus",
												"pinterest"=>"pinterest",												
												
												);	
		}
		
	$team_member_social_field_new_field =		array(
										"website"=>"website",						
										"email"=>"email",						
										"skype"=>"skype",
										"mobile"=>"mobile",									
										);
	
	
	$team_member_social_field = array_merge($team_member_social_field,$team_member_social_field_new_field);
	update_option('team_member_social_field', $team_member_social_field);
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(team_plugin_name.' Update', 'team')."</h2>";?>


    <div class="para-settings team-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Update</li>         
        </ul> <!-- tab-nav end --> 
		<ul class="box">
       		<li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title">Things has updated</p>
                    <p class="option-info">New things come with version <?php echo $team_version['current']; ?> your old version is <?php echo $team_version['previous']; ?>,
                    <br />
                    # you will see new profile fields at settigns page email, skype, website & mobile.<br />
                    
                    # And no longer team member static(variable) values for email, skype, website under "team_member" post type these are merge with dynamic field which come from setting page.
                    </p>
                    <p>Above things already updated by visiting this page, you no longer visit this page again.
                    </p>
                    
                    <?php
                    
					
					if($team_version['previous'] <= '1.4')
						{
							global $wp_query;
							
							
							$team_posttype = 'team_member';
							
							$wp_query = new WP_Query(
								array (
									'post_type' => $team_posttype,
									'order' => 'DESC'
									
									) );
					
							if ( $wp_query->have_posts() ) :
								while ( $wp_query->have_posts() ) : $wp_query->the_post();
								
									$team_member_website = get_post_meta( get_the_ID(), 'team_member_website', true );	
									$team_member_email = get_post_meta( get_the_ID(), 'team_member_email', true );
									$team_member_skype = get_post_meta( get_the_ID(), 'team_member_skype', true );	
									$team_member_social_links = get_post_meta( get_the_ID(), 'team_member_social_links', true );
									
									
									$team_member_social_links['website'] = $team_member_website;
									$team_member_social_links['email'] = $team_member_email;
									$team_member_social_links['skype'] = $team_member_skype;				
													
									
									update_post_meta(get_the_ID(), 'team_member_social_links', $team_member_social_links );
							
								endwhile;
								wp_reset_query();
							
							endif;
							
							
							
							update_option('team_version_ok', 'ok');
						}
					
					

					
					
					
					
					
					?>
                    
                    
                    
                    
                    
                    
                    
                </div>

            
            </li>
                        
                        
        </ul>
    
    
		

        
    </div>



</div>
