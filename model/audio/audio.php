<?php
	class ModelAudioAudio extends Model{
		public function getAudioList($userHash){
			$userHash = $this->db->escape($userHash);
			$userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userHash'"); //user_hash

			if ($userIsset->num_rows == 1){
				$userId = $this->db->escape($userIsset->row['user_id']);
				$userAudio = $this->db->query("SELECT * FROM audio LEFT OUTER JOIN user_audio ON audio.id = user_audio.song_id WHERE user_audio.user_id = '$userId' ORDER BY `user_audio`.`id` DESC");

				return $userAudio;
			} else {
				return null;
			}
		}
	}
?>