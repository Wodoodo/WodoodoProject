<?php
	class ModelServicesPfilm extends Model{
		public function getRating($filmURL){
			$result = $this->db->query("SELECT * FROM `films` WHERE `url`='$filmURL'");
			return $result->row['rating'];
		}

		public function getFilmId($filmURL){
			$result = $this->db->query("SELECT * FROM `films` WHERE `url`='$filmURL'");
			return $result->row['id'];
		}

		public function addInList($filmUrl){
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			$query = "SELECT * FROM `films` WHERE `url` = '$filmUrl'";

			$filmIsset = $this->db->query($query);
			$filmId = $filmIsset->row['id'];

			$query = "SELECT * FROM `people_watch` WHERE `watch_user_id` = '$userId' AND `watch_film_id` = '$filmId'";
			$searchInList = $this->db->query($query);

			if ($searchInList->num_rows > 0){
				$result['status'] = 'error';
				$result['text'] = 'Вы уже в списке';
			} else {
				$query = "INSERT INTO `people_watch` ";
				$query .= "(watch_user_id, watch_film_id) ";
				$query .= "VALUES ('$userId', '$filmId')";
				$this->db->query($query);
				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно добавлены в список';
			}

			return $result;
		}

		public function deleteFromList($filmUrl){
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			$query = "SELECT * FROM `films` WHERE `url` = '$filmUrl'";

			$filmIsset = $this->db->query($query);
			$filmId = $filmIsset->row['id'];

			$query = "SELECT * FROM `people_watch` WHERE `watch_user_id` = '$userId' AND `watch_film_id` = '$filmId'";
			$searchInList = $this->db->query($query);

			if ($searchInList->num_rows > 0){
				$playId = $searchInList->row['watch_id'];
				$query = "DELETE FROM `people_watch` ";
				$query .= "WHERE `watch_id` = '$playId'";
				$this->db->query($query);
				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно удалены из списка';
			} else {
				$result['status'] = 'error';
				$result['text'] = 'Вас уже нету в списке';
			}

			return $result;
		}

		public function getWatcher($filmId){
			$playersIsset = $this->db->query("SELECT * FROM `people_watch` WHERE `watch_film_id` = '$filmId'");
			if ($playersIsset->num_rows > 0) {
				$query = "SELECT * FROM `people_watch` ";
				$query .= "JOIN `users` ON `users`.`user_id` = `people_watch`.`watch_user_id` ";
				$query .= "WHERE `people_watch`.`watch_film_id` = '$filmId'";

				$result['gamePlayers'] = $this->db->query($query);
			}

			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			$query = "SELECT * FROM `people_watch` WHERE `watch_user_id` = '$userId' AND `watch_film_id` = '$filmId'";

			$issetInList = $this->db->query($query);
			if ($issetInList->num_rows == 1){
				$result['issetInList'] = true;
			} else {
				$result['issetInList'] = false;
			}

			return $result;
		}
	}
?>