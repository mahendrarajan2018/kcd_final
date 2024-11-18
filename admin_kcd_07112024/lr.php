<?php 
	$page_title = "LR";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $to_date = date("Y-m-d"); 
    if(!empty($billing_from_date) && !empty($billing_to_date)) {
        $to_date = $obj->getBillLastEntryDate($billing_from_date, $billing_to_date, $GLOBALS['lr_table'], 'lr_date');
    }
    $from_date = date('Y-m-d', strtotime('-1 day', strtotime($to_date)));

    $organization_list = array();
    $organization_list = $obj->getTableRecords($GLOBALS['organization_table'], '', '','');

    $lr_number_list = array();
    $lr_number_list = $obj->getLRNumberList();

    $bill_type_list = $GLOBALS['bill_type_options'];

    $branch_list = array();
    $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');

    $consignor_list = array();
    $consignor_list = $obj->getTableRecords($GLOBALS['consignor_table'], '', '','');

    $consignee_list = array();
    $consignee_list = $obj->getTableRecords($GLOBALS['consignee_table'], '', '','');

    $account_party_list = array();
    $account_party_list = $obj->getTableRecords($GLOBALS['account_party_table'], '', '','');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
    <script type="text/javascript" src="include/js/countries.js"></script>
    <script type="text/javascript" src="include/js/district.js"></script>
    <script type="text/javascript" src="include/js/cities.js"></script>
</head>	
<body>
<?php include "header.php"; ?>
<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="border card-box d-none add_update_form_content" id="add_update_form_content" ></div>
                            <div class="border card-box bg-white" id="table_records_cover">
                                <form name="table_listing_form" method="post">
                                    <div class="card-header align-items-center">
                                        <div class="row justify-content-end p-2">
                                            <div class="12">
                                                <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                            </div>
                                        </div>
                                        <div class="row px-2 mt-3">
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-1">
                                                    <div class="form-label-group in-border pb-2">
                                                        <input type="date" name="filter_from_date" class="form-control shadow-none" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" onChange="Javascript:table_listing_records_filter();">
                                                        <label>From Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-1">
                                                    <div class="form-label-group in-border pb-2">
                                                        <input type="date" name="filter_to_date" class="form-control shadow-none" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" onChange="Javascript:table_listing_records_filter();">
                                                        <label>To Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_organization_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Organization</option>
                                                            <?php
                                                                if(!empty($organization_list)) {
                                                                    foreach($organization_list as $data) {
                                                                        if(!empty($data['organization_id'])) {
                                                            ?>
                                                                            <option value="<?php echo $data['organization_id']; ?>">
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
                                                        <label>Select Organization</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_lr_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select LR Number</option>
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
                                                        <label>Select LR Number</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_from_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getFilterBranchToList(this.value);">
                                                            <option value="">Select From Branch</option>
                                                            <?php
                                                                if(!empty($branch_list)) {
                                                                    foreach($branch_list as $data) {
                                                                        if(!empty($data['branch_id'])) {
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
                                                        <label>Select From Branch</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div id="branch_to_cover" class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_to_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select To Branch</option>
                                                            <?php
                                                                if(!empty($branch_list)) {
                                                                    foreach($branch_list as $data) {
                                                                        if(!empty($data['branch_id'])) {
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
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_bill_type" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Bill Type</option>
                                                            <?php
                                                                if(!empty($bill_type_list)) {
                                                                    foreach($bill_type_list as $bill_type) {
                                                                        if(!empty($bill_type)) {
                                                            ?>
                                                                            <option value="<?php echo $obj->encode_decode('encrypt', $bill_type); ?>">
                                                                                <?php echo $bill_type; ?>
                                                                            </option>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Select Bill Type</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_consignor_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Consignor</option>
                                                            <?php
                                                                if(!empty($consignor_list)) {
                                                                    foreach($consignor_list as $data) {
                                                                        if(!empty($data['consignor_id'])) {
                                                            ?>
                                                                            <option value="<?php echo $data['consignor_id']; ?>">
                                                                                <?php 
                                                                                    if(!empty($data['name_mobile_city'])){
                                                                                        $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                                                        echo $data['name_mobile_city'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Select Consignor</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_consignee_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Consignee</option>
                                                            <?php
                                                                if(!empty($consignee_list)) {
                                                                    foreach($consignee_list as $data) {
                                                                        if(!empty($data['consignee_id'])) {
                                                            ?>
                                                                            <option value="<?php echo $data['consignee_id']; ?>">
                                                                                <?php 
                                                                                    if(!empty($data['name_mobile_city'])){
                                                                                        $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                                                        echo $data['name_mobile_city'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Select Consignee</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select name="filter_account_party_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Account Party</option>
                                                            <?php
                                                                if(!empty($account_party_list)) {
                                                                    foreach($account_party_list as $data) {
                                                                        if(!empty($data['account_party_id'])) {
                                                            ?>
                                                                            <option value="<?php echo $data['account_party_id']; ?>">
                                                                                <?php 
                                                                                    if(!empty($data['name_mobile_city'])){
                                                                                        $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                                                        echo $data['name_mobile_city'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Select Account Party</label>
                                                    </div>
                                                </div>        
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-lg-3 col-md-12 col-12 mb-3">
                                                <div class="input-group d-none">
                                                    <input type="text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                                    <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                                </div>
                                                <input type="hidden" name="page_number" value="<?php if(!empty($page_number)) { echo $page_number; } ?>">
                                                <input type="hidden" name="page_limit" value="<?php if(!empty($page_limit)) { echo $page_limit; } ?>">
                                                <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                            </div>
                                            <div class="col-lg-1 col-md-6 col-4">
                                                <button class="btn btn-dark py-2" style="font-size:10px; width:100%;" type="button"> <i class="fa fa-cloud-download"></i> Export </button>
                                            </div>
                                            <div class="col-lg-1 col-md-6 col-4">
                                                <button class="btn btn-dark py-2" style="font-size:10px; width:100%;" type="button"> <i class="fa fa-cloud-download"></i> PDF </button>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-4">
                                                <button class="btn btn-dark py-2" style="font-size:10px; width:100%;" type="button"> <i class="fa fa-cloud-download"></i> Payment Status </button>
                                            </div>
                                        </div>
                                    </div> 
                                </form>
                                <div id="table_listing_records" class="table-responsive"></div>
                            </div>
                        </div>   
                    </div>
                </div>  
            </div>
        </div>          
<!--Right Content End-->
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#lr").addClass("active");
        table_listing_records_filter();
    });
</script>