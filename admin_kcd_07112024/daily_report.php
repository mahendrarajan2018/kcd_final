<?php 
	$page_title = "Dashboard";
	include("include_user_check.php");

    $from_date = ""; $to_date = ""; $daily_report_list = array();

    if(isset($_POST['from_date'])) {
		$from_date = $_POST['from_date'];
	}
    if(isset($_POST['to_date'])) {
		$to_date = $_POST['to_date'];
	}

    if(empty($from_date)) { $from_date = date("Y-m-d"); }
    if(empty($to_date)) { $to_date = date("Y-m-d"); }

    $daily_report_list = $obj->getDailyReport($from_date, $to_date);
?>
<?php include "header.php"; ?>
<!-- Start right Content here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form name="report_form" method="post">
                <div class="row mx-0 my-3">
                    <div class="form-group col-sm-6 col-xl-3">
                        <label class="form-control-label">From Date</label>
                        <div class="w-100">
                            <input type="date" name="from_date" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" class="form-control shadow-none" placeholder="From Date" onChange="Javascript:getReport();">
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-xl-3">
                        <label class="form-control-label">To Date</label>
                        <div class="w-100">
                            <input type="date" name="to_date" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" class="form-control shadow-none" placeholder="To Date" onChange="Javascript:getReport();">
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <?php if(!empty($daily_report_list)) { ?>
                    <table cellpadding="0" cellspacing="0" class="table display report_table opening_closing_balance_table" style="width: 1000px;">
                        <thead>
                            <tr>
                                <th colspan="4" style="border: 1px solid #000; text-align: center; padding: 3px 10px; font-size: 14px; vertical-align: middle; height: 30px;">
                                    Daily Report <?php //if(!empty($from_date)) { echo "(".$from_date; } if(!empty($to_date)) { echo " - ".$to_date.")"; } ?> 
                                </th>
                            </tr>
                            <tr>
                                <th style="border: 1px solid #000; text-align: center; padding: 2px 5px; font-size: 14px; width: 50px; vertical-align: middle; height: 30px;">S.No</th>
                                <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 2px 5px; font-size: 14px; width: 150px; vertical-align: middle; height: 30px;">Date</th>
                                <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 2px 5px; font-size: 14px; width: 200px; vertical-align: middle; height: 30px;">Creator Name</th>
                                <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 2px 5px; font-size: 14px; vertical-align: middle; height: 30px; width: 500px;">Action</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php
                                $index = 1;
                                if(!empty($daily_report_list)) {
                                    foreach($daily_report_list as $report) {
                                        $created_date_time = ""; $creator_name = ""; $action = "";
                                        if(!empty($report)) {
                                            foreach($report as $log_key => $data) {
                                                if(!empty($log_key) && $log_key == 1) {
                                                    $created_date_time = $data;
                                                }
                                                if(!empty($log_key) && $log_key == 3) {
                                                    $creator_name = $data;
                                                }
                                                if(!empty($log_key) && $log_key == 6) {
                                                    $action = $data;
                                                }
                                            }
                                        }
                                        if($creator_name == "creator_name") { continue; }
                        ?>
                                        <tr>
                                            <td style="border: 1px solid #000; text-align: center; padding: 1px; font-size: 12px; vertical-align: middle;">
                                                <?php if(!empty($index)) { echo $index; } ?>
                                            </td>
                                            <td style="border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 1px; font-size: 12px; vertical-align: middle;">
                                                <?php 
                                                    if(!empty($created_date_time) && $created_date_time != $GLOBALS['default_date_time']) { 
                                                        echo date("d-m-Y", strtotime($created_date_time))."<br>".date("h:i:s A", strtotime($created_date_time)); 
                                                    } 
                                                ?>
                                            </td>
                                            <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; text-align: center; padding: 3px 10px; font-size: 13px; vertical-align: middle;">
                                                <?php
                                                    if(!empty($creator_name)) {
                                                        $creator_name = $obj->encode_decode('decrypt', $creator_name);
                                                        echo $creator_name;
                                                    }
                                                ?>
                                            </td>
                                            <td style="border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 3px 10px; font-size: 13px; vertical-align: middle; white-space: inherit;">
                                                <?php
                                                    if(!empty($action)) {
                                                        $action = $obj->encode_decode('decrypt', $action);
                                                        echo $action;
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                            <?php    
                                        $index = $index + 1;            
                                    }
                                }
                            ?>
                        </tbody>
                    </table>   
                <?php 
                    }
                    else {
                ?>
                    <div class="w-100 text-center mb-3">
                        No Records Found
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
<?php include "footer.php"; ?>
<script type="text/javascript">
    function getReport() {
        if(jQuery('form[name="report_form"]').length > 0) {
            jQuery('form[name="report_form"]').submit();
        }
    } 
</script>