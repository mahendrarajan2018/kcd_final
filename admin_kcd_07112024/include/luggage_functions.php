<?php 
    class Luggage_functions extends Basic_Functions{
        public function LuggagesheetFromList() {
            $user_id = ""; $role_id = ""; $user_list = array(); $branch_ids = array();
            $godown_ids = array(); $permission_check = 0; $godown_list = array();

            if(!empty($GLOBALS['user_id'])) {
                $user_id = $GLOBALS['user_id'];
            }
            if(!empty($user_id)) {
                $user_list = $this->getTableRecords($GLOBALS['user_table'], 'user_id', $user_id, '');
                if(!empty($user_list)) {
                    foreach($user_list as $list) {
                        if(!empty($list['role_id'])) {
                            $role_id = $list['role_id'];
                            if($role_id != $GLOBALS['null_value']) {
                                $permission_check = $this->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'permission_check');
                            }
                        }
                        if(!empty($list['godown_id']) && $list['godown_id'] != $GLOBALS['null_value']) {
                            $godown_ids = $list['godown_id'];
                            $godown_ids = explode(",", $godown_ids);
                        }
                        if(!empty($list['branch_id']) && $list['branch_id'] != $GLOBALS['null_value']) {
                            $branch_ids = $list['branch_id'];
                            $branch_ids = explode(",", $branch_ids);
                        }
                    }
                }
                if(empty($permission_check) || $permission_check == '3') {
                    $godown_list = $this->getTableRecords($GLOBALS['godown_table'], '', '', '');
                }
                else if($permission_check == '1') {
                    if(!empty($godown_ids)) {
                        for($k=0; $k < count($godown_ids); $k++) {
                            $godown_ids_list = array(); $already_present = array();
                            $godown_ids_list = $this->getTableRecords($GLOBALS['godown_table'], 'godown_id', $godown_ids[$k], '');
                            if (!empty($godown_ids_list)) {
                                $already_present = array_intersect(array_column($godown_ids_list, 'godown_id'), array_column($godown_list, 'godown_id'));
                                if (empty($already_present)) {
                                    $godown_list = array_merge($godown_list, $godown_ids_list);
                                }
                            }
                        }
                    }
                }
                else if($permission_check == '2') {
                    if(!empty($branch_ids)) {
                        for($l=0; $l < count($branch_ids); $l++) {
                            $branchwise_godowns = array();
                            $branchwise_godowns = $this->getTableColumnValue($GLOBALS['branch_table'], 'branch_id', $branch_ids[$l], 'godown_id');
                            if(!empty($branchwise_godowns) && $branchwise_godowns != $GLOBALS['null_value']) {
                                $branchwise_godowns = explode(",", $branchwise_godowns);
                                foreach($branchwise_godowns as $godown_id) {
                                    $godown_ids_list = array(); $already_present = array();
                                    $godown_ids_list = $this->getTableRecords($GLOBALS['godown_table'], 'godown_id', $godown_id, '');
                                    if (!empty($godown_ids_list)) {
                                        $already_present = array_intersect(array_column($godown_ids_list, 'godown_id'), array_column($godown_list, 'godown_id'));
                                
                                        if (empty($already_present)) {
                                            $godown_list = array_merge($godown_list, $godown_ids_list);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $godown_list;
        }

        public function LuggagesheetToList($from_location) {
            $select_query = ""; $list = array();
            $select_query = "SELECT * FROM ".$GLOBALS['branch_table']." WHERE FIND_IN_SET('".$from_location."', godown_id) AND deleted = '0' ORDER BY id DESC";
            $list = $this->getQueryRecords('', $select_query);
            return $list;
        }

        public function getLRlistForLuggagesheet($from_location) {
            $from_query = ""; $from_list = array(); $from_branch = array(); $lr_list = array();
            
            $from_query = "SELECT * FROM ".$GLOBALS['branch_table']." WHERE FIND_IN_SET('".$from_location."', godown_id) AND deleted = '0' ORDER BY id DESC";
            $from_list = $this->getQueryRecords('', $from_query);
            if(!empty($from_list)) {
                foreach($from_list as $list) {
                    if(!empty($list['branch_id']) && $list['branch_id'] != $GLOBALS['null_value']) {
                        if(!in_array($list['branch_id'], $from_branch)) {
                            $from_branch[] = $list['branch_id'];
                        }
                    }
                }
            }
            if(!empty($from_branch)) {
                for($d=0; $d < count($from_branch); $d++) {
                    $where = "luggage_sheet_number = '".$GLOBALS['null_value']."' AND tripsheet_number = '".$GLOBALS['null_value']."' AND cancelled = '0' AND "; 
                    $select_query = ""; $list = array(); $already_present = array();
                    if(!empty($from_branch[$d])) {
                        if(!empty($where)) {
                            $where = $where." from_branch_id = '".$from_branch[$d]."' AND ";
                        }
                        else {
                            $where = " from_branch_id = '".$from_branch[$d]."' AND ";
                        }
                    }
                    $select_query = "SELECT * FROM ".$GLOBALS['lr_table']." WHERE ".$where." deleted = '0' ORDER BY id DESC";
                    $list = $this->getQueryRecords('', $select_query);
                    if (!empty($list)) {
                        $already_present = array_intersect(array_column($list, 'lr_id'), array_column($lr_list, 'lr_id'));
                        if (empty($already_present)) {
                            $lr_list = array_merge($lr_list, $list);
                        }
                    }
                }
            }

            return $lr_list;
        }

        public function getLuggageSheetList($from_date, $to_date, $branch_id, $search_text, $cancelled) {
			$list = array(); $where = "";
			$where = "cancelled = '".$cancelled."'";
			if(!empty($from_date)) {
				$from_date = date("Y-m-d", strtotime($from_date));
				if(!empty($where)) {
					$where = $where." AND DATE(entry_date) >= '".$from_date."'";
				}
				else {
					$where = "DATE(entry_date) >= '".$from_date."'";
				}
			}
			if(!empty($to_date)) {
				$to_date = date("Y-m-d", strtotime($to_date));
				if(!empty($where)) {
					$where = $where." AND DATE(entry_date) <= '".$to_date."'";
				}
				else {
					$where = "DATE(entry_date) <= '".$to_date."'";
				}
			}

			if(!empty($branch_id)) {
				if(!empty($where)) {
					$where = $where." AND to_location = '".$branch_id."'";
				}
				else {
					$where = "to_location = '".$branch_id."'";
				}
			}

            if(!empty($search_text)) {
                if(!empty($where)) {
                    $where = $where." AND (lr_number LIKE '%".$search_text."%' OR luggage_sheet_number LIKE '%".$search_text."%')";
                }
                else {
					$where = " AND (lr_number LIKE '%".$search_text."%' OR luggage_sheet_number LIKE '%".$search_text."%')";
				}
            }

			$select_query = "";
			if(!empty($where)) {
				$select_query = "SELECT * FROM ".$GLOBALS['luggage_sheet_table']." WHERE ".$where." AND deleted = '0' ORDER BY id DESC";
			}
			else {
				$select_query = "SELECT * FROM ".$GLOBALS['luggage_sheet_table']." WHERE deleted = '0' ORDER BY id DESC";
			}

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['luggage_sheet_table'], $select_query);
			}
			return $list;
		}
    }
?>