<?php function easy_team_manager_create(){
   			if(isset($_POST['insert'])){
			$team_name = sanitize_text_field($_POST["team_name"]);
			$team_description = sanitize_text_field($_POST["team_description"]);
			global $wpdb;
			$sql=$wpdb->query( $wpdb->prepare("INSERT INTO ".$wpdb->prefix."easy_team_manager
				(team_name, description) VALUES( %s, %s )", //table
				array($team_name,
				$team_description)));
			if($sql){
			$location=admin_url('admin.php?page=easy_team_manager');
			echo'<script> window.location="'.$location.'"; </script> ';
			}}?>
        <div class="wrap jw_admin_wrap">
            <h2>Create New Team</h2>
            <form method="post" action="">
                <p class="required">Enter all in all the fields *</p>
                
                <div class="jw_easy_team_manage_create_team">
                    <div>
                        <span class="form_caption">Team Name</span><br /><span><input type="text" name="team_name" required placeholder="Enter Name of Team *" /></span>
                    </div><br /><br />
                    
                    <div>
                        <span class="form_caption">About Team</span> <br /><span><textarea name="team_description" id="team_description" rows="05" cols="50" required placeholder="Enter some Description *" ></textarea></span>
                    </div>
                </div><br /><br />
                
                <input type='submit' name="insert" value='Save New Team' class='green_btn green_solid'>
            </form>
        </div>
<?php }?>