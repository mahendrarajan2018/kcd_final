<?php 
	$page_title = "Invoice Acknowledgement";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $to_date = date("Y-m-d"); $from_date = date('Y-m-d', strtotime('-30 days', strtotime($to_date)));

    $tripsheet_number_list = array();
    $tripsheet_number_list = $obj->getFilterAcknowledgedTripsheetNumberList();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
    <script type="text/javascript" src="include/js/action_changes.js"></script>
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
                                                        <select name="filter_tripsheet_number" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select TS Number</option>
                                                            <?php
                                                                if(!empty($tripsheet_number_list)) {
                                                                    foreach($tripsheet_number_list as $tripsheet_number) {
                                                                        if(!empty($tripsheet_number)) {
                                                            ?>
                                                                            <option value="<?php echo $tripsheet_number; ?>"> <?php echo $tripsheet_number; ?> </option>
                                                            <?php
                                                                        }                                                                        
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Select TS Number</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-2 col-4">
                                                <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onClick="Javascript:ViewInvoiceAcknowledgement();"> <i class="fa fa-plus-circle"></i> Acknowledge Invoice </button>
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
<button class="d-none invoice_acknowledgement_button" type="button" data-bs-toggle="modal" data-bs-target="#invoiceAcknowledgementModal"></button>
<div id="invoiceAcknowledgementModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invoice Acknowledgement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div><hr>
            <div class="modal-body">
                <div class="row mx-0">
                    <div class="col-md-6 col-lg-4">
                        <div class="row">
                            <div class="form-group col-7">
                                <div class="form-label-group in-border mb-0">
                                <input type="text" name="acknowledge_tripsheet_number" class="form-control shadow-none">
                                    <label>Tripsheet number (*)</label>
                                </div>
                            </div>
                            <div class="form-group col-5 text-center">
                                <div class="form-label-group in-border mb-0">
                                    <button class="btn btn-dark btnwidth search_button" type="button" onClick="Javascript:ShowInvoiceAcknowledgedModal();">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 tripsheet_details"></div>
            </div>

        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#invoice_acknowledgement").addClass("active");
        table_listing_records_filter();
    });
</script>