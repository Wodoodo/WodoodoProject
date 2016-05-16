<div class="user_information_min">
    <div class="user_photo_min">
        <img src="/view/images/users/<?php echo $photo; ?>" alt=""/>
    </div>
    <div class="full_information_min">
        <p class="userstatus user_status_<?php echo $status; ?>"><?php echo $status; ?></p>
        <p class="username"><b><?php echo $firstName; ?></b> <?php echo $lastName; ?></p>
        <p class="userplace"><b>Минск,</b> <?php echo $fullYears; ?></p>
        <p class="userabout">Информация о пользователе</p>
        <table>
            <tr><td>Отношения:</td><td><?php echo $relations; ?></td></tr>
            <tr><td colspan="2">Показать информацию о пользователе</td></tr>
            <tr><td>День рождения:</td><td><?php echo $birthday; ?></td></tr>
            <tr><td>Телефон:</td><td><?php echo $phone; ?></td></tr>
            <tr><td>Twitter:</td><td><?php echo $twitter; ?></td></tr>
        </table>
    </div>
    <div class="buttons_action_min">
        <?php 
            if($id != 0){ ?>
                <a href="/profile/user/addToFriends?id=<?php echo $_GET['id']; ?>">
                    <div class="button add_to_friends">
                        <?php echo $btn_text; ?>
                    </div>
                </a>
                <a href="/messages/view">
                    <div class="button send_message">
                        Написать<br>сообщение
                    </div>
                </a>
            <?php } else { ?>
                <div class="button add_to_friends">
                    <?php echo $btn_text; ?>
                </div>
            <?php } ?>
    </div>
    <div class="buttons_module_min">
        <ul>
            <a href="/friends/myfriends?id=<?php echo $user_id; ?>"><li><p>Друзья</p><p><?php echo $friends_count; ?></p></li></a>
            <a href=""><li><p>Фото</p><p>99+</p></li></a>
            <a href="/audio/myaudio?id=<?php echo $user_id; ?>"><li><p>Аудио</p><p><?php echo $audio_count; ?></p></li></a>
            <a href=""><li><p>Записи</p><p><?php echo $userPost->num_rows; ?></p></li></a>
        </ul>
    </div>
</div>