var isOpen = false;
$(document).ready(function(){
	$("#services").click(function(){
		if (!isOpen){
			$('.menu_services').animate({
				"height" : 300
			}, 300, function(){
				$('.menu_services').animate({
					"width" : 180
				});
				$('.user_basic_info').animate({
					"margin-left":35
				});
				isOpen = true;
			});
		} else {
			$('.user_basic_info').animate({
				"margin-left":0
			}, 350);
			$('.menu_services').animate({
				"width" : 35
			}, 300, function(){
				$('.menu_services').animate({
					"height" : 0
				});
				isOpen = false;
			});	
		}
	});

	var infoOpen = false;

	/* USER INFO */
	$('.user_info_btn').click(function(){
		$('.user_info').css({
			'visibility':'visible'
		});
		$('.user_info').toggle(300);
	});
});