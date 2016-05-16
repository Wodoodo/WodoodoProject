$(document).ready(function(){
    var menuBtn = $('#hamburger_menu');
    var menuLeft = $('.left_menu');
    var menuIsOpen = false;
    var menuWidth = 0;
    var menuHeight = $(document).height() - 57;
    var image = document.getElementById('hamburger_menu').getElementsByTagName('img')[0];
    menuLeft.css({'height':menuHeight});
    menuBtn.click(function(){
        if (!menuIsOpen){
            menuWidth = 270;
            menuHeight = $(document).height();
            menuBtn.css({'background-color':'#1a77b0'});
            menuLeft.css({'display':'inline-block'});
            menuLeft.animate({
                'width':menuWidth
            }, function(){
                image.src = "http://wodoodo.vsemhorosho.by/view/images/close.png";
            });
            menuIsOpen = true;
        } else {
            menuWidth = 0;
            menuHeight = 0;
            menuLeft.animate({
                'width':menuWidth
            }, function(){
                image.src = "http://wodoodo.vsemhorosho.by/view/images/hamburg_btn.png";
                menuBtn.css({'background-color':'transparent'});
                menuLeft.css({'display':'none'});
            });
            menuIsOpen = false;
        }
    });
});