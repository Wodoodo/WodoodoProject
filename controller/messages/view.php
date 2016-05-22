<?php
	class ControllerMessagesView extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'dialogues');
			$this->registry->set('pageStyles', $pageStyles);
			$this->load->model("messages/dialogues");

			if(isset($_SESSION['USER'])){
				$data['header'] = $this->load->controller('header/header');

				$data['messages'] = $this->model_messages_dialogues->getMessages($_GET['id']);

				$this->load->view("messages/dialogues", $data);
			} else {
            	ob_end_clean();
                exit(header("Location: /profile/sign/signin"));
            }
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