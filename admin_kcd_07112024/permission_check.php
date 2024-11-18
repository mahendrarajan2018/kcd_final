<?php

    if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
            $access_page_permission = 0;
            if(!empty($permission_page)) {
                $staff_id = "";
                if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
                    $staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
                }
                if(!empty($staff_id)) {
                    $access_page_permission = $obj->CheckStaffAccessPage($staff_id ,$permission_page);
                    if(empty($access_page_permission)) {
                        header("Location:dashboard.php");
                        exit;

                        /*$staff_redirection_page = "";
                        $staff_redirection_page = $obj->getStaffRedirectionPage($staff_id);
                        if(!empty($staff_redirection_page)) {
                            header("Location:".$staff_redirection_page);
                            exit;
                        }*/
                    }
                }
            }
        }
    }

?>