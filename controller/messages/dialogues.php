<?php
	class ControllerMessagesDialogues extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'messages');
			$this->registry->set('pageStyles', $pageStyles);

			$data['header'] = $this->load->controller('header/header');

			$this->load->model("messages/messages");

			$data['userMessages'] = $this->model_messages_messages->getMessages();

			$this->load->view("messages/messages", $data);
		}

		public function updateMessages(){
			ob_start();
			if (isset($_POST['update'])){
				$this->load->model('messages/messages');
				$result = $this->model_messages_messages->updateMessages();

				echo json_encode($result);
				die();
			} else {
				ob_end_clean();
				exit(header("Location: /messages/dialogues"));
			}
		}


	}
?>