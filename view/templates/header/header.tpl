<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/view/javascripts/jquery.ajaxupload.js"></script>
    <?php
        if (isset($pageStyles)){
            foreach ($pageStyles as $style){
                    if (file_exists(STYLES_DIRECTORY . $style . '.css')){
                        if (($devicePrefix == '') or (($drevicePrefix != '_mobile') && ($style != 'user_posts')))
                        echo '<link rel="stylesheet" href="/view/stylesheets/' . $style . '.css">';
                    }
                    if (($devicePrefix == '_mobile') && (file_exists(STYLES_DIRECTORY . $style . $devicePrefix . '.css'))){
                        echo '<link rel="stylesheet" href="/view/stylesheets/' . $style . $devicePrefix . '.css">';
                    }
                }
            }
    ?>
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
<div class="horizontal_menu">
    <script type="text/javascript" src="/view/javascripts/header/left_menu.js"></script>
    <div class="horizontal_menu_wrapper">
        <ul class="horizontal_menu_tabs">
            <a><li id="hamburger_menu"><img src="/view/images/hamburg_btn.png"></li></a>
            <a href="/"><li><img src="/view/images/login.png"></li></a>
            <a href="/"><li><p>Профиль</p></li></a>
            <a href="/messages/dialogues"><li><p>Сообщения</p></li></a>
            <a href="/friends/myfriends"><li class="<?php echo ($userIncomingRequests->num_rows <= 0) ? '' : 'isset'; ?>" ><p>Друзья</p></li></a>
            <a href="/audio/myaudio"><li><p>Аудиозаписи</p></li></a>
            <a href="/settings/mysettings"><li><p>Настройки</p></li></a>
        </ul>
        <div class="left_menu">
            <?php if(isset($_SESSION['USER'])){ ?>
                <p><?php echo $firstName; ?> <?php echo $lastName; ?></p>
            <?php } ?>
            <ul>
                <p class="left_menu_title">Сервисы</p>
                <a href="/services/seans"><li>Кино</li></a>
                <a href="/services/music"><li>Музыка</li></a>
                <a href="/services/travel"><li>Поиск попутчиков</li></a>
                <a href="/services/games"><li>Игры</li></a>
            </ul>
            <?php if(isset($_SESSION['USER'])){ ?>
                <ul>
                    <p class="left_menu_title">Основное</p>
                    <a href="/"><li>Профиль</li></a>
                    <a href="/messages/dialogues"><li>Сообщения</li></a>
                    <a href="/friends/myfriends"><li>Друзья</li></a>
                    <a href="/audio/myaudio"><li>Аудиозаписи</li></a>
                    <a href="/settings/mysettings"><li>Настройки</li></a>
                    <a href="/profile/sign/userExit"><li>Выход</li></a>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>