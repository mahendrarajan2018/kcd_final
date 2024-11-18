// JavaScript Document
function CheckPassword(field_name) {
	var password = "";
	if (jQuery('input[name="password"]').length > 0) {
		password = jQuery('input[name="password"]').val();
		//password = jQuery.trim(password);
	}

	if (jQuery('#password_cover').length > 0) {
		if (jQuery('#password_cover').find('label').length > 0) {
			jQuery('#password_cover').find('label').addClass('text-danger');
		}
		if (jQuery('#password_cover').find('input[name="length_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="length_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="letter_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="letter_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="number_symbol_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="number_symbol_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="space_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="space_check"]').prop('checked', false);
		}

		var upper_regex = /[A-Z]/; var lower_regex = /[a-z]/;
		var number_regex = /\d/; var symbol_regex = /[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\]/; var no_space_regex = /^\S+$/;

		if (typeof password != "undefined" && password != null && password != "") {
			var password_length = password.length;
			if (parseInt(password_length) >= 8 && parseInt(password_length) <= 20) {
				if (jQuery('#password_cover').find('input[name="length_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="length_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if ((upper_regex.test(password) == true) && (lower_regex.test(password) == true)) {
				if (jQuery('#password_cover').find('input[name="letter_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="letter_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if ((number_regex.test(password) == true) && (symbol_regex.test(password) == true)) {
				if (jQuery('#password_cover').find('input[name="number_symbol_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="number_symbol_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if (no_space_regex.test(password) == true) {
				if (jQuery('#password_cover').find('input[name="space_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="space_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
		}
	}
}
function CustomCheckboxToggle(obj, toggle_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				var toggle_value = 2;
				if (jQuery('#' + toggle_id).length > 0) {
					if (jQuery('#' + toggle_id).prop('checked') == true) {
						toggle_value = 1;
					}
					jQuery('#' + toggle_id).val(toggle_value);
				}
				if (jQuery('.staff_access_table').length > 0) {
					toggle_id = toggle_id.replace('view', '');
					toggle_id = toggle_id.replace('add', '');
					toggle_id = toggle_id.replace('edit', '');
					toggle_id = toggle_id.replace('delete', '');
					toggle_id = jQuery.trim(toggle_id);
					var checkbox_cover = toggle_id + "cover";
					//console.log('checkbox_cover - '+checkbox_cover+', checbox count - '+jQuery('#'+checkbox_cover).find('input[type="checkbox"]').length);
					if (jQuery('#' + checkbox_cover).find('input[type="checkbox"]').length > 0) {

						var view_checkbox = toggle_id + "view"; var add_checkbox = toggle_id + "add"; var edit_checkbox = toggle_id + "edit";
						var delete_checkbox = toggle_id + "delete"; var select_count = 0; var select_all_checkbox = toggle_id + "select_all";
						//console.log('add_checkbox - '+add_checkbox+', edit_checkbox - '+edit_checkbox+', delete_checkbox - '+delete_checkbox+', select_all_checkbox - '+select_all_checkbox);
						if (jQuery('#' + view_checkbox).prop('checked') == true) {
							select_count = parseInt(select_count) + 1;
						}
						if (jQuery('#' + add_checkbox).prop('checked') == true) {
							select_count = parseInt(select_count) + 1;
						}
						if (jQuery('#' + edit_checkbox).prop('checked') == true) {
							select_count = parseInt(select_count) + 1;
						}
						if (jQuery('#' + delete_checkbox).prop('checked') == true) {
							select_count = parseInt(select_count) + 1;
						}

						if (parseInt(select_count) == 4) {
							jQuery('#' + select_all_checkbox).prop('checked', true);
						}
						else {
							jQuery('#' + select_all_checkbox).prop('checked', false);
						}
					}
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}
function SelectAllModuleActionToggle(obj, toggle_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				var toggle_value = 2;
				if (jQuery('#' + toggle_id).length > 0) {
					if (jQuery('#' + toggle_id).prop('checked') == true) {
						toggle_value = 1;
					}
					jQuery('#' + toggle_id).val(toggle_value);
				}
				if (parseInt(toggle_value) == 1) {
					if (jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').length > 0) {
						jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').each(function () {
							jQuery(this).prop('checked', true);
							jQuery(this).val('1');
						});
					}
				}
				else {
					if (jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').length > 0) {
						jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').each(function () {
							jQuery(this).prop('checked', false);
							jQuery(this).val('2');
						});
					}
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function table_listing_records_filter() {
	if (jQuery('#table_listing_records').length > 0) {
		jQuery('#table_listing_records').html('<div class="alert alert-success mb-3 mx-3"> Loading... </div>');
	}

	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	 jQuery.ajax({url: post_url, success: function (check_login_session) {
		if (check_login_session == 1) {
			var page_title = ""; var post_send_file = "";
			if (jQuery('input[name="page_title"]').length > 0) {
				page_title = jQuery('input[name="page_title"]').val();
				if (typeof page_title != "undefined" && page_title != "") {
					page_title = page_title.replace(" ", "_");
					page_title = page_title.toLowerCase();
					page_title = jQuery.trim(page_title);
					post_send_file = page_title + "_changes.php";
				}
			}
			jQuery.ajax({
				url: post_send_file,
				type: "post",
				async: true,
				data: jQuery('form[name="table_listing_form"]').serialize(),
				dataType: 'html',
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
				success: function (result) {
					if (jQuery('.alert').length > 0) {
						jQuery('.alert').remove();
					}
					if (jQuery('#table_listing_records').length > 0) {
						jQuery('#table_listing_records').html(result);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		}
		else {
			window.location.reload();
		}
	}});
}

function ShowModalContent(page_title, add_edit_id_value) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function(check_login_session){
		if(check_login_session == 1) {
			var add_edit_id = ""; var post_send_file = ""; var heading = "";
			if (typeof page_title != "undefined" && page_title != "") {
				heading = page_title;
				page_title = page_title.replaceAll(" ", "_");
				page_title = page_title.toLowerCase();
				add_edit_id = "show_" + page_title + "_id";
				post_send_file = page_title + "_changes.php";
				page_title = page_title + " Details";
				if (jQuery('.edit_title').length > 0) {
					page_title = page_title.replaceAll("_", " ");
					page_title = page_title.toLowerCase().replace(/\b[a-z]/g, function (string) {
						return string.toUpperCase();
					});
					jQuery('.edit_title').html(page_title);
				}
				if (jQuery('#table_records_cover').length > 0) {
					jQuery('#table_records_cover').addClass('d-none');
				}
				if (jQuery('#add_update_form_content').length > 0) {
					jQuery('#add_update_form_content').removeClass('d-none');
				}
			}

			var post_url = post_send_file + "?" + add_edit_id + "=" + add_edit_id_value;
			jQuery.ajax({
				url: post_url, success: function (result) {
					if (jQuery('.add_update_form_content').length > 0) {
						jQuery('.add_update_form_content').html("");
						jQuery('.add_update_form_content').html(result);
					}
					jQuery('html, body').animate({
						scrollTop: (jQuery('body').offset().top)
					}, 500);
				}
			});
		}
		else {
			window.location.reload();
		}
	}});
}

function SaveModalContent(event, form_name, post_send_file, redirection_file) {
	event.preventDefault();
	if (jQuery('span.infos').length > 0) {
		jQuery('span.infos').remove();
	}
	if (jQuery('.valid_error').length > 0) {
		jQuery('.valid_error').remove();
	}
	if (jQuery('div.alert').length > 0) {
		jQuery('div.alert').remove();
	}
	jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger mb-3"> Processing </div>');
	if (jQuery('.submit_button').length > 0) {
		jQuery('.submit_button').attr('disabled', true);
	}
	if (form_name != "register_form" && form_name != "login_form") {
		jQuery('html, body').animate({
			scrollTop: (jQuery('body').offset().top)
		}, 500);

		var check_login_session = 1;
		var post_url = "dashboard_changes.php?check_login_session=1";
		jQuery.ajax({
			url: post_url, success: function (check_login_session) {
				if (check_login_session == 1) {
					SendModalContent(form_name, post_send_file, redirection_file);
				}
				else {
					window.location.reload();
				}
			}
		});
	}
	else {
		jQuery('html, body').animate({
			scrollTop: (jQuery('form[name="' + form_name + '"]').offset().top)
		}, 500);
		SendModalContent(form_name, post_send_file, redirection_file);
	}
}

function SendModalContent(form_name, post_send_file, redirection_file) {
	jQuery.ajax({
		url: post_send_file,
		type: "post",
		async: true,
		data: jQuery('form[name="' + form_name + '"]').serialize(),
		dataType: 'html',
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		success: function (data) {
			//console.log(data);
			try {
				var x = JSON.parse(data);
			} catch (e) {
				return false;
			}
			//console.log(x);

			if (jQuery('span.infos').length > 0) {
				jQuery('span.infos').remove();
			}
			if (jQuery('.valid_error').length > 0) {
				jQuery('.valid_error').remove();
			}
			if (jQuery('div.alert').length > 0) {
				jQuery('div.alert').remove();
			}

			if (x.number == '1') {
				jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-success"> ' + x.msg + ' </div>');
				setTimeout(function () {
					if (jQuery('.redirection_form').length > 0) {
						if (typeof x.redirection_page != "undefined" && x.redirection_page != "") {
							window.location = x.redirection_page;
						}
						else {
							window.location = redirection_file;
						}
					}
					else {
						if (jQuery('#table_records_cover').hasClass('d-none')) {
							jQuery('#table_records_cover').removeClass('d-none');
						}
						else {
							table_listing_records_filter();
						}
					}
				}, 1000);
			}

			if (x.number == '2') {
				jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger"> ' + x.msg + ' </div>');
				if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
					jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
				}
			}

			if (x.number == '3') {
				jQuery('form[name="' + form_name + '"]').append('<div class="valid_error"> <script type="text/javascript"> ' + x.msg + ' </script> </div>');
				if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
					jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
				}
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
}

function DeleteModalContent(page_title, delete_content_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (typeof page_title != "undefined" && page_title != "") {
					jQuery('#DeleteModal .modal-header').find('h1').html("");
					jQuery('#DeleteModal .modal-header').find('h1').html("Delete " + page_title);
					page_title = page_title.toLowerCase();
				}
				jQuery('.delete_modal_button').trigger("click");
				jQuery('#DeleteModal .modal-body').html('');
				if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
					jQuery('#DeleteModal .modal-body').html('Are you surely want to cancel this ' + page_title + '?');
				}
				else {
					jQuery('#DeleteModal .modal-body').html('Are you surely want to delete this ' + page_title + '?');
				}

				jQuery('#DeleteModal .modal-footer .yes').attr('id', delete_content_id);
				jQuery('#DeleteModal .modal-footer .no').attr('id', delete_content_id);
			}
			else {
				window.location.reload();
			}
		}
	});
}
function DeleteNumberModalContent(page_title, delete_content_id) {

	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (typeof page_title != "undefined" && page_title != "") {
					jQuery('#ReceiptDeleteModal .modal-header').find('h4').html("");
					jQuery('#ReceiptDeleteModal .modal-header').find('h4').html("Delete " + page_title);

					page_title = page_title.toLowerCase();
				}
				jQuery('.receipt_delete_modal_button').trigger("click");
				jQuery('#ReceiptDeleteModal .modal-body').html('');

				if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
					jQuery('#ReceiptDeleteModal .modal-body').html('Are you surely want to cancel this ' + page_title + '?');
				}
				else {
					jQuery('#ReceiptDeleteModal .modal-body').html('Are you surely want to delete this ' + page_title + '?');
				}

				jQuery('#ReceiptDeleteModal .modal-footer .yes').attr('id', delete_content_id);
				jQuery('#ReceiptDeleteModal .modal-footer .no').attr('id', delete_content_id);
			}
			else {
				window.location.reload();
			}
		}
	});
}

function confirm_delete_modal(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				if (jQuery('#DeleteModal .modal-body').find('.infos').length > 0) {
					jQuery('#DeleteModal .modal-body').find('.infos').remove();
				}

				var page_title = ""; var post_send_file = "";
				if (jQuery('input[name="page_title"]').length > 0) {
					page_title = jQuery('input[name="page_title"]').val();
					if (typeof page_title != "undefined" && page_title != "") {
						page_title = page_title.replace(" ", "_");
						page_title = page_title.toLowerCase();
						page_title = jQuery.trim(page_title);
						post_send_file = page_title + "_changes.php";
					}
				}
				var delete_content_id = jQuery(obj).attr('id');
				if (page_title != 'receipt') {
					var post_url = post_send_file + "?delete_" + page_title + "_id=" + delete_content_id;
					jQuery.ajax({
						url: post_url, success: function (result) {
							jQuery('#DeleteModal .modal-content').animate({ scrollTop: 0 }, 500);

							var intRegex = /^\d+$/;
							if (intRegex.test(result) == true) {
								if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
									jQuery('#DeleteModal .modal-body').append('<div class="alert alert-success"> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> Successfully Cancel the ' + page_title.replace("_", " ") + ' </div>');
								}
								else {
									jQuery('#DeleteModal .modal-body').append('<div class="alert alert-success"> <button type="button" class="btn-close" data-bs-dismiss="alert"></button> Successfully Delete the ' + page_title.replace("_", " ") + ' </div>');
								}
								setTimeout(function () {
									jQuery('#DeleteModal .modal-header .btn-close').trigger("click");
									window.location.reload();
								}, 1000);

							}
							else {
								jQuery('#DeleteModal .modal-body').append('<span class="infos w-100 text-center" style="font-size: 15px; font-weight: bold;">' + result + '</span>');
							}
						}
					});
				}
				else {
					RemarksModalContent(delete_content_id, '')
				}

			}
			else {
				window.location.reload();
			}
		}
	});
}
function cancel_delete_modal(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				jQuery('#DeleteModal .modal-header .btn-close').trigger("click");
			}
			else {
				window.location.reload();
			}
		}
	});
}

