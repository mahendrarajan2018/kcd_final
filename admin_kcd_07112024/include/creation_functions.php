<?php 
    class Creation_functions extends Basic_Functions{

		public function UpdateSMSUsedCount($sms_count) {
			$sms_used_count = 0;
			$sms_unique_id = "";
			$sms_unique_id = $this->getTableColumnValue($GLOBALS['settings_table'], 'name', 'sms_used_count', 'id');
			if(preg_match("/^\d+$/", $sms_unique_id)) {
				$prev_sms_count = 0;
				$prev_sms_count = $this->getTableColumnValue($GLOBALS['settings_table'], 'id', 'sms_unique_id', 'value');
				if(!empty($prev_sms_count)) {
					$sms_count = $sms_count + $prev_sms_count;
				}
			}
			else {
				$settings_insert_id = ""; $columns = array(); $values = array();
				$columns = array('name', 'value', 'deleted');
				$values = array("'sms_used_count'", "'".$sms_count."'", "'0'");
				$settings_insert_id = $this->InsertSQL($GLOBALS['settings_table'], $columns, $values, '', '', '');
			}
			return $sms_used_count;
		}

        public function getBranchUserCountByGodown($godown_id) {
			$godown_rows = 0; $list = array();
			if(!empty($godown_id)) {
				$select_query = "SELECT g.name as godown_name, 
								(SELECT COUNT(b.id) FROM ".$GLOBALS['branch_table']." as b WHERE FIND_IN_SET('".$godown_id."', b.godown_id) AND b.deleted = '0') 
								as branch_count,
								(SELECT COUNT(u.id) FROM ".$GLOBALS['user_table']." as u WHERE FIND_IN_SET('".$godown_id."', u.godown_id) AND u.deleted = '0') 
								as user_count
								FROM ".$GLOBALS['godown_table']." as g WHERE g.godown_id = '".$godown_id."' AND g.deleted = '0'";
				$list = $this->getQueryRecords($GLOBALS['user_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['branch_count'])) {
							$godown_rows = $godown_rows + $data['branch_count'];
						}
						if(!empty($data['user_count'])) {
							$godown_rows = $godown_rows + $data['user_count'];
						}						
					}
				}
			}
			return $godown_rows;
		}

		public function getBranchUserCount($branch_id) {
			$branch_user_count = 0; $list = array();
			if(!empty($branch_id)) {
				$select_query = "SELECT COUNT(id) as branch_user_count FROM ".$GLOBALS['user_table']." WHERE FIND_IN_SET('".$branch_id."', branch_id) AND deleted = '0'";
				$list = $this->getQueryRecords($GLOBALS['user_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['branch_user_count'])) {
							$branch_user_count = $data['branch_user_count'];
						}						
					}
				}
			}
			return $branch_user_count;
		}

		public function getUserList() {
			$list = array();
			$select_query = "SELECT u.*, r.role_name FROM ".$GLOBALS['user_table']." as u 
								LEFT JOIN ".$GLOBALS['role_table']." as r ON r.role_id = u.role_id
								WHERE u.deleted = '0' ORDER BY u.id DESC";
			$list = $this->getQueryRecords($GLOBALS['user_table'], $select_query);
			return $list;
		}

		public function getOtherCityList($district) {
            $organization_query = ""; $consignor_query = ""; $consignee_query = ""; $account_party_query = "";
            $select_query = ""; $list = array();
            
            $organization_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['organization_table']." WHERE district = '".$district."' 
									AND city != '".$GLOBALS['null_value']."' ORDER BY id DESC";

            $consignor_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['consignor_table']." WHERE district = '".$district."'
									AND city != '".$GLOBALS['null_value']."' ORDER BY id DESC";

            $consignee_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['consignee_table']." WHERE district = '".$district."'
									AND city != '".$GLOBALS['null_value']."' ORDER BY id DESC";

            $account_party_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['account_party_table']." WHERE district = '".$district."' ORDER BY id DESC";

            $select_query = "SELECT DISTINCT(others_city) as city FROM ((".$organization_query.") UNION ALL (".$consignor_query.") UNION ALL (".$consignee_query.") 
								UNION ALL (".$account_party_query.")) as g";

            $list = $this->getQueryRecords('', $select_query);

            return $list;
        }

		public function getBillingYearList() {
			$list = array(); $select_query = ""; $year_list = array();
			$select_query = "SELECT YEAR(lr_date) as billing_year FROM ".$GLOBALS['lr_table']." GROUP BY YEAR(lr_date)";
			$list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['billing_year'])) {
						$year_list[] = $data['billing_year'];
					}
				}
			}
			$year = date('Y'); $month = date("m");
			if(!empty($year) && !empty($month)) {
				$month = (int)$month;
				if($month <= 3) { $year = $year - 1; }
			}
			if(!empty($year) && !in_array($year, $year_list)) {
				$year_list[] = $year;
			}
			return $year_list;
		}

		public function getBillLastEntryDate($from_date, $to_date, $table, $column) {
			$last_entry_date = ""; $list = array();
			if(!empty($from_date) && !empty($to_date) && !empty($table)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				$to_date = date("Y-m-d", strtotime($to_date));
				$select_query = "SELECT ".$column." as last_entry_date FROM ".$table." WHERE DATE(".$column.") >= '".$from_date."' 
									AND DATE(".$column.") <= '".$to_date."' AND deleted = '0' ORDER BY DATE(".$column.") DESC LIMIT 1";
				$list = $this->getQueryRecords($table, $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['last_entry_date'])) {
							$last_entry_date = $data['last_entry_date'];
						}						
					}
			}
			}
			return $last_entry_date;
		}

		public function getLRNumberList() {
			$list = array(); $lr_number_list = array();
			$select_query = "SELECT lr_number FROM ".$GLOBALS['lr_table']." WHERE deleted = '0' ORDER BY lr_number DESC";
			$lr_number_list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
			if(!empty($lr_number_list)) {
				foreach($lr_number_list as $data) {
					if(!empty($data['lr_number'])) {
						$list[] = $data['lr_number'];
					}						
				}
			}
			return $list;
		}

		public function getLRListCount($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled) {
			$list = array(); $where = ""; $lr_count = 0;
			$where = "cancelled = '".$cancelled."'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(lr_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(lr_date) <= '".$to_date."'";
				}
			}
			if(!empty($organization_id)) {
				if(!empty($where)) {
					$where = $where." AND organization_id = '".$organization_id."'";
				}
				else {
					$where = "organization_id = '".$organization_id."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND lr_number = '".$lr_number."'";
				}
				else {
					$where = "lr_number = '".$lr_number."'";
				}
			}

			if(!empty($from_branch_id)) {
				if(!empty($where)) {
					$where = $where." AND from_branch_id = '".$from_branch_id."'";
				}
				else {
					$where = "from_branch_id = '".$from_branch_id."'";
				}
			}
			if(!empty($to_branch_id)) {
				if(!empty($where)) {
					$where = $where." AND to_branch_id = '".$to_branch_id."'";
				}
				else {
					$where = "to_branch_id = '".$to_branch_id."'";
				}
			}
			if(!empty($bill_type)) {
				if(!empty($where)) {
					$where = $where." AND bill_type = '".$bill_type."'";
				}
				else {
					$where = "bill_type = '".$bill_type."'";
				}
			}

			if(!empty($consignor_id)) {
				if(!empty($where)) {
					$where = $where." AND consignor_id = '".$consignor_id."'";
				}
				else {
					$where = "consignor_id = '".$consignor_id."'";
				}
			}
			if(!empty($consignee_id)) {
				if(!empty($where)) {
					$where = $where." AND consignee_id = '".$consignee_id."'";
				}
				else {
					$where = "consignee_id = '".$consignee_id."'";
				}
			}
			if(!empty($account_party_id)) {
				if(!empty($where)) {
					$where = $where." AND account_party_id = '".$account_party_id."'";
				}
				else {
					$where = "account_party_id = '".$account_party_id."'";
				}
			}

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT COUNT(id) as lr_count FROM ".$GLOBALS['lr_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
			}
			else {
				$select_query = "SELECT COUNT(id) as lr_count FROM ".$GLOBALS['lr_table']." WHERE deleted = '0' ORDER BY id DESC";
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $row) {
						if(!empty($row['lr_count'])) {
							$lr_count = $row['lr_count'];
						}
					}
				}
			}
			return $lr_count;
		}

		public function getLRList($from_date, $to_date, $organization_id, $lr_number, $from_branch_id, $to_branch_id, $bill_type, $consignor_id, $consignee_id, $account_party_id, $cancelled, $page_start, $page_end) {
			$list = array(); $where = "";
			$where = "cancelled = '".$cancelled."'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(lr_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(lr_date) <= '".$to_date."'";
				}
			}
			if(!empty($organization_id)) {
				if(!empty($where)) {
					$where = $where." AND organization_id = '".$organization_id."'";
				}
				else {
					$where = "organization_id = '".$organization_id."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND lr_number = '".$lr_number."'";
				}
				else {
					$where = "lr_number = '".$lr_number."'";
				}
			}

			if(!empty($from_branch_id)) {
				if(!empty($where)) {
					$where = $where." AND from_branch_id = '".$from_branch_id."'";
				}
				else {
					$where = "from_branch_id = '".$from_branch_id."'";
				}
			}
			if(!empty($to_branch_id)) {
				if(!empty($where)) {
					$where = $where." AND to_branch_id = '".$to_branch_id."'";
				}
				else {
					$where = "to_branch_id = '".$to_branch_id."'";
				}
			}
			if(!empty($bill_type)) {
				if(!empty($where)) {
					$where = $where." AND bill_type = '".$bill_type."'";
				}
				else {
					$where = "bill_type = '".$bill_type."'";
				}
			}

			if(!empty($consignor_id)) {
				if(!empty($where)) {
					$where = $where." AND consignor_id = '".$consignor_id."'";
				}
				else {
					$where = "consignor_id = '".$consignor_id."'";
				}
			}
			if(!empty($consignee_id)) {
				if(!empty($where)) {
					$where = $where." AND consignee_id = '".$consignee_id."'";
				}
				else {
					$where = "consignee_id = '".$consignee_id."'";
				}
			}
			if(!empty($account_party_id)) {
				if(!empty($where)) {
					$where = $where." AND account_party_id = '".$account_party_id."'";
				}
				else {
					$where = "account_party_id = '".$account_party_id."'";
				}
			}

			$select_query = "";
			if(!empty($page_start) && !empty($page_end)) {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['lr_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['lr_table']." WHERE deleted = '0' ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
			}
			else {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['lr_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['lr_table']." WHERE deleted = '0' ORDER BY id DESC";
				}
			}	

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
			}
			return $list;
		}

		public function getTripsheetLuggageSheetNumberByBranch($branch_id) {
			$list = array();
			if(!empty($branch_id)) {
				$luggage_sheet_number_list = array();
				$select_query = "SELECT lr.luggage_sheet_number FROM ".$GLOBALS['lr_table']." as lr
									INNER JOIN ".$GLOBALS['luggage_sheet_table']." as l ON l.luggage_sheet_number = lr.luggage_sheet_number
									WHERE lr.from_branch_id = '".$branch_id."'AND l.tripsheet_number = '".$GLOBALS['null_value']."' AND l.cleared = '0' 
									AND l.cancelled = '0' AND l.deleted = '0' GROUP BY l.luggage_sheet_number ORDER BY l.luggage_sheet_number DESC";
				$luggage_sheet_number_list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
				if(!empty($luggage_sheet_number_list)) {
					foreach($luggage_sheet_number_list as $data) {
						if(!empty($data['luggage_sheet_number'])) {
							$list[] = $data['luggage_sheet_number'];
						}
					}
				}
			}
			return $list;
		}

		public function getTripsheetLRNumberByBranch($branch_id) {
			$list = array();
			if(!empty($branch_id)) {
				$lr_number_list = array();
				$select_query = "SELECT lr_number FROM ".$GLOBALS['lr_table']." WHERE from_branch_id = '".$branch_id."' 
									AND luggage_sheet_number = '".$GLOBALS['null_value']."' AND tripsheet_number = '".$GLOBALS['null_value']."' 
									AND cleared = '0' AND cancelled = '0' AND deleted = '0' ORDER BY lr_number DESC";
				$lr_number_list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
				if(!empty($lr_number_list)) {
					foreach($lr_number_list as $data) {
						if(!empty($data['lr_number'])) {
							$list[] = $data['lr_number'];
						}
					}
				}
			}
			return $list;
		}

		public function getTripsheetNumberList() {
			$list = array(); $tripsheet_number_list = array();
			$select_query = "SELECT tripsheet_number FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY tripsheet_number DESC";
			$tripsheet_number_list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
			if(!empty($tripsheet_number_list)) {
				foreach($tripsheet_number_list as $data) {
					if(!empty($data['tripsheet_number'])) {
						$list[] = $data['tripsheet_number'];
					}						
				}
			}
			return $list;
		}

		public function getTripsheetListCount($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled) {
			$list = array(); $where = ""; $tripsheet_count = 0;
			$where = "cancelled = '".$cancelled."'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) <= '".$to_date."'";
				}
			}
			if(!empty($vehicle_id)) {
				if(!empty($where)) {
					$where = $where." AND vehicle_id = '".$vehicle_id."'";
				}
				else {
					$where = "vehicle_id = '".$vehicle_id."'";
				}
			}
			if(!empty($branch_id)) {
				if(!empty($where)) {
					$where = $where." AND branch_id = '".$branch_id."'";
				}
				else {
					$where = "branch_id = '".$branch_id."'";
				}
			}
			if(!empty($tripsheet_number)) {
				if(!empty($where)) {
					$where = $where." AND tripsheet_number = '".$tripsheet_number."'";
				}
				else {
					$where = "tripsheet_number = '".$tripsheet_number."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND FIND_IN_SET('".$lr_number."', lr_number)";
				}
				else {
					$where = "FIND_IN_SET('".$lr_number."', lr_number)";
				}
			}

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT COUNT(id) as tripsheet_count FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
			}
			else {
				$select_query = "SELECT COUNT(id) as tripsheet_count FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC";
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['tripsheet_count'])) {
							$tripsheet_count = $data['tripsheet_count'];
						}
					}
				}
			}
			return $tripsheet_count;
		}

		public function getTripsheetList($from_date, $to_date, $vehicle_id, $branch_id, $tripsheet_number, $lr_number, $cancelled, $page_start, $page_end) {
			$list = array(); $where = "";
			$where = "cancelled = '".$cancelled."'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) <= '".$to_date."'";
				}
			}
			if(!empty($vehicle_id)) {
				if(!empty($where)) {
					$where = $where." AND vehicle_id = '".$vehicle_id."'";
				}
				else {
					$where = "vehicle_id = '".$vehicle_id."'";
				}
			}
			if(!empty($branch_id)) {
				if(!empty($where)) {
					$where = $where." AND branch_id = '".$branch_id."'";
				}
				else {
					$where = "branch_id = '".$branch_id."'";
				}
			}
			if(!empty($tripsheet_number)) {
				if(!empty($where)) {
					$where = $where." AND tripsheet_number = '".$tripsheet_number."'";
				}
				else {
					$where = "tripsheet_number = '".$tripsheet_number."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND FIND_IN_SET('".$lr_number."', lr_number)";
				}
				else {
					$where = "FIND_IN_SET('".$lr_number."', lr_number)";
				}
			}

			$select_query = "";
			if(!empty($page_start) && !empty($page_end)) {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
			}
			else {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC";
				}
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
			}
			return $list;
		}

		public function getUnAcknowledgedTripsheetList() {
			$list = array();
			$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE acknowledged = '0' AND cancelled = '0' AND deleted = '0' ORDER BY id DESC";
			$list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
			return $list;
		}

		public function getFilterAcknowledgedTripsheetNumberList() {
			$list = array(); $tripsheet_number_list = array();
			$select_query = "SELECT tripsheet_number FROM ".$GLOBALS['tripsheet_table']." WHERE acknowledged = '0' AND cancelled = '0' AND deleted = '0' 
								ORDER BY tripsheet_number DESC";
			$tripsheet_number_list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
			if(!empty($tripsheet_number_list)) {
				foreach($tripsheet_number_list as $data) {
					if(!empty($data['tripsheet_number'])) {
						$list[] = $data['tripsheet_number'];
					}						
				}
			}
			return $list;
		}

		public function getInvoiceAcknowledgedTripsheetNumberListCount($from_date, $to_date, $tripsheet_number) {
			$list = array(); $where = ""; $acknowledged_count = 0;
			$where = "cancelled = '0'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) <= '".$to_date."'";
				}
			}
			if(!empty($tripsheet_number)) {
				if(!empty($where)) {
					$where = $where." AND tripsheet_number = '".$tripsheet_number."'";
				}
				else {
					$where = "tripsheet_number = '".$tripsheet_number."'";
				}
			}

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT COUNT(id) as acknowledged_count FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
			}
			else {
				$select_query = "SELECT COUNT(id) as acknowledged_count FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC";
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['acknowledged_count'])) {
							$acknowledged_count = $data['acknowledged_count'];
						}
					}
				}
			}
			return $acknowledged_count;
		}

		public function getInvoiceAcknowledgedTripsheetNumberList($from_date, $to_date, $tripsheet_number, $page_start, $page_end) {
			$list = array(); $where = "";
			$where = "cancelled = '0'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(tripsheet_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(tripsheet_date) <= '".$to_date."'";
				}
			}
			if(!empty($tripsheet_number)) {
				if(!empty($where)) {
					$where = $where." AND tripsheet_number = '".$tripsheet_number."'";
				}
				else {
					$where = "tripsheet_number = '".$tripsheet_number."'";
				}
			}

			$select_query = "";
			if(!empty($page_start) && !empty($page_end)) {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' 
										ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC LIMIT ".$page_start.", ".$page_end;
				}
			}
			else {
				if(!empty($where)) {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
				}
				else {
					$select_query = "SELECT * FROM ".$GLOBALS['tripsheet_table']." WHERE deleted = '0' ORDER BY id DESC";
				}
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['tripsheet_table'], $select_query);
			}
			return $list;
		}

		public function getUnClearedLRNumberList() {
			$list = array(); $lr_number_list = array();
			$select_query = "SELECT l.lr_number FROM ".$GLOBALS['lr_table']." as l 
								INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
								WHERE l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
								AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC";
			$lr_number_list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
			if(!empty($lr_number_list)) {
				foreach($lr_number_list as $data) {
					if(!empty($data['lr_number'])) {
						$list[] = $data['lr_number'];
					}						
				}
			}
			return $list;
		}

		public function getUnClearedLRListCount($from_date, $to_date, $lr_number) {
			$list = array(); $where = ""; $unclearance_lr_count = 0;
			$where = "";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(lr_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(lr_date) <= '".$to_date."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND lr_number = '".$lr_number."'";
				}
				else {
					$where = "lr_number = '".$lr_number."'";
				}
			}

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT COUNT(l.id) as unclearance_lr_count FROM ".$GLOBALS['lr_table']." as l 
								INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
								WHERE ".$where." AND l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
								AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC";
			}
			else {
				$select_query = "SELECT COUNT(l.id) as unclearance_lr_count FROM ".$GLOBALS['lr_table']." as l 
								INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
								WHERE l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
								AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC";
			}

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['unclearance_lr_count'])) {
							$unclearance_lr_count = $data['unclearance_lr_count'];
						}
					}
				}
			}
			return $unclearance_lr_count;
		}

		public function getUnClearedLRList($from_date, $to_date, $lr_number, $page_start, $page_end) {
			$list = array(); $where = "";
			$where = "";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(lr_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(lr_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(lr_date) <= '".$to_date."'";
				}
			}
			if(!empty($lr_number)) {
				if(!empty($where)) {
					$where = $where." AND lr_number = '".$lr_number."'";
				}
				else {
					$where = "lr_number = '".$lr_number."'";
				}
			}

			$select_query = "";
			if(!empty($page_start) && !empty($page_end)) {
				if(!empty($where)) {
					$select_query = "SELECT l.* FROM ".$GLOBALS['lr_table']." as l 
									INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
									WHERE ".$where." AND l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
									AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC LIMIT ".$page_start.", ".$page_end;
				}
				else {
					$select_query = "SELECT l.* FROM ".$GLOBALS['lr_table']." as l 
									INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
									WHERE l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
									AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC LIMIT ".$page_start.", ".$page_end;
				}
			}
			else {
				if(!empty($where)) {
					$select_query = "SELECT l.* FROM ".$GLOBALS['lr_table']." as l 
									INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
									WHERE ".$where." AND l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
									AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC";
				}
				else {
					$select_query = "SELECT l.* FROM ".$GLOBALS['lr_table']." as l 
									INNER JOIN ".$GLOBALS['tripsheet_table']." as t ON t.tripsheet_number = l.tripsheet_number
									WHERE l.tripsheet_number != '".$GLOBALS['null_value']."' AND t.acknowledged = '1' AND l.cleared = '0' 
									AND l.cancelled = '0' AND l.deleted = '0' ORDER BY l.lr_number DESC";
				}
			}	

			//echo $select_query;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['lr_table'], $select_query);
			}
			return $list;
		}
		
    }
?>