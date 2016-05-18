<?php 
	class ControllerServicesMusic extends Controller{
		public function index(){

			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/getid3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.mp3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.wavpack.php');
			$pageStyles = array('header', 'horizontal_menu', 'music');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/music');

			if (isset($_GET['genre_id'])){
				$genreId = $_GET['genre_id'];
			} else {
				$genreId = 0;
			}

			$data['songList'] = $this->model_services_music->getAudioList($genreId);
			$data['genreList'] = $this->model_services_music->getGenres();

			$this->load->view('music/music', $data);
		}

		public function add(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/getid3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.mp3.php');

			$newFileName = $_FILES['upload']['name'][0];
			$i = 0;
			while (file_exists($_SERVER['DOCUMENT_ROOT'] . '/view/audio/' . $newFileName)){
				$i++;
				$newFileName = $i . '_' . $_FILES['upload']['name'][0];
			}

			$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/view/audio/';
			$uploadFile = $uploadDir . $newFileName;

			$types = array('audio/mp3');

			if (in_array($_FILES['upload']['type'][0], $types)){
				if (move_uploaded_file($_FILES['upload']['tmp_name'][0], $uploadFile)){
					$info = $this->saveMusicPhoto($uploadFile);
					$userHash = $this->db->escape($_SESSION['USER']);
					$userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
					if ($userIsset->num_rows == 1){
						$userId = $userIsset->row['user_id'];
						$query = "SELECT * FROM `genres` WHERE `genre_name` LIKE '%$info[genre]%'";
						$genre = $this->db->query($query);
						if ($genre->num_rows > 0){
							$genre = $genre->row['id'];
						} else {
							$genre = 1;
						}
						$info['artist'] = (strlen($info['artist']) > 0) ? $info['artist'] : 'Исполнитель не указан';
						$info['name'] = (strlen($info['name']) > 0) ? $info['name'] : 'Без названия';
						$query = "INSERT INTO `audio` ";
						$query .= "(genre_id, song_author, song_name, song_path, song_picture) ";
						$query .= "VALUES ('$genre', '$info[artist]', '$info[name]', '$newFileName', '$info[image_path]')";
						$this->db->query($query);
						$lastId = $this->db->getLastId();
						$query = "INSERT INTO `user_audio` ";
						$query .= "(user_id, song_id) ";
						$query .= "VALUES ('$userId', '$lastId')";
						$this->db->query($query);
					}
					$r['result'] = "Песня успешно загружена";
				} else {
					$r['result'] = "Произошла ошибка при загрузке";
				}
			} else {
				$r['result'] = "Неверный тип песни, загружайте только формат mp3";
			}

			echo json_encode($r);
			die();
		}

		public function saveMusicPhoto($data){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/getid3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.mp3.php');
			$getid3 = new getID3();
			$getid3->encoding = 'UTF-8';
			$getid3->Analyze($data);
			$fileName = preg_replace("/\.mp3$/", "", $getid3->info['filename']);
			$file =  $fileName . '.jpg';
			$text = $getid3->info['comments']['picture'][0]['data'];
			if (strlen($text > 0)){
				$filePath = $_SERVER['DOCUMENT_ROOT'] . '/view/images/audio/' . $file;
				file_put_contents($filePath, $text);
				$return['image_path'] = $file;
			} else {
				$return['image_path'] = 'nophoto.jpg';
			}
			$return['artist'] = $getid3->info['tags']['id3v1']['artist'][0];
			$return['name'] = $getid3->info['tags']['id3v1']['title'][0];
			$return['genre'] = $getid3->info['tags']['id3v1']['genre'][0];
			return $return;
		}

		public function searchGenres(){
			if (isset($_POST['search'])){
				$result = array();
				$this->load->model('services/music');
				$result['genre'] = $this->model_services_music->searchGenres($_POST['value']);
				echo json_encode($result);
				die();
			} else {
				ob_end_clean();
				exit(header("Location: /services/music"));
			}
		}
	}
?>