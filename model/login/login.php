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

        public function changePass($signData){
            if ($signData['password'] == $signData['repassword']){
                $signData['password'] = $this->db->escape($signData['password']);
                $signData['request_key'] = $this->db->escape($signData['request_key']);
                $searchRequest = $this->db->query("SELECT * FROM `pass_request` WHERE `request_key` = '$signData[request_key]'");
                $password = passHash($signData['password']);
                if ($searchRequest->num_rows == 1){
                    $email = $searchRequest->row['request_email'];
                    $query = "UPDATE `users` SET `user_password` = '$password' WHERE `user_email` = '$email'";
                    $this->db->query($query);
                    $query = "DELETE FROM `pass_request` WHERE `request_key` = '$signData[request_key]'";
                    $this->db->query($query);
                    mail_utf8($email, 'Изменение пароля', "Ваш новый пароль: " . $signData['password'] . "<br>Перейдите по ссылке чтобы войти на сайт: http://wodoodo.vsemhorosho.by/profile/sign/signin", 'info@wodoodo');
                    MessageSend("ok", "Пароль изменен, введите данные ниже чтобы войти на сайт", "profile/sign/signin");
                } else {
                    MessageSend("error", "Данный ключ запроса не найден, повторите попытку", "profile/sign/remember?request=" . $signData['request_key']);
                }
            } else {
                MessageSend("error", "Введенные пароли не совпадают", "profile/sign/remember?request=" . $signData['request_key']);
            }
        }

        public function remember($signData){
            $query = "SELECT * FROM `users` WHERE `user_email` = '$signData[email]'";
            $userIsset = $this->db->query($query);
            if ($userIsset->num_rows == 1){
                $issetInRequest = $this->db->query("SELECT * FROM `pass_request` WHERE `request_email` = '$signData[email]'");
                if ($issetInRequest->num_rows == 0){
                    $requestKey = sha1(sha1('wodoodo').sha1($signData['email']));
                    $query = "INSERT INTO `pass_request` (request_email, request_key) VALUES ('$signData[email]', '$requestKey')";
                    $this->db->query($query);
                    mail_utf8($signData['email'], 'Восстановление пароля на Wodoodo', "Ключ для восстановление пароля: " . $requestKey . "<br>Перейдите по ссылке для изменения пароля: http://wodoodo.vsemhorosho.by/profile/sign/remember?request=" . $requestKey, 'info@wodoodo');
                    MessageSend("ok", "Ключ для восстановление пароля выслан на ваш e-mail", "profile/sign/remember");
                } else {
                    MessageSend("error", "На данный email уже отправлен запрос на восстановление", "profile/sign/remember");
                }
            } else {
                MessageSend("error", "Данный e-mail не существует", "profile/sign/remember");
            }
        }
    }
?>