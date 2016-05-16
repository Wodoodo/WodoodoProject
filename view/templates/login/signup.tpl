<div class="register">
	<?php MessageShow(); ?>
	<img src="/resource/images/login.png">
	<p>Регистрация аккаунта</p>
	<form method="POST" action="/controller/profile/signup.php">
		<input type="email" name="auth_email" maxlength="100" placeholder="E-Mail" autocomplete="off" value="<?php if(isset($_SESSION['email'])) { echo $_SESSION['email']; } ?>" required>
		<input type="password" name="auth_pass" maxlength="100" placeholder="Пароль" autocomplete="off" required>
		<input type="password" name="auth_repass" maxlength="100" placeholder="Повторите пароль" autocomplete="off" required>
		<input type="text" name="auth_firstname" maxlength="100" placeholder="Имя" autocomplete="off" value="<?php if(isset($_SESSION['firstname'])) { echo $_SESSION['firstname']; } ?>" required>
		<input type="text" name="auth_lastname" maxlength="100" placeholder="Фамилия" autocomplete="off" value="<?php if(isset($_SESSION['lastname'])) { echo $_SESSION['lastname']; } ?>" required></input>
		<input type="submit" name="send_request" value="Зарегистрироваться">
	</form>
</div>	