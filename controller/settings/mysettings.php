<?php
	class SimpleImage
	{

		var $image;
		var $image_type;

		function load($filename)
		{
			$image_info = getimagesize($filename);
			$this->image_type = $image_info[2];
			if ($this->image_type == IMAGETYPE_JPEG) {
				$this->image = imagecreatefromjpeg($filename);
			} elseif ($this->image_type == IMAGETYPE_GIF) {
				$this->image = imagecreatefromgif($filename);
			} elseif ($this->image_type == IMAGETYPE_PNG) {
				$this->image = imagecreatefrompng($filename);
			}
		}

		function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
		{
			if ($image_type == IMAGETYPE_JPEG) {
				imagejpeg($this->image, $filename, $compression);
			} elseif ($image_type == IMAGETYPE_GIF) {
				imagegif($this->image, $filename);
			} elseif ($image_type == IMAGETYPE_PNG) {
				imagepng($this->image, $filename);
			}
			if ($permissions != null) {
				chmod($filename, $permissions);
			}
		}

		function output($image_type = IMAGETYPE_JPEG)
		{
			if ($image_type == IMAGETYPE_JPEG) {
				imagejpeg($this->image);
			} elseif ($image_type == IMAGETYPE_GIF) {
				imagegif($this->image);
			} elseif ($image_type == IMAGETYPE_PNG) {
				imagepng($this->image);
			}
		}

		function getWidth()
		{
			return imagesx($this->image);
		}

		function getHeight()
		{
			return imagesy($this->image);
		}

		function resizeToHeight($height)
		{
			$ratio = $height / $this->getHeight();
			$width = $this->getWidth() * $ratio;
			$this->resize($width, $height);
		}

		function resizeToWidth($width)
		{
			$ratio = $width / $this->getWidth();
			$height = $this->getheight() * $ratio;
			$this->resize($width, $height);
		}

		function scale($scale)
		{
			$width = $this->getWidth() * $scale / 100;
			$height = $this->getheight() * $scale / 100;
			$this->resize($width, $height);
		}
	}

	class ControllerSettingsMysettings extends Controller{
		public function index(){
			$pageStyles = array('header', 'horizontal_menu', 'settings');
			$this->registry->set('pageStyles', $pageStyles);    
			$this->load->model('profile/user');

            if(isset($_SESSION['USER'])){
            	$userInfo = $this->model_profile_user->getUser();

            	$data['photo'] = $userInfo->row['user_photo'];
            	($userInfo->row['user_birthday'] != 0) ? $data['birthday'] = $userInfo->row['user_birthday'] : $data['birthday'] = '';
                if($userInfo->row['user_city'] != 0){
                    $cityId = $this->db->escape($userInfo->row['user_city']);
                    $cityId = $this->db->query("SELECT * FROM `cities` WHERE `id`='$cityId'"); 
                    $data['city'] = $cityId->row['city_name'];  
                } else {
                    $data['city'] = '';
                }
                (strlen($userInfo->row['user_relations']) > 0) ? $data['relations'] = $userInfo->row['user_relations'] : $data['relations'] = '';
                (strlen($userInfo->row['user_phone']) > 0) ? $data['phone'] = $userInfo->row['user_phone'] : $data['phone'] = '';
                (strlen($userInfo->row['user_langagues']) > 0) ? $data['langagues'] = $userInfo->row['user_langagues'] : $data['langagues'] = '';
                (strlen($userInfo->row['user_twitter']) > 0) ? $data['twitter'] = $userInfo->row['user_twitter'] : $data['twitter'] = '';
                (strlen($userInfo->row['user_instagram']) > 0) ? $data['instagram'] = $userInfo->row['user_instagram'] : $data['instagram'] = '';
                (strlen($userInfo->row['user_skype']) > 0) ? $data['skype'] = $userInfo->row['user_skype'] : $data['skype'] = '';

            	$data['header'] = $this->load->controller('header/header');
            	$this->load->view('settings/settings', $data);

            	/*$count = 0;
				$file = fopen($_SERVER['DOCUMENT_ROOT'].'/view/images/CITY.csv', 'r');
				while(($data = fgetcsv($file, 0, ";")) !== FALSE)
				{
					$city = $this->db->escape($data[0]);
					$area = $this->db->escape($data[1]);
					$district = $this->db->escape($data[2]);
					$this->db->query("INSERT `cities` (city_name, city_area, city_district, city_parent) VALUES ('$city', '$area', '$district', '1') ");
				}*/

            	if(isset($_POST['save_info'])){
            		$this->load->model('settings/settings');
            		$userInfo = array();
                    $cityName = $this->db->escape($_POST['user_city']);
                    $cityId = $this->db->query("SELECT * FROM `cities` WHERE `city_name`='$cityName'");

					$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/view/images/users/';
					$uploadFile = $uploadDir . basename($_FILES['user_photo']['name']);

					if (move_uploaded_file($_FILES['user_photo']['tmp_name'], $uploadFile)) {
						$userInfo['photo'] = $_FILES['user_photo']['name'];
					}

					$userInfo['city'] = $this->db->escape($cityId->row['id']);
            		$userInfo['birthday'] = $this->db->escape(date("Y-m-j", strtotime($_POST['user_birthday'])));
            		$userInfo['relations'] = $this->db->escape($_POST['user_relations']);
            		$userInfo['phone'] = $this->db->escape($_POST['user_phone']);
            		$userInfo['twitter'] = $this->db->escape($_POST['user_twitter']);
            		$userInfo['instagram'] = $this->db->escape($_POST['user_instagram']);
            		$userInfo['skype'] = $this->db->escape($_POST['user_skype']);
            		$this->model_settings_settings->saveUserInfo($userInfo);
            	}
            } else {
            	ob_end_clean();
                exit(header("Location: /profile/sign/signin"));
            }
		}
	}
?>