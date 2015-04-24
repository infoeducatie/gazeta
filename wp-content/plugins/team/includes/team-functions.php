<?php


if ( ! defined('ABSPATH')) exit; // if direct access 

add_theme_support('post-thumbnails', array('team_member'));











function team_dark_color($input_color)
	{
		if(empty($input_color))
			{
				return "";
			}
		else
			{
				$input = $input_color;
			  
				$col = Array(
					hexdec(substr($input,1,2)),
					hexdec(substr($input,3,2)),
					hexdec(substr($input,5,2))
				);
				$darker = Array(
					$col[0]/2,
					$col[1]/2,
					$col[2]/2
				);
		
				return "#".sprintf("%02X%02X%02X", $darker[0], $darker[1], $darker[2]);
			}

		
		
	}
	
	
	
	
	
	
	
	function team_share_plugin()
		{
			
			?>
			<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwordpress.org%2Fplugins%2Fteam%2F&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=652982311485932" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>
            
            <br />
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo team_share_url; ?>"></div>
            
            <br />
            <br />
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo team_share_url; ?>" data-text="<?php echo team_plugin_name; ?>" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



            <?php
			
			
			
		
		
		}
		

	
	function team_admin_notices()
		{
			$team_version_ok = get_option('team_version_ok');
			
			$html= '';
			
			
			
			if($team_version_ok != 'ok')
				{
					$admin_url = get_admin_url();
					
					$html.= '<div class="update-nag">';
					$html.= 'Things has been changed please click to update <b>'.team_plugin_name.' &raquo; <a href="'.$admin_url.'edit.php?post_type=team&page=team_menu_update">Update Settings</a></b>';
					$html.= '</div>';	
				}
			else
				{

				}

			echo $html;
		}
	
	add_action('admin_notices', 'team_admin_notices');
