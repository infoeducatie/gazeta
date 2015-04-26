<?php
	function easy_team_manager_edit(){
		if(isset($_POST['update'])){
			$id = $_GET['id'];
			$team_name = sanitize_text_field($_POST["team_name"]);
			$team_description = sanitize_text_field($_POST["team_description"]);
			global $wpdb;
			$sql=$wpdb->update(''.$wpdb->prefix.'easy_team_manager',
			array('team_name'=>$team_name,'description'=>$team_description),
			array('tid'=>$id),
			array('%s','%s'),array('%d'));

			if($sql){
			$location=admin_url('admin.php?page=easy_team_manager');
			echo'<script> window.location="'.$location.'"; </script> ';
			}} else {
				
				global $wpdb;
				$easy_team_manager = $wpdb->get_results("SELECT *from ".$wpdb->prefix."easy_team_manager where tid=".$_GET['id']);

				foreach($easy_team_manager as $row){
					
					$team_name = esc_attr($row->team_name);
					$description = esc_attr($row->description);
				
				}
			}?>
        <div class="wrap jw_admin_wrap">
            <h2>Edit The Team Name And Description</h2>
            <form method="post" action="">
                <p class="required">Enter all in all the fields *</p>
                
                	<div class="jw_easy_team_manage_create_team">
                    	<div>
                        <span class="form_caption">Team Name</span><br /><span><input type="text" name="team_name" 
                        required placeholder="Enter Name of Team *" value="<?php if(isset($team_name)) echo $team_name;?>"/>				</span>
                    	</div><br /><br />
                    
                    	<div>
                        <span class="form_caption">About Team</span> <br /><span><textarea name="team_description" id="team_description" rows="05" cols="50" required placeholder="Enter some Description *" ><?php if(isset($description)) echo $description;?></textarea></span>
                    </div>
                </div><br /><br />
                
                <input type='submit' name="update" value='Update Team' class='green_btn green_solid'>
            </form>
       </div>
<?php }?>