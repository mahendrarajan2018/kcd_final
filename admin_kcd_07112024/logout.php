<?php
	include("include.php");

	$action = "";
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
		$action = "User Logout. Details - ".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'];
	}

	$msg = "";
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'])) {		
		$current_date_time = $GLOBALS['create_date_time_label'];
		$columns = array('logout_date_time');
		$values = array("'".$current_date_time."'");
		$msg = $obj->UpdateSQL($GLOBALS['login_table'], $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'], $columns, $values, $action);
		if(preg_match("/^\d+$/", $msg)) {
			$backup = "";
			$backup = $obj->daily_db_backup();
		}
	}	

	if(preg_match("/^\d+$/", $msg)) {
		session_destroy();	
		header("Location:index.php?success_msg=You have successfully logged out");
		exit;
	}
?>