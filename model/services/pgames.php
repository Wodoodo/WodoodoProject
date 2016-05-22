<?php
	class ModelServicesPgames extends Model{
		public function getGameInfo($gameId){
			$gameId = $this->db->escape($gameId);

			$query = "SELECT * FROM `games` ";
			$query .= "WHERE `games`.`game_id` = '$gameId'";

			$result['gameInfo'] = $this->db->query($query);

			$playersIsset = $this->db->query("SELECT * FROM `people_play` WHERE `play_game_id` = '$gameId'");
			if ($playersIsset->num_rows > 0) {
				$query = "SELECT * FROM `people_play` ";
				$query .= "JOIN `users` ON `users`.`user_id` = `people_play`.`play_user_id` ";
				$query .= "WHERE `people_play`.`play_game_id` = '$gameId'";

				$result['gamePlayers'] = $this->db->query($query);
			}

			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			$query = "SELECT * FROM `people_play` WHERE `play_user_id` = '$userId' AND `play_game_id` = '$gameId'";

			$issetInList = $this->db->query($query);
			if ($issetInList->num_rows == 1){
				$result['issetInList'] = true;
			} else {
				$result['issetInList'] = false;
			}

			$query = "SELECT * FROM `feedback_game` ";
			$query .= "JOIN `users` ON `users`.`user_id` = `feedback_game`.`feedback_user` ";
			$query .= "WHERE `feedback_game`.`feedback_game_id` = '$gameId' ORDER BY `feedback_game`.`feedback_id` DESC";

			$result['feedback'] = $this->db->query($query);

			return $result;
		}

		public function addInList($gameId){
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			$gameId = $this->db->escape($gameId);

			$query = "SELECT * FROM `people_play` WHERE `play_user_id` = '$userId' AND `play_game_id` = '$gameId'";
			$searchInList = $this->db->query($query);

			if ($searchInList->num_rows > 0){
				$result['status'] = 'error';
				$result['text'] = 'Вы уже в списке';
			} else {
				$query = "INSERT INTO `people_play` ";
				$query .= "(play_user_id, play_game_id) ";
				$query .= "VALUES ('$userId', '$gameId')";
				$this->db->query($query);
				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно добавлены в список';
			}

			return $result;
		}

		public function deleteFromList($gameId){
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			$gameId = $this->db->escape($gameId);

			$query = "SELECT * FROM `people_play` WHERE `play_user_id` = '$userId' AND `play_game_id` = '$gameId'";
			$searchInList = $this->db->query($query);

			if ($searchInList->num_rows > 0){
				$playId = $searchInList->row['play_id'];
				$query = "DELETE FROM `people_play` ";
				$query .= "WHERE `play_id` = '$playId'";
				$this->db->query($query);
				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно удалены из списка';
			} else {
				$result['status'] = 'error';
				$result['text'] = 'Вас уже нету в списке';
			}

			return $result;
		}

		public function addComment($gameId, $data){
			foreach ($data as $key => $value){
				$data[$key] = htmlspecialchars($this->db->escape($value));
			}
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];
			$gameId = $this->db->escape($gameId);

			$query = "SELECT * FROM `feedback_game` WHERE `feedback_user` = '$userId' AND `feedback_game_id` = '$gameId'";

			$commentIsset = $this->db->query($query);
			if ($commentIsset->num_rows > 0){
				$result['status'] = 'error';
				$result['text'] = 'Вы уже оставляли отзыв к данной игре';
			} else {
				$date = date('Y-m-d H:i:s');
				$query = "INSERT INTO `feedback_game` ";
				$query .= "(feedback_game_id, feedback_user, feedback_text, feedback_rate, feedback_date) ";
				$query .= "VALUES ('$gameId', '$userId', '$data[comment_text]', '$data[rate]', '$date')";
				$this->db->query($query);

				$query = "SELECT * FROM `feedback_game` WHERE `feedback_game_id` = '$gameId'";

				$game = $this->db->query($query);
				$newRate = 0;
				for ($i = 0; $i < $game->num_rows; $i++){
					$newRate += $game->rows[$i]['feedback_rate'];
				}

				$newRate = $newRate / $game->num_rows;
				$newRate = $newRate * 10;

				$this->db->query("UPDATE `games` SET `game_rate` = '$newRate' WHERE `game_id` = '$gameId'");

				$result['status'] = 'okay';
				$result['text'] = 'Вы успешно оставили отзыв';
			}

			return $result;
		}
	}
?>