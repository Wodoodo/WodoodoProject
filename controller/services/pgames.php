<?php 
	class ControllerServicesPgames extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'games');
			$this->registry->set('pageStyles', $pageStyles);
			$this->load->model('services/pgames');

			if (isset($_GET['id'])){
				$gameId = $_GET['id'];
			} else {
				$gameId = 1;
			}

			$game = $this->model_services_pgames->getGameInfo($gameId);

			$data['game'] = $game['gameInfo'];
			$data['players'] = $game['gamePlayers'];
			$data['issetInList'] = $game['issetInList'];
			$data['feedback'] = $game['feedback'];

			$pageTitle = $data['game']->row['game_name'] . ' - Wodoodo';
			$this->registry->set('pageTitle', $pageTitle);
			$data['header'] = $this->load->controller('header/header');

			$this->load->view('games/game_page', $data);
		}

		public function addInList(){
			$this->load->model('services/pgames');
			$result = $this->model_services_pgames->addInList($_GET['id']);
			MessageSend($result['status'], $result['text'], 'services/pgames?id=' . $_GET['id']);
		}

		public function deleteFromList(){
			$this->load->model('services/pgames');
			$result = $this->model_services_pgames->deleteFromList($_GET['id']);
			MessageSend($result['status'], $result['text'], 'services/pgames?id=' . $_GET['id']);
		}

		public function addComment(){
			$this->load->model('services/pgames');
			$result = $this->model_services_pgames->addComment($_POST['id'], $_POST);
			MessageSend($result['status'], $result['text'], 'services/pgames?id=' . $_POST['id']);
		}
	}
?>