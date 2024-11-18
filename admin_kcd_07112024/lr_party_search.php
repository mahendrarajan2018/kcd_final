<?php
    if(!empty($party_type)) {
        $party_list = array(); $party_name = ""; $party_mobile_number = ""; $party_state = "Tamil Nadu"; $party_district = ""; $party_city = "";
        if($party_type == "consignor") {
            $party_list = $obj->getTableRecords($GLOBALS['consignor_table'], '', '','');
            $consignor_list = array();
            if(!empty($party_id)) {
                $consignor_list = $obj->getTableRecords($GLOBALS['consignor_table'], 'consignor_id', $party_id,'');
            }
            if(!empty($consignor_list)) {
                foreach($consignor_list as $data) {
                    if(!empty($data['name'])) {
                        $party_name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['state'])) {
                        $party_state = $obj->encode_decode('decrypt', $data['state']);
                    }
                    if(!empty($data['district'])) {
                        $party_district = $obj->encode_decode('decrypt', $data['district']);
                    }
                    if(!empty($data['city'])) {
                        $party_city = $obj->encode_decode('decrypt', $data['city']);
                    }
                }
            }
        }
        else if($party_type == "consignee") {
            $party_list = $obj->getTableRecords($GLOBALS['consignee_table'], '', '','');
            $consigee_list = array();
            if(!empty($party_id)) {
                $consigee_list = $obj->getTableRecords($GLOBALS['consignee_table'], 'consignee_id', $party_id,'');
            }
            if(!empty($consigee_list)) {
                foreach($consigee_list as $data) {
                    if(!empty($data['name'])) {
                        $party_name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['state'])) {
                        $party_state = $obj->encode_decode('decrypt', $data['state']);
                    }
                    if(!empty($data['district'])) {
                        $party_district = $obj->encode_decode('decrypt', $data['district']);
                    }
                    if(!empty($data['city'])) {
                        $party_city = $obj->encode_decode('decrypt', $data['city']);
                    }
                }
            }
        }
        else if($party_type == "account_party") {
            $party_list = $obj->getTableRecords($GLOBALS['account_party_table'], '', '','');
            $account_party_list = array();
            if(!empty($party_id)) {
                $account_party_list = $obj->getTableRecords($GLOBALS['account_party_table'], 'account_party_id', $party_id,'');
            }
            if(!empty($account_party_list)) {
                foreach($account_party_list as $data) {
                    if(!empty($data['name'])) {
                        $party_name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['mobile_number'])) {
                        $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['state'])) {
                        $party_state = $obj->encode_decode('decrypt', $data['state']);
                    }
                    if(!empty($data['district'])) {
                        $party_district = $obj->encode_decode('decrypt', $data['district']);
                    }
                    if(!empty($data['city'])) {
                        $party_city = $obj->encode_decode('decrypt', $data['city']);
                    }
                }
            }
        }
