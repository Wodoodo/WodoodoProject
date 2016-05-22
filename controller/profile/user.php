<?php
    class ControllerProfileUser extends Controller{
        public function index(){
            $pageStyles = array('header', 'horizontal_menu', 'user_information', 'user_news', 'user_posts', 'user_info');

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

            $data['user_id'] = $userInfo->row['user_id'];
            $pageTitle = $userInfo->row['user_firstname'] . ' ' . $userInfo->row['user_lastname'] . ' - Wodoodo'; 
            $this->registry->set('pageTitle', $pageTitle);
            
            $result = $this->model_profile_user->checkButtonText($this->db->escape($_GET['id']));   
                        /* USER INFORMATION */
            $Month = array("January" => "января", "February" => "февраля", "March" => "марта", "April" => "апреля", "May" => "мая", "June" => "июня", "July" => "июля",
                    "August" => "августа", "September" => "сентября", "October" => "октября", "November" => "ноября", "December" => "декабря");

            $data['firstName'] = $userInfo->row['user_firstname'];
            $data['lastName'] = $userInfo->row['user_lastname'];
            $data['photo'] = $userInfo->row['user_photo'];
            $monthEng = date("F", strtotime($userInfo->row["user_birthday"]));
            $monthRus = $Month[$monthEng];
            ($userInfo->row['user_birthday'] != 0) ? $data['birthday'] = date("j $monthRus", strtotime($userInfo->row['user_birthday'])) : $data['birthday'] = 'не указано';
            ($userInfo->row['user_birthday'] != 0) ? $data['fullYears'] = getFullYears($userInfo->row['user_birthday']) . " лет" : $data['fullYears'] = '';
            if($userInfo->row['user_city'] != 0){
                $cityId = $this->db->escape($userInfo->row['user_city']);
                $cityId = $this->db->query("SELECT * FROM `cities` WHERE `id`='$cityId'"); 
                $data['city'] = $cityId->row['city_name'] . ", ";  
            } else {
                $data['city'] = '';
            }
            $relationship = array('не указано', 'в активном поиске', 'встречается', 'влюблен/влюблена', 'женат/замужем');
            (strlen($userInfo->row['user_relations']) > 0) ? $data['relations'] = $relationship[$userInfo->row['user_relations']] : $data['relations'] = 'не указано';
            (strlen($userInfo->row['user_phone']) > 0) ? $data['phone'] = $userInfo->row['user_phone'] : $data['phone'] = 'не указано';
            (strlen($userInfo->row['user_twitter']) > 0) ? $data['twitter'] = $userInfo->row['user_twitter'] : $data['twitter'] = 'не указано';
            (strlen($userInfo->row['user_instagram']) > 0) ? $data['instagram'] = $userInfo->row['user_instagram'] : $data['instagram'] = 'не указано';
            (strlen($userInfo->row['user_skype']) > 0) ? $data['skype'] = $userInfo->row['user_skype'] : $data['skype'] = 'не указано';

            $data['status'] = isOnline($userInfo->row['last_activity']);
            switch ($result) {
            	case '0':
            		$data['btn_text'] = 'Это Ваш<br>профиль';
            		break;
            	case '1':
            		$data['btn_text'] = 'Добавить<br>в друзья';
            		break;
            	case '2':
            		$data['btn_text'] = 'Принять<br>запрос';
            		break;
            	case '3':
            		$data['btn_text'] = 'Отменить<br>запрос';
            		break;
            	case '4':
            		$data['btn_text'] = 'Удалить<br>из друзей';
            		break;
            }
            /* For button in My Profile */

            $userVar = $this->model_profile_user->getUser();
            if((!isset($_GET['id'])) || ($_GET['id'] == $userVar->row['user_id'])){
                $data['id'] = 0;
            } else {
                $data['id'] = $_GET['id'];
            }

            $this->registry->set('firstName', $data['firstName']);
            $this->registry->set('lastName', $data['lastName']);

            $data['header'] = $this->load->controller('header/header');

            /* Friends Count in Page */
            
            $data['friends_count'] = $this->model_profile_user->getFriendCount($this->db->escape($userInfo->row['user_id']));
            $data['audio_count'] = $this->model_profile_user->getAudioCount($this->db->escape($userInfo->row['user_id']));
            $data['like_count'] = $this->model_profile_user->getUserLikeCount($this->db->escape($userInfo->row['user_id']));


            /* USER POSTS */

            $userPosts = $this->model_profile_user->getPosts($userInfo->row['user_id']);

            $data['userPost'] = $userPosts;

            $this->load->model('profile/user');
            $this->load->view('profile/template/user_info_template', $data);
            $this->load->view('profile/user_news', $data);
            $this->load->view('profile/template/user_news_template', $data);
            $this->load->view('profile/user_posts', $data);
        }

        public function addToFriends(){
        	$this->load->model('profile/user');
        	$this->model_profile_user->checkAddToFriends($this->db->escape($_GET['id']));
            //$this->model_profile_user->addToFriends();
        }

        public function deleteFriend(){
        	$this->load->model('profile/user');
            $userId = $this->db->escape($_GET['user']);
            $friendId = $this->db->escape($_GET['friend']);
            $checkVar = $this->db->query("SELECT * FROM `friends` WHERE `user_id`='$userId' AND `friend_id`='$friendId'");
            if($checkVar->num_rows > 0){
        	   $this->model_profile_user->deleteFriend($userId, $friendId);
            } else {
                $this->model_profile_user->deleteFriend($friendId, $userId);
            }
        	exit(header("Location: /friends/myfriends"));
        }

        public function cancelRequest(){
        	$this->load->model('profile/user');
        	$this->model_profile_user->deleteRequest($this->db->escape($_GET['sender']), $this->db->escape($_GET['recipient']));
        	exit(header("Location: $_GET[page]"));
        }

        public function confirmationRequest(){
        	$this->load->model('profile/user');
        	$this->model_profile_user->addToFriends($this->db->escape($_GET['sender']), $this->db->escape($_GET['recipient']));
        	$this->model_profile_user->deleteRequest($this->db->escape($_GET['sender']), $this->db->escape($_GET['recipient']));
        	exit(header("Location: /friends/myfriends/incoming"));
        }

        public function addPost(){
            $this->load->model('profile/user');
            if (isset($_POST['add_post'])){
                $postInformation = array();
                $postInformation['postText'] = $_POST['news_text'];
                $postInformation['postImages'] = $_POST['photo'];

                $id = $this->model_profile_user->addPost($postInformation, $this->db->escape($_POST['user_id']));
                ob_end_clean();
                exit(header("Location: /profile/user?id=$id"));
            } else {
                exit();
            }
        }

        public function addimage(){
            $i = 0;
            $newFileName = $_FILES['uploads']['name'][0];
            while (file_exists(IMAGE_DIRECTORY . 'temp/' . $newFileName)){
                $i++;
                $newFileName = $i . '_' . $_FILES['uploads']['name'][0];
            }

            $uploadDir = IMAGE_DIRECTORY . 'temp/';
            $file = $uploadDir . $newFileName;

            $types = array('image/jpeg', 'image/jpg', 'image/png');

            if (in_array($_FILES['uploads']['type'][0], $types)) {
                if (!file_exists($file)) {
                    if (move_uploaded_file($_FILES['uploads']['tmp_name'][0], $file)) {
                        $r['success'] = 'Success';
                    } else {
                        $r['error'] = 'File not move';
                    }
                }
            } else {
                $r['error'] = 'File have incorrect type';
            }

            $r['image'] = $newFileName;

            echo json_encode($r);
            die();
        }

        public function getCity(){
            $inputString = $this->db->escape($_POST['inputValue']);
            $city = $this->db->query("SELECT * FROM `cities` WHERE `city_name` LIKE '$inputString%' LIMIT 0,10");
            echo json_encode($city, JSON_UNESCAPED_UNICODE);
        }

        public function addLike(){
            $this->load->model('profile/user');
            $user = $this->model_profile_user->getUser();
            $userId = $this->db->escape($user->row['user_id']);
            $postId = $this->db->escape($_POST['postId']);
            $this->db->query("INSERT INTO `likes` (post_id, user_id) VALUES ('$postId', '$userId')");
        }

        public function deleteLike(){
            $this->load->model('profile/user');
            $user = $this->model_profile_user->getUser();
            $userId = $this->db->escape($user->row['user_id']);
            $postId = $this->db->escape($_POST['postId']);
            $this->db->query("DELETE FROM `likes` WHERE `post_id`='$postId' AND `user_id`='$userId'");
        }

        public function getLikers(){
            $postId = $this->db->escape($_POST['postId']);
            $likers = $this->db->query("SELECT * FROM likes RIGHT OUTER JOIN users ON users.user_id = likes.user_id WHERE likes.post_id = '$postId'");//$this->db->query("SELECT `user_id` FROM `likes` WHERE `post_id`='$postId'");
            echo json_encode($likers, JSON_UNESCAPED_UNICODE);
        }

        public function deletePost(){
            $this->load->model('profile/user');
            $postId = $this->db->escape($_GET['postid']);
            $userId = $this->model_profile_user->getUser();
            $userId = $userId->row['user_id'];
            $posts = $this->db->query("SELECT * FROM `posts` WHERE (`post_id`='$postId') AND ((`owner_id`='$userId') OR (`post_user`='$userId'))");
            if($posts->num_rows > 0){
                $this->db->query("DELETE FROM `posts` WHERE (`post_id`='$postId') AND ((`owner_id`='$userId') OR (`post_user`='$userId'))");
                $this->db->query("DELETE FROM `likes` WHERE `post_id`='$postId'");
            }
            exit(header("Location: $_GET[page]"));
        }

        public function socketText(){
            if (extension_loaded('sockets')) echo 'websockets OK';
            else 'websockets UNAVAILABLE';
        }
    }
?>