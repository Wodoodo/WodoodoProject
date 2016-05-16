<script type="text/javascript" src="/view/javascripts/profile/messages.js"></script>
<div class="dialogues_wrapper">
	<p class="interlocutor_name"><?php echo $messages->companion['user_firstname'] . ' ' . $messages->companion['user_lastname']; ?></p>
	<p class="status <?php echo isOnline($messages->row['last_activity']); ?>"><?php echo isOnline($messages->companion['last_activity']); ?></p>
	<a href="/messages/dialogues" class="to_messages_btn">Назад к диалогам</a>
	<div class="dialogues_block">
		<div class="all_dialogues">
		<?php for ($i = 0; $i < $messages->num_rows; $i++){ ?>
			<div class="user_message_block">
				<div class="message_info_block">
					<div class="user_photo_block <?php echo isOnline($messages->rows[$i]['last_activity']); ?>">
						<img src="/view/images/users/<?php echo $messages->rows[$i]['user_photo']; ?>" alt="">
					</div>
					<div class="message_info">
						<p class="author_name"><?php echo $messages->rows[$i]['user_firstname'] . ' ' . $messages->rows[$i]['user_lastname']; ?></p>
						<p class="message_datetime"><?php echo $messages->rows[$i]['message_date']; ?></p>
					</div>
				</div>
				<div class="message_text">
					<p><?php echo $messages->rows[$i]['message_text']; ?></p>
				</div>
			</div>
		<?php } ?>
		</div>
	<div class="send_message">
		<textarea class="text_to_send" placeholder="Введите ваше сообщение..."></textarea>
		<div class="attachment_message"></div>
		<div class="button_send_message">Отправить</div>
	</div>
</div>
	<div class="popup_block">
		<div class="popup_wrapper">
			<p class="popup_text">Ошибка</p>
		</div>
	</div>