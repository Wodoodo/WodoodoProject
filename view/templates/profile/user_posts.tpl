<div class="user_posts">
	<script type="text/javascript" src="/view/javascripts/profile/view_images.js"></script>
	<script type="text/javascript" src="/view/javascripts/profile/likes.js"></script>
	<?php
		$assocPhoto = array("1" => "one", "2" => "two", "3" => "three", "4" => "four", "5" => "five");
		if ($userPost->num_rows <= 0)
			echo '<p class="have_post">This user doesn\'t have a posts</p>';
		else {
			for ($i = 0; $i < $userPost->num_rows; $i++){
			$images = json_decode($userPost->rows[$i]['post_images']);
			$photoCount = $assocPhoto[count($images->images)];
			if(count($images->images) > 0){
				if(count($images->images) >= 3){
					$width = 33;
				} else {
					$width = 100/count($images->images);
				}
			}
			?>
			<div class="post_block <?php if (count($images->images) == 0) echo 'without_photo'; ?>" idpost="<?php echo $userPost->rows[$i]['post_id']; ?>">
				<?php if(($userPost->rows[$i]['user'] == $userPost->rows[$i]['owner_id']) || ($userPost->rows[$i]['user'] == $_GET['id']) || (!isset($_GET['id']))){ ?>
					<a href="/profile/user/deletePost?postid=<?php echo $userPost->rows[$i]['post_id']; ?>&page=/profile/user?id=<?php echo (isset($_GET['id'])) ? $_GET['id'] : $userPost->rows[$i]['user']; ?>" class="delete_post">X</a>
				<?php } ?>
				<div class="post_text_block">
					<div class="post_author">
						<img src="/view/images/users/<?php echo $userPost->rows[$i]['user_photo']; ?>">
						<div class="post_info">
							<p class="author_name <?php echo isOnline($userPost->rows[$i]['last_activity']); ?>"><a
										href="/profile/user?id=<?php echo $userPost->rows[$i]['owner_id']; ?>"><b><?php echo $userPost->rows[$i]['user_name']; ?></b></a></p>
							<p class="post_time"><?php echo $userPost->rows[$i]['post_date']; ?></p>
						</div>
					</div>
					<div class="post_text">
						<p><?php echo $userPost->rows[$i]['post_text']; ?></p>
					</div>
					<div class="post_comm_like">
						<div class="likers_block">
							<div class="likers_photo_block">
							</div>
							<p class="all_likers_btn">Показать все</p>
						</div>
						<div class="<?php echo (strcmp($userPost->rows[$i]['like_state'], 'false') == 0) ? btn_like : btn_like_press; ?>" like="<?php echo $userPost->rows[$i]['like_state']; ?>" postid="<?php echo $userPost->rows[$i]['post_id']; ?>">
							<p class="like_number"><?php echo $userPost->rows[$i]['like_number']; ?></p><p class="like_button">LIKE</p>
						</div>
					</div>
				</div>
				<?php if (count($images->images) > 0) { ?>
				<div class="post_photo_block">
					<?php for ($j = 0; $j < count($images->images); $j++) { 
						echo '<div class="image_block" style="width: ' . $width . '%; height:' . (100/ceil(count($images->images)/3)) . '%;"><img src="/view/images/temp/' . $images->images[$j] . '"></div>';
					} ?>
				</div>
				<?php } ?>
			</div>
			<?php }
		}
	?>
</div>
<div id="photo_slider">
	<div class="photo_slider_window">
		<div id="nav_prev">PREV</div>
		<div id="nav_next">NEXT</div>
		<div id="close_slider">x</div>
		<div class="photo_slider_image">
			<img src="" alt="">
		</div>
	</div>
</div>