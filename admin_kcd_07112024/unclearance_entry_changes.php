<?php
    include("include.php");

    if(isset($_REQUEST['clearance_consignee_details_lr_number'])) {
        $clearance_consignee_details_lr_number = $_REQUEST['clearance_consignee_details_lr_number'];
        $clearance_consignee_details_lr_number = trim($clearance_consignee_details_lr_number);

        $receiver_same_consignee = $_REQUEST['receiver_same_consignee'];
        $receiver_same_consignee = trim($receiver_same_consignee);

        $consignee_name = ""; $consignee_mobile_number = "";
        if(!empty($clearance_consignee_details_lr_number)) {
            if(!empty($receiver_same_consignee) && $receiver_same_consignee == 1) {
                $lr_unique_id = ""; $consignee_name_mobile_city = "";
                $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $clearance_consignee_details_lr_number, 'id');
                if(preg_match("/^\d+$/", $lr_unique_id)) {
                    $consignee_name_mobile_city = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $clearance_consignee_details_lr_number, 'consignee_name_mobile_city');
                    if(!empty($consignee_name_mobile_city)) {
                        $consignee_name_mobile_city = $obj->encode_decode('decrypt', $consignee_name_mobile_city);
                        $consignee_name_mobile_city = explode(")", $consignee_name_mobile_city);
                        $name_mobile = "";
                        if(!empty($consignee_name_mobile_city['0'])) {
                            $name_mobile = explode("(", $consignee_name_mobile_city['0']);
                            if(!empty($name_mobile)) {
                                if(!empty($name_mobile['0'])) { $consignee_name = $name_mobile['0']; }
                                if(!empty($name_mobile['1'])) { $consignee_mobile_number = $name_mobile['1']; }
                            }
                        }
                    }
                }
            }
        }
