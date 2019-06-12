// //var songs = ["Track 01.mp3", "Track 02.mp3", "Track 03.mp3", "Track 04.mp3", "Track 05.mp3", "Track 06.mp3", "Track 07.mp3", "Track 08.mp3", "Track 09.mp3", "Track 10.mp3", "Track 11.wav"];
// var songs = [];
// //var file = this.files[0];

// var songTitle = document.getElementById('songTitle');
// var songSlider = document.getElementById('songSlider');
// var currentTime = document.getElementById('currentTime');
// var duration = document.getElementById('duration');
// var volumeSlider = document.getElementById('volumeSlider');
// var nextSongTitle = document.getElementById('nextSongTitle');

// var song = new Audio();
// var currentSong = 0;

// window.onload = loadSong;
// //window.onload = prep;

// function prep(name){
// 	songs.push(name);
	
// }

// function add(name){
// 	currentSong = 0;
// 	songs.push(name);
// 	loadSong();
// }

// function loadSong () {
// 	call(currentSong);
// 	song.src = "Player/" + songs[currentSong];
// 	songTitle.textContent = songs[currentSong];
// 	nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs[currentSong + 1 % songs.length];
// 	song.playbackRate = 1;
// 	song.volume = volumeSlider.value;
// 	song.play();
// 	setTimeout(showDuration, 1000);
// }

// setInterval(updateSongSlider, 1000);

// function updateSongSlider () {
// 	var c = Math.round(song.currentTime);
// 	songSlider.value = c;
// 	currentTime.textContent = convertTime(c);
// 	if(song.ended){
// 		next();
// 	}
// }

// function convertTime (secs) {
// 	var min = Math.floor(secs/60);
// 	var sec = secs % 60;
// 	min = (min < 10) ? "0" + min : min;
// 	sec = (sec < 10) ? "0" + sec : sec;
// 	return (min + ":" + sec);
// }

// function showDuration () {
// 	var d = Math.floor(song.duration);
// 	songSlider.setAttribute("max", d);
// 	duration.textContent = convertTime(d);
// }

// function playOrPauseSong (img) {
// 	song.playbackRate = 1;
// 	if(song.paused){
// 		song.play();
// 		img.src = "images/pause.png";
// 	}else{
// 		song.pause();
// 		img.src = "images/play.png";
// 	}
// }

// function next(){
// 	//call(currentSong);
// 	currentSong++;
// 	currentSong = (currentSong > songs.length-1) ? 0 : currentSong;
// 	//currentSong = currentSong + 1 % songs.length;
// 	loadSong();
// }

// function previous () {
// 	//call(currentSong);
// 	currentSong--;
// 	currentSong = (currentSong < 0) ? songs.length - 1 : currentSong;
// 	loadSong();
// }

// function seekSong () {
// 	song.currentTime = songSlider.value;
// 	currentTime.textContent = convertTime(song.currentTime);
// }

// function adjustVolume () {
// 	song.volume = volumeSlider.value;
// }

// function increasePlaybackRate () {
// 	songs.playbackRate += 0.5;
// }

// function decreasePlaybackRate () {
// 	songs.playbackRate -= 0.5;
// }

// function select (x) {
// 	//call(currentSong);
// 	currentSong = x;
// 	loadSong();
// }

// function call(xy){
// 	var y = xy;
// 	// $.ajax({  
// 	// 	type: 'POST',  
// 	// 	url: 'test.php', 
// 	// 	data: { csong: xy },
// 	// 	success: function(response) {
// 	// 		content.html(response);
// 	// 	}
// 	// });
// 	var obj, dbParam, xmlhttp, myObj, x, txt = "";
// 	obj = { "name":"Ravin", "number":currentSong };
// 	dbParam = JSON.stringify(obj);

// 	xmlhttp = new XMLHttpRequest();
// 	// xmlhttp.onreadystatechange = function() {
//   	// 	if (this.readyState == 4 && this.status == 200) {
//     // 		myObj = JSON.parse(this.responseText);
//     // 		for (x in myObj) {
//     //   			txt += myObj[x].name + "<br>";
//     // 		}
//     // 		document.getElementById("songTitle").innerHTML = txt;
//  	// 	}
// 	// };

// 	xmlhttp = new XMLHttpRequest();
// 	xmlhttp.open("POST", "player.php", true);
// 	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 	xmlhttp.send("x=" + dbParam);
// 	console.log("x=" + dbParam);

// }

// // var obj, dbParam, xmlhttp, myObj, x, txt = "";
// 	// obj = { "name":"Ravin", "number":currentSong };
// 	// dbParam = JSON.stringify(obj);

// 	// xmlhttp = new XMLHttpRequest();
// 	// xmlhttp.open("POST", "test.php", true);
// 	// xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 	// xmlhttp.send("x=" + dbParam);