<?php
	include("include.php");

	if(isset($_REQUEST['show_account_party_id'])) { 
        $show_account_party_id = $_REQUEST['show_account_party_id'];
        $show_account_party_id = trim($show_account_party_id);

        $name = ""; $mobile_number = ""; $identification = ""; $address = ""; $country = "India"; $state = "Tamil Nadu"; $district = "";
        $city = ""; $account_party_details = "";     
        if(!empty($show_account_party_id)) {
            $account_party_list = array();
            $account_party_list = $obj->getTableRecords($GLOBALS['account_party_table'], 'account_party_id', $show_account_party_id,'');
            if(!empty($account_party_list)) {
                foreach($account_party_list as $data) {
                    if(!empty($data['name'])) {
                        $name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['identification']) && $data['identification'] != $GLOBALS['null_value']) {
                        $identification = $obj->encode_decode('decrypt', $data['identification']);
                    }
                    if(!empty($data['address']) && $data['address'] != $GLOBALS['null_value']) {
                        $address = $obj->encode_decode('decrypt', $data['address']);
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
                    if(!empty($data['account_party_details'])) {
                        $account_party_details = $obj->encode_decode('decrypt', $data['account_party_details']);
                    }
                }
            }
        }
?>
        <form class="poppins pd-20 redirection_form" name="account_party_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_account_party_id)) {  ?>
                            <div class="h5">Add account party</div>
                        <?php } else {?>
                            <div class="h5">Edit account party</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('account_party.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_account_party_id)) { echo $show_account_party_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="name" class="form-control shadow-none" value="<?php if(!empty($name)) { echo $name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);">
                            <label>Party Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Text only (Characters upto 25)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="mobile_number" class="form-control shadow-none" value="<?php if(!empty($mobile_number)) { echo $mobile_number; } ?>" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                            <label>Party Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" name="identification" class="form-control shadow-none" value="<?php if(!empty($identification)) { echo $identification; } ?>" onkeydown="Javascript:KeyboardControls(this,'',50,'');InputBoxColor(this,'text');">
                            <label>Party Identification</label>
                        </div>
                        <div class="new_smallfnt">Contains Text,Numbers,Symbols(Except <>?{}!*^%$)(Max Char: 50)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <textarea class="form-control" name="address" onkeydown="Javascript:KeyboardControls(this,'',150,'');InputBoxColor(this,'text');"><?php if(!empty($address)) { echo $address; } ?></textarea>
                            <label>Address</label>
                        </div>
                        <div class="new_smallfnt">Contains Text,Numbers,Symbols(Except <>?{}!*^%$)(Max Char: 150)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 pb-3">
                    <div class="form-group pb-3">
                        <div class="form-label-group in-border mb-0">
                            <div class="w-100" style="display:none;">
                                <select class="select2 select2-danger" name="country" id="country" onchange="Javascript:getCountries('account_party',this.value,'','','');" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option>India</option>
                                </select>
                            </div>
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" name="state" onchange="Javascript:getStates('account_party',this.value,'','');">
                                <option value="">Select State</option>
                            </select>
                            <label>State <span class="text-danger">*</span></label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group pb-3">
                        <div class="form-label-group in-border">
                            <select name="district" class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getDistricts('account_party',this.value,'');">
                                <option value="">Select District</option>
                            </select>
                            <label>District <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group pb-3">
                        <div class="form-label-group in-border">
                            <select name="city" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getCities('account_party','',this.value);">
                                <option>Select City</option>
                            </select>
                            <label>City <span class="text-danger">*</span></label>
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
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'account_party_form', 'account_party_changes.php', 'account_party.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {
                    jQuery('.add_update_form_content').find('select').select2();
                });
            </script>
            <script type="text/javascript">
                getCountries('account_party','<?php if(!empty($country)) { echo $country; } ?>', '<?php if(!empty($state)) { echo $state; } ?>', '<?php if(!empty($district)) { echo $district; } ?>', '<?php if(!empty($city)) { echo $city; } ?>');
            </script>
        </form>
