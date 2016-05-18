<?php 
	class ModelServicesMusic extends Model{
		public function getAudioList($genreId){
			if($genreId != 0){
				$query = "SELECT * FROM `genres` ";
				$genreId = $this->db->escape($genreId);
				$query .= "LEFT JOIN `audio` ON `audio`.`genre_id` = `genres`.`id` ";
				$query .= "WHERE `genres`.`id` = '$genreId'";
				$userAudio = $this->db->query($query);
				return $userAudio;
			} else {
				$query = "SELECT * FROM `audio`";
				$userAudio = $this->db->query($query);
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
	}
?>