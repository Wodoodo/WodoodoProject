<?php
	class ModelServicesTravel extends Model{
		public function index(){
			
		}

		public function getTravels($getData){
			$query = "SELECT * FROM `travel` ";
			$query .= "LEFT JOIN `users` ON `users`.`user_id` = `travel`.`travel_user` ";
			if (count($getData) > 1){
				$i = 0;
				$query .= "WHERE ";
				foreach ($_GET as $key => $value){
					if (($key != 'route') && ($key != 'start_search')){
						if ($key == 'search_whom'){
							$key = 'travel_type';
						}
						$i++;
						$value = $this->db->escape($value);
						if ($value == 'companion'){
							$value = 1;
						} elseif ($value == 'driver'){
							$value = 2;
						}
						$query .= "`" . $key . "` = '" . $value . "' ";
						if ($i < count($getData) - 1){
							$query .= "AND ";
						}
					}
				}
			}
			$query .= "ORDER BY `travel`.`travel_id` DESC";
			$result = $this->db->query($query);

			return $result;
		}

		public function add($data){
			/**=
             * @param_post radio search_whom     Кем является пользователь (companion/driver)
			 * @param_post text from             Место отправления
			 * @param_post text to               Место прибытия
			 * @param_post text auto             Автомобиль
			 * @param_post text all_place        Общее кол-во мест
			 * @param_post text free_place       Кол-во свободных мест
			 * @param_post text date_time        Время отправления

			DATABASE

			 * @param int travel_user 			ID отправителя
			 * @param varchar travel_from		ID места отправления
			 * @param varchar travel_to			ID места прибытия
			 * @param int travel_type			Тип отправителя (водитель/попутчик)
			 * @param varchar travel_auto		Автомобиль
			 * @param datetime travel_time		Дата отправления
			 * @param datetime travel_date_create Дата создания предложения
			 * @param int travel_all_place 		Общее кол-во мест
			 * @param int travel_free_place		Свободно мест
			*/
			$this->load->model('profile/user');
			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			foreach ($_POST as $key => $value){
				$_POST[$key] = htmlspecialchars($this->db->escape($value));
			}

			if ($_POST['search_whom'] == 'companion'){
				$type = 1;
			} else {
				$type = 2;
			}

			$date = date_create_from_format('Y-m-d H:i:s', $_POST['date_time']);
			$date = date_format($date, 'Y-m-d H:i:s');

			$dateNow = date('Y-m-d H:i:s');

			$travelDesc = htmlspecialchars($_POST['travel_desc']);

			$query = "INSERT INTO `travel` ";
			$query .= "(travel_user, travel_from, travel_to, travel_type, travel_desc, ";
			if ($type == 2){
				$query .= "travel_auto, travel_all_place, travel_free_place, ";
			}
			$query .= "travel_time, travel_date_create) ";
			$query .= "VALUES ('$userId', '$_POST[from]', '$_POST[to]', '$type', '$travelDesc', ";
			if ($type == 2){
				$query .= "'$_POST[auto]', '$_POST[all_place]', '$_POST[free_place]', ";
			}
			$query .= "'$date', '$dateNow')";

			$this->db->query($query);

			MessageSend('ok', 'Предложение успешно добавлено', 'services/travel/add');
		}

		public function getTravelInfo($travelID){
			$travelID = $this->db->escape($travelID);
			$query = "SELECT * FROM `travel` ";
			$query .= "JOIN `users` ON `users`.`user_id` = `travel`.`travel_user`";
			$query .= "WHERE `travel`.`travel_id` = '$travelID'";
			$result = $this->db->query($query);

			return $result;
		}

		public function addResponse($travelID){
			ob_start();
			$this->load->model('messages/messages');
			$this->load->model('profile/user');

			$user = $this->model_profile_user->getUser();
			$userId = $user->row['user_id'];

			$travelID = $this->db->escape($travelID);

			$query = "SELECT * FROM `travel` ";
			$query .= "JOIN `users` ON `users`.`user_id` = `travel`.`travel_id` ";
			$query .= "WHERE `travel`.`travel_id` = '$travelID'";

			$travel = $this->db->query($query);

			if ($travel->num_rows > 0){
				$companionId = $travel->row['travel_user'];
				$dialog = $this->model_messages_messages->newDialog($companionId);
				$dialogId = $dialog['conversation_id'];
				$date = date('Y-m-d H:i:s');

				$messageText = 'Здравствуйте! Я по поводу Вашего предложения - http://wodoodo.vsemhorosho.by/services/travel/view?id=' . $travelID . '. Актуально ли на данный момент?';

				$query = "INSERT INTO `messages` ";
				$query .= "(user_from, user_to, message_text, viewed, displayed, owner_displayed, conversation, message_date) ";
				$query .= "VALUES ('$userId', '$companionId', '$messageText', '0', '0', '0', '$dialogId', '$date')";

				$this->db->query($query);

				ob_end_clean();
				exit(header("Location: /messages/view?id=" . $dialogId));
			}
		}
	}
?>