<?php
    }

    if(isset($_POST['name'])) {	
        $name = ""; $name_error = "";  $mobile_number = ""; $mobile_number_error = ""; 	$identification = ""; $identification_error = ""; $district = ""; $district_error = ""; $others_city = ""; $others_city_error = "";
        $address = ""; $address_error = ""; $state = ""; $state_error = ""; $city = ""; $city_error = "";
        $valid_account_party = ""; $form_name = "account_party_form";
        
        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
    
        $name = $_POST['name'];
        $name = trim($name);
        if(!empty($name) && strlen($name) > 25) {
            $name_error = "Only 25 characters allowed";
        }
        else {
            $name_error = $valid->valid_company_name($name,'name','1');
        }
        if(!empty($name_error)) {
            $valid_account_party = $valid->error_display($form_name, "name", $name_error, 'text');			
        }

        $mobile_number = $_POST['mobile_number'];
        $mobile_number = trim($mobile_number);
        $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
        if(!empty($mobile_number_error)) {
            if(!empty($valid_account_party)) {
                $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
            else {
                $valid_account_party = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
        }

        $identification = $_POST['identification'];
        $identification = trim($identification);
        if(!empty($identification)) {
            if(strlen($identification) > 50) {
                $identification_error = "Only 50 characters allowed";
            }
            else {
                $identification_error = $valid->valid_address($identification, "identification", "0");    
            }       
        }
        if(!empty($identification_error)) {
            if(!empty($valid_account_party)) {
                $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "identification", $identification_error, 'text');
            }
            else {
                $valid_account_party = $valid->error_display($form_name, "identification", $identification_error, 'text');
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
            if(!empty($valid_account_party)) {
                $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "address", $address_error, 'textarea');
            }
            else {
                $valid_account_party = $valid->error_display($form_name, "address", $address_error, 'textarea');
            }
        }  

        if(isset($_POST['state'])) {
            $state = $_POST['state'];
            $state = trim($state);
            $state_error = $valid->common_validation($state,'State','select');
            if(!empty($state_error)) {
                if(!empty($valid_account_party)) {
                    $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "state", $state_error, 'select');
                }
                else {
                    $valid_account_party = $valid->error_display($form_name, "state", $state_error, 'select');
                }
            }
        }

        if(isset($_POST['district'])) {
            $district = $_POST['district'];
            $district = trim($district);
            $district_error = $valid->common_validation($district,'District','select');
            if(!empty($district_error)) {
                if(!empty($valid_account_party)) {
                    $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "district", $district_error, 'select');
                }
                else {
                    $valid_account_party = $valid->error_display($form_name, "district", $district_error, 'select');
                }
            }
        }

        if(isset($_POST['city'])) {
            $city = $_POST['city'];
            $city = trim($city);
            $city_error = $valid->common_validation($city,'City','select');
            if(!empty($city_error)) {
                if(!empty($valid_account_party)) {
                    $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "city", $city_error, 'select');
                }
                else {
                    $valid_account_party = $valid->error_display($form_name, "city", $city_error, 'select');
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
                            if(!empty($valid_account_party)) {
                                $valid_account_party = $valid_account_party." ".$valid->error_display($form_name, "others_city", $others_city_error, 'text');
                            }
                            else {
                                $valid_account_party = $valid->error_display($form_name, "others_city", $others_city_error, 'text');
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
    
        $result = "";
        
        if(empty($valid_account_party)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
    
                $name_mobile_city = ""; $account_party_details = "";
                if(!empty($name)) {
                    $name_mobile_city = $name;
                    $account_party_details = $name;
                    $name = $obj->encode_decode('encrypt', $name);
                }
                if(!empty($address)) {
                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details."<br>".str_replace("\r\n", "<br>", $address);
                    }
                    $address = $obj->encode_decode('encrypt', $address);
                }
                else {
                    $address = $GLOBALS['null_value'];
                }
                if(!empty($city)) {
                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details."<br>".$city;
                    }
                }
                if(!empty($district)) {
                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details."<br>".$district;
                    }
                }
                if(!empty($state)) {
                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details.", ".$state;
                    }
                    $state = $obj->encode_decode('encrypt', $state);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);

                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details."<br> Mobile : ".$mobile_number;
                    }
                    if(!empty($name_mobile_city)) {
                        $name_mobile_city = $name_mobile_city." (".$mobile_number.")";
                        if(!empty($city)) {
                            $name_mobile_city = $name_mobile_city." - ".$city;
                        }
                        $name_mobile_city = $obj->encode_decode('encrypt', $name_mobile_city);
                    }

                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }
                if(!empty($identification)) {
                    if(!empty($account_party_details)) {
                        $account_party_details = $account_party_details."<br>".$identification;
                    }
                    $identification = $obj->encode_decode('encrypt', $identification);
                }
                else {
                    $identification = $GLOBALS['null_value'];
                }

                if(!empty($city)) {
                    $city = $obj->encode_decode('encrypt', $city);
                }
                else{
                    $city = $GLOBALS['null_value'];
                }
                if(!empty($district)) {
                    $district = $obj->encode_decode('encrypt', $district);
                }
                else{
                    $district = $GLOBALS['null_value'];
                }
                if(!empty($account_party_details)) {
                    $account_party_details = $obj->encode_decode('encrypt', $account_party_details);
                }
                
                $prev_account_party_id = ""; $account_party_error = "";		
                if(!empty($mobile_number)) {
                    $prev_account_party_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'mobile_number', $mobile_number, 'account_party_id');
                    if(!empty($prev_account_party_id)) {
                        $account_party_error = "This mobile number is already exist";
                    }
                }
                if(!empty($identification) && $identification != $GLOBALS['null_value'] && empty($account_party_error)) {
                    $prev_account_party_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'identification', $identification, 'account_party_id');
                    if(!empty($prev_account_party_id)) {
                        $account_party_error = "This identification already exist";
                    }
                }
                
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                
                if(empty($edit_id)) {
                    if(empty($prev_account_party_id)) {
                        $action = "";
                        if(!empty($name_mobile_city)) {
                            $action = "New account party Created. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array('created_date_time', 'creator', 'creator_name', 'account_party_id', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city',  'account_party_details', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile_city."'", "'".$identification."'", "'".$address."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$account_party_details."'", "'0'");
                        $user_insert_id = $obj->InsertSQL($GLOBALS['account_party_table'], $columns, $values, 'account_party_id', '', $action);
                        if(preg_match("/^\d+$/", $user_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Account Party Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $user_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $account_party_error);
                    }
                }
                else {
                    if(empty($prev_account_party_id) || $prev_account_party_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'account_party_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name_mobile_city)) {
                                $action = "Account Party Updated. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state',  'district', 'city', 'account_party_details');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile_city."'", "'".$identification."'", "'".$address."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$account_party_details."'");
                            $user_update_id = $obj->UpdateSQL($GLOBALS['account_party_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $user_update_id)) {	
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $user_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $account_party_error);
                    }
                }    
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_account_party)) {
                $result = array('number' => '3', 'msg' => $valid_account_party);
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
        $total_records_list = $obj->getTableRecords($GLOBALS['account_party_table'], '', '', '');

        if(!empty($search_text)) {
            $search_text = strtolower($search_text);
            $list = array();
            if(!empty($total_records_list)) {
                foreach($total_records_list as $val) {
                    if(strpos(strtolower($obj->encode_decode('decrypt', $val['name_mobile_city'])), $search_text) !== false) {
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
                    <th>State</th>
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
                                        if(!empty($data['name_mobile_city'])) {
                                            $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                            echo $data['name_mobile_city'];
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
                                        if(!empty($data['state'])) {
                                            $data['state'] = $obj->encode_decode('decrypt', $data['state']);
                                            echo $data['state'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['account_party_id'])) { echo $data['account_party_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['account_party_id'])) { echo $data['account_party_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                <?php 
                        } 
                    }  
                    else {
                ?>
                        <tr>
                            <td colspan="4" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php 
                    } 
                ?>
            </tbody>
        </table>   
                      
		<?php	
	}

    if(isset($_REQUEST['delete_account_party_id'])) {
        $delete_account_party_id = $_REQUEST['delete_account_party_id'];
        $delete_account_party_id = trim($delete_account_party_id);
        $msg = "";
        if(!empty($delete_account_party_id)) {	
            $account_party_unique_id = "";
            $account_party_unique_id = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'account_party_id', $delete_account_party_id, 'id');
            if(preg_match("/^\d+$/", $account_party_unique_id)) {
                $name_mobile_city = "";
                $name_mobile_city = $obj->getTableColumnValue($GLOBALS['account_party_table'], 'account_party_id', $delete_account_party_id, 'name_mobile_city');
            
                $action = "";
                if(!empty($name_mobile_city)) {
                    $action = "Account Party Deleted. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                }
            
                $columns = array(); $values = array();						
                $columns = array('deleted');
                $values = array("'1'");
                $msg = $obj->UpdateSQL($GLOBALS['account_party_table'], $account_party_unique_id, $columns, $values, $action);
            }
            else {
                $msg = "Invalid account party";
            }
        }
        else {
            $msg = "Empty account party";
        }
        echo $msg;
        exit;	
    }
?>