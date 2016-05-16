<?php 
	class ControllerServicesMusic extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'music');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/music');
			$this->load->view('music/music');
		}
	}
?>