?>
    <div class="row">
        <div class="col-lg-12 pb-1">
            <div class="form-group mb-1">
                <div class="form-label-group in-border pb-1">
                    <input type="text" name="<?php echo $party_type."_name"; ?>" id="<?php echo $party_type."_search"; ?>" class="form-control shadow-none" value="<?php if(!empty($party_name)) { echo $party_name; } ?>" onkeyup="Javascript:search_filter('<?php echo $party_type; ?>');">
                    <label><?php echo ucfirst(str_replace("_", " ", $party_type)); ?> Name <?php if($party_type != "account_party") { ?> <span class="text-danger">*</span> <?php } ?> </label>
                </div>
                <div id="search_list_cover" class="w-100">
                    <ul id="<?php echo $party_type."_list"; ?>" class="w-100 px-0 my-0 search_list" style="display: none;">
                        <?php
                            if(!empty($party_list)) {
                                foreach($party_list as $data) {
                                    $party_id = $party_type."_id";
                                    if(!empty($data[$party_id])) {
                        ?>
                                        <li>
                                            <a href="<?php echo $data[$party_id]; ?>" class="text-dark">
                                                <?php 
                                                    if(!empty($data['name_mobile_city'])){
                                                        $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                        echo $data['name_mobile_city'];
                                                    }
                                                ?>                                                
                                            </a>
                                        </li>
                        <?php
                                    }                                    
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group mb-1">
                <div class="form-label-group in-border pb-1">
                    <input type="text" name="<?php echo $party_type."_mobile_number"; ?>" class="form-control shadow-none" value="<?php if(!empty($party_mobile_number)) { echo $party_mobile_number; } ?>">
                    <label><?php echo ucfirst(str_replace("_", " ", $party_type)); ?> Contact Number <?php if($party_type != "account_party") { ?> <span class="text-danger">*</span> <?php } ?> </label>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group pb-1">
                <div class="form-label-group in-border mb-0">
                    <select name="<?php echo $party_type."_state"; ?>" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getLRPartyStates('<?php echo $form_name; ?>', <?php echo $party_type; ?>, this.value, '', '');">
                    </select>
                    <label>Select State <?php if($party_type != "account_party") { ?> <span class="text-danger">*</span> <?php } ?> </label>
                </div>
            </div> 
        </div>
        <div class="col-lg-12">
            <div class="form-group pb-1">
                <div class="form-label-group in-border mb-0">
                    <select name="<?php echo $party_type."_district"; ?>" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getLRPartyDistricts('<?php echo $form_name; ?>', <?php echo $party_type; ?>, this.value, '');">
                    </select>
                    <label>Select District</label>
                </div>
            </div> 
        </div>
        <div class="col-lg-12">
            <div class="form-group pb-1">
                <div class="form-label-group in-border mb-0">
                    <select name="<?php echo $party_type."_city"; ?>" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getLRPartyCities('<?php echo $form_name; ?>', '<?php echo $party_type; ?>', '', this.value);">
                    </select>
                    <label>Select City</label>
                </div>
            </div> 
        </div>
        <div class="col-lg-12 d-none" id="<?php echo $party_type."_others_city_cover"; ?>">
            <div class="form-group mb-1">
                <div class="form-label-group in-border pb-1">
                    <input type="text" name="<?php echo $party_type."_others_city"; ?>" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
                    <label><?php echo ucfirst($party_type); ?> Others City</label>
                </div>
                <div class="new_smallfnt">Text Only(Max Char: 30)</div>
            </div>
        </div>
    </div>
    <script>
        getLRPartyCountry('<?php echo $form_name; ?>', '<?php echo $party_type; ?>', 'India', '<?php if(!empty($party_state)) { echo $party_state; } ?>', '<?php if(!empty($party_district)) { echo $party_district; } ?>', '<?php if(!empty($party_city)) { echo $party_city; } ?>');
        jQuery('select[name="<?php echo $party_type."_state"; ?>"]').select2();
        jQuery('select[name="<?php echo $party_type."_district"; ?>"]').select2();
        jQuery('select[name="<?php echo $party_type."_city"; ?>"]').select2();

        jQuery(document).ready(function(){
            jQuery('input[name="<?php echo $party_type."_name"; ?>"]').on("keypress", function(e) {
                if (e.keyCode == 13) {
                    //console.log('search enter');
                    if(jQuery(".search_list li.active").length!=0) {
                        var party_id = "";
                        party_id = jQuery.trim(jQuery(".search_list li.active").find('a').attr('href'));
                    }
                    ShowPartyDetails('<?php echo $party_type; ?>', party_id);
                    return false;
                }
            });

            jQuery('input[name="<?php echo $party_type."_name"; ?>"]').keyup(function(e) {
                if(e.which == 38){
                    var storeTarget = jQuery('.search_list').find("li.active");

                    do {
                        storeTarget = storeTarget.prev();
                    } while (storeTarget.length && storeTarget.is(':hidden'));
                    
                    jQuery(".search_list li.active").removeClass("active");
                    storeTarget.focus().addClass("active");

                    return false;
                }
                if(e.which == 40){
                    if(jQuery(".search_list li.active").length!=0) {
                        if(jQuery('.search_list').find("li.active").nextAll('li:visible').length > 0) {
                            var storeTarget = jQuery('.search_list').find("li.active").nextAll('li:visible').first().focus();
                            jQuery(".search_list li.active").removeClass("active");
                            storeTarget.addClass("active");
                        }
                        else {
                            jQuery(".search_list li.active").removeClass("active");
                            jQuery('.search_list').find("li:visible").first().focus().addClass("active");
                        }
                    }
                    else {
                        jQuery('.search_list').find("li:visible").first().focus().addClass("active");
                    }
                    return false;
                }
            });
        });

        function search_filter(party_type) {
            var search_box_id = party_type+"_search";
            var search_party_list = party_type+"_list";
            var input, filter, ul, li, a, i, txtValue;
            //console.log('search_box_id - '+search_box_id);
            input = document.getElementById(search_box_id);
            filter = input.value.toString().toUpperCase();
            ul = document.getElementById(search_party_list);
            //console.log('filter - '+filter);
            if(filter != '') {                
                ul.style.display = '';
                li = ul.getElementsByTagName("li");
                var not_found = 0;
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("a")[0];
                    if (jQuery.trim(a.innerHTML).toString().toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                        ul.style.display = '';
                    }
                    else {
                        li[i].style.display = "none";
                        not_found = parseInt(not_found) + 1;
                    }
                }
                if(not_found == li.length) {
                    ul.style.display = 'none';
                }
            }
            else {
                ul.style.display = 'none';
            }    
        }
    </script>
<?php } ?>