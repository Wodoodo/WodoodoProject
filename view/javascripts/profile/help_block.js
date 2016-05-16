var pressCount = 0;
var inputText;
var tempString;
var regexp = new RegExp("[^а-яА-Я]");
$(document).ready(function(){
	$('.city_block').on('click', '.city', function(e){
		var city = $(this).attr('city');
		$('input[name="user_city"]').val(city);
		$('.hint_block').animate({
			'height':0
		});
		$('.hint_block').css({
			'border': 'none'
		});
	});
	$('input[name="user_city"]').keyup(function(){
		tempString = $('input[name="user_city"]').val();
		if(tempString.length >= 1)
		{
			$.ajax({ 
				type: "POST",
				url: "/profile/user/getCity", 
				data: ({inputValue : tempString}), 
				success: function(response) 
				{ 
					response = JSON.parse(response);
					var city = '';
					if(response.rows.length > 0){
						for (var i = 0; i < response.rows.length; i++){
							city += '<div class="city" cityId="' + response.rows[i]['id'] + '" city="' + response.rows[i]['city_name'] + '"><p class="city_name">' + response.rows[i]['city_name'] + '</p><p class="area">' + response.rows[i]['city_area'] + ' обл.' + ', '+ response.rows[i]['city_district'] + ' р-н.' +'</p></div>';
						}
					} else {
						city += '<div class="city"><p class="city_name">Город не найден</p></div>';
					}
					$('.hint_block').append(city);
					console.log('Строки: ' + response.rows.length);
				}
			});
			var child = $('.hint_block').children();
			for (var i = 0; i < child.length; i++){
				child.remove();
			}


			//$('.hint_block').append('<div class="city_block"><p class="city_name">Витебск</p><p class="area">Витебская обл. Витебский р-н</p></div>');
			$('.hint_block').animate({
				'height':150
			});	
			$('.hint_block').css({
				'border': 'solid 1px black',
			});
		} else {
			$('.hint_block').animate({
				'height':0
			});
			$('.hint_block').css({
				'border': 'none'
			});
			//$('.city_block').empty();
		}
		/*pressCount++;
		if(pressCount >= 3)
		{
			$('.hint_block').animate({
				'height':50
			});
			pressCount = 0;
		} */
	});
});