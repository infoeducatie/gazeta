
jQuery(document).ready(function($)
	{
		
		
		$(document).on('click', '.team-popup-box', function()
			{	
				$('.team-popup-box').fadeOut();
				$('.team-slide').fadeOut();
				
			})			
		
		
		$(document).on('click', '.team-popup', function()
			{	
			
				var teamid = $(this).attr('teamid');
				$('.team-popup-box-'+teamid).fadeIn();
				$('.team-slide-'+teamid).css("display",'inline-block');

				
			})	
		
		
		$(document).on('click', '.team_member_social_icon', function()
			{	
			var team_member_social_icon = prompt("Please insert icon url","");
			if(team_member_social_icon != null)
				{
					var icon_name = $(this).attr("icon-name");	
							
					$(this).css("background-image",'url('+team_member_social_icon+')');
						
					$(".team_member_social_icon_"+icon_name).val(team_member_social_icon);
				}



			})
			
			
			
		$(document).on('click', '.remove_icon', function()
			{	
				if (confirm('Do you really want to delete this field ?')) {
					
					$(this).parent().parent().remove();
				}
			})			
			
			
				
		
		$(document).on('click', '.team_content_source', function()
			{	
				var source = $(this).val();
				var source_id = $(this).attr("id");
				
				$(".content-source-box.active").removeClass("active");
				$(".content-source-box."+source_id).addClass("active");

			})
			
			
		$(document).on('click', '.new_team_member_social_field', function()
			{
				var user_profile_social = prompt("Please add new social site","");
				
				if(user_profile_social != null && user_profile_social != '')
					{
						$(".team_member_social_field").append('<tr><td><input type="text" name="team_member_social_field['+user_profile_social+']" value="'+user_profile_social+'"  /></td><td><span class="remove_icon">X</span></td></tr>');
					}

		
			})
			
			
			
	
			
			
			
			

	});	
