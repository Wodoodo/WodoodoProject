<?php
	class ControllerServicesGames extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'games');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/games');
			$this->load->view('games/games');
		}
	}
?>