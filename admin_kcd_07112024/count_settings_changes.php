<?php
	include("include.php");

	if(isset($_POST['total_sms_count'])) {
		$total_sms_count = ""; $total_sms_count_error = "";

		$settings_error = "";
		$create_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
		$valid_settings = ""; $form_name = "settings_form";

		$total_sms_count = $_POST['total_sms_count'];
        $total_sms_count = trim($total_sms_count);
        $total_sms_count_error = $valid->valid_number($total_sms_count, "total sms count", "1");
        if(!empty($total_sms_count_error)) {
            $valid_settings = $valid->error_display($form_name, "total_sms_count", $total_sms_count_error, 'text');			
        }

		$result = "";
		
		if(empty($valid_settings) && empty($settings_error)) {
			$check_user_id_ip_address = 0;
			$check_user_id_ip_address = $obj->check_user_id_ip_address();	
			if(preg_match("/^\d+$/", $check_user_id_ip_address)) {

				$settings_list[] = array('settings_name' => 'total_sms_count', 'settings_value' => $total_sms_count, 'action' => 'Total SMS Count');

				if(!empty($settings_list)) {
					$success = 0;
					foreach($settings_list as $data) {
						if(!empty($data['settings_name']) && !empty($data['settings_value']) && !empty($data['action'])) {
							$getUniqueID = "";
							$getUniqueID = $obj->getTableColumnValue($GLOBALS['settings_table'], 'name', $data['settings_name'], 'id');
							if(preg_match("/^\d+$/", $getUniqueID)) {
								$action = "";
								if(!empty($data['action'])) {
									$action = "Settings Param Updated. Name - ".$data['action'];
								}

								$settings_update_id = ""; $columns = array(); $values = array();						
								$columns = array('value');
								$values = array("'".$data['settings_value']."'");
								$settings_update_id = $obj->UpdateSQL($GLOBALS['settings_table'], $getUniqueID, $columns, $values, $action);
								if(preg_match("/^\d+$/", $settings_update_id)) {
									$success++;						
								}						
							}
							else {
								$action = "";
								if(!empty($data['action'])) {
									$action = "New Settings Param Created. Name - ".$data['action'];
								}
								$settings_insert_id = ""; $columns = array(); $values = array();
								$columns = array('name', 'value', 'deleted');
								$values = array("'".$data['settings_name']."'", "'".$data['settings_value']."'", "'0'");
								$settings_insert_id = $obj->InsertSQL($GLOBALS['settings_table'], $columns, $values, '', '', $action);						
								if(preg_match("/^\d+$/", $settings_insert_id)) {
									$success++;
								}
							}
						}
					}

					if(!empty($success) && $success == count($settings_list)) {
						$result = array('number' => '1', 'msg' => 'Settings Successfully Updated');
					}
					else {
						$result = array('number' => '2', 'msg' => 'Some Values not inserted properly - '.$success.', '.count($settings_list));
					}
				}

			}
			else {
				$result = array('number' => '2', 'msg' => 'Invalid IP');
			}
		}
		else {
			if(!empty($valid_settings)) {
				$result = array('number' => '3', 'msg' => $valid_settings);
			}
		}
		
		if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
	}
?>