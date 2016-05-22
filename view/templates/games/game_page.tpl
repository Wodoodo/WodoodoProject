<div class="games_info_wrapper">
    <p class="games_title"><?php echo $game->row['game_name']; ?></p>
    <a href="/services/games" class="back_to_games">← Назад к играм</a>
    <?php MessageShow(); ?>
    <div class="games_info">
        <ul class="const_info_list">
            <li>Жанр</li>
            <li>Дата выхода</li>
            <li>Страна</li>
            <li>Разработчик</li>
            <li>Рейтинг</li>
            <li>Возраст</li>
        </ul>
        <ul class="info_list">
            <li><?php echo $game->row['game_genre']; ?></li>
            <li><?php $date = date('d M Y', strtotime($game->row['game_date'])); echo $date; ?></li>
            <li><?php echo $game->row['game_country']; ?></li>
            <li><?php echo $game->row['game_developer']; ?></li>
            <li style="color: <?php if ($game->row['game_rate'] < 50) echo 'red'; else echo 'green'; ?>"><?php echo $game->row['game_rate']; ?>%</li>
            <li><?php echo $game->row['game_cense']; ?>+</li>
        </ul>
    </div>
    <div class="about_games_block">
        <div class="games_picture_block">
            <img src="/view/images/games/<?php echo $game->row['game_photo']; ?>">
        </div>
        <div class="about_games">
            <div class="description_block">
                <p class="title_block_name" style="margin-top: 0;">Описание</p>
                <p class="text_block"><?php echo $game->row['game_desc']; ?></p>
            </div>
        </div>
    </div>
    <div class="trailer_block">
        <p class="title_block_name">Трейлер к игре</p>
        <iframe width="100%" height="570" src="<?php echo $game->row['game_trailer']; ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="picture_games_block">
        <p class="title_block_name">Кадры из игры</p>
        <?php $gallery = json_decode($game->row['game_gallery']);
        for ($i = 0; $i < count($gallery->images); $i++) { ?>
        <img src="/view/images/games/<?php echo $gallery->images[$i]; ?>">
        <?php } ?>
    </div>
    <div class="users_wrapper">
         <p class="title_block_name">Играют</p>
         <!--<div class="show_all_users_btn">показать всех</div>--><?php echo (!$issetInList) ? '<a href="/services/pgames/addInList?id=' . $_GET['id'] . '" class="im_played">добавить меня в список</a>' : '<a href="/services/pgames/deleteFromList?id=' . $_GET['id'] . '" class="im_played">удалить меня из списка</a>'; ?>
         <div class="users_block">
             <?php if ($players->num_rows == 0) { ?>
             <span class="not_players">Пока еще никто не добавился в список играющих</span>
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
        <form action="/services/pgames/addComment" class="comment_form" method="post">
            <input type="text" name="id" value="<?php echo $_GET['id']; ?>" hidden readonly>
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