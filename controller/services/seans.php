<?php
	class ControllerServicesSeans extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$data['films'] = $this->parse();
			$this->load->model('services/seans');
			$this->load->view('films/films', $data);
		}

		public function parse(){
			$url = "http://afisha.tut.by/film/"; //<ul class="b-lists list_afisha online_list col-5">
			$page = file_get_contents($url);
			//$result = preg_match_all('/\<ul class\=\"b\-lists list\_afisha online\_list col\-5\"\>(.*)\<\/ul\>/s', $page, $found);
			$result = preg_match_all('/\<div class\=\"events\-block js\-cut\_wrapper\"\>.*\<div class\=\"col\-i events\-block\"\>/s', $page, $found);
			$result = preg_match_all('/\<ul class\=\"b\-lists list\_afisha online\_list col\-5\"\>.*\<\/ul\>/s', $found[0][0], $found);	
			$countFilms = preg_match_all('/(?:\s\<p\>)(.*)(?=\<\/p\>)/', $found[0][0], $genre);
			$countFilms = preg_match_all('/(?:\s\<a href\=\"http\:\/\/afisha\.tut\.by\/film\/)(.*)(?=\/\" class\=\"media\")/', $found[0][0], $url);
			$countFilms = preg_match_all('/(?:\<img src\=\")(.*)(?=" )/', $found[0][0], $images);
			$countFilms = preg_match_all('/(?:\<span itemprop\=\"summary\"\>)(.*)(?=\<\/span\>)/', $found[0][0], $filmName);
			for($i = 0; $i < $countFilms; $i++){
				$data[$i]['picture'] = $images[1][$i];
				$data[$i]['name'] = $filmName[1][$i];
				$data[$i]['genre'] = $genre[1][$i];
				$data[$i]['url'] = $url[1][$i];
			}
			//echo "Matches: $countFilms<br>";
			//var_dump($url);
			return $data;
		}

		public function full(){
			/*$this->load->model('films/seans');
			$filmInfo = $this->model_films_seans->getFilms($_GET['id']);
			echo $filmInfo;*/
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/seans');
			$this->load->view('films/film_page');
		}
	}
?>