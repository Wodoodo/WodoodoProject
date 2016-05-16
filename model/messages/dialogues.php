<?php 
	class ModelMessagesDialogues extends Model{
		public function getMessages($conversationId){
            $conversationId = $this->db->escape($conversationId);

            $userHash = $this->db->escape($_SESSION['USER']);
            $userId = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
            if ($userId->num_rows > 0){
                $userId = $userId->row['user_id'];
            } else {
                ob_end_clean();
                exit(header("Location: /profile/sign/signin"));
            }

            $query = "SELECT * FROM `conversations` WHERE `id` = '$conversationId'";
            $conversation = $this->db->query($query);
            if ($conversation->num_rows > 0) {
                $userArray = json_decode($conversation->row['users']);
                if (($userArray->users[0] == $userId) or ($userArray->users[1] == $userId)) {
                    if ($userArray->users[0] != $userId) {
                        $companionId = $userArray->users[0];
                    } else {
                        $companionId = $userArray->users[1];
                    }
                } else {
                    ob_end_clean();
                    exit(header("Location: /messages"));
                }
                $query = "SELECT * FROM `messages` ";
                $query .= "LEFT JOIN `users` ON `users`.`user_id` = `messages`.`user_from` ";
                $query .= "WHERE (`messages`.`user_from` = '$userId' AND `messages`.`user_to` = '$companionId') ";
                $query .= "OR (`messages`.`user_from` = '$companionId' AND `messages`.`user_to` = '$userId') ORDER BY `messages`.`message_date`";

                $messages = $this->db->query($query);

                $query = "SELECT `user_firstname`, `user_lastname`, `last_activity` FROM `users` WHERE `user_id` = '$companionId'";

                $companion = $this->db->query($query);

                $query = "UPDATE `messages` ";
                $query .= "SET `displayed` = '1', `viewed` = '1' ";
                $query .= "WHERE `user_to` = '$userId' AND `conversation` = '$conversationId'";

                $this->db->query($query);

                $query = "UPDATE `messages` ";
                $query .= "SET `displayed` = '1' ";
                $query .= "WHERE `user_from` = '$userId' AND `conversation` = '$conversationId'";

                $this->db->query($query);

                $messages->companion = $companion->row;

                return $messages;
            } else {
                ob_end_clean();
                exit(header("Location: /messages/dialogues"));
            }
        }

        public function sendMessage($data){
            $userHash = $this->db->escape($_SESSION['USER']);
            $userIsset = $this->db->query("SELECT * FROM `users` WHERE `user_hash` = '$userHash'");
            if ($userIsset->num_rows > 0){
                $userId = $this->db->escape($userIsset->row['user_id']);
            } else {
                die();
            }
            $message = htmlspecialchars($this->db->escape($data['message']));
            $conversationId = $this->db->escape($data['to_id']);

            /* SEARCH COMPANION ID */

            $query = "SELECT * FROM `conversations` WHERE `id` = '$conversationId'";
            $companion = $this->db->query($query);
            if ($companion->num_rows > 0){
                $userArray = json_decode($companion->row['users']);
                if ($userArray->users[0] != $userId){
                    $companionId = $userArray->users[0];
                } else {
                    $companionId = $userArray->users[1];
                }
            }

            $date = date('Y-m-d H:i:s');

            $query = "INSERT INTO `messages` ";
            $query .= "(user_from, user_to, message_text, viewed, displayed, conversation, message_date, owner_displayed) ";
            $query .= "VALUES ('$userId', '$companionId', '$message', '0', '0', '$conversationId', '$date', '0')";

            $this->db->query($query);

            return 'okay';
        }

        public function updateMessages($data){
            $conversationId = $this->db->escape($data['convId']);
            $userHash = $this->db->escape($_SESSION['USER']);
            $query = "SELECT * FROM `users` WHERE `user_hash` = '$userHash'";
            $userIsset = $this->db->query($query);
            if ($userIsset->num_rows == 1){
                $userId = $this->db->escape($userIsset->row['user_id']);
            } else {
                return 'error lol';
                die();
            }

            $query = "SELECT * FROM `conversations` ";
            $query .= "WHERE `id` = '$conversationId'";
            $conversation = $this->db->query($query);
            if ($conversation->num_rows > 0){
                $userArray = json_decode($conversation->row['users']);
                if ($userArray->users[0] != $userId){
                    $companionId = $userArray->users[0];
                } else {
                    $companionId = $userArray->users[1];
                }
            } else {
                return 'error lol';
                die();
            }

            $query = "SELECT * FROM `messages` ";
            $query .= "LEFT JOIN `users` ON `users`.`user_id` = `messages`.`user_from` ";
            $query .= "WHERE `messages`.`user_from` = '$companionId' AND `messages`.`user_to` = '$userId' AND `displayed` = '0' ";
            $query .= " ORDER BY `messages`.`message_date`";

            $messages = $this->db->query($query);

            if ($messages->num_rows == 0){
                $query = "SELECT * FROM `messages` ";
                $query .= "LEFT JOIN `users` ON `users`.`user_id` = `messages`.`user_from` ";
                $query .= "WHERE `messages`.`user_from` = '$userId' AND `messages`.`user_to` = '$companionId' AND `owner_displayed` = '0' ";
                $query .= " ORDER BY `messages`.`message_date`";

                $messages = $this->db->query($query);

                $query = "UPDATE `messages` ";
                $query .= "SET `owner_displayed` = '1' ";
                $query .= "WHERE `user_from` = '$userId' AND `conversation` = '$conversationId'";

                $this->db->query($query);
            }

            $query = "UPDATE `messages` ";
            $query .= "SET `displayed` = '1', `viewed` = '1' ";
            $query .= "WHERE `user_to` = '$userId' AND `conversation` = '$conversationId'";

            $this->db->query($query);

            /* $query = "UPDATE `messages` ";
            $query .= "SET `displayed` = '1' ";
            $query .= "WHERE `user_from` = '$userId' AND `conversation` = '$conversationId'";

            $this->db->query($query); */

            return $messages;
        }
	}
?>