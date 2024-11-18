<?php 
	$page_title = "Settings";
	include("include_user_check.php");

    $total_sms_count = 0; $sms_used_count = 0;

    $settings_list = array();
    $settings_list = $obj->getTableRecords($GLOBALS['settings_table'], '', '', '');
    if(!empty($settings_list)) {
        foreach($settings_list as $data) {
            if(!empty($data['name']) && $data['name'] == "total_sms_count") {
                $total_sms_count = $data['value'];
            }
            if(!empty($data['name']) && $data['name'] == "sms_used_count") {
                $sms_used_count = $data['value'];
            }
        }
    }
?>
<?php include "header.php"; ?>
<!-- Start right Content here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
        
            <form name="settings_form" method="post" class="redirection_form">
                <div class="row p-3">
                    <div class="col-lg-2 col-md-3 col-12 pb-3">
                        <div class="form-group mb-1">
                            <div class="form-label-group in-border">
                                <input type="text" name="total_sms_count" class="form-control shadow-none" value="<?php if(!empty($total_sms_count)) { echo $total_sms_count; } ?>">
                                <label>Total SMS Count <span class="text-danger">*</span> </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3 text-center">
                        <button class="btn btn-dark template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event, 'settings_form', 'count_settings_changes.php', 'count_settings.php');">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        
        </div>
    </div>
    <!-- End Page-content -->
<script type="text/javascript" src="include/js/common.js"></script>
<?php include "footer.php"; ?>