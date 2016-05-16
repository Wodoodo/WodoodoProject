<?php
	class ModelServicesSeans extends Model{
		public function getFilms($filmID){
			$films = $this->db->query("SELECT * FROM `films` WHERE `id` = '$filmID'");
			return $film;
		}
	}
?>