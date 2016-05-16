var getReq = getUrlVars();
$(document).ready(function(){
    var text;
    $('.all_dialogues').animate({
        'scrollTop': $('.all_dialogues')[0].scrollHeight
    }, 500);
    setInterval(updateMessages, 400);
    $('.text_to_send').keypress(function(e){
        if (e.which == 13){
            var content = this.value;
            if (!e.shiftKey) {
                text = $('.text_to_send').val();
                if (text.length <= 0) {
                    showMessage('error', 'Введите сообщение для отправки');
                } else {
                    $.ajax({
                        type: 'post',
                        url: '/messages/view/sendMessage',
                        data: ({'message_send': 'send', 'conversation_id': getReq['id'], 'message_text': text}),
                        success: function (response) {
                            $('.text_to_send').val('');
                            response = JSON.parse(response);
                            updateMessages();
                        }
                    })
                }
            } else {
                this.value = content + "\r\n";
            }
            e.preventDefault();
        }
    });
    $('.button_send_message').click(function(){
        text = $('.text_to_send').val();
        if (text.length <= 0){
            showMessage('error', 'Введите сообщение для отправки');
        } else {
            $.ajax({
                type: 'post',
                url: '/messages/view/sendMessage',
                data: ({'message_send':'send', 'conversation_id':getReq['id'], 'message_text':text}),
                success: function(response)
                {
                    $('.text_to_send').val('');
                    response = JSON.parse(response);
                    updateMessages();
                }
            })
        }
    });
});

function showMessage(messageType, messageText){
    $('html, body').animate({
        scrollTop: 0
    }, 500);
    $('.popup_text').text(messageText);
    $('.popup_block').addClass('popup_' + messageType);
    $('.popup_block').fadeIn();
    setTimeout(function(){
        $('.popup_block').fadeOut();
    }, 2000)
}

function getUrlVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++){
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function updateMessages(conversationId){
    var textToAppend = '';
    $.ajax({
        type: 'post',
        url: '/messages/view/updateMessages',
        data: ({'update_message':'update', 'conversation':getReq['id']}),
        success: function(response){
            response = JSON.parse(response);
            for (var i = 0; i < response.num_rows; i++){
                textToAppend += '<div class="user_message_block"><div class="message_info_block"><div class="user_photo_block online"><img src="/view/images/users/' + response.rows[i]["user_photo"] + '"></div><div class="message_info"><p class="author_name">' + response.rows[i]["user_firstname"] + ' ' + response.rows[i]["user_lastname"] + '</p><p class="message_datetime">' + response.rows[i]["message_date"] + '</p></div></div><div class="message_text"><p>' + response.rows[i]["message_text"] + '</p></div></div>';
            }
            $('.all_dialogues').append(textToAppend);
            if (response.num_rows > 0){
                $('.all_dialogues').animate({
                    'scrollTop': $('.all_dialogues')[0].scrollHeight
                }, 500);
            }
        }
    });
}