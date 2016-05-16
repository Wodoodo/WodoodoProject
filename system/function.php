<?php
	ob_start();
	session_start([ 
		'cookie_lifetime' => 86400 
	]);

	function sessionHash($session){
		return sha1(md5('mysalt').md5($session).md5('228'));
	}

	function passHash($password){
		return md5(md5('mysalt').md5($password).md5('228'));
	}

	function getFullYears($birthdayDate) {
		$curday = date("Y-m-j");
		$d1 = strtotime($birthdayDate);
		$d2 = strtotime($curday);
		$diff = $d2 - $d1;
		$diff = $diff / (60 * 60 * 24 * 365);
		$years = floor($diff);
		return $years;
	}

	function MessageSend($MessageType, $MessageText, $BackUrl){
		$MessageText = "<div class=\"show_message ".$MessageType."_message_popup\"><p>".$MessageText."</p></div>";
		$_SESSION['MESSAGE_SHOW'] = $MessageText;
		ob_end_clean();
		exit(header("Location: /".$BackUrl));
	}

	function MessageShow()
	{
		if (isset($_SESSION['MESSAGE_SHOW'])) {
			echo $_SESSION['MESSAGE_SHOW'];
			unset($_SESSION['MESSAGE_SHOW']);
		}
	}

	function isOnline($lastActivity)
	{
		$dateNow = date('Y-m-d H:i:s');
		$dateNow = strtotime($dateNow);
		$lastActivity = strtotime($lastActivity);
		$min = $dateNow - $lastActivity;
		$min = $min / (60);
		if($min >= 15){
			return "offline";
		} else {
			return "online";
		}
	}

	function mail_utf8($to, $subject = '(No subject)', $message = '', $from) {
		$header = 'MIME-Version: 1.0' . "\n" . 'Content-type: text/html; charset=UTF-8' . "\n" . 'From: <' . $from . ">\n";
		mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
	}
?>