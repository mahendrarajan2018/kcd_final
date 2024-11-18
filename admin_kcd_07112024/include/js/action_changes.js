var number_regex = /^\d+$/;
var price_regex = /^(\d*\.)?\d+$/;
function check_decimal(check_number) {
	if(check_number != '' && check_number != 0) {				
		var decimal = ""; var numbers = "";
		numbers = check_number.toString().split('.');							
		if( typeof numbers[1] != 'undefined') {
			decimal = numbers[1];
		}
		if(decimal != "" && decimal != "00") {						
			if(decimal.length == 1) {
				decimal = decimal+'0';
				check_number = numbers[0]+'.'+decimal;
			}
			if(decimal.length > 2) {
				check_number = check_number.toFixed(2);
			}
		}
		else {
			check_number = numbers[0]+'.00';
		}
	}
	return check_number;
}

function ToggleGST(organization_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            if(jQuery('input[name="gst_option"]').length > 0) {
                jQuery('input[name="gst_option"]').prop('checked', false);
                jQuery('input[name="gst_option"]').val('0');
            }

            if(jQuery('select[name="tax_value"]').length > 0) {
                jQuery('select[name="tax_value"]').val('').trigger('change');
            }
            
            var post_url = "action_changes.php?gst_organization_id="+organization_id;
            jQuery.ajax({url: post_url, success: function (gst) {
                gst = jQuery.trim(gst);
                if(parseInt(gst) == 1) {
                    if(jQuery('input[name="gst_option"]').length > 0) {
                        jQuery('input[name="gst_option"]').prop('checked', true);
                        jQuery('input[name="gst_option"]').val('1');
                    }
                }
                CalTotal();
            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}

function ShowPartyDetails(party_type, party_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            if(jQuery('#'+party_type+'_name_mobile').length > 0) {
                jQuery('#'+party_type+'_name_mobile').html('');
            }
            if(jQuery('#'+party_type+'_details_cover').length > 0) {
                jQuery('#'+party_type+'_details_cover').html('');
            }
            
            var post_url = "action_changes.php?lr_party_type="+party_type+"&lr_party_id="+party_id;
            jQuery.ajax({url: post_url, success: function (result) {
                if(jQuery('#'+party_type+'_details_cover').length > 0) {
                    jQuery('#'+party_type+'_details_cover').html(result);
                }

                var post_url = "action_changes.php?lr_party_name_mobile_type="+party_type+"&lr_party_name_mobile_id="+party_id;
                jQuery.ajax({url: post_url, success: function (result) {
                    if(jQuery('#'+party_type+'_name_mobile').length > 0) {
                        jQuery('#'+party_type+'_name_mobile').html(result);
                    }
                    CalTotal();
                }});

            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}

function getFilterBranchToList(from_branch_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            if(jQuery('#branch_to_cover').length > 0) {
                jQuery('#branch_to_cover').html('');
            }
            
            var post_url = "action_changes.php?from_branch_id="+from_branch_id;
            jQuery.ajax({url: post_url, success: function (result) {
                if(jQuery('#branch_to_cover').length > 0) {
                    jQuery('#branch_to_cover').html(result);
                }
            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}

function AddLRRow() {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            if (jQuery('.add_row_button').length > 0) {
                jQuery('.add_row_button').attr('disabled', true);
            }
            
            var post_url = "action_changes.php?add_lr_row=1";
            jQuery.ajax({url: post_url, success: function (result) {
                if(jQuery('.lr_row_table').find('tbody').length > 0) {
                    jQuery('.lr_row_table').find('tbody').append(result);
                }

                if (jQuery('.add_row_button').length > 0) {
                    jQuery('.add_row_button').attr('disabled', false);
                }

                if(jQuery('.sno').length > 0) {
                    var sno = 1;
                    jQuery('.sno').each(function() {
                        jQuery(this).html(sno);
                        sno = parseInt(sno) + 1;
                    });
                }
                CalTotal();
            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}

function DeleteLRRow(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            jQuery(obj).parent().parent().remove();
            if(jQuery('.sno').length > 0) {
                var sno = 1;
                jQuery('.sno').each(function() {
                    jQuery(this).html(sno);
                    sno = parseInt(sno) + 1;
                });
            }    
            CalTotal();        
        }
        else {
            window.location.reload();
        }
	}});
}

function CalTotal() {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            var total_amount = 0;

            if(jQuery('.sub_total').length > 0) {
                jQuery('.sub_total').html('');
            }
            if(jQuery('.delivery_charges_value').length > 0) {
                jQuery('.delivery_charges_value').html('');
            }
            if(jQuery('.delivery_charges_total').length > 0) {
                jQuery('.delivery_charges_total').html('');
            }
            if(jQuery('.loading_charges_value').length > 0) {
                jQuery('.loading_charges_value').html('');
            }
            if(jQuery('.loading_charges_total').length > 0) {
                jQuery('.loading_charges_total').html('');
            }
            if(jQuery('.gst_row').length > 0) {
                jQuery('.gst_row').addClass('d-none');
            }
            if(jQuery('.cgst_row').length > 0) {
                jQuery('.cgst_row').addClass('d-none');
            }
            if(jQuery('.sgst_row').length > 0) {
                jQuery('.sgst_row').addClass('d-none');
            }
            if(jQuery('.igst_row').length > 0) {
                jQuery('.igst_row').addClass('d-none');
            }
            if(jQuery('.cgst').length > 0) {
                jQuery('.cgst').html('');
            }
            if(jQuery('.sgst').length > 0) {
                jQuery('.sgst').html('');
            }
            if(jQuery('.igst').length > 0) {
                jQuery('.igst').html('');
            }
            if(jQuery('.gst_total').length > 0) {
                jQuery('.gst_total').html('');
            }
            if(jQuery('.round_off').length > 0) {
                jQuery('.round_off').html('');
            }
            if(jQuery('.overall_total').length > 0) {
                jQuery('.overall_total').html('');
            }

            if(jQuery('.lr_row').length > 0) {
                jQuery('.lr_row').each(function() {
                    var quantity = ""; var weight = ""; var rate = ""; var freight = ""; var kooli_option = ""; var kooli_by_quantity = 0; var amount = "";

                    if(jQuery(this).find('.freight').length > 0) {
                        jQuery(this).find('.freight').html('');
                    }
                    if(jQuery(this).find('.kooli_by_quantity').length > 0) {
                        jQuery(this).find('.kooli_by_quantity').html('');
                    }
                    if(jQuery(this).find('.amount').length > 0) {
                        jQuery(this).find('.amount').html('');
                    }

                    if(jQuery(this).find('input[name="quantity[]"]').length > 0) {
                        quantity = jQuery(this).find('input[name="quantity[]"]').val();
                        quantity = jQuery.trim(quantity);                        
                        if(typeof quantity != "undefined" && quantity != null && quantity != "") {
                            if(number_regex.test(quantity) == true) {
                                //if(quantity.length <= 4) {
                                    kooli_option = quantity;
                                    if(jQuery(this).find('input[name="quantity[]"]').parent().parent().parent().find('.infos').length > 0) {
                                        jQuery(this).find('input[name="quantity[]"]').parent().parent().parent().find('.infos').remove();
                                    }
                                    if(jQuery(this).find('input[name="weight[]"]').length > 0) {
                                        jQuery(this).find('input[name="weight[]"]').attr('readonly', true);
                                    }

                                    if(jQuery(this).find('input[name="rate[]"]').length > 0) {
                                        rate = jQuery(this).find('input[name="rate[]"]').val();
                                        rate = jQuery.trim(rate);                        
                                        if(typeof rate != "undefined" && rate != null && rate != "") {
                                            if(price_regex.test(rate) == true) {
                                                /*if(rate.indexOf('.') != -1) {
                                                    var number_point = "";
                                                    number_point = rate.split('.');
                                                    if(number_point['0'].length <= 5 && number_point['1'].length <= 2) {
                                                        if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                        }
                                                        freight = parseFloat(quantity) * parseFloat(rate);
                                                        freight = check_decimal(freight);
                                                        if(jQuery(this).find('.freight').length > 0) {
                                                            jQuery(this).find('.freight').html(freight);
                                                        }
                                                    }
                                                    else {
                                                        jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                    }
                                                }
                                                else {
                                                    if(rate.length <= 5) {*/
                                                        if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                        }
                                                        freight = parseFloat(quantity) * parseFloat(rate);
                                                        freight = check_decimal(freight);
                                                        if(jQuery(this).find('.freight').length > 0) {
                                                            jQuery(this).find('.freight').html(freight);
                                                        }
                                                    /*}
                                                    else {
                                                        jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                    }
                                                }*/
                                            }
                                            else {
                                                jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate</span>'); 
                                            }
                                        }
                                    } 
                                /*}
                                else {
                                    jQuery(this).find('input[name="quantity[]"]').parent().parent().after('<span class="infos">Invalid Quantity. Max(9999)</span>');
                                }*/
                            }
                            else {
                                jQuery(this).find('input[name="quantity[]"]').parent().parent().after('<span class="infos">Invalid Quantity</span>');
                            }
                        }
                        else {
                            if(jQuery(this).find('input[name="weight[]"]').length > 0) {
                                jQuery(this).find('input[name="weight[]"]').attr('readonly', false);
                            }
                        }
                    }                    
                    
                    if(jQuery(this).find('input[name="weight[]"]').length > 0) {
                        weight = jQuery(this).find('input[name="weight[]"]').val();
                        weight = jQuery.trim(weight);                        
                        if(typeof weight != "undefined" && weight != null && weight != "") {
                            if(price_regex.test(weight) == true) {
                                if(weight.indexOf('.') != -1) {
                                    var number_point = "";
                                    number_point = weight.split('.');
                                    if(number_point['0'].length <= 5 && number_point['1'].length <= 2) {
                                        kooli_option = weight;
                                        if(jQuery(this).find('input[name="weight[]"]').parent().parent().parent().find('.infos').length > 0) {
                                            jQuery(this).find('input[name="weight[]"]').parent().parent().parent().find('.infos').remove();
                                        }
                                        if(jQuery(this).find('input[name="quantity[]"]').length > 0) {
                                            jQuery(this).find('input[name="quantity[]"]').attr('readonly', true);
                                        }
        
                                        if(jQuery(this).find('input[name="rate[]"]').length > 0) {
                                            rate = jQuery(this).find('input[name="rate[]"]').val();
                                            rate = jQuery.trim(rate);                        
                                            if(typeof rate != "undefined" && rate != null && rate != "") {
                                                if(price_regex.test(rate) == true) {
                                                    if(rate.indexOf('.') != -1) {
                                                        var number_point = "";
                                                        number_point = rate.split('.');
                                                        if(number_point['0'].length <= 5 && number_point['1'].length <= 2) {
                                                            if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                                jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                            }
                                                            freight = parseFloat(weight) * parseFloat(rate);
                                                            freight = check_decimal(freight);
                                                            if(jQuery(this).find('.freight').length > 0) {
                                                                jQuery(this).find('.freight').html(freight);
                                                            }
                                                        }
                                                        else {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                        }
                                                    }
                                                    else {
                                                        if(rate.length <= 5) {
                                                            if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                                jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                            }
                                                            freight = parseFloat(weight) * parseFloat(rate);
                                                            freight = check_decimal(freight);
                                                            if(jQuery(this).find('.freight').length > 0) {
                                                                jQuery(this).find('.freight').html(freight);
                                                            }
                                                        }
                                                        else {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                        }
                                                    }
                                                }
                                                else {
                                                    jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate</span>'); 
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        jQuery(this).find('input[name="weight[]"]').parent().parent().after('<span class="infos">Invalid Weight. Format(99999.99)</span>');
                                    }
                                }
                                else {
                                    if(weight.length <= 5) {
                                        kooli_option = weight;
                                        if(jQuery(this).find('input[name="weight[]"]').parent().parent().parent().find('.infos').length > 0) {
                                            jQuery(this).find('input[name="weight[]"]').parent().parent().parent().find('.infos').remove();
                                        }
                                        if(jQuery(this).find('input[name="quantity[]"]').length > 0) {
                                            jQuery(this).find('input[name="quantity[]"]').attr('readonly', true);
                                        }
        
                                        if(jQuery(this).find('input[name="rate[]"]').length > 0) {
                                            rate = jQuery(this).find('input[name="rate[]"]').val();
                                            rate = jQuery.trim(rate);                        
                                            if(typeof rate != "undefined" && rate != null && rate != "") {
                                                if(price_regex.test(rate) == true) {
                                                    if(rate.indexOf('.') != -1) {
                                                        var number_point = "";
                                                        number_point = rate.split('.');
                                                        if(number_point['0'].length <= 5 && number_point['1'].length <= 2) {
                                                            if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                                jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                            }
                                                            freight = parseFloat(weight) * parseFloat(rate);
                                                            freight = check_decimal(freight);
                                                            if(jQuery(this).find('.freight').length > 0) {
                                                                jQuery(this).find('.freight').html(freight);
                                                            }
                                                        }
                                                        else {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                        }
                                                    }
                                                    else {
                                                        if(rate.length <= 5) {
                                                            if(jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').length > 0) {
                                                                jQuery(this).find('input[name="rate[]"]').parent().parent().parent().find('.infos').remove();
                                                            }
                                                            freight = parseFloat(weight) * parseFloat(rate);
                                                            freight = check_decimal(freight);
                                                            if(jQuery(this).find('.freight').length > 0) {
                                                                jQuery(this).find('.freight').html(freight);
                                                            }
                                                        }
                                                        else {
                                                            jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate. Format(99999.99)</span>');
                                                        }
                                                    }
                                                }
                                                else {
                                                    jQuery(this).find('input[name="rate[]"]').parent().parent().after('<span class="infos">Invalid Rate</span>'); 
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        jQuery(this).find('input[name="weight[]"]').parent().parent().after('<span class="infos">Invalid Weight. Format(99999.99)</span>');
                                    }
                                }

                            }
                            else {
                                jQuery(this).find('input[name="weight[]"]').parent().parent().after('<span class="infos">Invalid Weight</span>');
                            }
                        }
                        else {
                            if(jQuery(this).find('input[name="quantity[]"]').length > 0) {
                                jQuery(this).find('input[name="quantity[]"]').attr('readonly', false);
                            }
                        }
                    }

                    if(price_regex.test(freight) == true) {
                        var kooli = "";
                        if(jQuery(this).find('input[name="kooli[]"]').length > 0) {
                            kooli = jQuery(this).find('input[name="kooli[]"]').val();
                            kooli = jQuery.trim(kooli);
                            if(typeof kooli != "undefined" && kooli != null && kooli != "") {
                                //console.log('kooli_option - '+kooli_option+", kooli - "+kooli);
                                if(price_regex.test(kooli_option) == true && price_regex.test(kooli) == true) {
                                    if(jQuery(this).find('input[name="kooli[]"]').parent().parent().parent().find('.infos').length > 0) {
                                        jQuery(this).find('input[name="kooli[]"]').parent().parent().parent().find('.infos').remove();
                                    }
                                    kooli_by_quantity = parseFloat(kooli_option) * parseFloat(kooli);
                                    kooli_by_quantity = check_decimal(kooli_by_quantity);
                                    if(jQuery(this).find('.kooli_by_quantity').length > 0) {
                                        jQuery(this).find('.kooli_by_quantity').html(kooli_by_quantity);
                                    }
                                }
                                else {
                                    jQuery(this).find('input[name="kooli[]"]').parent().parent().after('<span class="infos">Invalid Kooli</span>'); 
                                }
                            }
                        }
                        amount = parseFloat(freight) + parseFloat(kooli_by_quantity);
                        if(jQuery(this).find('.amount').length > 0) {
                            jQuery(this).find('.amount').html(amount);
                        }
                        if(price_regex.test(amount) == true) {
                            total_amount = parseFloat(total_amount) + parseFloat(amount);
                        }
                    }

                });

                //console.log('total_amount 1 - '+total_amount);
                if(jQuery('.sub_total').length > 0) {
                    jQuery('.sub_total').html(total_amount);
                }

                if(jQuery('input[name="delivery_charges"]').length > 0) {
                    var delivery_charges = ""; var delivery_charges_value = "";
                    delivery_charges = jQuery('input[name="delivery_charges"]').val();
                    delivery_charges = jQuery.trim(delivery_charges);
                    if(typeof delivery_charges != "undefined" && delivery_charges != null && delivery_charges != "") {
                        if(jQuery('input[name="delivery_charges"]').parent().parent().find('.infos').length > 0) {
                            jQuery('input[name="delivery_charges"]').parent().parent().find('.infos').remove();
                        }
                        if(delivery_charges.indexOf('%') != -1) {
                            delivery_charges = delivery_charges.replace("%", "");
                            delivery_charges = jQuery.trim(delivery_charges);    
                            if(parseFloat(delivery_charges) <= 99) {
                                delivery_charges_value = (parseFloat(total_amount) * parseFloat(delivery_charges)) / 100;
                                delivery_charges_value = check_decimal(delivery_charges_value);
                            }
                            else {
                                jQuery('input[name="delivery_charges"]').parent().parent().append('<span class="infos">Max.99%</span>');
                            }
                        }
                        else {
                            if(price_regex.test(delivery_charges) == true) {
                                delivery_charges_value = delivery_charges;
                            }
                        }
                        //console.log('delivery_charges_value - '+delivery_charges_value);
                        if(price_regex.test(delivery_charges_value) == true) {
                            if(jQuery('.delivery_charges_value').length > 0) {
                                jQuery('.delivery_charges_value').html(delivery_charges_value);
                                total_amount = parseFloat(total_amount) + parseFloat(delivery_charges_value);
                            }
                        }
                    }
                }

                //console.log('total_amount 2 - '+total_amount);
                if(jQuery('.delivery_charges_total').length > 0) {
                    jQuery('.delivery_charges_total').html(total_amount);
                }

                if(jQuery('input[name="loading_charges"]').length > 0) {
                    var loading_charges = ""; var loading_charges_value = "";
                    loading_charges = jQuery('input[name="loading_charges"]').val();
                    loading_charges = jQuery.trim(loading_charges);
                    if(typeof loading_charges != "undefined" && loading_charges != null && loading_charges != "") {
                        if(jQuery('input[name="loading_charges"]').parent().parent().find('.infos').length > 0) {
                            jQuery('input[name="loading_charges"]').parent().parent().find('.infos').remove();
                        }
                        if(loading_charges.indexOf('%') != -1) {
                            loading_charges = loading_charges.replace("%", "");
                            loading_charges = jQuery.trim(loading_charges);
    
                            if(parseFloat(loading_charges) <= 99) {
                                loading_charges_value = (parseFloat(total_amount) * parseFloat(loading_charges)) / 100;
                                loading_charges_value = check_decimal(loading_charges_value);
                            }
                            else {
                                jQuery('input[name="loading_charges"]').parent().parent().append('<span class="infos">Max.99%</span>');
                            }
                        }
                        else {
                            if(price_regex.test(loading_charges) == true) {
                                loading_charges_value = loading_charges;
                            }
                        }
                        //console.log('loading_charges_value - '+loading_charges_value);
                        if(price_regex.test(loading_charges_value) == true) {
                            if(jQuery('.loading_charges_value').length > 0) {
                                jQuery('.loading_charges_value').html(loading_charges_value);
                                total_amount = parseFloat(total_amount) + parseFloat(loading_charges_value);
                            }
                        }
                    }
                }

                //console.log('total_amount 3 - '+total_amount);
                if(jQuery('.loading_charges_total').length > 0) {
                    jQuery('.loading_charges_total').html(total_amount);
                }

                if(jQuery('input[name="gst_option"]').length > 0) {
                    var gst_option = "";
                    gst_option = jQuery('input[name="gst_option"]').val();
                    gst_option = jQuery.trim(gst_option);
                    if(parseInt(gst_option) == 1) {
                        var consignor_state = "";
                        if(jQuery('select[name="consignor_state"]').length > 0) {
                            consignor_state = jQuery('select[name="consignor_state"]').val();;
                            consignor_state = jQuery.trim(consignor_state);
                        }
                        if(typeof consignor_state != "undefined" && consignor_state != null && consignor_state != "") {
                            var consignee_state = "";
                            if(jQuery('select[name="consignee_state"]').length > 0) {
                                consignee_state = jQuery('select[name="consignee_state"]').val();;
                                consignee_state = jQuery.trim(consignee_state);
                            }
                            if(typeof consignee_state != "undefined" && consignee_state != null && consignee_state != "") {

                                var tax_value = ""; var gst = ""; var cgst = ""; var sgst = ""; var igst = "";
                                if(jQuery('select[name="tax_value"]').length > 0) {
                                    tax_value = jQuery('select[name="tax_value"]').val();
                                    tax_value = jQuery.trim(tax_value);
                                }
                                if(typeof tax_value != "undefined" && tax_value != null && tax_value != "") {
                                    var tax_value_options = new Array('0%', '5%', '12%', '18%', '28%');
                                    if(jQuery.inArray(tax_value, tax_value_options) !== -1) {
                                        tax_value = tax_value.replace('%', '');
                                        tax_value = jQuery.trim(tax_value);
                                        if(parseInt(tax_value) > 0 && price_regex.test(total_amount) == true) {
                                            gst = (parseFloat(total_amount) * parseInt(tax_value)) / 100;
                                            gst = check_decimal(gst);
                                            if(price_regex.test(gst) == true) {
                                                total_amount = parseFloat(total_amount) + parseFloat(gst);
                                                if(jQuery('.gst_row').length > 0) {
                                                    jQuery('.gst_row').removeClass('d-none');
                                                }
                                                if(consignor_state == consignee_state) {
                                                    gst = parseFloat(gst) / 2;
                                                    gst = check_decimal(gst);
                                                    if(jQuery('.cgst').length > 0) {
                                                        jQuery('.cgst').html(gst);
                                                    }
                                                    if(jQuery('.sgst').length > 0) {
                                                        jQuery('.sgst').html(gst);
                                                    }
                                                    if(jQuery('.cgst_row').length > 0) {
                                                        jQuery('.cgst_row').removeClass('d-none');
                                                    }
                                                    if(jQuery('.sgst_row').length > 0) {
                                                        jQuery('.sgst_row').removeClass('d-none');
                                                    }
                                                }   
                                                else {
                                                    if(jQuery('.igst').length > 0) {
                                                        jQuery('.igst').html(gst);
                                                    }
                                                    if(jQuery('.igst_row').length > 0) {
                                                        jQuery('.igst_row').removeClass('d-none');
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }                             
                            }                            
                        }
                    }
                }

                total_amount = check_decimal(total_amount);
                //console.log('total_amount 4 - '+total_amount);
                if(jQuery('.gst_total').length > 0) {
                    jQuery('.gst_total').html(total_amount);
                }

                if(price_regex.test(total_amount) == true) {
                    var decimal = ""; var round_off = '';
                    var numbers = total_amount.toString().split('.');							
                    if( typeof numbers[1] != 'undefined') {
                        decimal = numbers[1];
                    }
                    if(decimal != "" && decimal != "00") {
                        if(decimal.length == 1) {
                            decimal = decimal+'0';
                        }
                        //console.log('decimal - '+decimal);
                        var round_off = 0;
                        if(parseFloat(decimal) >= 50) {
                            round_off = 100 - parseFloat(decimal);
                            if(round_off.toString().length == 1) {
                                round_off = "0.0"+round_off;
                            }
                            else {
                                round_off = "0."+round_off;
                            }
                            total_amount = parseFloat(total_amount) + parseFloat(round_off);
                            if(jQuery('.round_off').length > 0) {
                                jQuery('.round_off').html(round_off);
                            }
                        }
                        else { 
                            round_off = decimal;                        
                            if(round_off.toString().length == 1) {
                                round_off = "0.0"+round_off;
                            }
                            else {
                                round_off = "0."+round_off;
                            }
                            total_amount = parseFloat(total_amount) - parseFloat(round_off);
                            if(jQuery.find('.round_off').length > 0) {
                                jQuery('.round_off').html('-'+round_off);
                            }
                        }   
                    }
                }
                
                if(jQuery('.overall_total').length > 0) {
                    jQuery('.overall_total').html(total_amount);
                }
            }

        }
        else {
            window.location.reload();
        }
	}});
}

function getTripsheetLRNumberByBranch(branch_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            if(jQuery('#tripsheet_luggage_cover').length > 0) {
                jQuery('#tripsheet_luggage_cover').html('');
            }
            if(jQuery('#tripsheet_lr_cover').length > 0) {
                jQuery('#tripsheet_lr_cover').html('');
            }

            if(jQuery('input[name="tripsheet_branch_id"]').length > 0) {
                jQuery('input[name="tripsheet_branch_id"]').val(branch_id);
            }
            
            var post_url = "action_changes.php?tripsheet_luggage_branch_id="+branch_id;
            jQuery.ajax({url: post_url, success: function (result) {
                result = jQuery.trim(result);
                if(jQuery('#tripsheet_luggage_cover').length > 0) {
                    jQuery('#tripsheet_luggage_cover').html(result);
                }

                var post_url = "action_changes.php?tripsheet_lr_branch_id="+branch_id;
                jQuery.ajax({url: post_url, success: function (result) {
                    result = jQuery.trim(result);
                    if(jQuery('#tripsheet_lr_cover').length > 0) {
                        jQuery('#tripsheet_lr_cover').html(result);
                    }
                }});

            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}

function AddTripsheetRow() {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            if (jQuery('.add_tripsheet_button').length > 0) {
                jQuery('.add_tripsheet_button').each(function() {
                    jQuery(this).attr('disabled', true);
                });
            }

            var tripsheet_lr_number = ""; var tripsheet_luggage_sheet_number = "";
            if(jQuery('select[name="tripsheet_lr_number"]').length > 0) {
                tripsheet_lr_number = jQuery('select[name="tripsheet_lr_number"]').val();
                tripsheet_lr_number = jQuery.trim(tripsheet_lr_number);
            }
            if(jQuery('select[name="tripsheet_luggage_sheet_number"]').length > 0) {
                tripsheet_luggage_sheet_number = jQuery('select[name="tripsheet_luggage_sheet_number"]').val();
                tripsheet_luggage_sheet_number = jQuery.trim(tripsheet_luggage_sheet_number);
            }

            var add_tripsheet_row = 2;
            if(typeof tripsheet_lr_number != "undefined" && tripsheet_lr_number != null && tripsheet_lr_number != "") {
                add_tripsheet_row = 1;
            }
            else if(typeof tripsheet_luggage_sheet_number != "undefined" && tripsheet_luggage_sheet_number != null && tripsheet_luggage_sheet_number != "") {
                add_tripsheet_row = 1;
            }

            if(jQuery('.tripsheet_row_table').parent().find('.infos').length > 0) {
                jQuery('.tripsheet_row_table').parent().find('.infos').remove();
            }

            if(parseInt(add_tripsheet_row) == 1) {        
                if(jQuery('select[name="branch_id"]').length > 0) {
                    jQuery('select[name="branch_id"]').attr('disabled', true);
                }   

                var post_url = "action_changes.php?add_tripsheet_lr_number="+tripsheet_lr_number+"&add_tripsheet_luggage_sheet_number="+tripsheet_luggage_sheet_number;
                jQuery.ajax({url: post_url, success: function (result) {
                    if(jQuery('.tripsheet_row_table').find('tbody').length > 0) {
                        jQuery('.tripsheet_row_table').find('tbody').append(result);
                    }

                    if(jQuery('select[name="tripsheet_lr_number"]').length > 0) {
                        jQuery('select[name="tripsheet_lr_number"]').val('').trigger('change');
                    }
                    if(jQuery('select[name="tripsheet_luggage_sheet_number"]').length > 0) {
                        jQuery('select[name="tripsheet_luggage_sheet_number"]').val('').trigger('change');
                    }

                    if (jQuery('.add_tripsheet_button').length > 0) {
                        jQuery('.add_tripsheet_button').each(function() {
                            jQuery(this).attr('disabled', false);
                        });
                    }

                    if(jQuery('.sno').length > 0) {
                        var sno = 1;
                        jQuery('.sno').each(function() {
                            jQuery(this).html(sno);
                            sno = parseInt(sno) + 1;
                        });
                    }
                }});
            }
            else {
                jQuery('.tripsheet_row_table').before('<span class="infos">Select the Luggage or LR Number</span>');
            }    
            
        }
        else {
            window.location.reload();
        }
	}});
}

function DeleteTripsheetRow(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            jQuery(obj).parent().parent().remove();
            if(jQuery('.sno').length > 0) {
                var sno = 1;
                jQuery('.sno').each(function() {
                    jQuery(this).html(sno);
                    sno = parseInt(sno) + 1;
                });
            }
            if(jQuery('.tripsheet_row').length == 0) {
                if(jQuery('select[name="branch_id"]').length > 0) {
                    jQuery('select[name="branch_id"]').attr('disabled', false);
                }
            }
        }
        else {
            window.location.reload();
        }
	}});
}

function ShowAcknowledgedModal(tripsheet_number) {
    var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            if(jQuery('#AcknowledgementModal').find('.modal-body').length > 0) {
                jQuery('#AcknowledgementModal').find('.modal-body').html('');
            }            
            var post_url = "tripsheet_changes.php?acknowledge_tripsheet_number="+tripsheet_number;
            jQuery.ajax({url: post_url, success: function (result) {
                result = jQuery.trim(result);
                if(jQuery('#AcknowledgementModal').find('.modal-body').length > 0) {
                    jQuery('#AcknowledgementModal').find('.modal-body').html(result);
                }

                if(jQuery('.acknowledgement_modal_button').length > 0) {
                    jQuery('.acknowledgement_modal_button').trigger('click');
                }

            }});
        }
        else {
            window.location.reload();
        }
	}});
}

function ViewInvoiceAcknowledgement() {
    if(jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').length > 0) {
        jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').html('');
    }
    if(jQuery('input[name="acknowledge_tripsheet_number"]').length > 0) {
        jQuery('input[name="acknowledge_tripsheet_number"]').val('');
    }
    if(jQuery('.invoice_acknowledgement_button').length > 0) {
        jQuery('.invoice_acknowledgement_button').trigger('click');
    }
}

function ShowInvoiceAcknowledgedModal() {
    var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            if(jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').length > 0) {
                jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').html('');
            }            

            var tripsheet_number = "";
            if(jQuery('input[name="acknowledge_tripsheet_number"]').length > 0) {
                tripsheet_number = jQuery('input[name="acknowledge_tripsheet_number"]').val();
                tripsheet_number = jQuery.trim(tripsheet_number);
            }

            var post_url = "tripsheet_changes.php?acknowledge_tripsheet_number="+tripsheet_number;
            jQuery.ajax({url: post_url, success: function (result) {
                result = jQuery.trim(result);
                if(jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').length > 0) {
                    jQuery('#invoiceAcknowledgementModal').find('.tripsheet_details').html(result);
                }
            }});
        }
        else {
            window.location.reload();
        }
	}});
}

