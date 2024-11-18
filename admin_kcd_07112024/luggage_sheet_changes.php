<?php
	include("include.php");
	if(isset($_REQUEST['show_luggage_sheet_id'])) { 
        $show_luggage_sheet_id = $_REQUEST['show_luggage_sheet_id'];
        $show_luggage_sheet_id = trim($show_luggage_sheet_id);

        $entry_date = date('d-m-Y'); $prev_date = date('d-m-Y', strtotime('-7 days'));
        $from_location = ""; $to_location = ""; $lr_ids = array(); $lr_count = 0; $lr_numbers = array();
        $driver_name = ""; $driver_number = ""; $helper_name = ""; $vehicle_id = "";

        if(!empty($show_luggage_sheet_id)) {
            $luggage_sheet_list = array();
            $luggage_sheet_list = $obj->getTableRecords($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $show_luggage_sheet_id, '');
            if(!empty($luggage_sheet_list)) {
                foreach($luggage_sheet_list as $data) {
                    if(!empty($data['lr_id']) && $data['lr_id'] != $GLOBALS['null_value']) {
                        $lr_ids = $data['lr_id'];
                        $lr_ids = explode(",", $lr_ids);
                    }
                    if(!empty($data['lr_number']) && $data['lr_number'] != $GLOBALS['null_value']) {
                        $lr_numbers = $data['lr_number'];
                    }
                    if(!empty($data['entry_date'])) {
                        $entry_date = date("d-m-Y", strtotime($data['entry_date']));
                    }
                    if(!empty($data['from_location'])) {
                        $from_location = $data['from_location'];
                    }
                    if(!empty($data['to_location'])) {
                        $to_location = $data['to_location'];
                    }
                    if(!empty($data['driver_name']) && $data['driver_name'] != $GLOBALS['null_value']) {
                        $driver_name = $obj->encode_decode('decrypt', $data['driver_name']);
                    }
                    if(!empty($data['driver_number']) && $data['driver_number'] != $GLOBALS['null_value']) {
                        $driver_number = $obj->encode_decode('decrypt', $data['driver_number']);
                    }
                    if(!empty($data['helper_name']) && $data['helper_name'] != $GLOBALS['null_value']) {
                        $helper_name = $obj->encode_decode('decrypt', $data['helper_name']);
                    } 
                    if(!empty($data['vehicle_id']) && $data['vehicle_id'] != $GLOBALS['null_value']) {
                        $vehicle_id = $data['vehicle_id'];
                    }
                    if(!empty($data['lr_count'])) {
                        $lr_count = $data['lr_count'];
                    }
                }
            }
        }

        $from_list = array();
        $from_list = $obj->LuggagesheetFromList();

        $to_list = array();
        if(!empty($show_luggage_sheet_id)) {
            $to_list = $obj->LuggagesheetToList($from_location);
        }
        
        $vehicle_list = array();
        $vehicle_list = $obj->getTableRecords($GLOBALS['vehicle_table'], '', '', '');
?>
        <form class="poppins pd-20 redirection_form" name="luggage_sheet_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_luggage_sheet_id)) { ?>
                            <div class="h5">Add Luggage Sheet</div>
                        <?php } else { ?>
                            <div class="h5">Edit Luggage Sheet</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('luggage_sheet.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-2">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_luggage_sheet_id)) { echo $show_luggage_sheet_id; } ?>">
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="entry_date" class="form-control shadow-none date_field" value="<?php if(!empty($entry_date)) { echo $entry_date; } ?>">
                            <label>Date <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="from_location" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getLocationAndLR(this.value, '');" <?php if(!empty($show_luggage_sheet_id)) { ?>disabled<?php } ?>>
                                <option value="">Select From Godown</option>
                                <?php
                                    if(!empty($from_list)) {
                                        foreach($from_list as $list) {
                                            if(!empty($list['godown_id']) && $list['godown_id'] != $GLOBALS['null_value']) {
                                ?>
                                                <option value="<?php echo $list['godown_id']; ?>" <?php if(!empty($from_location) && $from_location == $list['godown_id']) { ?>selected<?php } ?>>
                                                    <?php
                                                        if(!empty($list['name']) && $list['name'] != $GLOBALS['null_value']) {
                                                            $list['name'] = html_entity_decode($obj->encode_decode('decrypt', $list['name']));
                                                            echo $list['name'];
                                                        }
                                                    ?>
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>From Godown <span class="text-danger">*</span></label>
                        </div>
                    </div>  
                </div>

                <input type="hidden" name="from_location" value="<?php if(!empty($from_location)) { echo $from_location; } ?>" <?php if(empty($show_luggage_sheet_id)) { ?>disabled<?php } ?>>

                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="to_location" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select To Branch</option>
                                <?php
                                    if(!empty($to_list)) {
                                        foreach($to_list as $list) {
                                            if(!empty($list['branch_id']) && $list['branch_id'] != $GLOBALS['null_value']) {
                                ?>
                                                <option value="<?php echo $list['branch_id']; ?>" <?php if(!empty($to_location) && $to_location == $list['branch_id']) { ?>selected<?php } ?>>
                                                    <?php
                                                        if(!empty($list['prefix_name_mobile']) && $list['prefix_name_mobile'] != $GLOBALS['null_value']) {
                                                            $list['prefix_name_mobile'] = $obj->encode_decode('decrypt', $list['prefix_name_mobile']);
                                                            echo $list['prefix_name_mobile'];
                                                        }
                                                    ?>
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>To Branch <span class="text-danger">*</span></label>
                        </div>
                    </div>  
                </div>

                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <div class="input-group mb-3">
                                <select name="selected_lr_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option value="">Select LR</option>
                                </select>
                                <label>LR List <span class="text-danger">*</span></label>
                                <div class="input-group-append">
                                    <button class="btn add_button" type="button" style="background-color:#f06548!important; cursor:pointer; height:100%;" onclick="Javascript:AddLR();"><i class="fa fa-plus text-white"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <select name="vehicle_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select vehicle</option>    
                                <?php
                                    if(!empty($vehicle_list)) {
                                        foreach($vehicle_list as $data) {
                                            if(!empty($data['vehicle_id'])) {
                                ?>
                                                <option value="<?php echo $data['vehicle_id']; ?>" <?php if(!empty($vehicle_id) && $data['vehicle_id'] == $vehicle_id) { ?>selected="selected"<?php } ?>>
                                                    <?php
                                                        if(!empty($data['vehicle_details'])) {
                                                            $data['vehicle_details'] = $obj->encode_decode('decrypt', $data['vehicle_details']);
                                                            echo($data['vehicle_details']);
                                                        }
                                                    ?>
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Vehicle <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="driver_name" class="form-control shadow-none" value="<?php if(!empty($driver_name)) { echo $driver_name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
                            <label>Driver Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Contains Text Only(Max Char: 30)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="driver_number" class="form-control shadow-none" value="<?php if(!empty($driver_number)) { echo $driver_number; } ?>" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                            <label>Driver Contact Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="helper_name" class="form-control shadow-none" value="<?php if(!empty($helper_name)) { echo $helper_name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
                            <label>Helper Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Contains Text Only(Max Char: 30)</div>
                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-lg-12">
                    <div class="table-responsive text-center">
                        <input type="hidden" name="lr_count" value="<?php if(!empty($lr_count)) { echo $lr_count; } else { echo "0"; } ?>">
                        <table class="table nowrap cursor smallfnt w-100 added_lr_table">
                            <thead class="bg-dark table-bordered smallfnt">
                                <tr style="white-space:pre;">
                                    <th>#</th>
                                    <th class="px-4">Date</th>
                                    <th class="px-4">LR No</th>
                                    <th class="px-4">Branch</th>
                                    <th class="px-4">Consignor</th>
                                    <th class="px-4">Consignee</th>
                                    <th class="px-4">Article Qty & Unit</th>
                                    <th class="px-4">Price / QTY</th>
                                    <th class="px-4">Amount</th>
                                    <th class="px-4">Bill Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(empty($show_luggage_sheet_id)) { 
                                ?>
                                    <tr class="empty_row">
                                        <th colspan="11">No records found</th>
                                    </tr>
                                <?php 
                                    } 
                                    else { 
                                        if(!empty($lr_ids)) {
                                            for($e=0; $e < count($lr_ids); $e++) {
                                                $lr_list = array();
                                                $lr_list = $obj->getTableRecords($GLOBALS['lr_table'], 'lr_id', $lr_ids[$e], '');
                                                if(!empty($lr_list)) {
                                                    foreach($lr_list as $list) {
                                                        if(!empty($list['lr_number']) && $list['lr_number'] != $GLOBALS['null_value']) {
                                ?>
                                                            <tr class="lr_row" id="lr_row<?php echo $lr_count; ?>">
                                                                <th class="sno"><?php echo $lr_count; ?></th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['lr_date'])) { echo date("d-m-Y", strtotime($list['lr_date'])); } ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['lr_number'])) { echo $list['lr_number']; } ?>
                                                                    <input type="hidden" name="lr_id[]" value="<?php if(!empty($list['lr_id'])) { echo $list['lr_id']; } ?>">
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['to_branch_details'])) { echo $obj->encode_decode('decrypt', $list['to_branch_details']); } ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['consignor_name_mobile_city'])) { echo $obj->encode_decode('decrypt', $list['consignor_name_mobile_city']); } ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['consignee_name_mobile_city'])) { echo $obj->encode_decode('decrypt', $list['consignee_name_mobile_city']); } ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php
                                                                        $unit_id = ""; $unit_name = ""; $quantity = "";
                                                                        $weight = "";
                                                                        if(!empty($list['unit_id']) && $list['unit_id'] != $GLOBALS['null_value']) {
                                                                            $unit_id = $list['unit_id'];
                                                                        }
                                                                        if(!empty($list['unit_name']) && $list['unit_name'] != $GLOBALS['null_value']) {
                                                                            $unit_name = $list['unit_name'];
                                                                        }
                                                                        if(!empty($list['quantity']) && $list['quantity'] != $GLOBALS['null_value']) {
                                                                            $quantity = $list['quantity'];
                                                                        }
                                                                        if(!empty($list['weight']) && $list['weight'] != $GLOBALS['null_value']) {
                                                                            $weight = $list['weight'];
                                                                        }
                                                                        if(!empty($unit_id)) {
                                                                            $unit_id_values = array(); $quantity_values = array(); $weight_values = array();
                                                                            $unit_name_values = array();
                                                                            $unit_id_values = explode(",", $unit_id);
                                                                            $unit_name_values = explode(",", $unit_name);
                                                                            $quantity_values = explode(",", $quantity);
                                                                            $weight_values = explode(",", $weight);
                                                                            for($i = 0; $i < count($unit_id_values); $i++) {
                                                                                if(!empty($unit_name_values[$i]) && $unit_name_values[$i] != $GLOBALS['null_value']) {
                                                                                    $unit_name_values[$i] = $obj->encode_decode('decrypt', $unit_name_values[$i]);
                                                                                }
                                                                                if(!empty($quantity_values[$i]) && empty($weight_values[$i])) {
                                                                                    echo $quantity_values[$i]." ".$unit_name_values[$i]."<br>";
                                                                                }
                                                                                else if(!empty($weight_values[$i]) && empty($quantity_values[$i])) {
                                                                                    echo $weight_values[$i]." ".$unit_name_values[$i]."<br>";
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php 
                                                                        $rate = "";
                                                                        if(!empty($list['rate']) && $list['rate'] != $GLOBALS['null_value']) {
                                                                            $rate = $list['rate'];
                                                                        }
                                                                        if(!empty($rate)) {
                                                                            $rate_values = array();
                                                                            $rate_values = explode(",", $rate);
                                                                            for($g=0; $g < count($rate_values); $g++) {
                                                                                echo "Rs.".$rate_values[$g]."<br>";
                                                                            }
                                                                        } 
                                                                    ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['total_amount'])) { echo $list['total_amount']; } ?>
                                                                </th>
                                                                <th class="px-4">
                                                                    <?php if(!empty($list['bill_type'])) { echo $obj->encode_decode('decrypt', $list['bill_type']); } ?>
                                                                </th>
                                                                <th class="delete_lr">
                                                                    <button class="btn btn-danger" type="button" onclick="Javascript:DeleteLrRow('<?php if(!empty($lr_count)) { echo $lr_count; } ?>');"><i class="fa fa-trash"></i></button>
                                                                </th>
                                                            </tr>
                                <?php
                                                        }
                                                    }
                                                }
                                                $lr_count --;
                                            }
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'luggage_sheet_form', 'luggage_sheet_changes.php', 'luggage_sheet.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.add_update_form_content').find('select').select2();
                });
            </script>
            <script type="text/javascript" src="include/js/bootstrap-datepicker.min.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    if(jQuery('.date_field').length > 0) {
                        jQuery('.date_field').datepicker({
                            format: "dd-mm-yyyy",
                            autoclose: true,
                            startDate: "<?php if(!empty($prev_date)) { echo $prev_date; } ?>",
                            endDate: "today"
                        });
                    }
                }); 
            </script> 
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    <?php
                        if(!empty($show_luggage_sheet_id)) {
                    ?>
                            getLocationAndLR('<?php if(!empty($from_location)) { echo $from_location; } ?>', '<?php if(!empty($to_location)) { echo $to_location; } ?>');
                    <?php
                        }
                    ?>
                }); 
            </script> 
        </form>
		<?php
    } 

    if(isset($_POST['from_location'])) {
        $current_date = date("Y-m-d"); $entry_date_from = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
        $entry_date = ""; $entry_date_error = ""; $from_location = ""; $to_location = ""; $from_location_error = ""; $to_location_error = ""; $from_location_details = ""; $to_location_details = ""; 

        $lr_ids = array(); $lr_numbers = array(); $vehicle_id = ""; $vehicle_details = ""; $driver_name = "";
        $driver_number = ""; $helper_name = ""; $vehicle_id_error = ""; $driver_name_error = ""; $driver_number_error = "";
        $helper_name_error = ""; $lr_count = 0; $driver_details = "";

        $valid_luggage_sheet = ""; $form_name = "luggage_sheet_form"; $luggage_sheet_error = "";

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }

        if(isset($_POST['entry_date'])) {
            $entry_date = $_POST['entry_date'];
            $entry_date = trim($entry_date);
        }
        if(!empty($entry_date)) {
            $entry_date = date("d-m-Y", strtotime($entry_date));
        }
        $entry_date_error = $valid->valid_date($entry_date, "Entry Date", "1");
        if(empty($entry_date_error)) {
            if( (strtotime($entry_date) >= strtotime($entry_date_from)) && (strtotime($entry_date) <= strtotime($current_date)) ) {
                $entry_date = date("Y-m-d", strtotime($entry_date));
            }
            else {
                $entry_date_error = "Invalid Entry date";
            }
        }
        if(!empty($entry_date_error)) {
            $valid_luggage_sheet = $valid->error_display($form_name, "entry_date", $entry_date_error, 'text');			
        }

        $from_location = $_POST['from_location'];
        $from_location = trim($from_location);
        if(!empty($from_location)) {
            $godown_unique_id = "";
            $godown_unique_id = $obj->getTableColumnValue($GLOBALS['godown_table'], 'godown_id', $from_location, 'id');
            if(preg_match("/^\d+$/", $godown_unique_id)) {
                $from_location_details = $obj->getTableColumnValue($GLOBALS['godown_table'], 'id', $godown_unique_id, 'name');
            }
            else {
                $from_location_error = "Invalid From Location";
            }
        }
        else {
            $from_location_error = "Select From Location";
        }
        if(!empty($from_location_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "from_location", $from_location_error, 'select');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "from_location", $from_location_error, 'select');		
            }
        }

        if(isset($_POST['to_location'])) {
            $to_location = $_POST['to_location'];
            $to_location = trim($to_location);
        }
        if(!empty($to_location)) {
            $branch_unique_id = "";
            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $to_location, 'id');
            if(preg_match("/^\d+$/", $branch_unique_id)) {
                $to_location_details = $obj->getTableColumnValue($GLOBALS['branch_table'], 'id', $branch_unique_id, 'prefix_name_mobile');
            }
            else {
                $to_location_error = "Invalid To Location";
            }
        }
        else {
            $to_location_error = "Select To Location";
        }
        if(!empty($to_location_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "to_location", $to_location_error, 'select');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "to_location", $to_location_error, 'select');		
            }
        }

        if(isset($_POST['vehicle_id'])) {
            $vehicle_id = $_POST['vehicle_id'];
            $vehicle_id = trim($vehicle_id);
        }
        if(!empty($vehicle_id)) {
            $vehicle_unique_id = "";
            $vehicle_unique_id = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'vehicle_id', $vehicle_id, 'id');
            if(preg_match("/^\d+$/", $vehicle_unique_id)) {
                $vehicle_details = $obj->getTableColumnValue($GLOBALS['vehicle_table'], 'id', $vehicle_unique_id, 'vehicle_details');
            }
            else {
                $vehicle_id_error = "Invalid Vehicle";
            }
        }
        else {
            $vehicle_id_error = "Select Vehicle";
        }
        if(!empty($vehicle_id_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "vehicle_id", $vehicle_id_error, 'select');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "vehicle_id", $vehicle_id_error, 'select');		
            }
        }

        if(isset($_POST['driver_number'])) {
            $driver_number = $_POST['driver_number'];
            $driver_number = trim($driver_number);
            $driver_number_error = $valid->valid_mobile_number($driver_number, "Driver Number", "1");
        }
        if(!empty($driver_number_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "driver_number", $driver_number_error, 'text');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "driver_number", $driver_number_error, 'text');		
            }
        }

        if(isset($_POST['driver_name'])) {
            $driver_name = $_POST['driver_name'];
            $driver_name = trim($driver_name);
            if(strlen($driver_name) > 30) {
                $driver_name_error = "Only 30 characters allowed";
            }
            else {
                $driver_name_error = $valid->valid_text($driver_name, "Driver Name", "1");
            }
        }
        if(!empty($driver_name_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "driver_name", $driver_name_error, 'text');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "driver_name", $driver_name_error, 'text');		
            }
        }

        if(isset($_POST['helper_name'])) {
            $helper_name = $_POST['helper_name'];
            $helper_name = trim($helper_name);
            if(strlen($helper_name) > 30) {
                $helper_name_error = "Only 30 characters allowed";
            }
            else {
                $helper_name_error = $valid->valid_text($helper_name, "Driver Name", "1");
            }
        }
        if(!empty($helper_name_error)) {
            if(!empty($valid_luggage_sheet)) {
                $valid_luggage_sheet = $valid_luggage_sheet." ".$valid->error_display($form_name, "helper_name", $helper_name_error, 'text');		
            }
            else {
                $valid_luggage_sheet = $valid->error_display($form_name, "helper_name", $helper_name_error, 'text');		
            }
        }

        if(isset($_POST['lr_id'])) {
            $lr_ids = $_POST['lr_id'];
        }
        if(!empty($lr_ids)) {
            for($f=0; $f < count($lr_ids); $f++) {
                if(!empty($lr_ids[$f])) {
                    $lr_unique_id = "";
                    $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $lr_ids[$f], 'id');
                    if(preg_match("/^\d+$/", $lr_unique_id)) {
                        $lr_no = "";
                        $lr_no = $obj->getTableColumnValue($GLOBALS['lr_table'], 'id', $lr_unique_id, 'lr_number');
                        $lr_numbers[$f] = $lr_no;
                        $prev_lr_id = "";
                        if(!empty($lr_ids[$f+1])) {
                            $prev_lr_id = $lr_ids[$f+1];
                        }
                        if(!empty($prev_lr_id) && $prev_lr_id == $lr_ids[$f]) {
                            $luggage_sheet_error = "Same LR repeated";
                        }
                    }
                    else {
                        $luggage_sheet_error = "Invalid LR";
                    }
                }
            }
        }
        else {
            $luggage_sheet_error = "Select LR";
        }

        $result = "";
		if(empty($valid_luggage_sheet)) {
            if(empty($luggage_sheet_error)) {
                $check_user_id_ip_address = "";
                $check_user_id_ip_address = $obj->check_user_id_ip_address();	
                if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                    if(!empty($driver_name)) {
                        $driver_details = $driver_name;
                        $driver_name = $obj->encode_decode('encrypt', $driver_name);
                    }
                    else {
                        $driver_name = $GLOBALS['null_value'];
                    }
                    if(!empty($driver_number)) {
                        if(!empty($driver_details)) {
                            $driver_details = $driver_details." (".$driver_number.")";
                        }
                        $driver_number = $obj->encode_decode('encrypt', $driver_number);
                    }
                    else {
                        $driver_number = $GLOBALS['null_value'];
                    }
                    if(!empty($helper_name)) {
                        $helper_name = $obj->encode_decode('encrypt', $helper_name);
                    }
                    else {
                        $helper_name = $GLOBALS['null_value'];
                    }
                    if(empty($vehicle_id)) {
                        $vehicle_id = $GLOBALS['null_value'];
                        $vehicle_details = $GLOBALS['null_value'];
                    }
                    if(!empty($driver_details)) {
                        $driver_details = $obj->encode_decode('encrypt', $driver_details);
                    }

                    $lr_count = count($lr_numbers);
                    if(!empty($lr_ids)) {
                        $lr_ids = implode(",", $lr_ids);
                    }
                    if(!empty($lr_numbers)) {
                        $lr_numbers = implode(",", $lr_numbers);
                    }

                    $prev_lr_numbers = "";
                    if(!empty($edit_id)) {
                        $prev_lr_numbers = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $edit_id, 'lr_number');
                    }

                    $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                    $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                    if(empty($edit_id)) {
                        $null_value = $GLOBALS['null_value']; $cancelled = 0; $cancel_date = $GLOBALS['default_date']; $cancel_remarks = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'luggage_sheet_id', 'luggage_sheet_number', 'entry_date', 'from_location', 'from_location_details', 'to_location', 'to_location_details', 'lr_id', 'lr_number', 'lr_count', 'vehicle_id', 'vehicle_details', 'driver_name', 'driver_number', 'driver_details', 'helper_name', 'cleared', 'cancelled', 'cancel_date', 'cancel_remarks', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$null_value."'", "'".$entry_date."'", "'".$from_location."'", "'".$from_location_details."'", "'".$to_location."'", "'".$to_location_details."'", "'".$lr_ids."'", "'".$lr_numbers."'", "'".$lr_count."'", "'".$vehicle_id."'", "'".$vehicle_details."'", "'".$driver_name."'", "'".$driver_number."'", "'".$driver_details."'", "'".$helper_name."'", "'0'", "'".$cancelled."'", "'".$cancel_date."'", "'".$cancel_remarks."'", "'0'");
                        $luggage_insert_id = $obj->InsertSQL($GLOBALS['luggage_sheet_table'], $columns, $values, 'luggage_sheet_id', 'luggage_sheet_number', '');
                        if(preg_match("/^\d+$/", $luggage_insert_id)) {	
                            $luggage_sheet_number = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'id', $luggage_insert_id, 'luggage_sheet_number');							
                            $result = array('number' => '1', 'msg' => 'Luggage Sheet Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $luggage_insert_id);
                        }
                    }
                    else {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {                            
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'entry_date', 'from_location', 'from_location_details', 'to_location', 'to_location_details', 'lr_id', 'lr_number', 'lr_count', 'vehicle_id', 'vehicle_details', 'driver_name', 'driver_number', 'driver_details', 'helper_name');
                            $values = array("'".$creator_name."'", "'".$entry_date."'", "'".$from_location."'", "'".$from_location_details."'", "'".$to_location."'", "'".$to_location_details."'", "'".$lr_ids."'", "'".$lr_numbers."'", "'".$lr_count."'", "'".$vehicle_id."'", "'".$vehicle_details."'", "'".$driver_name."'", "'".$driver_number."'", "'".$driver_details."'", "'".$helper_name."'");
                            $luggage_update_id = $obj->UpdateSQL($GLOBALS['luggage_sheet_table'], $getUniqueID, $columns, $values, '');
                            if(preg_match("/^\d+$/", $luggage_update_id)) {	
                                $luggage_sheet_number = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $edit_id, 'luggage_sheet_number');
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $luggage_update_id);
                            }							
                        }
                    }

                    if(!empty($luggage_sheet_number)) {
                        $luggage_sheet_unique_id = "";
                        $luggage_sheet_unique_id = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_number', $luggage_sheet_number, 'id');
                        if(preg_match("/^\d+$/", $luggage_sheet_unique_id)) {
                            $action = "";
                            if(!empty($edit_id)) {
                                $action = "Luggage Sheet Updated. Number - ".$luggage_sheet_number;
                            }
                            else {
                                $action = "New Luggage Sheet Created. Number - ".$luggage_sheet_number;
                            }
                            $columns = array(); $values = array();						
                            $columns = array('luggage_sheet_number');
                            $values = array("'".$luggage_sheet_number."'");
                            $msg = $obj->UpdateSQL($GLOBALS['luggage_sheet_table'], $luggage_sheet_unique_id, $columns, $values, $action);
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
                                                    $columns = array(); $values = array();						
                                                    $columns = array('luggage_sheet_number');
                                                    $values = array("'".$GLOBALS['null_value']."'");
                                                    $msg = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, '');
                                                }
                                            }
                                        }
                                    }
    
                                    foreach($lr_numbers as $lr_number) {
                                        if(!empty($lr_number)) {
                                            $lr_unique_id = "";
                                            $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'id');
                                            if(preg_match("/^\d+$/", $lr_unique_id)) {
                                                $action = "Luggage Sheet LR Updated. LR Number - ".$lr_number.", Luggage Sheet Number - ".$luggage_sheet_number;
                                                $columns = array(); $values = array();						
                                                $columns = array('luggage_sheet_number');
                                                $values = array("'".$luggage_sheet_number."'");
                                                $msg = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, $action);
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
                if(!empty($luggage_sheet_error)) {
                    $result = array('number' => '2', 'msg' => $luggage_sheet_error);
                }
            }
		}
		else {
			if(!empty($valid_luggage_sheet)) {
				$result = array('number' => '3', 'msg' => $valid_luggage_sheet);
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
        
        $filter_from_date = "";
        if(isset($_POST['filter_from_date'])) {
            $filter_from_date = $_POST['filter_from_date'];
        }
        $filter_to_date = "";
        if(isset($_POST['filter_to_date'])) {
            $filter_to_date = $_POST['filter_to_date'];
        }
        $filter_branch_id = "";
        if(isset($_POST['filter_branch_id'])) {
            $filter_branch_id = $_POST['filter_branch_id'];
        }
        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = $_POST['search_text'];
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
                    include("luggage_sheet_table.php"); 
                ?>
            </div>
            <div class="tab-pane fade" id="cancel_bill">
                <?php 
                    $cancelled = 1;
                    include("luggage_sheet_table.php"); 
                ?>
            </div>
        </div>
<?php	
	}

    if(isset($_POST['cancel_bill_id'])) {
        $cancell_bill_error = ""; $cancel_bill_id = ""; $cancel_bill_id_error = ""; $cancel_bill_remarks = ""; $cancel_bill_remarks_error = "";

        $cancel_bill_id = $_POST['cancel_bill_id'];
        $cancel_bill_id = trim($cancel_bill_id);
        if(!empty($cancel_bill_id)) {
            $cancel_bill_unique_id = ""; $cancel_bill_table = "";
            $cancel_bill_unique_id = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $cancel_bill_id, 'id');
            if(!empty($cancel_bill_unique_id) && preg_match("/^\d+$/", $cancel_bill_unique_id)) {
                $cancel_bill_table = $GLOBALS['luggage_sheet_table'];
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

            $luggage_sheet_number = "";
            if(!empty($cancel_bill_id)) {
                $luggage_sheet_number = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_id', $cancel_bill_id, 'luggage_sheet_number');
                if(!empty($luggage_sheet_number)) {
                    $action = "Luggage Sheet Cancelled. Number - ".$luggage_sheet_number;
        
                    $columns = array(); $values = array();						
                    $columns = array('cancelled', 'cancel_remarks');
                    $values = array("'1'", "'".$cancel_bill_remarks."'");
                    $msg = $obj->UpdateSQL($cancel_bill_table, $cancel_bill_unique_id, $columns, $values, $action);                    
                    if(preg_match("/^\d+$/", $msg)) {
                        $result = array('number' => '1', 'msg' => 'Successfully Cancelled');
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