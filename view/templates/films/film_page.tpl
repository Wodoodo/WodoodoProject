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
        <?php if (isset($_SESSION['USER'])) { ?>
        <form action="/services/pfilm/addComment?film=<?php echo $_GET['film']; ?>" class="comment_form" method="post">
            <input type="text" name="id" value="<?php echo $film['id']; ?>" hidden readonly>
            <span class="input_title">Ваша оценка (от 0 до 10):</span><input type="text" name="rate" pattern="(\d|10)" maxlength="2" required title="Введите число от 0 до 10">
            <textarea name="comment_text" maxlength="1200"></textarea>
            <input type="submit" name="add_comment">
        </form>
        <?php } else { ?>
        <span class="not_players">Войдите или зарегистрируйтесь, чтобы оставлять отзывы</span><br><br>
        <?php } ?>
        <div class="all_comments_block">
            <?php for ($i = 0; $i < $feedback->num_rows; $i++) { ?>
            <div class="user_comments_block <?php if (($feedback->rows[$i]['feedback_rate']) < 4) echo 'bad'; if ((($feedback->rows[$i]['feedback_rate']) > 3) && (($feedback->rows[$i]['feedback_rate']) < 7)) echo 'satisfactory'; if ($feedback->rows[$i]['feedback_rate'] > 6) echo 'good'; ?>">
                <p class="user_login"><?php echo $feedback->rows[$i]['user_firstname'] . ' ' . $feedback->rows[$i]['user_lastname']; ?></p>
                <div class="points_block">
                    <p><b>Оценка: </b></p>
                    <p class="points"><?php echo $feedback->rows[$i]['feedback_rate']; ?>/10</p>
                </div>
                <div class="comments_text_block">
                    <p><?php echo $feedback->rows[$i]['feedback_text']; ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>