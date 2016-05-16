<div class="user_friends_wrapper">
	<p class="block_title">Исходящие запросы</p>
	<div class="search_friends">
		<form method="POST" action="">
			<input type="text" name="search_friends" placeholder="Введите имя для поиска..." maxlength="100" required>
		</form>
    </div>
    <div class="type_page">
		<a href="/friends/myfriends" class="popular_messages">Все друзья (<?php echo $userFriends->num_rows; ?>)</a>
		<a href="/friends/myfriends/incoming" class="incoming_requests">Входящие запросы (<?php echo $userIncomingRequests->num_rows; ?>)</a>
		<a href="/friends/myfriends/outgoing" class="outgoing_requests"><b>Исходящие запросы (<?php echo $userOutgingRequests->num_rows; ?>)</b></a>
	</div>
	<div class="all_user_friends_block">
		<?php
			if(($userOutgingRequests->num_rows <= 0)){
				echo '<p class="have_post">У Вас нет исходящих запросов</p>';
			} else {
				for($i = 0; $i < $userOutgingRequests->num_rows; $i++){ ?>
					<div class="user_friend_block">
						<div class="user_friend_photo_block">
							<img src="/view/images/users/<?php echo $userOutgingRequests->rows[$i]['user_photo']; ?>">
						</div>
						<div class="user_friend_info">
							<p class="user_friend_name <?php echo isOnline($userOutgingRequests->rows[$i]['last_activity']); ?>"><a
										href="/profile/user?id=<?php echo $userOutgingRequests->rows[$i]['recipient_id']; ?>"><b><?php echo $userOutgingRequests->rows[$i]['user_name']; ?></b></a></p>
							<p class="user_friend_add_info"><?php echo $userOutgingRequests->rows[$i]['city'] . $userOutgingRequests->rows[$i]['fullYears']; ?></p>
							<div class="btn_send_message">
								<a href="/profile/user/cancelRequest?sender=<?php echo $userOutgingRequests->rows[$i]['sender']; ?>&recipient=<?php echo $userOutgingRequests->rows[$i]['recipient_id']; ?>&page=/friends/myfriends/outgoing"><p>Отменить запрос</p></a>
							</div>
						</div>
					</div>
				<?php }
			}
		?>
	</div>
</div>