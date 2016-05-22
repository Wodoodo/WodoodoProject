<?php
	class ControllerMessagesDialogues extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'messages');
			$this->registry->set('pageStyles', $pageStyles);
			$this->load->model("messages/messages");

			if(isset($_SESSION['USER'])){
				$data['header'] = $this->load->controller('header/header');

				$data['userMessages'] = $this->model_messages_messages->getMessages();

				$this->load->view("messages/messages", $data);
			} else {
            	ob_end_clean();
                exit(header("Location: /profile/sign/signin"));
            }
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

		public function newDialog(){
			if (isset($_GET['companion_id'])) {
				$this->load->model('messages/messages');
				$result = $this->model_messages_messages->newDialog($_GET['companion_id']);
				if ($result['status'] == 'okay'){
					ob_end_clean();
					exit(header("Location: /messages/view?id=" . $result['conversation_id']));
				}
			} else {
				ob_end_clean();
				exit(header("Location: /messages/dialogues"));
			}
		}
	}
?>