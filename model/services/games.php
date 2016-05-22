<?php 
	class ModelServicesGames extends Model{
		public function getGameList($genre){
			$genre = $this->db->escape($genre);
			$query = "SELECT * FROM `games` ";
			if (strlen($genre) > 0){
				$query .= "WHERE `game_genre` = '$genre'";
			}
			$result = $this->db->query($query);

			return $result;
		}
	}
?>