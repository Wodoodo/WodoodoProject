<?php
	class ControllerMessagesView extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'dialogues');
			$this->registry->set('pageStyles', $pageStyles);

			$data['header'] = $this->load->controller('header/header');

			$this->load->model("messages/dialogues");

			$data['messages'] = $this->model_messages_dialogues->getMessages($_GET['id']);

			$this->load->view("messages/dialogues", $data);
		}

		public function sendMessage(){
			ob_start();
			if (isset($_POST['message_send'])){
				$data['message'] = $_POST['message_text'];
				$data['to_id'] = $_POST['conversation_id'];

				$this->load->model('messages/dialogues');

				$result = $this->model_messages_dialogues->sendMessage($data);

				echo json_encode($result);
				die();
			} else {
				ob_end_clean();
				exit(header("Location: /"));
			}
		}

		public function updateMessages(){
			ob_start();
			if (isset($_POST['update_message'])){
				$data['convId'] = $_POST['conversation'];

				$this->load->model('messages/dialogues');
				$result = $this->model_messages_dialogues->updateMessages($data);

				echo json_encode($result);
				die();
			} else {
				ob_end_clean();
				die();
			}
		}
	}
?>