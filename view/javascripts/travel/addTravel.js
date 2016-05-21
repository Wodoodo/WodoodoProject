var whomChoice = '';
$(document).ready(function(){
    var userChoice = $('input[name="search_whom"]');
    $(userChoice).change(function(){
        if (this.checked && this.value == 'companion'){
            $('#add_auto').fadeOut();
            $('#add_places').fadeOut();
        } else {
            $('#add_auto').fadeIn();
            $('#add_places').fadeIn();
        }
    });

    $('input[name="from"]').keyup(function(){
        whomChoice = 'from';
        var cityFrom = $(this).val();
        if (cityFrom.length == 0){
            hideHelpBlock();
        } else {
            $.ajax({
                type: "POST",
                url: "/profile/user/getCity",
                data: ({inputValue : cityFrom}),
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
                    appendToBlock(city);
                }
            });
            showHelpBlock(this);
        }
    });

    $('input[name="to"]').keyup(function(){
        whomChoice = 'to';
        var cityTo = $(this).val();
        if (cityTo.length == 0){
            hideHelpBlock();
        } else {
            $.ajax({
                type: "POST",
                url: "/profile/user/getCity",
                data: ({inputValue : cityTo}),
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
                    appendToBlock(city);
                }
            });
            showHelpBlock(this);
        }
    });

    $(document).on('click', '.city', function(e){
        var cityName = $(this).attr('city');
        $('input[name="' + whomChoice + '"]').val(cityName);
        hideHelpBlock();
    });
});

function showHelpBlock(element){
    var helpBlock = $('.help_block');
    var offset = $(element).offset();
    helpBlock.css({
        'width' : $(element).width() + 12,
        'top' : offset.top + $(element).height() + 8,
        'left' : offset.left
    });
    helpBlock.fadeIn();
}

function hideHelpBlock(){
    var helpBlock = $('.help_block');
    helpBlock.fadeOut();
}

function appendToBlock(city){
    var helpBlock = $('.help_block');
    helpBlock.empty();
    helpBlock.append(city);
}