function CancelModalContent(page_title, delete_content_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";	
	jQuery.ajax({url: post_url, success: function(check_login_session){
		if(check_login_session == 1) {	
			console.log('page_title - '+page_title);	
            if(typeof page_title != "undefined" && page_title != "") {
				jQuery('#CancelBillModal .modal-header').find('h4').html("");
				jQuery('#CancelBillModal .modal-header').find('h4').html("Cancel "+page_title);
                page_title = page_title.toLowerCase();
            }

			if(jQuery('#CancelBillModal .modal-body').find('.infos').length > 0) {
                jQuery('#CancelBillModal .modal-body').find('.infos').remove();
            }

			if(jQuery('#CancelBillModal').find('input[name="cancel_bill_id"]').length > 0) {
				jQuery('#CancelBillModal').find('input[name="cancel_bill_id"]').val('');
				jQuery('#CancelBillModal').find('input[name="cancel_bill_id"]').val(delete_content_id);
			}

			if(jQuery('#CancelBillModal').find('textarea[name="cancel_bill_remarks"]').length > 0) {
				jQuery('#CancelBillModal').find('textarea[name="cancel_bill_remarks"]').val('');
			}

			jQuery('.cancel_bill_modal_button').trigger("click");
		}
		else {
			window.location.reload();
		}
	}});
}

