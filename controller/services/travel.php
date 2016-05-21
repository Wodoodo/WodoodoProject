<?php 
	class ControllerServicesTravel extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'travel');
			$this->registry->set('pageStyles', $pageStyles);
			
			$data['header'] = $this->load->controller('header/header');

			$this->load->model('services/travel');

			$travels = $this->model_services_travel->getTravels($_GET);

			$data['travels'] = $travels;

			$this->load->view('travel/travel', $data);
		}

		public function view(){
			$pageStyles = array('header', 'horizontal_menu', 'travel');
			$this->registry->set('pageStyles', $pageStyles);

			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/travel');

			if (isset($_GET['id']) && (strlen($_GET['id']) > 0)) {
				$travelInfo = $this->model_services_travel->getTravelInfo($_GET['id']);
			} else {
				$travelInfo = $this->model_services_travel->getTravelInfo('1');
			}

			$data['travel'] = $travelInfo;

			$this->load->view('travel/view', $data);
		}

		public function add(){
			$pageStyles = array('header', 'horizontal_menu', 'travel');
			$this->registry->set('pageStyles', $pageStyles);

			$this->load->model('services/travel');

			if (isset($_POST['add_offer'])){
				$this->model_services_travel->add($_POST);
			}

			$data['header'] = $this->load->controller('header/header');

			$this->load->view('travel/add');
		}

		public function search(){
			ob_start();
			$requestURI = '?';
			$i = 0;
			foreach ($_POST as $key => $value){
				if (strlen($value) > 0){
					if ($i > 0){
						$requestURI .= "&";
					}
					$requestURI .= $key . '=' . $value;
					$i++;
				}
			}
			ob_end_clean();
			exit(header("Location: /services/travel" . $requestURI));
		}

		public function addResponse(){
			$this->load->model('services/travel');
			$this->model_services_travel->addResponse($_GET['id']);
		}
	}
?>