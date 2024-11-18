<?php
	class User_Functions extends Basic_Functions {
		// check current user login ip address
		public function check_user_id_ip_address() {
			$select_query = ""; $list = array(); $check_login_id = "";			
			if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'])) {
					$select_query = "SELECT l.id, u.id as user_unique_id
										FROM ".$GLOBALS['login_table']." as l 
										LEFT JOIN ".$GLOBALS['user_table']." as u ON u.user_id = l.user_id AND u.deleted = '0'
										WHERE l.user_id = '".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']."' 
											AND l.ip_address = '".$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address']."' 
											AND l.logout_date_time = login_date_time ORDER BY l.id DESC LIMIT 1";
					$list = $this->getQueryRecords($GLOBALS['login_table'], $select_query);
					if(!empty($list)) {
						foreach($list as $row) {
							if(preg_match("/^\d+$/", $row['user_unique_id'])) {
								if(!empty($row['id'])) {
									$check_login_id = $row['id'];
								}
							}
						}
					}
				}
			}
			return $check_login_id;
		}
		// check current user is login or not
		public function checkUser() {			
			$user_id = ""; $select_query = ""; $list = array(); $login_user_id = "";
			if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
				$user_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];				
				$today = date('Y-m-d');					
				$select_query = "SELECT l.*, u.id as user_unique_id
									FROM ".$GLOBALS['login_table']." as l
									LEFT JOIN ".$GLOBALS['user_table']." as u ON u.user_id = l.user_id AND u.deleted = '0'
									WHERE l.user_id = '".$user_id."' AND DATE(l.login_date_time) = '".$today."' AND logout_date_time = login_date_time 
									ORDER BY l.id DESC LIMIT 1";
				$list = $this->getQueryRecords($GLOBALS['login_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $row) {
						if(preg_match("/^\d+$/", $row['user_unique_id'])) {
							if(!empty($row['user_id'])) {
								$login_user_id = $row['user_id'];
							}
						}
					}
				}
			}
			return $login_user_id;
		}
		public function getDailyReport($from_date, $to_date) {
            $log_list = array();  $list = array();
			$log_backup_file = "";

			$log_backup_file = "";
			$dirpath = $GLOBALS['log_backup_folder_name'];
			$dirpath .= "/*.csv";
			$csv_files = array();
			$csv_files = glob($dirpath);
			usort($csv_files, function($x, $y) {
				return filemtime($x) < filemtime($y);
			});
			$action_list = array();
			if(!empty($csv_files)) {
				for($i = 0; $i < count($csv_files); $i++) {
					if(!empty($csv_files[$i])) {
						$log_backup_file = $csv_files[$i];
						//echo $i.", log_backup_file - ".$log_backup_file."<br>";
						if(file_exists($log_backup_file)) {
							$myfile = fopen($log_backup_file, "r");
							while(!feof($myfile)) {
								$log = "";
								$log = fgetcsv($myfile);
								if(!empty($log)) {
									//$log = json_decode($log);
									$log_list[] = $log;
								}
							}
							fclose($myfile);
							//print_r($log_list);
							if(!empty($log_list)) {								
								foreach($log_list as $key => $row) {	
									if(!empty($key) && !empty($row)) {
										$success = 0; $action = "";
										foreach($row as $index => $value) {
											if(!empty($value) && $index == 1) {
												//echo "index - ".$index.", value - ".$value.", from_date - ".$from_date.", to_date - ".$to_date."<br>";
												if( ( strtotime(date("d-m-Y", strtotime($value))) >= strtotime($from_date) ) && ( strtotime(date("d-m-Y", strtotime($value))) <= strtotime($to_date) ) ) {
													$success = 1;									
												}
											}
											if(!empty($success) && $success == 1) {
												if($index == 6) {
													$action = $value;
												}
											}
										}	
										//echo "success - ".$success."<br><br>";
										if( (!empty($success) && $success == 1) && !in_array($action, $action_list) ) {
											$list[] = $row;
											$action_list[] = $action;
										}
									}
								}
							}
						}
					}
				}
			}	
			//print_r($list);
			//exit;
			return $list;
        }
		// send email
		public function send_email_details($to_emails, $detail, $title) {
			require_once "PHPMailer/phpmailer.php";

			if ( isset($_SERVER["OS"]) && $_SERVER["OS"] == "Windows_NT" ) {
				$hostname = strtolower($_SERVER["COMPUTERNAME"]);
			} else {
				$hostname = `hostname`;
				$hostnamearray = explode('.', $hostname);
				$hostname = $hostnamearray[0];
			}

			$mail = new PHPMailer();
    
            $mail->SMTPDebug = 0;  // Enable verbose debug output
            //SMTP settings start
            $mail->isSMTP(); // Set mailer to use SMTP
            if ( strpos($hostname, 'cpnl') === FALSE ) //if not cPanel
				$mail->Host = 'relay-hosting.secureserver.net';
			else
				$mail->Host = 'localhost';
				
            $mail->SMTPAuth = false; // Enable SMTP authentication
            $mail->From = 'admin@sridemoapps.in';
			$mail -> FromName = 'Order Form';
			if(!empty($to_emails)) {
				foreach($to_emails as $key => $to) {
					if(!empty($key)) {
						$mail->AddBCC($to);
					}
					if(empty($key)) {
						$mail->addAddress($to);
					}
				}
			}            
			$mail->Subject = $title;
			$mail->Body = $detail;
	
			$mailresult = $mail->Send();
			$mailconversation = nl2br(htmlspecialchars(ob_get_clean())); //captures the output of PHPMailer and htmlizes it
            if ( $mailresult ) {
				$msg = "Successfully Mail send";
            }
            else {
                $msg = 'FAIL: ' . $mail->ErrorInfo . '<br />' . $mailconversation;
            }
			return $msg;
		}
		// send sms
		public function send_mobile_details($company_mobile_number, $number, $sms) {
			$res = true; $sms_link = "";
			if(!empty($company_mobile_number) && !empty($number) && !empty($sms)) {
				//$sms_link = "https://www.fast2sms.com/dev/bulkV2?authorization=VFxWy81QjDk3S2b6qo0JRNHaYCcZs4nmA5Xl7KMuGtwpTIPiUBV6LM5aSg7x84mfP2XyJtshdoFGEBrK&route=dlt&sender_id=SRISOF&message=126873&variables_values=".$msg."|&flash=0&numbers=".$mobile_number;
				$fields = array(
					"sender_id" => "SRISOF",
					"message" => $number,
					"variables_values" => $sms,
					"route" => "dlt",
					"numbers" => $company_mobile_number,
				);
				
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => json_encode($fields),
				  CURLOPT_HTTPHEADER => array(
					"authorization: VFxWy81QjDk3S2b6qo0JRNHaYCcZs4nmA5Xl7KMuGtwpTIPiUBV6LM5aSg7x84mfP2XyJtshdoFGEBrK",
					"accept: */*",
					"cache-control: no-cache",
					"content-type: application/json"
				  ),
				));
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				/*if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				  echo $response;
				}*/
			}
			/*$phone_number = '91'.$phone_number;
			$mailin = new MailinSms($GLOBALS['mailin_sms_api_key']);
			$mailin->addTo($phone_number);
			$mailin->setFrom('ram');
			$mailin->setText($msg);
			$mailin->setTag('');
			$mailin->setType('');
			$mailin->setCallback('');
			$res = $mailin->send();*/
			return $res;
		}
		
		public function getOTPNumber() {
			$select_query = ""; $list = array(); $new_otp_number = ""; $otp_unique_id = ""; $otp_number = mt_rand(1000, 9999);
			if(!empty($otp_number)) {
				$otp_unique_id = $this->getTableColumnValue($GLOBALS['otp_table'], 'otp_number', $otp_number, 'id');
				if(!empty($otp_unique_id)) {
					$this->getOTPNumber();
				}
				else {
					$new_otp_number = $otp_number;
				}
			}
			return $new_otp_number;
		}

		public function getOTPSendCount($otp_send_date, $otp_receive) {
            $select_query = ""; $list = array(); $otp_send_count = 0;
			if(!empty($otp_send_date) && !empty($otp_receive)) {
				$select_query = "SELECT SUM(otp_send_count) as otp_send_count FROM ".$GLOBALS['otp_table']." WHERE send_date = '".$otp_send_date."' 
									AND (phone_number = '".$otp_receive."' OR email = '".$otp_receive."') AND deleted = '0' ORDER BY id DESC";
				$list = $this->getQueryRecords($GLOBALS['otp_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['otp_send_count'])) {
							$otp_send_count = $data['otp_send_count'];
						}
					}
				}
			}
			return $otp_send_count;
        }

		public function getOTPSendUniqueID($otp_send_date, $otp_receive) {
            $select_query = ""; $list = array(); $unique_id = "";
			if(!empty($otp_send_date) && !empty($otp_receive)) {
				$select_query = "SELECT id FROM ".$GLOBALS['otp_table']." WHERE send_date = '".$otp_send_date."' 
									AND (phone_number = '".$otp_receive."' OR email = '".$otp_receive."') AND deleted = '0' ORDER BY id DESC LIMIT 1";
				$list = $this->getQueryRecords($GLOBALS['otp_table'], $select_query);
				if(!empty($list)) {
					foreach($list as $data) {
						if(!empty($data['id'])) {
							$unique_id = $data['id'];
						}
					}
				}
			}
			return $unique_id;
        }	
		public function image_directory() {
			$target_dir = "../images/upload/";
			return $target_dir;
		}
		public function temp_image_directory() {
			$temp_dir = "../images/temp/";
			return $temp_dir;
		}
		public function clear_temp_image_directory() {
			$temp_dir = "../images/temp/";
			
			$files = glob($temp_dir.'*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
				unlink($file); // delete file
			}
			
			return true;
		}
		
		 // check access page permission
		public function CheckStaffAccessPage($role_id, $permission_page) {
			$list = array(); $select_query = ""; $acccess_permission = 0;
			if(!empty($role_id)) {
				$select_query = "SELECT * FROM ".$GLOBALS['role_table']." WHERE role_id = '".$role_id."' AND deleted = '0'";
			}
			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['role_table'], $select_query);
				if(!empty($list)) {
					$access_pages = "";
					foreach($list as $data) {
						if(!empty($data['access_pages'])) {
							$access_pages = $data['access_pages'];
						}
					}

					if(!empty($access_pages)) {
						$access_pages = explode(",", $access_pages);					
						if(!empty($permission_page)) {
							$permission_page = $this->encode_decode('encrypt', $permission_page);
							if(in_array($permission_page, $access_pages)) {
								$acccess_permission = 1;
							}
						}
					}
				}
			}
			return $acccess_permission;
		}
	}	
?>