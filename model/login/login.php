<?php
    class ModelLoginLogin extends Model{
        public function signin($parameters = ''){
            $checkEmail = $this->db->query("SELECT * FROM `users` WHERE `user_email` = '$parameters[auth_email]'");
            if ($checkEmail->num_rows > 0){
                if (passHash($parameters['auth_pass']) == $checkEmail->row['user_password']){
                    $_SESSION['USER'] = sessionHash($checkEmail->row['user_id']);
                    $userHashSession = $this->db->escape($_SESSION['USER']);
                    $userId = $this->db->escape($checkEmail->row['user_id']);
                    $this->db->query("UPDATE `users` SET `user_hash` = '$userHashSession' WHERE `user_id` = '$userId'");
                    exit(header("Location: /"));
                } else {
                    MessageSend("error", "Error: Incorrect password or email", "profile/sign/signin");
                }
            } else {
                MessageSend("error", "Введенный Вами E-Mail не зарегистрирован", "profile/sign/signin");
            }
        }

        public function signup($parameters = ''){
            $checkEmail = $this->db->query("SELECT * FROM `users` WHERE `user_email` = '$parameters[auth_email]'");
            if($checkEmail->num_rows == 0){
                if($parameters['auth_pass'] == $parameters['auth_repass'])
                {
                    if (preg_match("/[^A-ZА-Яa-zа-я]/u", $parameters['auth_firstname'])) { 
                        MessageSend("error", "Введенное Вами имя содержит недопустимые символы", "profile/sign/signup");
                    }
                    if (preg_match("/[^A-ZА-Яa-zа-я]/u", $parameters['auth_lastname'])) { 
                        MessageSend("error", "Введенная Вами фамилия содержит недопустимые символы", "profile/sign/signup");
                    }
                    $HashPass = passHash($parameters['auth_pass']);
                    $today = date("Y-m-d H:i:s");
                    $result = $this->db->query("INSERT INTO `users` (user_email, user_password, user_firstname, user_lastname, user_register_date, user_photo) VALUES ('$parameters[auth_email]', '$HashPass', '$parameters[auth_firstname]', '$parameters[auth_lastname]', '$today', 'noPhoto.jpg')");
                    unset($_SESSION['email']);
                    unset($_SESSION['firstname']);
                    unset($_SESSION['lastname']);
                    mail_utf8($parameters['auth_email'], 'Регистрация на Wodoodo', "Информация для входа на Wodoodo: <br>Ваш E-Mail: " . $parameters['auth_email'] . "<br>Ваш пароль: " . $parameters['auth_pass'] . "<br>Спасибо за регистрацию!", 'info@wodoodo');
                    MessageSend("ok", "Ваш аккаунт успешно зарегистрирован, выполните вход ниже","profile/sign/signin");
                } else {
                    MessageSend("error", "Введенные Вами пароли не совпадают", "profile/sign/signup");
                }
            } else {
                MessageSend("error", "Введенный Вами E-Mail уже зарегистрирован", "profile/sign/signup");
            }
        }

        public function userExit(){
            $sessionHash = $this->db->escape($_SESSION['USER']);
            $this->db->query("UPDATE `users` SET `user_hash` = '' WHERE `user_hash` = '$sessionHash'");
        }
    }
?>