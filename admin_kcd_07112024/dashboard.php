<?php 
	$page_title = "Dashboard";
	include("include_user_check.php");

    $unacknowledged_tripsheet_list = array();
    $unacknowledged_tripsheet_list = $obj->getUnAcknowledgedTripsheetList();
?>
<?php include "header.php"; ?>
<!-- Start right Content here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 pb-4">
                    <div class="border card-box mt-4" id="table_records_cover">
                        <div class="card-header bg-light align-items-center">
                            <div class="row p-2">
                                <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                    <div class="h5">Tripsheet Approval</div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive dash-tble">
                            <table class="table nowrap cursor text-center smallfnt">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Tripsheet No</th>
                                        <th>LR Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(!empty($unacknowledged_tripsheet_list)) {
                                            foreach($unacknowledged_tripsheet_list as $key => $data) {
                                                if(!empty($data['tripsheet_id'])) {
                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $key + 1; ?>
                                                        </td>
                                                        <th>
                                                            <?php
                                                                if(!empty($data['tripsheet_date']) && $data['tripsheet_date'] != "0000-00-00") {
                                                                    echo date("d-m-Y", strtotime($data['tripsheet_date']));
                                                                }  
                                                            ?>
                                                        </th>
                                                        <th>
                                                            <?php if(!empty($data['tripsheet_number'])) { echo $data['tripsheet_number']; } ?>
                                                        </th>
                                                        <th><?php if(!empty($data['lr_count'])) { echo $data['lr_count']; } ?></th>
                                                        <td>
                                                            <a class="pe-2 text-dark" href="Javascript:ShowAcknowledgedModal('<?php if(!empty($data['tripsheet_number'])) { echo $data['tripsheet_number']; } ?>');">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                        }
                                        else {
                                    ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Sorry! No Records Found</td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>    
                    </div>    
                </div> 
                <div class="col-6 pb-4">
                    <div class="border card-box mt-4" id="table_records_cover">
                        <div class="card-header bg-light align-items-center">
                            <div class="row p-2">
                                <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                    <div class="h5">Booking Status</div>
                                </div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div id="line_chart_zoomable" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div> 
                <div class="col-6 pb-4">
                    <div class="border card-box">
                        <div class="card-header bg-light align-items-center">
                            <div class="row p-2">
                                <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                    <div class="h5">OVERALL LR REPORT</div>
                                </div>
                            </div>
                        </div>    
                        <div class="py-3">
                            <canvas id="doughnut" class="chartjs-chart" data-colors='["--vz-primary", "--vz-light"]'></canvas>
                        </div>
                    </div> 
                </div> 
                <div class="col-6 pb-4">
                    <div class="border card-box">
                        <div class="card-header bg-light align-items-center">
                            <div class="row p-2">
                                <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                    <div class="h5">SMS COUNT LEFT</div>
                                </div>
                            </div>
                        </div>    
                        <div class="py-3">
                        <div class="fu-progress">
                            <div class="fu-inner">
                                <div class="fu-percent percent"><span>80</span>%</div>
                                <div class="water"></div>
                                <div class="glare"></div>
                            </div>
                        </div>
                        </div>
                    </div>  
                </div> 
            </div>
        </div>
    </div>
    <!-- End Page-content -->
<script type="text/javascript" src="include/js/common.js"></script>
<script type="text/javascript" src="include/js/action_changes.js"></script>
<script>
    'use strict';

    var animatePercentChange = function animatePercentChange (newPercent, elem) {
        elem = elem || $('.fu-percent span');
        const val = parseInt(elem.text(), 10);

        if(val !== parseInt(newPercent, 10)) {
            let diff = newPercent < val ? -1 : 1;
            elem.text(val + diff);
            setTimeout(animatePercentChange.bind(null, newPercent, elem), 50);
        }
    };

    $('.fu-progress').on('click', function () {
    const amount = Math.ceil((Math.random() * 100));
    const currentPercent = $('.fu-percent span').text();
    const waterAnimSpeed = (Math.abs(currentPercent - amount) / 50) * 10;
    const waterPercent = 100 - amount;
    animatePercentChange(amount);
    $('.water').css({
        top : waterPercent + '%'
    });
    });
</script>  
<script src="js/chart.min.js"></script>
<script src="js/chartjs.init.js"></script>
<script src="js/apexcharts.min.js"></script>
<script src="js/apexcharts-line.init.js"></script>  
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#dashboard").addClass("active");
    });
</script>  