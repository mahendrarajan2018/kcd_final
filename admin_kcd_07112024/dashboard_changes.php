<?php
    include("include.php");
    
    if(isset($_REQUEST['check_login_session'])) {
		$check_login_session = $_REQUEST['check_login_session'];

		if($check_login_session == 1) {
			$check_login_session = 1; $login_user_id = "";
			if(!empty($_SESSION)) {
				$login_user_id = $obj->checkUser();
				if(!empty($login_user_id)) {
					if($login_user_id != $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) {
						$check_login_session = 0;
					}
				}
				else {
					$check_login_session = 0;
				}
			}
			else {
				$check_login_session = 0;
			}
			echo $check_login_session;
			exit;
		}
	}

	if(isset($_REQUEST['get_backup'])) {
		$get_backup = $_REQUEST['get_backup'];
		if(!empty($get_backup) && $get_backup == 1) {
			$backup = $obj->daily_db_backup();
			echo $backup;
			exit;
		}
	}

	if(isset($_REQUEST['update_billing_year'])) {
		$update_billing_year = $_REQUEST['update_billing_year'];
		$update_billing_year = trim($update_billing_year);

		$year_list = array();
		$year_list = $obj->getBillingYearList();

		$year = date('Y');
		if(!empty($update_billing_year)) {
			if(!empty($year_list) && in_array($update_billing_year, $year_list)) {
				$year = $update_billing_year;
			}
		}
		if(!empty($year)) {

			if(isset($_SESSION['billing_year']) && !empty($_SESSION['billing_year'])) {
				unset($_SESSION['billing_year']);
			}
			if(isset($_SESSION['billing_year_starting_date']) && !empty($_SESSION['billing_year_starting_date'])) {
				unset($_SESSION['billing_year_starting_date']);
			}
			if(isset($_SESSION['billing_year_ending_date']) && !empty($_SESSION['billing_year_ending_date'])) {
				unset($_SESSION['billing_year_ending_date']);
			}

			$_SESSION['billing_year'] = $year;
			$_SESSION['billing_year_starting_date'] = "01-04-".$year;
			$_SESSION['billing_year_ending_date'] = "31-03-".($year + 1);

		}
		echo $year;
		exit;
	}
?>