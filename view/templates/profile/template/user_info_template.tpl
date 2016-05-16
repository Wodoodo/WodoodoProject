<div class="user_information">
    <div class="user_information_block user_photo">
        <img src="/view/images/users/<?php echo $photo; ?>"/>
    </div>
    <div class="user_information_block user_content">
        <div class="user_block user_place">
            <b><?php echo $city; ?></b><?php echo $fullYears; ?>
        </div>
        <div class="user_block user_status_<?php echo $status; ?>">
            <?php echo $status; ?>
        </div>
        <p class="username"><b><?php echo $firstName; ?></b><br><?php echo $lastName; ?></p>
        <div class="user_full_information">
            <table cellspacing="8">
                <tr><td>Отношения:</td><td><?php echo $relations; ?></td></tr>
                <tr><td colspan="2" class="show_all_information">Показать всю информацию</td></tr>
                <tr><td>День рождения:</td><td><?php echo $birthday; ?></td></tr>
                <tr><td>Телефон:</td><td><?php echo $phone; ?></td></tr>
            </table>
            <table cellspacing="8">
                <tr><td>Twitter:</td><td><a href="https://www.twitter.com/<?php echo $twitter; ?>/" target="_blank"><?php echo $twitter ?></a></td></tr>
                <tr><td>Instagram:</td><td><a href="https://www.instagram.com/<?php echo $instagram; ?>/" target="_blank"><?php echo $instagram; ?></a></td></tr>
                <tr><td>Skype:</td><td><?php echo $skype; ?></td></tr>
            </table>
        </div>
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
                <div class="button send_message">
                    Написать<br>сообщение
                </div>
            <?php } ?>
    </div>
    <div class="buttons_module_min">
        <ul>
            <a href="/friends/myfriends?id=<?php echo $user_id; ?>"><li><p>Друзья</p><p><?php echo $friends_count; ?></p></li></a>
            <a href="/audio/myaudio?id=<?php echo $user_id; ?>"><li><p>Аудио</p><p><?php echo $audio_count; ?></p></li></a>
            <a href=""><li><p>Записи</p><p><?php echo $userPost->num_rows; ?></p></li></a>
            <a href=""><li><p>Лайки</p><p><?php echo $like_count; ?></p></li></a>
        </ul>
    </div>
</div>