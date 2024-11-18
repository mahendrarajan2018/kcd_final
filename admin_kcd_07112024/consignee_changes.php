<?php
	include("include.php");

	if(isset($_REQUEST['show_consignee_id'])) { 
        $show_consignee_id = $_REQUEST['show_consignee_id'];
        $show_consignee_id = trim($show_consignee_id);

        $name = ""; $mobile_number = ""; $identification = ""; $address = ""; $country = "India"; $state = "Tamil Nadu"; $district = "";
        $city = ""; $consignee_details = "";     
        if(!empty($show_consignee_id)) {
            $consignee_list = array();
            $consignee_list = $obj->getTableRecords($GLOBALS['consignee_table'], 'consignee_id', $show_consignee_id,'');
            if(!empty($consignee_list)) {
                foreach($consignee_list as $data) {
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
                    if(!empty($data['consignee_details'])) {
                        $consignee_details = $obj->encode_decode('decrypt', $data['consignee_details']);
                    }
                }
            }
        }
?>
        <form class="poppins pd-20 redirection_form" name="consignee_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_consignee_id)) {  ?>
                            <div class="h5">Add Consignee</div>
                        <?php } else {?>
                            <div class="h5">Edit Consignee</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="window.open('consignee.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_consignee_id)) { echo $show_consignee_id; } ?>">
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
                                <select class="select2 select2-danger" name="country" id="country" onchange="Javascript:getCountries('consignee',this.value,'','','');" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option>India</option>
                                </select>
                            </div>
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" name="state" onchange="Javascript:getStates('consignee',this.value,'','');">
                                <option value="">Select State</option>
                            </select>
                            <label>State <span class="text-danger">*</span></label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group pb-3">
                        <div class="form-label-group in-border">
                            <select name="district" class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getDistricts('consignee',this.value,'');">
                                <option value="">Select District</option>
                            </select>
                            <label>District <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 pb-3">
                    <div class="form-group pb-3">
                        <div class="form-label-group in-border">
                            <select name="city" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getCities('consignee','',this.value);">
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
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'consignee_form', 'consignee_changes.php', 'consignee.php');">
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
                getCountries('consignee','<?php if(!empty($country)) { echo $country; } ?>', '<?php if(!empty($state)) { echo $state; } ?>', '<?php if(!empty($district)) { echo $district; } ?>', '<?php if(!empty($city)) { echo $city; } ?>');
            </script>
        </form>
