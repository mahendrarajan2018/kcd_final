<?php
    include("include.php");

    if(isset($_REQUEST['from_branch_id'])) {
        $from_branch_id = $_REQUEST['from_branch_id'];
        $from_branch_id = trim($from_branch_id);

        $branch_list = array();
        $branch_list = $obj->getTableRecords($GLOBALS['branch_table'], '', '', '');
?>
        <div class="form-label-group in-border mb-0">
            <select name="to_branch_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:table_listing_records_filter();">
                <option value="">Select Branch</option>
                <?php
                    if(!empty($branch_list)) {
                        foreach($branch_list as $data) {
                            if(!empty($data['branch_id'])) {
                                if(!empty($from_branch_id) && $data['branch_id'] == $from_branch_id) { continue; }
                ?>
                                <option value="<?php echo $data['branch_id']; ?>">
                                    <?php 
                                        if(!empty($data['prefix_name_mobile'])){
                                            $data['prefix_name_mobile'] = $obj->encode_decode('decrypt', $data['prefix_name_mobile']);
                                            echo $data['prefix_name_mobile'];
                                        }
                                    ?>
                                </option>
                <?php
                            }
                        }
                    }
                ?>
            </select>
            <label>Select To Branch</label>
            <script>
                jQuery('select[name="to_branch_id"]').select2();
            </script>
        </div>
<?php
    }

?>