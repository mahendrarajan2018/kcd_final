<?php
    include("include.php");

    if(isset($_REQUEST['show_organization_id'])) { 
        $show_organization_id = $_REQUEST['show_organization_id'];
        $show_organization_id = trim($show_organization_id);
        
        $name = ""; $address1 = ""; $address2 = ""; $country = "India"; $state = "Tamil Nadu"; $district = ""; 
        $city = ""; $pincode = ""; $gst_number = ""; $mobile_number = ""; $sms_on_off = 0; $tax_on_off = 0;

        if(!empty($show_organization_id)) {
            $organization_list = array();
            $organization_list = $obj->getTableRecords($GLOBALS['organization_table'], 'organization_id', $show_organization_id,'');

			if(!empty($organization_list)) {
				foreach($organization_list as $data) {
					if(!empty($data['name'])) {
						$name = $obj->encode_decode('decrypt', $data['name']);
					}
					if(!empty($data['address1'])) {
						$address1 = $obj->encode_decode('decrypt', $data['address1']);
					}
                    if(!empty($data['address2']) && $data['address2'] != $GLOBALS['null_value']) {
						$address2 = $obj->encode_decode('decrypt', $data['address2']);
					}
					if(!empty($data['state'])) {
						$state = $obj->encode_decode('decrypt', $data['state']);
					} 
                    if(!empty($data['district']) && $data['district'] != $GLOBALS['null_value']) {
						$district = $obj->encode_decode('decrypt', $data['district']);
					} 
                    if(!empty($data['city']) && $data['city'] != $GLOBALS['null_value']) {
						$city = $obj->encode_decode('decrypt', $data['city']);
					}                     
					if(!empty($data['gst_number']) && $data['gst_number'] != $GLOBALS['null_value']) {
						$gst_number = $obj->encode_decode('decrypt', $data['gst_number']);
					}
                    if(!empty($data['pincode']) && $data['pincode'] != $GLOBALS['null_value']) {
						$pincode = $obj->encode_decode('decrypt', $data['pincode']);
					} 
                    if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']) {
						$mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
					}
                    if(!empty($data['sms_on_off']) && $data['sms_on_off'] != $GLOBALS['null_value']) {
                        $sms_on_off = $data['sms_on_off'];
                    }
                    if(!empty($data['tax_on_off']) && $data['tax_on_off'] != $GLOBALS['null_value']) {
                        $tax_on_off = $data['tax_on_off'];
                    }
				}
            }
        } 