?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group mb-1 pb-3">
                    <div class="form-label-group in-border">
                        <input type="text" name="received_person" class="form-control shadow-none" value="<?php if(!empty($consignee_name)) { echo $consignee_name; } ?>">
                        <label>Name <span class="text-danger">*</span> </label>
                    </div>
                    <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group mb-1 pb-3">
                    <div class="form-label-group in-border">
                        <input type="text" name="received_person_contact_number" class="form-control shadow-none" value="<?php if(!empty($consignee_mobile_number)) { echo $consignee_mobile_number; } ?>">
                        <label>Mobile Number <span class="text-danger">*</span></label>
                    </div>
                    <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group mb-1 pb-3">
                    <div class="form-label-group in-border">
                        <input type="text" name="received_person_identification" class="form-control shadow-none" value="">
                        <label>Identification</label>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    if(isset($_REQUEST['clearance_lr_number'])) {
        $clearance_lr_number = $_REQUEST['clearance_lr_number'];
        $clearance_lr_number = trim($clearance_lr_number);

        $unclearance_lr_list = array();
        if(!empty($clearance_lr_number)) {
            $unclearance_lr_list[] = $clearance_lr_number;
        }
        else {
            $unclearance_lr_list = $obj->getUnClearedLRNumberList();
        }
?>
        <form name="clearance_form" method="post" class="redirection_form">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 pb-3">
                    <div class="form-group">
                        <div class="form-label-group in-border pb-1">
                            <select name="update_clearance_lr_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select LR</option>
                                <?php
                                    if(!empty($unclearance_lr_list)) {
                                        foreach($unclearance_lr_list as $lr_number) {
                                            if(!empty($lr_number)) {
                                ?>
                                                <option value="<?php echo $lr_number; ?>" <?php if(!empty($lr_number) && $lr_number == $clearance_lr_number) { ?>selected="selected"<?php } ?> >
                                                    <?php echo $lr_number; ?>                                                                    
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Select LR <span class="text-danger">*</span> </label>
                        </div>
                    </div> 
                </div>
                <div class="col-12 receiver_details"></div>
                <div class="col-lg-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="receiver_same_consignee" name="receiver_same_consignee" onClick="Javascript:ToggleReceiver();">
                        <label class="form-check-label" for="receiver_same_consignee">
                            Check if receiver is same as consignee
                        </label>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'clearance_form', 'unclearance_entry_changes.php', '');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    $('select[name="update_clearance_lr_number"]').select2({
                        dropdownParent: $("#clearancemodal")
                    });
                    ToggleReceiver();              
                });
            </script>
        </form>
<?php
    }

    if(isset($_POST['update_clearance_lr_number'])) {	
        $lr_number = ""; $lr_number_erorr = ""; $received_person = ""; $received_person_error = ""; $received_person_contact_number = "";
        $received_person_contact_number_error = ""; $received_person_identification = ""; $received_person_identification_error = "";
        $receiver_same_consignee = ""; $receiver_same_consignee_error = "";

        $valid_clearance = ""; $form_name = "clearance_form";

        $lr_unique_id = ""; $already_cleared = 0; $consignee_name_mobile_city = ""; $consignee_name = ""; $consignee_mobile_number = "";
    
        $lr_number = $_POST['update_clearance_lr_number'];
        $lr_number = trim($lr_number);
        if(!empty($lr_number)) {            
            $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'id');
            if(preg_match("/^\d+$/", $lr_unique_id)) {
                $already_cleared = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'cleared');
                if(empty($already_cleared)) {
                    $consignee_name_mobile_city = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'consignee_name_mobile_city');
                    if(!empty($consignee_name_mobile_city)) {
                        $consignee_name_mobile_city = $obj->encode_decode('decrypt', $consignee_name_mobile_city);
                        $consignee_name_mobile_city = explode(")", $consignee_name_mobile_city);
                        $name_mobile = "";
                        if(!empty($consignee_name_mobile_city['0'])) {
                            $name_mobile = explode("(", $consignee_name_mobile_city['0']);
                            if(!empty($name_mobile)) {
                                if(!empty($name_mobile['0'])) { $consignee_name = $name_mobile['0']; }
                                if(!empty($name_mobile['1'])) { $consignee_mobile_number = $name_mobile['1']; }
                            }
                        }
                    }
                }
                else {
                    $lr_number_erorr = "Already Cleared";
                }
            }
            else {
                $lr_number_erorr = "Invalid LR Number";
            }
        }
        else {
            $lr_number_erorr = "Select the LR Number";
        }
        if(!empty($lr_number_erorr)) {
            $valid_clearance = $valid->error_display($form_name, "update_clearance_lr_number", $lr_number_erorr, 'select');			
        }

        if(isset($_POST['receiver_same_consignee'])) {
            $receiver_same_consignee = $_POST['receiver_same_consignee'];
            $receiver_same_consignee = trim($receiver_same_consignee);
        }
        if(!empty($receiver_same_consignee) && $receiver_same_consignee == 1) {
            if(!empty($consignee_name)) { $receiver_person = $consignee_name; }
            if(!empty($consignee_mobile_number)) { $received_person_contact_number = $consignee_mobile_number; }
            $received_person_identification = $GLOBALS['null_value'];
        }
        else {
            $received_person = $_POST['received_person'];
            $received_person = trim($received_person);
            $received_person_error = $valid->valid_company_name($received_person, 'name','1');
            if(!empty($received_person_error)) {
                if(!empty($valid_clearance)) {
                    $valid_clearance = $valid_clearance." ".$valid->error_display($form_name, "received_person", $received_person_error, 'text');
                }
                else {
                    $valid_clearance = $valid->error_display($form_name, "received_person", $received_person_error, 'text');
                }
            }

            $received_person_contact_number = $_POST['received_person_contact_number'];
            $received_person_contact_number = trim($received_person_contact_number);
            $received_person_contact_number_error = $valid->valid_mobile_number($received_person_contact_number, "Mobile number", "1");
            if(!empty($received_person_contact_number_error)) {
                if(!empty($valid_clearance)) {
                    $valid_clearance = $valid_clearance." ".$valid->error_display($form_name, "received_person_contact_number", $received_person_contact_number_error, 'text');
                }
                else {
                    $valid_clearance = $valid->error_display($form_name, "received_person_contact_number", $received_person_contact_number_error, 'text');
                }
            }

            $received_person_identification = $_POST['received_person_identification'];
            $received_person_identification = trim($received_person_identification);
            if(!empty($received_person_identification)) {
                $received_person_identification_error = $valid->common_validation($received_person_identification, "identification", "text");
            }
            if(!empty($received_person_identification_error)) {
                if(!empty($valid_clearance)) {
                    $valid_clearance = $valid_clearance." ".$valid->error_display($form_name, "received_person_identification", $received_person_identification_error, 'text');
                }
                else {
                    $valid_clearance = $valid->error_display($form_name, "received_person_identification", $received_person_identification_error, 'text');
                }
            }
        }

        $result = "";
        
        if(empty($valid_clearance)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

                if(!empty($received_person)) {
                    $received_person = $obj->encode_decode('encrypt', $received_person);
                }
                if(!empty($received_person_contact_number)) {
                    $received_person_contact_number = $obj->encode_decode('encrypt', $received_person_contact_number);
                }
                if(!empty($received_person_identification)) {
                    $received_person_identification = $obj->encode_decode('encrypt', $received_person_identification);
                }
                else {
                    $received_person_identification = $GLOBALS['null_value'];
                }

                $cleared = 1;

                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(preg_match("/^\d+$/", $lr_unique_id)) {
                    $action = "";
                    if(!empty($lr_number)) {
                        $action = "Clearance Updated. LR Number - ".$lr_number;
                    }
                
                    $columns = array(); $values = array();						
                    $columns = array('creator_name', 'cleared', 'received_person', 'received_person_contact_number', 'received_person_identification');
                    $values = array("'".$creator_name."'", "'".$cleared."'", "'".$received_person."'", "'".$received_person_contact_number."'", "'".$received_person_identification."'");
                    $lr_update_id = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, $action);
                    if(preg_match("/^\d+$/", $lr_update_id)) {	
                        $result = array('number' => '1', 'msg' => 'Clearance Successfully');						
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $lr_update_id);
                    }							
                }
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_clearance)) {
                $result = array('number' => '3', 'msg' => $valid_clearance);
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

        $filter_from_date = "";
        if(isset($_POST['filter_from_date'])) {
            $filter_from_date = $_POST['filter_from_date'];
        }
        $filter_to_date = "";
        if(isset($_POST['filter_to_date'])) {
            $filter_to_date = $_POST['filter_to_date'];
        }
        $filter_lr_number = "";
        if(isset($_POST['filter_lr_number'])) {
            $filter_lr_number = $_POST['filter_lr_number'];
        }

        $total_pages = 0;
        $total_pages = $obj->getUnClearedLRListCount($filter_from_date, $filter_to_date, $filter_lr_number);
        
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
        $show_records_list = $obj->getUnClearedLRList($filter_from_date, $filter_to_date, $filter_lr_number, $page_start, $page_end);
        /*if(!empty($total_records_list)) {
            foreach($total_records_list as $key => $val) {
                if($key >= $page_start && $key < $page_end) {
                    $show_records_list[] = $val;
                }
            }
        }*/
        
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
                    <th>#</th>
                    <th>L.R.No / Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Consignor</th>
                    <th>Consignee</th>
                    <th>Amount</th>
                    <th>Bill Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($show_records_list)) { 
                        foreach($show_records_list as $key => $data) {
                            $index = $key + 1;
                            if(!empty($prefix)) { $index = $index + $prefix; } 
                ?>
                            <tr onClick="Javascript:ShowClearanceModal('<?php if(!empty($data['lr_number'])) { echo $data['lr_number']; } ?>');" style="cursor: pointer;">
                                <td><?php echo $index; ?></td>
                                <td class="text-center">
                                    <?php
                                        if(!empty($data['lr_number'])) {
                                            echo $data['lr_number'];
                                            if(!empty($data['lr_date']) && $data['lr_date'] != "0000-00-00") {
                                                echo "<br>".date("d-m-Y", strtotime($data['lr_date']));
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['from_branch_details'])) {
                                            $data['from_branch_details'] = $obj->encode_decode('decrypt', $data['from_branch_details']);
                                            echo $data['from_branch_details'];
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
                                    <?php
                                        if(!empty($data['to_branch_details'])) {
                                            $data['to_branch_details'] = $obj->encode_decode('decrypt', $data['to_branch_details']);
                                            echo $data['to_branch_details'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['consignor_name_mobile_city'])) {
                                            $data['consignor_name_mobile_city'] = $obj->encode_decode('decrypt', $data['consignor_name_mobile_city']);
                                            echo $data['consignor_name_mobile_city'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['consignee_name_mobile_city'])) {
                                            $data['consignee_name_mobile_city'] = $obj->encode_decode('decrypt', $data['consignee_name_mobile_city']);
                                            echo $data['consignee_name_mobile_city'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['total_amount'])) {
                                            echo $data['total_amount'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($data['bill_type'])) {
                                            $data['bill_type'] = $obj->encode_decode('decrypt', $data['bill_type']);
                                            echo $data['bill_type'];
                                        }
                                    ?>
                                </td>
                            </tr>
                <?php 
                        } 
                    }  
                    else {
                ?>
                        <tr>
                            <td colspan="8" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php 
                    } 
                ?>
            </tbody>
        </table>
<?php
	}    
?>