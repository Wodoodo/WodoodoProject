$(document).ready(function(){
	var searchValue = '';
	var textForAppend;
	$('input[name="genre_search"]').keyup(function(){
		searchValue = $(this).val();
		if (searchValue.length >= 0){
			$.ajax({
				type: 'post',
				data: ({'search':'search', 'value':searchValue}),
				url: '/services/music/searchGenres',
				success: function(e){
					e = JSON.parse(e);
					textForAppend = '';
					for (var i = 0; i < e.genre.num_rows; i++){
						textForAppend += '<a href="/services/music?genre_id=' + e.genre.rows[i]["id"] + '">' + e.genre.rows[i]["genre_name"] + '</a> ';
					}
					$('.genre_list').empty();
					$('.genre_list').append(textForAppend);
				}
			})
		}
	});
});