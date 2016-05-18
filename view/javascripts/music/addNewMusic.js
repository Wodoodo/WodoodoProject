$(document).ready(function(){
    $('button.add_music').click(function(){
        $('.add_music_popup').css({
            'height': $(document).height() + 'px'
        })
        $('.add_music_popup').fadeIn(300);
    });
    $(document).mouseup(function(e){
        var popup = $('.add_music_popup');
        if (popup.has(e.target).length == 0){
            popup.fadeOut(300);
        }
    });
});

jQuery(function($){
    var photoIsLoad = false;

    if (!photoIsLoad){
        $.ajaxUploadSettings.name = 'upload[]';

        $('button#add_new_music_button').ajaxUploadPrompt({
            url: '/services/music/add',
            beforeSend: function () {
                $('#upload').hide();
                $('p.result_upload_music').text('Выполняется проверка файла...');
            },
            onprogress: function (e) {
                if (e.lengthComputable) {
                    var percentComplete = e.loaded / e.total;
                    $('p.state_upload_music').text('Загружено: ' + Math.round(percentComplete)*100 + '%');
                }
            },
            error: function () {
                alert('error');
            },
            success: function (data) {
                data = $.parseJSON(data);
                var html = '';
                if (data.result) {
                    $('p.result_upload_music').text(data.result);
                    setTimeout(function() {window.location.reload();}, 1000);
                }
            }
        });
    } else {
        alert('Another photo is already upload');
    }
});