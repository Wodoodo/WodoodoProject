<link rel="stylesheet" type="text/css" href="/view/stylesheets/login.css">
<div class="login">
	<?php MessageShow(); ?>
	<img src="/view/images/login.png">
	<p>Восстановление пароля</p>
	<form method="POST" action="/profile/sign/remember">
		<input type="text" name="request_key" maxlength="100" placeholder="Введите текст запроса" autocomplete="off" value="<?php echo $request; ?>" readonly required>
		<input type="text" name="password" maxlength="100" placeholder="Введите пароль" autocomplete="off" required>
		<input type="text" name="repassword" maxlength="100" placeholder="Повторите пароль" autocomplete="off" required>
		<input type="submit" name="change_pass" value="Изменить пароль">
	</form>
	<a href="/profile/sign"><p>Вход на сайт</p></a>
</div>