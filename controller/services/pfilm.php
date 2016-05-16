<?php
	class ControllerServicesPfilm extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/pfilm');
			$this->load->view('films/film_page');
		}
	}
?>