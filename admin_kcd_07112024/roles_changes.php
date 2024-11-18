<?php
	include("include.php");

	if(isset($_REQUEST['show_roles_id'])) { 
        $show_role_id = $_REQUEST['show_roles_id'];
        $show_role_id = trim($show_role_id);        

        $role_name = ""; $access_pages = ""; $access_page_actions = ""; $permission_check = 0;

        if(!empty($show_role_id)) {
            $role_list = array();
            $role_list = $obj->getTableRecords($GLOBALS['role_table'], 'role_id', $show_role_id, '');
            if(!empty($role_list)) {
                foreach($role_list as $data) {
                    if(!empty($data['role_name']) && $data['role_name'] != $GLOBALS['null_value']) {
                        $role_name = $obj->encode_decode('decrypt',$data['role_name']);
                    }
                    if(!empty($data['access_pages']) && $data['access_pages'] != $GLOBALS['null_value']) {
						$access_pages = explode(",", $data['access_pages']);
					}
					if(!empty($data['access_page_actions']) && $data['access_page_actions'] != $GLOBALS['null_value']) {
						$access_page_actions = explode(",", $data['access_page_actions']);
					}
                    if(!empty($data['permission_check']) && $data['permission_check'] != $GLOBALS['null_value']) {
                        $permission_check = $data['permission_check'];
                    }
                }
            }
        }

        $access_pages_list = $GLOBALS['access_pages_list'];          
?>
        <form class="poppins pd-20 redirection_form" name="roles_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_role_id)) { ?>
                            <div class="h5">Add Roles</div>
                        <?php } else { ?>
                            <div class="h5">Edit Roles</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('roles.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_role_id)) { echo $show_role_id; } ?>">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="role_name" class="form-control shadow-none" value="<?php if(!empty($role_name)) { echo $role_name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                            <label>Role Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Text only (Characters upto 25)</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="pb-2">Select Type <span class="text-danger">*</span> :</div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="godown_staff" name="permission_check" value="1" <?php if(!empty($permission_check) && $permission_check == '1') { ?>checked="checked"<?php } ?>>
                            <label class="form-check-label">Godown Staff</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="branch_staff" name="permission_check" value="2" <?php if(!empty($permission_check) && $permission_check == '2') { ?>checked="checked"<?php } ?>>
                            <label class="form-check-label">Branch Staff</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="other_staff" name="permission_check" value="3" <?php if(!empty($permission_check) && $permission_check == '3') { ?>checked="checked"<?php } ?>>
                            <label class="form-check-label">Both</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 pt-3">
                    <div class="table-responsive poppins">
                        <table class="table nowrap table-bordered smallfnt staff_access_table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Module</th>
                                    <th>Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php				
                                    if(!empty($access_pages_list)) {
                                        foreach($access_pages_list as $module) {
                                            if(!empty($module)) {
                                                $module_encrypted = "";
                                                $module_encrypted = $obj->encode_decode('encrypt', $module);
                                                $view_checkbox_value = 2; $add_checkbox_value = 2; $edit_checkbox_value = 2; $delete_checkbox_value = 2;
                                                $select_all_checkbox_value = 2;

                                                $module_selected = 0; $module_action = array();
                                                if(!empty($access_pages) && !empty($access_page_actions)) {
                                                    for($i = 0; $i < count($access_pages); $i++) {
                                                        if(!empty($access_pages[$i]) && $module_encrypted == $access_pages[$i]) {
                                                            if(!empty($access_page_actions[$i])) {
                                                                $module_action = explode("$$$", $access_page_actions[$i]);
                                                            }														
                                                        }
                                                    }
                                                    if(!empty($module_action)) {
                                                        if(in_array($view_action, $module_action)) {
                                                            $view_checkbox_value = 1;
                                                            $module_selected++;
                                                        }
                                                        if(in_array($add_action, $module_action)) {
                                                            $add_checkbox_value = 1;
                                                            $module_selected++;
                                                        }
                                                        if(in_array($edit_action, $module_action)) {
                                                            $edit_checkbox_value = 1;
                                                            $module_selected++;
                                                        }
                                                        if(in_array($delete_action, $module_action)) {
                                                            $delete_checkbox_value = 1;
                                                            $module_selected++;
                                                        }
                                                        if($module_selected == 4) {
                                                            $select_all_checkbox_value = 1;
                                                        }
                                                        
                                                    }
                                                }
                                ?>
                                                <tr>
                                                    <td><?php if(!empty($module)) { echo $module; } ?></td>
                                                    <td>
                                                        <div class="d-flex" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_cover"; } ?>">
                                                            <div class="form-check pe-3">
                                                                <input class="form-check-input" type="checkbox"  name="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_select_all"; } ?>" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_select_all"; } ?>" value="<?php if(!empty($select_all_checkbox_value)) { echo $select_all_checkbox_value; } ?>" <?php if(!empty($select_all_checkbox_value) && $select_all_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:SelectAllModuleActionToggle(this, '<?php if(!empty($module_encrypted)) { echo $module_encrypted."_select_all"; } ?>');">
                                                                <label class="form-check-label checkbox">
                                                                    Select All
                                                                </label>
                                                            </div>
                                                            <div class="form-check pe-3">
                                                                <input class="form-check-input" type="checkbox" name="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_view"; } ?>" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_view"; } ?>" value="<?php if(!empty($view_checkbox_value)) { echo $view_checkbox_value; } ?>" <?php if(!empty($view_checkbox_value) && $view_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php if(!empty($module_encrypted)) { echo $module_encrypted."_view"; } ?>');">
                                                                <label class="form-check-label checkbox">
                                                                    View
                                                                </label>
                                                            </div>
                                                            <div class="form-check pe-3">
                                                                <input class="form-check-input" type="checkbox" name="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_add"; } ?>" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_add"; } ?>" value="<?php if(!empty($add_checkbox_value)) { echo $add_checkbox_value; } ?>" <?php if(!empty($add_checkbox_value) && $add_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php if(!empty($module_encrypted)) { echo $module_encrypted."_add"; } ?>');">
                                                                <label class="form-check-label checkbox">
                                                                    Add
                                                                </label>
                                                            </div>
                                                            <div class="form-check pe-3">
                                                                <input class="form-check-input" type="checkbox" name="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_edit"; } ?>" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_edit"; } ?>" value="<?php if(!empty($edit_checkbox_value)) { echo $edit_checkbox_value; } ?>" <?php if(!empty($edit_checkbox_value) && $edit_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php if(!empty($module_encrypted)) { echo $module_encrypted."_edit"; } ?>');">
                                                                <label class="form-check-label checkbox">
                                                                    Edit
                                                                </label>
                                                            </div>
                                                            <div class="form-check pe-3">
                                                                <input class="form-check-input" type="checkbox" name="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_delete"; } ?>" id="<?php if(!empty($module_encrypted)) { echo $module_encrypted."_delete"; } ?>" value="<?php if(!empty($delete_checkbox_value)) { echo $delete_checkbox_value; } ?>" <?php if(!empty($delete_checkbox_value) && $delete_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php if(!empty($module_encrypted)) { echo $module_encrypted."_delete"; } ?>');">
                                                                <label class="form-check-label checkbox">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event,'roles_form', 'roles_changes.php', 'roles.php');">
                        Submit
                    </button>
                </div>
            </div>
        </form>
