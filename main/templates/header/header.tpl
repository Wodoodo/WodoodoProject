<div class="header">
	<div class="header_wrapper">
		<?php
			include $_SERVER['DOCUMENT_ROOT'].'/main/templates/header/menu.tpl';
		?>
		<div class="header_block logo">
			<img id="logo" src="./images/main/logo.png" alt="logo">
		</div>
		<div class="header_block block_search">
			<form method="POST" action="">
				<input type="text" class="search" maxlength="50" placeholder="Поиск по сайту..." />
				<input type="submit" class="btn_search" value="">
			</form>
		</div>
		<div class="header_block mini_menu">
			<ul class="right_menu">
				<li>Помощь</li>
				<li>Выход из аккаунта</li>
				<li><img src="/images/help.png"/></li>
				<li><img src="/images/exit.png"/></li>
			</ul>
		</div>
	</div>
</div>