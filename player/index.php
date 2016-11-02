<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/24/2016
 * Time: 9:15 AM
 */
include "../includes/php/base.php";
include "../includes/php/general.php";

if(!$_SESSION['logged_in']){
    header("Location: /login.php");
}

$action = $_GET['action'];
if($action != ""){
    switch($action){
        case 'play':
            //TODO get likes and check if current user has already liked the file
            $track = $_GET['track'];
            $file = $_GET['file'];
            if($file == ""){
                $sql = "SELECT * FROM midi_files WHERE track_id = ".$track." ORDER BY popularity DESC";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) > 0){
                    $file = mysqli_fetch_assoc($query);
                }
            }else{
                //TODO select file and track info from db.
                $sql = "SELECT * FROM midi_files WHERE id=".$file;
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) == 0){
                    //TODO error
                }
                $file = mysqli_fetch_assoc($query);
            }

            $sql = "SELECT * FROM tracks WHERE id=".$track;
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){
                //TODO error
                echo "No Results ".$track;
            }
            $track = mysqli_fetch_assoc($query);


            break;
        case 'upvote':
            $sql = "SELECT * FROM downvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND file_id=".$_GET['file_id']." AND active = 'yes'";
            $sql_up = "SELECT * FROM upvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND file_id=".$_GET['file_id']." AND active = 'yes'";

            $query_down= mysqli_query($conn, $sql);
            if(mysqli_num_rows($query_down) > 0){
                $result = mysqli_fetch_assoc($query_down);
                $deactivate = "UPDATE downvotes SET active = 'no' WHERE id=".$result['id'];
                $query_deactivate = mysqli_query($conn, $deactivate);

                $upvote = "INSERT INTO upvotes (file_id, user_id) VALUES (".$_GET['file_id'].",(SELECT id FROM users WHERE username='".$_SESSION['username']."'))";
                $query_upvote = mysqli_query($conn, $upvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Upvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;

            }

            $query_up = mysqli_query($conn, $sql_up);
            if(mysqli_num_rows($query_up) > 0){
                $result = mysqli_fetch_assoc($query_up);
                $unvote = "UPDATE upvotes SET active='no' WHERE id=".$result['id'];
                $query_unvote = mysqli_query($conn, $unvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Unvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;
            }else{
                $upvote = "INSERT INTO upvotes (file_id, user_id) VALUES (".$_GET['file_id'].", (SELECT id FROM users WHERE username='".$_SESSION['username']."'))";
                $query_upvote = mysqli_query($conn, $upvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Upvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;
            }


            break;
        case 'downvote':
            $sql = "SELECT * FROM downvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND file_id=".$_GET['file_id']." AND active = 'yes'";
            $sql_up = "SELECT * FROM upvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND file_id=".$_GET['file_id']." AND active = 'yes'";

            $query_up= mysqli_query($conn, $sql_up);
            if(mysqli_num_rows($query_up) > 0){
                $result = mysqli_fetch_assoc($query_up);
                $deactivate = "UPDATE upvotes SET active = 'no' WHERE id=".$result['id'];
                $query_deactivate = mysqli_query($conn, $deactivate);
                $downvote = "INSERT INTO downvotes (file_id, user_id) VALUES (".$_GET['file_id'].",(SELECT id FROM users WHERE username='".$_SESSION['username']."'))";
                $query_upvote = mysqli_query($conn, $downvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Downvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;

            }

            $query_down = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query_down) > 0){
                $result = mysqli_fetch_assoc($query_down);
                $unvote = "UPDATE downvotes SET active='no' WHERE id=".$result['id'];
                $query_unvote = mysqli_query($conn, $unvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Unvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;
            }else{
                $downvote = "INSERT INTO downvotes (file_id, user_id) VALUES (".$_GET['file_id'].", (SELECT id FROM users WHERE username='".$_SESSION['username']."'))";
                $query_downvote = mysqli_query($conn, $downvote);
                $returned = update_pop($conn);
                $json = array('code' => 200, 'action' => 'Downvoted', 'returned' => $returned);
                echo json_encode($json);
                exit;
            }
            break;
    }
}


function update_pop($conn){
    $sql_up = "SELECT * FROM upvotes WHERE file_id=".$_GET['file_id']." AND active = 'yes'";
    $query_up = mysqli_query($conn, $sql_up);
    $sql_down = "SELECT * FROM downvotes WHERE file_id=".$_GET['file_id']." AND active = 'yes'";
    $query_down = mysqli_query($conn, $sql_down);

    $up = mysqli_num_rows($query_up);
    $down = mysqli_num_rows($query_down);

    $count  = $up - $down;

    $insert = "UPDATE midi_files SET popularity=".$count." WHERE id=".$_GET['file_id'];
    $query = mysqli_query($conn,$insert);

    return $count;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Mines of MIDIa</title>

    <link rel="stylesheet" href="../includes/css/shared.css">
    <link rel="stylesheet" href="../includes/css/header.css">
    <link rel="stylesheet" href="../includes/css/footer.css">
    <link rel="stylesheet" href="../includes/css/music_staff.css">
    <link rel="stylesheet" href="../includes/css/player.css">
    <link rel="icon" type="image/x-icon" href="../favicon.png?v=4"/>
    <!--<script src="includes/shim/Base64.js" type="text/javascript"></script>-->
    <script src="../includes/shim/Base64binary.js" type="text/javascript"></script>
    <script src="../includes/shim/WebAudioAPI.js" type="text/javascript"></script>
    <script src="../includes/shim/WebMIDIAPI.js" type="text/javascript"></script>
    <!-- jasmid package -->
    <script src="../includes/jasmid/stream.js"></script>
    <script src="../includes/jasmid/midifile.js"></script>
    <script src="../includes/jasmid/replayer.js"></script>
    <!-- midi.js package -->
    <script src="../includes/midi-js/js/midi/audioDetect.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/gm.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/loader.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/plugin.audiotag.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/plugin.webaudio.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/plugin.webmidi.js" type="text/javascript"></script>
    <script src="../includes/midi-js/js/midi/player.js" type="text/javascript"></script>
    <!-- utils -->
    <script src="../includes/midi-js/js/util/dom_request_xhr.js" type="text/javascript"></script>
    <!--<script src="includes/midi-js/js/util/dom_request_script.js" type="text/javascript"></script>-->
    <!-- includes -->
    <script src="../includes/js/timer.js" type="text/javascript"></script>
    <script src="../includes/js/event.js" type="text/javascript"></script>
    <script src="../includes/js/shared.js" type="text/javascript"></script>
</head>
<?php
include "../includes/php/header.php";
?>
<body>
<input type="hidden" id="song_file" value="<?= $file['file_name'] ?>">
<input type="hidden" id="duration" value="<?= $track['duration'] ?>">
<h2 id="title"><?= $track['title']." -- ". $track['artist'] ?></h2>

<div style="position: fixed; top: 0; left: 0; z-index: 4; overflow: hidden;" id="colors"></div>
<?php
$sql1 = "SELECT * FROM upvotes WHERE file_id=".$file['id']." AND user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND active = 'yes'";
$sql2 = "SELECT * FROM downvotes WHERE file_id=".$file['id']." AND user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND active = 'yes'";

$query_up = mysqli_query($conn, $sql1);
$query_down = mysqli_query($conn, $sql2);

?>
<div id="loading" hidden>
    <h1>Loading</h1>

    <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
        <defs>
            <filter id="gooey">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                <feBlend in="SourceGraphic" in2="goo"></feBlend>
            </filter>
        </defs>
    </svg>
    <div class="blob blob-0"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="blob blob-4"></div>
    <div class="blob blob-5"></div>
</div>
<img id="upvote" onclick="up_vote('<?= $file['id'] ?>')" src="/includes/images/<?= mysqli_num_rows($query_up) > 0 ? 'upvoted' : 'upvote'  ?>.png">
<img id="downvote" onclick="down_vote('<?= $file['id'] ?>')" src="/includes/images/<?= mysqli_num_rows($query_down) > 0 ? 'downvoted' : 'downvote' ?>.png">

<div id="player" style="">

    <div class="player">
        <div id="controls">
            <input type="image" src="../includes/images/pause.png" align="absmiddle" value="pause"
                   onclick="pausePlayStop()" id="pausePlayStop">
            <input type="image" src="../includes/images/stop.png" align="absmiddle" value="stop"
                   onclick="pausePlayStop(true)">
            <input type="image" src="../includes/images/backward.png" align="absmiddle" value="stop"
                   onclick="player.getNextSong(-1);">
            <input type="image" src="../includes/images/forward.png" align="absmiddle" value="stop"
                   onclick="player.getNextSong(+1);">
        </div>


        <div class="time-controls">
            <span id="time1" class="time">0:00</span>
            <span id="capsule">
					<span id="cursor"></span>
				</span>
            <span id="time2" class="time">-0:00</span>
        </div>
    </div>

</div>

<div id="sheet-music-header">
    <h2>Generated Sheet Music</h2>
    <p><b>Disclaimer:</b> Sheet music generation can only match quarter, eighth, and 16th notes in 4/4 time. It can't
        do triplets, odd groupings, odd time signatures, or anything smaller in duration than 16th notes. At
        least not yet...</p><div id="music-staff"></div>
</div>


<?php
include "../drum.php";

?>

<script src="../includes/js/music_staff.js" type="text/javascript"></script>
<script src="../includes/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="../includes/js/mines_of_midia_player.js" type="text/javascript"></script>
<script>
    var upvoter = $('#upvote');
    var downvoter = $('#downvote');

    function up_vote(id){
        var url = "/player/index.php?action=upvote&file_id="+id;
        $.getJSON(url, function(response){
            console.log(response);
            if(response.action == 'Upvoted'){
                upvoter.attr('src','/includes/images/upvoted.png');
                downvoter.attr('src','/includes/images/downvote.png');
            }else if(response.action == 'Unvoted'){
                upvoter.attr('src','/includes/images/upvote.png');
                downvoter.attr('src','/includes/images/downvote.png');
            }
        });
    }
    function down_vote(id){
        var url = "/player/index.php?action=downvote&file_id="+id;
        $.getJSON(url, function(response){
            console.log(response);
            if(response.action == 'Downvoted'){
                upvoter.attr('src','/includes/images/upvote.png');
                downvoter.attr('src','/includes/images/downvoted.png');
            }else if(response.action == 'Unvoted'){
                upvoter.attr('src','/includes/images/upvote.png');
                downvoter.attr('src','/includes/images/downvote.png');
            }
        });
    }
</script>
</body>
</html>
<?php


