<?php
	function remove_easy_team_manager(){
	global $wpdb;
	if($_GET['team_id']){
	$tid = $_GET['team_id'];
	$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."easy_team_manager where tid = %s",$tid));
	}

	global $wpdb;
	if($_GET['id']){
	$id=$_GET['id'];
	$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."easy_team_manager_description WHERE id = %s",$id));
	}
}?>