?>
        <form class="poppins pd-20 redirection_form" name="organization_form" method="POST">
            <div class="card-header align-items-center">
                <div class="row p-2">
                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_organization_id)) { ?>
                            <div class="h5">Add Organization</div>
                        <?php } else { ?>
                            <div class="h5">Edit Organization</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_organization_id)) { echo $show_organization_id; } ?>">
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="organization_name" name="organization_name" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'text',50,1);" value="<?php if(!empty($name)) { echo $name; } ?>">
                            <label>Organization Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.(Max Char: 50)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <textarea class="form-control" id="address1" name="address1" onkeydown="Javascript:KeyboardControls(this,'',150,'');InputBoxColor(this,'text');"><?php if(!empty($address1)) { echo $address1; } ?></textarea>
                            <label>Address 1 <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Contains Text,Numbers,Symbols(Except <>?{}!*^%$)(Max Char: 150)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <textarea class="form-control" id="address2" name="address2" onkeydown="Javascript:KeyboardControls(this,'',150,'');InputBoxColor(this,'text');"><?php if(!empty($address2)) { echo $address2; } ?></textarea>
                            <label>Address 2</label>
                        </div>
                        <div class="new_smallfnt">Contains Text,Numbers,Symbols(Except <>?{}!*^%$)(Max Char: 150)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <div class="w-100" style="display:none;">
                                <select class="select2 select2-danger" name="country" id="country" onchange="Javascript:getCountries('organization',this.value,'','','');" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option>India</option>
                                </select>
                            </div>
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" name="state" onchange="Javascript:getStates('organization',this.value,'','');">
                                <option value="">Select State</option>
                            </select>
                            <label>State <span class="text-danger">*</span></label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="district" class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getDistricts('organization',this.value,'');">
                                <option value="">Select District</option>
                            </select>
                            <label>District</label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group">
                        <div class="form-label-group in-border mb-0">
                            <select name="city" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getCities('organization','',this.value);">
                                <option>Select City</option>
                            </select>
                            <label>City</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3 d-none" id="others_city_cover">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="others_city" name="others_city" class="form-control shadow-none" value="" onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
                            <label>Others city <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Text Only(Max Char: 30)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="pincode" name="pincode" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',6,'');" onkeyup="Javascript:InputBoxColor(this,'text');" value="<?php if(!empty($pincode)) { echo $pincode; } ?>">
                            <label>Pincode</label>
                        </div>
                        <div class="new_smallfnt">6 digit numbers only</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');" value="<?php if(!empty($mobile_number)) { echo $mobile_number; } ?>">
                            <label>Mobile Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="FormSelectDefault" class="form-label text-muted">SMS ON / OFF</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="sms_on_off" name="sms_on_off" onchange="Javascript:OnOffButton('sms_on_off');" value="<?php if($sms_on_off == '1') { echo '1'; } else { echo '0'; } ?>" <?php if($sms_on_off == '1') { ?>checked="checked"<?php } ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="FormSelectDefault" class="form-label text-muted">TAX ON / OFF</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="tax_on_off" name="tax_on_off" onchange="Javascript:OnOffButton('tax_on_off');" value="<?php if($tax_on_off == '1') { echo '1'; } else { echo '0'; } ?>" <?php if($tax_on_off == '1') { ?>checked="checked"<?php } ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="gst_number" name="gst_number" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',16,'');InputBoxColor(this,'text');" value="<?php if(!empty($gst_number)) { echo $gst_number; } ?>">
                            <label id="gst_label">GST Number <?php if($tax_on_off == '1') { ?><span class="text-danger">*</span><?php } ?></label>
                        </div>
                        <div class="new_smallfnt">Format : 22AAAAA0000A1Z5</div>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event,'organization_form', 'organization_changes.php', 'organization.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    if(jQuery('.add_update_form_content').length > 0) {
                        jQuery('.add_update_form_content').find('select').select2();
                    }

                    getCountries('organization','<?php if(!empty($country)) { echo $country; } ?>', '<?php if(!empty($state)) { echo $state; } ?>', '<?php if(!empty($district)) { echo $district; } ?>', '<?php if(!empty($city)) { echo $city; } ?>');
                });
            </script>
        </form>
        <?php
    }

    if(isset($_POST['organization_name'])) {	
        $name = ""; $name_error = ""; $address1 = ""; $address1_error = ""; $address2 = ""; $address2_error = "";
        $gst_number = ""; $gst_number_error = ""; $city = ""; $city_error = ""; $district = ""; $district_error = "";
        $state = ""; $state_error = ""; $pincode = ""; $pincode_error = ""; $mobile_number = ""; $mobile_number_error = "";
        $others_city = ""; $others_city_error = ""; $sms_on_off = 0; $tax_on_off = 0;
        $sms_on_off_error = ""; $tax_on_off_error = "";

        $valid_organization = ""; $form_name = "organization_form"; $edit_id = "";

        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
        
        $name = $_POST['organization_name'];
        $name = trim($name);
        if(!empty($name) && strlen($name) > 50) {
            $name_error = "Only 50 characters allowed";
        }
        else {
            $name_error = $valid->valid_company_name($name,'name','1');
        }
        if(empty($name_error) && empty($edit_id)) {
            $organization_list = array(); $organization_count = 0;
            $organization_list = $obj->getTableRecords($GLOBALS['organization_table'], '', '','');
            if(!empty($organization_list)) {
                $organization_count = count($organization_list);
            }
            if($organization_count == $GLOBALS['max_company_count']) {
                $name_error = "Max. ".$GLOBALS['max_company_count']." organizations are allowed";
            }
        }
        if(!empty($name_error)) {
            if(!empty($valid_organization)) {
                $valid_organization = $valid_organization." ".$valid->error_display($form_name, "organization_name", $name_error, 'text');
            }
            else {
                $valid_organization = $valid->error_display($form_name, "organization_name", $name_error, 'text');
            }
        }

        if(isset($_POST['address1'])) {
            $address1 = $_POST['address1'];
            $address1 = trim($address1);
            if(!empty($address1) && strlen($address1) > 150) {
                $address1_error = "Only 150 characters allowed";
            }
            else {
                $address1_error = $valid->valid_address($address1,'address','1');
            }
            if(!empty($address1_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "address1", $address1_error, 'textarea');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "address1", $address1_error, 'textarea');
                }
            }
        }

        if(isset($_POST['address2'])) {
            $address2 = $_POST['address2'];
            $address2 = trim($address2);
            if(!empty($address2)) {
                if(strlen($address2) > 150) {
                    $address2_error = "Only 150 characters allowed";
                }
                else {
                    $address2_error = $valid->valid_address($address2,'address','');
                }
                if(!empty($address2_error)) {
                    if(!empty($valid_organization)) {
                        $valid_organization = $valid_organization." ".$valid->error_display($form_name, "address2", $address2_error, 'textarea');
                    }
                    else {
                        $valid_organization = $valid->error_display($form_name, "address2", $address2_error, 'textarea');
                    }
                }
            }
        }

        if(isset($_POST['state'])) {
            $state = $_POST['state'];
            $state = trim($state);
            $state_error = $valid->common_validation($state,'State','select');
            if(!empty($state_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "state", $state_error, 'select');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "state", $state_error, 'select');
                }
            }
        }

        if(isset($_POST['district'])) {
            $district = $_POST['district'];
            $district = trim($district);
            if(!empty($district)) {
                $district_error = $valid->common_validation($district,'District','select');
            }
            if(!empty($district_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "district", $district_error, 'select');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "district", $district_error, 'select');
                }
            }
        }

        if(isset($_POST['city'])) {
            $city = $_POST['city'];
            $city = trim($city);
            if(!empty($city)) {
                $city_error = $valid->common_validation($city,'City','select');
            }
            if(!empty($city_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "city", $city_error, 'select');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "city", $city_error, 'select');
                }
            }
            else{
                if(isset($_POST['others_city']))
                {
                    $others_city = $_POST['others_city'];
                    $others_city = trim($others_city);
                    if(!empty($city) && $city == "Others") {
                        if(!empty($others_city) && strlen($others_city) > 30) {
                            $others_city_error = "Only 30 characters allowed";
                        }
                        else {
                            $others_city_error = $valid->valid_text($others_city,'City','1');
                        }
                        if(!empty($others_city_error)) {
                            if(!empty($valid_organization)) {
                                $valid_organization = $valid_organization." ".$valid->error_display($form_name, "others_city", $others_city_error, 'text');
                            }
                            else {
                                $valid_organization = $valid->error_display($form_name, "others_city", $others_city_error, 'text');
                            }
                        }
                        else {
                            $city = $others_city;
                            $city = trim($city);
                        }
                    }
                }
            }
        }

        if(isset($_POST['pincode'])) {
            $pincode = $_POST['pincode'];
            $pincode = trim($pincode);
            if(!empty($pincode)) {
                $pincode_error = $valid->valid_pincode($pincode, "Pincode", "0");
                if(!empty($pincode_error)) {
                    if(!empty($valid_organization)) {
                        $valid_organization = $valid_organization." ".$valid->error_display($form_name, "pincode", $pincode_error, 'text');
                    }
                    else {
                        $valid_organization = $valid->error_display($form_name, "pincode", $pincode_error, 'text');
                    }
                }
            }
        }

        if(isset($_POST['mobile_number'])) {
            $mobile_number = $_POST['mobile_number'];
            $mobile_number = trim($mobile_number);
            $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile Number", "1");
            if(!empty($mobile_number_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
                }
            }
        }
        
        if(isset($_POST['sms_on_off'])) {
            $sms_on_off = $_POST['sms_on_off'];
            $sms_on_off = trim($sms_on_off);

            if($sms_on_off != '0' && $sms_on_off != '1') {
                $sms_on_off_error = "SMS Checkbox Error";
            }
            if(!empty($sms_on_off_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "sms_on_off", $sms_on_off_error, 'checkbox');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "sms_on_off", $sms_on_off_error, 'checkbox');
                }
            }
        }

        if(isset($_POST['tax_on_off'])) {
            $tax_on_off = $_POST['tax_on_off'];
            $tax_on_off = trim($tax_on_off);
            if($tax_on_off != '0' && $tax_on_off != '1') {
                $tax_on_off_error = "Tax Checkbox Error";
            }
            if(!empty($tax_on_off_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "tax_on_off", $tax_on_off_error, 'checkbox');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "tax_on_off", $tax_on_off_error, 'checkbox');
                }
            }
        }

        if(isset($_POST['gst_number'])) {
            $gst_number = $_POST['gst_number'];
            $gst_number = trim($gst_number);
            $required = 0;
            if($tax_on_off == '1'){
                $required = 1;
            }
            $gst_number_error = $valid->valid_gst_number($gst_number, "GST Number", $required);
            if(!empty($gst_number_error)) {
                if(!empty($valid_organization)) {
                    $valid_organization = $valid_organization." ".$valid->error_display($form_name, "gst_number", $gst_number_error, 'text');
                }
                else {
                    $valid_organization = $valid->error_display($form_name, "gst_number", $gst_number_error, 'text');
                }
            }
        }
        
        $result = ""; $lower_case_name = "";
        
        if(empty($valid_organization)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

                $organization_details = "";

                if(!empty($name)) {
                    $organization_details = $name;
                    $name = htmlentities($name,ENT_QUOTES);
                    $lower_case_name = strtolower($name);   
                    $name = $obj->encode_decode('encrypt', $name);
                    $lower_case_name = htmlentities($lower_case_name,ENT_QUOTES);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                }

                if(!empty($address1)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>".str_replace("\r\n", "<br>", $address1);
                    }
                    $address1 = htmlentities($address1,ENT_QUOTES);
                    $address1 = $obj->encode_decode('encrypt', $address1);
                }
                else {
                    $address1 = $GLOBALS['null_value'];
                }

                if(!empty($address2)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>".str_replace("\r\n", "<br>", $address2);
                    }
                    $address2 = htmlentities($address2,ENT_QUOTES);
                    $address2 = $obj->encode_decode('encrypt', $address2);
                }
                else {
                    $address2 = $GLOBALS['null_value'];
                }

                if(!empty($city)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>".$city;
                    }
                    $city = $obj->encode_decode('encrypt', $city);
                }
                else {
                    $city = $GLOBALS['null_value'];
                }
                if(!empty($pincode)) {
                    if(!empty($organization_details) && !empty($city)) {
                        $organization_details = $organization_details." - ".$pincode;
                    }
                    $pincode = $obj->encode_decode('encrypt', $pincode);
                }
                else {
                    $pincode = $GLOBALS['null_value'];
                }
                if(!empty($district)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>".$district;
                    }
                    $district = $obj->encode_decode('encrypt', $district);
                }
                else {
                    $district = $GLOBALS['null_value'];
                }
                if(!empty($state)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>".$state;
                    }
                    $state = $obj->encode_decode('encrypt', $state);
                }
                else {
                    $state = $GLOBALS['null_value'];
                }
                if(!empty($mobile_number)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>Mobile :".$mobile_number;
                    }
                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }
                else {
                    $mobile_number = $GLOBALS['null_value'];
                }
                if(!empty($gst_number)) {
                    if(!empty($organization_details)) {
                        $organization_details = $organization_details."<br>GST IN :".$gst_number;
                    }
                    $gst_number = $obj->encode_decode('encrypt', $gst_number);
                }
                else {
                    $gst_number = $GLOBALS['null_value'];
                } 

                if(empty($others_city)) {
                    $others_city = $GLOBALS['null_value'];
                }

                if(!empty($organization_details)) {
                    $organization_details = $obj->encode_decode('encrypt',$organization_details);
                }

                $prev_organization_id = "";$organization_error = "";
                if(!empty($lower_case_name)) {
                    $prev_organization_id = $obj->getTableColumnValue($GLOBALS['organization_table'],'lower_case_name',$lower_case_name,'organization_id');
                    if(!empty($prev_organization_id)) {
                        $organization_error = "This organization name already exists";
                    }
                }

                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(empty($edit_id)) {
                    if(empty($prev_organization_id)) {
                        $action = "";
                        if(!empty($name)) {
                            $action = "New organization Created. Name - ".($obj->encode_decode('decrypt', $name));
                        }

                        $check_organization = array(); $organization_count = 0;
                        $check_organization = $obj->getTableRecords($GLOBALS['organization_table'], '', '','');
                        if(!empty($check_organization)) {
                            $organization_count = count($check_organization);
                        }

                        $primary_organization = 0;
                        if(empty($organization_count)) {
                            $primary_organization = 1;
                        }

                        $null_value = $GLOBALS['null_value'];

                        $columns = array();$values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'organization_id', 'name', 'lower_case_name', 'address1', 'address2', 'state', 'district', 'city', 'pincode', 'others_city', 'gst_number', 'mobile_number', 'organization_details', 'primary_organization', 'sms_on_off', 'tax_on_off','deleted');

                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$lower_case_name."'", "'".$address1."'", "'".$address2."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$pincode."'","'".$others_city."'", "'".$gst_number."'", "'".$mobile_number."'", "'".$organization_details."'", "'".$primary_organization."'", "'".$sms_on_off."'", "'".$tax_on_off."'", "'0'");

                        $organization_insert_id = $obj->InsertSQL($GLOBALS['organization_table'], $columns, $values,'organization_id', '', $action);	
                                            
                        if(preg_match("/^\d+$/", $organization_insert_id)) {
                            $result = array('number' => '1', 'msg' => 'Organization Successfully Created');
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $organization_insert_id);
                        }
                    }
                    else {
                        if(!empty($organization_error)) {
                            $result = array('number' => '2', 'msg' => $organization_error);
                        } 
                    }	
                }
                else {
                    if(empty($prev_organization_id) || $prev_organization_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['organization_table'], 'organization_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name)) {
                                $action = "Organization Updated. Name - ".($obj->encode_decode('decrypt', $name));
                            }

                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'lower_case_name', 'address1', 'address2', 'state', 'district', 'city', 'pincode', 'others_city', 'gst_number', 'mobile_number', 'organization_details', 'sms_on_off', 'tax_on_off');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$lower_case_name."'", "'".$address1."'", "'".$address2."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$pincode."'","'".$others_city."'", "'".$gst_number."'", "'".$mobile_number."'", "'".$organization_details."'", "'".$sms_on_off."'", "'".$tax_on_off."'");

                            $organization_update_id = $obj->UpdateSQL($GLOBALS['organization_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $organization_update_id)) {
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');					
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $organization_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $organization_error);
                    }
                }	
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_organization)) {
                $result = array('number' => '3', 'msg' => $valid_organization);
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
    
        $login_staff_id = "";
        if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
        }
        
        $total_records_list = array();
        $total_records_list = $obj->getTableRecords($GLOBALS['organization_table'],'','','ASC'); 
    
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
        if($total_pages > $page_limit) { ?>
            <div class="pagination_cover mt-3"> 
                <?php
                    include("pagination.php");
                ?> 
            </div>
            <?php 
        } 
        ?>
        
        <table class="table nowrap cursor text-center smallfnt">
            <thead class="bg-light">
                <tr>
                    <th>S.No</th>
                    <th>Organization Name</th>
                    <th>City</th>
                    <th>Mobile</th>
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
                                <td><?php echo $index; ?></td>
                                <td>
                                    <?php
                                        if(!empty($list['name']) && $list['name'] != $GLOBALS['null_value']) {
                                            echo html_entity_decode($obj->encode_decode('decrypt', $list['name']));
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($list['city']) && $list['city'] != $GLOBALS['null_value']) {
                                            echo $obj->encode_decode('decrypt', $list['city']);
                                        }
                                        else {
                                            echo '-';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(!empty($list['mobile_number']) && $list['mobile_number'] != $GLOBALS['null_value']) {
                                            echo $obj->encode_decode('decrypt', $list['mobile_number']);
                                        }
                                        else {
                                            echo '-';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['organization_id'])) { echo $list['organization_id']; } ?>');"><i class="fa fa-pencil"></i></a>
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

    if(isset($_REQUEST['delete_organization_id'])) {
        $delete_organization_id = $_REQUEST['delete_organization_id'];
        $delete_organization_id = trim($delete_organization_id);
        $msg = "";
        if(!empty($delete_organization_id)) {	
            $organization_unique_id = "";
            $organization_unique_id = $obj->getTableColumnValue($GLOBALS['organization_table'], 'organization_id', $delete_organization_id, 'id');
        
            if(preg_match("/^\d+$/", $organization_unique_id)) {
                $name = "";
                $name = $obj->getTableColumnValue($GLOBALS['organization_table'], 'organization_id', $delete_organization_id, 'name');
            
                $action = "";
                if(!empty($name)) {
                    $action = "Organization Deleted. Name - ".($obj->encode_decode('decrypt', $name));
                }
            
                $columns = array(); $values = array();						
                $columns = array('deleted');
                $values = array("'1'");
                $msg = $obj->UpdateSQL($GLOBALS['organization_table'], $organization_unique_id, $columns, $values, $action);
            }
            else {
                $msg = "Invalid Organization";
            }
        }
        else {
            $msg = "Empty Organization";
        }
        echo $msg;
        exit;	
    }
?>