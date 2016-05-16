<?php
	class ModelMessagesMessages extends Model{
		public function getMessages(){
			$userHash = $this->db->escape($_SESSION['USER']);
			$userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
			if ($userIsset->num_rows > 0){
				$userId = $userIsset->row['user_id'];
			}
			$query = "SELECT * FROM `conversations` WHERE `users` LIKE '%$userId%'";
			$conversation = $this->db->query($query);
			if ($conversation->num_rows > 0){
				$conversation = $conversation->row['id'];
			}

			$query = "SELECT * FROM `conversations` ";
			$query .= "WHERE `users` LIKE '%\"$userId\"%'";

			$result = $this->db->query($query);

			for ($i = 0; $i < $result->num_rows; $i++){
				$userArray = json_decode($result->rows[$i]['users']);
				if ($userArray->users[0] != $userId){
					$companionId = $userArray->users[0];
				} else {
					$companionId = $userArray->users[1];
				}
				$query = "SELECT * FROM `users` WHERE `user_id` = '$companionId'";
				$result->rows[$i]['companion_info'] = $this->db->query($query);
				$result->rows[$i]['conversation_id'] = $result->rows[$i]['id'];

				$query = "SELECT * FROM `messages` WHERE (`user_from` = '$userId' AND `user_to` = '$companionId') ";
				$query .= "OR (`user_from` = '$companionId' AND `user_to` = '$userId') ORDER BY `message_date` DESC LIMIT 0,1";
				$result->rows[$i]['messages'] = $this->db->query($query);
			}

			$result->row['my_user_id'] = $userId;
			$result->row['conversation_id'] = $conversation;

			return $result;
		}

		function updateMessages(){
			$userHash = $this->db->escape($_SESSION['USER']);
			$userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
			if ($userIsset->num_rows == 1){
				$userId = $userIsset->row['user_id'];
			} else {
				die();
			}

			$query = "SELECT * FROM `conversations` ";
			$query .= "WHERE `users` LIKE '%\"$userId\"%'";

			$result = $this->db->query($query);

			for ($i = 0; $i < $result->num_rows; $i++){
				$userArray = json_decode($result->rows[$i]['users']);
				if ($userArray->users[0] != $userId){
					$companionId = $userArray->users[0];
				} else {
					$companionId = $userArray->users[1];
				}
				$query = "SELECT * FROM `users` WHERE `user_id` = '$companionId'";
				$result->rows[$i]['companion_info'] = $this->db->query($query);
				$result->rows[$i]['conversation_id'] = $result->rows[$i]['id'];

				$query = "SELECT * FROM `messages` WHERE ((`user_from` = '$userId' AND `user_to` = '$companionId') ";
				$query .= "OR (`user_from` = '$companionId' AND `user_to` = '$userId')) ORDER BY `message_date` DESC LIMIT 0,1";
				$result->rows[$i]['messages'] = $this->db->query($query);
			}

			$result->row['my_user_id'] = $userId;

			return $result;
		}
	}
?>