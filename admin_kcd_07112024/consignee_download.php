<?php
    include("include.php");
?>
<script type="text/javascript" src="include/js/xlsx.full.min.js"></script>

<table id="tbl_consignee_list" class="data-table table nowrap tablefont" style="margin:auto; display:none;">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center; width: 50px;">S.No</th>
            <th style="text-align: center; width: 500px;">Party Name</th>
            <th style="text-align: center; width: 500px;">Party Number</th>
            <th style="text-align: center; width: 500px;">Party Identification</th>
            <th style="text-align: center; width: 500px;">Address</th>
            <th style="text-align: center; width: 500px;">State</th> 
            <th style="text-align: center; width: 500px;">District</th> 
            <th style="text-align: center; width: 500px;">City</th>    
        </tr>
    </thead>
    <tbody>
        <?php 
            $total_records_list = array();
            $total_records_list = $obj->getTableRecords($GLOBALS['consignee_table'], '', '', '');

            $search_text = "";
            if(isset($_REQUEST['search_text'])) {
                $search_text = $_REQUEST['search_text'];
            }

            if(!empty($search_text)) {
                $search_text = strtolower($search_text);
                $list = array();
                if(!empty($total_records_list)) {
                    foreach($total_records_list as $val) {
                        if(strpos(strtolower($obj->encode_decode('decrypt', $val['name_mobile_city'])), $search_text) !== false) {
                            $list[] = $val;
                        }
                    }
                }
                $total_records_list = $list;
            }

            $show_records_list = array();
            if(!empty($total_records_list)) {
                foreach($total_records_list as $key => $val) {
                    $show_records_list[] = $val;
                }
            }

            if(!empty($show_records_list)) {
                foreach($show_records_list as $key => $data) {
                    $index = $key + 1;
                    if(!empty($prefix)) { $index = $index + $prefix; } 
        ?>
                    <tr>
                        <td class="text-center"><?php echo $index; ?></td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['name'])) {
                                    $data['name'] = $obj->encode_decode('decrypt', $data['name']);
                                    echo $data['name'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['mobile_number'])) {
                                    $data['mobile_number'] = $obj->encode_decode('decrypt', $data['mobile_number']);
                                    echo $data['mobile_number'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['identification']) && $data['identification'] != $GLOBALS['null_value']) {
                                    $data['identification'] = $obj->encode_decode('decrypt', $data['identification']);
                                    echo $data['identification'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['address']) && $data['address'] != $GLOBALS['null_value']) {
                                    $data['address'] = $obj->encode_decode('decrypt', $data['address']);
                                    echo html_entity_decode($data['address']);
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['state'])) {
                                    $data['state'] = $obj->encode_decode('decrypt', $data['state']);
                                    echo $data['state'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['district'])) {
                                    $data['district'] = $obj->encode_decode('decrypt', $data['district']);
                                    echo $data['district'];
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                                if(!empty($data['city']) && $data['city'] != $GLOBALS['null_value']) {
                                    $data['city'] = $obj->encode_decode('decrypt', $data['city']);
                                    echo $data['city'];
                                }
                            ?>
                        </td>
                    </tr>
        <?php 
                }
            }
        ?>
    </tbody>
</table>

<script>
    ExportToExcel('xlsx');
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_consignee_list');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || ('consignee_list.' + (type || 'xlsx')));
    }
    window.open("consignee.php","_self");
</script>