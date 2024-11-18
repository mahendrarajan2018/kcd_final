<?php
	include("include.php");

	if(isset($_REQUEST['show_lr_id'])) { 
        $show_lr_id = $_REQUEST['show_lr_id'];
        $show_lr_id = trim($show_lr_id);

        $current_date = date("Y-m-d"); $lr_date_from = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));

        $form_name = "lr"; $lr_date = date("Y-m-d"); $organization_id = ""; $consignor_id = ""; $consignee_id = ""; $account_party_id = ""; $from_branch_id = "";
        $to_branch_id = ""; $bill_type = ""; $gst_option = 0; $tax_value = ""; $unit_values = array(); $quantity_values = array(); $weight_values = array();
        $rate_values = array(); $kooli_values = array();

        if(!empty($show_lr_id)) {
            $lr_list = array();
            $lr_list = $obj->getTableRecords($GLOBALS['lr_table'], 'lr_id', $show_lr_id, '');
            if(!empty($lr_list)) {
                foreach($lr_list as $data) {
                    if(!empty($data['lr_date'])) {
                        $lr_date = $data['lr_date'];
                    }
                    if(!empty($data['organization_id'])) {
                        $organization_id = $data['organization_id'];
                    }
                    if(!empty($data['consignor_id'])) {
                        $consignor_id = $data['consignor_id'];
                    }
                    if(!empty($data['consignee_id'])) {
                        $consignee_id = $data['consignee_id'];
                    }
                    if(!empty($data['account_party_id'])) {
                        $account_party_id = $data['account_party_id'];
                    }
                    if(!empty($data['from_branch_id'])) {
                        $from_branch_id = $data['from_branch_id'];
                    }
                    if(!empty($data['to_branch_id'])) {
                        $to_branch_id = $data['to_branch_id'];
                    }
                    if(!empty($data['bill_type'])) {
                        $bill_type = $data['bill_type'];
                    }
                    if(!empty($data['gst_option'])) {
                        $gst_option = $data['gst_option'];
                    }
                    if(!empty($data['tax_value'])) {
                        $tax_value = $data['tax_value'];
                    }
                    if(!empty($data['unit_id'])) {
                        $unit_id_values = explode(",", $data['unit_id']);
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
                }
            }
        }

        $organization_list = array();
        $organization_list = $obj->getTableRecords($GLOBALS['organization_table'], '', '','');

        $bill_type_list = $GLOBALS['bill_type_options']; $tax_value_list = $GLOBALS['tax_value_options'];

        $branch_list = array();
        $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');

        $unit_list = array();
        $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');
?>
        <form class="poppins pd-20 redirection_form" name="<?php echo $form_name; ?>_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_lr_id)){ ?>
                            <div class="h5">Add LR</div>
                        <?php }else{ ?>
                            <div class="h5">Edit LR</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('lr.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-2">
                <script type="text/javascript" src="include/js/action_changes.js"></script>
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_lr_id)) { echo $show_lr_id; } ?>">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group pb-1">
                                        <div class="form-label-group in-border pb-1">
                                            <input type="date" class="form-control shadow-none" name="lr_date" value="<?php if(!empty($lr_date)) { echo $lr_date; } ?>" min="<?php if(!empty($lr_date_from)) { echo $lr_date_from; } ?>" max="<?php if(!empty($current_date)) { echo $current_date; } ?>">
                                            <label>Date <span class="text-danger">*</span> </label>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group pb-1">
                                        <div class="form-label-group in-border pb-1">
                                            <select name="organization_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:ToggleGST(this.value);">
                                                <option value="">Select Organization</option>
                                                <?php
                                                    if(!empty($organization_list)) {
                                                        foreach($organization_list as $data) {
                                                            if(!empty($data['organization_id'])) {
                                                ?>
                                                                <option value="<?php echo $data['organization_id']; ?>" <?php if(!empty($organization_id) && $data['organization_id'] == $organization_id) { ?>selected="selected"<?php } ?> >
                                                                    <?php
                                                                        if(!empty($data['name'])) {
                                                                            $data['name'] = $obj->encode_decode('decrypt', $data['name']);
                                                                            echo $data['name'];
                                                                        }
                                                                    ?>                                                                    
                                                                </option>
                                                <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <label>Select Organization <span class="text-danger">*</span> </label>
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                            <div class="w-100" style="display: none;">
                                <select class="select2 select2-danger" name="country"></select>
                            </div>
                        </div>
                        <div id="consignor_details_cover" class="col-lg-4 col-md-4 col-12">
                            <?php
                                $party_type = "consignor"; $party_id = $consignor_id;
                                include("lr_party_search.php");
                            ?>
                        </div>  
                        <div id="consignee_details_cover" class="col-lg-4 col-md-4 col-12">
                            <?php
                                $party_type = "consignee"; $party_id = $consignee_id;
                                include("lr_party_search.php");
                            ?>
                        </div> 
                        <div id="account_party_details_cover" class="col-lg-4 col-md-4 col-12">
                            <?php
                                $party_type = "account_party"; $party_id = $account_party_id;
                                include("lr_party_search.php");
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 border-start">
                    <div class="border mb-1">
                        <div class="p-1">
                            <div class="fw-bold text-danger text-center pb-1">Consignor Details</div>
                            <div class="smallfnt" id="consignor_name_mobile"></div>
                        </div>
                    </div>
                    <div class="border mb-1">
                        <div class="p-1">
                            <div class="fw-bold text-danger text-center pb-1">Consignee Details</div>
                            <div class="smallfnt" id="consignee_name_mobile"></div>
                        </div>
                    </div>
                    <div class="border mb-1">
                        <div class="p-1">
                            <div class="fw-bold text-danger text-center pb-1">Account Party</div>
                            <div class="smallfnt" id="account_party_name_mobile"></div>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="row justify-content-end p-2">    
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="from_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getFilterBranchToList(this.value);">
                                <option value="">Select From Branch</option>
                                <?php
                                    if(!empty($branch_list)) {
                                        foreach($branch_list as $data) {
                                            if(!empty($data['branch_id'])) {
                                ?>
                                                <option value="<?php echo $data['branch_id']; ?>" <?php if(!empty($from_branch_id) && $data['branch_id'] == $from_branch_id) { ?>selected="selected"<?php } ?> >
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
                            <label>Select From Branch <span class="text-danger">*</span> </label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div id="branch_to_cover" class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="to_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select To Branch</option>
                                <?php
                                    if(!empty($branch_list)) {
                                        foreach($branch_list as $data) {
                                            if(!empty($data['branch_id'])) {
                                                if(!empty($from_branch_id) && $data['branch_id'] == $from_branch_id) { continue; }
                                ?>
                                                <option value="<?php echo $data['branch_id']; ?>" <?php if(!empty($to_branch_id) && $data['branch_id'] == $to_branch_id) { ?>selected="selected"<?php } ?> >
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
                            <label>Select To Branch <span class="text-danger">*</span> </label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="bill_type" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select Bill Type</option>
                                <?php
                                        if(!empty($bill_type_list)) {
                                            foreach($bill_type_list as $type_option) {
                                                if(!empty($type_option)) {
                                                    $type_option_encrypted = $obj->encode_decode('encrypt', $type_option);
                                    ?>
                                                    <option value="<?php echo $type_option_encrypted; ?>" <?php if(!empty($bill_type) && $type_option_encrypted == $bill_type) { ?>selected="selected"<?php } ?> >
                                                        <?php echo $type_option; ?>
                                                    </option>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                            </select>
                            <label>Select Bill Type <span class="text-danger">*</span> </label>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-2 col-md-6 col-12 align-self-center">
                    <div class="form-group mb-1">
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="gst_option" class="form-label text-muted">GST ON / OFF</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="gst_option" name="gst_option" value="<?php echo $gst_option; ?>" <?php if(!empty($gst_option) && $gst_option == 1) { ?>checked="checked"<?php } ?> onChange="Javascript:CustomCheckboxToggle(this, 'gst_option');">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="tax_value" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:CalTotal();">
                                <option value="">Select Tax</option>
                                <?php
                                    if(!empty($tax_value_list)) {
                                        foreach($tax_value_list as $tax) {
                                            if(!empty($tax)) {
                                ?>
                                                <option value="<?php echo $tax; ?>" <?php if(!empty($tax_value) && $tax == $tax_value) { ?>selected="selected"<?php } ?> ><?php echo $tax; ?></option>
                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <label>Select Tax</label>
                        </div>
                    </div> 
                </div>
            </div>   
            <div class="row"> 
                <div class="col-lg-12">
                    <div class="table-responsive text-center">
                        <table class="table nowrap cursor smallfnt w-100 lr_row_table">
                            <thead class="bg-dark smallfnt">
                                <tr style="white-space:pre;">
                                    <th>#</th>
                                    <th style="with:100px;">Unit</th>
                                    <th style="width:60px;">QTY</th>
                                    <th style="width:85px;">Weight</th>
                                    <th style="width:70px;">Price / QTY</th>
                                    <th style="width:100px;">Freight</th>
                                    <th style="width:100px;">Kooli / Unit</th>
                                    <th style="width:100px;">Kooli / QTY</th>
                                    <th style="width:100px;">Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($unit_id_values)) {
                                        for($i = 0; $i < count($unit_id_values); $i++) {
                                            $unit_id = ""; $quantity = ""; $weight = ""; $rate = ""; $kooli = "";
                                            if(!empty($unit_id_values[$i])) { $unit_id = $unit_id_values[$i]; }
                                            if(!empty($quantity_values[$i])) { $quantity = $quantity_values[$i]; }
                                            if(!empty($weight_values[$i])) { $weight = $weight_values[$i]; }
                                            if(!empty($rate_values[$i])) { $rate = $rate_values[$i]; }
                                            if(!empty($kooli_values[$i])) { $kooli = $kooli_values[$i]; }
                                ?>
                                            <tr class="lr_row">
                                                <td class="sno"><?php echo $i + 1; ?></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-label-group in-border mb-0">
                                                            <select name="unit_id[]" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                                <option value="">Select Unit</option>
                                                                <?php
                                                                    if(!empty($unit_list)) {
                                                                        foreach($unit_list as $data) {
                                                                            if(!empty($data['unit_id'])) {
                                                                ?>
                                                                                <option value="<?php echo $data['unit_id']; ?>" <?php if(!empty($unit_id) && $data['unit_id'] == $unit_id) { ?>selected="selected"<?php } ?> >
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
                                                </td>
                                                <td>
                                                    <div class="form-group mb-1">
                                                        <div class="form-label-group in-border">
                                                            <input type="text" name="quantity[]" class="form-control shadow-none" value="<?php if(!empty($quantity)) { echo $quantity; } ?>" onkeyup="Javascript:CalTotal();">
                                                            <label>QTY</label>
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td>
                                                    <div class="form-group mb-1">
                                                        <div class="form-label-group in-border">
                                                            <input type="text" name="weight[]" class="form-control shadow-none" value="<?php if(!empty($weight)) { echo $weight; } ?>" onkeyup="Javascript:CalTotal();">
                                                            <label>Weight</label>
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td>
                                                    <div class="form-group mb-1">
                                                        <div class="form-label-group in-border">
                                                            <input type="text" name="rate[]" class="form-control shadow-none" value="<?php if(!empty($rate)) { echo $rate; } ?>" onkeyup="Javascript:CalTotal();">
                                                            <label>Price</label>
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td class="freight"></td>
                                                <td>
                                                    <div class="form-group mb-1">
                                                        <div class="form-label-group in-border">
                                                            <input type="text" name="kooli[]" class="form-control shadow-none" value="<?php if(!empty($kooli)) { echo $kooli; } ?>" onkeyup="Javascript:CalTotal();">
                                                            <label>Kooli / Unit</label>
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td class="kooli_by_quantity"></td>
                                                <td class="amount"></td>
                                                <td>
                                                    <button class="btn btn-danger add_row_button" type="button" onClick="Javascript:AddLRRow();"><i class="bi bi-plus-circle"></i></button>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else {
                                ?>
                                <tr class="lr_row">
                                    <td class="sno">1</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select name="unit_id[]" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
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
                                        <button class="btn btn-danger add_row_button" type="button" onClick="Javascript:AddLRRow();"><i class="bi bi-plus-circle"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="text-end"> Total : </td>
                                    <td class="text-end sub_total"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">Delivery charges</td>
                                    <td colspan="2" class="text-end">
                                        <div class="w-100">
                                            <input type="text" name="delivery_charges" class="form-control shadow-none extra_charges" value="<?php if(!empty($delivery_charges)) { echo $delivery_charges; } ?>" placeholder="Extra charges" onChange="Javascript:CalTotal();">
                                        </div>
                                    </td>
                                    <td class="text-end delivery_charges_value"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-end ">Total :</td>
                                    <td class="text-end delivery_charges_total"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">Loading Charges</td>
                                    <td colspan="2" class="text-end">
                                        <div class="w-100">
                                            <input type="text" name="loading_charges" class="form-control shadow-none load" value="<?php if(!empty($loading_charges)) { echo $loading_charges; } ?>" placeholder="Loading charges" onChange="Javascript:CalTotal();">
                                        </div>
                                    </td>
                                    <td class="text-end loading_charges_value"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-end ">Total :</td>
                                    <td class="text-end loading_charges_total"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr class="cgst_row d-none">
                                    <td colspan="8" class="text-end ">CGST :</td>
                                    <td class="text-end cgst"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr class="sgst_row d-none">
                                    <td colspan="8" class="text-end ">SGST :</td>
                                    <td class="text-end sgst"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr class="igst_row d-none">
                                    <td colspan="8" class="text-end ">IGST :</td>
                                    <td class="text-end igst"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr class="gst_row d-none">
                                    <td colspan="8" class="text-end ">Total :</td>
                                    <td class="text-end gst_total"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-end ">Round OFF :</td>
                                    <td class="text-end round_off">  </td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-end ">Total :</td>
                                    <td class="text-end overall_total"></td>
                                    <td colspan="1" class="text-end"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 py-3 text-center">
                    <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'lr_form', 'lr_changes.php', 'lr.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.add_update_form_content').find('select').select2();    
                    <?php if(!empty($show_lr_id)) { ?>
                        CalTotal();
                    <?php } ?>                
                });
            </script>
        </form>
<?php
    } 

    if(isset($_POST['edit_id'])) {	
        $current_date = date("Y-m-d"); $lr_date_from = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
        $lr_date = ""; $lr_date_error = ""; $organization_id = ""; $organization_id_error = ""; $organization_details = ""; 

        $consignor_name = ""; $consignor_name_error = ""; $consignor_mobile_number = ""; $consignor_mobile_number_error = ""; $consignor_state = ""; 
        $consignor_state_error = ""; $consignor_district = ""; $consignor_district_error = ""; $consignor_city = ""; $consignor_city_error = "";
        
        $consignee_name = ""; $consignee_name_error = ""; $consignee_mobile_number = ""; $consignee_mobile_number_error = ""; $consignee_state = ""; 
        $consignee_state_error = ""; $consignee_district = ""; $consignee_district_error = ""; $consignee_city = ""; $consignee_city_error = "";
        
        $account_party_name = ""; $account_party_name_error = ""; $account_party_mobile_number = ""; $account_party_mobile_number_erorr = ""; 
        $account_party_state = ""; $account_party_state_error = ""; $account_party_district = ""; $account_party_district_error = ""; $account_party_city = "";
        $account_party_city_error = "";
        
        $from_branch_id = ""; $from_branch_id_error = ""; $from_branch_details = ""; $to_branch_id = ""; $to_branch_id_error = ""; $to_branch_details = "";
        $bill_type = ""; $bill_type_error = ""; $gst_option = 0; $tax_value = ""; $tax_value_error = ""; 
        
        $unit_id_values = array(); $unit_name_values = array(); $quantity_values = array(); $weight_values = array(); $rate_values = array(); $freight_values = array();
        $kooli_values = array(); $kooli_by_quantity_values = array(); $amount_values = array();

        $sub_total = 0; $delivery_charges = 0; $delivery_charges_error = ""; $delivery_charges_value = 0; $loading_charges = 0; $loading_charges_error = "";
        $loading_charges_value = 0; $cgst = 0; $sgst = 0; $igst = 0; $round_off = 0; $total_quantity = 0; $total_weight = 0; $total_amount = 0; 
        
        $luggage_sheet_number = $GLOBALS['null_value']; $tripsheet_number = $GLOBALS['null_value']; $cleared = 0; $received_person = $GLOBALS['null_value']; 
        $received_person_contact_number = $GLOBALS['null_value']; $received_person_identification = $GLOBALS['null_value'];

        $valid_lr = ""; $form_name = "lr_form";

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }

        $lr_date = $_POST['lr_date'];
        $lr_date = trim($lr_date);
        if(!empty($lr_date)) {
            $lr_date = date("d-m-Y", strtotime($lr_date));
        }
        $lr_date_error = $valid->valid_date($lr_date, "LR date", "1");
        if(empty($lr_date_error)) {
            if( (strtotime($lr_date) >= strtotime($lr_date_from)) && (strtotime($lr_date) <= strtotime($current_date)) ) {
                $lr_date = date("Y-m-d", strtotime($lr_date));
            }
            else {
                $lr_date_error = "Invalid LR date";
            }
        }
        if(!empty($lr_date_error)) {
            $valid_lr = $valid->error_display($form_name, "lr_date", $lr_date_error, 'text');			
        }

        $organization_id = $_POST['organization_id'];
        $organization_id = trim($organization_id);
        if(!empty($organization_id)) {
            $organization_unique_id = "";
            $organization_unique_id = $obj->getTableColumnValue($GLOBALS['organization_table'], 'organization_id', $organization_id, 'id');
            if(preg_match("/^\d+$/", $organization_unique_id)) {
                $organization_details = $obj->getTableColumnValue($GLOBALS['organization_table'], 'id', $organization_unique_id, 'organization_details');
            }
            else {
                $organization_id_error = "Invalid organization";
            }
        }
        else {
            $organization_id_error = "Select the organization";
        }
        if(!empty($organization_id_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "organization_id", $organization_id_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "organization_id", $organization_id_error, 'select');
            }
        }

        $consignor_name = $_POST['consignor_name'];
        $consignor_name = trim($consignor_name);
        $consignor_name_error = $valid->common_validation($consignor_name, "consignor name", "text");
        if(!empty($consignor_name_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_name", $consignor_name_error, 'text');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignor_name", $consignor_name_error, 'text');
            }
        }

        $consignor_mobile_number = $_POST['consignor_mobile_number'];
        $consignor_mobile_number = trim($consignor_mobile_number);
        $consignor_mobile_number_error = $valid->valid_mobile_number($consignor_mobile_number, "consignor mobile number", "1");
        if(!empty($consignor_mobile_number_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_mobile_number", $consignor_mobile_number_error, 'text');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignor_mobile_number", $consignor_mobile_number_error, 'text');
            }
        }

        $consignor_state = $_POST['consignor_state'];
        $consignor_state = trim($consignor_state);
        $consignor_state_error = $valid->common_validation($consignor_state, "consignor state", "text");
        if(!empty($consignor_state_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_state", $consignor_state_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignor_state", $consignor_state_error, 'select');
            }
        }

        if(isset($_POST['consignor_district'])) {
            $consignor_district = $_POST['consignor_district'];
            $consignor_district = trim($consignor_district);
        }
        if(!empty($consignor_district)) {
            $consignor_district_error = $valid->common_validation($consignor_district, "consignor district", "text");
        }
        if(!empty($consignor_district_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_district", $consignor_district_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignor_district", $consignor_district_error, 'select');
            }
        }

        if(isset($_POST['consignor_city'])) {
            $consignor_city = $_POST['consignor_city'];
            $consignor_city = trim($consignor_city);
        }
        if(!empty($consignor_city)) {
            if($consignor_city == "Others") {
                if(isset($_POST['consignor_others_city'])) {
                    $consignor_others_city = $_POST['consignor_others_city'];
                    $consignor_others_city = trim($consignor_others_city);
                }
                $consignor_city_error = $valid->common_validation($consignor_others_city, "consignor others city", "text");
                if(!empty($consignor_city_error)) {
                    if(!empty($valid_lr)) {
                        $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_others_city", $consignor_city_error, 'text');
                    }
                    else {
                        $valid_lr = $valid->error_display($form_name, "consignor_others_city", $consignor_city_error, 'text');
                    }
                }
                else {
                    $consignor_city = $consignor_others_city;
                }
            }
            else {
                $consignor_city_error = $valid->common_validation($consignor_city, "consignor city", "text");
                if(!empty($consignor_city_error)) {
                    if(!empty($valid_lr)) {
                        $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignor_city", $consignor_city_error, 'select');
                    }
                    else {
                        $valid_lr = $valid->error_display($form_name, "consignor_city", $consignor_city_error, 'select');
                    }
                }
            }
        }

        $consignee_name = $_POST['consignee_name'];
        $consignee_name = trim($consignee_name);
        $consignee_name_error = $valid->common_validation($consignee_name, "consignee name", "text");
        if(!empty($consignee_name_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_name", $consignee_name_error, 'text');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignee_name", $consignee_name_error, 'text');
            }
        }

        $consignee_mobile_number = $_POST['consignee_mobile_number'];
        $consignee_mobile_number = trim($consignee_mobile_number);
        $consignee_mobile_number_error = $valid->valid_mobile_number($consignee_mobile_number, "consignee mobile number", "1");
        if(!empty($consignee_mobile_number_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_mobile_number", $consignee_mobile_number_error, 'text');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignee_mobile_number", $consignee_mobile_number_error, 'text');
            }
        }

        $consignee_state = $_POST['consignee_state'];
        $consignee_state = trim($consignee_state);
        $consignee_state_error = $valid->common_validation($consignee_state, "consignee state", "text");
        if(!empty($consignee_state_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_state", $consignee_state_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignee_state", $consignee_state_error, 'select');
            }
        }

        if(isset($_POST['consignee_district'])) {
            $consignee_district = $_POST['consignee_district'];
            $consignee_district = trim($consignee_district);
        }
        if(!empty($consignee_district)) {
            $consignee_district_error = $valid->common_validation($consignee_district, "consignee district", "text");
        }
        if(!empty($consignee_district_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_district", $consignee_district_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "consignee_district", $consignee_district_error, 'select');
            }
        }

        if(isset($_POST['consignee_city'])) {
            $consignee_city = $_POST['consignee_city'];
            $consignee_city = trim($consignee_city);
        }
        if(!empty($consignee_city)) {
            if($consignee_city == "Others") {
                if(isset($_POST['consignee_others_city'])) {
                    $consignee_others_city = $_POST['consignee_others_city'];
                    $consignee_others_city = trim($consignee_others_city);
                }
                $consignee_city_error = $valid->common_validation($consignee_others_city, "consignee others city", "text");
                if(!empty($consignee_city_error)) {
                    if(!empty($valid_lr)) {
                        $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_others_city", $consignee_city_error, 'text');
                    }
                    else {
                        $valid_lr = $valid->error_display($form_name, "consignee_others_city", $consignee_city_error, 'text');
                    }
                }
                else {
                    $consignee_city = $consignee_others_city;
                }
            }
            else {
                $consignee_city_error = $valid->common_validation($consignee_city, "consignee city", "text");
                if(!empty($consignee_city_error)) {
                    if(!empty($valid_lr)) {
                        $valid_lr = $valid_lr." ".$valid->error_display($form_name, "consignee_city", $consignee_city_error, 'select');
                    }
                    else {
                        $valid_lr = $valid->error_display($form_name, "consignee_city", $consignee_city_error, 'select');
                    }
                }
            }
        }

        if(isset($_POST['account_party_mobile_number'])) {
            $account_party_mobile_number = $_POST['account_party_mobile_number'];
            $account_party_mobile_number = trim($account_party_mobile_number);
        }
        if(!empty($account_party_mobile_number)) {
            $account_party_mobile_number_error = $valid->valid_mobile_number($account_party_mobile_number, "account_party mobile number", "1");
        }
        if(!empty($account_party_mobile_number_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_mobile_number", $account_party_mobile_number_error, 'text');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "account_party_mobile_number", $account_party_mobile_number_error, 'text');
            }
        }

        if(!empty($account_party_mobile_number)) {

            if(isset($_POST['account_party_name'])) {
                $account_party_name = $_POST['account_party_name'];
                $account_party_name = trim($account_party_name);
            }
            if(!empty($account_party_name)) {
                $account_party_name_error = $valid->common_validation($account_party_name, "account_party name", "text");
            }
            if(!empty($account_party_name_error)) {
                if(!empty($valid_lr)) {
                    $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_name", $account_party_name_error, 'text');
                }
                else {
                    $valid_lr = $valid->error_display($form_name, "account_party_name", $account_party_name_error, 'text');
                }
            }

            if(isset($_POST['account_party_state'])) {
                $account_party_state = $_POST['account_party_state'];
                $account_party_state = trim($account_party_state);
            }
            $account_party_state_error = $valid->common_validation($account_party_state, "account_party state", "text");
            if(!empty($account_party_state_error)) {
                if(!empty($valid_lr)) {
                    $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_state", $account_party_state_error, 'select');
                }
                else {
                    $valid_lr = $valid->error_display($form_name, "account_party_state", $account_party_state_error, 'select');
                }
            }

            if(isset($_POST['account_party_district'])) {
                $account_party_district = $_POST['account_party_district'];
                $account_party_district = trim($account_party_district);
            }
            if(!empty($account_party_district)) {
                $account_party_district_error = $valid->common_validation($account_party_district, "account_party district", "text");
            }
            if(!empty($account_party_district_error)) {
                if(!empty($valid_lr)) {
                    $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_district", $account_party_district_error, 'select');
                }
                else {
                    $valid_lr = $valid->error_display($form_name, "account_party_district", $account_party_district_error, 'select');
                }
            }

            if(isset($_POST['account_party_city'])) {
                $account_party_city = $_POST['account_party_city'];
                $account_party_city = trim($account_party_city);
            }
            if(!empty($account_party_city)) {
                if($account_party_city == "Others") {
                    if(isset($_POST['account_party_others_city'])) {
                        $account_party_others_city = $_POST['account_party_others_city'];
                        $account_party_others_city = trim($account_party_others_city);
                    }
                    $account_party_city_error = $valid->common_validation($account_party_others_city, "account_party others city", "text");
                    if(!empty($account_party_city_error)) {
                        if(!empty($valid_lr)) {
                            $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_others_city", $account_party_city_error, 'text');
                        }
                        else {
                            $valid_lr = $valid->error_display($form_name, "account_party_others_city", $account_party_city_error, 'text');
                        }
                    }
                    else {
                        $account_party_city = $account_party_others_city;
                    }
                }
                else {
                    $account_party_city_error = $valid->common_validation($account_party_city, "account_party city", "text");
                    if(!empty($account_party_city_error)) {
                        if(!empty($valid_lr)) {
                            $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_city", $account_party_city_error, 'select');
                        }
                        else {
                            $valid_lr = $valid->error_display($form_name, "account_party_city", $account_party_city_error, 'select');
                        }
                    }
                }
            }
            if(!empty($account_party_city_error)) {
                if(!empty($valid_lr)) {
                    $valid_lr = $valid_lr." ".$valid->error_display($form_name, "account_party_city", $account_party_city_error, 'select');
                }
                else {
                    $valid_lr = $valid->error_display($form_name, "account_party_city", $account_party_city_error, 'select');
                }
            }
        }  
        
        $from_branch_id = $_POST['from_branch_id'];
        $from_branch_id = trim($from_branch_id);
        if(!empty($from_branch_id)) {
            $branch_unique_id = "";
            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $from_branch_id, 'id');
            if(preg_match("/^\d+$/", $branch_unique_id)) {
                $from_branch_details = $obj->getTableColumnValue($GLOBALS['branch_table'], 'id', $branch_unique_id, 'prefix_name_mobile');
            }
            else {
                $from_branch_id_error = "Invalid branch";
            }
        }
        else {
            $from_branch_id_error = "Select the branch";
        }
        if(!empty($from_branch_id_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "from_branch_id", $from_branch_id_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "from_branch_id", $from_branch_id_error, 'select');
            }
        }

        $to_branch_id = $_POST['to_branch_id'];
        $to_branch_id = trim($to_branch_id);
        if(!empty($to_branch_id)) {
            $branch_unique_id = "";
            $branch_unique_id = $obj->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $to_branch_id, 'id');
            if(preg_match("/^\d+$/", $branch_unique_id)) {
                $to_branch_details = $obj->getTableColumnValue($GLOBALS['branch_table'], 'id', $branch_unique_id, 'prefix_name_mobile');
            }
            else {
                $to_branch_id_error = "Invalid branch";
            }
        }
        else {
            $to_branch_id_error = "Select the branch";
        }
        if(!empty($to_branch_id_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "to_branch_id", $to_branch_id_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "to_branch_id", $to_branch_id_error, 'select');
            }
        }

        $bill_type = $_POST['bill_type'];
        $bill_type = trim($bill_type);
        if(!empty($bill_type)) {
            $bill_type_list = $GLOBALS['bill_type_options'];
            $check_bill_type = $obj->encode_decode('decrypt', $bill_type);
            if(!in_array($check_bill_type, $bill_type_list)) {
                $bill_type_error = "Invalid bill type";
            }
        }
        else {
            $bill_type_error = "Select the bill type";
        }
        if(!empty($to_branch_id_error)) {
            if(!empty($valid_lr)) {
                $valid_lr = $valid_lr." ".$valid->error_display($form_name, "bill_type", $bill_type_error, 'select');
            }
            else {
                $valid_lr = $valid->error_display($form_name, "bill_type", $bill_type_error, 'select');
            }
        }

        if(isset($_POST['gst_option'])) {
            $gst_option = $_POST['gst_option'];
            $gst_option = trim($gst_option);
        }
        $gst = "";
        if(!empty($gst_option) && $gst_option == 1) {
            if(isset($_POST['tax_value'])) {
                $tax_value = $_POST['tax_value'];
                $tax_value = trim($tax_value);
            }
            if(!empty($tax_value)) {
                $tax_value_list = $GLOBALS['tax_value_options'];
                if(in_array($tax_value, $tax_value_list)) {
                    $gst = str_replace("%", "", $tax_value);
                    $gst = trim($gst);
                }
                else {
                    $tax_value_error = "Invalid tax";
                }
            }
            else {
                $tax_value_error = "Select the tax";
            }
            if(!empty($tax_value_error)) {
                if(!empty($valid_lr)) {
                    $valid_lr = $valid_lr." ".$valid->error_display($form_name, "tax_value", $tax_value_error, 'select');
                }
                else {
                    $valid_lr = $valid->error_display($form_name, "tax_value", $tax_value_error, 'select');
                }
            }
        }
        else {
            $gst_option = 0; $tax_value= "0%";
        }

        if(isset($_POST['unit_id'])) {
            $unit_id_values = $_POST['unit_id'];
        }
        if(isset($_POST['quantity'])) {
            $quantity_values = $_POST['quantity'];
        }
        if(isset($_POST['weight'])) {
            $weight_values = $_POST['weight'];
        }
        if(isset($_POST['rate'])) {
            $rate_values = $_POST['rate'];
        }
        if(isset($_POST['kooli'])) {
            $kooli_values = $_POST['kooli'];
        }

        $lr_row_selected = 0; $lr_error = "";
        if(!empty($unit_id_values)) {
            for($i = 0; $i < count($unit_id_values); $i++) {
                $unit_id_values[$i] = trim($unit_id_values[$i]);
                if(!empty($unit_id_values[$i])) {
                    $unit_unique_id = "";
                    $unit_unique_id = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_id_values[$i], 'id');
                    if(preg_match("/^\d+$/", $unit_unique_id)) {
                        $unit_name_values[$i] = $obj->getTableColumnValue($GLOBALS['unit_table'], 'id', $unit_unique_id, 'unit_name');

                        $goods_value = 0; $quantity_error = ""; $weight_error = "";

                        $quantity_values[$i] = trim($quantity_values[$i]);
                        if(!empty($quantity_values[$i])) {
                            if(preg_match("/^\d+$/", $quantity_values[$i])) {
                                if(strlen($quantity_values[$i]) <= 4) {
                                    $goods_value = $quantity_values[$i];
                                    $total_quantity = $total_quantity + $quantity_values[$i];
                                }
                                else {
                                    $quantity_error = "Invalid Quantity. Max(9999)";
                                }
                            }
                            else {
                                $quantity_error = "Invalid Quantity";
                            }
                        }
                        else {
                            $quantity_values[$i] = 0;
                        }

                        if(empty($quantity_error)) {
                            if(!empty($weight_values[$i])) {
                                if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $weight_values[$i])) {
                                    $length_error = "";
                                    if (strpos($weight_values[$i], '.') !== false) {
                                        $number_point_value = "";
                                        $number_point_value = explode(".", $weight_values[$i]);
                                        if(!empty($number_point_value)) {
                                            if(strlen($number_point_value['0']) > 5 || strlen($number_point_value['1']) > 2) {
                                                $length_error = "Invalid Weight. Format(99999.99)";
                                            }
                                        }
                                    }
                                    else if(strlen($weight_values[$i]) > 5){
                                        $length_error = "Invalid Weight. Format(99999.99)";
                                    }
                                    if(empty($length_error)) {
                                        $total_weight = $total_weight + $weight_values[$i];
                                        $goods_value = $weight_values[$i];
                                    }
                                    else {
                                        $weight_error = $length_error;
                                    }
                                }
                                else {
                                    $weight_error = "Invalid Weight";
                                }
                            }
                            else {
                                $weight_values[$i] = 0;
                            }

                            if(empty($weight_error)) {
                                if(!empty($goods_value)) {
                                    $rate_values[$i] = trim($rate_values[$i]);
                                    if(!empty($rate_values[$i])) {
                                        if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $rate_values[$i])) {

                                            $length_error = "";
                                            if (strpos($rate_values[$i], '.') !== false) {
                                                $number_point_value = "";
                                                $number_point_value = explode(".", $rate_values[$i]);
                                                if(!empty($number_point_value)) {
                                                    if(strlen($number_point_value['0']) > 5 || strlen($number_point_value['1']) > 2) {
                                                        $length_error = "Invalid Rate. Format(99999.99)";
                                                    }
                                                }
                                            }
                                            else if(strlen($rate_values[$i]) > 5){
                                                $length_error = "Invalid Rate. Max(99999.99)";
                                            }
                                            if(empty($length_error)) {
                                                $freight_values[$i] = $goods_value * $rate_values[$i];
                                                if(!empty($freight_values[$i])) {
                                                    $freight_values[$i] = number_format($freight_values[$i], 2);
                                                    $freight_values[$i] = str_replace(",", "", $freight_values[$i]);
                                                }
                                                $kooli_values[$i] = trim($kooli_values[$i]);
                                                if(!empty($kooli_values[$i])) {
                                                    if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $kooli_values[$i])) {
                                                        $kooli_by_quantity_values[$i] = $goods_value * $kooli_values[$i];
                                                        if(!empty($kooli_by_quantity_values[$i])) {
                                                            $kooli_by_quantity_values[$i] = number_format($kooli_by_quantity_values[$i], 2);
                                                            $kooli_by_quantity_values[$i] = str_replace(",", "", $kooli_by_quantity_values[$i]);
                                                        } 
                                                    }
                                                    else {
                                                        $lr_error = "Invalid Kooli";
                                                    }
                                                }
                                                else {
                                                    $kooli_values[$i] = 0;
                                                    $kooli_by_quantity_values[$i] = 0;
                                                }
                                                $amount_values[$i] = $freight_values[$i] + $kooli_by_quantity_values[$i];
                                                $total_amount = $total_amount + $amount_values[$i];
                                                $lr_row_selected = 1;
                                            }
                                            else {
                                                $lr_error = $length_error;
                                            }

                                        }
                                        else {
                                            $lr_error = "Invalid Rate";
                                        }
                                    }   
                                    else {
                                        $lr_error = "Empty Rate";
                                    }                                 
                                }
                            }
                            else {
                                $lr_error = $weight_error;
                            }
                        }
                        else {
                            $lr_error = $quantity_error;
                        }

                    }
                    else {
                        $lr_error = "Invalid Unit";
                    }
                }
                else {
                    $lr_error = "Empty Unit";
                }
            }
        }

        if(empty($lr_row_selected) && empty($lr_error)) {
            $lr_error = "Add LR Unit Rows";
        }

        if(!empty($total_amount)) {
            $sub_total = $total_amount;
        }
        //echo "total_amount - ".$total_amount."<br>";
        
        if(isset($_POST['delivery_charges'])) {
            $delivery_charges = $_POST['delivery_charges'];
            $delivery_charges = trim($delivery_charges);
            if(!empty($delivery_charges)) {
                $delivery_charges_error = $valid->valid_percentage($delivery_charges, "delivery charges", "1");
                if(empty($delivery_charges_error)) {
                    if (strpos($delivery_charges, '%') !== false) {
                        $check_delivery_charges = str_replace("%", "", $delivery_charges);
                        if($check_delivery_charges > 99) {
                            $delivery_charges_error = "Delivery Charges Max.99%";
                        }
                    }    
                }
                if(!empty($delivery_charges_error)) {
                    if(!empty($valid_lr)) {
                        $valid_lr = $valid_lr." ".$valid->error_display($form_name, "delivery_charges", $delivery_charges_error, 'text');
                    }
                    else {
                        $valid_lr = $valid->error_display($form_name, "delivery_charges", $delivery_charges_error, 'text');
                    }
                }
                else { 
                    if (strpos($delivery_charges, '%') !== false) {
                        $check_delivery_charges = str_replace("%", "", $delivery_charges);
                        $delivery_charges_value = (($total_amount * $check_delivery_charges) / 100);
                        if(!empty($delivery_charges_value)) {
                            $delivery_charges_value = number_format($delivery_charges_value, 2);
                            $delivery_charges_value = str_replace(",", "", $delivery_charges_value);
                        }
                    }
                    else {
                        $delivery_charges_value = $delivery_charges;
                    }
                    if(!empty($delivery_charges_value)) {
                        $total_amount = $total_amount + $delivery_charges_value;
                        $total_amount = number_format($total_amount, 2);
                        $total_amount = str_replace(",", "", $total_amount);
                    }
                }
            }
        }
        if(empty($delivery_charges)) { $delivery_charges = 0; }

        //echo "delivery_charges - ".$delivery_charges.", delivery_charges_value - ".$delivery_charges_value.", total_amount - ".$total_amount."<br>";

        if(isset($_POST['loading_charges'])) {
            $loading_charges = $_POST['loading_charges'];
            $loading_charges = trim($loading_charges);
            if(!empty($loading_charges)) {
                $loading_charges_error = $valid->valid_percentage($loading_charges, "loading charges", "1");
                if(empty($loading_charges_error)) {
                    if (strpos($loading_charges, '%') !== false) {
                        $check_loading_charges = str_replace("%", "", $loading_charges);
                        if($check_loading_charges > 99) {
                            $loading_charges_error = "Loading Charges Max.99%";
                        }
                    }    
                }
                if(!empty($loading_charges_error)) {
                    if(!empty($valid_invoice)) {
                        $valid_invoice = $valid_invoice." ".$valid->error_display($form_name, "loading_charges", $loading_charges_error, 'text');
                    }
                    else {
                        $valid_invoice = $valid->error_display($form_name, "loading_charges", $loading_charges_error, 'text');
                    }
                }
                else { 
                    if (strpos($loading_charges, '%') !== false) {
                        $check_loading_charges = str_replace("%", "", $loading_charges);
                        $loading_charges_value = (($total_amount * $check_loading_charges) / 100);
                        if(!empty($loading_charges_value)) {
                            $loading_charges_value = number_format($loading_charges_value, 2);
                            $loading_charges_value = str_replace(",", "", $loading_charges_value);
                        }
                    }
                    else {
                        $loading_charges_value = $loading_charges;
                    }
                    if(!empty($loading_charges_value)) {
                        $total_amount = $total_amount + $loading_charges_value;
                        $total_amount = number_format($total_amount, 2);
                        $total_amount = str_replace(",", "", $total_amount);
                    }
                }
            }
        }
        if(empty($loading_charges)) { $loading_charges = 0; }

        //echo "loading_charges - ".$loading_charges.", loading_charges_value - ".$loading_charges_value.", total_amount - ".$total_amount."<br>";

        if(!empty($gst)) {
            $gst_value = "";
            $gst_value = (($total_amount * $gst) / 100);
            if(!empty($gst_value)) {
                $gst_value = number_format($gst_value, 2);
                $gst_value = str_replace(",", "", $gst_value);

                $total_amount = $total_amount + $gst_value;
                $total_amount = number_format($total_amount, 2);
                $total_amount = str_replace(",", "", $total_amount);
            }
            if(!empty($consignee_state) && !empty($consignee_state)) {
                if($consignee_state == $consignee_state) {
                    $gst_value = $gst_value / 2;
                    $gst_value = number_format($gst_value, 2);
                    $gst_value = str_replace(",", "", $gst_value);
                    $cgst = $gst_value; $sgst = $gst_value; $igst = 0;
                }
                else {
                    $cgst = 0; $sgst = 0; $igst = $gst_value;
                }
            }
        }

        //echo "gst - ".$gst.", gst_value - ".$gst_value.", cgst - ".$cgst.", sgst - ".$sgst.", igst - ".$igst.", total_amount - ".$total_amount."<br>";

        $round_off = 0;
        if(!empty($total_amount)) {
            if (strpos( $total_amount, "." ) !== false) {
                $pos = strpos($total_amount, ".");
                $decimal = substr($total_amount, ($pos + 1), strlen($total_amount));
                if($decimal != "00") {
                    if(strlen($decimal) == 1) {
                        $decimal = $decimal."0";
                    }
                    if($decimal >= 50) {
                        $round_off = 100 - $decimal;
                        if(strlen($round_off) < 2) {
                            $round_off = '0.0'.$round_off;
                        }
                        else {
                            $round_off = '0.'.$round_off;
                        }
                        $total_amount = $total_amount + $round_off;
                    }
                    else {
                        $round_off = $decimal;
                        if(strlen($round_off) < 2) {
                            $round_off = '0.0'.$round_off;
                        }
                        else {
                            $round_off = '0.'.$round_off;
                        }
                        $total_amount = $total_amount - $round_off;
                        $round_off = "-".$round_off;
                    }                                       
                }
            }
        }
        //echo "round_off - ".$round_off.", total_amount - ".$total_amount."<br>"; exit;

        $result = "";
        
        if(empty($valid_lr) && empty($lr_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                $consignor_id = ""; $consignor_name_mobile_city = ""; $consignor_details = "";
                if(!empty($consignor_mobile_number)) {
                    $check_consignor_mobile_number = "";
                    $check_consignor_mobile_number = $obj->encode_decode('encrypt', $consignor_mobile_number);

                    $consignor_unique_id = ""; $consignor_address = ""; $consignor_identification = "";
                    $consignor_unique_id = $obj->getTableColumnValue($GLOBALS['consignor_table'], 'mobile_number', $check_consignor_mobile_number, 'id');
                    if(preg_match("/^\d+$/", $consignor_unique_id)) {
                        $consignor_address = $obj->getTableColumnValue($GLOBALS['consignor_table'], 'id', $consignor_unique_id, 'address');
                        if(!empty($consignor_address) && $consignor_address != $GLOBALS['null_value']) {
                            $consignor_address = $obj->encode_decode('decrypt', $consignor_address);
                        }

                        $consignor_identification = $obj->getTableColumnValue($GLOBALS['consignor_table'], 'id', $consignor_unique_id, 'identification');
                        if(!empty($consignor_identification) && $consignor_identification != $GLOBALS['null_value']) {
                            $consignor_identification = $obj->encode_decode('decrypt', $consignor_identification);
                        }
                    }
                    
                    if(!empty($consignor_name)) {
                        $consignor_name_mobile_city = $consignor_name;
                        $consignor_details = $consignor_name;
                        $consignor_name = $obj->encode_decode('encrypt', $consignor_name);
                    }
                    if(!empty($consignor_address)) {
                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details."<br>".str_replace("\r\n", "<br>", $consignor_address);
                        }
                        $consignor_address = $obj->encode_decode('encrypt', $consignor_address);
                    }
                    else {
                        $consignor_address = $GLOBALS['null_value'];
                    }
                    if(!empty($consignor_city)) {
                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details."<br>".$consignor_city;
                        }
                    }
                    if(!empty($consignor_district)) {
                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details.", ".$consignor_district;
                        }
                        $consignor_district = $obj->encode_decode('encrypt', $consignor_district);
                    }
                    if(!empty($consignor_state)) {
                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details.", ".$consignor_state;
                        }
                        $consignor_state = $obj->encode_decode('encrypt', $consignor_state);
                    }
                    if(!empty($consignor_mobile_number)) {
                        $consignor_mobile_number = str_replace(" ", "", $consignor_mobile_number);

                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details."<br> Mobile : ".$consignor_mobile_number;
                        }
                        if(!empty($consignor_name_mobile_city)) {
                            $consignor_name_mobile_city = $consignor_name_mobile_city." (".$consignor_mobile_number.")";
                            if(!empty($consignor_city)) {
                                $consignor_name_mobile_city = $consignor_name_mobile_city." - ".$consignor_city;
                            }
                            $consignor_name_mobile_city = $obj->encode_decode('encrypt', $consignor_name_mobile_city);
                        }

                        $consignor_mobile_number = $obj->encode_decode('encrypt', $consignor_mobile_number);
                    }
                    if(!empty($consignor_identification)) {
                        if(!empty($consignor_details)) {
                            $consignor_details = $consignor_details."<br>".$consignor_identification;
                        }
                        $consignor_identification = $obj->encode_decode('encrypt', $consignor_identification);
                    }
                    else {
                        $consignor_identification = $GLOBALS['null_value'];
                    }

                    if(!empty($consignor_city)) {
                        $consignor_city = $obj->encode_decode('encrypt', $consignor_city);
                    }
                    if(!empty($consignor_details)) {
                        $consignor_details = $obj->encode_decode('encrypt', $consignor_details);
                    }

                    if(preg_match("/^\d+$/", $consignor_unique_id)) {
                        $action = "";
                        if(!empty($consignor_name_mobile_city)) {
                            $action = "Consignor Updated. Details - ".$obj->encode_decode('decrypt', $consignor_name_mobile_city);
                        }
                    
                        $columns = array(); $values = array(); $update_id = "";				
                        $columns = array('creator_name', 'name', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'consignor_details');
                        $values = array("'".$creator_name."'", "'".$consignor_name."'", "'".$consignor_name_mobile_city."'", "'".$consignor_identification."'", "'".$consignor_address."'", "'".$consignor_state."'", "'".$consignor_district."'", "'".$consignor_city."'", "'".$consignor_details."'");
                        $update_id = $obj->UpdateSQL($GLOBALS['consignor_table'], $consignor_unique_id, $columns, $values, $action);
                        if(preg_match("/^\d+$/", $update_id)) {
                            $consignor_id = $obj->getTableColumnValue($GLOBALS['consignor_table'], 'id', $consignor_unique_id, 'consignor_id');						
                        }
                    }
                    else {
                        $action = "";
                        if(!empty($consignor_name_mobile_city)) {
                            $action = "New Consignor Created. Details - ".$obj->encode_decode('decrypt', $consignor_name_mobile_city);
                        }
                        $null_value = $GLOBALS['null_value']; $insert_id = "";
                        $columns = array('created_date_time', 'creator', 'creator_name', 'consignor_id', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'consignor_details', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$consignor_name."'", "'".$consignor_mobile_number."'", "'".$consignor_name_mobile_city."'", "'".$consignor_identification."'", "'".$consignor_address."'", "'".$consignor_state."'", "'".$consignor_district."'", "'".$consignor_city."'", "'".$consignor_details."'", "'0'");
                        $insert_id = $obj->InsertSQL($GLOBALS['consignor_table'], $columns, $values, 'consignor_id', '', $action);
                        if(preg_match("/^\d+$/", $insert_id)) {
                            $consignor_id = $obj->getTableColumnValue($GLOBALS['consignor_table'], 'id', $insert_id, 'consignor_id');					
                        }
                    }
                }

                if(!empty($consignor_id)) {

                    $consignee_id = ""; $consignee_name_mobile_city = ""; $consignee_details = "";
                    if(!empty($consignee_mobile_number)) {
                        $check_consignee_mobile_number = "";
                        $check_consignee_mobile_number = $obj->encode_decode('encrypt', $consignee_mobile_number);

                        $consignee_unique_id = ""; $consignee_address = ""; $consignee_identification = "";
                        $consignee_unique_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'mobile_number', $check_consignee_mobile_number, 'id');
                        if(preg_match("/^\d+$/", $consignee_unique_id)) {
                            $consignee_address = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'id', $consignee_unique_id, 'address');
                            if(!empty($consignee_address) && $consignee_address != $GLOBALS['null_value']) {
                                $consignee_address = $obj->encode_decode('decrypt', $consignee_address);
                            }

                            $consignee_identification = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'id', $consignee_unique_id, 'identification');
                            if(!empty($consignee_identification) && $consignee_identification != $GLOBALS['null_value']) {
                                $consignee_identification = $obj->encode_decode('decrypt', $consignee_identification);
                            }
                        }
                        
                        if(!empty($consignee_name)) {
                            $consignee_name_mobile_city = $consignee_name;
                            $consignee_details = $consignee_name;
                            $consignee_name = $obj->encode_decode('encrypt', $consignee_name);
                        }
                        if(!empty($consignee_address)) {
                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details."<br>".str_replace("\r\n", "<br>", $consignee_address);
                            }
                            $consignee_address = $obj->encode_decode('encrypt', $consignee_address);
                        }
                        else {
                            $consignee_address = $GLOBALS['null_value'];
                        }
                        if(!empty($consignee_city)) {
                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details."<br>".$consignee_city;
                            }
                        }
                        if(!empty($consignee_district)) {
                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details.", ".$consignee_district;
                            }
                            $consignee_district = $obj->encode_decode('encrypt', $consignee_district);
                        }
                        if(!empty($consignee_state)) {
                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details.", ".$consignee_state;
                            }
                            $consignee_state = $obj->encode_decode('encrypt', $consignee_state);
                        }
                        if(!empty($consignee_mobile_number)) {
                            $consignee_mobile_number = str_replace(" ", "", $consignee_mobile_number);

                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details."<br> Mobile : ".$consignee_mobile_number;
                            }
                            if(!empty($consignee_name_mobile_city)) {
                                $consignee_name_mobile_city = $consignee_name_mobile_city." (".$consignee_mobile_number.")";
                                if(!empty($consignee_city)) {
                                    $consignee_name_mobile_city = $consignee_name_mobile_city." - ".$consignee_city;
                                }
                                $consignee_name_mobile_city = $obj->encode_decode('encrypt', $consignee_name_mobile_city);
                            }

                            $consignee_mobile_number = $obj->encode_decode('encrypt', $consignee_mobile_number);
                        }
                        if(!empty($consignee_identification)) {
                            if(!empty($consignee_details)) {
                                $consignee_details = $consignee_details."<br>".$consignee_identification;
                            }
                            $consignee_identification = $obj->encode_decode('encrypt', $consignee_identification);
                        }
                        else {
                            $consignee_identification = $GLOBALS['null_value'];
                        }

                        if(!empty($consignee_city)) {
                            $consignee_city = $obj->encode_decode('encrypt', $consignee_city);
                        }
                        if(!empty($consignee_details)) {
                            $consignee_details = $obj->encode_decode('encrypt', $consignee_details);
                        }

                        if(preg_match("/^\d+$/", $consignee_unique_id)) {
                            $action = "";
                            if(!empty($consignee_name_mobile_city)) {
                                $action = "consignee Updated. Details - ".$obj->encode_decode('decrypt', $consignee_name_mobile_city);
                            }
                        
                            $columns = array(); $values = array(); $update_id = "";				
                            $columns = array('creator_name', 'name', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'consignee_details');
                            $values = array("'".$creator_name."'", "'".$consignee_name."'", "'".$consignee_name_mobile_city."'", "'".$consignee_identification."'", "'".$consignee_address."'", "'".$consignee_state."'", "'".$consignee_district."'", "'".$consignee_city."'", "'".$consignee_details."'");
                            $update_id = $obj->UpdateSQL($GLOBALS['consignee_table'], $consignee_unique_id, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $update_id)) {
                                $consignee_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'id', $consignee_unique_id, 'consignee_id');						
                            }
                        }
                        else {
                            $action = "";
                            if(!empty($consignee_name_mobile_city)) {
                                $action = "New consignee Created. Details - ".$obj->encode_decode('decrypt', $consignee_name_mobile_city);
                            }
                            $null_value = $GLOBALS['null_value']; $insert_id = "";
                            $columns = array('created_date_time', 'creator', 'creator_name', 'consignee_id', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'consignee_details', 'deleted');
                            $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$consignee_name."'", "'".$consignee_mobile_number."'", "'".$consignee_name_mobile_city."'", "'".$consignee_identification."'", "'".$consignee_address."'", "'".$consignee_state."'", "'".$consignee_district."'", "'".$consignee_city."'", "'".$consignee_details."'", "'0'");
                            $insert_id = $obj->InsertSQL($GLOBALS['consignee_table'], $columns, $values, 'consignee_id', '', $action);
                            if(preg_match("/^\d+$/", $insert_id)) {
                                $consignee_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'id', $insert_id, 'consignee_id');					
                            }
                        }
                    }

                    if(!empty($consignee_id)) {

                        $account_party_id = ""; $account_party_name_mobile_city = ""; $account_party_details = "";
                        if(!empty($account_party_mobile_number)) {
                            $check_account_party_mobile_number = "";
                            $check_account_party_mobile_number = $obj->encode_decode('encrypt', $account_party_mobile_number);

                            $account_party_unique_id = ""; $account_party_address = ""; $account_party_identification = "";
                            $account_party_unique_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'mobile_number', $check_account_party_mobile_number, 'id');
                            if(preg_match("/^\d+$/", $account_party_unique_id)) {
                                $account_party_address = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'id', $account_party_unique_id, 'address');
                                if(!empty($account_party_address) && $account_party_address != $GLOBALS['null_value']) {
                                    $account_party_address = $obj->encode_decode('decrypt', $account_party_address);
                                }

                                $account_party_identification = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'id', $account_party_unique_id, 'identification');
                                if(!empty($account_party_identification) && $account_party_identification != $GLOBALS['null_value']) {
                                    $account_party_identification = $obj->encode_decode('decrypt', $account_party_identification);
                                }
                            }
                            
                            if(!empty($account_party_name)) {
                                $account_party_name_mobile_city = $account_party_name;
                                $account_party_details = $account_party_name;
                                $account_party_name = $obj->encode_decode('encrypt', $account_party_name);
                            }
                            if(!empty($account_party_address)) {
                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details."<br>".str_replace("\r\n", "<br>", $account_party_address);
                                }
                                $account_party_address = $obj->encode_decode('encrypt', $account_party_address);
                            }
                            else {
                                $account_party_address = $GLOBALS['null_value'];
                            }
                            if(!empty($account_party_city)) {
                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details."<br>".$account_party_city;
                                }
                            }
                            if(!empty($account_party_district)) {
                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details.", ".$account_party_district;
                                }
                                $account_party_district = $obj->encode_decode('encrypt', $account_party_district);
                            }
                            if(!empty($account_party_state)) {
                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details.", ".$account_party_state;
                                }
                                $account_party_state = $obj->encode_decode('encrypt', $account_party_state);
                            }
                            if(!empty($account_party_mobile_number)) {
                                $account_party_mobile_number = str_replace(" ", "", $account_party_mobile_number);

                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details."<br> Mobile : ".$account_party_mobile_number;
                                }
                                if(!empty($account_party_name_mobile_city)) {
                                    $account_party_name_mobile_city = $account_party_name_mobile_city." (".$account_party_mobile_number.")";
                                    if(!empty($account_party_city)) {
                                        $account_party_name_mobile_city = $account_party_name_mobile_city." - ".$account_party_city;
                                    }
                                    $account_party_name_mobile_city = $obj->encode_decode('encrypt', $account_party_name_mobile_city);
                                }

                                $account_party_mobile_number = $obj->encode_decode('encrypt', $account_party_mobile_number);
                            }
                            if(!empty($account_party_identification)) {
                                if(!empty($account_party_details)) {
                                    $account_party_details = $account_party_details."<br>".$account_party_identification;
                                }
                                $account_party_identification = $obj->encode_decode('encrypt', $account_party_identification);
                            }
                            else {
                                $account_party_identification = $GLOBALS['null_value'];
                            }

                            if(!empty($account_party_city)) {
                                $account_party_city = $obj->encode_decode('encrypt', $account_party_city);
                            }
                            if(!empty($account_party_details)) {
                                $account_party_details = $obj->encode_decode('encrypt', $account_party_details);
                            }

                            if(preg_match("/^\d+$/", $account_party_unique_id)) {
                                $action = "";
                                if(!empty($account_party_name_mobile_city)) {
                                    $action = "Account Party Updated. Details - ".$obj->encode_decode('decrypt', $account_party_name_mobile_city);
                                }
                            
                                $columns = array(); $values = array(); $update_id = "";				
                                $columns = array('creator_name', 'name', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'account_party_details');
                                $values = array("'".$creator_name."'", "'".$account_party_name."'", "'".$account_party_name_mobile_city."'", "'".$account_party_identification."'", "'".$account_party_address."'", "'".$account_party_state."'", "'".$account_party_district."'", "'".$account_party_city."'", "'".$account_party_details."'");
                                $update_id = $obj->UpdateSQL($GLOBALS['account_party_table'], $account_party_unique_id, $columns, $values, $action);
                                if(preg_match("/^\d+$/", $update_id)) {
                                    $account_party_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'id', $account_party_unique_id, 'account_party_id');						
                                }
                            }
                            else {
                                $action = "";
                                if(!empty($account_party_name_mobile_city)) {
                                    $action = "New Account Party Created. Details - ".$obj->encode_decode('decrypt', $account_party_name_mobile_city);
                                }
                                $null_value = $GLOBALS['null_value']; $insert_id = "";
                                $columns = array('created_date_time', 'creator', 'creator_name', 'account_party_id', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'account_party_details', 'deleted');
                                $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$account_party_name."'", "'".$account_party_mobile_number."'", "'".$account_party_name_mobile_city."'", "'".$account_party_identification."'", "'".$account_party_address."'", "'".$account_party_state."'", "'".$account_party_district."'", "'".$account_party_city."'", "'".$account_party_details."'", "'0'");
                                $insert_id = $obj->InsertSQL($GLOBALS['account_party_table'], $columns, $values, 'account_party_id', '', $action);
                                if(preg_match("/^\d+$/", $insert_id)) {
                                    $account_party_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'id', $insert_id, 'account_party_id');					
                                }
                            }
                        }
                        
                        if(empty($account_party_id)) {
                            $account_party_id = $GLOBALS['null_value']; $account_party_name_mobile_city = $GLOBALS['null_value']; 
                            $account_party_details = $GLOBALS['null_value'];
                        }

                        if(!empty($unit_id_values)) {
                            $unit_id_values = implode(",", $unit_id_values);
                        }
                        if(!empty($unit_name_values)) {
                            $unit_name_values = implode(",", $unit_name_values);
                        }
                        if(!empty($quantity_values)) {
                            $quantity_values = implode(",", $quantity_values);
                        }
                        if(!empty($weight_values)) {
                            $weight_values = implode(",", $weight_values);
                        }
                        if(!empty($rate_values)) {
                            $rate_values = implode(",", $rate_values);
                        }
                        if(!empty($freight_values)) {
                            $freight_values = implode(",", $freight_values);
                        }
                        if(!empty($kooli_values)) {
                            $kooli_values = implode(",", $kooli_values);
                        }
                        if(!empty($kooli_by_quantity_values)) {
                            $kooli_by_quantity_values = implode(",", $kooli_by_quantity_values);
                        }
                        if(!empty($amount_values)) {
                            $amount_values = implode(",", $amount_values);
                        }

                        $lr_number = "";

                        if(empty($edit_id)) {
                            $null_value = $GLOBALS['null_value']; $cancelled = 0; $cancel_date = $GLOBALS['default_date']; $cancel_remarks = $GLOBALS['null_value'];
                            $columns = array('created_date_time', 'creator', 'creator_name', 'lr_id', 'lr_number', 'lr_date', 'organization_id', 'organization_details', 'consignor_id', 'consignor_name_mobile_city', 'consignor_details', 'consignee_id', 'consignee_name_mobile_city', 'consignee_details', 'account_party_id', 'account_party_name_mobile_city', 'account_party_details', 'from_branch_id', 'from_branch_details', 'to_branch_id', 'to_branch_details', 'bill_type', 'gst_option', 'tax_value', 'unit_id', 'unit_name', 'quantity', 'weight', 'rate', 'freight', 'kooli', 'kooli_by_quantity', 'amount', 'sub_total', 'delivery_charges', 'delivery_charges_value', 'loading_charges', 'loading_charges_value', 'cgst', 'sgst', 'igst', 'round_off', 'total_quantity', 'total_weight', 'total_amount', 'luggage_sheet_number', 'tripsheet_number', 'cleared', 'received_person', 'received_person_contact_number', 'received_person_identification', 'cancelled', 'cancel_date', 'cancel_remarks', 'deleted');
                            $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$null_value."'", "'".$lr_date."'", "'".$organization_id."'", "'".$organization_details."'", "'".$consignor_id."'", "'".$consignor_name_mobile_city."'", "'".$consignor_details."'", "'".$consignee_id."'", "'".$consignee_name_mobile_city."'", "'".$consignee_details."'", "'".$account_party_id."'", "'".$account_party_name_mobile_city."'", "'".$account_party_details."'", "'".$from_branch_id."'", "'".$from_branch_details."'", "'".$to_branch_id."'", "'".$to_branch_details."'", "'".$bill_type."'", "'".$gst_option."'", "'".$tax_value."'", "'".$unit_id_values."'", "'".$unit_name_values."'", "'".$quantity_values."'", "'".$weight_values."'", "'".$rate_values."'", "'".$freight_values."'", "'".$kooli_values."'", "'".$kooli_by_quantity_values."'", "'".$amount_values."'", "'".$sub_total."'", "'".$delivery_charges."'", "'".$delivery_charges_value."'", "'".$loading_charges."'", "'".$loading_charges_value."'", "'".$cgst."'", "'".$sgst."'", "'".$igst."'", "'".$round_off."'", "'".$total_quantity."'", "'".$total_weight."'", "'".$total_amount."'", "'".$luggage_sheet_number."'", "'".$tripsheet_number."'", "'".$cleared."'", "'".$received_person."'", "'".$received_person_contact_number."'", "'".$received_person_identification."'", "'".$cancelled."'", "'".$cancel_date."'", "'".$cancel_remarks."'", "'0'");
                            $lr_insert_id = $obj->InsertSQL($GLOBALS['lr_table'], $columns, $values, 'lr_id', 'lr_number', '');
                            if(preg_match("/^\d+$/", $lr_insert_id)) {	
                                $lr_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'id', $lr_insert_id, 'lr_number');							
                                $result = array('number' => '1', 'msg' => 'LR Successfully Created');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $lr_insert_id);
                            }
                        }
                        else {
                            $getUniqueID = "";
                            $getUniqueID = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $edit_id, 'id');
                            if(preg_match("/^\d+$/", $getUniqueID)) {                            
                                $columns = array(); $values = array();						
                                $columns = array('creator_name', 'lr_date', 'organization_id', 'organization_details', 'consignor_id', 'consignor_name_mobile_city', 'consignor_details', 'consignee_id', 'consignee_name_mobile_city', 'consignee_details', 'account_party_id', 'account_party_name_mobile_city', 'account_party_details', 'from_branch_id', 'from_branch_details', 'to_branch_id', 'to_branch_details', 'bill_type', 'gst_option', 'tax_value', 'unit_id', 'unit_name', 'quantity', 'weight', 'rate', 'freight', 'kooli', 'kooli_by_quantity', 'amount', 'sub_total', 'delivery_charges', 'delivery_charges_value', 'loading_charges', 'loading_charges_value', 'cgst', 'sgst', 'igst', 'round_off', 'total_quantity', 'total_weight', 'total_amount');
                                $values = array("'".$creator_name."'", "'".$lr_date."'", "'".$organization_id."'", "'".$organization_details."'", "'".$consignor_id."'", "'".$consignor_name_mobile_city."'", "'".$consignor_details."'", "'".$consignee_id."'", "'".$consignee_name_mobile_city."'", "'".$consignee_details."'", "'".$account_party_id."'", "'".$account_party_name_mobile_city."'", "'".$account_party_details."'", "'".$from_branch_id."'", "'".$from_branch_details."'", "'".$to_branch_id."'", "'".$to_branch_details."'", "'".$bill_type."'", "'".$gst_option."'", "'".$tax_value."'", "'".$unit_id_values."'", "'".$unit_name_values."'", "'".$quantity_values."'", "'".$weight_values."'", "'".$rate_values."'", "'".$freight_values."'", "'".$kooli_values."'", "'".$kooli_by_quantity_values."'", "'".$amount_values."'", "'".$sub_total."'", "'".$delivery_charges."'", "'".$delivery_charges_value."'", "'".$loading_charges."'", "'".$loading_charges_value."'", "'".$cgst."'", "'".$sgst."'", "'".$igst."'", "'".$round_off."'", "'".$total_quantity."'", "'".$total_weight."'", "'".$total_amount."'");
                                $branch_update_id = $obj->UpdateSQL($GLOBALS['lr_table'], $getUniqueID, $columns, $values, '');
                                if(preg_match("/^\d+$/", $branch_update_id)) {	
                                    $lr_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $edit_id, 'lr_number');
                                    $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                                }
                                else {
                                    $result = array('number' => '2', 'msg' => $branch_update_id);
                                }							
                            }
                        }

                        if(!empty($lr_number)) {
                            $lr_unique_id = "";
                            $lr_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_number', $lr_number, 'id');
                            if(preg_match("/^\d+$/", $lr_unique_id)) {
                                $action = "";
                                if(!empty($edit_id)) {
                                    $action = "LR Updated. Number - ".$lr_number;
                                }
                                else {
                                    $action = "New LR Created. Number - ".$lr_number;
                                }
                                $columns = array(); $values = array();						
                                $columns = array('lr_number');
                                $values = array("'".$lr_number."'");
                                $msg = $obj->UpdateSQL($GLOBALS['lr_table'], $lr_unique_id, $columns, $values, $action);
                            }
                        }

                    }
                    else {
                        $result = array('number' => '2', 'msg' => 'Missing consignee details');
                    }

                }
                else {
                    $result = array('number' => '2', 'msg' => 'Missing consignor details');
                }

            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_lr)) {
                $result = array('number' => '3', 'msg' => $valid_lr);
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
        $filter_organization_id = "";
        if(isset($_POST['filter_organization_id'])) {
            $filter_organization_id = $_POST['filter_organization_id'];
        }
        $filter_lr_number = "";
        if(isset($_POST['filter_lr_number'])) {
            $filter_lr_number = $_POST['filter_lr_number'];
        }

        $filter_from_branch_id = "";
        if(isset($_POST['filter_from_branch_id'])) {
            $filter_from_branch_id = $_POST['filter_from_branch_id'];
        }
        $filter_to_branch_id = "";
        if(isset($_POST['filter_to_branch_id'])) {
            $filter_to_branch_id = $_POST['filter_to_branch_id'];
        }
        $filter_bill_type = "";
        if(isset($_POST['filter_bill_type'])) {
            $filter_bill_type = $_POST['filter_bill_type'];
        }

        $filter_consignor_id = "";
        if(isset($_POST['filter_consignor_id'])) {
            $filter_consignor_id = $_POST['filter_consignor_id'];
        }
        $filter_consignee_id = "";
        if(isset($_POST['filter_consignee_id'])) {
            $filter_consignee_id = $_POST['filter_consignee_id'];
        }
        $filter_account_party_id = "";
        if(isset($_POST['filter_account_party_id'])) {
            $filter_account_party_id = $_POST['filter_account_party_id'];
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
                    include("lr_table.php"); 
                ?>
            </div>
            <div class="tab-pane fade" id="cancel_bill">
                <?php 
                    $cancelled = 1;
                    include("lr_table.php"); 
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
            $cancel_bill_unique_id = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $cancel_bill_id, 'id');
            if(!empty($cancel_bill_unique_id) && preg_match("/^\d+$/", $cancel_bill_unique_id)) {
                $cancel_bill_table = $GLOBALS['lr_table'];
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

            $lr_number = "";
            if(!empty($cancel_bill_id)) {
                $lr_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $cancel_bill_id, 'lr_number');
                if(!empty($lr_number)) {
                    $cancel_lr = 0;

                    $luggage_sheet_number = "";
                    $luggage_sheet_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $cancel_bill_id, 'luggage_sheet_number');

                    $tripsheet_number = "";
                    $tripsheet_number = $obj->getTableColumnValue($GLOBALS['lr_table'], 'lr_id', $cancel_bill_id, 'tripsheet_number');

                    if( (!empty($luggage_sheet_number) && $luggage_sheet_number == $GLOBALS['null_value']) && (!empty($tripsheet_number) && $tripsheet_number == $GLOBALS['null_value']) ) {
                        $cancel_lr = 1;
                    }

                    if(!empty($cancel_lr) && $cancel_lr == 1) {
                        $action = "LR Cancelled. Number - ".$lr_number;

                        $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
            
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