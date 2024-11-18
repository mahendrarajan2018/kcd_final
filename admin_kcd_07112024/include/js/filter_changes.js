function getFilterBranchToList(from_branch_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({url: post_url, success: function (check_login_session) {
        if (check_login_session == 1) {

            if(jQuery('#branch_to_cover').length > 0) {
                jQuery('#branch_to_cover').html('');
            }
            
            var post_url = "filter_changes.php?from_branch_id="+from_branch_id;
            jQuery.ajax({url: post_url, success: function (result) {
                if(jQuery('#branch_to_cover').length > 0) {
                    jQuery('#branch_to_cover').html(result);
                }
                table_listing_records_filter();
            }});
            
        }
        else {
            window.location.reload();
        }
	}});
}