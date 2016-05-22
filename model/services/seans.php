<?php
	class ModelServicesSeans extends Model{
		public function getFilms($filmGenre){
			$films = $this->db->query("SELECT * FROM `films` WHERE `genre` LIKE '%$filmGenre%'");
			for($i = 0; $i < $films->num_rows; $i++){
				$film[$i]['name'] = $films->rows[$i]['name'];
				$film[$i]['url'] = $films->rows[$i]['url'];
				$film[$i]['genre'] = $films->rows[$i]['genre'];
				$film[$i]['picture'] = $films->rows[$i]['picture'];
			}
			return $film;
		}

		public function loadFilms($films){
			for($i = 0; $i < count($films); $i++){
				$url = $this->db->escape($films[$i]['url']);
				$result = $this->db->query("SELECT * FROM `films` WHERE `url`='$url'");
				if($result->num_rows == 0){
					$name = $this->db->escape($films[$i]['name']);
					$genre = $this->db->escape($films[$i]['genre']);
					$picture = $this->db->escape($films[$i]['picture']);
					/*$result = preg_match_all('/(.*)(?=до)/', $genre, $genre);
					$genre = $genre[0][0];*/
					$this->db->query("INSERT INTO `films` (name, genre, url, picture) VALUES ('$name', '$genre', '$url', '$picture')");
				}
			}
		}
	}
?>