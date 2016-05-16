<script type="text/javascript" src="/view/javascripts/audio/audioPlayer.js"></script>
<div class="user_audio_wrapper">
	<p class="block_title">Аудиозаписи</p>
	<div class="search_audio">
		<form method="POST" action="">
			<input type="text" name="search_audio" placeholder="Введите название песни или исполнителя..." maxlength="100" required>
		</form>
    </div>
    <?php 
    	if($songList->num_rows <= 0){
    		echo '<p class="have_post">Записей нет</p>';
    	} else { ?>
    		<div class="audio_player_block">
		    	<div class="album_photo">
		    		<img src="/view/images/audio/acdc.jpg">
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
		    <div class="user_audio_list_block">
		    <?php for($i = 0; $i < $songList->num_rows; $i++){ 
		    	$getid3 = new getID3();
			  	$getid3->encoding = 'UTF-8';
			  	$getid3->Analyze($_SERVER['DOCUMENT_ROOT'] . '/view/audio/' . $songList->rows[$i]['song_path']);
			?>
				<div class="user_audio_block" path="<?php echo $getid3->info['filenamepath']; ?>">
					<div class="user_audio_photo_block">
						<img src="/view/images/audio/<?php echo $songList->rows[$i]['song_picture']; ?>">
					</div>
					<div class="user_audio_info">
						<p class="user_audio_performer_name"><b><?php echo (strcmp($getid3->info['fileformat'], "wav") == 0) ? $getid3->info['tags']['riff']['artist'][0] :  $getid3->info['tags']['id3v1']['artist'][0]; ?></b></p>
						<p class="user_audio_track_name"><?php echo (strcmp($getid3->info['fileformat'], "wav") == 0) ? $getid3->info['tags']['riff']['title'][0] :  $getid3->info['tags']['id3v1']['title'][0]; ?></p>
						<p class="user_audio_time"><?php echo $getid3->info['playtime_string']; ?></p>
					</div>
					<div class="audio_play_btn" songnumber="<?php echo $i; ?>">
						<img src="/view/images/play_mini.png" class="user_play_button">
					</div>
				</div>
		    <?php }	?>
		    </div>
    	<?php } ?>
</div>