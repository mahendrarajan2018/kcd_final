<?php
	include("include.php");

	if(isset($_REQUEST['show_branch_id'])) { 
        $show_branch_id = $_REQUEST['show_branch_id'];
        $show_branch_id = trim($show_branch_id);

        $name = ""; $mobile_number = ""; $prefix = ""; $address = ""; $godown_ids = "";
        if(!empty($show_branch_id)) {
            $branch_list = array();
            $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], 'branch_id', $show_branch_id, '');
            if(!empty($branch_list)) {
                foreach($branch_list as $data) {
                    if(!empty($data['name'])) {
                        $name = $obj->encode_decode('decrypt',$data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $mobile_number = $obj->encode_decode('decrypt',$data['mobile_number']);
                    }
                    if(!empty($data['prefix'])) {
                        $prefix = $obj->encode_decode('decrypt',$data['prefix']);
                    }
                    if(!empty($data['address']) && $data['address'] != $GLOBALS['null_value']) {
                        $address = $obj->encode_decode('decrypt',$data['address']);
                    }
                    if(!empty($data['godown_id'])) {
                        $godown_ids = explode(",", $data['godown_id']);
                    }
                }
            }
        }        

        $godown_list = array();
        $godown_list = $obj->getTableRecords($GLOBALS['godown_table'], '', '','');
