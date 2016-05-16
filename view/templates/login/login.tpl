<html>
<head>
	<link rel="stylesheet" href="/resource/stylesheets/login.css">
</head>
<body>
	<?php
		if (isset($_GET['type'])){
			$DirrectoryTemplate = $_SERVER['DOCUMENT_ROOT'].'/view/login/'.$_GET['type'].'.tpl';
			if (file_exists($DirrectoryTemplate)){
				include_once $DirrectoryTemplate;
			}
		}
	?>