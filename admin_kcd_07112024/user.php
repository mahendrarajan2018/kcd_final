<?php 
	$page_title = "User";
	include("include_user_check.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $user_list = array(); $user_count = 0;
    $user_list = $obj->getTableRecords($GLOBALS['user_table'], '', '','');
    if(!empty($user_list)) {
        $user_count = count($user_list);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
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
                                            <div class="col-lg-3 col-md-4 col-6">
                                            </div>
                                            <div class="col-lg-1 col-4">
                                                <?php if($user_count < $GLOBALS['max_user_count']) { ?>
                                                    <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-12 text-end pt-2">
                                                <?php if(!empty($GLOBALS['max_user_count'])) { ?>
                                                    <div class="new_smallfnt">Max <?php echo $GLOBALS['max_user_count']; ?> User Allowed</div>
                                                <?php } ?>
                                            </div>
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
        $("#user").addClass("active");
        table_listing_records_filter();
    });
</script>