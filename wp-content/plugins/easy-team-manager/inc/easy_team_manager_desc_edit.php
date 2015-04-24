<?php
	function easy_team_manager_desc_edit(){
	if(isset($_POST['update'])){
	require_once(ABSPATH . 'wp-admin/includes/image.php');
		$id = sanitize_text_field($_POST['id']);
		$ind_name = mysql_real_escape_string($_POST["ind_name"]);
		$sh_name = mysql_real_escape_string($_POST['sh_name']);
		$ind_name_detail = array('name'=>$ind_name,'sh'=>$sh_name);
		$ind_position = sanitize_text_field($_POST['ind_position']);
		$ind_url = sanitize_text_field($_POST['ind_url']);
		
		$mb_email = sanitize_email(mysql_real_escape_string($_POST['mb_email']));
		$sh_email = mysql_real_escape_string($_POST['sh_email']);
		$ind_email_detail = array('email'=>$mb_email,'sh'=>$sh_email);
				
		$mb_phone=mysql_real_escape_string($_POST['mb_phone']);
		$sh_phone = mysql_real_escape_string($_POST['sh_phone']);
		$ind_phone_detail = array('phone'=>$mb_phone,'sh'=>$sh_phone);
		$priority = sanitize_text_field($_POST['p_num']);

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
			'wordpress'=>$wordpress
			);
		}
		$random_digit=rand(000000,999999);// produces random no
		$imgname=basename($_FILES['image']['name']);
		$imgpath=$random_digit.$imgname;
		$upload_dir = wp_upload_dir();
		move_uploaded_file($_FILES['image']['tmp_name'],$upload_dir['basedir'].""."/easy_team_manager/".$imgpath);
		$path=''.$path_name.'';
		
		$path=$path.$imgpath;
		if ($_FILES['image']['name'] != '') {
		global $wpdb;
			$wpdb->update(
				''.$wpdb->prefix.'easy_team_manager_description', //table
				array('name'=> serialize($ind_name_detail),'image'=>$imgpath,'ind_description'=>$ind_desc,'position'=>$ind_position,'url'=>$ind_url, 'email'=>serialize($ind_email_detail),'phone'=>serialize($ind_phone_detail),'social_media'=> serialize($ind_social_media),'p_num'=>$priority,'team_id'=>$ind_team_id),array( 'id' => $id ), //data
				array('%s','%s','%s', '%s', '%s', '%s', '%s','%s', '%d','%d'),
				array('%d') //data format			
				);
		} else{global $wpdb;
			$wpdb->update(
				''.$wpdb->prefix.'easy_team_manager_description', //table
				array('name'=> serialize($ind_name_detail),'ind_description'=>$ind_desc,'position'=>$ind_position,'url'=>$ind_url,'email'=>serialize($ind_email_detail),'phone'=>serialize($ind_phone_detail),'social_media'=> serialize($ind_social_media),'p_num'=>$priority,'team_id'=>$ind_team_id),
				array( 'id' => $id ), //data
				array('%s','%s','%s', '%s', '%s', '%s', '%s','%d','%d'),
				array('%d') //data format			
				);}} 
	
		else {
        global $wpdb;	
        $easy_team_manager_desc = $wpdb->get_results("SELECT *from ".$wpdb->prefix."easy_team_manager_description where id=".$_GET['id']);
		foreach ($easy_team_manager_desc as $s ){
			$ind_name_detail = unserialize($s->name);
			$socia_media = unserialize($s->social_media);
			$id=$_GET['id'];
			$ind_position = esc_attr($s->position);
			$ind_image=$s->image;
			$ind_email_detail = unserialize($s->email);
			$ind_phone_detail = unserialize($s->phone);
			$ind_desc = esc_attr(stripcslashes($s->ind_description));
			$ind_url = $s->url;
			$priority = $s->p_num;
			
		}}?>
        <div class="wrap jw_admin_wrap">
		<?php if (isset($_POST['update'])) { 
        $location=admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$_GET['team_id']);
        echo'<script> window.location="'.$location.'"; </script> ';
        }?>
       <h2 style="border:0;">Eidt The Content of:<?php echo $ind_name_detail['name'];?> <a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$_GET['team_id']);?>"><button class="green_btn" style="margin-left:25px;">Go Back</button></a></h2>
		<form method="post" action="" enctype="multipart/form-data">
		
		<table class='wp-list-table widefat fixed jw_easy_team_add_details'>
		<tr><th>Member's Name </th><td><input type="text" name="ind_name" value="<?php echo $ind_name_detail['name'];?>" placeholder="Enter the Name" required/></td></tr>
        <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_name" value="sh_show" 
		<?php if ($ind_name_detail['sh']=="sh_show"){ echo "checked";} else { echo "unchecked";}?>>Show Name &nbsp;<input type="radio" name="sh_name" value="sh_hide" <?php if ($ind_name_detail['sh']=="sh_hide"){ echo "checked";} else { echo "unchecked";}?>>Hide Name</p></td></tr>
        
        <tr><th>Member's Position</th><td><input type="text" name="ind_position" value="<?php echo $ind_position;?>" placeholder="Enter The Position" required/></td></tr>
        
		<tr><th>Photo of Member</th><td><input type="file" name="image" accept="image/*"/></td></tr>
        <tr><th></th><td><p style="float:left; color:#666;"> Use image size: 600px X 340px or ratio of 3:1.7</p></td></tr>
        
        <!--member_url-->
         <tr><th>Member's Link</th><td><input type="text" name="ind_url" value="<?php echo esc_url($ind_url);?>" placeholder="Enter The url" /></td></tr>
        <tr><th></th><td><p style="float:left; color:#666; margin:0px"> eg &nbsp;:&nbsp;www.jwthemes.com/kamal</p></td></tr>

        
                
