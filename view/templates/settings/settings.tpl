<script type="text/javascript" src="/view/javascripts/profile/help_block.js"></script>
<div class="settings_wrapper">
	<form method="POST">
		<label>Сменить фото:</label><input type="file" name="user_photo"></input>
		<?php 
			$filename = $photo;
			$photo = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . "/view/images/users/" . $photo);
			$w_src = imagesx($photo);
			$h_src = imagesy($photo);
			$w = 150;
			$dest = imagecreatetruecolor($w, $w);
			// Вырезаем квадратную серединку по x, если фото горизонтальное
			if ($w_src > $h_src)
				imagecopyresampled($dest, $photo, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src))/2), 0, $w, $w, min($w_src, $h_src), min($w_src, $h_src));

			// Вырезаем квадратную серединку по y, если фото горизонтальное
			elseif ($w_src < $h_src)
				imagecopyresampled($dest, $photo, 0, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src))/2), $w, $w, min($w_src, $h_src), min($w_src, $h_src));
			// Квадратная картинка масштабируется без вырезок
			elseif ($w_src == $h_src)
				imagecopyresampled($dest, $photo, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
			imagejpeg($dest, $_SERVER['DOCUMENT_ROOT'] . '/view/images/users/lol' . $filename);
		?>
		<div class="user_photo_block" id="images_upload">
			<img src="<?php echo '/view/images/users/lol' . $filename; ?>">
		</div><br>
		<div class="city_block">
			<label>Город:</label><input type="text" id="user_city" name="user_city" value="<?php echo $city; ?>" autocomplete="off"></input>
			<div class="hint_block"></div>
		</div>
		<label>Дата рождения:</label><input type="date" name="user_birthday" value="<?php echo $birthday; ?>"></input><br>
		<label>Телефон:</label><input type="text" name="user_phone" value="<?php echo $phone; ?>"></input><br>
		<label>Отношения:</label>
							<?php 
								$relationship = array('не указано', 'в активном поиске', 'встречается', 'влюблен/влюблена', 'женат/замужем');
								echo 
								'<select name="user_relations">';
									for($i = 0; $i < count($relationship); $i++){
										if($i == $relations){
											echo '<option value="' .$i. '" selected>' . $relationship[$i] . '</option>';
										} else {
											echo '<option value="' . $i .'">' . $relationship[$i] . '</option>';
										}
									}
								echo '</select><br>';
								?>
		<label>Twitter:</label><input type="text" name="user_twitter" value="<?php echo $twitter; ?>"></input><br>
		<label>Instagram:</label><input type="text" name="user_instagram" value="<?php echo $instagram; ?>"></input><br>
		<label>Skype:</label><input type="text" name="user_skype" value="<?php echo $skype; ?>"></input><br>
		<input type="submit" name="save_info" value="Сохранить"></input>
	</form>
</div>