<?php function easy_team_manager_desc_list(){?>
	<div class="wrap jw_admin_wrap">
        <aside>
        <h2>Add &amp; Manage Team Members <a href="<?php echo admin_url('admin.php?page=easy_team_manager');?>">
        <button class="green_btn" style="margin-left:25px;">Go Back</button></a></h2><br /><br />
        	<a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_create&action=create&team_id='.$_GET['team_id']); ?>"
         	class="green_btn green_solid">Add New Team Members</a><br/><br/>
        <?php
        global $wpdb;
        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."easy_team_manager_description");
		$team_id = $wpdb->get_var($wpdb->prepare("SELECT team_id FROM ".$wpdb->prefix."easy_team_manager_description where team_id = %d",$_GET['team_id']));	
		if($team_id!=$_GET['team_id']){ echo "No any Members availabe, Add new memeber detail above";}else{
        echo "<table class='list-table widefat fixed jw_easy_team_memeber_list'>";
				echo "<tr>
					<th style='width:10%;'>Order No</th>
					<th style='width:16%;'>Name</th>
					<th style='width:14%;'>Position</th>
					<th style='width:15%;'>Thumbail</th>
					<th style='width:14%;'>Email</th>
					<th style='width:14%;'>Phone</th>
					<th style='width:30%;'>Description</th>
					<th style='width:15%;'>Socail Media</th>
					<th style='width:15%;'>Action</th>
				</tr>";
				foreach ($rows as $row ){if($row->team_id==$_GET['team_id']){$socia_media=unserialize($row->social_media);
				$ind_name_detail=unserialize($row->name);$ind_email_detail=unserialize($row->email);$ind_phone_detail=unserialize($row->phone);?>
				<tr class="easy_team_manager_list">
               		<td><?php echo esc_attr($row->p_num);?></td>
					<td><?php echo esc_attr($ind_name_detail['name']);?></td>
					<td><?php echo esc_attr($row->position);?></td>	
					<td><?php if($row->image!=is_numeric($row->image)){?>
						<img src='<?php $upload_dir=wp_upload_dir();
						echo $upload_dir["baseurl"]."/"."easy_team_manager/".$row->image;?>' style="height:56px; width:auto;">
				<?php } else {?> <img src='<?php echo plugins_url('easy-team-manager/images/blank_pic.png');?>' style="height:56px; width:auto;"><?php }?>
				
					</td>
                    <td><?php echo esc_attr($ind_email_detail['email']);?></td>
                    <td><?php echo esc_attr($ind_phone_detail['phone'])?></td>
                    <td><?php echo stripcslashes($row->ind_description); ?></td>
            		<td>  
            			<?php if($socia_media['ind_facebook_link']!=''){?>
                      	<a href="http://www.facebook.com/<?php echo $social_media['ind_facebook_link'];?>"> 
                       	<i class="fa fa-facebook"></i></a><?php }?>
                        
                        <?php if($socia_media['ind_twitter_link']!=''){?>
                       	<a href="http://www.twitter.com/<?php echo $social_media['ind_twitter_link'];?>"> 
                       	<i class="fa fa-twitter"></i></a><?php }?>
                        
                       	<?php if($socia_media['ind_google_link']!=''){?>
                        <a href="http://www.google.com/<?php echo $social_media['ind_google_link'];?>"> 
                       	<i class="fa fa-google"></i></a><?php }?>
                        
                       	<?php if($socia_media['ind_skype_link']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['ind_skype_link'];?>"> 
                       	<i class="fa fa-skype"></i></a><?php }?>
                        
                       	<?php if($socia_media['instagram']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['instagram'];?>"> 
                       	<i class="fa fa-instagram"></i></a><?php }?>
                        
                        <?php if($socia_media['youtube']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['youtube'];?>"> 
                       	<i class="fa fa-youtube"></i></a><?php }?>
                        
                        <?php if($socia_media['linkdin']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['linkdin'];?>"> 
                       	<i class="fa fa-linkedin"></i></a><?php }?>
                        
                        <?php if($socia_media['vimeo']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['vimeo'];?>"> 
                       	<i class="fa fa-vimeo-square"></i></a><?php }?>
                        
                       	<?php if($socia_media['stumbleupon']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['stumbleupon'];?>"> 
                       	<i class="fa fa-stumbleupon"></i></a><?php }?>
                        
                        <?php if($socia_media['timblr']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['timblr'];?>"> 
                       	<i class="fa fa-tumblr-square"></i></a><?php }?>
                        
                        <?php if($socia_media['digg']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['digg'];?>"> 
                       	<i class="fa fa-digg"></i></a><?php }?>
                        
                        <?php if($socia_media['behance']!=''){?>
                       	<a href="http://www.behance.com/<?php echo $social_media['behance'];?>"> 
                       	<i class="fa fa-behance"></i></a><?php }?>
                        
                        <?php if($socia_media['foursquare']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['foursquare'];?>"> 
                       	<i class="fa fa-foursquare"></i></a><?php }?>
                       
                        <?php if($socia_media['delicious']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['delicious'];?>"> 
                       	<i class="fa fa-delicious"></i></a><?php }?>
                        
                        <?php if($socia_media['reddit']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['reddit'];?>"> 
                       	<i class="fa fa-reddit"></i></a><?php }?>
                        
                        <?php if($socia_media['wordpress']!=''){?>
                       	<a href="http://www.skype.com/<?php echo $social_media['wordpress'];?>"> 
                       	<i class="fa fa-wordpress"></i></a><?php }?>
             		</td>
                    <td class="easy_team_manager_action"><a href='<?php echo admin_url('admin.php?page=easy_team_manager_desc_edit&id='.$row->id.'&team_id='.$_GET['team_id']);?>'  class="green_btn">Edit</a>
                        <a href='#' id="<?php echo $row->id;?>" class="red_btn jw_easy_team_manager_remove">Remove</a>
                    </td>
                </tr><?php }}?>
            </table>
		</aside>
        </div>
        		<!--delete-->
        		<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".jw_easy_team_manager_remove").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("id");
                //Built a url to send
                var info = 'id=' + del_id;
                if(confirm("Sure you want to delete this list? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=remove_easy_team_manager');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".easy_team_manager_list").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
                </script>
        
        <div class="jw_admin_wrap">
            <div class="show_easy_team_manager_shortcode">
            <?php global $wpdb;
            $rows=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."easy_team_manager where tid=".$_GET['team_id'] );
            foreach($rows as $row){?>
            <strong style="font-size:18px; padding-top:10px; display:inline-block">Copy &amp; Paste the Shortcode to Post/Page or anywhere you need to display</strong><br /><br /><code class="shortcode" style="font-size:16px; padding:5px 20px; border-radius:3px;">[easy-team-manager team_name="<?php echo $row->team_name;?>"]</code>
            <?php }?>
            </div>
            <?php
                if(isset($_POST['submit_setting'])){            
                    global $wpdb;
                    $id = $_GET['team_id'];
                    $random_digit=rand(000000,999999);// produces random no
                    $imgname=basename($_FILES['image']['name']);
                    $imgpath=$random_digit.$imgname;
                    $upload_dir = wp_upload_dir();
					move_uploaded_file($_FILES['image']['tmp_name'],$upload_dir['basedir'].""."/easy_team_manager/".$imgpath);
                    $path=''.$path_name.'';
                    $background_color = sanitize_text_field($_POST['background_color']);
                    $img_hv_color = sanitize_text_field($_POST['img_hv_color']);
                    $theme_color = sanitize_text_field($_POST['theme_color']);
                    $img_set = sanitize_text_field($_POST['img_setting']);
                    $setting=array('background_color'=>$background_color,'img_hv_color'=>$img_hv_color,'theme_color'=>$theme_color,'img_set'=>$img_set);
                    if ($_FILES['image']['name'] != '') {
                    $wpdb->update(''.$wpdb->prefix.'easy_team_manager',
                    array('background_image'=>$imgpath,'setting'=>serialize($setting)),array( 'tid' => $id ), array('%s','%s'),array('%d'));
                    $message.="Setting updated";
                }
                else{
                    $wpdb->update(''.$wpdb->prefix.'easy_team_manager',
                    array('setting'=>serialize($setting)),array( 'tid' => $id ), array('%s'),array('%d'));
                    $message.="Setting updated";
                }
                } else{
                    global $wpdb;
                    $id = $_GET['team_id'];
                    $rows=$wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."easy_team_manager where tid = %d",$_GET['team_id'] ));
                    foreach($rows as $result){
                        $name = esc_attr($result->team_name);
                        $image=$result->background_image;
                        $setting=unserialize($result->setting);
                        $img_set=$setting['img_set'];
                        $background_color=$setting['background_color'];
                        $img_hv_color=$setting['img_hv_color'];
                        $theme_color=$setting['theme_color'];
                    }
                }?>
            <div class="wrap">
            <script>var imageUrl='<?php echo plugins_url('easy-team-manager/images/paint_brush_color.png');?>';</script>          
              <?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?><br/>
            </div><?php endif;?>
            	<br />
                <div class="ek_pana_setting">
                    <h2>Setting for Team Members Displayed on Front-end</h2>
                </div>
                <div class="ek_pana_setting_form"><br />
                    <form  method="post" enctype="multipart/form-data" action="">
                        <div class="widefat jw_easy_team_memeber_list_settings">
                            <label class="form_caption	">Background Image:</label><span><input type="file" name="image"></span>
                            
                            <input type="radio" name="img_setting" value="set" <?php if($img_set!="unset")?> checked/><label>Set Image</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="img_setting" value="unset" <?php if($img_set!="set"){?> checked<?php } else {?> unchecked<?php }?>/><label>Unset Image</label>
                            <div><?php if($image!='' AND isset($image)){?>
                            	<img src='<?php $upload_dir=wp_upload_dir();echo $upload_dir["baseurl"]."/"."easy_team_manager/".$image;?>' height="50px" width="100px"><?php }?>
                            </div><br />
                      
                            <div>
                            	<label class="form_caption">Background Color:</label>
                                	<input type="text" placeholder="Add Hex color code OR choose from Pallete" name="background_color" id="mycolor" class="iColorPicker" value="<?php if(isset($background_color)) echo $background_color;?>" >
                            </div><br />
                            
                            <div>
                            	<label class="form_caption">Image Caption Background:</label>
                                <input type="text" placeholder="Add Hex color code OR choose from Pallete"  name="img_hv_color" value="<?php if(isset($img_hv_color)) echo $img_hv_color;?>" id="mycolor1" class="iColorPicker" >
                            </div><br />
                            
                            <div>
                            	<label class="form_caption">Choose Color Theme: </label>
                                <input type="text" placeholder="Add Hex color code OR choose from Pallete"  name="theme_color" value="<?php if(isset($theme_color)) echo $theme_color;?>" id="mycolor2" class="iColorPicker" >
                            </div><br />
                            
                            <div style="margin-left:243px;">
	                            <input type="submit" name="submit_setting"  value="Save Setting"class="green_btn green_solid">
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
<?php }}?>