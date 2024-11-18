<?php
	include("basic_functions.php");
	include("user_functions.php");
	include("creation_functions.php");
	include("luggage_functions.php");
	
	class Core_Functions extends Basic_Functions {		
		// Start Basic Functions
		public function basic_functions_object() {
			$basic_obj = "";		
			$basic_obj = new Basic_Functions();
			return $basic_obj;
		}
		// encryption or decryption
		public function encode_decode($action, $string) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();
			$string = $basic_obj->encode_decode($action, $string);
			return $string;
		}	
		// insert records to table		
		public function InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$last_insert_id = "";		
			$last_insert_id = $basic_obj->InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action);
			return $last_insert_id;
		}	
		// update records to table
		public function UpdateSQL($table, $update_id, $columns, $values, $action) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$msg = "";		
			$msg = $basic_obj->UpdateSQL($table, $update_id, $columns, $values, $action);
			return $msg;
		}
		// get particular column value of table
		public function getTableColumnValue($table, $column, $value, $return_value) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$result = "";
			$result = $basic_obj->getTableColumnValue($table, $column, $value, $return_value);
			return $result;
		}
		// get all values of table
		public function getTableRecords($table, $column, $value, $order) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$result = ""; $list = array();		
			$result = $basic_obj->getTableRecords($table, $column, $value, $order);
			return $result;
		}
		// get all values of table use query
		public function getQueryRecords($table, $query) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();
			
			$result = "";		
			$result = $basic_obj->getQueryRecords($table, $query);
			return $result;
		}
		// get backup of database tables
		public function daily_db_backup() {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$result = "";		
			$result = $basic_obj->daily_db_backup();
			return $result;
		}
		// get number formated
		public function numberFormat($number, $decimals = 0) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$result = "";
			$result = $basic_obj->numberFormat($number, $decimals = 0);
			return $result;
		}
		// get number formated
		public function truncate_number( $number, $precision = 2) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();

			$result = "";
			$result = $basic_obj->truncate_number( $number, $precision = 2);
			return $result;
		}
		// sort images with position
		public function SortingImages($images, $positions) {
			$basic_obj = "";
			$basic_obj = $this->basic_functions_object();
			
			$list = array();
			$list = $basic_obj->SortingImages($images, $positions);
			return $list;
		}
		// End Basic Functions
		
		// Start User Functions
		public function user_functions_object() {
			$user_obj = "";		
			$user_obj = new User_Functions();
			return $user_obj;
		}
		// check current user login ip address
		public function check_user_id_ip_address() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$check_login_id = "";			
			$check_login_id = $user_obj->check_user_id_ip_address();			
			return $check_login_id;	
		}
		// check current user is login or not
		public function checkUser() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$login_user_id = "";			
			$login_user_id = $user_obj->checkUser();			
			return $login_user_id;	
		}
		// get daily report
		public function getDailyReport($from_date, $to_date) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$list = array();
			$list = $user_obj->getDailyReport($from_date, $to_date);
			return $list;
		}
		// send email
		/*public function send_email_details($from, $to, $detail, $title) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$res = "";
			$res = $user_obj->send_email_details($from, $to, $detail, $title);
			return $res;
		}*/
		public function send_email_details($to_emails, $detail, $title) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$res = "";
			$res = $user_obj->send_email_details($to_emails, $detail, $title);
			return $res;
		}
		// send sms
		public function send_mobile_details($mobile_number, $sms_number, $sms) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$res = "";
			$res = $user_obj->send_mobile_details($mobile_number, $sms_number, $sms);
			return true;
		}	
		public function getOTPNumber() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$otp_number = "";
			$otp_number = $user_obj->getOTPNumber();
			return $otp_number;
		}
		public function getOTPSendCount($otp_send_date, $otp_receive) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$otp_send_count = 0;
			$otp_send_count = $user_obj->getOTPSendCount($otp_send_date, $otp_receive);
			return $otp_send_count;
		}
		public function getOTPSendUniqueID($otp_send_date, $otp_receive) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$unique_id = "";
			$unique_id = $user_obj->getOTPSendUniqueID($otp_send_date, $otp_receive);
			return $unique_id;
		}
		public function image_directory() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$target_dir = "";		
			$target_dir = $user_obj->image_directory();
			return $target_dir;
		}
		public function temp_image_directory() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$temp_dir = "";		
			$temp_dir = $user_obj->temp_image_directory();
			return $temp_dir;
		}
		public function clear_temp_image_directory() {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$res = "";		
			$res = $user_obj->clear_temp_image_directory();
			return $res;
		}
		public function CheckStaffAccessPage($role_id, $permission_page) {
			$user_obj = "";
			$user_obj = $this->user_functions_object();

			$acccess_permission = 0;		
			$acccess_permission = $user_obj->CheckStaffAccessPage($role_id, $permission_page);
			return $acccess_permission;
		}
		// End User Functions

		public function getProjectTitle() {
			$project_title = "KCD Logistics";

			/*$company_name = "";
			$company_list = array();
			$company_list = $this->getTableRecords($GLOBALS['company_table'], '', '', '');
            if(!empty($company_list)) {
                foreach($company_list as $data) {
                    if(!empty($data['name'])) {
                        $project_title = $this->encode_decode('decrypt', $data['name']);
					}
				}
			}*/

			return $project_title;
		}

		// Start Creation Functions
		public function creation_function_object() {
			$create_obj = "";		
			$create_obj = new Creation_functions();
			return $create_obj;
		}
		public function UpdateSMSUsedCount($sms_count) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();
			$sms_used_count = 0;
			$sms_used_count = $create_obj->UpdateSMSUsedCount($sms_count);
			return $sms_used_count;
		}
		public function getBranchUserCountByGodown($godown_id) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();
			$godown_rows = 0;
			$godown_rows = $create_obj->getBranchUserCountByGodown($godown_id);
			return $godown_rows;
		}
		public function getBranchUserCount($branch_id) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();
			$branch_user_count = 0;
			$branch_user_count = $create_obj->getBranchUserCount($branch_id);
			return $branch_user_count;
		}
		public function getUserList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();
			$list = array();
			$list = $create_obj->getUserList();
			return $list;
		}
		public function getOtherCityList($district) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getOtherCityList($district);
			return $list;	
		}
		public function getBillingYearList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getBillingYearList();
			return $list;	
		}
		public function getBillLastEntryDate($from_date, $to_date, $table, $column) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$last_entry_date = "";
			$last_entry_date = $create_obj->getBillLastEntryDate($from_date, $to_date, $table, $column);
			return $last_entry_date;	
		}
		public function getLRNumberList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getLRNumberList();
			return $list;	
		}
		public function getLRListCount($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getLRListCount($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled);
			return $list;	
		}
		public function getLRList($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled, $page_start, $page_end) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getLRList($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled, $page_start, $page_end);
			return $list;	
		}
		public function getTripsheetLuggageSheetNumberByBranch($branch_id) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getTripsheetLuggageSheetNumberByBranch($branch_id);
			return $list;	
		}
		public function getTripsheetLRNumberByBranch($branch_id) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getTripsheetLRNumberByBranch($branch_id);
			return $list;	
		}
		public function getTripsheetNumberList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getTripsheetNumberList();
			return $list;	
		}
		public function getTripsheetListCount($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getTripsheetListCount($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled);
			return $list;	
		}
		public function getTripsheetList($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled, $page_start, $page_end) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getTripsheetList($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled, $page_start, $page_end);
			return $list;	
		}
		public function getUnAcknowledgedTripsheetList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getUnAcknowledgedTripsheetList();
			return $list;	
		}
		public function getFilterAcknowledgedTripsheetNumberList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getFilterAcknowledgedTripsheetNumberList();
			return $list;	
		}
		public function getInvoiceAcknowledgedTripsheetNumberListCount($from_date, $to_date, $tripsheet_number) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getInvoiceAcknowledgedTripsheetNumberListCount($from_date, $to_date, $tripsheet_number);
			return $list;	
		}
		public function getInvoiceAcknowledgedTripsheetNumberList($from_date, $to_date, $tripsheet_number, $page_start, $page_end) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getInvoiceAcknowledgedTripsheetNumberList($from_date, $to_date, $tripsheet_number, $page_start, $page_end);
			return $list;	
		}
		public function getUnClearedLRNumberList() {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getUnClearedLRNumberList();
			return $list;	
		}
		public function getUnClearedLRListCount($from_date, $to_date, $lr_number) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getUnClearedLRListCount($from_date, $to_date, $lr_number);
			return $list;	
		}
		public function getUnClearedLRList($from_date, $to_date, $lr_number, $page_start, $page_end) {
			$create_obj = "";
			$create_obj = $this->creation_function_object();

			$list = array();
			$list = $create_obj->getUnClearedLRList($from_date, $to_date, $lr_number, $page_start, $page_end);
			return $list;	
		}

		public function luggage_function_object() {
			$luggage_obj = "";		
			$luggage_obj = new Luggage_functions();
			return $luggage_obj;
		}
		public function LuggagesheetFromList() {
			$luggage_obj = "";
			$luggage_obj = $this->luggage_function_object();
	
			$list = array();
			$list = $luggage_obj->LuggagesheetFromList();
			return $list;	
		}
		public function LuggagesheetToList($from_location) {
			$luggage_obj = "";
			$luggage_obj = $this->luggage_function_object();
	
			$list = array();
			$list = $luggage_obj->LuggagesheetToList($from_location);
			return $list;	
		}
		public function getLRlistForLuggagesheet($from_location) {
			$luggage_obj = "";
			$luggage_obj = $this->luggage_function_object();
	
			$list = array();
			$list = $luggage_obj->getLRlistForLuggagesheet($from_location);
			return $list;	
		}
		public function getLuggageSheetList($from_date, $to_date, $branch_id, $search_text, $cancelled) {
			$luggage_obj = "";
			$luggage_obj = $this->luggage_function_object();
	
			$list = array();
			$list = $luggage_obj->getLuggageSheetList($from_date, $to_date, $branch_id, $search_text, $cancelled);
			return $list;	
		}
		// End Frontend Functions
	}	
?>