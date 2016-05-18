<div class="user_friends_wrapper">
	<p class="block_title">Друзья</p>
	<div class="search_friends">
		<form method="POST" action="">
			<input type="text" name="search_friends" placeholder="Введите имя для поиска..." maxlength="100" required>
		</form>
    </div>
    <div class="type_page">  
		<?php 
			if($user_id == $id){ ?>
				<a href="/friends/myfriends" class="popular_messages"><b>Все друзья (<?php echo $userFriends->num_rows; ?>)</b></a>
				<a href="/friends/myfriends/incoming" class="incoming_requests">Входящие запросы (<?php echo $userIncomingRequests->num_rows; ?>)</a>   
				<a href="/friends/myfriends/outgoing" class="outgoing_requests">Исходящие запросы (<?php echo $userOutgingRequests->num_rows; ?>)</a>
		<?php } else { ?>
				<p class="popular_messages"><b>Все друзья (<?php echo $userFriends->num_rows; ?>)</b></p>
		<?php } ?>
	</div>
	<div class="all_user_friends_block">
		<?php
			if(($userFriends->num_rows <= 0)){
				echo '<p class="have_post">У Вас нет друзей</p>';
			} else {
				for($i = 0; $i < $userFriends->num_rows; $i++){ ?>
					<div class="user_friend_block">
						<div class="user_friend_photo_block">
							<img src="/view/images/users/<?php echo $userFriends->rows[$i]['user_photo']; ?>">
						</div>
						<div class="user_friend_info">
							<p class="user_friend_name <?php echo isOnline($userFriends->rows[$i]['last_activity']); ?>"><a
										href="/profile/user?id=<?php echo $userFriends->rows[$i]['id']; ?>"><b><?php echo $userFriends->rows[$i]['user_name']; ?></b></a></p>
							<p class="user_friend_add_info"><?php echo $userFriends->rows[$i]['city'] . $userFriends->rows[$i]['fullYears']; ?></p>
							<div class="btn_send_message">
								<a href="/messages/dialogues/newDialog?companion_id=<?php echo $userFriends->rows[$i]['id']; ?>"><p>Отправить сообщение</p></a>
								<?php 
									if($user_id == $id){ ?>
										<a href="/profile/user/deleteFriend?user=<?php echo $userFriends->rows[$i]['userId']; ?>&friend=<?php echo $userFriends->rows[$i]['id']; ?>"><p>Удалить из друзей</p></a>
									<?php } ?>
							</div>
						</div>
					</div>
				<?php }
			}
		?>
	</div>
</div>