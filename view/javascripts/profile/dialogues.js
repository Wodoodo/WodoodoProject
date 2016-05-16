$(document).ready(function(){
	setInterval(updateMessages, 1000);
});

function updateMessages(){
	var textToAppend = '';
	$.ajax({
		type: 'post',
		url: '/messages/dialogues/updateMessages',
		data: ({'update':'update'}),
		success: function(response){
			response = JSON.parse(response);
			for (var i = 0; i < response.num_rows; i++){
				$('.dialog_block').each(function(n, e){
					if (response.rows[i]['messages'].row['message_text'] != undefined) {
						if ($(e).attr('dialogid') == response.rows[i]['conversation_id']) {
							var blockContent = $(e).find('.message_text').text();
							if (blockContent != response.rows[i]['messages'].row['message_text']){
								if (response.row['my_id'] == response.rows[i]['messages'].row['from_id']){
									$(e).find('.message_text').removeClass('your_mess');
								} else {
									$(e).find('.message_text').addClass('your_mess');
								}
								if (response.rows[i]['messages'].row['viewed'] == 0){
									$(e).addClass('unread');
								} else {
									$(e).removeClass('unread');
								}
								$(e).find('.message_text').text(response.rows[i]['messages'].row['message_text']);
							} else {
								if (response.rows[i]['messages'].row['viewed'] == 1){
									$(e).removeClass('unread');
								}
							}
						}
					}
				});
			}
		}
	});
}