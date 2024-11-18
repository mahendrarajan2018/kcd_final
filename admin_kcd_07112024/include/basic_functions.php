<?php
	include("kcdlogistics_07112024.php");
	class Basic_Functions extends db {
		public $con;
		
		public function connect() {
			$con = parent::connect();
			return $con;
		}

		public function encode_decode($action, $string) {
			$output = "";
			//encode
			if($action == 'encrypt') {
				$string = htmlentities($string, ENT_QUOTES);
				$output = base64_encode($string);
				$output =  bin2hex($output);
				//$output = gzcompress($output, 9);
			}			
			//decode
			if($action == 'decrypt') {
				//$output = gzuncompress($string);
				//echo "string  - ".$string."<br>"; 
				$output = hex2bin($string);
				$output = base64_decode($output);
				$output = html_entity_decode($output);
			}
			return $output;
		}

		// get last record id before insert
		public function getLastRecordIDFromTable($table) {
			$max_unique_id = ""; $list = array();				
			$select_query = "SELECT id FROM ".$table." ORDER BY id DESC LIMIT 1";
			$list = $this->getQueryRecords($table, $select_query);
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['id'])) {
						$max_unique_id = $data['id'];
					}
				}
			}
			return $max_unique_id;
		}

		public function automate_number($table, $column) {
			$last_number = ""; $next_number = "";

			$prefix = "";
			if(!empty($table)) {
				if($table == $GLOBALS['lr_table']) { $prefix = "P"; }
				else if($table == $GLOBALS['luggage_sheet_table']) { $prefix = "LC"; }
				else if($table == $GLOBALS['tripsheet_table']) { $prefix = "TS"; }
			}
			if(!empty($prefix)) {
				$prefix = "/".$prefix;
			}

			//echo "last_number - ".$last_number."<br>";

			$from_date = ""; $to_date = "";
			if(isset($_SESSION['billing_year_starting_date']) && !empty($_SESSION['billing_year_starting_date'])) {
				$from_date = $_SESSION['billing_year_starting_date'];
				if(!empty($from_date)) {
					$from_date = date("Y-m-d", strtotime($from_date));
				}
			}			
			if(isset($_SESSION['billing_year_ending_date']) && !empty($_SESSION['billing_year_ending_date'])) {
				$to_date = $_SESSION['billing_year_ending_date'];
				if(!empty($to_date)) {
					$to_date = date("Y-m-d", strtotime($to_date));
				}
			}

			$bill_rows = 0;
			if(!empty($from_date) && !empty($to_date)) {
				$select_query = ""; $list = array();
				if($table == $GLOBALS['lr_table']) {
					$select_query = "SELECT COUNT(id) as bill_rows FROM ".$table." WHERE DATE(lr_date) >= '".$from_date."' AND DATE(lr_date) <= '".$to_date."' 
										ORDER BY id DESC";
				}
				else if($table == $GLOBALS['luggage_sheet_table']) {
					$select_query = "SELECT COUNT(id) as bill_rows FROM ".$table." WHERE DATE(entry_date) >= '".$from_date."' AND DATE(entry_date) <= '".$to_date."' 
										ORDER BY id DESC";	
				}
				else if($table == $GLOBALS['tripsheet_table']) {
					$select_query = "SELECT COUNT(id) as bill_rows FROM ".$table." WHERE DATE(tripsheet_date) >= '".$from_date."' AND DATE(tripsheet_date) <= '".$to_date."' 
										ORDER BY id DESC";	
				}
				if(!empty($select_query)) {
					$list = $this->getQueryRecords($table, $select_query);
					if(!empty($list)) {
						foreach($list as $data) {
							if(!empty($data['bill_rows'])) {
								$bill_rows = $data['bill_rows'];
							}
						}
					}
				}
				//echo "bill_rows - ".$bill_rows."<br>";
				if(!empty($bill_rows) && $bill_rows == 1) { $next_number = 1; }
				else {
					if($table == $GLOBALS['lr_table']) {
						$select_query = "SELECT MAX(CAST(SUBSTRING_INDEX(".$column.", '/', 1) AS UNSIGNED)) AS max_number FROM ".$table." WHERE ".$column." != '' 
											AND DATE(lr_date) >= '".$from_date."' AND DATE(lr_date) <= '".$to_date."' AND ".$column." REGEXP '[0-9]+/[a-zA-Z]'";
					}
					else if($table == $GLOBALS['luggage_sheet_table']) {
						$select_query = "SELECT MAX(CAST(SUBSTRING_INDEX(".$column.", '/', 1) AS UNSIGNED)) AS max_number FROM ".$table." WHERE ".$column." != '' 
											AND DATE(entry_date) >= '".$from_date."' AND DATE(entry_date) <= '".$to_date."' 
											AND ".$column." REGEXP '[0-9]+/[a-zA-Z]'";
					}
					else if($table == $GLOBALS['tripsheet_table']) {
						$select_query = "SELECT MAX(CAST(SUBSTRING_INDEX(".$column.", '/', 1) AS UNSIGNED)) AS max_number FROM ".$table." WHERE ".$column." != '' 
											AND DATE(tripsheet_date) >= '".$from_date."' AND DATE(tripsheet_date) <= '".$to_date."' 
											AND ".$column." REGEXP '[0-9]+/[a-zA-Z]'";	
					}	
					//echo $select_query."<br>";
					$list = $this->getQueryRecords($table, $select_query);
					if(!empty($list)) {
						foreach($list as $data) {
							if(!empty($data['max_number'])) {
								$last_number = $data['max_number'];
							}
						}
					}
				}
			}

			if(!empty($last_number) && !empty($bill_rows)) {	 
				//echo "last_number - ".$last_number.", prefix - ".$prefix."<br>";
				if(preg_match("/^\d+$/", $last_number)) {
					$next_number = $last_number + 1;
				}
			}
			if(!empty($next_number) && !empty($prefix)) {
				$next_number = $next_number.$prefix;
			}

			//echo "next_number - ".$next_number."<br>";

			return $next_number;
		}

		// insert records to table
		public function InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action) {
			$con = $this->connect(); $last_insert_id = "";
			
			if(!empty($columns) && !empty($values)) {
				if(count($columns) == count($values)) {					
					$columns = implode(",", $columns);
					$values = implode(",", $values);

					$last_record_id = 0;
                	$last_record_id = $this->getLastRecordIDFromTable($table);
					
					$result = "";
					$insert_query = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
					//echo $insert_query."<br>";
					$result = $con->prepare($insert_query);
					if($result->execute() === TRUE) {
						$last_insert_id = $con->lastInsertId();
						$last_query_insert_id = "";
						if(preg_match("/^\d+$/", $last_insert_id)) {
							if(!empty($custom_id)) {
								$unique_number_value = "";
								if(!empty($unique_number)) {
									$unique_number_value = $this->automate_number($table, $unique_number);
									/*if(!empty($unique_number_value)) {                    
										$unique_number_value = $this->encode_decode('encrypt', strtoupper($unique_number_value));
									}*/							
								}

								$custom_id_value = "";
								if($last_insert_id < 10) {
									$custom_id_value = date("dmYhis")."_0".$last_insert_id;
								}
								else {
									$custom_id_value = date("dmYhis")."_".$last_insert_id;
								}

								if(!empty($custom_id_value)) {
									$custom_id_value = $this->encode_decode('encrypt', $custom_id_value);
								}
								$columns = array(); $values = array(); $update_id = "";	
								if(!empty($unique_number) && !empty($unique_number_value)) {
									$columns = array($custom_id, $unique_number);
									$values = array("'".$custom_id_value."'", "'".$unique_number_value."'");
								}	
								else {			
									$columns = array($custom_id);
									$values = array("'".$custom_id_value."'");
								}
								$update_id = $this->UpdateSQL($table, $last_insert_id, $columns, $values, '');
								if(preg_match("/^\d+$/", $update_id)) {
									$last_log_id = $this->add_log($table, $last_insert_id, $insert_query, $action);			
								}
							}
							else {
								$last_log_id = $this->add_log($table, $last_insert_id, $insert_query, $action);
							}
						}
					}
					else {
						$last_insert_id = "Unable to insert the data";
					}
				}
				else {
					$last_insert_id = "Columns are not match";
				}
			}			
					
			return $last_insert_id;
		}
		// add log to csv file
		public function add_log($table, $table_unique_id, $query, $action) {
			$con = $this->connect(); $last_query_insert_id = "";
			if(!empty($query) && !empty($action)) {
				$query = $this->encode_decode('encrypt', $query);
				$action = $this->encode_decode('encrypt', $action);
				$table = $this->encode_decode('encrypt', $table);
			
				$create_date_time = $GLOBALS['create_date_time_label'];
				$creator = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
					$creator = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
				}
				$creator_type = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
					$creator_type = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']);
				}
				$creator_name = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
					$creator_name = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']);
				}
				$creator_mobile_number = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'])) {
					$creator_mobile_number = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']);
				}

				/*echo "create_date_time - ".$create_date_time."<br>";
				echo "creator_type - ".$creator_type."<br>";
				echo "creator_name - ".$creator_name."<br>";
				echo "creator_mobile_number - ".$creator_mobile_number."<br>";
				echo "table - ".$table."<br>";
				echo "table_unique_id - ".$table_unique_id."<br>";
				echo "action - ".$action."<br>";
				echo "query - ".$query."<br>";
				exit;*/

				//$log_backup_file = $GLOBALS['log_backup_file'];

				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				$log_backup_file = "";
				$dirpath = $GLOBALS['log_backup_folder_name'];
				$dirpath .= "/*.csv";
				$csv_files = array();
				$csv_files = glob($dirpath);
				usort($csv_files, function($x, $y) {
					return filemtime($x) < filemtime($y);
				});
				if(!empty($csv_files)) {
					$last_created_file = "";
					$last_created_file = $csv_files['0'];
					if(!empty($last_created_file)) {
						$log_backup_file = $last_created_file;
					}
				}
				if(empty($log_backup_file)) {
					$log_backup_file = $GLOBALS['log_backup_folder_name']."/log_".date("d_m_Y").".csv";
				}
				if(!empty($log_backup_file)) {
					if (strpos($actual_link, $GLOBALS['admin_folder_name']) == false) {
						$log_backup_file = $GLOBALS['admin_folder_name']."/".$log_backup_file;
					}
				}

				$columns = array('type', 'created_date_time', 'creator_name', 'log_table', 'log_table_unique_id', 'action', 'query');	
				$values = array("'".$creator_type."'", "'".$create_date_time."'", "'".$creator_name."'", "'".$table."'", "'".$table_unique_id."'", "'".$action."'", "'".$query."'");			
				/*if(count($columns) == count($values)) {	
					$log_data = array();
					$log_data = array('type' => $creator_type, 'created_date_time' => $create_date_time, 'creator' => $creator, 'creator_name' => $creator_name, 'creator_mobile_number' => $creator_mobile_number, 'table' => $table, 'table_unique_id' => $table_unique_id, 'action' => $action, 'query' => $query);	
					if(!empty($log_data)) {
						$log_data = json_encode($log_data);
						
						if(file_exists($log_backup_file)) {
							file_put_contents($log_backup_file, $log_data, FILE_APPEND | LOCK_EX);
							file_put_contents($log_backup_file, "\n", FILE_APPEND | LOCK_EX);
						}
						else {
							$myfile = fopen($log_backup_file, "a+");
							fwrite($myfile, $log_data."\n");
							fclose($myfile);
						}
					}
				}*/
				if(count($columns) == count($values)) {	
					$log_data = array();
					$log_data = array('type' => $creator_type, 'created_date_time' => $create_date_time, 'creator' => $creator, 'creator_name' => $creator_name, 'table' => $table, 'table_unique_id' => $table_unique_id, 'action' => $action, 'query' => $query);	
					if(!empty($log_data)) {
						$log_data = json_encode($log_data);	
						$values = array($creator_type, $create_date_time, $creator, $creator_name, $table, $table_unique_id, $action, $query);

						//echo "log_backup_file - ".$log_backup_file."<br>";

						if(file_exists($log_backup_file)) {
							$backup_file_size = 0;
							$backup_file_size = filesize($log_backup_file);

							if($backup_file_size > 0) {
								$backup_file_size = $backup_file_size / 1048576;

								$backup_files_count = 0; $max_log_file_size_mb = 0;
								$backup_files_count = count(glob($GLOBALS['log_backup_folder_name']."/*"));
								$max_log_file_size_mb = $GLOBALS['max_log_file_size_mb'];
								/*if(!empty($max_log_file_size_mb)) {
									$max_log_file_size_mb = $max_log_file_size_mb  * 1000000;
								}*/
								//echo "backup_file_size - ".$backup_file_size.", max_log_file_size_mb - ".$max_log_file_size_mb."<br>";
								if(!empty($backup_file_size) && !empty($max_log_file_size_mb) && $backup_file_size > $max_log_file_size_mb) {
									$backup_files_count = $backup_files_count + 1;
									$log_backup_file = $GLOBALS['log_backup_folder_name']."/log_".date("d_m_Y").".csv";
									if(!empty($log_backup_file)) {
										if (strpos($actual_link, $GLOBALS['admin_folder_name']) == false) {
											$log_backup_file = $GLOBALS['admin_folder_name']."/".$log_backup_file;
										}
									}
									$fp = fopen($log_backup_file,"w");
									$log_headings = array('type', 'created_date_time', 'creator', 'creator_name', 'creator_mobile_number', 'table', 'table_unique_id', 'action', 'query');
									fputcsv( $fp, $log_headings);
									fclose($fp);

									$myfile = fopen($log_backup_file, "a");
									fputcsv($myfile, $values);
									fclose($myfile);
								}
								else {
									$myfile = fopen($log_backup_file, "a");
									fputcsv($myfile, $values);
									fclose($myfile);

									$max_log_file_count = $GLOBALS['max_log_file_count'];
									//echo "backup_files_count - ".$backup_files_count.", max_log_file_count - ".$max_log_file_count;
									if(!empty($max_log_file_count) && $backup_files_count > $max_log_file_count) {
										$dirpath = $GLOBALS['log_backup_folder_name'];
										// set file pattern
										$dirpath .= "/*.csv";
										// copy filenames to array
										$csv_files = array();
										$csv_files = glob($dirpath);
										// sort files by last modified date
										usort($csv_files, function($x, $y) {
											return filemtime($x) < filemtime($y);
										});
										if(!empty($csv_files)) {
											$first_created_file = "";
											$first_created_file = $csv_files[count($csv_files) - 1];
											if(!empty($first_created_file)) {
												$last_modified_date_time = ""; $current_date_time = date("d-m-Y H:i:s");
												$last_modified_date_time = date ("d-m-Y H:i:s", filemtime($first_created_file));
												$datediff = strtotime($current_date_time) - strtotime($last_modified_date_time);
												$log_no_of_days = 0;
												$log_no_of_days = round($datediff / (60 * 60 * 24));
												if($log_no_of_days > $GLOBALS['expire_log_file_days']) {
													unlink($first_created_file);
												}
											}
										}
									}
								}
							}
						}
						else {
							$fp = fopen($log_backup_file,"w");
							$log_headings = array('type', 'created_date_time', 'creator', 'creator_name', 'creator_mobile_number', 'table', 'table_unique_id', 'action', 'query');
							fputcsv( $fp, $log_headings);
							fclose($fp);

							$myfile = fopen($log_backup_file, "a");
							fputcsv($myfile, $values);
							fclose($myfile);
						}

					}
				}
			}			
					
			return $last_query_insert_id;
		}
		// update records to table
		public function UpdateSQL($table, $update_id, $columns, $values, $action) {
			$con = $this->connect(); $updated_data = ''; $msg = "";
			
			if(!empty($columns) && !empty($values)) {
			
				if(count($columns) == count($values)) {					
					for($r = 0; $r < count($columns); $r++) {
						$updated_data = $updated_data.$columns[$r]." = ".$values[$r]."";
						if(!empty($columns[$r+1])) {
							$updated_data = $updated_data.', ';
						}	
					}
					if(!empty($updated_data)) {
						$updated_data = trim($updated_data);
						$update_query = "UPDATE ".$table." SET ".$updated_data." WHERE id='".$update_id."'";
						//echo $update_query."<br>";
						$result = $con->prepare($update_query);
						if($result->execute() === TRUE) {
							$msg = 1;							
							$last_log_id = $this->add_log($table, $update_id, $update_query, $action);
						}
						else {
							$msg = "Unable to update the data";
						}
					}
					else {
						$msg = "Unable to update the data";
					}
				}
				else {
					$msg = "Columns are not match";
				}
			}
					
			return $msg;	
		}
		// get particular column value of table
		public function getTableColumnValue($table, $column, $value, $return_value) {
			$table_column_value = ""; $select_query = ""; $list = array();
			if(!empty($column) && !empty($value) && !empty($return_value)) {
				 $select_query = "SELECT ".$return_value." FROM ".$table." WHERE ".$column." = '".$value."' AND deleted = '0'";	
				//echo $select_query."<br>";
				if(!empty($select_query)) {
					$list = $this->getQueryRecords($table, $select_query);
					if(!empty($list)) {
						foreach($list as $row) {
							$table_column_value = $row[$return_value];
						}
					}
				}
			}
			return $table_column_value;
		}
		// get all values of table
		public function getTableRecords($table, $column, $value, $order) {
			$select_query = ""; $list = array();

			if(empty($order)) {
				$order = "DESC";
			}

			if(!empty($table)) {
				if(!empty($column) && !empty($value)) {		
					$select_query = "SELECT * FROM ".$table." WHERE ".$column." = '".$value."' AND deleted = '0' ORDER BY id ".$order;	
				}
				else if(empty($column) && empty($value)) {		
					$select_query = "SELECT * FROM ".$table." WHERE deleted = '0' ORDER BY id ".$order;	
				}
			}			
			//echo $select_query."<br>";
			if(!empty($select_query)) {
				$list = $this->getQueryRecords($table, $select_query);
			}
			return $list;
		}

		// get all values of table use query
		public function getQueryRecords($table, $select_query) {
			$con = $this->connect(); $list = array();
			//echo $select_query."<br>";
			if(!empty($select_query)) {
				$result = 0; $pdo = "";			
				$pdo = $con->prepare($select_query);
				$pdo->execute();	
				$result = $pdo->setFetchMode(PDO::FETCH_ASSOC);
				if(!empty($result)) {
					foreach($pdo->fetchAll() as $row) {
						$list[] = $row;
					}
				}
			}
			return $list;
		}
		// get backup of database tables
		public function daily_db_backup() {
			$path = $GLOBALS['backup_folder_name']."/";

			$con = $this->connect();
			$backupAlert = 0; $backup_file = ""; $file_name = ""; $dbname = $this->db_name;
			$tables = array();
			//$result = mysqli_query($con, "SHOW TABLES");
			$select_query = "SHOW TABLES";
			$result = 0; $pdo = "";			
			$pdo = $con->prepare($select_query);
			$pdo->execute();	
			$result = $pdo->fetchAll(PDO::FETCH_COLUMN); 
			if (!empty($result)) {
				$tables = array();
				foreach($result as $table_name) {
					if(!empty($table_name)) {
						$tables[] = $table_name;
					}
				}
				$output = '';
				if(!empty($tables)) {
					foreach($tables as $table) {
						if (strpos($table, $GLOBALS['table_prefix']) !== false) {
							$show_table_query = "SHOW CREATE TABLE " . $table . "";
							$statement = $con->prepare($show_table_query);
							$statement->execute();
							$show_table_result = $statement->fetchAll();

							foreach($show_table_result as $show_table_row) {
								$output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
							}
							$select_query = "SELECT * FROM " . $table . "";
							$statement = $con->prepare($select_query);
							$statement->execute();
							$total_row = $statement->rowCount();
							for($count=0; $count<$total_row; $count++) {
								$single_result = $statement->fetch(\PDO::FETCH_ASSOC);
								$table_column_array = array_keys($single_result);
								$table_value_array = array_values($single_result);
								$output .= "\nINSERT INTO $table (";
								$output .= "" . implode(", ", $table_column_array) . ") VALUES (";
								$output .= "'" . implode("','", $table_value_array) . "');\n";
							}
						}	
					}
				}

				if(!empty($output)) {
					$file_name = $dbname.'.sql';
					$backup_file = $path.$file_name;
					file_put_contents($backup_file, $output);
					if(file_exists($backup_file)) {
						$backupAlert = 1;
					}
				}
			}

			$msg = "";
			if(!empty($backupAlert) && $backupAlert == 1) {
				$msg = $backup_file;
			}
			else {
				$msg = $backupAlert;
			}
			return $msg;
		}

		public function numberFormat($number, $decimals = 0) {
			if (strpos($number,'.') != null) {
				$decimalNumbers = substr($number, strpos($number,'.'));
				$decimalNumbers = substr($decimalNumbers, 1, $decimals);
			}
			else {
				$decimalNumbers = 0;
				for ($i = 2; $i <=$decimals ; $i++) {
					$decimalNumbers = $decimalNumbers.'0';
				}
			}	
			$number = (int) $number;
			// reverse
			$number = strrev($number);	
			$n = '';
			$stringlength = strlen($number);
	
			for ($i = 0; $i < $stringlength; $i++) {
				if ($i%2==0 && $i!=$stringlength-1 && $i>1) {
					$n = $n.$number[$i].',';
				}
				else {
					$n = $n.$number[$i];
				}
			}
	
			$number = $n;
			// reverse
			$number = strrev($number);
				
			($decimals!=0)? $number=$number.'.'.$decimalNumbers : $number ;

			if(!empty($number)) {
				if (strpos( $number, "." ) !== false) {
					$pos = strpos($number, ".");
					$decimal = substr($number, ($pos + 1), strlen($number));
					if($decimal != "00") {
						if(strlen($decimal) == 1) {
							$number = $number."0";
						}                                     
					}
				}
			}
	
			return $number;
		}
		
		public function truncate_number( $number, $precision = 2) {
			// Zero causes issues, and no need to truncate
			if ( 0 == (int)$number ) {
				return $number;
			}
			// Are we negative?
			$negative = $number / abs($number);
			// Cast the number to a positive to solve rounding
			$number = abs($number);
			// Calculate precision number for dividing / multiplying
			$precision = pow(10, $precision);
			// Run the math, re-applying the negative value to ensure returns correctly negative / positive
			return floor( $number * $precision ) / $precision * $negative;
		}

		public function SortingImages($images, $positions) {
			$sorted_images_list = array(); $image_position_list = array();
			for($i = 0; $i < count($images); $i++) {
				if(!empty($images[$i]) && !empty($positions[$i])) {
					$image_position_list[$i] = array('image' => $images[$i], 'position' => $positions[$i]);
				}
			}
			if(!empty($image_position_list)) {
				$values = array();
				foreach ($image_position_list as $key => $row) {
					$values[$key] = $row['position'];
				}
				array_multisort($values, SORT_ASC, $image_position_list);
				if(!empty($image_position_list)) {
					foreach($image_position_list as $key => $val) {
						if(!empty($val['image'])) {
							$sorted_images_list[] = $val['image'];
						}
					}
				}
			}
			return $sorted_images_list;
		}
	}	
?>