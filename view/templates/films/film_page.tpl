<div class="film_info_wrapper">
    <p class="film_title"><?php echo $film['name']; ?></p>
    <a href="/services/seans" class="back_to_films">← Назад к фильмам</a>
    <?php MessageShow(); ?>
    <div class="film_info">
        <ul class="const_info_list">
            <li>Жанр</li>
            <li>Год</li>
            <li>Страна</li>
            <li>Время</li>
            <li>Рейтинг</li>
            <li>Возраст</li>
        </ul>
        <ul class="info_list">
            <li><?php echo (isset($film['genre'])) ? $film['genre'] : "-" ?></li>
            <li><?php echo (isset($film['year'])) ? $film['year'] : "-" ?></li>
            <li><?php echo (isset($film['author'])) ? $film['author'] : "-" ?></li>
            <li><?php echo (isset($film['duration'])) ? $film['duration'] : "-" ?></li>
            <li style="color: <?php echo $film['color']; ?>;"><?php echo (isset($film['rating'])) ? $film['rating'] . '%' : '0%' ?></li>
            <li><?php echo (isset($film['age'])) ? $film['age'] : "0+" ?></li>
        </ul>
    </div>
    <div class="about_film_block">
        <div class="film_picture_block">
            <img src="<?php echo $film['photo']; ?>">
        </div>
        <div class="about_film">
            <div class="description_block">
                <p class="title_block_name" style="margin-top: 0;">Описание</p>
                <p class="text_block"><?php echo $film['text']; ?></p>
            </div>
            <?php if(isset($film['role'])){ ?>
                <div class="role_block">
                    <p class="title_block_name">В ролях</p>
                    <p class="text_block"><?php echo $film['role']; ?></p>
                </div>
            <?php } ?>
            <?php if(isset($film['producer'])){ ?>
                <div class="producer_block">
                    <p class="title_block_name">Режиссер</p>
                    <p class="text_block"><?php echo $film['producer']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if(isset($film['video'])){ ?>
        <div class="trailer_block">
            <p class="title_block_name">Трейлер к фильму</p>
            <video controls poster="<?php echo $film['poster']; ?>">
                <source src="<?php echo $film['video']; ?>">
            </video>
        </div>
    <?php } ?>
    <?php if(isset($film[0]['photoList'])){ ?>
        <div class="picture_film_block">
            <p class="title_block_name">Кадры фильма</p>
            <?php for($i = 0; $i < 3; $i++){ ?>
                <img src="<?php echo $film[$i]['photoList']; ?>">
            <?php } ?>
        </div>
    <?php } ?>
    <!--<div class="info_ticket_block">
         <p class="title_block_name">Купить билеты</p>
    </div>-->
    <div class="users_wrapper">
         <p class="title_block_name">Смотрят</p>
         <!--<div class="show_all_users_btn">показать всех</div>--><?php echo (!$issetInList) ? '<a href="/services/pfilm/addInList?film=' . $_GET['film'] . '" class="im_played">добавить меня в список</a>' : '<a href="/services/pfilm/deleteFromList?film=' . $_GET['film'] . '" class="im_played">удалить меня из списка</a>'; ?>
         <div class="users_block">
             <?php if ($players->num_rows == 0) { ?>
             <span class="not_players">Пока еще никто не добавился в список смотрящих</span>
             <?php } else { ?>
             <?php for ($i = 0; $i < $players->num_rows; $i++) { ?>
             <div class="user_block">
                 <div class="user_photo_block">
                     <a href="/profile/user?id=<?php echo $players->rows[$i]['user_id']; ?>"><img src="/view/images/users/<?php echo $players->rows[$i]['user_photo']; ?>" alt=""></a>
                 </div>
                 <a href="/profile/user?id=<?php echo $players->rows[$i]['user_id']; ?>"><p class="user_name"><b><?php echo $players->rows[$i]['user_firstname']; ?></b><br/><?php echo $players->rows[$i]['user_lastname']; ?></p></a>
             </div>
             <?php } ?>
             <?php } ?>
         </div>
    </div>
    <div class="comments_wrapper">
        <p class="title_block_name">Отзывы</p>
        <div class="all_comments_block">
            <div class="user_comments_block good">
                <p class="user_login">Александр Бегун</p>
                <div class="points_block">
                     <p><b>Оценка: </b></p>
                     <p class="points">8/10</p>
                </div>
                <div class="comments_text_block">
                    <p>Жанр сказок на современный лад является достаточно рискованным в наше время. С одной стороны, нужно отдать дань уважения первоисточнику. С другой, сохранить какую никакую, но индивидуальность. С третьей, разбавить историю экшеном и юмором, дабы фильм подходил под формат качественного блокбастера. Потому, риск не оправдать ожидания достаточно велик. «Белоснежка и охотник» 2012-го года сама по себе является не самым плохим примером переноса сказки на экран. Да фильм страдал от сумбурного и порой скучного повествования, но тем не менее имел при себе много элементов, которые вытягивали фильм. Заработав неплохую кассу, Universal имела все шансы сделать новую фэнтези-франшизу. Однако, если учитывать то, что у первой части был первоисточник, которому хоть и не точно, но порой следовали, то придумать самостоятельную историю для второй части было бы довольно проблематично. Потому решение о производстве приквела было наиболее логичным вариантом. Плюс убрав из сюжета саму Белоснежку, был шанс сконцентрироваться на Охотнике.</p>
                </div>
            </div>
            <div class="user_comments_block satisfactory">
                <p class="user_login">Александр Бегун</p>
                <div class="points_block">
                     <p><b>Оценка: </b></p>
                     <p class="points">5/10</p>
                </div>
                <div class="comments_text_block">
                    <p>Жанр сказок на современный лад является достаточно рискованным в наше время. С одной стороны, нужно отдать дань уважения первоисточнику. С другой, сохранить какую никакую, но индивидуальность. С третьей, разбавить историю экшеном и юмором, дабы фильм подходил под формат качественного блокбастера. Потому, риск не оправдать ожидания достаточно велик. «Белоснежка и охотник» 2012-го года сама по себе является не самым плохим примером переноса сказки на экран. </p>
                </div>
            </div>
            <div class="user_comments_block bad">
                <p class="user_login">Александр Бегун</p>
                <div class="points_block">
                     <p><b>Оценка: </b></p>
                     <p class="points">3/10</p>
                </div>
                <div class="comments_text_block">
                    <p>Жанр сказок на современный лад является достаточно рискованным в наше время. С одной стороны, нужно отдать дань уважения первоисточнику. С другой, сохранить какую никакую, но индивидуальность. С третьей, разбавить историю экшеном и юмором, дабы фильм подходил под формат качественного блокбастера. Потому, риск не оправдать ожидания достаточно велик. «Белоснежка и охотник» 2012-го года сама по себе является не самым плохим примером переноса сказки на экран. Да фильм страдал от сумбурного и порой скучного повествования, но тем не менее имел при себе много элементов, которые вытягивали фильм. Заработав неплохую кассу, Universal имела все шансы сделать новую фэнтези-франшизу. Однако, если учитывать то, что у первой части был первоисточник, которому хоть и не точно, но порой следовали, то придумать самостоятельную историю для второй части было бы довольно проблематично. Потому решение о производстве приквела было наиболее логичным вариантом. Плюс убрав из сюжета саму Белоснежку, был шанс сконцентрироваться на Охотнике. Жанр сказок на современный лад является достаточно рискованным в наше время. С одной стороны, нужно отдать дань уважения первоисточнику. С другой, сохранить какую никакую, но индивидуальность. С третьей, разбавить историю экшеном и юмором, дабы фильм подходил под формат качественного блокбастера. Потому, риск не оправдать ожидания достаточно велик. «Белоснежка и охотник» 2012-го года сама по себе является не самым плохим примером переноса сказки на экран. Да фильм страдал от сумбурного и порой скучного повествования, но тем не менее имел при себе много элементов, которые вытягивали фильм. Заработав неплохую кассу, Universal имела все шансы сделать новую фэнтези-франшизу. Однако, если учитывать то, что у первой части был первоисточник, которому хоть и не точно, но порой следовали, то придумать самостоятельную историю для второй части было бы довольно проблематично. Потому решение о производстве приквела было наиболее логичным вариантом. Плюс убрав из сюжета саму Белоснежку, был шанс сконцентрироваться на Охотнике.</p>
                </div>
            </div>
        </div>
    </div>
</div>