<!DOCTYPE html>
<html>
	<head>
		<title>Listener 1.0</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/png" href="images/logo.png"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</head>
	<body>
        <?php include "header.php"; ?>
        <div>
            <div class="audio-player-cont">
                <div class="player">
                <span class="badge badge-warning"><div id="songTitle" class="song-title">Song title goes here</div></span><br>
                <br>
                        <input id="songSlider" class="song-slider" type="range" min="0" step="1" onchange="seekSong()" />
                    <div>
                        <div id="currentTime" class="current-time">00:00</div>
                        <div id="duration" class="duration">00:00</div>
                    </div>
                    <div class="controllers">
                        <img class = "ic" src="images/previous.png" width="30px" onclick="previous();" />
                        <img class = "ic" src="images/backward.png" width="30px" onclick="decreasePlaybackRate();" />
                        <img class = "ic" src="images/play.png" width="40px" onclick="playOrPauseSong(this);" />
                        <img class = "ic" src="images/forward.png" width="30px" onclick="increasePlaybackRate();" />
                        <img class = "ic" src="images/next.png" width="30px" onclick="next();" />
                    </div>
                        <br>
                    <div class="vol">
                        <table width="100%">
                            <tr><td>
                        <img class = "ic" src="images/volume-down.png" width="15px" />
                        </td><td class="volcel">
                        <input id="volumeSlider" class="volume-slider" type="range" min="0" max="1" step="0.01" 
    onchange="adjustVolume()" />
                        </td><td>
                        <img class = "ic" src="images/volume-up.png" width="15px" style="margin-left:2px;" />
                    </td></table>
                    </div>

                    <div class="nextbox">
                        <span class="badge badge-pill badge-light">
                            <div id="nextSongTitle"><b>Next Song :</b>Next song title goes here...</div>
                        </span>
                    </div>

                </div>    
            </div>
            <!-- <script type="text/javascript" src="script.js"></script> -->
        </div>

        <div class="songList">
            <table>
            <?php
                $dir = 'C:\xampp\htdocs\Listener\Player';
                #$dir = 'songs/';

                // Sort in ascending order - this is default
                $a = scandir($dir);

                // Sort in descending order
                $b = scandir($dir,1);

                // print_r($a);
                // print_r($b);
                $a = array_diff( $a, array('.','..'));
                
                foreach($a as $name){
                    echo '<script type="text/javascript" src="script.js">add('.$name.');</script>';
                    //echo $name;
                }
                
                $x = 0;
                foreach($a as $song){
                   echo '<tr><td><span class="badge badge-light" onclick="select('.$x.');">'.$song.'</span></td></tr>';
                   $x++;

                }
            ?>
            </table>
        </div>
            
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "listener1";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            echo "Connected to database successfully";
            
        ?>

        <script  type="text/javascript">

            var songs = [];


            var songTitle = document.getElementById('songTitle');
            var songSlider = document.getElementById('songSlider');
            var currentTime = document.getElementById('currentTime');
            var duration = document.getElementById('duration');
            var volumeSlider = document.getElementById('volumeSlider');
            var nextSongTitle = document.getElementById('nextSongTitle');

            var song = new Audio();
            var currentSong = 0;

            window.onload = loadSong;
            //window.onload = prep;

            function prep(name){
                songs.push(name);
                
            }

            function add(name){
                currentSong = 0;
                songs.push(name);
                loadSong();
            }

            function loadSong () {
                // call(currentSong);
                song.src = "Player/" + songs[currentSong];
                songTitle.textContent = songs[currentSong];
                nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs[currentSong + 1 % songs.length];
                song.playbackRate = 1;
                song.volume = volumeSlider.value;
                song.play();
                setTimeout(showDuration, 1000);
            }

            setInterval(updateSongSlider, 1000);

            function updateSongSlider () {
                var c = Math.round(song.currentTime);
                songSlider.value = c;
                currentTime.textContent = convertTime(c);
                if(song.ended){
                    next();
                }
            }

            function convertTime (secs) {
                var min = Math.floor(secs/60);
                var sec = secs % 60;
                min = (min < 10) ? "0" + min : min;
                sec = (sec < 10) ? "0" + sec : sec;
                return (min + ":" + sec);
            }

            function showDuration () {
                var d = Math.floor(song.duration);
                songSlider.setAttribute("max", d);
                duration.textContent = convertTime(d);
            }

            function playOrPauseSong (img) {
                song.playbackRate = 1;
                if(song.paused){
                    song.play();
                    img.src = "images/pause.png";
                }else{
                    song.pause();
                    img.src = "images/play.png";
                }
            }

            function next(){
                call(currentSong);
                currentSong++;
                currentSong = (currentSong > songs.length-1) ? 0 : currentSong;
                //currentSong = currentSong + 1 % songs.length;
                loadSong();
            }

            function previous () {
                call(currentSong);
                currentSong--;
                currentSong = (currentSong < 0) ? songs.length - 1 : currentSong;
                loadSong();
            }

            function seekSong () {
                song.currentTime = songSlider.value;
                currentTime.textContent = convertTime(song.currentTime);
            }

            function adjustVolume () {
                song.volume = volumeSlider.value;
            }

            function increasePlaybackRate () {
                songs.playbackRate += 0.5;
            }

            function decreasePlaybackRate () {
                songs.playbackRate -= 0.5;
            }

            function select (x) {
                call(currentSong);
                currentSong = x;
                loadSong();
            }

            function call(xy){
                // var obj = {"z":songs[xy], "y":song.currentTime};
                // var dbParam = JSON.stringify(obj);
                
                xmlhttp = new XMLHttpRequest();
	            xmlhttp.open("POST", "player.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("x=" + songs[xy]);
                console.log("x=" + songs[xy]);

                xmlhttp = new XMLHttpRequest();
	            xmlhttp.open("POST", "player.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("y=" + song.currentTime);
                console.log("y=" + song.currentTime);

                // xmlhttp.send("x=" + dbParam);
                // console.log("x=" + dbParam);

                <?php 
                    $xxx = isset($_POST['x']) ? $_POST['x'] : '';
                    $times = 5;

                    if($xxx != ""){
                        $sql = "INSERT INTO history (title, runtime, checked) VALUES ('".$xxx."',".$times.", 0)";

                        if ($GLOBALS['conn']->query($sql) === TRUE) {
                            //echo "New record created successfully";
                        } else {
                            //echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    
                ?>

            }

            var songs = <?php echo '["' . implode('", "', $a) . '"]' ?>;
            prep(songs);

            
        </script>


    </body>
</html>