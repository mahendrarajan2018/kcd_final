<?php 
	$page_title = "Login";
	include("include.php");

    $user_list = array(); $users_count = 0;
	$user_list = $obj->getTableRecords($GLOBALS['user_table'], '', '', '');
    if(!empty($user_list)) {
        $users_count = count($user_list);
    }

    if(isset($_POST['name'])) {	
		$name = ""; $name_error = "";  $mobile_number = ""; $mobile_number_error = ""; $login_id = ""; $login_id_error = ""; $password = ""; $password_error = ""; 
		$admin = 1;

		$valid_user = ""; $form_name = "register_form";
	
        $name = $_POST['name'];
		$name = trim($name);
		if(strlen($name) > 25){
            $name_error = "Only 25 characters allowed";
        }
        else{
            $name_error = $valid->valid_company_name($name,'name','1');
        }
		if(!empty($name_error)) {
			$valid_user = $valid->error_display($form_name, "name", $name_error, 'text');
		}

		$mobile_number = $_POST['mobile_number'];
		$mobile_number = trim($mobile_number);
		$mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
		if(!empty($mobile_number_error)) {
			if(!empty($valid_user)) {
				$valid_user = $valid_user." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
			}
			else {
				$valid_user = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
			}
		}

		$login_id = $_POST['login_id'];
        $login_id = trim($login_id);
		$login_id_error = $valid->valid_company_name($login_id, "User ID", "1");
		if(!empty($login_id_error)) {
			if(!empty($valid_user)) {
				$valid_user = $valid_user." ".$valid->error_display($form_name, "login_id", $login_id_error, 'text');
			}
			else {
				$valid_user = $valid->error_display($form_name, "login_id", $login_id_error, 'text');
			}
		}

		$password = $_POST['password'];
		$password = trim($password);
		$password_error = $valid->valid_password($password, "Password", "1");
		if(!empty($password_error)) {
			if(!empty($valid_user)) {
				$valid_user = $valid_user." ".$valid->error_display($form_name, "password", $password_error, 'input_group');
			}
			else {
				$valid_user = $valid->error_display($form_name, "password", $password_error, 'input_group');
			}
		}
		
		$result = "";
		
		if(empty($valid_user)) {
            $name_mobile = "";
            if(!empty($name)) {
                $name_mobile = $name;
                $name = $obj->encode_decode('encrypt', $name);
            }
            if(!empty($mobile_number)) {
                $mobile_number = str_replace(" ", "", $mobile_number);

                if(!empty($name_mobile)) {
                    $name_mobile = $name_mobile." (".$mobile_number.")";
                    $name_mobile = $obj->encode_decode('encrypt', $name_mobile);
                }

                $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
            }
            $lower_case_login_id = "";
            if(!empty($login_id)) {
                $lower_case_login_id = strtolower($login_id);
                $lower_case_login_id = $obj->encode_decode('encrypt', $lower_case_login_id);
                $login_id = $obj->encode_decode('encrypt', $login_id);
            }
            if(!empty($password)) {
                $password = $obj->encode_decode('encrypt', $password);
            }

            $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator']; $creator_name = $name_mobile;
            $role_id = $GLOBALS['null_value']; $godown_id = $GLOBALS['null_value']; $branch_id = $GLOBALS['null_value'];

            $action = "";
            if(!empty($name_mobile)) {
                $action = "New User Created. Details - ".$obj->encode_decode('decrypt', $name_mobile);
            }   
            
            $columns = array();$values = array();
            $columns = array('created_date_time', 'creator', 'creator_name', 'user_id', 'name', 'mobile_number', 'name_mobile', 'role_id', 'godown_id', 'branch_id', 'login_id', 'lower_case_login_id', 'password', 'admin', 'deleted');
            $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile."'", "'".$role_id."'", "'".$godown_id."'", "'".$branch_id."'", "'".$login_id."'", "'".$lower_case_login_id."'", "'".$password."'", "'".$admin."'", "'0'");
            $entry_insert_id = $obj->InsertSQL($GLOBALS['user_table'], $columns, $values, 'user_id', '', $action);						
            if(preg_match("/^\d+$/", $entry_insert_id)) {
                $result = array('number' => '1', 'msg' => 'User Successfully Created');
            }
            else {
                $result = array('number' => '2', 'msg' => $entry_insert_id);
            }	
		}
		else {
			if(!empty($valid_user)) {
				$result = array('number' => '3', 'msg' => $valid_user);
			}
		}
		
		if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
	}

    if(isset($_POST['username'])) {
		$username = ""; $username_error = ""; $password = ""; $password_error = "";	
		$valid_login = ""; $form_name = "login_form";

		$username = $_POST['username'];
		$username = trim($username);
		$username_error = $valid->common_validation($username, "Username", "text");
		if(!empty($username_error)) {
			$valid_login = $valid->error_display($form_name, "username", $username_error, 'text');
		}	
		
		$password = $_POST['password'];
		$password = trim($password);
		$password_error = $valid->common_validation($password, "password", "text");
		if(!empty($password_error)) {
			if(!empty($valid_login)) {
				$valid_login = $valid_login." ".$valid->error_display($form_name, "password", $password_error, 'text');
			}
			else {
				$valid_login = $valid->error_display($form_name, "password", $password_error, 'text');
			}
		}
		
		$result = "";
		
		if(empty($valid_login)) {		
			$login_id = ""; $check_users = array(); $check_password = "";
			if(!empty($username)) {
				$username = strtolower($username);
				$encrypted_username = $obj->encode_decode('encrypt', $username);
				$check_users = $obj->getTableRecords($GLOBALS['user_table'], 'lower_case_login_id', $encrypted_username, '');
				if(!empty($check_users)) {
					foreach($check_users as $data) {
						$login_id = $data['id'];
						$check_password = $data['password'];
					}
				}
			}

			if(!empty($login_id)) {		
				$password_match = 0;
				if($check_password == $obj->encode_decode('encrypt', $password)) {
					$password_match = 1;
				}

				if(!empty($password_match) && $password_match == 1) {
					$check_users = $obj->getTableRecords($GLOBALS['user_table'], 'id', $login_id, '');
					if(!empty($check_users)) {
						foreach($check_users as $data) {
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'] = $data['user_id'];
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'] =  $obj->encode_decode('decrypt', $data['name']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'] =  $obj->encode_decode('decrypt', $data['mobile_number']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'] =  $obj->encode_decode('decrypt', $data['name_mobile']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_login_id'] = $obj->encode_decode('decrypt', $data['login_id']);
                            if(!empty($data['role_id']) && $data['role_id'] != $GLOBALS['null_value']){
                                $role_name = "";
                                $role_name = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $data['role_id'], 'role_name');
                                if(!empty($role_name)) {
                                    $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] = $obj->encode_decode('decrypt', $role_name);
                                }
                            }
                            else{
                                $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] = $GLOBALS['admin_user_type'];
                            }
						}
					}
					
					if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
						$create_date_time = $GLOBALS['create_date_time_label'];			
						$ip_address = $_SERVER['REMOTE_ADDR'];
						$browser = $_SERVER['HTTP_USER_AGENT'];
						$os_detail = php_uname();
						
						$action = "";
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
							$action = "User Login. Details - ".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'].", IP Address - ".$ip_address;
						}

						$loginer_name = "";
                        if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
							$loginer_name = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'];
                            $loginer_name = $obj->encode_decode('encrypt', $loginer_name);
						}
						
						$columns = array('loginer_name', 'login_date_time', 'logout_date_time', 'ip_address', 'browser', 'os_detail', 'type', 'user_id', 'deleted');
						$values = array("'".$loginer_name."'", "'".$create_date_time."'", "'".$create_date_time."'", "'".$ip_address."'", "'".$browser."'", "'".$os_detail."'", "'".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']."'", "'".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']."'", "'0'");						
						$user_login_record_id = $obj->InsertSQL($GLOBALS['login_table'], $columns, $values, '', '', $action);						
						if(preg_match("/^\d+$/", $user_login_record_id)) {	
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'] = $user_login_record_id;
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'] = $ip_address;						
							if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'])) {
								$result = array('number' => '1', 'msg' => 'Login Successfully');
							}
						}
						else {
							$result = array('number' => '2', 'msg' => $user_login_record_id);
						}
					}
						
				}
				else {
					$result = array('number' => '2', 'msg' => 'Wrong password');
				}				
			}
			else {
				$result = array('number' => '2', 'msg' => 'Invalid login details');
			}	
		}
		else {
			$result = array('number' => '3', 'msg' => $valid_login);
		}
		
		if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
	}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(!empty($page_title)) { echo $page_title; } ?> | <?php if(!empty($project_title)) { echo $project_title; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Layout config Js -->
    <script src="js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- App Css-->
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="css/form.css">
    <!-- custom Css-->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="include/css/modify.css">
    <script src="include/js/common.js"></script>
</head>
<body>
<div class="auth-page-wrapper">
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>
        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="images/kcd_top_logo.png" alt="" height="150">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-danger">Welcome Back !</h5>
                                <p class="text-muted">Sign <?php if(!empty($users_count)) { ?>in<?php } else { ?>up<?php } ?> to continue to KCD Logistics.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <script type="text/javascript" src="include/js/creation_modules.js"></script>
                                <?php if(!empty($users_count)) { ?>
                                    <form name="login_form" method="post" class="redirection_form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <div class="form-group mb-1">
                                                        <div class="form-label-group in-border">
                                                            <input type="text" name="username" class="form-control shadow-none" value="" placeholder="">
                                                            <label>User Name <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <div class="form-label-group in-border">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control shadow-none" id="password" name="password" value="" placeholder="Password">
                                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                                <div style="position: inherit; top: 0px;" class="input-group-append" data-toggle="tooltip" data-placement="right" title="Show Password">
                                                                    <button class="btn btn-dark" type="button" id="passwordBtn" data-toggle="button" aria-pressed="false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-danger w-25 submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'login_form', 'index.php', 'dashboard.php');">Log In</button>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <form name="register_form" method="post" class="redirection_form">
                                        <div class="row">
                                            <div class="col-10 mx-auto">
                                                <div class="form-group mb-1 pb-3">
                                                    <div class="form-label-group in-border">
                                                        <input type="text" name="name" class="form-control shadow-none" value="" onkeydown="Javascript:KeyboardControls(this,'text',25,1);" placeholder="">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                                                </div>
                                            </div>
                                            <div class="col-10 mx-auto">
                                                <div class="form-group mb-1 pb-3">
                                                    <div class="form-label-group in-border">
                                                        <input type="text" name="mobile_number" class="form-control shadow-none" value="" placeholder="" onkeydown="Javascript:KeyboardControls(this,'mobile_number',10,'');">
                                                        <label>Mobile Number <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                                                </div>
                                            </div>
                                            <div class="col-10 mx-auto">
                                                <div class="form-group mb-1 pb-3">
                                                    <div class="form-label-group in-border">
                                                        <input type="text" name="login_id" class="form-control shadow-none" value="" placeholder="" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                                                        <label>User ID <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                                                </div>
                                            </div>
                                            <div class="col-10 mx-auto">
                                                <div id="password_cover" class="form-group mb-1 pb-3">
                                                    <div class="form-label-group in-border">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control shadow-none" id="password" name="password" value="" placeholder="Password" onkeyup="Javascript:CheckPassword('password');" onfocus="Javascript:KeyboardControls(this,'password',20,'');" onkeydown="Javascript:InputBoxColor(this,'text');">
                                                            <label for="password">Password <span class="text-danger">*</span></label>
                                                            <div style="position: inherit; top: 0px;" class="input-group-append" data-toggle="tooltip" data-placement="right" title="Show Password">
                                                                <button class="btn btn-danger" type="button" id="passwordBtn" data-toggle="button" aria-pressed="false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="smallfnt p-gray">Password must include:</div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="length_check" value="" id="defaultCheck1" disabled>
                                                        <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                                            8 - 20 characters
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="letter_check" value="" id="defaultCheck1" disabled>
                                                        <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                                            Atleast one upper case and lower case letter
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="number_symbol_check" value="" id="defaultCheck1" disabled>
                                                        <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                                            Atleast one number and one symbol
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="space_check" value="" id="defaultCheck1" disabled>
                                                        <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                                            No space
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-danger w-25 submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'register_form', 'index.php', 'index.php');">Submit</button>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">Copyright &copy; All Rights Reserved Developed By Srisoftwarez</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/waves.min.js"></script>
<script src="js/feather.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/dashboard-ecommerce.init.js"></script>
<script src="js/app.js"></script>
<script src="js/fonticons.js"></script>
<script src="js/particles.js"></script>
<script src="js/particles.app.js"></script>
<script>
        $(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    const passBtn = $("#passwordBtn");

    passBtn.click(togglePassword);

    function togglePassword() {
        const passInput = $("#password");
    if (passInput.attr("type") === "password") {
        passInput.attr("type", "text");
    } 
    else {
        passInput.attr("type", "password");
    }
  }
});
    </script>
</body>
</html>          