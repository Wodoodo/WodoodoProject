	<?php
	class ControllerServicesSeans extends Controller{
		public function index(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/films/simple_html_dom.php');
			$this->load->model('services/seans');
			$pageTitle = 'Сервис кино - Wodoodo'; 
			$this->registry->set('pageTitle', $pageTitle);
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			if(!isset($_GET['genre'])){
				$data['films'] = $this->parse();
			} else {
				$data['films'] = $this->model_services_seans->getFilms($this->db->escape($_GET['genre']));
			}
			$this->model_services_seans->loadFilms($data['films']);
			$this->load->view('films/films', $data);
		}

		public function parse(){
			$url = "http://afisha.tut.by/film/";
			$page = file_get_html($url); 
			$div = $page->find('.js-cut_wrapper', 0);
			$i = 0;
			foreach ($div->find('.media') as $a){
			 	$href = $a->href;
			 	$countFilms = preg_match_all('/(?:http\:\/\/afisha\.tut\.by\/film\/)(.*)(?=\/)/', $href, $url);
			 	$data[$i]['url'] = $url[1][0];
			 	$i++;	 	
			}  
			$i = 0;
			foreach ($div->find('.media img') as $img){
			 	$src = $img->src;
			 	$data[$i]['picture'] = $src;
			 	$i++;	 	
			} 
			$i = 0;
			foreach ($div->find('.name span') as $name){
			 	$name = $name->innertext;
			 	$data[$i]['name'] = $name;
			 	$i++;	 	
			} 
			$i = 0;
			foreach ($div->find('.txt p') as $genre){
			 	$genre = $genre->innertext;
			 	$data[$i]['genre'] = $genre;
			 	$i++;	 	
			}

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