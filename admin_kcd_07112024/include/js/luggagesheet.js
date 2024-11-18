var numbers_regex = /^\d+$/;

function getLocationAndLR(from_location, to_location) {
    if(from_location != "" && typeof from_location != "undefined") {
        var check_login_session = 1;
        var post_url = "dashboard_changes.php?check_login_session=1";
        jQuery.ajax({
            url: post_url, success: function (check_login_session) {
                if (check_login_session == 1) {
                    var post_url = "luggage_bill_changes.php?get_location_lr="+from_location;
                    jQuery.ajax({
                        url: post_url, success: function (result) {
                            result = jQuery.trim(result);
                            if(result != "" && typeof result != "undefined") {
                                result = result.split('$$$');
                                if(to_location == "") {
                                    if(jQuery('select[name="to_location"]').length > 0) {
                                        jQuery('select[name="to_location"]').html(result[0]);
                                    }
                                }
                                if(jQuery('select[name="selected_lr_id"]').length > 0) {
                                    jQuery('select[name="selected_lr_id"]').html(result[1]);
                                }
                            }
                        }
                    });
                }
                else {
                    window.location.reload();
                }
            }
        });
    }
}

function AddLR() {
    var check_login_session = 1; var all_errors_check = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('.infos').length > 0) {
					jQuery('.infos').each(function() { jQuery(this).remove(); });
				}

                var entry_date = "";
                if(jQuery('input[name="entry_date"]').length > 0) {
                    entry_date = jQuery('input[name="entry_date"]').val();
                    entry_date = jQuery.trim(entry_date);
                    if(entry_date == "" || typeof entry_date == "undefined") {
                        all_errors_check = 0;
                    }
                }

                var from_location = "";
                if(jQuery('select[name="from_location"]').length > 0) {
                    from_location = jQuery('select[name="from_location"]').val();
                    from_location = jQuery.trim(from_location);
                    if(from_location == "" || typeof from_location == "undefined") {
                        all_errors_check = 0;
                    }
                }

                var to_location = "";
                if(jQuery('select[name="to_location"]').length > 0) {
                    to_location = jQuery('select[name="to_location"]').val();
                    to_location = jQuery.trim(to_location);
                    if(to_location == "" || typeof to_location == "undefined") {
                        all_errors_check = 0;
                    }
                }

                var selected_lr_id = "";
                if(jQuery('select[name="selected_lr_id"]').length > 0) {
                    selected_lr_id = jQuery('select[name="selected_lr_id"]').val();
                    selected_lr_id = jQuery.trim(selected_lr_id);
                    if(selected_lr_id == "" || typeof selected_lr_id == "undefined") {
                        all_errors_check = 0;
                    }
                }

                if(parseFloat(all_errors_check) == 1) {
                    var add = 1;
                    if(selected_lr_id != "") {
                        if(jQuery('input[name="lr_id[]"]').length > 0) {
                            if(jQuery('.added_lr_table tbody tr').length > 0) {
                                jQuery('.added_lr_table tbody').find('tr').each(function () {
                                    var prev_lr_id = ""; var current_lr_id = "";
                                    prev_lr_id = jQuery(this).find('input[name="lr_id[]"]').val();
                                    prev_lr_id = prev_lr_id.toLowerCase();
                                    current_lr_id = selected_lr_id.toLowerCase();
                                    if(prev_lr_id == current_lr_id) {
                                        add = 0;
                                    }
                                });
                            }
                        }
                    }
                    if (add == 1) {
                        var lr_count = 0;
                        lr_count = jQuery('input[name="lr_count"]').val();
                        lr_count = parseInt(lr_count) + 1;
                        jQuery('input[name="lr_count"]').val(lr_count);

                        var post_url = "luggage_bill_changes.php?lr_row_index="+lr_count+"&selected_lr_id="+selected_lr_id;

                        jQuery.ajax({
                            url: post_url, success: function (result) {
                                if (jQuery('.added_lr_table tbody').find('tr.empty_row').length > 0) {
                                    jQuery('.added_lr_table tbody').find('tr.empty_row').remove();
                                }
                                if (jQuery('.added_lr_table tbody').find('tr').length > 0) {
                                    jQuery('.added_lr_table tbody').find('tr:first').before(result);
                                }
                                else {
                                    jQuery('.added_lr_table tbody').append(result);
                                }
                                SnoCalculation();
                                if(jQuery('input[name="from_location"]').length > 0) {
                                    jQuery('input[name="from_location"]').attr('disabled', false);
                                    jQuery('input[name="from_location"]').val(from_location);
                                }
                                if(jQuery('select[name="from_location"]').length > 0) {
                                    jQuery('select[name="from_location"]').attr('disabled', true);
                                }
                                if(jQuery('select[name="selected_lr_id"]').length > 0) {
                                    jQuery('select[name="selected_lr_id"]').val('').trigger('change');
                                }
                            }
                        });
                    }
                    else {
                        jQuery('.added_lr_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">LR No already Exists</span>');
                    }
                }
                else {
                    jQuery('.added_lr_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">Check all fields!</span>');
                }
			}
			else {
				window.location.reload();
			}
		}
	});
}

function SnoCalculation() {
    if (jQuery('.sno').length > 0) {
		var row_count = 0;
		row_count = jQuery('.sno').length;
		if (typeof row_count != "undefined" && row_count != null && row_count != 0 && row_count != "") {
			var j = 1;
			var sno = document.getElementsByClassName('sno');
			for (var i = row_count - 1; i >= 0; i--) {
				sno[i].innerHTML = j;
				j = parseInt(j) + 1;
			}
		}
	}
}

function DeleteLrRow(row_index) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('#lr_row' + row_index).length > 0) {
					jQuery('#lr_row' + row_index).remove();
				}
				SnoCalculation();
                if(jQuery('.lr_row').length == 0) {
                    if(jQuery('input[name="from_location"]').length > 0) {
                        jQuery('input[name="from_location"]').val('');
                        jQuery('input[name="from_location"]').attr('disabled', true);
                    }
                    if(jQuery('select[name="from_location"]').length > 0) {
                        jQuery('select[name="from_location"]').attr('disabled', false);
                    }
                }
			}
			else {
				window.location.reload();
			}
		}
	});
}
