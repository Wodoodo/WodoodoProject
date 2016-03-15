<div class="header">
	<div class="header_wrapper">
		<?php
			include $_SERVER['DOCUMENT_ROOT'].'/main/templates/header/menu.tpl';
		?>
		<div class="header_block">
			<img id="logo" src="./images/main/logo.png" alt="logo">
		</div>
		<div class="header_block">
			<form method="POST" action="">
				<input type="text" class="search" maxlength="50" placeholder="Поиск по сайту..." />
				<input type="submit" class="btn_search" value="">
			</form>
		</div>
		<div class="header_block mini_menu">
			<ul>
				<li>Профиль</li>
				<li>Новости</li>
				<li>Сообщения</li>
				<li>Друзья</li>
				<li>Сообщества</li>
				<li>Настройки</li>
				<li>Помощь</li>
				<li>Выход из аккаунта</li>
			</ul>
		</div>
	</div>
</div>