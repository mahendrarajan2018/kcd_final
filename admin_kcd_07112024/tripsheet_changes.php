<?php
	include("include.php");
	
    if(isset($_REQUEST['show_tripsheet_id'])) { 
        $show_tripsheet_id = $_REQUEST['show_tripsheet_id'];
        $show_tripsheet_id = trim($show_tripsheet_id);

        $current_date = date("Y-m-d"); $tripsheet_date_from = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));

        $tripsheet_date = date("Y-m-d"); $vehicle_id = ""; $branch_id = ""; $driver_name = ""; $driver_contact_number = ""; $helper_name = ""; $lr_numbers = array();

        if(!empty($show_tripsheet_id)) {
            $tripsheet_list = array();
            $tripsheet_list = $obj->getTableRecords($GLOBALS['tripsheet_table'], 'tripsheet_id', $show_tripsheet_id, '');
            if(!empty($tripsheet_list)) {
                foreach($tripsheet_list as $data) {
                    if(!empty($data['tripsheet_date'])) {
                        $tripsheet_date = $data['tripsheet_date'];
                    }
                    if(!empty($data['vehicle_id'])) {
                        $vehicle_id = $data['vehicle_id'];
                    }
                    if(!empty($data['branch_id'])) {
                        $branch_id = $data['branch_id'];
                    }
                    if(!empty($data['driver_name'])) {
                        $driver_name = $obj->encode_decode('decrypt',$data['driver_name']);
                    }
                    if(!empty($data['driver_contact_number'])) {
                        $driver_contact_number = $obj->encode_decode('decrypt',$data['driver_contact_number']);
                    }
                    if(!empty($data['helper_name']) && $data['helper_name'] != $GLOBALS['null_value']) {
                        $helper_name = $obj->encode_decode('decrypt',$data['helper_name']);
                    }
                    if(!empty($data['lr_number'])) {
                        $lr_numbers = explode(",", $data['lr_number']);
                    }
                }
            }
        }

        $vehicle_list = array();
        $vehicle_list = $obj->getTableRecords($GLOBALS['vehicle_table'], '', '','');

        $branch_list = array();
        $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');
