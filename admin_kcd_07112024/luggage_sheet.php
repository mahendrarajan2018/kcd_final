<?php 
	$page_title = "Luggage Sheet";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $prev_date = ""; $from_date = ""; $to_date = "";
    $prev_date = date('d-m-Y', strtotime('-30 days'));
    $from_date = date('d-m-Y', strtotime('-30 days'));
    $to_date = date('d-m-Y');

    $branch_list = array();
    $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php 
	include "link_style_script.php"; ?>
    <script type="text/javascript" src="include/js/luggagesheet.js"></script>
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
                            <div class="border card-box d-none add_update_form_content" id="add_update_form_content"></div>
                            <div class="border card-box" id="table_records_cover">
                                <div class="card-header align-items-center">
                                    <form name="table_listing_form" method="post">
                                        <div class="row p-2">
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-1">
                                                    <div class="form-label-group in-border pb-2">
                                                        <input type="text" name="from_date" class="form-control date_field shadow-none" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" onchange="Javascript:table_listing_records_filter();">
                                                        <label>From Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-1">
                                                    <div class="form-label-group in-border pb-2">
                                                        <input type="text" name="to_date" class="form-control date_field shadow-none" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" onchange="Javascript:table_listing_records_filter();">
                                                        <label>To Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-5 col-6">
                                                <div class="form-group pb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" name="filter_branch_id" style="width: 100%;" onchange="Javascript:table_listing_records_filter();">
                                                            <option value="">Select Branch</option>
                                                            <?php
                                                                if(!empty($branch_list)) {
                                                                    foreach($branch_list as $list) {
                                                                        if(!empty($list['branch_id']) && $list['branch_id'] != $GLOBALS['null_value']) {
                                                            ?>
                                                                            <option value="<?php echo $list['branch_id']; ?>">
                                                                                <?php  
                                                                                    if(!empty($list['prefix_name_mobile']) && $list['prefix_name_mobile'] != $GLOBALS['null_value']) {
                                                                                        echo $obj->encode_decode('decrypt', $list['prefix_name_mobile']);
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label>Branch</label>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-lg-3 col-md-5 col-6">
                                                <div class="input-group">
                                                    <input type="text" name="search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" onkeyup="Javascript:table_listing_records_filter();">
                                                    <span class="input-group-text" style="height:34px;" id="basic-addon2" onclick="Javascript:table_listing_records_filter();"><i class="bi bi-search"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                            </div>
                                            <div class="col-sm-6 col-xl-8">
                                                <input type="hidden" name="page_number" value="<?php if(!empty($page_number)) { echo $page_number; } ?>">
                                                <input type="hidden" name="page_limit" value="<?php if(!empty($page_limit)) { echo $page_limit; } ?>">
                                                <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                            </div>	
                                        </div>
                                    </form>
                                </div>
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
    $(document).ready(function() {
        $("#luggage_sheet").addClass("active");
        table_listing_records_filter();
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