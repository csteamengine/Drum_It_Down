<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/24/2016
 * Time: 9:15 AM
 */
include "includes/php/base.php";
$action = $_GET['action'];
if($action != ""){
    switch($action){
        case 'play':
            $track = $_GET['track'];
            $file = $_GET['file'];
            //TODO select file and track info from db.
            $sql = "SELECT * FROM midi_files WHERE id=".$file;
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){
                //TODO error
            }
            $file = mysqli_fetch_assoc($query);

            $sql = "SELECT * FROM tracks WHERE id=".$track;
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){
                //TODO error
            }
            $track = mysqli_fetch_assoc($query);


            break;

    }
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Mines of MIDIa</title>
    <link rel="stylesheet" href="includes/css/player.css">
    <link rel="stylesheet" href="includes/css/shared.css">
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <link rel="icon" type="image/x-icon" href="favicon.png?v=3"/>
    <!--<script src="includes/shim/Base64.js" type="text/javascript"></script>-->
    <script src="includes/shim/Base64binary.js" type="text/javascript"></script>
    <script src="includes/shim/WebAudioAPI.js" type="text/javascript"></script>
    <script src="includes/shim/WebMIDIAPI.js" type="text/javascript"></script>
    <!-- jasmid package -->
    <script src="includes/jasmid/stream.js"></script>
    <script src="includes/jasmid/midifile.js"></script>
    <script src="includes/jasmid/replayer.js"></script>
    <!-- midi.js package -->
    <script src="includes/midi-js/js/midi/audioDetect.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/gm.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/loader.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/plugin.audiotag.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/plugin.webaudio.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/plugin.webmidi.js" type="text/javascript"></script>
    <script src="includes/midi-js/js/midi/player.js" type="text/javascript"></script>
    <!-- utils -->
    <script src="includes/midi-js/js/util/dom_request_xhr.js" type="text/javascript"></script>
    <!--<script src="includes/midi-js/js/util/dom_request_script.js" type="text/javascript"></script>-->
    <!-- includes -->
    <script src="includes/js/timer.js" type="text/javascript"></script>
    <script src="includes/js/event.js" type="text/javascript"></script>
</head>
<?php
include "includes/php/header.php";
?>
<body>
<input type="hidden" id="song_file" value="<?= $file['file_name'] ?>">
<input type="hidden" id="duration" value="<?= $track['duration'] ?>">
<h2 id="title"><?= $track['title']." -- ". $track['artist'] ?></h2>

<div style="position: fixed; top: 0; left: 0; z-index: 4; overflow: hidden;" id="colors"></div>
<div id="player" style="">
    <div class="player">
        <div id="controls">
            <input type="image" src="includes/images/pause.png" align="absmiddle" value="pause"
                   onclick="pausePlayStop()" id="pausePlayStop">
            <input type="image" src="includes/images/stop.png" align="absmiddle" value="stop"
                   onclick="pausePlayStop(true)">
            <input type="image" src="includes/images/backward.png" align="absmiddle" value="stop"
                   onclick="player.getNextSong(-1);">
            <input type="image" src="includes/images/forward.png" align="absmiddle" value="stop"
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
<?php
include "drum.php";

?>
<script src="includes/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="includes/js/mines_of_midia_player.js" type="text/javascript"></script>
</body>
<?php
include "includes/php/footer.php";
?>
</html>
