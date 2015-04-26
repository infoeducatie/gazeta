<?php function easy_team_manager_desc_create(){ 
	if(isset($_POST['insert'])){
	require_once(ABSPATH . 'wp-admin/includes/image.php');
		$ind_name = mysql_real_escape_string($_POST["ind_name"]);
		$sh_name = mysql_real_escape_string($_POST['sh_name']);
		$ind_name_detail = array('name'=>$ind_name,'sh'=>$sh_name);
		$ind_position = sanitize_text_field($_POST['ind_position']);
		$ind_url = sanitize_text_field($_POST['p_num']);
		$priority = sanitize_text_field($_POST['p_num']);
		
		$mb_email = sanitize_email(mysql_real_escape_string($_POST['mb_email']));
		$sh_email = mysql_real_escape_string($_POST['sh_email']);
		$ind_email_detail = array('email'=>$mb_email,'sh'=>$sh_email);
				
		$mb_phone=mysql_real_escape_string($_POST['mb_phone']);
		$sh_phone = mysql_real_escape_string($_POST['sh_phone']);
		$ind_phone_detail = array('phone'=>$mb_phone,'sh'=>$sh_phone);

		$ind_desc = sanitize_text_field($_POST['ind_description']);
		$ind_team_id = sanitize_text_field($_POST['team_id']);
		$ind_facebook_link=mysql_real_escape_string($_POST['ind_facebook_link']);
		$ind_twitter_link=mysql_real_escape_string($_POST['ind_twitter_link']);
		$ind_google_link=mysql_real_escape_string($_POST['ind_google_link']);
		$ind_skype_link=mysql_real_escape_string($_POST['ind_skype_link']);
		$instagram=mysql_real_escape_string($_POST['instagram']);
		$youtube=mysql_real_escape_string($_POST['youtube']);
		$linkdin=mysql_real_escape_string($_POST['linkdin']);
		$vimeo=mysql_real_escape_string($_POST['vimeo']);
		$stumbleupon=mysql_real_escape_string($_POST['stumbleupon']);
		$timblr=mysql_real_escape_string($_POST['timblr']);
		$digg=mysql_real_escape_string($_POST['digg']);
		$foursquare=mysql_real_escape_string($_POST['foursquare']);
		$behance=mysql_real_escape_string($_POST['behance']);
		$delicious=mysql_real_escape_string($_POST['delicious']);
		$reddit=mysql_real_escape_string($_POST['reddit']);
		$wordpress=mysql_real_escape_string($_POST['wordpress']);
		if(isset($_POST['social_media_check'])){
			$ind_social_media=array(
			'ind_facebook_link'=> $ind_facebook_link,
			'ind_twitter_link'=> $ind_twitter_link,		
			'ind_google_link'=> $ind_google_link,
			'ind_skype_link'=> $ind_skype_link,
			'instagram'=>$instagram,
			'youtube'=>$youtube,
			'linkdin'=>$linkdin,
			'vimeo'=>$vimeo,
			'stumbleupon'=>$stumbleupon,
			'timblr'=>$timblr,
			'digg'=>$digg,
			'foursquare'=>$foursquare,
			'behance'=>$behance,
			'delicious'=>$delicious,
			'reddit'=>$reddit,
			'wordpress'=>$wordpress,
			);
		}
		$upload_dir = wp_upload_dir();
		$path_name=$upload_dir['basedir'].""."/easy_team_manager/"; //file upload path !important
		$path=''.$path_name.'';
		$random_digit=rand(000000,999999);// produces random no
		$imgname=basename($_FILES['image']['name']);
		$imgpath=$random_digit.$imgname;
		$path=$path.$imgpath;		
		global $wpdb;
		move_uploaded_file($_FILES['image']['tmp_name'],$path);
			$wpdb->query($wpdb->prepare( "INSERT INTO
				".$wpdb->prefix."easy_team_manager_description
				(name, image, ind_description, position, url, email ,phone, social_media, p_num, team_id )
				VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %d, %d)",
				array(
				serialize($ind_name_detail),
				$imgpath,
				$ind_desc,
				$ind_position,
				$ind_url,
				serialize($ind_email_detail),
				serialize($ind_phone_detail),
				serialize($ind_social_media),
				$priority,
				$ind_team_id
				)		
				));
		$message.="New Member Created";
		}?>
		<div class="wrap jw_admin_wrap">
   <h2 style="border:0;">Add New Member Details <a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$_GET['team_id']);?>">
        <button class="green_btn"  style="margin-left:25px;">Go Back</button></a></h2>
		<?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?><br/>
        <a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$_GET['team_id']);?>">&laquo; Back to Member List</a>
		</p></div><?php endif;?>
		<form method="post" action="" id="create_form" enctype="multipart/form-data">
		<table class='wp-list-table widefat fixed jw_easy_team_add_details'>

		<tr>
        	<th style="color:red">Member's Name </th>
        	<td><input type="text" name="ind_name" placeholder="Enter the Full Name" required/></td>
            
        </tr>
       <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_name" value="sh_show" checked>Show Name &nbsp;<input type="radio" name="sh_name" value="sh_hide">Hide Name</p></td></tr>

        <tr>
            <th>Member's Position</th>
            <td><input type="text"name="ind_position" placeholder="Enter Position" required/></td>
       	</tr>
		<tr><th>Photo of Member</th><td><input type="file" name="image" accept="image/*"/></td></tr>
        
        <tr><th></th><td><p style="float:left; color:#666;"> Use image size: 600px X 340px or ratio of 3:1.7</p></td></tr>
        <tr>
        <!--member_url-->
         <tr><th>Member's Link</th><td><input type="text" name="ind_url"  placeholder="Enter The url" /></td></tr>
         <tr><th></th><td><p style="float:left; color:#666;"> eg&nbsp;:&nbsp;www.jwthemes.com/kamal</p></td></tr>

           <th>Member's Email</th>
           <td><input type="text" name="mb_email" placeholder="Enter Email" /></td>
       	</tr>
       <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_email" value="s_email" checked>Show Email &nbsp;<input type="radio" name="sh_email" value="h_email">Hide Email</p></td></tr>
        
         <tr>
           <th>Member's phone No</th>
           <td><input type="text" name="mb_phone" placeholder="Enter Mobile Number" /></td>
       	</tr>
         <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_phone" value="s_phone" checked>Show Phone &nbsp;<input type="radio" name="sh_phone" value="h_phone">Hide Phone</p></td></tr>
        
        <tr><th>Description</th><td><textarea name="ind_description" id="txtarea" cols="60" rows="10" required  placeholder="Add some Intresting about the Member" ></textarea></td></tr>
         <tr><th>Add Social Links</th><td><select id='purpose'>
    	<option value="0">Select Social Media</option>
    	<option value="1">Facebook</option>
    	<option value="2">Twitter</option>
        <option value="3">Google</option>
        <option value="4">Skype</option>
        <option value="5">Instagram</option>
        <option value="6">Youtube</option>
        <option value="7">Linkdin</option>
        <option value="8">Vimeo</option>
        <option value="9">Stumbleupon</option>
        <option value="10">Tumblr</option>
        <option value="11">Digg</option>
        <option value="12">Foursquare</option>
        <option value="13">Behance</option>
        <option value="14">Delicious</option>
        <option value="15">Reddit</option>
        <option value="16">Wordpress</option>
		</select></td></tr>
		<script>
			jQuery(document).ready(function() {
				jQuery("#facebook").hide();
				jQuery("#twitter").hide();
				jQuery("#google").hide();
				jQuery("#skype").hide();
				jQuery("#instagram").hide();
				jQuery("#youtube").hide();
				jQuery("#linkdin").hide();
				jQuery("#vimeo").hide();
				jQuery("#stumbleupon").hide();
				jQuery("#timblr").hide();
				jQuery("#digg").hide();
				jQuery("#behance").hide();
				jQuery("#foursquare").hide();
				jQuery("#delicious").hide();
				jQuery("#reddit").hide();
				jQuery("#wordpress").hide();
				});
			jQuery('#purpose').on('change', function () {
			
			if(this.value === "1"){
				jQuery("#facebook").show();
			}
			else if(this.value === "2"){
				jQuery("#twitter").show();
			} 
			else if(this.value === "3"){
				jQuery("#google").show();
			}
			else if(this.value === "4"){
				jQuery("#skype").show();
			}
			else if(this.value === "5"){
				jQuery("#instagram").show();
			}
			else if(this.value === "6"){
				jQuery("#youtube").show();																			
			}
			else if(this.value === "7"){
				jQuery("#linkdin").show();
			}
			else if(this.value === "8"){
				jQuery("#vimeo").show();
			}
			else if(this.value === "9"){
				jQuery("#stumbleupon").show();
			}
			else if(this.value === "10"){
				jQuery("#timblr").show();
			}
			else if(this.value === "11"){
				jQuery("#digg").show();
			}
			else if(this.value === "12"){
				jQuery("#foursquare").show();
			}
			else if(this.value === "13"){
				jQuery("#behance").show();
			}
			else if(this.value === "14"){
				jQuery("#delicious").show();
			}
			else if(this.value === "15"){
				jQuery("#reddit").show();
			}
			else if(this.value === "16"){
				jQuery("#wordpress").show();
			}
			});
        </script>
        <tr id="facebook"><th>facebook</th><td><input type="text" name="ind_facebook_link" id="ind_facebook_link">
        <input type="checkbox" name="social_media_check"></td></tr>
        <tr id="twitter"><th>Twitter</th><td><input type="text" name="ind_twitter_link" id="ind_twitter_link">
        <input type="checkbox" name="social_media_check"></td></tr>
        <tr id="google"><th>Google</th><td><input type="text" name="ind_google_link" id="ind_google_link">
        <input type="checkbox" name="social_media_check"></td></tr>
        <tr id="skype"><th>Skype</th><td><input type="text" name="ind_skype_link" id="ind_skype_link">
        <input type="checkbox" name="social_media_check"></td></tr>
        
         <tr id="instagram"><th>Instagram</th><td><input type="text" name="instagram" id="instagram">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="youtube"><th>Youtube</th><td><input type="text" name="youtube" id="youtube">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="linkdin"><th>Linkdin</th><td><input type="text" name="linkdin" id="linkdin">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="vimeo"><th>Vimeo</th><td><input type="text" name="vimeo" id="vimeo">
        <input type="checkbox" name="social_media_check"></td></tr>
        
         <tr id="stumbleupon"><th>stumbleupon</th><td><input type="text" name="stumbleupon" id="stumbleupon">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="timblr"><th>Timblr</th><td><input type="text" name="timblr" id="timblr">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="digg"><th>Digg</th><td><input type="text" name="digg" id="digg">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="foursquare"><th>foursquare</th><td><input type="text" name="foursquare" id="foursquare">
        <input type="checkbox" name="social_media_check"></td></tr>
        
         <tr id="behance"><th>behance</th><td><input type="text" name="behance" id="behance">
        <input type="checkbox" name="social_media_check"></td></tr>
        
         <tr id="delicious"><th>delicious</th><td><input type="text" name="delicious" id="delicious">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="reddit"><th>Reddit</th><td><input type="text" name="reddit" id="reddit">
        <input type="checkbox" name="social_media_check"></td></tr>
        
        <tr id="wordpress"><th>Wordpress</th><td><input type="text" name="wordpress" id="wordpress">
        <input type="checkbox" name="social_media_check"></td></tr>
         <tr>
           <th>Priority Number</th>
           <td><input type="text" name="p_num" placeholder="Enter the priority eg:1" /></td>
       	</tr>
        
		<input type="hidden" name="team_id" id="team_id" value="<?php echo $_GET['team_id'];?>"> 	
    	
		
        <tr><td><input type='submit' name="insert" value='Save Details' class='green_btn green_solid'></td></tr>
        <tr><td></td></tr>
		</table>
		</form>
		</div>
<?php }?>