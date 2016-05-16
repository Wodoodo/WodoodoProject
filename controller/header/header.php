<?php
    class ControllerHeaderHeader extends Controller{
        public function index(){
            $this->load->model('profile/user');
            $userInfo = $this->model_profile_user->getUser();

            $this->load->model('friends/friends');
            $userIncomingRequests = $this->model_friends_friends->getIncomingRequests($userInfo->row['user_id']);
            $data['userIncomingRequests'] = $userIncomingRequests;

            $data['pageStyles'] = $this->registry->get('pageStyles');
            $data['devicePrefix'] = $this->registry->get('devicePrefix');
            $data['firstName'] = $userInfo->row['user_firstname'];
            $data['lastName'] = $userInfo->row['user_lastname'];

            $this->load->view('header/header', $data);
        }
    }
?>