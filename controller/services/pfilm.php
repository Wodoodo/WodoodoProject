<?php
	class ControllerServicesPfilm extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			if(isset($_GET['film']))
				$data['film'] = $this->getFilmInfo($_GET['film']);
			$this->load->model('services/pfilm');
			$this->load->view('films/film_page', $data);
		}

		public function getFilmInfo($filmURL){
			$url = "http://afisha.tut.by/film/" . $filmURL . "/"; //<h1 class="title" itemprop="name" id="event-name">Люди Икс: Апокалипсис</h1>
			$page = file_get_contents($url);
			$result = preg_match_all('/(?:\<h1 class\=\"title\" itemprop\=\"name\" id\=\"event\-name\"\>)(.*)(?=\<\/h1\>)/', $page, $name);
			$data['name'] = $name[1][0];
			$result = preg_match_all('/(?:src\=\")(.*)(?=\" itemprop\=\"image\">)/', $page, $photo);
			$data['photo'] = $photo[1][0];
			$result = preg_match_all('/(?:itemprop\=\"description\"\>)(.*)(?=\<p class\=\"note\"\>)/s', $page, $text);
			//if($result == 0)
				//$result = preg_match_all('/(?:itemprop\=\"description\"\>)(.*)(?=\<p class\=\"note\"\>)/s', $page, $text);
			$data['text'] = $text[1][0];
			//echo "Matches: $result<br>";
			//var_dump($text);
			return $data;
		}
	}
?>