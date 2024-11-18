<?php
	include("include.php");

	if(isset($_REQUEST['show_user_id'])) { 
        $show_user_id = $_REQUEST['show_user_id'];
        $show_user_id = trim($show_user_id);

        $name = ""; $mobile_number = ""; $username = ""; $password = ""; $role_id = ""; $godown_ids = ""; $branch_ids = "";
        $admin = 0; $permission_check = 0;
        if(!empty($show_user_id)) {
            $user_list = array();
            $user_list = $obj->getTableRecords($GLOBALS['user_table'], 'user_id', $show_user_id,'');
            if(!empty($user_list)) {
                foreach($user_list as $data) {
                    if(!empty($data['name'])) {
                        $name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['login_id'])) {
                        $username = $obj->encode_decode('decrypt', $data['login_id']);
                    }
                    if(!empty($data['password'])) {
                        $password = $obj->encode_decode('decrypt', $data['password']);
                    }
                    if(!empty($data['role_id']) && $data['role_id'] != $GLOBALS['null_value']) {
                        $role_id = $data['role_id'];
                        $permission_check = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'permission_check');
                    }
                    if(!empty($data['godown_id']) && $data['godown_id'] != $GLOBALS['null_value']) {
                        $godown_ids = explode(",", $data['godown_id']);
                    }
                    if(!empty($data['branch_id']) && $data['branch_id'] != $GLOBALS['null_value']) {
                        $branch_ids = explode(",", $data['branch_id']);
                    }
                    if(!empty($data['admin'])) {
                        $admin = $data['admin'];
                    }
                }
            }
        }
        
        $role_list = array();
        $role_list = $obj->getTableRecords($GLOBALS['role_table'], '', '','');

        $godown_list = array();
        $godown_list = $obj->getTableRecords($GLOBALS['godown_table'], '', '','');

        $branch_list = array();
        $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '','');
