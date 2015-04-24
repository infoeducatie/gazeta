<?php
	function easy_team_manager_desc_remove(){
		global $wpdb;
		$id = $_GET["id"];
		$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."easy_team_manager_description WHERE id = %s",$id));
		if($sql){
			$location=admin_url('admin.php?page=easy_team_manager_desc_list&team_id='.$_GET['team_id']);
			echo'<script> window.location="'.$location.'"; </script> ';
}}?>