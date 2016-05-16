<?php
	class ModelFriendsFriends extends Model{
		public function index(){

		}

		public function getFriends($userId){
			$friends  = $this->db->query("SELECT * FROM `friends` WHERE `user_id` = '$userId' OR `friend_id`='$userId' ORDER BY `id` DESC");

            for ($i = 0; $i < $friends->num_rows; $i++){
            	if ($friends->rows[$i]['user_id'] != $userId){
					$userFriends = $this->db->escape($friends->rows[$i]['user_id']);
				} else {
					$userFriends = $this->db->escape($friends->rows[$i]['friend_id']);
				}
				$friends->rows[$i]['id'] = $userFriends;
				$friends->rows[$i]['userId'] = $userId;
                $userFriends = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userFriends'");
                $friends->rows[$i]['user_name'] = $userFriends->row['user_firstname'] . ' ' . $userFriends->row['user_lastname'];
                $friends->rows[$i]['last_activity'] = $userFriends->row['last_activity'];
                $friends->rows[$i]['user_photo'] = $userFriends->row['user_photo'];
                ($userFriends->row['user_birthday'] != 0) ? $friends->rows[$i]['fullYears'] = getFullYears($userFriends->row['user_birthday']) . " лет" : $friends->rows[$i]['fullYears'] = '';
                if($userFriends->row['user_city'] != 0){
                    $cityId = $this->db->escape($userFriends->row['user_city']);
                    $cityId = $this->db->query("SELECT * FROM `cities` WHERE `id`='$cityId'"); 
                    $friends->rows[$i]['city'] = $cityId->row['city_name'] . ", ";  
                } else {
                    $friends->rows[$i]['city'] = '';
                }
            }

            return $friends;
		}

		public function getIncomingRequests($userId){
			$requests  = $this->db->query("SELECT * FROM `requests` WHERE `recipient_id` = '$userId' ORDER BY `request_id` DESC");

            for ($i = 0; $i < $requests->num_rows; $i++){
                $userSender = $this->db->escape($requests->rows[$i]['sender_id']);
                $userSender = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userSender'");
                $requests->rows[$i]['recipient'] = $userId;
                $requests->rows[$i]['user_name'] = $userSender->row['user_firstname'] . ' ' . $userSender->row['user_lastname'];
                $requests->rows[$i]['last_activity'] = $userSender->row['last_activity'];
                $requests->rows[$i]['user_photo'] = $userSender->row['user_photo'];
                ($userSender->row['user_birthday'] != 0) ? $requests->rows[$i]['fullYears'] = getFullYears($userSender->row['user_birthday']) . " лет" : $requests->rows[$i]['fullYears'] = '';
            	if($userSender->row['user_city'] != 0){
                    $cityId = $this->db->escape($userSender->row['user_city']);
                    $cityId = $this->db->query("SELECT * FROM `cities` WHERE `id`='$cityId'"); 
                    $requests->rows[$i]['city'] = $cityId->row['city_name'] . ", ";  
                } else {
                    $requests->rows[$i]['city'] = '';
                }
            }

            return $requests;
		}

		public function getOutgingRequests($userId){
			$requests  = $this->db->query("SELECT * FROM `requests` WHERE `sender_id` = '$userId' ORDER BY `request_id` DESC");

            for ($i = 0; $i < $requests->num_rows; $i++){
                $userRecipient = $this->db->escape($requests->rows[$i]['recipient_id']);
                $userRecipient = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userRecipient'");
                $requests->rows[$i]['sender'] = $userId;
                $requests->rows[$i]['user_name'] = $userRecipient->row['user_firstname'] . ' ' . $userRecipient->row['user_lastname'];
                $requests->rows[$i]['last_activity'] = $userRecipient->row['last_activity'];
                $requests->rows[$i]['user_photo'] = $userRecipient->row['user_photo'];
                ($userRecipient->row['user_birthday'] != 0) ? $requests->rows[$i]['fullYears'] = getFullYears($userRecipient->row['user_birthday']) . " лет" : $requests->rows[$i]['fullYears'] = '';
                if($userRecipient->row['user_city'] != 0){
                    $cityId = $this->db->escape($userRecipient->row['user_city']);
                    $cityId = $this->db->query("SELECT * FROM `cities` WHERE `id`='$cityId'"); 
                    $requests->rows[$i]['city'] = $cityId->row['city_name'] . ", ";  
                } else {
                    $requests->rows[$i]['city'] = '';
                }
            }

            return $requests;
		}
	}
?>