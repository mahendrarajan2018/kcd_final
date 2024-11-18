<?php
    $total_pages;
    $total_pages = $obj->getLRListCount($filter_from_date, $filter_to_date, $filter_organization_id, $filter_lr_number, $filter_from_branch_id, $filter_to_branch_id, $filter_bill_type, $filter_consignor_id, $filter_consignee_id, $filter_account_party_id, $cancelled);
    
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
    $show_records_list = $obj->getLRList($filter_from_date, $filter_to_date, $filter_organization_id, $filter_lr_number, $filter_from_branch_id, $filter_to_branch_id, $filter_bill_type, $filter_consignor_id, $filter_consignee_id, $filter_account_party_id, $cancelled, $page_start, $page_end);
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
            <th>L.R.No / Date</th>
            <th>From</th>
            <th>To</th>
            <th>Consignor</th>
            <th>Consignee</th>
            <th>Amount</th>
            <th>Bill Type</th>
            <th>Tripsheet</th>
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
                                if(!empty($data['lr_number'])) {
                                    echo $data['lr_number'];
                                    if(!empty($data['lr_date']) && $data['lr_date'] != "0000-00-00") {
                                        echo "<br>".date("d-m-Y", strtotime($data['lr_date']));
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['from_branch_details'])) {
                                    $data['from_branch_details'] = $obj->encode_decode('decrypt', $data['from_branch_details']);
                                    echo $data['from_branch_details'];
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
                                if(!empty($data['to_branch_details'])) {
                                    $data['to_branch_details'] = $obj->encode_decode('decrypt', $data['to_branch_details']);
                                    echo $data['to_branch_details'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['consignor_name_mobile_city'])) {
                                    $data['consignor_name_mobile_city'] = $obj->encode_decode('decrypt', $data['consignor_name_mobile_city']);
                                    echo $data['consignor_name_mobile_city'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['consignee_name_mobile_city'])) {
                                    $data['consignee_name_mobile_city'] = $obj->encode_decode('decrypt', $data['consignee_name_mobile_city']);
                                    echo $data['consignee_name_mobile_city'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['total_amount'])) {
                                    echo $data['total_amount'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['bill_type'])) {
                                    $data['bill_type'] = $obj->encode_decode('decrypt', $data['bill_type']);
                                    echo $data['bill_type'];
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(!empty($data['tripsheet_number']) && $data['tripsheet_number'] != $GLOBALS['null_value']) {
                                    echo $data['tripsheet_number'];
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
                            <?php } else if(!empty($data['tripsheet_number']) && $data['tripsheet_number'] == $GLOBALS['null_value']) { ?>
                            <a class="pe-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['lr_id'])) { echo $data['lr_id']; } ?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a class="pe-2" href="Javascript:CancelModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($data['lr_id'])) { echo $data['lr_id']; } ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
        <?php 
                } 
            }  
            else {
        ?>
                <tr>
                    <td colspan="10" class="text-center">Sorry! No records found</td>
                </tr>
        <?php 
            } 
        ?>
    </tbody>
</table>