<?php
    class ModelProfileUser extends Model{
        public function getUser(){
        	$userHash = $this->db->escape($_SESSION['USER']);
            $user = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
            return $user;
        }

        public function getUserFromID(){
            $userHash = $this->db->escape($_GET['id']);
            $user = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userHash'");
            return $user;
        }

        public function getPosts($userId){
            $posts  = $this->db->query("SELECT * FROM `posts` WHERE `post_user` = '$userId' AND `post_published` = '1' ORDER BY `post_id` DESC");
            $userId = $this->getUser();
            for ($i = 0; $i < $posts->num_rows; $i++){
                $userOwner = $this->db->escape($posts->rows[$i]['owner_id']);
                $userOwner = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userOwner'");
                $posts->rows[$i]['user'] = $userId->row['user_id'];
                $posts->rows[$i]['likers'] = $this->getLikers($posts->rows[$i]['post_id']);
                $posts->rows[$i]['like_number'] = $this->getLikesCount($posts->rows[$i]['post_id']);
                $posts->rows[$i]['like_state'] = $this->getLikeState($posts->rows[$i]['post_id']);
                $posts->rows[$i]['user_name'] = $userOwner->row['user_firstname'] . ' ' . $userOwner->row['user_lastname'];
                $posts->rows[$i]['last_activity'] = $userOwner->row['last_activity'];
                $posts->rows[$i]['user_photo'] = $userOwner->row['user_photo'];
            }
            return $posts;
        }

        public function addPost($postData, $forUserId = ''){
            $userHash = $this->db->escape($_SESSION['USER']);
            $userId = $this->db->query("SELECT `user_id` FROM `users` WHERE `user_hash` = '$userHash'");
            $userId = $this->db->escape($userId->row['user_id']);

            $postImages = array();
            $postImages['images'] = array();
            $imagesCount = 0;
            while ($imagesCount < count($postData['postImages'])){
                if ($imagesCount < 5) {
                    array_push($postImages['images'], $postData['postImages'][$imagesCount]);
                    $imagesCount++;
                } else{
                    break;
                }
            }

            $postImages = json_encode($postImages);

            $postData['postText'] = $this->db->escape($postData['postText']);
            $postData['postText'] = htmlspecialchars($postData['postText']);
            $postDate = date("Y-m-d H:i:s");
            if (($forUserId == $userId) || ($forUserId == 0)) {
                $this->db->query("INSERT INTO `posts` (owner_id, post_user, post_text, post_date, post_published, post_images) VALUES ('$userId', '$userId', '$postData[postText]', '$postDate', '1', '$postImages')");
                return $userId;
            } else {
                $forUserId = $this->db->escape($forUserId);
                $this->db->query("INSERT INTO `posts` (owner_id, post_user, post_text, post_date, post_published, post_images) VALUES ('$userId', '$forUserId', '$postData[postText]', '$postDate', '1', '$postImages')");
                return $forUserId;
            }
        }

        public function getCity(){
            if(isset($_POST['inputValue'])){
                $inputCity = $this->db->escape($_POST['inputValue']);
                $result = $this->db->query("SELECT * FROM `cities` WHERE `city_name` LIKE '$inputCity%'");
                
            }
        }

        public function checkSender($userId, $friendsId){
            $checkVar = $this->db->query("SELECT * FROM `requests` WHERE (`sender_id`='$userId') AND (`recipient_id`='$friendsId')");
            if($checkVar->num_rows > 0){
                return true;
            } else {
                return false;
            }
        }

        
        public function checkInFriends($userId, $friendsId){
            $checkVar = $this->db->query("SELECT * FROM `friends` WHERE ((`friend_id`='$friendsId') AND (`user_id`='$userId')) OR ((`user_id`='$friendsId') AND (`friend_id`='$userId'))");
            if($checkVar->num_rows > 0){
                return true;
            } else {
                return false;
            }
        }

        public function checkButtonText($friendsId){
            $userHash = $this->db->escape($_SESSION['USER']);
            $userId = $this->db->query("SELECT `user_id` FROM `users` WHERE `user_hash` = '$userHash'");
            $userId = $this->db->escape($userId->row['user_id']);
            if(($userId == $friendsId) || ($friendsId == 0)){
                return 0;
            }
            if($this->checkInFriends($userId, $friendsId)){
                return 4;
            } else {
                if($this->checkSender($userId, $friendsId)){
                    return 3;
                } else if($this->checkSender($friendsId, $userId)){
                    return 2;
                }
                return 1;
            }
        }

        public function addToRequests($userId, $friendsId){
            $this->db->query("INSERT INTO `requests` (sender_id, recipient_id) VALUES ('$userId', '$friendsId')");
        }

        public function addToFriends($userId, $friendsId){
            $this->db->query("INSERT INTO `friends` (user_id, friend_id) VALUES ('$userId', '$friendsId')");
        }

        public function deleteRequest($userId, $friendsId){
            $this->db->query("DELETE FROM `requests` WHERE (`sender_id`='$userId') AND (`recipient_id`='$friendsId')");
        }

        public function deleteFriend($userId, $friendsId){
            $this->db->query("DELETE FROM `friends` WHERE (`user_id`='$userId') AND (`friend_id`='$friendsId')");
        }

        /*public function checkInRequests($userId, $friendsId){
            $checkVar = $this->db->query("SELECT * FROM `requests` WHERE ((`sender_id`='$userId') AND (`recipient_id`='$friendsId')) OR ((`sender_id`='$friendsId') AND (`recipient_id`='$user_id'))");
            if($checkVar->num_rows > 0){
                return true;
            } else {
                return false;
            }
        }*/

        public function checkAddToFriends($friendsId){
            $userHash = $this->db->escape($_SESSION['USER']);
            $userId = $this->db->query("SELECT `user_id` FROM `users` WHERE `user_hash` = '$userHash'");
            $userId = $this->db->escape($userId->row['user_id']);
            if(($userId == $friendsId) || ($friendsId == 0)){
                exit(header("Location: /"));
            }
            if(!$this->checkInFriends($userId, $friendsId)){
                if($this->checkSender($userId, $friendsId)){
                    $this->deleteRequest($userId, $friendsId); 
                    exit(header("Location: /profile/user?id=$friendsId")); 
                } else if($this->checkSender($friendsId, $userId)){
                    $this->addToFriends($userId, $friendsId);
                    $this->deleteRequest($friendsId, $userId);
                    exit(header("Location: /profile/user?id=$friendsId"));
                } else {
                    $this->addToRequests($userId, $friendsId);
                    exit(header("Location: /profile/user?id=$friendsId"));
                }
            } else {
                $this->deleteFriend($userId, $friendsId);
                exit(header("Location: /profile/user?id=$friendsId"));
            }
        }

        public function getFriendCount($userId){
            $userFriend = $this->db->query("SELECT * FROM `friends` WHERE `user_id`='$userId' OR `friend_id`='$userId'");
            return $userFriend->num_rows;
        }

        public function getAudioCount($userHash){
            $userHash = $this->db->escape($userHash);
            $userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_id` = '$userHash'");

            if ($userIsset->num_rows == 1){
                $userId = $this->db->escape($userIsset->row['user_id']);
                $userAudio = $this->db->query("SELECT * FROM audio LEFT OUTER JOIN user_audio ON audio.id = user_audio.song_id WHERE user_audio.user_id = '$userId'");

                return $userAudio->num_rows;
            } else {
                return 0;
            }
        }

        public function getLikeState($postId){
            $user = $this->getUser();
            $userId = $this->db->escape($user->row['user_id']);
            $postId = $this->db->escape($postId);
            $likes  = $this->db->query("SELECT * FROM `likes` WHERE `post_id` = '$postId' AND `user_id`='$userId'");
            if($likes->num_rows == 0){
                return "false";
            } else {
                return "true";
            }
        }

        public function getLikesCount($postId){
            $postId = $this->db->escape($postId);
            $posts  = $this->db->query("SELECT * FROM `likes` WHERE `post_id` = '$postId'");
            return $posts->num_rows;
        }

        public function getUserLikeCount($userId){
            $userLikeCount = $this->db->query("SELECT * FROM `likes` WHERE `user_id`='$userId'");
            return $userLikeCount->num_rows;
        }

        public function getLikers($postId){
            $postId = $this->db->escape($postId);
            $likers = $this->db->query("SELECT * FROM likes RIGHT OUTER JOIN users ON users.user_id = likes.user_id WHERE likes.post_id = '$postId'");//$this->db->query("SELECT `user_id` FROM `likes` WHERE `post_id`='$postId'");
            return $likers;
        }
    }
?>