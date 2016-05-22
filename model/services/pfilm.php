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

			$query = "SELECT * FROM `feedback_films` ";
			$query .= "JOIN `users` ON `users`.`user_id` = `feedback_films`.`feedback_user` ";
			$query .= "WHERE `feedback_films`.`feedback_film_id` = '$filmId' ORDER BY `feedback_films`.`feedback_id` DESC";

			$result['feedback'] = $this->db->query($query);

			return $result;
		}

		public function addComment($filmId, $data){
			foreach ($data as $key => $value){
				$data[$key] = htmlspecialchars($this->db->escape($value));
			}
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			$gameId = $this->db->escape($gameId);

			$query = "SELECT * FROM `feedback_films` WHERE `feedback_user` = '$userId' AND `feedback_film_id` = '$filmId'";

			$commentIsset = $this->db->query($query);
			if ($commentIsset->num_rows > 0){
				$result['status'] = 'error';
				$result['text'] = 'Вы уже оставляли отзыв к данной игре';
			} else {
				$date = date('Y-m-d H:i:s');
				$query = "INSERT INTO `feedback_films` ";
				$query .= "(feedback_film_id, feedback_user, feedback_text, feedback_rate, feedback_date) ";
				$query .= "VALUES ('$filmId', '$userId', '$data[comment_text]', '$data[rate]', '$date')";
				$this->db->query($query);

				$query = "SELECT * FROM `feedback_films` WHERE `feedback_film_id` = '$filmId'";

				$game = $this->db->query($query);
				$newRate = 0;
				for ($i = 0; $i < $game->num_rows; $i++){
					$newRate += $game->rows[$i]['feedback_rate'];
				}

				$newRate = $newRate / $game->num_rows;
				$newRate = $newRate * 10;

				$this->db->query("UPDATE `films` SET `rating` = '$newRate' WHERE `id` = '$filmId'");

				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно оставили отзыв';
			}

			return $result;
		}
	}
?>