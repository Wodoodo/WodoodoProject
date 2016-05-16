<link rel="stylesheet" type="text/css" href="/view/stylesheets/login.css">
<div class="login">
	<?php MessageShow(); ?>
	<img src="/view/images/login.png">
	<p>Вход в аккаунт</p>
	<form method="POST" action="/profile/sign/signin">
		<input type="email" name="auth_email" maxlength="100" placeholder="E-Mail" autocomplete="off" required>
		<input type="password" name="auth_pass" maxlength="100" placeholder="Пароль" autocomplete="off" required>
		<input type="submit" name="send_request" value="Войти">
	</form>
	<a href="remember"><p>Забыли пароль?</p></a>
	<a href="signup"><p>Зарегистрироваться</p></a>
</div>