<?php
    } 

    if(isset($_POST['name'])) {	
        $name = ""; $name_error = ""; $mobile_number = ""; $mobile_number_error = ""; 	$identification = ""; $identification_error = ""; $district = ""; $district_error = ""; $others_city = ""; $others_city_error = "";
        $address = ""; $address_error = ""; $state = ""; $state_error = ""; $city = ""; $city_error = "";
        $valid_consignee = ""; $form_name = "consignee_form";
        
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
            $valid_consignee = $valid->error_display($form_name, "name", $name_error, 'text');			
        }

        $mobile_number = $_POST['mobile_number'];
        $mobile_number = trim($mobile_number);
        $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
        if(!empty($mobile_number_error)) {
            if(!empty($valid_consignee)) {
                $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
            else {
                $valid_consignee = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
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
            if(!empty($valid_consignee)) {
                $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "identification", $identification_error, 'text');
            }
            else {
                $valid_consignee = $valid->error_display($form_name, "identification", $identification_error, 'text');
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
            if(!empty($valid_consignee)) {
                $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "address", $address_error, 'textarea');
            }
            else {
                $valid_consignee = $valid->error_display($form_name, "address", $address_error, 'textarea');
            }
        }  

        if(isset($_POST['state'])) {
            $state = $_POST['state'];
            $state = trim($state);
            $state_error = $valid->common_validation($state,'State','select');
            if(!empty($state_error)) {
                if(!empty($valid_consignee)) {
                    $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "state", $state_error, 'select');
                }
                else {
                    $valid_consignee = $valid->error_display($form_name, "state", $state_error, 'select');
                }
            }
        }

        if(isset($_POST['district'])) {
            $district = $_POST['district'];
            $district = trim($district);
            $district_error = $valid->common_validation($district,'District','select');
            if(!empty($district_error)) {
                if(!empty($valid_consignee)) {
                    $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "district", $district_error, 'select');
                }
                else {
                    $valid_consignee = $valid->error_display($form_name, "district", $district_error, 'select');
                }
            }
        }

        if(isset($_POST['city'])) {
            $city = $_POST['city'];
            $city = trim($city);
            $city_error = $valid->common_validation($city,'City','select');
            if(!empty($city_error)) {
                if(!empty($valid_consignee)) {
                    $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "city", $city_error, 'select');
                }
                else {
                    $valid_consignee = $valid->error_display($form_name, "city", $city_error, 'select');
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
                            if(!empty($valid_consignee)) {
                                $valid_consignee = $valid_consignee." ".$valid->error_display($form_name, "others_city", $others_city_error, 'text');
                            }
                            else {
                                $valid_consignee = $valid->error_display($form_name, "others_city", $others_city_error, 'text');
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
        
        if(empty($valid_consignee)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
    
                $name_mobile_city = ""; $consignee_details = "";
                if(!empty($name)) {
                    $name_mobile_city = $name;
                    $consignee_details = $name;
                    $name = $obj->encode_decode('encrypt', $name);
                }
                if(!empty($address)) {
                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br>".str_replace("\r\n", "<br>", $address);
                    }
                    $address = $obj->encode_decode('encrypt', $address);
                }
                else {
                    $address = $GLOBALS['null_value'];
                }
                if(!empty($city)) {
                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br>".$city;
                    }
                }
                if(!empty($district)) {
                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br>".$district;
                    }
                }
                if(!empty($state)) {
                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br>".$state;
                    }
                    $state = $obj->encode_decode('encrypt', $state);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);

                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br> Mobile : ".$mobile_number;
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
                    if(!empty($consignee_details)) {
                        $consignee_details = $consignee_details."<br>".$identification;
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
                if(!empty($consignee_details)) {
                    $consignee_details = $obj->encode_decode('encrypt', $consignee_details);
                }
                
                $prev_consignee_id = ""; $consignee_error = "";		
                if(!empty($mobile_number)) {
                    $prev_consignee_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'mobile_number', $mobile_number, 'consignee_id');
                    if(!empty($prev_consignee_id)) {
                        $consignee_error = "This mobile number is already exist";
                    }
                }
                if(!empty($identification) && $identification != $GLOBALS['null_value'] && empty($consignee_error)) {
                    $prev_consignee_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'identification', $identification, 'consignee_id');
                    if(!empty($prev_consignee_id)) {
                        $consignee_error = "This identification already exist";
                    }
                }
                
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                
                if(empty($edit_id)) {
                    if(empty($prev_consignee_id)) {
                        $action = "";
                        if(!empty($name_mobile_city)) {
                            $action = "New consignee Created. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time', 'creator', 'creator_name', 'consignee_id', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state', 'district', 'city', 'consignee_details', 'deleted');
                        $values = array("'".$created_date_time."'", "'".$creator."'", "'".$creator_name."'", "'".$null_value."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile_city."'", "'".$identification."'", "'".$address."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$consignee_details."'", "'0'");
                        $user_insert_id = $obj->InsertSQL($GLOBALS['consignee_table'], $columns, $values, 'consignee_id', '', $action);
                        if(preg_match("/^\d+$/", $user_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'Consignee Successfully Created');						
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $user_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $consignee_error);
                    }
                }
                else {
                    if(empty($prev_consignee_id) || $prev_consignee_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'consignee_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name_mobile_city)) {
                                $action = "Consignee Updated. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('creator_name', 'name', 'mobile_number', 'name_mobile_city', 'identification', 'address', 'state',  'district', 'city', 'consignee_details');
                            $values = array("'".$creator_name."'", "'".$name."'", "'".$mobile_number."'", "'".$name_mobile_city."'", "'".$identification."'", "'".$address."'", "'".$state."'", "'".$district."'", "'".$city."'", "'".$consignee_details."'");
                            $user_update_id = $obj->UpdateSQL($GLOBALS['consignee_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $user_update_id)) {	
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $user_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $consignee_error);
                    }
                }    
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_consignee)) {
                $result = array('number' => '3', 'msg' => $valid_consignee);
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
        $total_records_list = $obj->getTableRecords($GLOBALS['consignee_table'], '', '', '');

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
                                    <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['consignee_id'])) { echo $data['consignee_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="pe-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['consignee_id'])) { echo $data['consignee_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

    if(isset($_REQUEST['delete_consignee_id'])) {
        $delete_consignee_id = $_REQUEST['delete_consignee_id'];
        $delete_consignee_id = trim($delete_consignee_id);
        $msg = "";
        if(!empty($delete_consignee_id)) {	
            $consignee_unique_id = "";
            $consignee_unique_id = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'consignee_id', $delete_consignee_id, 'id');
            if(preg_match("/^\d+$/", $consignee_unique_id)) {
                $name_mobile_city = "";
                $name_mobile_city = $obj->getTableColumnValue($GLOBALS['consignee_table'], 'consignee_id', $delete_consignee_id, 'name_mobile_city');
            
                $action = "";
                if(!empty($name_mobile_city)) {
                    $action = "Consignee Deleted. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                }
            
                $columns = array(); $values = array();						
                $columns = array('deleted');
                $values = array("'1'");
                $msg = $obj->UpdateSQL($GLOBALS['consignee_table'], $consignee_unique_id, $columns, $values, $action);
            }
            else {
                $msg = "Invalid consignee";
            }
        }
        else {
            $msg = "Empty consignee";
        }
        echo $msg;
        exit;	
    }
?>