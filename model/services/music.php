<?php 
	class ModelServicesMusic extends Model{
		public function getAudioList($genreId){
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			if($genreId != 0){
				$query = "SELECT * FROM `genres` ";
				$genreId = $this->db->escape($genreId);
				$query .= "LEFT JOIN `audio` ON `audio`.`genre_id` = `genres`.`id` ";
				$query .= "WHERE `genres`.`id` = '$genreId'";
				$userAudio = $this->db->query($query);
				for ($i = 0; $i < $userAudio->num_rows; $i++){
					$audioId = $userAudio->rows[$i]['id'];
					$query = "SELECT * FROM `user_audio` WHERE `user_id` = '$userId' AND `song_id` = '$audioId'";
					$audioIsset = $this->db->query($query);
					if ($audioIsset->num_rows > 0){
						$userAudio->rows[$i]['issetInUser'] = true;
					} else {
						$userAudio->rows[$i]['issetInUser'] = false;
					}
				}
				return $userAudio;
			} else {
				$query = "SELECT * FROM `audio`";
				$userAudio = $this->db->query($query);
				for ($i = 0; $i < $userAudio->num_rows; $i++){
					$audioId = $userAudio->rows[$i]['id'];
					$query = "SELECT * FROM `user_audio` WHERE `user_id` = '$userId' AND `song_id` = '$audioId'";
					$audioIsset = $this->db->query($query);
					if ($audioIsset->num_rows > 0){
						$userAudio->rows[$i]['issetInUser'] = true;
					} else {
						$userAudio->rows[$i]['issetInUser'] = false;
					}
				}
				return $userAudio;
			}
		}

		public function getGenres(){
			$query = "SELECT * FROM `genres`";
			$result = $this->db->query($query);
			return $result;
		}

		public function searchGenres($value){
			$value = $this->db->escape($value);
			$query = "SELECT * FROM `genres` WHERE `genre_name` LIKE '%$value%'";
			$result = $this->db->query($query);

			return $result;
		}

		public function deleteMusic($musicId){
			$this->load->model('profile/user');
			$musicId = $this->db->escape($musicId);
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			if (isset($userId) && (strlen($userId) > 0)){
				$query = "DELETE FROM `user_audio` WHERE `user_id` = '$userId' AND `song_id` = '$musicId'";
				$this->db->query($query);
			} else {
				die();
			}
		}

		public function addMusic($musicId){
			$this->load->model('profile/user');
			$musicId = $this->db->escape($musicId);
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			if (isset($userId) && (strlen($userId) > 0)){
				$query = "SELECT * FROM `user_audio` WHERE `user_id` = '$userId' AND 'song_id'";
				$audioIsset = $this->db->query($query);
				if ($audioIsset->num_rows <= 0) {
					$query = "INSERT INTO `user_audio` (user_id, song_id) VALUES ('$userId', '$musicId')";
					$this->db->query($query);
				}
			} else {
				die();
			}
		}

		public function getAudioInfo($musicId){
			$musicId = $this->db->escape($musicId);
			$query = "SELECT * FROM `audio` WHERE `id`='$musicId'";
			$result = $this->db->query($query);

			return $result;
		}

		public function updateAudioInfo($musicId, $authorName, $audioName){
			$musicId = $this->db->escape($musicId);
			$audioName = $this->db->escape($audioName);
			$authorName = $this->db->escape($authorName);
			$query = "UPDATE `audio` SET `song_author`='$authorName', `song_name`='$audioName' WHERE `id`='$musicId'";
			$this->db->query($query);
		}
	}
?>