<?php
    } 
    if(isset($_POST['role_name'])) {
        $role_name = ""; $role_name_error = ""; $access_page_actions = array(); $access_pages = array(); 
        $permission_check = 0; $permission_check_error = "";
        $valid_role = ""; $form_name = "roles_form";

        if(isset($_POST['edit_id'])) {
			$edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
		}

        $role_name = $_POST['role_name'];
        $role_name = trim($role_name);
        if(!empty($role_name) && strlen($role_name) > 25) {
            $role_name_error = "Only 25 characters allowed";
        }
        else { 
            $role_name_error = $valid->valid_text($role_name, 'Role name', '1');
        }
        if(empty($role_name_error) && empty($edit_id)) {
            $role_list = array(); $role_count = 0;
            $role_list = $obj->getTableRecords($GLOBALS['role_table'], '', '','');
            if(!empty($role_list)) {
                $role_count = count($role_list);
            }
            if($role_count == $GLOBALS['max_role_count']) {
                $role_name_error = "Max. ".$GLOBALS['max_role_count']." roles are allowed";
            }
        }
        if(!empty($role_name_error)) {
            if(!empty($valid_role)) {
                $valid_role = $valid_role." ".$valid->error_display($form_name,'role_name',$role_name_error,'text');
            }
            else {
                $valid_role = $valid->error_display($form_name,'role_name',$role_name_error,'text');
            }
        }

        if(isset($_POST['permission_check'])) {
            $permission_check = $_POST['permission_check'];
            $permission_check = trim($permission_check);
            if($permission_check != '1' && $permission_check != '2' && $permission_check != '3') {
                $permission_check_error = "Staff Type Error";
            }
        }
        else {
            $permission_check_error = "Select staff type";
        }
        if(!empty($permission_check_error)) {
            if(!empty($valid_role)) {
                $valid_role = $valid_role." ".$valid->error_display($form_name, "permission_check", $permission_check_error, 'radio');
            }
            else {
                $valid_role = $valid->error_display($form_name, "permission_check", $permission_check_error, 'radio');
            }
        }

        $user_access_pages_list = $GLOBALS['access_pages_list']; $module_selected = 0;
		if(!empty($user_access_pages_list)) {
			foreach($user_access_pages_list as $module) {
				if(!empty($module)) {
					$module_encrypted = "";
					$module_encrypted = $obj->encode_decode('encrypt', $module);
					$module_action = array(); 
					$view_checkbox_value = 2; $add_checkbox_value = 2; $edit_checkbox_value = 2; $delete_checkbox_value = 2;
					$view_field = $module_encrypted."_view"; $add_field = $module_encrypted."_add"; $edit_field = $module_encrypted."_edit"; 
					$delete_field = $module_encrypted."_delete";

					if(isset($_POST[$view_field])) {
						$view_checkbox_value = $_POST[$view_field];
						$view_checkbox_value = trim($view_checkbox_value);
					}
					if($view_checkbox_value != 1 && $view_checkbox_value != 2) { $view_checkbox_value = 2; }
					if($view_checkbox_value == 1) { 
						$module_action[] = $view_action;
					}

					if(isset($_POST[$add_field])) {
						$add_checkbox_value = $_POST[$add_field];
						$add_checkbox_value = trim($add_checkbox_value);
					}
					if($add_checkbox_value != 1 && $add_checkbox_value != 2) { $add_checkbox_value = 2; }
					if($add_checkbox_value == 1) { 
						$module_action[] = $add_action;
					}

					if(isset($_POST[$edit_field])) {
						$edit_checkbox_value = $_POST[$edit_field];
						$edit_checkbox_value = trim($edit_checkbox_value);
					}
					if($edit_checkbox_value != 1 && $edit_checkbox_value != 2) { $edit_checkbox_value = 2; }
					if($edit_checkbox_value == 1) { 
						$module_action[] = $edit_action;
					}
					if(isset($_POST[$delete_field])) {
						$delete_checkbox_value = $_POST[$delete_field];
						$delete_checkbox_value = trim($delete_checkbox_value);
					}
					if($delete_checkbox_value != 1 && $delete_checkbox_value != 2) { $delete_checkbox_value = 2; }
					if($delete_checkbox_value == 1) { 
						$module_action[] = $delete_action;
					}
					if(!empty($module_action) && count($module_action) > 0) {
						$access_pages[] = $module_encrypted;
						$access_page_actions[] = implode("$$$", $module_action);
						$module_selected = 1;
					}
				}
			}
		}

        $access_permission_error = "";
		if(empty($module_selected)) {
			$access_permission_error = "Select the access permission";
		}

        $result = "";
		if(empty($valid_role) && empty($access_permission_error)) {
            $check_user_id_ip_address = "";
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $lower_case_name = "";
                if(!empty($role_name)) {
                    $lower_case_name = strtolower($role_name);
                    $role_name = $obj->encode_decode('encrypt', $role_name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                }   

                if(!empty($access_pages)) {
                    $access_pages = implode(",", $access_pages);
                }
                if(!empty($access_page_actions)) {
                    $access_page_actions = implode(",", $access_page_actions);
                }
                
                $prev_role_id = ""; $role_error = "";
                if(!empty($lower_case_name)) {
                    $prev_role_id = $obj->getTableColumnValue($GLOBALS['role_table'], 'lower_case_name', $lower_case_name, 'role_id');
                    if(!empty($prev_role_id)) {
                        $role_error = "This role name already exists";
                    }
                }

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(empty($edit_id)) {
                    if(empty($prev_role_id)) {						
                        $action = "";
                        if(!empty($role_name)) {
                            $action = "New Role Created - ".$obj->encode_decode("decrypt",$role_name);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'role_id', 'role_name', 'lower_case_name', 'access_pages', 'access_page_actions', 'permission_check', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$role_name."'", "'".$lower_case_name."'", "'".$access_pages."'", "'".$access_page_actions."'", "'".$permission_check."'", "'0'");
                        $role_insert_id = $obj->InsertSQL($GLOBALS['role_table'], $columns, $values,'role_id','', $action);
                        if(preg_match("/^\d+$/", $role_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Role Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $role_insert_id);
                        }
                    }
                    else {
                        if(!empty($role_error)) {
                            $result = array('number' => '2', 'msg' => $role_error);
                        }
                    }
                }
                else {
                    if(empty($prev_role_id) || $prev_role_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($role_name)) {
                                $action = "Role Updated - ".$obj->encode_decode("decrypt",$role_name);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'role_name', 'lower_case_name', 'access_pages', 'access_page_actions', 'permission_check');
                            $values = array("'".$creator_name."'", "'".$role_name."'", "'".$lower_case_name."'", "'".$access_pages."'", "'".$access_page_actions."'", "'".$permission_check."'");
                            $entry_update_id = $obj->UpdateSQL($GLOBALS['role_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $entry_update_id)) {								
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $entry_update_id);
                            }							
                        }
                    }
                    else {
                        if(!empty($role_error)) {
                            $result = array('number' => '2', 'msg' => $role_error);
                        }
                    }
                }

            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
		}
		else {
			if(!empty($valid_role)) {
				$result = array('number' => '3', 'msg' => $valid_role);
			}
            else if(!empty($access_permission_error)) {
				$result = array('number' => '2', 'msg' => $access_permission_error);
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
        $total_records_list = $obj->getTableRecords($GLOBALS['role_table'], '', '', ''); 

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
                                <td class="text-center" style="cursor:default;"><?php echo $index; ?></td>
                                <td class="text-center">
                                    <?php
                                        if(!empty($data['role_name'])) {
                                            $data['role_name'] = $obj->encode_decode('decrypt', $data['role_name']);
                                            echo($data['role_name']);
                                        }
                                    ?>
                                    <div class="w-100 py-2">
                                        Creator :
                                        <?php
                                            if(!empty($data['creator_name'])) {
                                                $data['creator_name'] = $obj->encode_decode('decrypt', $data['creator_name']);
                                                echo $data['creator_name'];
                                            }
                                        ?>                                        
                                    </div>
                                </td>
                                <td>
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['role_id'])) { echo $data['role_id']; } ?>');"><i class="fa fa-pencil"></i></a>
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['role_id'])) { echo $data['role_id']; } ?>');"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                    else {
                ?>
                        <tr>
                            <td colspan="3" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>  
<?php	
	}

    if(isset($_REQUEST['delete_roles_id'])) {
        $delete_role_id = $_REQUEST['delete_roles_id'];
        $delete_role_id = trim($delete_role_id);
        $msg = "";
        if(!empty($delete_role_id)) {
            $role_unique_id = "";
            $role_unique_id = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $delete_role_id, 'id');
            if(preg_match("/^\d+$/", $role_unique_id)) {               
                $role_name = "";
                $role_name = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $delete_role_id, 'role_name');

                $action = "";
                if(!empty($role_name)) {
                    $action = "Role Deleted - ".$obj->encode_decode("decrypt", $role_name);
                }

                $columns = array(); $values = array();					
                $columns = array('deleted');
                $values = array("'1'");
                $msg = $obj->UpdateSQL($GLOBALS['role_table'], $role_unique_id, $columns, $values, $action);
            }
            else {
                $msg = "Invalid role";
            }
        }
        else {
            $msg = "Empty role";
        }
        echo $msg;
        exit;	
    }
?>