<!DOCTYPE html>
<html>
	<head>
		<title>Listner Music Player</title>
		<link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/png" href="images/logo.png"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</head>
	<body>
        <?php include "header.php"; ?>
        <div>
            <div class="verdict-box">
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
                     //echo "Connected to database successfully";

                     $sql = "SELECT * FROM verdict WHERE id=0";
                     $result = $conn->query($sql);
                     
                     if ($result->num_rows > 0) {
                         // output data of each row
                         while($row = $result->fetch_assoc()) {
                            $badge1 = 'warning';
                            $badge2 = 'light';
                            $testt = $row["audMood"];
                            if($row["audMood"]=='amzement' || $row["audMood"]=='joyful'){
                                $badge1 = 'primary';
                            }
                            if($row["audMood"]=='calmness' || $row["audMood"]=='tenderness'){
                                $badge1 = 'light';
                            }
                            if($row["audMood"]=='sad' || $row["audMood"]=='nostalgia'){
                                $badge1 = 'info';
                            }
                            if($row["audMood"]=='power' || $row["audMood"]=='solemnity'){
                                $badge1 = 'danger';
                            }
                            if($row["lyrMood"]=='death' || $row["lyrMood"]=='depression'){
                                $badge2 = 'light';
                            }
                            if($row["lyrMood"]=='happiness'){
                                $badge2 = 'success';
                            }
                            if($row["lyrMood"]=='suicide'){
                                $badge2 = 'danger';
                            }
                            echo 'You listen to songs that mostly sounds representing <span class="badge badge-'.$badge1.'">'.$row["audMood"].'</span> and is <span class="badge badge-'.$badge2.'">'.$row["lyrMood"].'</span> in context.';
                         }
                     } else {
                         echo "0 results";
                     }
                     $conn->close();
                ?>
            </div><br>
            <div class="songList2">
                <span class="badge badge-light"><div class="history-title">Your Listening History</div></span>

                <div>
                <br><table>
                    <th>Track</th>
                    <th>Time</th>
                    <th>Mood</th>
                    <th>Context</th>
                    <?php 
                        $file = fopen('test.csv', 'r');
                        while (($line = fgetcsv($file)) !== FALSE) {
                            //$line is an array of the csv elements
                            $num = 4;
                            echo '<tr border="1">';
                            for ($c = 0; $c < $num; $c++){
                                if($c == 2){
                                    $badge = 'light';
                                    if($line[$c]=='amazement' || $line[$c]=='joyful'){
                                        $badge = 'primary';
                                    }
                                    else if($line[$c]=='calmness' || $line[$c]=='tenderness'){
                                        $badge = 'light';
                                    }
                                    else if($line[$c]=='sad' || $line[$c]=='nostalgia'){
                                        $badge = 'info';
                                    }
                                    else if($line[$c]=='power' || $line[$c]=='solemnity'){
                                        $badge = 'danger';
                                    }
                                    echo '<td>';
                                    echo '<span class="badge badge-'.$badge.'">'.$line[$c].'</span>';
                                    echo '</td>'; 
                                }
                                else if($c == 3){
                                    $badge = 'light';
                                    if($line[$c]=='death' || $line[$c]=='depression'){
                                        $badge = 'light';
                                    }
                                    else if($line[$c]=='happiness'){
                                        $badge = 'success';
                                    }
                                    else if($line[$c]=='suicide'){
                                        $badge = 'danger';
                                    }
                                    echo '<td>';
                                    echo '<span class="badge badge-'.$badge.'">'.$line[$c].'</span>';
                                    echo '</td>'; 
                                }
                                else if ($c == 0){
                                    echo '<td class="track_name">';
                                    echo $line[$c];
                                    echo '</td>'; 
                                }
                                else if ($c == 1){
                                    echo '<td>';
                                    echo $line[$c];
                                    echo '</td>'; 
                                }
                               
                            }
                            echo '</tr>';
                          }
                        fclose($file);
                        ?>
                        <tr>
                        </tr>
                    </table>
                </div>  
            </div>
        </div>

        <?php
            // $title = 'Nine Inch Nails - Hurt';
            // $title = str_replace(' ', '_', $title);
            // $time = 236;

            // echo shell_exec("C:\Users\User\Anaconda3\python.exe C:/Users/User/.spyder-py3/hello.py $title $time");
            #echo shell_exec("C:\Users\User\Anaconda3\python.exe D:/Projects/FYP/Listener/Main_controller.py $title $time");
            #echo $title;
        ?>
    </body>
</html>