?>
        <form class="poppins pd-20 redirection_form" name="branch_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_branch_id)) { ?>
                            <div class="h5">Add Branch</div>
                        <?php } else { ?>
                            <div class="h5">Edit Branch</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('branch.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_branch_id)) { echo $show_branch_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="name" class="form-control shadow-none" value="<?php if(!empty($name)) { echo $name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',50,1);">
                            <label>Branch Name <span class="text-danger">*</span> </label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.(Max Char : 50)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="mobile_number" class="form-control shadow-none" value="<?php if(!empty($mobile_number)) { echo $mobile_number; } ?>" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                            <label>Mobile Number <span class="text-danger">*</span> </label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="prefix" class="form-control shadow-none" value="<?php if(!empty($prefix)) { echo $prefix; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',3,1);">
                            <label>Branch Prefix <span class="text-danger">*</span> </label>
                        </div>
                        <div class="new_smallfnt">Max.3 characters Allowed</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <textarea class="form-control" name="address" onkeydown="Javascript:KeyboardControls(this,'',150,'');InputBoxColor(this,'text');"><?php if(!empty($address)) { echo $address; } ?></textarea>
                            <label>Branch Address</label>
                        </div>
                        <div class="new_smallfnt">Contains Text,Numbers,Symbols(Except <>?{}!*^%$)(Max Char: 150)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border mb-0">
                            <select class="form-control" name="godown_id[]" id="choices-multiple-remove-button2" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple onchange="InputBoxColor(this,'select');">
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
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'branch_form', 'branch_changes.php', 'branch.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {
                    jQuery('.add_update_form_content').find('select').select2();
                });
            </script>
        </form>
		<?php
    } 

    if(isset($_POST['name'])) {	
        $name = ""; $name_error = "";  $mobile_number = ""; $mobile_number_error = ""; $prefix = ""; $prefix_error = "";
        $address = ""; $address_error = ""; $godown_ids = array();
        $valid_branch = ""; $form_name = "branch_form";

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
    
        $name = $_POST['name'];
        $name = trim($name);
        if(!empty($name) && strlen($name) > 50) {
            $name_error = "Only 50 characters allowed";
        }
        else {
            $name_error = $valid->valid_company_name($name,'name','1');
        }
        if(empty($name_error) && empty($edit_id)) {
            $branch_list = array(); $branch_count = 0;
            $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '','');
            if(!empty($branch_list)) {
                $branch_count = count($branch_list);
            }
            if($branch_count == $GLOBALS['max_branch_count']) {
                $name_error = "Max.".$GLOBALS['max_branch_count']." branch are allowed";
            }
        }
        if(!empty($name_error)) {
            $valid_branch = $valid->error_display($form_name, "name", $name_error, 'text');			
        }

        $mobile_number = $_POST['mobile_number'];
        $mobile_number = trim($mobile_number);
        $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
        if(!empty($mobile_number_error)) {
            if(!empty($valid_branch)) {
                $valid_branch = $valid_branch." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
            else {
                $valid_branch = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
        }

        $prefix = $_POST['prefix'];
        $prefix = trim($prefix);
        $prefix_error = $valid->valid_text($prefix,'prefix','1');
        if(!empty($prefix) && empty($prefix_error)) {
            if(strlen($prefix) > 3) {
                $prefix_error = "Max.3 characters are allowed";
            }
        }
        if(!empty($prefix_error)) {
            if(!empty($valid_branch)) {
                $valid_branch = $valid_branch." ".$valid->error_display($form_name, "prefix", $prefix_error, 'text');
            }
            else {
                $valid_branch = $valid->error_display($form_name, "prefix", $prefix_error, 'text');
            }
        }

        $address = $_POST['address'];
        $address = trim($address);
        if(!empty($address)) {
            if(strlen($address) > 150) {
                $address_error = "Only 150 characters allowed";
            }
            else {
                $address_error = $valid->valid_address($address, "address", "0");
            }
        }
        if(!empty($address_error)) {
            if(!empty($valid_branch)) {
                $valid_branch = $valid_branch." ".$valid->error_display($form_name, "address", $address_error, 'textarea');
            }
            else {
                $valid_branch = $valid->error_display($form_name, "address", $address_error, 'textarea');
            }
        }

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
        if(empty($godown_selected) && empty($godown_error)) {
            $godown_error = "Select the godown";
        }        
        if(!empty($godown_error)) {
            if(!empty($valid_branch)) {
                $valid_branch = $valid_branch." ".$valid->error_display($form_name, "godown_id[]", $godown_error, 'select');
            }
            else {
                $valid_branch = $valid->error_display($form_name, "godown_id[]", $godown_error, 'select');
            }
        }   
    
        $result = "";
        
        if(empty($valid_branch)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
    
                $prefix_name_mobile = ""; $lower_case_prefix = "";
                if(!empty($prefix)) {
                    $lower_case_prefix = strtolower($prefix);
                    $prefix_name_mobile = $prefix;
                    $lower_case_prefix = $obj->encode_decode('encrypt', $lower_case_prefix);
                    $prefix = $obj->encode_decode('encrypt', $prefix);
                }
                $lower_case_name = "";
                if(!empty($name)) {
                    $lower_case_name = strtolower($name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                    if(!empty($prefix_name_mobile)) {
                        $prefix_name_mobile = $prefix_name_mobile." - ".$name;
                    }
                    $name = $obj->encode_decode('encrypt', $name);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);

                    if(!empty($prefix_name_mobile)) {
                        $prefix_name_mobile = $prefix_name_mobile." (".$mobile_number.")";
                        $prefix_name_mobile = $obj->encode_decode('encrypt', $prefix_name_mobile);
                    }

                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }
                if(!empty($address)) {
                    $address = $obj->encode_decode('encrypt', $address);
                }

                if(!empty($godown_ids)) {
                    $godown_ids = implode(",", $godown_ids);
                }
                
                $prev_branch_id = ""; $branch_error = "";		
                if(!empty($lower_case_name)) {
                    $prev_branch_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'lower_case_name', $lower_case_name, 'branch_id');
                    if(!empty($prev_branch_id)) {
                        $branch_error = "This name is already exist";
                    }
                }
                if(!empty($mobile_number) && empty($branch_error)) {
                    $prev_branch_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'mobile_number', $mobile_number, 'branch_id');
                    if(!empty($prev_branch_id)) {
                        $branch_error = "This mobile number already exist";
                    }
                }
                if(!empty($lower_case_prefix) && empty($branch_error)) {
                    $prev_branch_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'lower_case_prefix', $lower_case_prefix, 'branch_id');
                    if(!empty($prev_branch_id)) {
                        $branch_error = "This prefix already exist";
                    }
                }
                
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                
                if(empty($edit_id)) {
                    if(empty($prev_branch_id)) {
                        $action = "";
                        if(!empty($prefix_name_mobile)) {
                            $action = "New Branch Created. Details - ".$obj->encode_decode('decrypt', $prefix_name_mobile);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array('created_date_time', 'creator', 'creator_name', 'branch_id', 'name', 'lower_case_name', 'mobile_number', 'prefix', 'lower_case_prefix', 'prefix_name_mobile', 'address', 'godown_id', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$lower_case_name."'", "'".$mobile_number."'", "'".$prefix."'", "'".$lower_case_prefix."'", "'".$prefix_name_mobile."'", "'".$address."'", "'".$godown_ids."'", "'0'");
                        $branch_insert_id = $obj->InsertSQL($GLOBALS['branch_table'], $columns, $values, 'branch_id', '', $action);
                        if(preg_match("/^\d+$/", $branch_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Branch Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $branch_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $branch_error);
                    }
                }
                else {
                    if(empty($prev_branch_id) || $prev_branch_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($prefix_name_mobile)) {
                                $action = "Branch Updated. Details - ".$obj->encode_decode('decrypt', $prefix_name_mobile);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'lower_case_name', 'mobile_number', 'prefix', 'lower_case_prefix', 'prefix_name_mobile', 'address', 'godown_id');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$lower_case_name."'", "'".$mobile_number."'", "'".$prefix."'", "'".$lower_case_prefix."'", "'".$prefix_name_mobile."'", "'".$address."'", "'".$godown_ids."'");
                            $branch_update_id = $obj->UpdateSQL($GLOBALS['branch_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $branch_update_id)) {	
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $branch_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $branch_error);
                    }
                }    
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_branch)) {
                $result = array('number' => '3', 'msg' => $valid_branch);
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
        
        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = $_POST['search_text'];
        }

        $total_records_list = array();
        $total_records_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');

        if(!empty($search_text)) {
            $search_text = strtolower($search_text);
            $list = array();
            if(!empty($total_records_list)) {
                foreach($total_records_list as $val) {
                    if(strpos(strtolower($obj->encode_decode('decrypt', $val['prefix_name_mobile'])), $search_text) !== false) {
                        $list[] = $val;
                    }
                }
            }
            $total_records_list = $list;
        }
        
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
                                        if(!empty($data['prefix_name_mobile'])) {
                                            $data['prefix_name_mobile'] = $obj->encode_decode('decrypt', $data['prefix_name_mobile']);
                                            echo $data['prefix_name_mobile'];
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
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['branch_id'])) { echo $data['branch_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['branch_id'])) { echo $data['branch_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                <?php 
                    } 
                ?>
            </tbody>
        </table>   
                      
		<?php	
	}

    if(isset($_REQUEST['delete_branch_id'])) {
        $delete_branch_id = $_REQUEST['delete_branch_id'];
        $delete_branch_id = trim($delete_branch_id);
        $msg = "";
        if(!empty($delete_branch_id)) {
            $branch_unique_id = "";
            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $delete_branch_id, 'id');
            if(preg_match("/^\d+$/", $branch_unique_id)) {
                $branch_user_count = 0;
                $branch_user_count = $obj->getBranchUserCount($delete_branch_id);
                if(empty($branch_user_count)) {
                    $prefix_name_mobile = "";
                    $prefix_name_mobile = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $delete_branch_id, 'prefix_name_mobile');
                
                    $action = "";
                    if(!empty($prefix_name_mobile)) {
                        $action = "Branch Deleted. Details - ".$obj->encode_decode('decrypt', $prefix_name_mobile);
                    }
                
                    $columns = array(); $values = array();						
                    $columns = array('deleted');
                    $values = array("'1'");
                    $msg = $obj->UpdateSQL($GLOBALS['branch_table'], $branch_unique_id, $columns, $values, $action);
                }
                else {
                    $msg = "Unable To delete";
                }    
            }
            else {
                $msg = "Invalid branch";
            }
        }
        else {
            $msg = "Empty branch";
        }
        echo $msg;
        exit;	
    }
?>