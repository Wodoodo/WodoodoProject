<script type="text/javascript" src="/view/javascripts/jquerysession.js"></script>
<script type="text/javascript" src="/view/javascripts/audio/audioPlayer.js"></script>
<script type="text/javascript" src="/view/javascripts/music/addNewMusic.js"></script>
<script type="text/javascript" src="/view/javascripts/music/searchGenres.js"></script>
<div class="music_wrapper">
    <div class="audio_player_block">
    <div class="album_photo">
        <img src="/view/images/audio/nophoto.jpg">
    </div>
    <div class="player">
        <div class="player_audio_info">
            <p class="user_audio_performer_name"><b>David Bowie</b></p>
            <p class="user_audio_track_name">Cat People (Putting Out the Fire)</p>
        </div>
        <div class="time_bar" id="time_bar">
            <div class="time_pointer" id="time_pointer"></div>
        </div>
        <div class="time">
            <p class="past_track_time">0:00</p>
            /
            <p class="all_track_time">4:10</p>
        </div>
        <div class="volume_bar" id="volume_bar">
            <?php if (isset($_COOKIE['AUDIO_VOLUME'])) { ?>
            <div class="volume_pointer" id="volume_pointer" style="left: <?php echo (($_COOKIE['AUDIO_VOLUME'] * 100) > 0) ? (($_COOKIE['AUDIO_VOLUME']*100)-14) : '0.1' ?>%"></div>
            <?php } else { ?>
            <div class="volume_pointer" id="volume_pointer" style="left: 50%"></div>
            <?php } ?>
        </div>
        <div class="volume_level"><?php echo $_COOKIE['AUDIO_VOLUME'] * 100; ?>%</div>
        <div class="player_btn">
            <div class="prev_btn" id="prev_button">
                <img src="/view/images/prev_music.png">
            </div>
            <div class="play_btn" id="play_music" data-sound="http://wodoodo.vsemhorosho.by/view/audio/rich_bitch.mp3">
                <img src="/view/images/play.png" class="play_button_image">
            </div>
            <div class="next_btn" id="next_button">
                <img src="/view/images/next_music.png">
            </div>
        </div>
    </div>
</div>
	<div class="genre_menu">
        <button class="add_music">Добавить песню</button>
		<p class="menu_title">ЖАНРЫ</p>
        <input type="text" name="genre_search" maxlength="50" placeholder="Поиск по жанрам..." class="genre_search">
        <a href="/services/music">Все жанры</a>
        <div class="genre_list">
        <?php for ($i = 0; $i < $genreList->num_rows; $i++) { ?>
        <a href="/services/music?genre_id=<?php echo $genreList->rows[$i]['id']; ?>"><?php echo $genreList->rows[$i]['genre_name']; ?></a>
        <?php } ?>
        </div>
	</div>
	<div class="right_wrapper">
        <?php if($songList->rows[0]['genre_id'] == null){ ?>
            <p class="no_audio">Аудиозаписи данного жанра отсутствуют</p>
        <?php } else { ?>
            <div class="user_audio_list_block">
            <?php
            for($i = 0; $i < $songList->num_rows; $i++){ 
                $getid3 = new getID3();
                $getid3->encoding = 'UTF-8';
                $getid3->Analyze($_SERVER['DOCUMENT_ROOT'] . '/view/audio/' . $songList->rows[$i]['song_path']);
                //var_dump($getid3->info['tags']['id3v1']['title']);
                //var_dump($getid3->info['tags']['id3v2']['title']);
            ?>
                <div class="user_audio_block" path="<?php echo $getid3->info['filenamepath']; ?>">
                    <div class="user_audio_photo_block">
                        <img src="/view/images/audio/<?php echo $songList->rows[$i]['song_picture']; ?>">
                    </div>
                    <div class="user_audio_info">
                        <p class="user_audio_performer_name"><b><?php echo $songList->rows[$i]['song_author']; ?></b></p>
                        <p class="user_audio_track_name"><?php echo $songList->rows[$i]['song_name']; ?></p>
                        <p class="user_audio_time"><?php echo $getid3->info['playtime_string']; ?></p>
                    </div>
                    <div class="audio_play_btn" songnumber="<?php echo $i; ?>" title="Воспроизвести">
                        <img src="/view/images/play_mini.png" class="user_play_button">
                    </div>
                    <a class="<?php echo ($songList->rows[$i]['issetInUser']) ? 'audio_delete_btn' : 'audio_add_btn'; ?>" songnumber="<?php echo $i; ?>" title="<?php echo ($songList->rows[$i]['issetInUser']) ? 'Удалить' : 'Добавить'; ?>" href="<?php echo ($songList->rows[$i]['issetInUser']) ? '/services/music/deleteMusic?music_id=' . $songList->rows[$i]['id'] . '&return_page=/services/music' : '/services/music/addMusic?music_id=' . $songList->rows[$i]['id'] . '&return_page=/services/music'; ?>">
                        <img src="/view/images/<?php echo ($songList->rows[$i]['issetInUser']) ? 'delete_music.png' : 'add_music.png'; ?>" class="<?php echo ($songList->rows[$i]['issetInUser']) ? 'user_delete_btn' : 'user_add_btn'; ?>">
                    </a>
                </div>
            <?php } ?>
            </div>
        <?php } ?>
	</div>
</div>
<div class="add_music_popup">
    <div class="add_music_window">
        <p class="popup_title">Выберите музыку формата .mp3</p>
        <button class="add_new_music" id="add_new_music_button">Выберите файл для загрузки</button>
        <p class="state_upload_music"></p>
        <p class="result_upload_music"></p>
    </div>
</div>