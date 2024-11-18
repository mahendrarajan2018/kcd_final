var numbers_regex = /^\d+$/;
function KeyboardControls(obj,type,characters,color){
    var input = jQuery(obj);

    // Use onkeydown
    if(type == "text"){
        input.on('keypress', function(event) {
            // Get the keycode of the pressed key
            var keyCode = event.keyCode || event.which;

            // Allow: backspace, delete, tab, escape, enter, and arrow keys
            if ([8, 46, 9, 27, 13, 37, 38, 39, 40].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: home, end, page up, page down
                (keyCode >= 35 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }

            // Block numeric key codes (0-9 on main keyboard and numpad)
            if ((keyCode >= 48 && keyCode <= 57)) {
                event.preventDefault();
            }
        });
    }

    // Use onfocus
    if(type == "mobile_number"){
        input.on('keypress', function(event) {
            var keyCode = event.keyCode || event.which;
        
            // Allow: backspace, delete, tab, escape, enter, period, arrow keys
            if ([8, 46, 9, 27, 13, 190].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: arrow keys
                (keyCode >= 37 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }
        
            // Ensure that it is a number and stop the keypress if not
            if ((keyCode < 48 || keyCode > 57)) {
                event.preventDefault();
            }
        });
        
        input.on("input", function(event){
            var str_len = input.val().length;
            if(str_len > 10) {
                input.val(input.val().substring(0, 10));
            }
        });
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }

	// Use onfocus
    if(type == "email" || type == "password"){
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }

    // Use onfocus
    if(type == "number"){
        input.on('keypress', function(event) {
            var keyCode = event.keyCode || event.which;
        
            // Allow: backspace, delete, tab, escape, enter, period, arrow keys
            if ([8, 46, 9, 27, 13, 190].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) || 
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: arrow keys
                (keyCode >= 37 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }
        
            // Ensure that it is a number and stop the keypress if not
            if ((keyCode < 48 || keyCode > 57)) {
                event.preventDefault();
            }
        });
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }

	 // Use onfocus
	 if(type == "no_space"){
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }
	
	if(numbers_regex.test(characters) != false){
		if(characters != "" && characters != 0){
			input.on("input", function(event){
				var str_len = input.val().length;
				if(str_len > parseFloat(characters)) {
					input.val(input.val().substring(0, parseFloat(characters)));
				}
			});
		}
	}

    if(color == '1'){
        InputBoxColor(obj,type);
    }
}

function SnoCalculation(){
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

function InputBoxColor(obj,type){
    if(type == 'select'){
		if(jQuery(obj).closest().find('.select2-selection--single').length > 0){
			jQuery(obj).closest().find('.select2-selection--single').css('border','1px solid #ced4da');
		}
        if(jQuery(obj).parent().find('.infos').length > 0){
            jQuery(obj).parent().find('.infos').remove();
        }
        if(jQuery(obj).parent().parent().find('.infos').length > 0){
            jQuery(obj).parent().parent().find('.infos').remove();
        }
        if(jQuery(obj).parent().parent().parent().find('.infos').length > 0){
            jQuery(obj).parent().parent().parent().find('.infos').remove();
        }
	}
	else{
		jQuery(obj).css('border','1px solid #ced4da');
        if(jQuery(obj).parent().find('.infos').length > 0){
            jQuery(obj).parent().find('.infos').remove();
        }
        if(jQuery(obj).parent().parent().find('.infos').length > 0){
            jQuery(obj).parent().parent().find('.infos').remove();
        }
        if(jQuery(obj).parent().parent().parent().find('.infos').length > 0){
            jQuery(obj).parent().parent().parent().find('.infos').remove();
        }
	}
}

function OnOffButton(field_name){
    var checkbox_button = document.getElementById(field_name).checked;
    
    if(checkbox_button == true){
        document.getElementById(field_name).value = 1;
        if(field_name == 'tax_on_off'){
            document.getElementById('gst_label').innerHTML = 'GST Number <span class="text-danger">*</span>';
        }
    }
    else if(checkbox_button == false){
        document.getElementById(field_name).value = 0;
        if(field_name == 'tax_on_off'){
            document.getElementById('gst_label').innerHTML = 'GST Number';
        }
    }
}

function addUnitDetails() {
	var check_login_session = 1; var all_errors_check = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				if (jQuery('.infos').length > 0) {
					jQuery('.infos').each(function() { jQuery(this).remove(); });
				}

				var regex = /^[a-zA-Z ]+$/;

				var validation_check = 1; var unit_name = ""; var character_check = 1;  

				if(jQuery('input[name="unit_name"]').is(":visible")) {
					if(jQuery('input[name="unit_name"]').length > 0) {
						unit_name = jQuery('input[name="unit_name"]').val();
                        unit_name = jQuery.trim(unit_name);

						if(typeof unit_name != "undefined" && unit_name != "") {
							if(unit_name.length > 40) {
								character_check = 0;
							} 
                            else {
								if(regex.test(unit_name) == false) {
									validation_check = 0;
								}
							}
						} 
                        else {
							all_errors_check = 0;
						}
					}
				}

				if (parseFloat(all_errors_check) == 1) {
					if(parseFloat(character_check) == 1) {
						if (parseFloat(validation_check) == 1) {
							var add = 1;
							if (unit_name != "") {
								if (jQuery('input[name="unit_names[]"]').length > 0) {
                                    if(jQuery('.added_unit_table tbody').length > 0){
                                        jQuery('.added_unit_table tbody').find('tr').each(function () {
                                            var prev_unit_name = ""; var current_unit_name = "";
                                            prev_unit_name = jQuery(this).find('input[name="unit_names[]"]').val();
                                            prev_unit_name = prev_unit_name.toLowerCase();
                                            current_unit_name = unit_name.toLowerCase();
                                            if (prev_unit_name == current_unit_name) {
                                                add = 0;
                                            }
                                        });
                                    }
								}
							}

							if (add == 1) {
                                var unit_count = 0;
								unit_count = jQuery('input[name="unit_count"]').val();
								unit_count = parseInt(unit_count) + 1;
								jQuery('input[name="unit_count"]').val(unit_count);

								var post_url = "unit_changes.php?unit_row_index=" + unit_count + "&selected_unit_name=" + unit_name;

								jQuery.ajax({
									url: post_url, success: function (result) {
										if (jQuery('.added_unit_table tbody').find('tr').length > 0) {
											jQuery('.added_unit_table tbody').find('tr:first').before(result);
										}
										else {
											jQuery('.added_unit_table tbody').append(result);
										}
										SnoCalculation();
										if (jQuery('input[name="unit_name"]').length > 0) {
											jQuery('input[name="unit_name"]').val('');
										}
									}
								});
							}
							else {
								jQuery('.added_unit_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">Unit Name already Exists</span>');
							}
						}
						else{
							jQuery('.added_unit_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">Invalid unit</span>');
							jQuery('input[name="unit_name"]').val('');
						}
					}
					else{
						jQuery('.added_unit_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">Only 40 characters allowed</span>');
					}
				}
				else {
                    jQuery('.added_unit_table').before('<span class="infos w-100 text-center mb-3" style="font-size: 15px;">Enter Unit Name</span>');
				}
			}
			else {
				window.location.reload();
			}
		}
	});
	
}

