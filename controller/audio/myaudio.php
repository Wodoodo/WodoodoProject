<?php
	class ControllerAudioMyaudio extends Controller{
		public function index(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/getid3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.mp3.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/audio/getid3/module.audio.wavpack.php');
			$pageStyles = array('header', 'horizontal_menu', 'user_audio');
			$this->registry->set('pageStyles', $pageStyles);    
            $data['header'] = $this->load->controller('header/header');
            $this->load->model('profile/user');
            if(!isset($_GET['id']))
            {
                if (isset($_SESSION['USER'])) {

                    $userInfo = $this->model_profile_user->getUser();
                    $data['isMyPage'] = true;
                } else {
                    ob_end_clean();
                    exit(header("Location: /profile/sign/signin"));
                }
            } else {
                $userInfo = $this->model_profile_user->getUserFromID();
                $data['isMyPage'] = false;
            }

            $this->load->model('audio/audio');

			$data['songList'] = $this->model_audio_audio->getAudioList($userInfo->row['user_id']);
			$this->saveMusicPhoto($data);

            $this->load->view('audio/audio', $data);
		}

		public function saveMusicPhoto($data){
			$getid3 = new getID3();
		  	$getid3->encoding = 'UTF-8';
		  	$getid3->Analyze($_SERVER['DOCUMENT_ROOT'] . '/view/audio/' . $data['songList']->rows[0]['song_path']);
			$fileName = preg_replace("/\.mp3$/", "", $getid3->info['filename']);
		  	$file =  $fileName . '.jpg';
		  	$text = $getid3->info['comments']['picture'][0]['data'];
		  	$filePath = $_SERVER['DOCUMENT_ROOT'] . '/view/images/audio/' . $file;
		  	file_put_contents($filePath, $text);
		  	/*if((strcmp($getid3->info['fileformat'], "wav") != 0) && (isset($getid3->info['comments']['picture'][0]['data']))){
		  		$fileName = preg_replace("/\.mp3$/", "", $getid3->info['filename']);
		  		$file =  $fileName . '.jpg';
				$text = $getid3->info['comments']['picture'][0]['data'];
				file_put_contents($file, $text);
		  	} else if((strcmp($getid3->info['fileformat'], "wav") != 0) && (!isset($getid3->info['comments']['picture'][0]['data']))){
		  		$file = "no_sound.jpg";
		  	} else 	{
		  		$fileName = preg_replace("/\.wav$/", "", $getid3->info['filename']);
		  		$file =  $fileName . '.jpg';
				$text = $getid3->info['comments']['picture'][0]['data'];
				file_put_contents($file, $text);
		  	}*/
		  	//$getid3->info['comments']['picture']['data'];
		}
	}
?>