?>
        <form class="poppins pd-20 redirection_form" name="tripsheet_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_tripsheet_id)){ ?>
                            <div class="h5">Add Tripsheet</div>
                        <?php }else{ ?>
                            <div class="h5">Edit Tripsheet</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('tripsheet.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row justify-content-end p-2">
                <script type="text/javascript" src="include/js/action_changes.js"></script>
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_tripsheet_id)) { echo $show_tripsheet_id; } ?>">
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border pb-2">
                            <input type="date" class="form-control shadow-none" name="tripsheet_date" value="<?php if(!empty($tripsheet_date)) { echo $tripsheet_date; } ?>" min="<?php if(!empty($tripsheet_date_from)) { echo $tripsheet_date_from; } ?>" max="<?php if(!empty($current_date)) { echo $current_date; } ?>">
                            <label>Date <span class="text-danger">*</span> </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="vehicle_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select Vehicle</option>
                                <?php
                                    if(!empty($vehicle_list)) {
                                        foreach($vehicle_list as $data) {
                                            if(!empty($data['vehicle_id'])) {
                                ?>
                                                <option value="<?php echo $data['vehicle_id']; ?>" <?php if(!empty($vehicle_id) && $data['vehicle_id'] == $vehicle_id) { ?>selected="selected"<?php } ?> >
                                                    <?php
                                                        if(!empty($data['vehicle_details'])) {
                                                            $data['vehicle_details'] = $obj->encode_decode('decrypt', $data['vehicle_details']);
                                                            echo $data['vehicle_details'];
                                                        }
                                                    ?>                                                                    
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Select Vehicle <span class="text-danger">*</span> </label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getTripsheetLRNumberByBranch(this.value);">
                                <option value="">Select Branch</option>
                                <?php
                                    if(!empty($branch_list)) {
                                        foreach($branch_list as $data) {
                                            if(!empty($data['branch_id'])) {
                                ?>
                                                <option value="<?php echo $data['branch_id']; ?>" <?php if(!empty($branch_id) && $data['branch_id'] == $branch_id) { ?>selected="selected"<?php } ?> >
                                                    <?php 
                                                        if(!empty($data['prefix_name_mobile'])){
                                                            $data['prefix_name_mobile'] = $obj->encode_decode('decrypt', $data['prefix_name_mobile']);
                                                            echo $data['prefix_name_mobile'];
                                                        }
                                                    ?>
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Select Branch <span class="text-danger">*</span> </label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="driver_name" class="form-control shadow-none" value="<?php if(!empty($driver_name)) { echo $driver_name; } ?>">
                            <label>Driver Name <span class="text-danger">*</span> </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="driver_contact_number" class="form-control shadow-none" value="<?php if(!empty($driver_contact_number)) { echo $driver_contact_number; } ?>">
                            <label>Driver Contact Number <span class="text-danger">*</span> </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="helper_name" class="form-control shadow-none" value="<?php if(!empty($helper_name)) { echo $helper_name; } ?>">
                            <label>Helper Name</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <div id="tripsheet_luggage_cover" class="input-group tripsheet_select2">
                                <select name="tripsheet_luggage_sheet_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option value="">Select Luggage Sheet</option>
                                </select>
                                <label>Select Luggage Sheet</label>
                                <div class="input-group-append">
                                    <span class="input-group-text add_tripsheet_button" onClick="Javascript:AddTripsheetRow();" style="background-color:#f06548!important; cursor:pointer; height:100%;"><i class="fa fa-plus text-white"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div id="tripsheet_lr_cover" class="form-label-group in-border">
                            <div class="input-group tripsheet_select2">
                                <select name="tripsheet_lr_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option value="">Select LR</option>
                                </select>
                                <label>Select LR</label>
                                <div class="input-group-append">
                                    <span class="input-group-text add_tripsheet_button" onClick="Javascript:AddTripsheetRow();" style="background-color:#f06548!important; cursor:pointer; height:100%;"><i class="fa fa-plus text-white"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-12">
                    <input type="hidden" name="tripsheet_branch_id" value="<?php if(!empty($branch_id)) { echo $branch_id; } ?>">
                    <div class="table-responsive text-center">
                        <table class="table nowrap cursor smallfnt w-100 tripsheet_row_table">
                            <thead class="bg-dark table-bordered smallfnt">
                                <tr style="white-space:pre;">
                                    <th>#</th>
                                    <th class="px-4">Date</th>
                                    <th class="px-4">LR No</th>
                                    <th class="px-4">Branch</th>
                                    <th class="px-4">Consignor</th>
                                    <th class="px-4">Consignee</th>
                                    <th class="px-4">Article QTY / Unit</th>
                                    <th class="px-4">Price / QTY</th>
                                    <th class="px-4">Amount</th>
                                    <th class="px-4">Bill Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($lr_numbers)) {
                                        foreach($lr_numbers as $key =>  $lr_number) {
                                            if(!empty($lr_number)) {
                                                $lr_date = ""; $from_branch_details = ""; $consignor_name_mobile_city = ""; $consignee_name_mobile_city = ""; 
                                                $unit_name_values = array(); $quantity_values = array(); $weight_values = array(); $rate_values = array(); 
                                                $total_amount = ""; $bill_type = "";

                                                $lr_list = array();
                                                $lr_list = $obj->getTableRecords($GLOBALS['lr_table'], 'lr_number', $lr_number, '');
                                                if(!empty($lr_list)) {
                                                    foreach($lr_list as $data) {
                                                        if(!empty($data['lr_date'])) {
                                                            $lr_date = $data['lr_date'];
                                                        }
                                                        if(!empty($data['from_branch_details'])) {
                                                            $from_branch_details = $data['from_branch_details'];
                                                        }
                                                        if(!empty($data['consignor_name_mobile_city'])) {
                                                            $consignor_name_mobile_city = $data['consignor_name_mobile_city'];
                                                        }
                                                        if(!empty($data['consignee_name_mobile_city'])) {
                                                            $consignee_name_mobile_city = $data['consignee_name_mobile_city'];
                                                        }
                                                        if(!empty($data['unit_name'])) {
                                                            $unit_name_values = explode(",", $data['unit_name']);
                                                        }
                                                        if(!empty($data['quantity'])) {
                                                            $quantity_values = explode(",", $data['quantity']);
                                                        }
                                                        if(!empty($data['weight'])) {
                                                            $weight_values = explode(",", $data['weight']);
                                                        }
                                                        if(!empty($data['rate'])) {
                                                            $rate_values = explode(",", $data['rate']);
                                                        }
                                                        if(!empty($data['kooli'])) {
                                                            $kooli_values = explode(",", $data['kooli']);
                                                        }
                                                        if(!empty($data['delivery_charges'])) {
                                                            $delivery_charges = $data['delivery_charges'];
                                                        }
                                                        if(!empty($data['loading_charges'])) {
                                                            $loading_charges = $data['loading_charges'];
                                                        }
                                                        if(!empty($data['total_amount'])) {
                                                            $total_amount = $data['total_amount'];
                                                        }
                                                        if(!empty($data['bill_type'])) {
                                                            $bill_type = $data['bill_type'];
                                                        }
                                                    }
                                ?>
                                                    <tr class="tripsheet_row">
                                                        <th class="sno"> <?php echo $key + 1; ?> </th>
                                                        <th class="px-4">
                                                            <?php if(!empty($lr_date) && $lr_date != "0000-00-00") { echo date("d-m-Y", strtotime($lr_date)); } ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php if(!empty($lr_number)) { echo $lr_number; } ?>
                                                            <input type="hidden" name="tripsheet_lr_number[]" value="<?php if(!empty($lr_number)) { echo $lr_number; } ?>">
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($from_branch_details)) {
                                                                    $from_branch_details = $obj->encode_decode('decrypt', $from_branch_details);
                                                                    echo $from_branch_details;
                                                                }
                                                            ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($consignor_name_mobile_city)) {
                                                                    $consignor_name_mobile_city = $obj->encode_decode('decrypt', $consignor_name_mobile_city);
                                                                    echo $consignor_name_mobile_city;
                                                                }
                                                            ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($consignee_name_mobile_city)) {
                                                                    $consignee_name_mobile_city = $obj->encode_decode('decrypt', $consignee_name_mobile_city);
                                                                    echo $consignee_name_mobile_city;
                                                                }
                                                            ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($unit_name_values)) {
                                                                    for($i = 0; $i < count($unit_name_values); $i++) {
                                                                        if(!empty($unit_name_values[$i])) {
                                                                            $unit_name_values[$i] = $obj->encode_decode('decrypt', $unit_name_values[$i]);
                                                                            $article = "";
                                                                            if(!empty($quantity_values[$i])) { $article = $quantity_values[$i]; }
                                                                            else if(!empty($weight_values[$i])) { $article = $weight_values[$i]; }
                                                                            if(!empty($article)) {
                                                                                $article = $article." / ".$unit_name_values[$i];
                                                            ?>
                                                                                <div class="w-100 mb-1"> <?php echo $article; ?> </div>
                                                            <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($rate_values)) {
                                                                    for($i = 0; $i < count($rate_values); $i++) {
                                                                        if(!empty($rate_values[$i])) {
                                                            ?>
                                                                            <div class="w-100 mb-1"> <?php echo $rate_values[$i]; ?> </div>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php if(!empty($total_amount)) { echo $total_amount; } ?>
                                                        </th>
                                                        <th class="px-4">
                                                            <?php
                                                                if(!empty($bill_type)) {
                                                                    $bill_type = $obj->encode_decode('decrypt', $bill_type);
                                                                    echo $bill_type;
                                                                }
                                                            ?>
                                                        </th>
                                                        <th>
                                                            <button type="button" class="btn btn-danger" onClick="Javascript:DeleteTripsheetRow(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        </th>
                                                    </tr>
                                <?php
                                                }

                                            }                                            
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 py-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'tripsheet_form', 'tripsheet_changes.php', 'tripsheet.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.add_update_form_content').find('select').select2();
                });

            </script>
        </form>
		<?php
    } 

    if(isset($_POST['edit_id'])) {
        $current_date = date("Y-m-d"); $tripsheet_date_from = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
        $tripsheet_date = ""; $tripsheet_date_error = ""; $vehicle_id = ""; $vehicle_id_error = ""; $vehicle_details = ""; $branch_id = ""; $branch_id_error = ""; 
        $branch_details = ""; $driver_name = ""; $driver_name_error = ""; $driver_contact_number = ""; $driver_contact_number_error = ""; $helper_name = ""; 
        $helper_name_error = ""; $lr_numbers = array();

        $valid_tripsheet = ""; $form_name = "tripsheet_form";

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }

        $tripsheet_date = $_POST['tripsheet_date'];
        $tripsheet_date = trim($tripsheet_date);
        if(!empty($tripsheet_date)) {
            $tripsheet_date = date("d-m-Y", strtotime($tripsheet_date));
        }
        $tripsheet_date_error = $valid->valid_date($tripsheet_date, "tripsheet date", "1");
        if(empty($tripsheet_date_error)) {
            if( (strtotime($tripsheet_date) >= strtotime($tripsheet_date_from)) && (strtotime($tripsheet_date) <= strtotime($current_date)) ) {
                $tripsheet_date = date("Y-m-d", strtotime($tripsheet_date));
            }
            else {
                $tripsheet_date_error = "Invalid tripsheet date";
            }
        }
        if(!empty($tripsheet_date_error)) {
            $valid_tripsheet = $valid->error_display($form_name, "tripsheet_date", $tripsheet_date_error, 'text');			
        }

        $vehicle_id = $_POST['vehicle_id'];
        $vehicle_id = trim($vehicle_id);
        if(!empty($vehicle_id)) {
            $vehicle_unique_id = "";
            $vehicle_unique_id = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'vehicle_id', $vehicle_id, 'id');
            if(preg_match("/^\d+$/", $vehicle_unique_id)) {
                $vehicle_details = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'id', $vehicle_unique_id, 'vehicle_details');
            }
            else {
                $vehicle_id_error = "Invalid vehicle";
            }
        }
        else {
            $vehicle_id_error = "Select the vehicle";
        }
        if(!empty($vehicle_id_error)) {
            if(!empty($valid_tripsheet)) {
                $valid_tripsheet = $valid_tripsheet." ".$valid->error_display($form_name, "vehicle_id", $vehicle_id_error, 'select');
            }
            else {
                $valid_tripsheet = $valid->error_display($form_name, "vehicle_id", $vehicle_id_error, 'select');
            }
        }

        if(isset($_POST['tripsheet_branch_id'])) {
            $branch_id = $_POST['tripsheet_branch_id'];
            $branch_id = trim($branch_id);
        }
        if(!empty($branch_id)) {
            $branch_unique_id = "";
            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $branch_id, 'id');
            if(preg_match("/^\d+$/", $branch_unique_id)) {
                $branch_details = $obj->getTableColumnValue($GLOBALS['branch_table'], 'id', $branch_unique_id, 'prefix_name_mobile');
            }
            else {
                $branch_id_error = "Invalid branch";
            }
        }
        else {
            $branch_id_error = "Select the branch";
        }
        if(!empty($branch_id_error)) {
            if(!empty($valid_tripsheet)) {
                $valid_tripsheet = $valid_tripsheet." ".$valid->error_display($form_name, "branch_id", $branch_id_error, 'select');
            }
            else {
                $valid_tripsheet = $valid->error_display($form_name, "branch_id", $branch_id_error, 'select');
            }
        }

        $driver_name = $_POST['driver_name'];
        $driver_name = trim($driver_name);
        $driver_name_error = $valid->common_validation($driver_name, "driver name", "text");
        if(!empty($driver_name_error)) {
            if(!empty($valid_tripsheet)) {
                $valid_tripsheet = $valid_tripsheet." ".$valid->error_display($form_name, "driver_name", $driver_name_error, 'text');
            }
            else {
                $valid_tripsheet = $valid->error_display($form_name, "driver_name", $driver_name_error, 'text');
            }
        }

        $driver_contact_number = $_POST['driver_contact_number'];
        $driver_contact_number = trim($driver_contact_number);
        $driver_contact_number_error = $valid->valid_mobile_number($driver_contact_number, "driver contact number", "1");
        if(!empty($driver_contact_number_error)) {
            if(!empty($valid_tripsheet)) {
                $valid_tripsheet = $valid_tripsheet." ".$valid->error_display($form_name, "driver_contact_number", $driver_contact_number_error, 'text');
            }
            else {
                $valid_tripsheet = $valid->error_display($form_name, "driver_contact_number", $driver_contact_number_error, 'text');
            }
        }

        $helper_name = $_POST['helper_name'];
        $helper_name = trim($helper_name);
        if(!empty($helper_name)) {
            $helper_name_error = $valid->common_validation($helper_name, "helper name", "text");
        }
        if(!empty($helper_name_error)) {
            if(!empty($valid_tripsheet)) {
                $valid_tripsheet = $valid_tripsheet." ".$valid->error_display($form_name, "helper_name", $helper_name_error, 'text');
            }
            else {
                $valid_tripsheet = $valid->error_display($form_name, "helper_name", $helper_name_error, 'text');
            }
        }

        $lr_selected = 0; $lr_error = "";
        if(isset($_POST['tripsheet_lr_number'])) {
            $lr_numbers = $_POST['tripsheet_lr_number'];
        }

        if(!empty($lr_numbers)) {
            for($i = 0; $i < count($lr_numbers); $i++) {
                $lr_numbers[$i] = trim($lr_numbers[$i]);
                if(!empty($lr_numbers[$i])) {
                    $lr_unique_id = "";
                    $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_numbers[$i], 'id');
                    if(preg_match("/^\d+$/", $lr_unique_id)) {
                        $lr_selected = 1;
                    }
                    else {
                        $lr_error = "Invalid LR number";
                    }
                }
                else {
                    $lr_error = "Empty LR number";
                }
            }
        }
        if(empty($lr_selected) && empty($lr_error)) {
            $lr_error = "Add tripsheet LR Numbers";
        }

        $result = "";
        
        if(empty($valid_tripsheet) && empty($lr_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(!empty($driver_name)) {
                    $driver_name = $obj->encode_decode('encrypt', $driver_name);
                }
                if(!empty($driver_contact_number)) {
                    $driver_contact_number = $obj->encode_decode('encrypt', $driver_contact_number);
                }
                if(!empty($helper_name)) {
                    $helper_name = $obj->encode_decode('encrypt', $helper_name);
                }
                else {
                    $helper_name = $GLOBALS['null_value'];
                }

                $lr_count = 0;
                if(!empty($lr_numbers)) {
                    $lr_count = count($lr_numbers);
                    $lr_numbers = implode(",", $lr_numbers);
                }

                $prev_lr_numbers = "";
                if(!empty($edit_id)) {
                    $prev_lr_numbers = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $edit_id, 'lr_number');
                }

                $tripsheet_number = "";

                if(empty($edit_id)) {
                    $null_value = $GLOBALS['null_value']; $acknowledged = 0; $cancelled = 0; $cancel_date = $GLOBALS['default_date']; 
                    $cancel_remarks = $GLOBALS['null_value'];

                    $columns = array('created_date_time', 'creator', 'creator_name', 'tripsheet_id', 'tripsheet_number', 'tripsheet_date', 'vehicle_id', 'vehicle_details', 'branch_id', 'branch_details', 'driver_name', 'driver_contact_number', 'helper_name', 'lr_number', 'lr_count', 'acknowledged', 'cancelled', 'cancel_date', 'cancel_remarks', 'deleted');
                    $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$null_value."'", "'".$tripsheet_date."'", "'".$vehicle_id."'", "'".$vehicle_details."'", "'".$branch_id."'", "'".$branch_details."'", "'".$driver_name."'", "'".$driver_contact_number."'", "'".$helper_name."'", "'".$lr_numbers."'", "'".$lr_count."'", "'".$acknowledged."'", "'".$cancelled."'", "'".$cancel_date."'", "'".$cancel_remarks."'", "'0'");
                    $tripsheet_insert_id = $obj->InsertSQL($GLOBALS['tripsheet_table'], $columns, $values, 'tripsheet_id', 'tripsheet_number', '');
                    if(preg_match("/^\d+$/", $tripsheet_insert_id)) {	
                        $tripsheet_number = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'id', $tripsheet_insert_id, 'tripsheet_number');							
                        $result = array('number' => '1', 'msg' => 'Tripsheet Successfully Created');						
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $lr_insert_id);
                    }
                }
                else {
                    $getUniqueID = "";
                    $getUniqueID = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $edit_id, 'id');
                    if(preg_match("/^\d+$/", $getUniqueID)) {                            
                        $columns = array(); $values = array();						
                        $columns = array('creator_name', 'tripsheet_date', 'vehicle_id', 'vehicle_details', 'branch_id', 'branch_details', 'driver_name', 'driver_contact_number', 'helper_name', 'lr_number', 'lr_count');
                        $values = array("'".$creator_name."'", "'".$tripsheet_date."'", "'".$vehicle_id."'", "'".$vehicle_details."'", "'".$branch_id."'", "'".$branch_details."'", "'".$driver_name."'", "'".$driver_contact_number."'", "'".$helper_name."'", "'".$lr_numbers."'", "'".$lr_count."'");
                        $tripsheet_update_id = $obj->UpdateSQL($GLOBALS['tripsheet_table'], $getUniqueID, $columns, $values, '');
                        if(preg_match("/^\d+$/", $tripsheet_update_id)) {	
                            $tripsheet_number = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $edit_id, 'tripsheet_number');
                            $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $tripsheet_update_id);
                        }							
                    }
                }

                if(!empty($tripsheet_number)) {

                    $tripsheet_unique_id = "";
                    $tripsheet_unique_id = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_number', $tripsheet_number, 'id');
                    if(preg_match("/^\d+$/", $tripsheet_unique_id)) {
                        $action = "";
                        if(!empty($edit_id)) {
                            $action = "Tripsheet Updated. Number - ".$tripsheet_number;
                        }
                        else {
                            $action = "New Tripsheet Created. Number - ".$tripsheet_number;
                        }
                        $columns = array(); $values = array();						
                        $columns = array('tripsheet_number');
                        $values = array("'".$tripsheet_number."'");
                        $msg = $obj->UpdateSQL($GLOBALS['tripsheet_table'], $tripsheet_unique_id, $columns, $values, $action);
                        if(preg_match("/^\d+$/", $msg)) {
                            if(!empty($lr_numbers)) {
                                $lr_numbers = explode(",", $lr_numbers);

                                if(!empty($prev_lr_numbers)) {
                                    $prev_lr_numbers = explode(",", $prev_lr_numbers);
                                    foreach($prev_lr_numbers as $prev_lr_number) {
                                        if(!empty($prev_lr_number) && !in_array($prev_lr_number, $lr_numbers)) {
                                            $lr_unique_id = "";
                                            $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $prev_lr_number, 'id');
                                            if(preg_match("/^\d+$/", $lr_unique_id)) {
                                                $columns = array(); $values = array(); $prev_lr_updated = "";				
                                                $columns = array('tripsheet_number');
                                                $values = array("'".$GLOBALS['null_value']."'");
                                                $prev_lr_updated = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, '');
                                            }
                                        }
                                    }
                                }

                                foreach($lr_numbers as $lr_number) {
                                    if(!empty($lr_number)) {
                                        $lr_unique_id = "";
                                        $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'id');
                                        if(preg_match("/^\d+$/", $lr_unique_id)) {
                                            $action = "Tripsheet LR Updated. LR Number - ".$lr_number.", Tripsheet Number - ".$tripsheet_number;
                                            $columns = array(); $values = array(); $lr_updated = "";					
                                            $columns = array('tripsheet_number');
                                            $values = array("'".$tripsheet_number."'");
                                            $lr_updated = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, $action);
                                            if(preg_match("/^\d+$/", $lr_updated)) {
                                                $luggage_sheet_number = "";
                                                $luggage_sheet_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'luggage_sheet_number');
                                                if(!empty($luggage_sheet_number) && $luggage_sheet_number != $GLOBALS['null_value']) {
                                                    $luggage_unique_id = "";
                                                    $luggage_unique_id = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_number', $luggage_sheet_number, 'id');
                                                    if(preg_match("/^\d+$/", $luggage_unique_id)) {
                                                        $luggage_tripsheet_number = "";
                                                        $luggage_tripsheet_number = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'id', $luggage_unique_id, 'tripsheet_number');
                                                        if(!empty($luggage_tripsheet_number) && $luggage_tripsheet_number == $GLOBALS['null_value']) {
                                                            $action = "Tripsheet Luggage Sheet Updated. Luggage Sheet Number - ".$luggage_sheet_number.", Tripsheet Number - ".$tripsheet_number;
                                                            $columns = array(); $values = array(); $luggage_updated = "";					
                                                            $columns = array('tripsheet_number');
                                                            $values = array("'".$tripsheet_number."'");
                                                            $luggage_updated = $obj->UpdateSQL($GLOBALS['luggage_sheet_table'], $luggage_unique_id, $columns, $values, $action);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_tripsheet)) {
                $result = array('number' => '3', 'msg' => $valid_tripsheet);
            }
            else if(!empty($lr_error)) {
                $result = array('number' => '2', 'msg' => $lr_error);
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
        $filter_vehicle_id = "";
        if(isset($_POST['filter_vehicle_id'])) {
            $filter_vehicle_id = $_POST['filter_vehicle_id'];
        }
        $filter_branch_id = "";
        if(isset($_POST['filter_branch_id'])) {
            $filter_branch_id = $_POST['filter_branch_id'];
        }
        $filter_tripsheet_number = "";
        if(isset($_POST['filter_tripsheet_number'])) {
            $filter_tripsheet_number = $_POST['filter_tripsheet_number'];
        }
        $filter_lr_number = "";
        if(isset($_POST['filter_lr_number'])) {
            $filter_lr_number = $_POST['filter_lr_number'];
        }

?>
        <ul class="nav nav-tabs row align-items-center justify-content-center mx-0">
            <li class="nav-item" style="width: auto;">
                <a class="nav-link active" data-bs-toggle="tab" href="#active_bill">Active</a>
            </li>
            <li class="nav-item" style="width: auto;">
                <a class="nav-link" data-bs-toggle="tab" href="#cancel_bill">Cancel</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="active_bill">
                <?php 
                    $cancelled = 0;
                    include("tripsheet_table.php"); 
                ?>
            </div>
            <div class="tab-pane fade" id="cancel_bill">
                <?php 
                    $cancelled = 1;
                    include("tripsheet_table.php"); 
                ?>
            </div>
        </div>
<?php	
	}

    if(isset($_REQUEST['acknowledge_tripsheet_number'])) {
        $acknowledge_tripsheet_number = $_REQUEST['acknowledge_tripsheet_number'];
        $acknowledge_tripsheet_number = trim($acknowledge_tripsheet_number);
        if(!empty($acknowledge_tripsheet_number)) {
            $tripsheet_date = date("Y-m-d"); $vehicle_id = ""; $branch_id = ""; $driver_name = ""; $driver_contact_number = ""; $helper_name = ""; 
            $lr_numbers = array();

            $tripsheet_list = array();
            $tripsheet_list = $obj->getTableRecords($GLOBALS['tripsheet_table'], 'tripsheet_number', $acknowledge_tripsheet_number, '');
            if(!empty($tripsheet_list)) {
                foreach($tripsheet_list as $data) {
                    if(!empty($data['tripsheet_date'])) {
                        $tripsheet_date = $data['tripsheet_date'];
                    }
                    if(!empty($data['vehicle_id'])) {
                        $vehicle_id = $data['vehicle_id'];
                    }
                    if(!empty($data['branch_id'])) {
                        $branch_id = $data['branch_id'];
                    }
                    if(!empty($data['driver_name'])) {
                        $driver_name = $obj->encode_decode('decrypt',$data['driver_name']);
                    }
                    if(!empty($data['driver_contact_number'])) {
                        $driver_contact_number = $obj->encode_decode('decrypt',$data['driver_contact_number']);
                    }
                    if(!empty($data['helper_name']) && $data['helper_name'] != $GLOBALS['null_value']) {
                        $helper_name = $obj->encode_decode('decrypt',$data['helper_name']);
                    }
                    if(!empty($data['lr_number'])) {
                        $lr_numbers = explode(",", $data['lr_number']);
                    }
                }
?>
                <div class="p-2">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mb-2">Are you sure you want to approve this tripsheet <?php echo $acknowledge_tripsheet_number; ?> ?</p>
                </div>
                <div class="table-responsive">
                    <div class="col-lg-12 p-0">
                        <form name="acknowledge_form" method="post" class="redirection_form">
                            <div class="row mx-0">
                                <div class="col-12">
                                    <input type="hidden" name="update_acknowledge_tripsheet_number" value="<?php echo $acknowledge_tripsheet_number; ?>">
                                    <table class="table nowrap cursor text-center smallfnt">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>L.R.No / Date</th>
                                                <th style="width: 200px;">Consignor</th>
                                                <th style="width: 200px;">Consignee</th>
                                                <th style="width: 200px;">Branch</th>
                                                <th>Amount</th>
                                                <th>Bill Type</th>
                                                <th>Quantity / Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($lr_numbers)) {
                                                    foreach($lr_numbers as $key =>  $lr_number) {
                                                        if(!empty($lr_number)) {
                                                            $lr_date = ""; $from_branch_details = ""; $consignor_name_mobile_city = ""; $consignee_name_mobile_city = ""; 
                                                            $unit_name_values = array(); $quantity_values = array(); $weight_values = array(); $rate_values = array(); 
                                                            $total_amount = ""; $bill_type = "";

                                                            $lr_list = array();
                                                            $lr_list = $obj->getTableRecords($GLOBALS['lr_table'], 'lr_number', $lr_number, '');
                                                            if(!empty($lr_list)) {
                                                                foreach($lr_list as $data) {
                                                                    if(!empty($data['lr_date'])) {
                                                                        $lr_date = $data['lr_date'];
                                                                    }
                                                                    if(!empty($data['from_branch_details'])) {
                                                                        $from_branch_details = $data['from_branch_details'];
                                                                    }
                                                                    if(!empty($data['consignor_name_mobile_city'])) {
                                                                        $consignor_name_mobile_city = $data['consignor_name_mobile_city'];
                                                                    }
                                                                    if(!empty($data['consignee_name_mobile_city'])) {
                                                                        $consignee_name_mobile_city = $data['consignee_name_mobile_city'];
                                                                    }
                                                                    if(!empty($data['unit_name'])) {
                                                                        $unit_name_values = explode(",", $data['unit_name']);
                                                                    }
                                                                    if(!empty($data['quantity'])) {
                                                                        $quantity_values = explode(",", $data['quantity']);
                                                                    }
                                                                    if(!empty($data['weight'])) {
                                                                        $weight_values = explode(",", $data['weight']);
                                                                    }
                                                                    if(!empty($data['rate'])) {
                                                                        $rate_values = explode(",", $data['rate']);
                                                                    }
                                                                    if(!empty($data['kooli'])) {
                                                                        $kooli_values = explode(",", $data['kooli']);
                                                                    }
                                                                    if(!empty($data['delivery_charges'])) {
                                                                        $delivery_charges = $data['delivery_charges'];
                                                                    }
                                                                    if(!empty($data['loading_charges'])) {
                                                                        $loading_charges = $data['loading_charges'];
                                                                    }
                                                                    if(!empty($data['total_amount'])) {
                                                                        $total_amount = $data['total_amount'];
                                                                    }
                                                                    if(!empty($data['bill_type'])) {
                                                                        $bill_type = $data['bill_type'];
                                                                    }
                                                                }
                                            ?>
                                                                <tr class="tripsheet_row">
                                                                    <th class="sno"> <?php echo $key + 1; ?> </th>
                                                                    <th class="px-4">
                                                                        <?php 
                                                                            if(!empty($lr_number)) { 
                                                                                echo $lr_number; 
                                                                                if(!empty($lr_date) && $lr_date != "0000-00-00") { 
                                                                                    echo "<br>".date("d-m-Y", strtotime($lr_date));
                                                                                }
                                                                            } 
                                                                        ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php
                                                                            if(!empty($consignor_name_mobile_city)) {
                                                                                $consignor_name_mobile_city = $obj->encode_decode('decrypt', $consignor_name_mobile_city);
                                                                                echo $consignor_name_mobile_city;
                                                                            }
                                                                        ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php
                                                                            if(!empty($consignee_name_mobile_city)) {
                                                                                $consignee_name_mobile_city = $obj->encode_decode('decrypt', $consignee_name_mobile_city);
                                                                                echo $consignee_name_mobile_city;
                                                                            }
                                                                        ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php
                                                                            if(!empty($from_branch_details)) {
                                                                                $from_branch_details = $obj->encode_decode('decrypt', $from_branch_details);
                                                                                echo $from_branch_details;
                                                                            }
                                                                        ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php if(!empty($total_amount)) { echo $total_amount; } ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php
                                                                            if(!empty($bill_type)) {
                                                                                $bill_type = $obj->encode_decode('decrypt', $bill_type);
                                                                                echo $bill_type;
                                                                            }
                                                                        ?>
                                                                    </th>
                                                                    <th class="px-4">
                                                                        <?php
                                                                            if(!empty($unit_name_values)) {
                                                                                for($i = 0; $i < count($unit_name_values); $i++) {
                                                                                    if(!empty($unit_name_values[$i])) {
                                                                                        $unit_name_values[$i] = $obj->encode_decode('decrypt', $unit_name_values[$i]);
                                                                                        $article = "";
                                                                                        if(!empty($quantity_values[$i])) { $article = $quantity_values[$i]; }
                                                                                        else if(!empty($weight_values[$i])) { $article = $weight_values[$i]; }
                                                                                        if(!empty($article)) {
                                                                                            $article = $article." / ".$unit_name_values[$i];
                                                                        ?>
                                                                                            <div class="w-100 mb-1"> <?php echo $article; ?> </div>
                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </th>
                                                                </tr>
                                            <?php
                                                            }
                                                        }                                            
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table> 
                                    <div class="w-100 text-center">
                                        <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'acknowledge_form', 'tripsheet_changes.php', '');">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
<?php
            }
        }
    }

    if(isset($_POST['update_acknowledge_tripsheet_number'])) {
        $acknowledge_tripsheet_number = $_POST['update_acknowledge_tripsheet_number'];
        $acknowledge_tripsheet_number = trim($acknowledge_tripsheet_number);
        $result = "";
        if(!empty($acknowledge_tripsheet_number)) {
            $tripsheet_unique_id = "";
            $tripsheet_unique_id = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_number', $acknowledge_tripsheet_number, 'id');
            if(preg_match("/^\d+$/", $tripsheet_unique_id)) {
                $acknowledged = 0;
                $acknowledged = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_number', $acknowledge_tripsheet_number, 'acknowledged');
                if(empty($acknowledged)) {
                    $action = "Tripsheet Acknowledged. Number - ".$acknowledge_tripsheet_number;

                    $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
        
                    $columns = array(); $values = array();
                    $columns = array('creator_name', 'acknowledged');
                    $values = array("'".$creator_name."'", "'1'");
                    $msg = $obj->UpdateSQL($GLOBALS['tripsheet_table'], $tripsheet_unique_id, $columns, $values, $action);                    
                    if(preg_match("/^\d+$/", $msg)) {
                        $result = array('number' => '1', 'msg' => 'Successfully Acknowledged');
                    }
                }
                else {
                    $result = array('number' => '2', 'msg' => 'Already acknowledged');
                }
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid tripsheet number');
            }
        }
        else {
            $result = array('number' => '2', 'msg' => 'Empty tripsheet number');
        }
        if(!empty($result)) {
            $result = json_encode($result);
        }
        echo $result; exit;
    }

    if(isset($_POST['cancel_bill_id'])) {
        $cancell_bill_error = ""; $cancel_bill_id = ""; $cancel_bill_id_error = ""; $cancel_bill_remarks = ""; $cancel_bill_remarks_error = "";

        $cancel_bill_id = $_POST['cancel_bill_id'];
        $cancel_bill_id = trim($cancel_bill_id);
        if(!empty($cancel_bill_id)) {
            $cancel_bill_unique_id = ""; $cancel_bill_table = "";
            $cancel_bill_unique_id = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $cancel_bill_id, 'id');
            if(!empty($cancel_bill_unique_id) && preg_match("/^\d+$/", $cancel_bill_unique_id)) {
                $cancel_bill_table = $GLOBALS['tripsheet_table'];
            }
            if(empty($cancel_bill_unique_id)) {
                $cancel_bill_id_error = "Invalid Cancel bill";
            }
        }
        else {
            $cancel_bill_id_error = "Cancel bill id is empty";
        }

        if(!empty($cancel_bill_id_error)) {
            $cancell_bill_error = $cancel_bill_id_error;
        }

        $cancel_bill_remarks = $_POST['cancel_bill_remarks'];
        $cancel_bill_remarks = trim($cancel_bill_remarks);
        $cancel_bill_remarks_error = $valid->common_validation($cancel_bill_remarks, "Cancel bill remarks", "text");
        if(!empty($cancel_bill_remarks_error)) {
            if(!empty($cancell_bill_error)) {
                $cancell_bill_error = $cancell_bill_error."<br>".$cancel_bill_remarks_error;
            }
            else {
                $cancell_bill_error = $cancel_bill_remarks_error;
            }
        }

        $result = "";
        if(empty($cancell_bill_error) && !empty($cancel_bill_table) && !empty($cancel_bill_unique_id) && preg_match("/^\d+$/", $cancel_bill_unique_id)) {

            if(!empty($cancel_bill_remarks)) {
                $cancel_bill_remarks = $obj->encode_decode('encrypt', $cancel_bill_remarks);
            }

            $tripsheet_number = "";
            if(!empty($cancel_bill_id)) {
                $tripsheet_number = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $cancel_bill_id, 'tripsheet_number');
                if(!empty($tripsheet_number)) {
                    $acknowledged = 0;
                    $acknowledged = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_id', $cancel_bill_id, 'acknowledged');
                    if(empty($acknowledged)) {
                        $lr_numbers = "";
                        $lr_numbers = $obj->getTableColumnValue($GLOBALS['tripsheet_table'], 'tripsheet_number', $tripsheet_number, 'lr_number');
                        if(!empty($lr_numbers)) {
                            $lr_numbers = explode(",", $lr_numbers);
                            foreach($lr_numbers as $lr_number) {
                                if(!empty($lr_number)) {
                                    $lr_unique_id = "";
                                    $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'id');
                                    if(preg_match("/^\d+$/", $lr_unique_id)) {
                                        $columns = array(); $values = array();						
                                        $columns = array('tripsheet_number');
                                        $values = array("'".$GLOBALS['null_value']."'");
                                        $msg = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, '');
                                    }
                                }
                            }
                        }

                        $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                        $action = "Tripsheet Cancelled. Number - ".$tripsheet_number;
            
                        $columns = array(); $values = array();						
                        $columns = array('creator_name', 'cancelled', 'cancel_remarks');
                        $values = array("'".$creator_name."'", "'1'", "'".$cancel_bill_remarks."'");
                        $msg = $obj->UpdateSQL($cancel_bill_table, $cancel_bill_unique_id, $columns, $values, $action);                    
                        if(preg_match("/^\d+$/", $msg)) {
                            $result = array('number' => '1', 'msg' => 'Successfully Cancelled');
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => 'Unable To Delete');
                    }    
                }                   
            }  
        }
        else {
            $result = array('number' => '2', 'msg' => $cancell_bill_error);
        }
        if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
    }
?>
