	<?php
	class ControllerProfileSign extends Controller{
		public function index(){

		}

		public function signin(){
			$pageStyles = array('login');
			$this->registry->set('pageStyles', $pageStyles);
			if (isset($_POST['send_request'])){
				$signData = array();
				$signData['auth_email'] = $this->db->escape($_POST['auth_email']);
				$signData['auth_pass'] = $this->db->escape($_POST['auth_pass']);

				$this->load->model('login/login');
				$this->model_login_login->signin($signData);
			
			} 
			$this->load->view('profile/signin');
		}

		public function signup(){
			$pageStyles = array('login');
			$this->registry->set('pageStyles', $pageStyles);
			if (isset($_POST['send_request'])){
				$signData = array();
				$signData['auth_email'] = $this->db->escape($_POST['auth_email']);
				$signData['auth_firstname'] = $this->db->escape($_POST['auth_firstname']);
				$signData['auth_lastname'] = $this->db->escape($_POST['auth_lastname']);
				$signData['auth_pass'] = $this->db->escape($_POST['auth_pass']);
				$signData['auth_repass'] = $this->db->escape($_POST['auth_repass']);
				$_SESSION['email'] = $_POST['auth_email'];
				$_SESSION['firstname'] = $_POST['auth_firstname'];
				$_SESSION['lastname'] = $_POST['auth_lastname'];

				$this->load->model('login/login');
				$this->model_login_login->signup($signData);
			} 
			$this->load->view('profile/signup');
		}

		public function userExit(){
			$this->load->model('login/login');
			$this->model_login_login->userExit();
			unset($_SESSION['USER']);
			session_destroy();
			ob_end_clean();
			exit(header("Location: /profile/sign/signin"));
		}
	}
?>