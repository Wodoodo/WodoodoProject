<?php
	class ControllerServicesPfilm extends Controller{
		public function index(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/view/javascripts/films/simple_html_dom.php');
			if(isset($_GET['film'])){
				$data['film'] = $this->getFilmInfo($_GET['film']);
				$data['players'] = $data['film']['gamePlayers'];
				$data['issetInList'] = $data['film']['issetInList'];
				$pageTitle = $data['film']['name']; 
				$this->registry->set('pageTitle', $pageTitle);
			}
			$pageStyles = array('header', 'horizontal_menu', 'films');
			$this->registry->set('pageStyles', $pageStyles);	
			$data['header'] = $this->load->controller('header/header');
			$this->load->model('services/pfilm');
			$this->load->view('films/film_page', $data);
		}

		public function getFilmInfo($filmURL){
			$url = "http://afisha.tut.by/film/" . $filmURL . "/";
			$pageTemp = file_get_contents($url);
			$page = file_get_html($url);
			$title = $page->find('.title');
			$data['name'] = $title[0]->innertext;
			$photo = $page->find('.main_image'); 
			$data['photo'] = $photo[0]->src;
			foreach($page->find('a[itemprop=genre]') as $genre){ 
				$data['genre'] .= $genre->innertext . ", ";
			}
			if(isset($data['genre'])){
				$data['genre'] = substr_replace($data['genre'], '', strlen($data['genre']) - 2);
			}
			$year = $page->find('.year a', 0);
			$data['year'] = $year->innertext;
			$author = $page->find('.author', 0);
			$data['author'] = $author->innertext;
			$duration = $page->find('.duration', 0);
			$data['duration'] = $duration->innertext;
			$age = $page->find('.title__labels .label', 1);
			$data['age'] = $age->innertext;
			$result = preg_match_all('/(?:\<p\>Режиссер:)(.*)(?=\<\/p\>)/', $pageTemp, $producer);
			$data['producer'] = $producer[1][0];
			$result = preg_match_all('/(?:\<p\>В ролях:)(.*)(?=\<\/p\>)/', $pageTemp, $role);
			$data['role'] = $role[1][0];
			$div = $page->find('#event-description', 0);
			$post = substr_replace($div->plaintext, '', strlen($div->plaintext) - 165); 
			$data['text'] = $post;
			$photoList = $page->find('a[itemprop=contentUrl]');
			for($i = 0; $i < 3; $i++)	
				$data[$i]['photoList'] = $photoList[$i]->href; 

			$video = $page->find('link[itemprop=url]', 0);
			$data['video'] = $video->href;
			$poster = $page->find('link[itemprop=thumbnail thumbnailUrl]', 0);
			$data['poster'] = $poster->href;
			$this->load->model('services/pfilm');
			$data['rating'] = $this->model_services_pfilm->getRating($this->db->escape($filmURL));
			if(isset($data['rating'])){
				if(($data['rating'] >= 0) && ($data['rating'] <= 39)){
					$data['color'] = 'red';
				} else if(($data['rating'] > 39) && ($data['rating'] <= 79)){
					$data['color'] = 'orange';
				} else if($data['rating'] > 79){
					$data['color'] = 'green';
 				}
			} else {
				$data['color'] = 'red';
			}
			$data['id'] = $this->model_services_pfilm->getFilmId($this->db->escape($filmURL));
			$wather = $this->model_services_pfilm->getWatcher($this->db->escape($data['id']));
			$data['gamePlayers'] = $wather['gamePlayers'];
			$data['issetInList'] = $wather['issetInList'];
			return $data;
		}

		public function addInList(){
			$this->load->model('services/pfilm');
			$result = $this->model_services_pfilm->addInList($_GET['film']);
			MessageSend($result['status'], $result['text'], 'services/pfilm?film=' . $_GET['film']);
		}

		public function deleteFromList(){
			$this->load->model('services/pfilm');
			$result = $this->model_services_pfilm->deleteFromList($_GET['film']);
			MessageSend($result['status'], $result['text'], 'services/pfilm?film=' . $_GET['film']);
		}
	}
?>