function ConfirmCancelBill() {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";	
	jQuery.ajax({url: post_url, success: function(check_login_session){
		if(check_login_session == 1) {

			jQuery('#CancelBillModal .modal-content').animate({ scrollTop: 0 }, 500);

            if(jQuery('#CancelBillModal .modal-body').find('.infos').length > 0) {
                jQuery('#CancelBillModal .modal-body').find('.infos').remove();
            }

            var page_title = ""; var post_send_file  = "";
            if(jQuery('input[name="page_title"]').length > 0) {
                page_title = jQuery('input[name="page_title"]').val();
                if(typeof page_title != "undefined" && page_title != "") {
                    page_title = page_title.replaceAll(" ", "_");
                    page_title = page_title.toLowerCase();
                    page_title = jQuery.trim(page_title);
                    post_send_file = page_title+"_changes.php";
                }
            }

			var form_name = "bill_cancel_form";
	
			jQuery.ajax({
				url: post_send_file,
				type: "post",
				async: true,
				data: jQuery('form[name="'+form_name+'"]').serialize(),
				dataType: 'html',
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
				success: function(data) {
					//console.log(data);
					if(typeof data == "undefined" || data == "" || data == null) {
						if(jQuery('form[name="'+form_name+'"]').find('.submit_button').length > 0) {
							jQuery('form[name="'+form_name+'"]').find('.submit_button').attr('disabled', false);
						}
					}
		
					try {
						var x = JSON.parse(data);
					} catch (e) {
						return false;
					}
					//console.log(x);
					
					if(jQuery('#CancelBillModal .modal-body').find('.infos').length > 0) {
						jQuery('#CancelBillModal .modal-body').find('.infos').remove();
					}
					
					if(x.number == '1') {
						if(jQuery('form[name="'+form_name+'"]').find('.submit_button').length > 0) {
							jQuery('form[name="'+form_name+'"]').find('.submit_button').attr('disabled', false);
						}	
						jQuery('#CancelBillModal .modal-body').append('<span class="infos w-100 text-center" style="font-size: 15px; font-weight: bold; color: green;">'+x.msg+'</span>');

						setTimeout(function(){ 
							if(jQuery('#CancelBillModal').find('.modal-header').find('button').length > 0) {
								jQuery('#CancelBillModal').find('.modal-header').find('button').trigger('click');
							}
							table_listing_records_filter();
						}, 1000);
					}
					
					if(x.number == '2') {
						if(jQuery('form[name="'+form_name+'"]').find('.submit_button').length > 0) {
							jQuery('form[name="'+form_name+'"]').find('.submit_button').attr('disabled', false);
						}
						jQuery('#CancelBillModal .modal-body').append('<span class="infos w-100 text-center" style="font-size: 15px; font-weight: bold;">'+x.msg+'</span>');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		}
		else {
			window.location.reload();
		}
	}});
}