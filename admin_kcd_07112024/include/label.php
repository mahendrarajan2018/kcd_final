<?php	
	date_default_timezone_set('Asia/Calcutta');
	$GLOBALS['create_date_time_label'] = date('Y-m-d H:i:s');
	
	$GLOBALS['site_name_user_prefix'] = "kcd_".date("d-m-Y"); $GLOBALS['user_id'] = ""; $GLOBALS['creator'] = "";
	$GLOBALS['creator_details'] = ""; $GLOBALS['user_type'] = ""; $GLOBALS['user_name'] = ""; $GLOBALS['user_mobile_number'] = "";
	$GLOBALS['user_email'] = ""; $GLOBALS['login_id'] = ""; $GLOBALS['ip_address'] = ""; $GLOBALS['null_value'] = "NULL";

	$GLOBALS['admin_user_type'] = "Super Admin";$GLOBALS['staff_user_type'] = "Staff"; $GLOBALS['admin_folder_name'] = "admin_kcd_07112024";

	$GLOBALS['page_number'] = 1; $GLOBALS['page_limit'] = 10; $GLOBALS['page_limit_list'] = array("10", "25", "50", "100", "500", "1000");

	$GLOBALS['backup_folder_name'] = 'backup'; $GLOBALS['log_backup_folder_name'] = 'backup/logs'; 
	$GLOBALS['max_log_file_count'] = 5; $GLOBALS['max_log_file_size_mb'] = 10; $GLOBALS['expire_log_file_days'] = 90;
	$GLOBALS['max_role_count'] = 5; $GLOBALS['max_user_count'] = 10; $GLOBALS['max_godown_count'] = 3; $GLOBALS['max_branch_count'] = 5; $GLOBALS['max_company_count'] = 2;

	// Tables
	$GLOBALS['table_prefix'] = "kcd_2024_";

	$GLOBALS['user_table'] = $GLOBALS['table_prefix'].'user'; $GLOBALS['login_table'] = $GLOBALS['table_prefix'].'login'; 
	$GLOBALS['role_table'] = $GLOBALS['table_prefix'].'role'; $GLOBALS['organization_table'] = $GLOBALS['table_prefix'].'organization'; 
	$GLOBALS['godown_table'] = $GLOBALS['table_prefix'].'godown'; $GLOBALS['branch_table'] = $GLOBALS['table_prefix'].'branch';
	$GLOBALS['consignor_table'] = $GLOBALS['table_prefix'].'consignor'; $GLOBALS['consignee_table'] = $GLOBALS['table_prefix'].'consignee'; 
	$GLOBALS['vehicle_table'] = $GLOBALS['table_prefix'].'vehicle'; $GLOBALS['unit_table'] = $GLOBALS['table_prefix'].'unit';
	$GLOBALS['account_party_table'] = $GLOBALS['table_prefix'].'account_party'; $GLOBALS['luggage_sheet_table'] = $GLOBALS['table_prefix'].'luggage_sheet';
	$GLOBALS['lr_table'] = $GLOBALS['table_prefix'].'lr'; $GLOBALS['tripsheet_table'] = $GLOBALS['table_prefix'].'tripsheet';
	$GLOBALS['settings_table'] = $GLOBALS['table_prefix'].'settings';

	// Prefix
	//$GLOBALS[$GLOBALS['table_prefix'].'orders_table_prefix'] = "ORD";
	
	// Session Variables	
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
		$GLOBALS['user_id'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
		$GLOBALS['creator'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
	}	
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
		$GLOBALS['user_name'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'];
	}
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'])) {
		$GLOBALS['user_mobile_number'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'];
	}
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
		$GLOBALS['user_name_mobile'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'];
	}		
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'])) {
		$GLOBALS['user_login_record_id'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'];
	}
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'])) {
		$GLOBALS['ip_address'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'];
	}
	if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
		$GLOBALS['creator_name'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'];
	}
	if(isset($_SESSION['bill_company_id']) && !empty($_SESSION['bill_company_id'])) {
		$GLOBALS['bill_company_id'] = $_SESSION['bill_company_id'];
	}

	$GLOBALS['creation_module'] = "Creation";

	$access_pages_list = array();
	$access_pages_list[] = $GLOBALS['creation_module'];
	$GLOBALS['access_pages_list'] = $access_pages_list;

	$GLOBALS['tax_value_options'] = array('0%', '5%', '12%', '18%', '28%');

	$GLOBALS['bill_type_options'] = array('Paid', 'To Pay');

	$GLOBALS['default_date'] = "1947-01-01"; $GLOBALS['default_date_time'] = "1947-01-01 01:01:01";
?>