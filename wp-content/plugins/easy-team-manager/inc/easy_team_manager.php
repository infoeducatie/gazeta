<?php function easy_team_manager(){
        global $wpdb;
        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."easy_team_manager");
		foreach($rows as $row);
		if($row->tid!=''){
			echo "<div class='jw_admin_wrap'>";
				echo "<h2>Select the Team </h2>";
				echo "<table class='list-table widefat fixed'>";
					echo "<tr>
							<th style='width:22%;'>Slider Name</th>
							<th style='width:18%;'>Add New Member</th>
							<th style='width:40%;'>Shortcode</th>
							<th style='width:20%;'>Action</th>
						</tr>"; 
			
						foreach($rows as $row){?>  
						<tr class="team_list">
							<td><a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$row->tid);?>" class="easy_team_manager_name"><?php echo esc_attr(stripcslashes($row->team_name));?></a></td>
							
							<td><a href="<?php echo admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$row->tid);?>" class="easy_team_manager_name">Add New Member</a></td>
							
						   <td>[easy-team-manager team_name="<?php echo esc_attr(stripcslashes($row->team_name));?>"]</td>
						   
							<td><a href="<?php echo admin_url('admin.php?page=easy_team_manager_edit&id='.$row->tid);?>">
                            <button class="green_btn ">Edit</button></a><span class="remove_easy_team_manager_name"> 
							<a href="#" team_id="<?php echo $row->tid;?>" class="remove_name">
						  <button class="red_btn red_solid">Remove</button></a></span></td>                       
					   </tr> 
						<?php }?>
               		</table> <br>
                    <!--delete-->
        		<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".remove_name").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("team_id");
                //Built a url to send
                var info = 'team_id=' + del_id;
                if(confirm("Sure you want to delete this list? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=remove_easy_team_manager');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".team_list").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
                </script>
                
                    <h3>Add New Team</h3>
                    <a href="admin.php?page=easy_team_manager_create"><button class="button primary-button">Add New Team</button></a> 
                </div>
                    
				<?php } else {?>
                
                <div class="jw_admin_wrap">
                    <h2>Create New Team</h2>
                    <a href="admin.php?page=easy_team_manager_create"><button class="button primary-button">Add New Team</button></a>
                </div>
                
<?php }}?>