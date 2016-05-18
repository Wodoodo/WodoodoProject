<?php 
	class ControllerServicesTravel extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'travel');
			$this->registry->set('pageStyles', $pageStyles);
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/travel');
			$this->load->view('travel/travel');
		}
	}
?>