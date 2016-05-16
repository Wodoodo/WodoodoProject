var audio = new Audio();
$(document).ready(function(){
	var musicIsPlaying = false;
	var timeIsDrag = false;
	var songNumber = 0;
	var prevSongNum = 0;

	audio.preload = false;

	firstLoad(audio);

	$(audio).bind('timeupdate', updateAudio);
	var myCookie = getCookie("AUDIO_VOLUME");


	$('#play_music').click(function(){
		playMyEbanyMusic(audio);
	});

	function playMyEbanyMusic(audio){
		if (!musicIsPlaying){
			audio.currentTime = (audio.currentTime) ? audio.currentTime : 0;
			audio.play();
			if (myCookie != undefined)
				audio.volume = getCookie("AUDIO_VOLUME");
			else
				audio.volume = 1;
			$('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
			musicIsPlaying = true;
			$('.play_button_image').attr('src', '/view/images/pause.png');
			$('.user_play_button').eq(songNumber).attr('src', '/view/images/pause_mini.png');
		} else {
			audio.pause();
			$('.play_button_image').attr('src', '/view/images/play.png');
			$('.user_play_button').eq(songNumber).attr('src', '/view/images/play_mini.png');
			musicIsPlaying = false;
		}
		$('.user_play_button').eq(songNumber-1).attr('src', '/view/images/play_mini.png');
		$('.user_audio_list_block > .user_audio_block').eq(songNumber-1).css({
			'background-color': '#fff',
			'border-radius': 0
		});
		$('.user_audio_list_block > .user_audio_block').eq(songNumber).css({
			'background-color': 'rgba(0, 183, 220, 0.06)',
			'border-radius': 10 + 'px'
		});;
	}

	$('#next_button').click(function(){
		prevSongNum = songNumber;
		if (songNumber < $('.user_audio_block').length - 1){
			songNumber++;
		} else {
			songNumber = 0;
		}
		audio.pause();
		audio.src = nextMusic(prevSongNum, songNumber, true);
		audio.addEventListener('loadedmetadata', function() {
		    //console.log("Playing " + audio.src + ", for: " + audio.duration + "seconds.");
		    musicIsPlaying = false;
			playMyEbanyMusic(audio); 
			//nextMusic(songNumber-1, songNumber);
		    $('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
		});
	});

	$('#prev_button').click(function(){
		prevSongNum = songNumber;
		if (songNumber != 0){
			songNumber--;
		} else {
			songNumber = $('.user_audio_block').length - 1;
		}
		audio.pause();
		audio.src = nextMusic(prevSongNum, songNumber, false);
		audio.addEventListener('loadedmetadata', function() {
		    //console.log("Playing " + audio.src + ", for: " + audio.duration + "seconds.");
		    musicIsPlaying = false;
			playMyEbanyMusic(audio); 
			//nextMusic(prevSongNum, songNumber);
		    $('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
		});
	});

	function updateAudio(){
		var prefix = '';
		var fullWidthTrack = $('.time_bar').width();
		(((audio.currentTime % 60).toFixed(0) < 10) && ((audio.currentTime % 60).toFixed(0) > 0)) ? prefix = '0' : prefix = '';
		(((audio.currentTime) % 60).toFixed(0) == 0) ? seconds = '00' : seconds = (audio.currentTime % 60).toFixed(0);
		var audioCurrentTime = Math.floor((audio.currentTime) / 60) + ':' + prefix + seconds;
		$('.past_track_time').text(audioCurrentTime);
		if (!timeIsDrag) {
			var left = ((100 * audio.currentTime) / audio.duration) - (900 / fullWidthTrack);
			$('.time_pointer').css({
				left: left + "%"
			});
		}
		if (audio.duration == audio.currentTime){
			if (songNumber < $('.user_audio_block').length - 1){
				songNumber++;
			} else {
				songNumber = 0;
			}
			audio.src = nextMusic(prevSongNum, songNumber, true);
			audio.addEventListener('loadedmetadata', function() {
			    //console.log("Playing " + audio.src + ", for: " + audio.duration + "seconds.");
			    audio.play(); 
			    $('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
			});
		}
	}

	$('.time_bar').mousedown(function(e){
		var fullWidthTrack = $('.time_bar').width();
		if ((e.offsetX > 7) && (e.offsetX < (fullWidthTrack + 7))){
			var newTime = ((e.offsetX)*100)/fullWidthTrack;
			$('.time_pointer').css({'left': newTime + '%'});
			newTime = (audio.duration * newTime) / 100;
			audio.currentTime = newTime;
		}
	});


	$('.audio_play_btn').click(function(){
		prevSongNum = songNumber;
		songNumber = $(this).attr('songnumber');
		if(prevSongNum == songNumber)
		{
			if (!musicIsPlaying){
				audio.currentTime = (audio.currentTime) ? audio.currentTime : 0;
				audio.play();
				if (myCookie != undefined)
					audio.volume = getCookie("AUDIO_VOLUME");
				else
					audio.volume = 1;
				$('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
				musicIsPlaying = true;
				$('.user_play_button').eq(songNumber).attr('src', '/view/images/pause_mini.png');
				$('.play_button_image').attr('src', '/view/images/pause.png');
			} else {
				audio.pause();
				$('.play_button_image').attr('src', '/view/images/play.png');
				$('.user_play_button').eq(songNumber).attr('src', '/view/images/play_mini.png');
				musicIsPlaying = false;
			}
			nextMusic(-1, songNumber, true);
		} else {
			if (!musicIsPlaying){
				audio.src = nextMusic(prevSongNum, songNumber, true);
				audio.addEventListener('loadedmetadata', function() {
				    //console.log("Playing " + audio.src + ", for: " + audio.duration + "seconds.");
				    musicIsPlaying = false;
					playMyEbanyMusic(audio); 
				    $('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
				});
				$('.user_play_button').eq(prevSongNum).attr('src', '/view/images/play_mini.png');
				$('.user_play_button').eq(songNumber).attr('src', '/view/images/pause_mini.png');
				$('.play_button_image').attr('src', '/view/images/pause.png');
			} else {
				audio.pause();
				audio.src = nextMusic(prevSongNum, songNumber, true);
				audio.addEventListener('loadedmetadata', function() {
				    //console.log("Playing " + audio.src + ", for: " + audio.duration + "seconds.");
				    musicIsPlaying = false;
					playMyEbanyMusic(audio); 
				    $('p.all_track_time').text(Math.floor(audio.duration / 60) + ':' + (audio.duration % 60).toFixed(0));
				});
				$('.user_play_button').eq(prevSongNum).attr('src', '/view/images/play_mini.png');
				$('.user_play_button').eq(songNumber).attr('src', '/view/images/pause_mini.png');
				$('.play_button_image').attr('src', '/view/images/pause.png');
			}
			prevSongNum = songNumber;
		}
	});

	/*$('.volume_bar').mousedown(function(e){
		var fullVolumeTrack = $('.volume_bar').width();
		if ((e.offsetX) && (e.offsetX < (fullVolumeTrack + 7))){
			var newVolume = ((e.offsetX)*100)/fullVolumeTrack;
			$('.volume_pointer').css({'left': newVolume - 8 + '%'});
			audio.volume = (newVolume)/100;
			console.log((newVolume)/100);
			var date = new Date(new Date().getTime() + 60 * 1000);
			$('.volume_level').text(Math.floor(newVolume) + '%');
			document.cookie = "AUDIO_VOLUME=" + (newVolume)/100 + "; path=/; expires=" + date.toUTCString();
		}
	});*/

	var volumeBar = document.getElementById('volume_bar');
	var volumePointer = volumeBar.children[0];
	var newVolume;

	volumePointer.onmousedown = function(e){
		timeIsDrag = true;
		var thumbsCoords = getCoords(volumePointer);
		var shiftX = e.pageX - thumbsCoords.left;

		var sliderCoords = getCoords(volumeBar);

		document.onmousemove = function(e){
			newVolume = e.pageX - shiftX - sliderCoords.left;
			if (newVolume < 0){
				newVolume = 0;
			}
			var rightEdge = volumeBar.offsetWidth;
			if (newVolume > rightEdge){
				newVolume = rightEdge;
			}
			volumePointer.style.left = newVolume - 800/volumeBar.offsetWidth + '%';
			changeVolume(newVolume, audio);
		}

		document.onmouseup = function(){
			document.onmousemove = document.onmouseup = null;
			timeIsDrag = false;
		};

		return false;
	};

	volumePointer.ondragstart = function(){
		return false;
	};

	var timeBar = document.getElementById('time_bar');
	var timePointer = timeBar.children[0];
	var newLeft;

	timePointer.onmousedown = function(e){
		timeIsDrag = true;
		var thumbsCoords = getCoords(timePointer);
		var shiftX = e.pageX - thumbsCoords.left;

		var sliderCoords = getCoords(timeBar);

		document.onmousemove = function(e){
			newLeft = e.pageX - shiftX - sliderCoords.left;
			if (newLeft < 0){
				newLeft = 0;
			}
			var rightEdge = timeBar.offsetWidth - timePointer.offsetWidth/2;
			if (newLeft > rightEdge){
				newLeft = rightEdge;
			}
			timePointer.style.left = newLeft + 'px';
		}

		document.onmouseup = function(){
			document.onmousemove = document.onmouseup = null;
			changeMusicTime(newLeft, audio);
			timeIsDrag = false;
		};

		return false;
	};

	timePointer.ondragstart = function(){
		return false;
	};

	function getCoords(elem){
		var box = elem.getBoundingClientRect();

		return {
			top: box.top + pageYOffset,
			left: box.left + pageXOffset
		};
	}
});

function changeMusicTime(newTime, audio){
	var time = (audio.duration * newTime * 100) / $('.time_bar').width();
	audio.currentTime = (audio.duration * ((newTime * 100) / $('.time_bar').width())) / 100;
}

function changeVolume(newVolume, audio){
	audio.volume = (newVolume)/100;
	var date = new Date(new Date().getTime() + 60 * 1000);
	$('.volume_level').text(newVolume + '%');
	document.cookie = "AUDIO_VOLUME=" + (newVolume)/100 + "; path=/; expires=" + date.toUTCString();
}

function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

function firstLoad(audio){
	var firstItem = $('.user_audio_list_block > .user_audio_block').first();
	var musicPath = firstItem.attr('path');
	$('.player_audio_info > .user_audio_performer_name > b').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_performer_name > b').first().text());
	$('.player_audio_info > .user_audio_track_name').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_track_name').first().text());
	$('p.all_track_time').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_time').first().text());
	$('.album_photo > img').attr('src', $('.user_audio_photo_block > img').first().attr('src'));
	musicPath = musicPath.replace('/hosting/home/vsemhorosho/wodoodo/', '/');
	audio.src = musicPath;
}

function nextMusic(prevSongIndex, soundIndex, flag){
	var prevItem = $('.user_audio_list_block > .user_audio_block').eq(prevSongIndex);
	var nextItem = $('.user_audio_list_block > .user_audio_block').eq(soundIndex);
	var itemAttr = nextItem.attr('path');
	prevItem.css({
		'background-color': '#fff',
		'border-radius': 0
	});
	nextItem.css({
		'background-color': 'rgba(0, 183, 220, 0.06)',
		'border-radius': 10 + 'px'
	});
	if(!flag){
		$('.user_play_button').eq(prevSongIndex).attr('src', '/view/images/play_mini.png');
	}
	$('.player_audio_info > .user_audio_performer_name > b').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_performer_name > b').eq(soundIndex).text());
	$('.player_audio_info > .user_audio_track_name').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_track_name').eq(soundIndex).text());
	$('p.all_track_time').text($('.user_audio_list_block > .user_audio_block > .user_audio_info > .user_audio_time').eq(soundIndex).text());
	$('.album_photo > img').attr('src', $('.user_audio_photo_block > img').eq(soundIndex).attr('src'));
	itemAttr = itemAttr.replace('/hosting/home/vsemhorosho/wodoodo/', '/');
	return itemAttr;
}