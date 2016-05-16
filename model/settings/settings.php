<?php
	class ModelSettingsSettings extends Model{
		public function index(){
			
		}

		public function saveUserInfo($userInfo){
			$userHash = $this->db->escape($_SESSION['USER']);
			$this->db->query("UPDATE `users` SET `user_birthday` = '$userInfo[birthday]', `user_phone` = '$userInfo[phone]', `user_twitter` = '$userInfo[twitter]', `user_instagram` = '$userInfo[instagram]', `user_skype` = '$userInfo[skype]', `user_relations` = '$userInfo[relations]', `user_city`='$userInfo[city]' WHERE `user_hash` = '$userHash'");
			ob_end_clean();
			exit(header("Location: /settings/mysettings"));
		}
	}
?>