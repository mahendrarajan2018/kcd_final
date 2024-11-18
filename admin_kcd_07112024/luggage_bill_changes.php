<?php
    include("include.php");

    if(isset($_REQUEST['get_location_lr'])) {
        $from_location = $_REQUEST['get_location_lr'];

        $to_list = array();
        $to_list = $obj->LuggagesheetToList($from_location);

        $lr_list = array();
        $lr_list = $obj->getLRlistForLuggagesheet($from_location);

?>
        <option value="">Select To Location</option>
<?php
        if(!empty($to_list)) {
            foreach($to_list as $data) {
                if(!empty($data['branch_id']) && $data['branch_id'] != $GLOBALS['null_value']) {
?>
                    <option value="<?php echo $data['branch_id']; ?>">
                        <?php
                            if(!empty($data['prefix_name_mobile']) && $data['prefix_name_mobile'] != $GLOBALS['null_value']) {
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
        $$$
        <option value="">Select LR</option>
<?php
        if(!empty($lr_list)) {
            foreach($lr_list as $list) {
                if(!empty($list['lr_id']) && $list['lr_id'] != $GLOBALS['null_value']) {
?>
                    <option value="<?php echo $list['lr_id']; ?>">
                        <?php
                            if(!empty($list['lr_number']) && $list['lr_number']) {
                                echo $list['lr_number'];
                            }
                        ?>
                    </option>
<?php
                }
            }
        }
    }

    if(isset($_REQUEST['lr_row_index'])) {
        $lr_row_index = $_REQUEST['lr_row_index'];
        $selected_lr_id = $_REQUEST['selected_lr_id'];
        $lr_list = array();

        if(!empty($selected_lr_id) && $selected_lr_id != $GLOBALS['null_value']) {
            $lr_list = $obj->getTableRecords($GLOBALS['lr_table'], 'lr_id', $selected_lr_id, '');
        }

        $lr_date = ""; $lr_number = ""; $to_branch_id = ""; $to_branch_details = ""; $consignor_id = "";
        $consignor_name_mobile_city = ""; $consignee_id = ""; $consignee_name_mobile_city = ""; $quantity = "";
        $weight = ""; $rate = ""; $unit_id = ""; $unit_name = ""; $total_amount = 0; $bill_type = "";
        if(!empty($lr_list)) {
            foreach($lr_list as $data) {
                if(!empty($data['lr_date'])) {
                    $lr_date = date("d-m-Y", strtotime($data['lr_date']));
                }
                if(!empty($data['lr_number']) && $data['lr_number'] != $GLOBALS['null_value']) {
                    $lr_number = $data['lr_number'];
                }
                if(!empty($data['to_branch_id']) && $data['to_branch_id'] != $GLOBALS['null_value']) {
                    $to_branch_id = $data['to_branch_id'];
                }
                if(!empty($data['to_branch_details']) && $data['to_branch_details'] != $GLOBALS['null_value']) {
                    $to_branch_details = $obj->encode_decode('decrypt', $data['to_branch_details']);
                }
                if(!empty($data['consignor_id']) && $data['consignor_id'] != $GLOBALS['null_value']) {
                    $consignor_id = $data['consignor_id'];
                }
                if(!empty($data['consignor_name_mobile_city']) && $data['consignor_name_mobile_city'] != $GLOBALS['null_value']) {
                    $consignor_name_mobile_city = $obj->encode_decode('decrypt', $data['consignor_name_mobile_city']);
                }
                if(!empty($data['consignee_id']) && $data['consignee_id'] != $GLOBALS['null_value']) {
                    $consignee_id = $data['consignee_id'];
                }
                if(!empty($data['consignee_name_mobile_city']) && $data['consignee_name_mobile_city'] != $GLOBALS['null_value']) {
                    $consignee_name_mobile_city = $obj->encode_decode('decrypt', $data['consignee_name_mobile_city']);
                }
                if(!empty($data['quantity']) && $data['quantity'] != $GLOBALS['null_value']) {
                    $quantity = $data['quantity'];
                }
                if(!empty($data['weight']) && $data['weight'] != $GLOBALS['null_value']) {
                    $weight = $data['weight'];
                }
                if(!empty($data['unit_id']) && $data['unit_id'] != $GLOBALS['null_value']) {
                    $unit_id = $data['unit_id'];
                }
                if(!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                    $unit_name = $data['unit_name'];
                }
                if(!empty($data['rate']) && $data['rate'] != $GLOBALS['null_value']) {
                    $rate = $data['rate'];
                }
                if(!empty($data['total_amount']) && $data['total_amount'] != $GLOBALS['null_value']) {
                    $total_amount = $data['total_amount'];
                }
                if(!empty($data['bill_type']) && $data['bill_type'] != $GLOBALS['null_value']) {
                    $bill_type = $obj->encode_decode('decrypt', $data['bill_type']);
                }
            }
?>
            <tr class="lr_row" id="lr_row<?php if(!empty($lr_row_index)) { echo $lr_row_index; } ?>">
                <th class="sno"><?php if(!empty($lr_row_index)) { echo $lr_row_index; } ?></th>
                <th class="px-4">
                    <?php if(!empty($lr_date)) { echo $lr_date; } ?>
                </th>
                <th class="px-4">
                    <?php if(!empty($lr_number)) { echo $lr_number; } ?>
                    <input type="hidden" name="lr_id[]" value="<?php if(!empty($selected_lr_id)) { echo $selected_lr_id; } ?>">
                </th>
                <th class="px-4">
                    <?php if(!empty($to_branch_details)) { echo $to_branch_details; } ?>
                </th>
                <th class="px-4">
                    <?php if(!empty($consignor_name_mobile_city)) { echo $consignor_name_mobile_city; } ?>
                </th>
                <th class="px-4">
                    <?php if(!empty($consignee_name_mobile_city)) { echo $consignee_name_mobile_city; } ?>
                </th>
                <th class="px-4">
                    <?php
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
                    <?php if(!empty($total_amount)) { echo $total_amount; } ?>
                </th>
                <th class="px-4">
                    <?php if(!empty($bill_type)) { echo $bill_type; } ?>
                </th>
                <th class="delete_lr">
                    <button class="btn btn-danger" type="button" onclick="Javascript:DeleteLrRow('<?php if(!empty($lr_row_index)) { echo $lr_row_index; } ?>');"><i class="fa fa-trash"></i></button>
                </th>
            </tr>
<?php
        }
    }
?>