<?php
	class ControllerServicesSeans extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/seans');
			$this->load->view('films/films');
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