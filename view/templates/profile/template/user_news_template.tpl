<form method="POST" action="/profile/user/addPost">
	<div class="user_news_search">
		<textarea name="news_text" maxlength="1000" placeholder="Введите текст..." required></textarea>
		<input type="file" name="fileimage" photocount="0" id="1" class="fileimage">
        <input type="text" name="user_id" value="<?php echo $_GET['id']; ?>" hidden>
		<label id="upload_image"><img src="/view/images/photo.png"/></label>
		<input type="submit" name="add_post" value="Опубликовать">
	</div>
	<div class="news_uploaded" id="images_upload">
		<p>Прикрепленные файлы</p><br>
	</div>
	</div>
</form>