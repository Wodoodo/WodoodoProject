<script type="text/javascript" src="/view/javascripts/profile/dialogues.js"></script>
<div class="messages_wrapper">
	<p class="page_title">Сообщения</p>
	<div class="search_block">
		<form method="POST" action="">
			<input type="text" name="search_block" placeholder="Поиск сообщений и собеседников..." maxlength="100" required>
		</form>
    </div>
	<div class="messages_title">
		<div class="type_messages">
			<a href="" class="popular_messages">Популярные</a> |
			<a href="" class="last_messages">Последние</a>
		</div>
	</div>
	<div class="all_dialogues_block">
		<?php
			for ($i = 0; $i < $userMessages->num_rows; $i++){
			if (strlen($userMessages->rows[$i]['messages']->rows[0]['message_text']) > 0) { ?>
			<a href="/messages/view?id=<?php echo $userMessages->rows[$i]['conversation_id']; ?>">
				<div class="dialog_block <?php echo (($userMessages->rows[$i]['messages']->rows[0]['viewed']) && ($userMessages->rows[$i]['user_from'] != $userMessages->row['my_user_id'])) ? '' : 'unread'; ?>" dialogid="<?php echo $userMessages->rows[$i]['conversation_id']; ?>">
					<div class="dialog_title_block">
						<div class="author_photo <?php echo isOnline($userMessages->rows[$i]['companion_info']->rows[0]['last_activity']); ?>">
							<img src="/view/images/users/<?php echo $userMessages->rows[$i]['companion_info']->rows[0]['user_photo']; ?>" alt="">
						</div>
						<div class="message_info">
							<p class="author_name"><?php echo $userMessages->rows[$i]['companion_info']->rows[0]['user_firstname'] . ' ' . $userMessages->rows[$i]['companion_info']->rows[0]['user_lastname']; ?></p>
							<p class="last_mess_time"><?php echo $userMessages->rows[$i]['messages']->rows[0]['message_date']; ?></p>
						</div>
					</div>
					<div class="message_text_block" id="message_text_block">
						<p class="message_text <?php if ($userMessages->rows[$i]['messages']->rows[0]['user_from'] == $userMessages->row['my_user_id']) echo 'your_mess'; ?>" id="message_text"><?php echo $userMessages->rows[$i]['messages']->rows[0]['message_text']; ?></p>
					</div>
				</div>
			</a>
		<?php } } ?>
</div>
<div class="popup_block">
	<div class="popup_wrapper">
		<p class="popup_text"></p>
	</div>
</div>