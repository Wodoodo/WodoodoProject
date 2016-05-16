<?php
	class ModelSettingsSettings extends Model{
		public function index(){
			
		}

		public function saveUserInfo($userInfo){
			$userHash = $this->db->escape($_SESSION['USER']);

			$query = "UPDATE `users` ";
			$query .= "SET `user_birthday` = '$userInfo[birthday]', `user_phone` = '$userInfo[phone]', `user_twitter` = '$userInfo[twitter]', `user_instagram` = '$userInfo[instagram]', `user_skype` = '$userInfo[skype]', `user_relations` = '$userInfo[relations]', `user_city`='$userInfo[city]' ";

			if (isset($userInfo['photo']) && (strlen($userInfo['photo']) > 0)){
				$query .= ", `user_photo` = '$userInfo[photo]' ";
			}

			$query .= " WHERE `user_hash` = '$userHash'";

			$this->db->query($query);
			
			//ob_end_clean();
			//exit(header("Location: /settings/mysettings"));
		}
	}
?>