function DeleteUnitRow(row_index) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('#unit_row' + row_index).length > 0) {
					jQuery('#unit_row' + row_index).remove();
				}
				SnoCalculation();
			}
			else {
				window.location.reload();
			}
		}
	});
}

function RolePermission(role_id) {
    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
                var post_url = "user_changes.php?role_permission="+role_id;
                jQuery.ajax({
                    url: post_url, success: function (result) {
                        result = jQuery.trim(result);
                        if(parseFloat(result) == '1') {
                            if(jQuery('#godown_element').length > 0) {
                                jQuery('#godown_element').removeClass('d-none');
                            }
                            if(jQuery('#branch_element').length > 0) {
                                jQuery('#branch_element').addClass('d-none');
                            }
                        }
                        else if(parseFloat(result) == '2') {
                            if(jQuery('#godown_element').length > 0) {
                                jQuery('#godown_element').addClass('d-none');
                            }
                            if(jQuery('#branch_element').length > 0) {
                                jQuery('#branch_element').removeClass('d-none');
                            }
                        }
                        else {
                            if(jQuery('#godown_element').length > 0) {
                                jQuery('#godown_element').addClass('d-none');
                            }
                            if(jQuery('#branch_element').length > 0) {
                                jQuery('#branch_element').addClass('d-none');
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