?>
        <form class="poppins pd-20 redirection_form" name="user_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_user_id)) { ?>
                            <div class="h5">Add User</div>
                        <?php } else { ?>
                            <div class="h5">Edit User</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('user.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_user_id)) { echo $show_user_id; } ?>">
                <div class="col-lg-9 col-md-7 col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 pb-3">
                            <div class="form-group mb-1">
                                <div class="form-label-group in-border">
                                    <input type="text" name="name" class="form-control shadow-none" value="<?php if(!empty($name)) { echo $name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                                    <label>Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.(Max Char : 25)</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 pb-3">
                            <div class="form-group mb-1">
                                <div class="form-label-group in-border">
                                    <input type="text" name="mobile_number" class="form-control shadow-none" value="<?php if(!empty($mobile_number)) { echo $mobile_number; } ?>" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                                    <label>Contact Number <span class="text-danger">*</span></label>
                                </div>
                                <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                            </div>
                        </div>
                        <?php if(empty($admin)) { ?>
                            <div class="col-lg-4 col-md-4 col-12 pb-3">
                                <div class="form-group">
                                    <div class="form-label-group in-border mb-0">
                                        <select name="role_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:RolePermission(this.value);">
                                            <option value="">Select Role</option>    
                                            <?php
                                                if(!empty($role_list)) {
                                                    foreach($role_list as $data) {
                                                        if(!empty($data['role_id'])) {
                                            ?>
                                                            <option value="<?php echo $data['role_id']; ?>" <?php if(!empty($role_id) && $data['role_id'] == $role_id) { ?>selected="selected"<?php } ?>>
                                                                <?php
                                                                    if(!empty($data['role_name'])) {
                                                                        $data['role_name'] = $obj->encode_decode('decrypt', $data['role_name']);
                                                                        echo($data['role_name']);
                                                                    }
                                                                ?>
                                                            </option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <label>Select Role <span class="text-danger">*</span></label>
                                    </div>
                                </div>        
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pb-3 <?php if($permission_check != '1') { ?>d-none<?php } ?>" id="godown_element">
                                <div class="form-group">
                                    <div class="form-label-group in-border mb-0">
                                        <select name="godown_id[]" class="form-control" id="choices-multiple-remove-button2" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
                                            <option value="">Select Godown</option>
                                            <?php
                                                if(!empty($godown_list)) {
                                                    foreach($godown_list as $data) {
                                                        if(!empty($data['godown_id'])) {
                                                            $godown_selected = 0;
                                                            if(!empty($godown_ids) && in_array($data['godown_id'], $godown_ids)) {
                                                                $godown_selected = 1;
                                                            }
                                            ?>
                                                            <option value="<?php echo $data['godown_id']; ?>" <?php if(!empty($godown_selected) && $godown_selected == 1) { ?>selected="selected"<?php } ?> >
                                                                <?php
                                                                    if(!empty($data['name'])) {
                                                                        $data['name'] = $obj->encode_decode('decrypt', $data['name']);
                                                                        echo($data['name']);
                                                                    }
                                                                ?>
                                                            </option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <label>Godown Name <span class="text-danger">*</span></label>
                                    </div>
                                </div>        
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pb-3 <?php if($permission_check != '2') { ?>d-none<?php } ?>" id="branch_element">
                                <div class="form-group">
                                    <div class="form-label-group in-border mb-0">
                                        <select name="branch_id[]" class="form-control" id="choices-multiple-remove-button3" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
                                            <option value="">Select Branch</option>
                                            <?php
                                                if(!empty($branch_list)) {
                                                    foreach($branch_list as $data) {
                                                        if(!empty($data['branch_id'])) {
                                                            $branch_selected = 0;
                                                            if(!empty($branch_ids) && in_array($data['branch_id'], $branch_ids)) {
                                                                $branch_selected = 1;
                                                            }
                                            ?>
                                                            <option value="<?php echo $data['branch_id']; ?>" <?php if(!empty($branch_selected) && $branch_selected == 1) { ?>selected="selected"<?php } ?> >
                                                                <?php
                                                                    if(!empty($data['prefix_name_mobile'])) {
                                                                        $data['prefix_name_mobile'] = $obj->encode_decode('decrypt', $data['prefix_name_mobile']);
                                                                        echo($data['prefix_name_mobile']);
                                                                    }
                                                                ?>
                                                            </option>
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <label>Branch Name <span class="text-danger">*</span></label>
                                    </div>
                                </div>        
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 pb-3">
                            <div class="form-group">
                                <div class="form-label-group in-border">
                                    <input type="text" class="form-control shadow-none" name="username" value="<?php if(!empty($username)) { echo $username; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                                    <label>User Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.(Max Char : 25)</div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div id="password_cover" class="form-group">
                                <div class="form-label-group in-border">
                                    <div class="input-group">
                                        <input type="password" class="form-control shadow-none" id="password" name="password" value="<?php if(!empty($password)) { echo $password; } ?>" onkeyup="Javascript:CheckPassword('password');" onfocus="Javascript:KeyboardControls(this,'password',20,'');" onkeydown="Javascript:InputBoxColor(this,'text');">
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
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'user_form', 'user_changes.php', 'user.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {
                    jQuery('.add_update_form_content').find('select').select2();

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

                    <?php
                        if(!empty($show_user_id)){ ?>CheckPassword('password');<?php }
                    ?>
                });
            </script>
        </form>
<?php
    } 

    if(isset($_POST['name'])) {	
        $name = ""; $name_error = "";  $mobile_number = ""; $mobile_number_error = ""; 	$username = ""; $username_error = "";
        $password = ""; $password_error = ""; $role_id = ""; $role_id_error = ""; $godown_ids = ""; $branch_ids = "";
        $permission_check = 0;
        $valid_user = ""; $form_name = "user_form";
        
        $edit_id = ""; $admin = 0;
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
            if(!empty($edit_id)) {
                $admin = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $edit_id, 'admin');
            }
        }
    
        $name = $_POST['name'];
        $name = trim($name);
        if(!empty($name) && strlen($name) > 25) {
            $name_error = "Only 25 characters allowed";
        }
        else {
            $name_error = $valid->valid_company_name($name,'name','1');
        }
        if(empty($name_error) && empty($edit_id)) {
            $user_list = array(); $user_count = 0;
            $user_list = $obj->getTableRecords($GLOBALS['user_table'], '', '','');
            if(!empty($user_list)) {
                $user_count = count($user_list);
            }
            if($user_count == $GLOBALS['max_user_count']) {
                $name_error = "Max.".$GLOBALS['max_user_count']." users are allowed";
            }
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

        if(empty($admin)) {
            if(isset($_POST['role_id'])) {
                $role_id = $_POST['role_id'];
                $role_id = trim($role_id);
            }
            if(!empty($role_id)) {
                $role_unique_id = "";
                $role_unique_id = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'id');
                $permission_check = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'permission_check');
                if(!preg_match("/^\d+$/", $role_unique_id)) {
                    $role_id_error = "Invalid role";
                }
            }
            else {
                $role_id_error = "Select the role";
            }
            if(!empty($role_id_error)) {
                if(!empty($valid_user)) {
                    $valid_user = $valid_user." ".$valid->error_display($form_name, "role_id", $role_id_error, 'select');
                }
                else {
                    $valid_user = $valid->error_display($form_name, "role_id", $role_id_error, 'select');
                }
            }

            if($permission_check == '1') {
                $godown_selected = 0; $godown_error = "";
                if(isset($_POST['godown_id'])) {
                    $godown_ids = $_POST['godown_id'];
                }
                if(!empty($godown_ids)) {
                    foreach($godown_ids as $godown_id) {
                        $godown_id = trim($godown_id);
                        if(!empty($godown_id)) {
                            $godown_unique_id = "";
                            $godown_unique_id = $obj->getTableColumnValue($GLOBALS['godown_table'], 'godown_id', $godown_id, 'id');
                            if(preg_match("/^\d+$/", $godown_unique_id)) {
                                $godown_selected = 1;
                            }
                            else {
                                $godown_error = "Invalid godown";
                            }
                        }
                    }
                }  
                else if(empty($godown_ids)) {
                    $godown_error = "Select the godown";
                }  
                if(!empty($godown_error)) {
                    if(!empty($valid_user)) {
                        $valid_user = $valid_user." ".$valid->error_display($form_name, "godown_id[]", $godown_error, 'select');
                    }
                    else {
                        $valid_user = $valid->error_display($form_name, "godown_id[]", $godown_error, 'select');
                    }
                }
            }

            if($permission_check == '2') {
                $branch_selected = 0; $branch_error = "";
                if(isset($_POST['branch_id'])) {
                    $branch_ids = $_POST['branch_id'];
                }
                if(!empty($branch_ids)) {
                    foreach($branch_ids as $branch_id) {
                        $branch_id = trim($branch_id);
                        if(!empty($branch_id)) {
                            $branch_unique_id = "";
                            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $branch_id, 'id');
                            if(preg_match("/^\d+$/", $branch_unique_id)) {
                                $branch_selected = 1;
                            }
                            else {
                                $branch_error = "Invalid branch";
                            }
                        }
                    }
                }      
                else if(empty($branch_ids)) {
                    $branch_error = "Select the Branch";
                }
                if(!empty($branch_error)) {
                    if(!empty($valid_user)) {
                        $valid_user = $valid_user." ".$valid->error_display($form_name, "branch_id[]", $branch_error, 'select');
                    }
                    else {
                        $valid_user = $valid->error_display($form_name, "branch_id[]", $branch_error, 'select');
                    }
                }
            }
        }

        $username = $_POST['username'];
        $username = trim($username);
        if(!empty($username) && strlen($username) > 25) {
            $username_error = "Only 25 digits allowed";
        }
        else {
            $username_error = $valid->valid_company_name($username,'user ID','1');
        }        
        if(!empty($username_error)) {
            if(!empty($valid_user)) {
                $valid_user = $valid_user." ".$valid->error_display($form_name, "username", $username_error, 'text');
            }
            else {
                $valid_user = $valid->error_display($form_name, "username", $username_error, 'text');
            }
        }

        $password = $_POST['password'];
        $password = trim($password);
        if(strpos($password," ") == true) {
            $password_error = "Password should not contain spaces";
        }
        else if(strlen($password) > 20) {
            $password_error = "Only 20 digits allowed(recommended)";
        }
        else {
            $password_error = $valid->valid_password($password, "Password", "1");
        }        
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
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $name_mobile = "";
                if(!empty($name)) {
                    $name_mobile = $name;
                    $name = $obj->encode_decode('encrypt', $name);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);
                    $mobile_number = trim($mobile_number);

                    if(!empty($name_mobile)) {
                        $name_mobile = $name_mobile." (".$mobile_number.")";
                        $name_mobile = $obj->encode_decode('encrypt', $name_mobile);
                    }

                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }

                if(!empty($godown_ids)) {
                    $godown_ids = implode(",", $godown_ids);
                }
                else {
                    $godown_ids = $GLOBALS['null_value'];
                }

                if(!empty($branch_ids)) {
                    $branch_ids = implode(",", $branch_ids);
                }
                else {
                    $branch_ids = $GLOBALS['null_value'];
                }

                $login_id = ""; $lower_case_login_id = "";
                if(!empty($username)) {
                    $login_id = $username;
                    $lower_case_login_id = strtolower($login_id);
                    $lower_case_login_id = $obj->encode_decode('encrypt', $lower_case_login_id);
                    $login_id = $obj->encode_decode('encrypt', $login_id);
                }
                if(!empty($password)) {
                    $password = $obj->encode_decode('encrypt', $password);
                }

                if($admin == '1') {
                    $role_id = $GLOBALS['null_value'];
                    $godown_ids = $GLOBALS['null_value'];
                    $branch_ids = $GLOBALS['null_value'];
                }
                if(empty($permission_check) || $permission_check == '3') {
                    $godown_ids = $GLOBALS['null_value'];
                    $branch_ids = $GLOBALS['null_value'];
                }
                else if($permission_check == '1') {
                    $branch_ids = $GLOBALS['null_value'];
                }
                else if($permission_check == '2') {
                    $godown_ids = $GLOBALS['null_value'];
                }
                $prev_user_id = ""; $user_error = "";		
                if(!empty($lower_case_login_id)) {
                    $prev_user_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'lower_case_login_id', $lower_case_login_id, 'user_id');
                    if(!empty($prev_user_id)) {
                        $user_error = "This User ID is already exist";
                    }
                }
                if(!empty($mobile_number) && empty($prev_user_id)) {
                    $prev_user_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'mobile_number', $mobile_number, 'user_id');
                    if(!empty($prev_user_id)) {
                        $user_error = "This Mobile Number already exist";
                    }
                }
                
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                
                if(empty($edit_id)) {
                    if(empty($prev_user_id)) {
                        $action = "";
                        if(!empty($name_mobile)) {
                            $action = "New User Created. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'user_id', 'name', 'mobile_number', 'name_mobile', 'role_id', 'godown_id', 'branch_id', 'login_id', 'lower_case_login_id', 'password', 'admin', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile."'", "'".$role_id."'", "'".$godown_ids."'", "'".$branch_ids."'", "'".$login_id."'", "'".$lower_case_login_id."'", "'".$password."'", "'".$admin."'", "'0'");
                        $user_insert_id = $obj->InsertSQL($GLOBALS['user_table'], $columns, $values, 'user_id', '', $action);
                        if(preg_match("/^\d+$/", $user_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'User Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $user_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $user_error);
                    }
                }
                else {
                    if(empty($prev_user_id) || $prev_user_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name_mobile)) {
                                $action = "User Updated. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'mobile_number', 'name_mobile', 'role_id', 'godown_id', 'branch_id', 'login_id', 'lower_case_login_id', 'password');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile."'", "'".$role_id."'", "'".$godown_ids."'", "'".$branch_ids."'", "'".$login_id."'", "'".$lower_case_login_id."'", "'".$password."'");
                            $user_update_id = $obj->UpdateSQL($GLOBALS['user_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $user_update_id)) {	
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $user_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $user_error);
                    }
                }

                if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
					$name = "";
					$name = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name');
					if(!empty($name)) {
						$name = $obj->encode_decode('decrypt', $name);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'] = $name;
						}
					}

					$mobile_number = "";
					$mobile_number = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'mobile_number');
					if(!empty($mobile_number)) {
						$mobile_number = $obj->encode_decode('decrypt', $mobile_number);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'] = $mobile_number;
						}
					}

					$name_mobile = "";
					$name_mobile = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name_mobile');
					if(!empty($name_mobile)) {
						$name_mobile = $obj->encode_decode('decrypt', $name_mobile);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'] = $name_mobile;
						}
					}
				}
    
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
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

    if(isset($_POST['page_number'])) {
		$page_number = $_POST['page_number'];
		$page_limit = $_POST['page_limit'];
		$page_title = $_POST['page_title']; 

        $total_records_list = array();
        $total_records_list = $obj->getUserList();
        
        $total_pages = 0;	
        $total_pages = count($total_records_list);
        
        $page_start = 0; $page_end = 0;
        if(!empty($page_number) && !empty($page_limit) && !empty($total_pages)) {
            if($total_pages > $page_limit) {
                if($page_number) {
                    $page_start = ($page_number - 1) * $page_limit;
                    $page_end = $page_start + $page_limit;
                }
            }
            else {
                $page_start = 0;
                $page_end = $page_limit;
            }
        }

        $show_records_list = array();
        if(!empty($total_records_list)) {
            foreach($total_records_list as $key => $val) {
                if($key >= $page_start && $key < $page_end) {
                    $show_records_list[] = $val;
                }
            }
        }
        
        $prefix = 0;
        if(!empty($page_number) && !empty($page_limit)) {
            $prefix = ($page_number * $page_limit) - $page_limit;
        } 
?>

        <?php if($total_pages > $page_limit) { ?>
            <div class="pagination_cover mt-3"> 
                <?php include("pagination.php"); ?> 
            </div> 
        <?php } ?>
        
		<table class="table nowrap cursor text-center smallfnt">
            <thead class="bg-light">
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($show_records_list)) { 
                        foreach($show_records_list as $key => $data) {
                            $index = $key + 1;
                            if(!empty($prefix)) { $index = $index + $prefix; } 
                ?>
                            <tr>
                                <td style="cursor:default;"><?php echo $index; ?></td>
                                <td>
                                    <?php
                                        if(!empty($data['name_mobile'])) {
                                            $data['name_mobile'] = $obj->encode_decode('decrypt', $data['name_mobile']);
                                            echo $data['name_mobile'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['role_name'])) {
                                            $data['role_name'] = $obj->encode_decode('decrypt', $data['role_name']);
                                            echo $data['role_name'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['user_id'])) { echo $data['user_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php if(empty($data['admin'])){ ?>
                                        <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['user_id'])) { echo $data['user_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                <?php 
                        } 
                    }  
                    else {
                ?>
                        <tr>
                            <td colspan="4" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php 
                    } 
                ?>
            </tbody>
        </table>   
                      
<?php	
	}

    if(isset($_REQUEST['delete_user_id'])) {
        $delete_user_id = $_REQUEST['delete_user_id'];
        $delete_user_id = trim($delete_user_id);
        $msg = "";
        if(!empty($delete_user_id)) {	
            $user_unique_id = "";
            $user_unique_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'id');
            if(preg_match("/^\d+$/", $user_unique_id)) {
                $admin = 0;
                $admin = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'admin');
                if(empty($admin)) {
                    $name_mobile = "";
                    $name_mobile = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'name_mobile');
                
                    $action = "";
                    if(!empty($name_mobile)) {
                        $action = "User Deleted. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                    }
                
                    $columns = array(); $values = array();						
                    $columns = array('deleted');
                    $values = array("'1'");
                    $msg = $obj->UpdateSQL($GLOBALS['user_table'], $user_unique_id, $columns, $values, $action);
                }
                else {
                    $msg = "Unable to delete";
                }    
            }
            else {
                $msg = "Invalid user";
            }
        }
        else {
            $msg = "Empty user";
        }
        echo $msg;
        exit;	
    }

    if(isset($_REQUEST['role_permission'])) {
        $role_id = $_REQUEST['role_permission'];
        $role_id = trim($role_id);
        $permission_check = 0;
        if($role_id != "" && $role_id != $GLOBALS['null_value']) {
            $permission_check = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'permission_check');
        }
        echo $permission_check;
    }
?>