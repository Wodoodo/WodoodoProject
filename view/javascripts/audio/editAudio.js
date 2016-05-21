$(document).ready(function(){
	var songId;
	$('.audio_editing_btn').click(function(){
		songId = $(this).attr('songid');
		$.ajax({ 
			type: "POST",
			url: "/services/music/getAudioInfo", 
			data: ({musicId : songId}), 
			success: function(response) 
			{ 
				response = JSON.parse(response);
				console.log(response.row['song_author']);
				$('#input_author_name').val(response.row['song_author']);
				$('#input_audio_name').val(response.row['song_name']);
			}
		});
		$('.edit_music_popup').css({
            'height': $(document).height() + 'px'
        })
        $('.edit_music_popup').fadeIn(300);
    });
    $(document).mouseup(function(e){
        var popup = $('.edit_music_popup');
        if (popup.has(e.target).length == 0){
            popup.fadeOut(300);
        }
    });

    $('#edit_info').click(function(){
    	var author_name = $('#input_author_name').val();
    	var audio_name = $('#input_audio_name').val();
    	$.ajax({
    		type: "POST",
    		url: "/services/music/updateAudioInfo",
    		data: ({musicId : songId, authorName : author_name, audioName : audio_name}),
    		success: function()
    		{
    			setTimeout(function() {window.location.reload();}, 1000);
    			$('.result_edit_music').text('Изменения внесены успешно');
    		}
    	});
    });

});