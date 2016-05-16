<?php
	class ControllerFriendsMyfriends extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'friends', 'profile.min');
			$this->registry->set('pageStyles', $pageStyles);  
			$this->load->model('profile/user');
            if(!isset($_GET['id']))
            {
                if (isset($_SESSION['USER'])) {

                    $userInfo = $this->model_profile_user->getUser();
                } else {
                    ob_end_clean();
                    exit(header("Location: /profile/sign/signin"));
                }
            } else {
                $userInfo = $this->model_profile_user->getUserFromID();
            }

            $data['header'] = $this->load->controller('header/header');

            $this->load->model('friends/friends');

            $userFriends = $this->model_friends_friends->getFriends($userInfo->row['user_id']);
            $userIncomingRequests = $this->model_friends_friends->getIncomingRequests($userInfo->row['user_id']);
            $userOutgingRequests = $this->model_friends_friends->getOutgingRequests($userInfo->row['user_id']);
            $data['userIncomingRequests'] = $userIncomingRequests;
            $data['userOutgingRequests'] = $userOutgingRequests;
            $data['userFriends'] = $userFriends;

            $userVar = $this->model_profile_user->getUser();
            $data['user_id'] = $userVar->row['user_id'];
            if((!isset($_GET['id'])) || ($_GET['id'] == $userVar->row['user_id'])){
                $data['id'] = $userVar->row['user_id'];
            } else {
                $data['id'] = $_GET['id'];
            }

            $this->load->view('friends/friends', $data);
		}

		public function incoming(){
			$pageStyles = array('header', 'horizontal_menu', 'friends', 'profile.min');
			$this->registry->set('pageStyles', $pageStyles);    
			$this->load->model('profile/user');
            if(!isset($_GET['id']))
            {
                if (isset($_SESSION['USER'])) {

                    $userInfo = $this->model_profile_user->getUser();
                } else {
                    ob_end_clean();
                    exit(header("Location: /profile/sign/signin"));
                }
            } else {
                $userInfo = $this->model_profile_user->getUserFromID();
            }

            $data['header'] = $this->load->controller('header/header');

            $this->load->model('friends/friends');

            $userFriends = $this->model_friends_friends->getFriends($userInfo->row['user_id']);
            $userIncomingRequests = $this->model_friends_friends->getIncomingRequests($userInfo->row['user_id']);
            $userOutgingRequests = $this->model_friends_friends->getOutgingRequests($userInfo->row['user_id']);
            $data['userIncomingRequests'] = $userIncomingRequests;
            $data['userOutgingRequests'] = $userOutgingRequests;
            $data['userFriends'] = $userFriends;
            
            $this->load->view('friends/incoming', $data);
		}

		public function outgoing(){
			$pageStyles = array('header', 'horizontal_menu', 'friends', 'profile.min');
			$this->registry->set('pageStyles', $pageStyles);    
			$this->load->model('profile/user');
            if(!isset($_GET['id']))
            {
                if (isset($_SESSION['USER'])) {

                    $userInfo = $this->model_profile_user->getUser();
                } else {
                    ob_end_clean();
                    exit(header("Location: /profile/sign/signin"));
                }
            } else {
                $userInfo = $this->model_profile_user->getUserFromID();
            }

            $data['header'] = $this->load->controller('header/header');

            $this->load->model('friends/friends');

            $userFriends = $this->model_friends_friends->getFriends($userInfo->row['user_id']);
            $userIncomingRequests = $this->model_friends_friends->getIncomingRequests($userInfo->row['user_id']);
            $userOutgingRequests = $this->model_friends_friends->getOutgingRequests($userInfo->row['user_id']);
            $data['userIncomingRequests'] = $userIncomingRequests;
            $data['userOutgingRequests'] = $userOutgingRequests;
            $data['userFriends'] = $userFriends;

            $this->load->view('friends/outgoing', $data);
		}
	}
?>