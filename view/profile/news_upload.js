var uploadedOpen = false;

function deletePhoto(button){
	console.log(button);
	var photoCount = $('input[name="fileimage"]').attr("photocount");
	console.log(photoCount);
	$($(button).parents('.news_uploaded_image').get(0)).remove();
	$('input[name="fileimage"]').attr("photocount", --photoCount);
	if (photoCount == 0){
		$('.news_uploaded').animate({
			"height": 0
		});
		uploadedOpen = false;
	}
	countImages();
}

jQuery(function($){
	var photoCount = $('input[name="fileimage"]').attr("photocount");
	var photoIsLoad = false;

	if (!photoIsLoad){
		$.ajaxUploadSettings.name = 'uploads[]';

		$('#upload_image').ajaxUploadPrompt({
			url: '/profile/user/addimage',
			beforeSend: function () {
				$('#upload').hide();
				if (!uploadedOpen) {
					$('.news_uploaded').animate({
						'height': 120
					}, 700);
					uploadedOpen = true;
				}
				$('.news_uploaded').append('<div class="news_uploaded_image"><div id="progress_load">' +
					'<p class="progress_percent">0%</p><div id="progress"></div></div></div></div>');
			},
			onprogress: function (e) {
				if (e.lengthComputable) {
					var percentComplete = e.loaded / e.total;
					$('.progress_percent').text(Math.round(percentComplete * 100) + '%');
					$('#progress').animate({
						'width': percentComplete * 100
					});
					photoIsLoad = true;
				}
			},
			error: function () {
				alert('error');
			},
			success: function (data) {
				data = $.parseJSON(data);
				var html = '';
				if (data.error) {

				}
				if (data.success) {
					$('.news_uploaded').append('<div class="news_uploaded_image" photo=""><img src="/view/images/temp/'
						+ data.image + '"/><button onclick="deletePhoto($(this))" class="delete_attachment">x</button>' +
						'<input type="text" name="photo[' + photoCount + ']" value="' + data.image + '" hidden></div>');
					$('input[name="fileimage"]').attr("photocount", ++photoCount);
					$($('#progress_load').parents('.news_uploaded_image').get(0)).remove();
					countImages();
				}
				if (data.failed) {

				}
				$('#upload').show();
				$('#upload').html(html);
				console.log(data);
			}
		});
	} else {
		alert('Another photo is already upload');
	}
});

function countImages(){
	var countChilds = document.getElementById('images_upload').getElementsByClassName('news_uploaded_image').length;
	var i = 0;
	$('#images_upload > .news_uploaded_image').each(function(){
		$(this).children('input').attr('name', 'photo[' + i + ']');
		i++;
	});
}