<link rel="stylesheet" type="text/css" href="/view/stylesheets/login.css">
<div class="login">
	<?php MessageShow(); ?>
	<img src="/view/images/login.png">
	<p>Восстановление пароля</p>
	<form method="POST" action="/profile/sign/remember">
		<input type="email" name="email" maxlength="100" placeholder="E-Mail" autocomplete="off" required>
		<input type="submit" name="send_request" value="Отправить запрос">
	</form>
	<a href="/profile/sign"><p>Вход на сайт</p></a>
</div>