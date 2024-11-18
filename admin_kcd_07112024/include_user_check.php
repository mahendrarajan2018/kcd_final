<?php    
    include("include.php");

    $login_user_id = "";
    if(!empty($_SESSION)) {
        $login_user_id = $obj->checkUser();
        if(!empty($login_user_id)) {
            if($login_user_id != $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) {
              header("Location:logout.php");
              exit;
            }
        }
        else {
            header("Location:logout.php");
            exit;
        }
    }
    else {
      header("Location:index.php");
      exit;
    }

    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] != $GLOBALS['admin_user_type']) {
            header("Location:dashboard.php");
            exit;
        }
    }    
                  
    $billing_year = ""; $billing_from_date = ""; $billing_to_date = "";
    if(isset($_SESSION['billing_year']) && !empty($_SESSION['billing_year'])) {
        $billing_year = $_SESSION['billing_year'];
    }                        
    if(isset($_SESSION['billing_year_starting_date']) && !empty($_SESSION['billing_year_starting_date'])) {
        $billing_from_date = $_SESSION['billing_year_starting_date'];
        if(!empty($billing_from_date)) {
            $billing_from_date = date("Y-m-d", strtotime($billing_from_date));
        }
    }                        
    if(isset($_SESSION['billing_year_ending_date']) && !empty($_SESSION['billing_year_ending_date'])) {
        $billing_to_date = $_SESSION['billing_year_ending_date'];
        if(!empty($billing_to_date)) {
            $billing_to_date = date("Y-m-d", strtotime($billing_to_date));
        }
    }

    $year_list = array();
    $year_list = $obj->getBillingYearList();

    $year = date('Y'); $month = date("m");
    if(!empty($year) && !empty($month)) {
        $month = (int)$month;
        if($month <= 3) { $year = $year - 1; }
    }
    if(empty($billing_year)) {
        if(!empty($year)) {
            $_SESSION['billing_year'] = $year;
            $billing_year = $year;
            $_SESSION['billing_year_starting_date'] = "01-04-".$year;
            $_SESSION['billing_year_ending_date'] = "31-03-".($year + 1);
        }
    }
?>