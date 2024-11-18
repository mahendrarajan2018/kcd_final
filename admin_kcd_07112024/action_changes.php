<?php
    include("include.php");

    if(isset($_REQUEST['gst_organization_id'])) {
        $gst_organization_id = $_REQUEST['gst_organization_id'];
        $gst_organization_id = trim($gst_organization_id);
        $tax_on_off = "";
        if(!empty($gst_organization_id)) {
            $tax_on_off = $obj->getTableColumnValue($GLOBALS['organization_table'], 'organization_id', $gst_organization_id, 'tax_on_off');
        }
        echo $tax_on_off; exit;
    }

    if(isset($_REQUEST['lr_party_type'])) {
        $party_type = $_REQUEST['lr_party_type'];
        $party_type = trim($party_type);

        $party_id = $_REQUEST['lr_party_id'];
        $party_id = trim($party_id);

        if(!empty($party_type)) {
            $form_name = "lr";
            include("lr_party_search.php");
        }
    }

    if(isset($_REQUEST['lr_party_name_mobile_type'])) {
        $party_type = $_REQUEST['lr_party_name_mobile_type'];
        $party_type = trim($party_type);

        $party_id = $_REQUEST['lr_party_name_mobile_id'];
        $party_id = trim($party_id);

        $party_details = "";
        if(!empty($party_type)) {
            $party_name = ""; $party_mobile_number = "";
            if($party_type == "consignor") {
                $party_list = $obj->getTableRecords($GLOBALS['consignor_table'], '', '','');
                $consignor_list = array();
                if(!empty($party_id)) {
                    $consignor_list = $obj->getTableRecords($GLOBALS['consignor_table'], 'consignor_id', $party_id,'');
                }
                if(!empty($consignor_list)) {
                    foreach($consignor_list as $data) {
                        if(!empty($data['name'])) {
                            $party_name = $obj->encode_decode('decrypt', $data['name']);
                        }
                        if(!empty($data['mobile_number'])) {
                            $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                        }
                    }
                }
            }
            else if($party_type == "consignee") {
                $party_list = $obj->getTableRecords($GLOBALS['consignee_table'], '', '','');
                $consigee_list = array();
                if(!empty($party_id)) {
                    $consigee_list = $obj->getTableRecords($GLOBALS['consignee_table'], 'consignee_id', $party_id,'');
                }
                if(!empty($consigee_list)) {
                    foreach($consigee_list as $data) {
                        if(!empty($data['name'])) {
                            $party_name = $obj->encode_decode('decrypt', $data['name']);
                        }
                        if(!empty($data['mobile_number'])) {
                            $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                        }
                    }
                }
            }
            else if($party_type == "account_party") {
                $party_list = $obj->getTableRecords($GLOBALS['account_party_table'], '', '','');
                $account_party_list = array();
                if(!empty($party_id)) {
                    $account_party_list = $obj->getTableRecords($GLOBALS['account_party_table'], 'account_party_id', $party_id,'');
                }
                if(!empty($account_party_list)) {
                    foreach($account_party_list as $data) {
                        if(!empty($data['name'])) {
                            $party_name = $obj->encode_decode('decrypt', $data['name']);
                        }
                        if(!empty($data['mobile_number'])) {
                            $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                        }
                    }
                }
            }
            if(!empty($party_name) && !empty($party_mobile_number)) {
                $party_details = strtoupper($party_name)."<br>".$party_mobile_number;
            }
        }
        echo $party_details; exit;
    }

    if(isset($_REQUEST['from_branch_id'])) {
        $from_branch_id = $_REQUEST['from_branch_id'];
        $from_branch_id = trim($from_branch_id);

        $branch_list = array();
        $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');
?>
        <div class="form-label-group in-border mb-0">
            <select name="to_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                <option>Select To Branch</option>
                <?php
                    if(!empty($branch_list)) {
                        foreach($branch_list as $data) {
                            if(!empty($data['branch_id'])) {
                                if(!empty($from_branch_id) && $data['branch_id'] == $from_branch_id) { continue; }
                ?>
                                <option value="<?php echo $data['branch_id']; ?>">
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
            <label>Select To Branch</label>
            <script>
                jQuery('select[name="to_branch_id"]').select2();
            </script>
        </div>
<?php
    }

    if(isset($_REQUEST['add_lr_row'])) {
        $add_lr_row = $_REQUEST['add_lr_row'];
        $add_lr_row = trim($add_lr_row);
        if(!empty($add_lr_row) && $add_lr_row == 1) {
            $unit_list = array();
            $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');
            $class_name = "unit_".strtotime(date("dmYHis"));
?>
            <tr class="lr_row">
                <td class="sno"></td>
                <td>
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="unit_id[]" class="select2 select2-danger <?php echo $class_name; ?>" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select Unit</option>
                                <?php
                                    if(!empty($unit_list)) {
                                        foreach($unit_list as $data) {
                                            if(!empty($data['unit_id'])) {
                                ?>
                                                <option value="<?php echo $data['unit_id']; ?>">
                                                    <?php
                                                        if(!empty($data['unit_name'])) {
                                                            $data['unit_name'] = $obj->encode_decode('decrypt', $data['unit_name']);
                                                            echo $data['unit_name'];
                                                        }
                                                    ?>                                                                        
                                                </option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Select Unit</label>
                        </div>
                    </div> 
                    <script>
                        jQuery('.<?php echo $class_name; ?>').select2();
                    </script>
                </td>
                <td>
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="quantity[]" class="form-control shadow-none" value="" onkeyup="Javascript:CalTotal();">
                            <label>QTY</label>
                        </div>
                    </div> 
                </td>
                <td>
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="weight[]" class="form-control shadow-none" value="" onkeyup="Javascript:CalTotal();">
                            <label>Weight</label>
                        </div>
                    </div> 
                </td>
                <td>
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="rate[]" class="form-control shadow-none" value="" onkeyup="Javascript:CalTotal();">
                            <label>Price</label>
                        </div>
                    </div> 
                </td>
                <td class="freight"></td>
                <td>
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="kooli[]" class="form-control shadow-none" value="" onkeyup="Javascript:CalTotal();">
                            <label>Kooli / Unit</label>
                        </div>
                    </div> 
                </td>
                <td class="kooli_by_quantity"></td>
                <td class="amount"></td>
                <td>
                    <button class="btn btn-danger" type="button" onClick="Javascript:DeleteLRRow(this);"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
<?php
        }
    }

    if(isset($_REQUEST['tripsheet_luggage_branch_id'])) {
        $tripsheet_luggage_branch_id = $_REQUEST['tripsheet_luggage_branch_id'];
        $tripsheet_luggage_branch_id = trim($tripsheet_luggage_branch_id);

        if(!empty($tripsheet_luggage_branch_id)) {
            $luggage_sheet_number_list = array();
            $luggage_sheet_number_list = $obj->getTripsheetLuggageSheetNumberByBranch($tripsheet_luggage_branch_id);
?>
            <div class="input-group tripsheet_select2">
                <select name="tripsheet_luggage_sheet_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option value="">Select LR</option>
                    <?php
                        if(!empty($luggage_sheet_number_list)) {
                            foreach($luggage_sheet_number_list as $luggage_sheet_number) {
                                if(!empty($luggage_sheet_number)) {
                    ?>
                                    <option value="<?php echo $luggage_sheet_number; ?>"> <?php echo $luggage_sheet_number; ?> </option>
                    <?php
                                }                                                                        
                            }
                        }
                    ?>
                </select>
                <label>Select LR</label>
                <div class="input-group-append">
                    <span class="input-group-text add_tripsheet_button" onClick="Javascript:AddTripsheetRow();" style="background-color:#f06548!important; cursor:pointer; height:100%;"><i class="fa fa-plus text-white"></i></span>
                </div>
                <script>
                    jQuery('select[name="tripsheet_luggage_sheet_number"]').select2();
                </script>
            </div>
<?php
        }
    }

    if(isset($_REQUEST['tripsheet_lr_branch_id'])) {
        $tripsheet_lr_branch_id = $_REQUEST['tripsheet_lr_branch_id'];
        $tripsheet_lr_branch_id = trim($tripsheet_lr_branch_id);

        if(!empty($tripsheet_lr_branch_id)) {
            $lr_number_list = array();
            $lr_number_list = $obj->getTripsheetLRNumberByBranch($tripsheet_lr_branch_id);
?>
            <div class="input-group tripsheet_select2">
                <select name="tripsheet_lr_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option value="">Select LR</option>
                    <?php
                        if(!empty($lr_number_list)) {
                            foreach($lr_number_list as $lr_number) {
                                if(!empty($lr_number)) {
                    ?>
                                    <option value="<?php echo $lr_number; ?>"> <?php echo $lr_number; ?> </option>
                    <?php
                                }                                                                        
                            }
                        }
                    ?>
                </select>
                <label>Select LR</label>
                <div class="input-group-append">
                    <span class="input-group-text add_tripsheet_button" onClick="Javascript:AddTripsheetRow();" style="background-color:#f06548!important; cursor:pointer; height:100%;"><i class="fa fa-plus text-white"></i></span>
                </div>
                <script>
                    jQuery('select[name="tripsheet_lr_number"]').select2();
                </script>
            </div>
<?php
        }
    }

    if(isset($_REQUEST['add_tripsheet_lr_number'])) {
        $add_tripsheet_lr_number = $_REQUEST['add_tripsheet_lr_number'];
        $add_tripsheet_lr_number = trim($add_tripsheet_lr_number);

        $add_tripsheet_luggage_sheet_number = $_REQUEST['add_tripsheet_luggage_sheet_number'];
        $add_tripsheet_luggage_sheet_number = trim($add_tripsheet_luggage_sheet_number);

        $lr_number_list = array();
        if(!empty($add_tripsheet_lr_number)) {
            $lr_number_list[] = $add_tripsheet_lr_number;
        }
        else if(!empty($add_tripsheet_luggage_sheet_number)) {
            $lr_numbers = "";
            $lr_numbers = $obj->getTableColumnValue($GLOBALS['luggage_sheet_table'], 'luggage_sheet_number', $add_tripsheet_luggage_sheet_number, 'lr_number');
            if(!empty($lr_numbers)) {
                $lr_number_list = explode(",", $lr_numbers);
            }
        }
        if(!empty($lr_number_list)) {
            foreach($lr_number_list as $lr_number) {
                if(!empty($lr_number)) {
                    $lr_date = ""; $from_branch_details = ""; $consignor_name_mobile_city = ""; $consignee_name_mobile_city = ""; $unit_name_values = array();
                    $quantity_values = array(); $weight_values = array(); $rate_values = array(); $total_amount = ""; $bill_type = "";

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
                            <th class="sno"></th>
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
    }

?>