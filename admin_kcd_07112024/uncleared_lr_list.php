<?php 
	$page_title = "Uncleared LR List";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php 
	include "link_style_script.php"; ?>
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
                                <div class="row justify-content-end px-2 my-3">
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-group mb-1">
                                            <div class="form-label-group in-border pb-2">
                                                <input type="date" id="from_date" name="from_date" class="form-control shadow-none" onchange="Javascript:table_listing_records_filter();" value="2024-04-01" placeholder="" required="">
                                                <label>From Date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-group mb-1">
                                            <div class="form-label-group in-border pb-2">
                                                <input type="date" id="to_date" name="to_date" class="form-control shadow-none" value="2025-03-31" onchange="Javascript:table_listing_records_filter();" placeholder="" required="">
                                                <label>To Date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Organization</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Organization</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Branch</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Branch</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Bill Type</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Bill Type</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select LR Selection</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select LR Selection</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Godown</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Godown</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Consignor</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Consignor</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-12">
                                        <div class="form-group">
                                            <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option>Select Consignee</option>
                                                    <option>Alabama</option>
                                                    <option>Alaska</option>
                                                </select>
                                                <label>Select Consignee</label>
                                            </div>
                                        </div>        
                                    </div>
                                    <div class="col-lg-1 col-md-4 col-12 form-group">
                                        <button type="button" class="btn btn-danger fs-12"> <i class="fa fa-download"></i> Print </button> 
                                    </div>
                                </div>
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
        $("#uncleared_lr_list").addClass("active");
        table_listing_records_filter();
    });
</script>