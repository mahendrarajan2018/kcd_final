<?php
	include("include.php");

	if(isset($_REQUEST['show_godown_id'])) { 
        $show_godown_id = $_REQUEST['show_godown_id'];
        $show_godown_id = trim($show_godown_id);        

        $name = "";
        if(!empty($show_godown_id)) {
            $godown_list = array();
            $godown_list = $obj->getTableRecords($GLOBALS['godown_table'], 'godown_id', $show_godown_id, '');
            if(!empty($godown_list)) {
                foreach($godown_list as $data) {
                    if(!empty($data['name'])) {
                        $name = $obj->encode_decode('decrypt',$data['name']);
                    }
                }
            }
        }
?>
        <form class="poppins pd-20 redirection_form" name="godown_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_godown_id)) { ?>
                            <div class="h5">Add Godown</div>
                        <?php } else{ ?>
                            <div class="h5">Edit Godown</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('godown.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_godown_id)) { echo $show_godown_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 mx-auto">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="name" class="form-control shadow-none" value="<?php if(!empty($name)) { echo $name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',50,1);">
                            <label>Godown Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.(Max Char : 50)</div>
                    </div>
                </div>                
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'godown_form', 'godown_changes.php', 'godown.php');">
                        Submit
                    </button>
                </div>
            </div>
        </form>
<?php
    } 
    if(isset($_POST['name'])) {
        $name = ""; $name_error = "";
        $valid_godown = ""; $form_name = "godown_form";

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
            $name_error = $valid->valid_company_name($name, 'name', '1');
        }
        if(empty($name_error) && empty($edit_id)) {
            $godown_list = array(); $godown_count = 0;
            $godown_list = $obj->getTableRecords($GLOBALS['godown_table'], '', '','');
            if(!empty($godown_list)) {
                $godown_count = count($godown_list);
            }
            if($godown_count == $GLOBALS['max_godown_count']) {
                $name_error = "Max.".$GLOBALS['max_godown_count']." godown are allowed";
            }
        }
        if(!empty($name_error)) {
            if(!empty($valid_godown)) {
                $valid_godown = $valid_godown." ".$valid->error_display($form_name,'name',$name_error,'text');
            }
            else{
                $valid_godown = $valid->error_display($form_name,'name',$name_error,'text');
            }
        }

        $result = "";
		if(empty($valid_godown)) {
            $check_user_id_ip_address = "";
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

                $lower_case_name = "";
                if(!empty($name)) {
                    $lower_case_name = strtolower($name);
                    $name = $obj->encode_decode('encrypt', $name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                }  
                
                $prev_godown_id = ""; $godown_error = "";
                if(!empty($lower_case_name)) {
                    $prev_godown_id = $obj->getTableColumnValue($GLOBALS['godown_table'], 'lower_case_name', $lower_case_name, 'godown_id');
                    if(!empty($prev_godown_id)) {
                        $godown_error = "This name already exists";
                    }
                }

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                if(empty($edit_id)) {
                    if(empty($prev_godown_id)) {						
                        $action = "";
                        if(!empty($name)) {
                            $action = "New Godown Created - ".$obj->encode_decode("decrypt",$name);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array('created_date_time', 'creator', 'creator_name', 'godown_id', 'name', 'lower_case_name', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$lower_case_name."'", "'0'");
                        $godown_insert_id = $obj->InsertSQL($GLOBALS['godown_table'], $columns, $values,'godown_id','', $action);
                        if(preg_match("/^\d+$/", $godown_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Godown Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $godown_insert_id);
                        }
                    }
                    else {
                        if(!empty($godown_error)) {
                            $result = array('number' => '2', 'msg' => $godown_error);
                        }
                    }
                }
                else {
                    if(empty($prev_godown_id) || $prev_godown_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['godown_table'], 'godown_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name)) {
                                $action = "Godown Updated - ".$obj->encode_decode("decrypt",$name);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'lower_case_name');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$lower_case_name."'");
                            $entry_update_id = $obj->UpdateSQL($GLOBALS['godown_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $entry_update_id)) {								
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $entry_update_id);
                            }							
                        }
                    }
                    else {
                        if(!empty($godown_error)) {
                            $result = array('number' => '2', 'msg' => $godown_error);
                        }
                    }
                }

            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
		}
		else {
			if(!empty($valid_godown)) {
				$result = array('number' => '3', 'msg' => $valid_godown);
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
        $total_records_list = $obj->getTableRecords($GLOBALS['godown_table'], '', '', ''); 

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
                    <th>Godown</th>
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
                                        if(!empty($data['name'])) {
                                            $data['name'] = $obj->encode_decode('decrypt', $data['name']);
                                            echo($data['name']);
                                        }
                                    ?>
                                    <div class="w-100 py-1">
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
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['godown_id'])) { echo $data['godown_id']; } ?>');"><i class="fa fa-pencil"></i></a>
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['godown_id'])) { echo $data['godown_id']; } ?>');"><i class="fa fa-trash"></i></a>
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

    if(isset($_REQUEST['delete_godown_id'])){
        $delete_godown_id = $_REQUEST['delete_godown_id'];
        $delete_godown_id = trim($delete_godown_id);
        $msg = "";
        if(!empty($delete_godown_id)) {
            $godown_unique_id = "";
            $godown_unique_id = $obj->getTableColumnValue($GLOBALS['godown_table'], 'godown_id', $delete_godown_id, 'id');
            if(preg_match("/^\d+$/", $godown_unique_id)) {  
                $godown_rows = 0;
                $godown_rows = $obj->getBranchUserCountByGodown($delete_godown_id);
                if(empty($godown_rows)) {             
                    $name = "";
                    $name = $obj->getTableColumnValue($GLOBALS['godown_table'], 'godown_id', $delete_godown_id, 'name');

                    $action = "";
                    if(!empty($name)) {
                        $action = "Godown Deleted - ".$obj->encode_decode("decrypt", $name);
                    }

                    $columns = array(); $values = array();					
                    $columns = array('deleted');
                    $values = array("'1'");
                    $msg = $obj->UpdateSQL($GLOBALS['godown_table'], $godown_unique_id, $columns, $values, $action);
                }    
                else {
                    $msg = "Unable To delete";
                }
            }
            else {
                $msg = "Invalid godown";
            }
        }
        else {
            $msg = "Empty godown";
        }
        echo $msg;
        exit;	
    }
    ?>