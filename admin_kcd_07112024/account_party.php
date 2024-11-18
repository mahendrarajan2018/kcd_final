<?php 
	$page_title = "Account Party";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $account_party_list = array(); $account_party_count = 0;
    $account_party_list = $obj->getTableRecords($GLOBALS['account_party_table'], '', '', '');
    if(!empty($account_party_list)){
        $account_party_count = count($account_party_list);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php 
	include "link_style_script.php"; ?>
    <script type="text/javascript" src="include/js/creation_modules.js"></script>
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
                                            <div class="col-lg-12 col-md-12 col-12 text-end">
                                                <div class="d-flex float-end">
                                                    <div class="input-group">
                                                        <input type="text" name="search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" onkeyup="Javascript:table_listing_records_filter();">
                                                        <span class="input-group-text" style="height:34px;" id="basic-addon2" onclick="Javascript:table_listing_records_filter();"><i class="bi bi-search"></i></span>
                                                    </div>
                                                    <?php if($account_party_count > 0) { ?>
                                                        <div class="ps-2">
                                                            <button class="btn btn-success py-2" style="font-size:12px; width:140px;" type="button" onclick="Javascript:ExcelDownload();"> <i class="fa fa-cloud-download"></i> Excel Download </button>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="ps-2">
                                                        <button class="btn btn-danger float-end" style="font-size:11px; width:80px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($account_party_count > 0) { ?>
                                                <div class="col-lg-12 col-md-12 col-12 text-end my-2">
                                                    <div class="d-flex float-end">
                                                        <div class="ps-2">
                                                            <button class="btn btn-primary py-2" style="font-size:12px; width:75px;" type="button" onclick="Javascript:PrintParty('');"> <i class="fa fa-print"></i> Print </button>
                                                        </div>
                                                        <div class="ps-2">
                                                            <button class="btn btn-primary py-2" style="font-size:12px; width:70px;" type="button" onclick="Javascript:PrintParty('D');"> <i class="fa fa-download"></i> PDF </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-sm-6 col-xl-8">
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
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        $("#account_party").addClass("active");
        table_listing_records_filter();
    });
</script>
<script type="text/javascript">
    function ExcelDownload() {
        var search_text = ""; var url = "";
        search_text = jQuery('input[name="search_text"]').val();
        url = "account_party_download.php?search_text="+search_text;
        window.open(url,'_self');
    }

    function PrintParty(from) {
        var search_text = ""; var url = "";
        search_text = jQuery('input[name="search_text"]').val();
        url = "reports/rpt_account_party_list.php?search_text="+search_text+"&from="+from;
        window.open(url,'_blank');
    }
</script>