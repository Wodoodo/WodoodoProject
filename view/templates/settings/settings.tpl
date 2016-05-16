<script type="text/javascript" src="/view/javascripts/profile/help_block.js"></script>
<div class="settings_wrapper">
	<form method="POST" enctype="multipart/form-data">
		<label>Сменить фото:</label><input type="file" name="user_photo" class="change_photo">
x
		<!--<div class="user_photo_block" id="images_upload">
			<img src="<?php echo '/view/images/users/lol' . $filename; ?>">
		</div><br>-->
		<div class="city_block">
			<label>Город:</label><input type="text" id="user_city" name="user_city" value="<?php echo $city; ?>" autocomplete="off">
			<div class="hint_block"></div>
		</div>
		<label>Дата рождения:</label><input type="date" name="user_birthday" value="<?php echo $birthday; ?>"><br>
		<label>Телефон:</label><input type="text" name="user_phone" value="<?php echo $phone; ?>"><br>
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
		<label>Twitter:</label><input type="text" name="user_twitter" value="<?php echo $twitter; ?>"><br>
		<label>Instagram:</label><input type="text" name="user_instagram" value="<?php echo $instagram; ?>"><br>
		<label>Skype:</label><input type="text" name="user_skype" value="<?php echo $skype; ?>"><br>
		<div class="information_button">
			<a href="/settings/mysettings"><button class="button_cancel">Отменить изменения</button></a>
			<input type="submit" name="save_info" class="button_save" value="Сохранить">
		</div>
	</form>
</div>