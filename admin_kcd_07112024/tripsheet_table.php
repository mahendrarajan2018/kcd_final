<?php
    $total_pages = 0;
    $total_pages = $obj->getTripsheetListCount($filter_from_date, $filter_to_date, $filter_vehicle_id, $filter_branch_id, $filter_tripsheet_number, $filter_lr_number, $cancelled);
    
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
    $show_records_list = $obj->getTripsheetList($filter_from_date, $filter_to_date, $filter_vehicle_id, $filter_branch_id, $filter_tripsheet_number, $filter_lr_number, $cancelled, $page_start, $page_end);
    /*if(!empty($total_records_list)) {
        foreach($total_records_list as $key => $val) {
            if($key >= $page_start && $key < $page_end) {
                $show_records_list[] = $val;
            }
        }
    }*/
    
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
            <th>#</th>
            <th>Trip Sheet .No / Date</th>
            <th>Vehicle</th>
            <th>Branch</th>
            <th>LR Count</th>
            <th>Driver</th>
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
                        <td><?php echo $index; ?></td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['tripsheet_number'])) {
                                    echo $data['tripsheet_number'];
                                    if(!empty($data['tripsheet_date']) && $data['tripsheet_date'] != "0000-00-00") {
                                        echo "<br>".date("d-m-Y", strtotime($data['tripsheet_date']));
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['vehicle_details'])) {
                                    $data['vehicle_details'] = $obj->encode_decode('decrypt', $data['vehicle_details']);
                                    echo $data['vehicle_details'];
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
                                if(!empty($data['branch_details'])) {
                                    $data['branch_details'] = $obj->encode_decode('decrypt', $data['branch_details']);
                                    echo $data['branch_details'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['lr_count'])) {
                                    echo $data['lr_count'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['driver_name'])) {
                                    $data['driver_name'] = $obj->encode_decode('decrypt', $data['driver_name']);
                                    echo $data['driver_name'];
                                    if(!empty($data['driver_contact_number'])) {
                                        $data['driver_contact_number'] = $obj->encode_decode('decrypt', $data['driver_contact_number']);
                                        echo " (".$data['driver_contact_number'].")";
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php if(!empty($data['cancelled']) && $data['cancelled'] == 1) { ?>
                                <?php
                                    if(!empty($data['cancel_remarks']) && $data['cancel_remarks'] != $GLOBALS['null_value']) {
                                        $data['cancel_remarks'] = $obj->encode_decode('decrypt', $data['cancel_remarks']);
                                        echo $data['cancel_remarks'];
                                    }
                                ?>
                            <?php } else if(empty($data['acknowledged'])) { ?>
                            <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['tripsheet_id'])) { echo $data['tripsheet_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a class="pe-2" href="Javascript:CancelModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['tripsheet_id'])) { echo $data['tripsheet_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
        <?php 
                } 
            }  
            else {
        ?>
                <tr>
                    <td colspan="7" class="text-center">Sorry! No records found</td>
                </tr>
        <?php 
            } 
        ?>
    </tbody>
</table>