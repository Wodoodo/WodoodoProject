<?php
	class ControllerServicesGames extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'games');
			$pageTitle = 'Сервис "Игры" - Wodoodo';
			$this->registry->set('pageTitle', $pageTitle);
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');

			$this->load->model('services/games');

			$data['game'] = $this->model_services_games->getGameList($_GET['genre']);

			$this->load->view('games/games', $data);
		}
	}
?>