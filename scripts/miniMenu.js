var isOpen = false;
$(document).mouseup(function(event){
	if (event.target.className != 'service_button'){
		if ($(".services").prop('checked')){
			if ($(event.target).closest(".menu_services").length) return;
			$(".menu_services").css('height', '0px');
			event.stopPropafation;
			$(".services").prop('checked', false);
		}
	}
});