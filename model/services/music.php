<?php 
	class ModelServicesMusic extends Model{
		public function getAudioList($genreId){
			$query = "SELECT * FROM `genres` ";
			$genreId = $this->db->escape($genreId);
			$query .= "LEFT JOIN `audio` ON `audio`.`genre_id` = `genres`.`id` ";
			if($genreId != 0)
				$query .= "WHERE `genres`.`id` = '$genreId'";
			$userAudio = $this->db->query($query);
			return $userAudio;
		}
	}
?>