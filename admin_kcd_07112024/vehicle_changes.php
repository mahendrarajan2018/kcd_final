<?php
	include("include.php");
   
	if(isset($_REQUEST['show_vehicle_id'])) { 
        $show_vehicle_id = $_REQUEST['show_vehicle_id']; 
        $show_vehicle_id = trim($show_vehicle_id);
        
        $vehicle_name = ""; $vehicle_number = ""; $contact_number = "";
        if(!empty($show_vehicle_id)) {
            $vehicle_list = array();
            $vehicle_list = $obj->getTableRecords($GLOBALS['vehicle_table'],'vehicle_id',$show_vehicle_id,'');
            if(!empty($vehicle_list)) {
                foreach($vehicle_list as $data) {
                    if(!empty($data['vehicle_name']) && $data['vehicle_name'] != $GLOBALS['null_value']) {
                        $vehicle_name = $obj->encode_decode('decrypt',$data['vehicle_name']);
                    }
                    if(!empty($data['vehicle_number']) && $data['vehicle_number'] != $GLOBALS['null_value']) {
                        $vehicle_number = $obj->encode_decode('decrypt',$data['vehicle_number']);
					}
                    if(!empty($data['contact_number']) && $data['contact_number'] != $GLOBALS['null_value']) {
                        $contact_number = $obj->encode_decode('decrypt',$data['contact_number']);
					}
                }
            }
        }
?>
        <form class="poppins pd-20 redirection_form" name="vehicle_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
					    <?php if(empty($show_vehicle_id)){ ?>
                            <div class="h5">Add Vehicles</div>
                        <?php } else { ?>
                            <div class="h5">Edit Vehicles</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('vehicle.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>

            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_vehicle_id)) { echo $show_vehicle_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="vehicle_name" name="vehicle_name" class="form-control shadow-none" value="<?php if(!empty($vehicle_name)) { echo $vehicle_name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                            <label>Vehicle Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Text & Symbols &,-,.,' only(Characters upto 25)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="vehicle_number" name="vehicle_number" class="form-control shadow-none" value="<?php if(!empty($vehicle_number)) { echo $vehicle_number; } ?>"  onkeydown="Javascript:KeyboardControls(this,'',15,'');InputBoxColor(this,'text');">
                            <label>Vehicle Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Format : TN 07 CM 2026</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="contact_number" name="contact_number" value="<?php if(!empty($contact_number)) { echo $contact_number; } ?>"class="form-control shadow-none"  onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                            <label>Contact Number  <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (10 digits)</div>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark" type="button" onClick="Javascript:SaveModalContent(event,'vehicle_form', 'vehicle_changes.php', 'vehicle.php');">
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
    if(isset($_POST['vehicle_name'])) {
        $vehicle_name = ""; $vehicle_name_error = ""; $vehicle_number = ""; $vehicle_number_error = "";
        $contact_number = ""; $contact_number_error = "";
        
        $valid_vehicle = ""; $form_name = "vehicle_form"; $edit_id = "";

        if(isset($_POST['edit_id'])) {
			$edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
		}

        $vehicle_name = $_POST['vehicle_name'];
        $vehicle_name = trim($vehicle_name);
        if(!empty($vehicle_name) && strlen($vehicle_name) > 25) {
            $vehicle_name_error = "Only 25 characters allowed";
        }
        else { 
            $vehicle_name_error = $valid->valid_company_name($vehicle_name,'Vehicle Name','1');
        }
        if(!empty($vehicle_name_error)) {
            if(!empty($valid_vehicle)) {
                $valid_vehicle = $valid_vehicle." ".$valid->error_display($form_name,'vehicle_name',$vehicle_name_error,'text');
            }
            else {
                $valid_vehicle = $valid->error_display($form_name,'vehicle_name',$vehicle_name_error,'text');
            }
        }

        $vehicle_number = $_POST['vehicle_number'];
        $vehicle_number = trim($vehicle_number);
        if(!empty($vehicle_name) && strlen($vehicle_number) > 15) {
            $vehicle_number_error = "Only 15 characters allowed";
        }
        else { 
            $vehicle_number_error = $valid->valid_vehicle_number($vehicle_number,'Vehicle Number','1');
        }
        if(!empty($vehicle_number_error)) {
            if(!empty($valid_vehicle)) {
                $valid_vehicle = $valid_vehicle." ".$valid->error_display($form_name,'vehicle_number',$vehicle_number_error,'text');
            }
            else {
                $valid_vehicle = $valid->error_display($form_name,'vehicle_number',$vehicle_number_error,'text');
            }
        }

        $contact_number = $_POST['contact_number'];
        $contact_number = trim($contact_number);
        $contact_number_error = $valid->valid_mobile_number($contact_number,'Contact Number','1');
        if(!empty($contact_number_error)) {
            if(!empty($valid_vehicle)) {
                $valid_vehicle = $valid_vehicle." ".$valid->error_display($form_name,'contact_number',$contact_number_error,'text');
            }
            else {
                $valid_vehicle = $valid->error_display($form_name,'contact_number',$contact_number_error,'text');
            }
        }

        $result = "";
		if(empty($valid_vehicle)) {
            $check_user_id_ip_address = "";
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $lower_case_name = "";$vehicle_details = "";
                if(!empty($vehicle_name)) {
                    $vehicle_details = $vehicle_name;
                    $lower_case_name = strtolower($vehicle_name);
                    $vehicle_name = $obj->encode_decode('encrypt', $vehicle_name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                }  

                $lower_case_number = "";
                if(!empty($vehicle_number)) {
                    if(!empty($vehicle_details)) {
                        $vehicle_details = $vehicle_details." - ".$vehicle_number;
                    }
                    $lower_case_number = str_replace(" ","",$vehicle_number);
                    $lower_case_number = strtolower($lower_case_number);
                    $vehicle_number = $obj->encode_decode('encrypt', $vehicle_number);
                    $lower_case_number = $obj->encode_decode('encrypt', $lower_case_number);
                } 
            
                if(!empty($contact_number)) {
                    if(!empty($vehicle_details)) {
                        $vehicle_details = $vehicle_details." (".$contact_number.")";
                    }
                    $contact_number = $obj->encode_decode('encrypt', $contact_number);
                }  

                if(!empty($vehicle_details)) {
                    $vehicle_details = $obj->encode_decode('encrypt',$vehicle_details);
                }

                $prev_vehicle_id = ""; $vehicle_error = "";
                if(!empty($lower_case_number)) {
                    $prev_vehicle_id = $obj->getTableColumnValue($GLOBALS['vehicle_table'],'lower_case_number',$lower_case_number,'vehicle_id');
                    if(!empty($prev_vehicle_id)) {
                        $vehicle_error = "This vehicle number is already exists";
                    }
                }

                if(!empty($contact_number) && empty($vehicle_error)) {
                    $prev_vehicle_id = $obj->getTableColumnValue($GLOBALS['vehicle_table'],'contact_number',$contact_number,'vehicle_id');
                    if(!empty($prev_vehicle_id)) {
                        $vehicle_error = "This Contact Number Already Exists";
                    }
                }

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                if(empty($edit_id)) {
                    if(empty($prev_vehicle_id)) {	
                        $action = "";
                        if(!empty($vehicle_name)) {
                            $action = "New Vehicle Created - ".$obj->encode_decode("decrypt",$vehicle_name);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'vehicle_id', 'vehicle_name', 'lower_case_name', 'vehicle_number',  'lower_case_number', 'contact_number', 'vehicle_details', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$vehicle_name."'", "'".$lower_case_name."'", "'".$vehicle_number."'", "'".$lower_case_number."'", "'".$contact_number."'", "'".$vehicle_details."'", "'0'");
                        $vehicle_insert_id = $obj->InsertSQL($GLOBALS['vehicle_table'], $columns, $values,'vehicle_id','', $action);

                        if(preg_match("/^\d+$/", $vehicle_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Vehicle Created Successfully');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $vehicle_insert_id);
                        }	
                    }
                    else {
                        if(!empty($vehicle_error)) {
                            $result = array('number' => '2', 'msg' => $vehicle_error);
                        }
                    }
                }
                else {
                    if(empty($prev_vehicle_id) || $prev_vehicle_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'vehicle_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($vehicle_name)) {
                                $action = "Vehicle Updated.Name - ".($obj->encode_decode('decrypt',$vehicle_name));
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'vehicle_name', 'lower_case_name', 'vehicle_number', 'lower_case_number', 'contact_number', 'vehicle_details');
                            $values = array("'".$creator_name."'", "'".$vehicle_name."'", "'".$lower_case_name."'", "'".$vehicle_number."'", "'".$lower_case_number."'", "'".$contact_number."'", "'".$vehicle_details."'");
                            $entry_update_id = $obj->UpdateSQL($GLOBALS['vehicle_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $entry_update_id)) {								
                                $result = array('number' => '1', 'msg' => 'Vehicle Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $entry_update_id);
                            }							
                        }
                    }
                    else {
                        if(!empty($vehicle_error)) {
                            $result = array('number' => '2', 'msg' => $vehicle_error);
                        }
                    }
                }
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
		}
		else {
			if(!empty($valid_vehicle)) {
				$result = array('number' => '3', 'msg' => $valid_vehicle);
			}
		}
		
		if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; 
        exit;
    }


    if(isset($_POST['page_number'])) {
		$page_number = $_POST['page_number'];
		$page_limit = $_POST['page_limit'];
		$page_title = $_POST['page_title']; 

        $search_text = "";
        if(isset($_POST['search_text'])) {
			$search_text = $_POST['search_text'];
		}
        
        $login_staff_id = "";
		if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
			$login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
		}

        $total_records_list = array();
        $total_records_list = $obj->getTableRecords($GLOBALS['vehicle_table'],'','','ASC'); 

        if(!empty($search_text)) {
			$search_text = strtolower($search_text);
			$list = array();
			if(!empty($total_records_list)) {
				foreach($total_records_list as $val) {
					if((strpos(strtolower($obj->encode_decode('decrypt', $val['vehicle_details'])), $search_text) !== false)) {
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
				<?php
					include("pagination.php");
				?> 
			</div> 
		<?php } ?>
        
		<table class="table nowrap cursor text-center smallfnt">
            <thead class="bg-light">
                <tr>
                    <th>S.No</th>
                    <th>Vehicle Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($show_records_list)) {
                        foreach($show_records_list as $key => $list) {
                            $index = $key + 1;
                            if(!empty($prefix)) { $index = $index + $prefix; } 
                ?>
                            <tr>
                                <td class="text-center" style="cursor:default;"><?php echo $index; ?></td>
                                
                                <td class="text-center" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['vehicle_id'])) { echo $list['vehicle_id']; } ?>');">
                                    <?php
                                        if(!empty($list['vehicle_details']) && $list['vehicle_details'] != $GLOBALS['null_value']) {
                                            $list['vehicle_details'] = $obj->encode_decode('decrypt', $list['vehicle_details']);
                                            echo($list['vehicle_details']);
                                        }
                                    ?>
                                    <div class="w-100 py-2">
                                        Creator :
                                        <?php
                                            if(!empty($list['creator_name'])) {
                                                $list['creator_name'] = $obj->encode_decode('decrypt', $list['creator_name']);
                                                echo $list['creator_name'];
                                            }
                                        ?>                                        
                                    </div>
                                </td>

                                <td>
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['vehicle_id'])) { echo $list['vehicle_id']; } ?>');" ><i class="fa fa-pencil"></i></a>
                                            
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['vehicle_id'])) { echo $list['vehicle_id']; } ?>', '<?php if(!empty($list['vehicle_name'])) { echo $list['vehicle_name']; } ?>');"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                <?php 
                        }
                    }
                    else {
                ?>
                        <tr>
                            <td colspan="5" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>      
<?php	
    }

    if(isset($_REQUEST['delete_vehicle_id'])) {
        $delete_vehicle_id = $_REQUEST['delete_vehicle_id'];
        $delete_vehicle_id = trim($delete_vehicle_id);
        $msg = "";
        if(!empty($delete_vehicle_id)) {	
            $vehicle_unique_id = "";
            $vehicle_unique_id = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'vehicle_id', $delete_vehicle_id, 'id');
        
            if(preg_match("/^\d+$/", $vehicle_unique_id)) {
                $name = "";
                $name = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'vehicle_id', $delete_vehicle_id, 'vehicle_name');
            
                $action = "";
                if(!empty($name)) {
                    $action = "Vehicle Deleted. Name - ".$obj->encode_decode('decrypt', $name);
                }
            
                $columns = array(); $values = array();						
                $columns = array('deleted');
                $values = array("'1'");
                $msg = $obj->UpdateSQL($GLOBALS['vehicle_table'], $vehicle_unique_id, $columns, $values, $action);
            }
            else {
                $msg = "Invalid Vehicle";
            }
        }
        else {
            $msg = "Empty Vehicle";
        }
        echo $msg;
        exit;	
    }
?>