<tr><th></th><td><?php if ($ind_image!=is_numeric($ind_image)){?><img src='<?php $upload_dir=wp_upload_dir();
						echo $upload_dir["baseurl"]."/"."easy_team_manager/".$ind_image;?>' style="height:128px; width:auto; float:left; border:1px solid #ddd; border-radius:3px; padding:6px; background:#fff;"><?php } else {?><img src='<?php echo plugins_url('easy-team-manager/images/blank_pic.png');?>'style="height:128px; width:auto; float:left; border:1px solid #ddd; border-radius:3px; padding:6px; background:#fff;"><?php }?></td></tr>
        <tr>
           <th>Member's Email</th>
           <td><input type="text" name="mb_email" placeholder="Enter Email" value="<?php echo $ind_email_detail['email'];?>" /></td>
       	</tr>
        <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_email" value="s_email" 
		<?php if ($ind_email_detail['sh']=="s_email"){ echo "checked";} else { echo "unchecked";}?>>Show Name &nbsp;<input type="radio" name="sh_email" value="h_email" <?php if ($ind_email_detail['sh']=="h_email"){ echo "checked";} else { echo "unchecked";}?>>Hide Name</p></td></tr>
        
         <tr>
           <th>Member's phone No</th>
           <td><input type="text" name="mb_phone" placeholder="Enter Mobile Number" value="<?php echo $ind_phone_detail['phone'];?>"/></td>
       	</tr>
        <tr><th></th><td><p style="float:left; color:#666;"><input type="radio" name="sh_phone" value="s_phone" 
		<?php if ($ind_phone_detail['sh']=="s_phone"){ echo "checked";} else { echo "unchecked";}?>>Show Name &nbsp;<input type="radio" name="sh_phone" value="h_phone" <?php if ($ind_phone_detail['sh']=="h_phone"){ echo "checked";} else { echo "unchecked";}?>>Hide Name</p></td></tr>
        
        
        <tr><th>Description</th><td><textarea name="ind_description" id="txtarea" cols="60" rows="10"><?php echo $ind_desc;?></textarea></td></tr>   
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
			jQuery( document ).ready(function() {
			<?php if ($socia_media['ind_facebook_link']!=''){?>
				jQuery("#facebook").show();
			<?php }
			else {?> jQuery("#facebook").hide();<?php }?>
			<?php if ($socia_media['ind_twitter_link']!=''){?>
				jQuery("#twitter").show();
			<?php }
			else {?>jQuery("#twitter").hide();<?php }?>
			<?php if ($socia_media['ind_google_link']!=''){?>
				jQuery("#google").show();
			<?php }
			else {?> jQuery("#google").hide();<?php }?>
			
			<?php if ($socia_media['ind_skype_link']!=''){?>
				jQuery("#skype").show();
			<?php }
			else {?> jQuery("#skype").hide();<?php }?>
			
			<?php if ($socia_media['instagram']!=''){?>
				jQuery("#instagram").show();
			<?php }
			else {?> jQuery("#instagram").hide();<?php }?>
			
			<?php if ($socia_media['youtube']!=''){?>
				jQuery("#youtube").show();
			<?php }
			else {?> jQuery("#youtube").hide();<?php }?>
			
			<?php if ($socia_media['linkdin']!=''){?>
				jQuery("#linkdin").show();
			<?php }
			else {?> jQuery("#linkdin").hide();<?php }?>
			<?php if ($socia_media['vimeo']!=''){?>
				jQuery("#vimeo").show();
			<?php }
			else {?> jQuery("#vimeo").hide();<?php }?>
			
			<?php if ($socia_media['stumbleupon']!=''){?>
				jQuery("#stumbleupon").show();
			<?php }
			else {?> jQuery("#stumbleupon").hide();<?php }?>
			
			<?php if ($socia_media['timblr']!=''){?>
			$("#timblr").show();
			<?php }
			else {?> jQuery("#timblr").hide();<?php }?>
			
			<?php if ($socia_media['digg']!=''){?>
				jQuery("#digg").show();
			<?php }
			else {?> jQuery("#digg").hide();<?php }?>
			<?php if ($socia_media['behance']!=''){?>
				jQuery("#behance").show();
			<?php }
			else {?> jQuery("#behance").hide();<?php }?>
			<?php if ($socia_media['foursquare']!=''){?>
				jQuery("#foursquare").show();
			<?php }
			else {?> jQuery("#foursquare").hide();<?php }?>
			<?php if ($socia_media['delicious']!=''){?>
				jQuery("#delicious").show();
			<?php }
			else {?> jQuery("#delicious").hide();<?php }?>
			
			<?php if ($socia_media['reddit']!=''){?>
				jQuery("#reddit").show();
			<?php }
			else {?> jQuery("#reddit").hide();<?php }?>
			
			<?php if ($socia_media['wordpress']!=''){?>
				jQuery("#wordpress").show();
			<?php }
			else {?> jQuery("#wordpress").hide();<?php }?>
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
 <tr id="facebook"><th>facebook</th><td><input type="text" name="ind_facebook_link" id="ind_facebook_link"
          value="<?php echo $socia_media['ind_facebook_link'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['ind_facebook_link']!='')?> checked ></td></tr>
        
        <tr id="twitter"><th>Twitter</th><td><input type="text" name="ind_twitter_link" id="ind_twitter_link" value="<?php echo $socia_media['ind_twitter_link'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['ind_twitter_link']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="google"><th>Google</th><td><input type="text" name="ind_google_link" id="ind_google_link" value="<?php echo $socia_media['ind_google_link'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['ind_google_link']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="skype"><th>Skype</th><td><input type="text" name="ind_skype_link" id="ind_skype_link" 
        value="<?php echo $socia_media['ind_skype_link'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['ind_skype_link']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        
         <tr id="instagram"><th>Instagram</th><td><input type="text" name="instagram" id="instagram" value="<?php echo $socia_media['instagram'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['instagram']!=''){?> checked <?php } else {?> disable <?php }?>></td>
        </tr>
        
        <tr id="youtube"><th>Youtube</th><td><input type="text" name="youtube" id="youtube" value="<?php echo $socia_media['youtube'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['youtube']!=''){?> checked <?php } else {?> disable <?php }?>></td></tr>
        
        <tr id="linkdin"><th>Linkdin</th><td><input type="text" name="linkdin" id="linkdin" value="<?php echo $socia_media['linkdin'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['linkdin']!=''){?> checked <?php } else {?> disable <?php }?> ></td></tr>
        
        <tr id="vimeo"><th>Vimeo</th><td><input type="text" name="vimeo" id="vimeo" value="<?php echo $socia_media['vimeo'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['vimeo']!=''){?> checked <?php } else {?> disable <?php }?>></td></tr>
        
         <tr id="stumbleupon"><th>stumbleupon</th><td><input type="text" name="stumbleupon" id="stumbleupon" value="<?php echo $socia_media['linkdin'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['stumbleupon']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="timblr"><th>Timblr</th><td><input type="text" name="timblr" id="timblr" value="<?php echo $socia_media['timblr'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['timblr']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="digg"><th>Digg</th><td><input type="text" name="digg" id="digg" value="<?php echo $socia_media['digg'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['digg']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="foursquare"><th>foursquare</th><td><input type="text" name="foursquare" id="foursquare" value="<?php echo $socia_media['foursquare'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['foursquare']!=''){?> checked <?php } else {?> disable <?php }?>></td></tr>
        
         <tr id="behance"><th>behance</th><td><input type="text" name="behance" id="behance" value="<?php echo $socia_media['behance'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['behance']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
         <tr id="delicious"><th>delicious</th><td><input type="text" name="delicious" id="delicious" value="<?php echo $socia_media['delicious'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['delicious']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="reddit"><th>Reddit</th><td><input type="text" name="reddit" id="reddit" value="<?php echo $socia_media['reddit'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['reddit']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
        
        <tr id="wordpress"><th>Wordpress</th><td><input type="text" name="wordpress" id="wordpress" value="<?php echo $socia_media['wordpress'];?>">
        <input type="checkbox" name="social_media_check" <?php if ($socia_media['wordpress']!=''){?> checked <?php } else {?> disable <?php }?>>
        </td></tr>
         <tr>
           <th>Priority Number</th>
           <td><input type="text" name="p_num" value="<?php echo esc_attr($priority);?>" placeholder="Enter the priority eg:1" /></td>
       	</tr>
    
		<input type="hidden" name="team_id" id="team_id" value="<?php echo $_GET['team_id'];?>">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"
        		
		<tr><td><input type='submit' name="update" value='&nbsp;Update &nbsp;' class='green_btn green_solid'></td></tr>
		</table>
		</form>
		</div>
<?php }?>