function ShowClearanceModal(lr_number) {
    var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            if(jQuery('#clearancemodal').find('.modal-body').length > 0) {
                jQuery('#clearancemodal').find('.modal-body').html('');
            }            
            var post_url = "unclearance_entry_changes.php?clearance_lr_number="+lr_number;
            jQuery.ajax({url: post_url, success: function (result) {
                result = jQuery.trim(result);
                if(jQuery('#clearancemodal').find('.modal-body').length > 0) {
                    jQuery('#clearancemodal').find('.modal-body').html(result);
                }

                if(jQuery('.clearance_modal_button').length > 0) {
                    jQuery('.clearance_modal_button').trigger('click');
                }

            }});
        }
        else {
            window.location.reload();
        }
	}});
}

function ToggleReceiver() {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {
            var toggle_value = 2;
            if (jQuery('#receiver_same_consignee').length > 0) {
                if (jQuery('#receiver_same_consignee').prop('checked') == true) {
                    toggle_value = 1;
                }
                jQuery('#receiver_same_consignee').val(toggle_value);
            }
            if(jQuery('.receiver_details').length > 0) {
                jQuery('.receiver_details').html('');
            }
            var lr_number = "";
            if(jQuery('select[name="update_clearance_lr_number"]').length > 0) {
                lr_number = jQuery('select[name="update_clearance_lr_number"]').val();
                lr_number = jQuery.trim(lr_number);
            }
            var post_url = "unclearance_entry_changes.php?clearance_consignee_details_lr_number="+lr_number+"&receiver_same_consignee="+toggle_value;
            jQuery.ajax({url: post_url, success: function (result) {
                result = jQuery.trim(result);
                if(jQuery('.receiver_details').length > 0) {
                    jQuery('.receiver_details').html(result);
                }
            }});            
        }
        else {
            window.location.reload();
        }
	}});
}