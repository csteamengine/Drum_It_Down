<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:27 PM
 */

//include "includes/php/base.php";
include "includes/php/general.php";


####################################################
###############   Preprocessing   ##################
####################################################


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="favicon.png?v=2"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/css/shared.css">
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <script src='includes/jasmid/stream.js'></script>
    <script type="application/javascript" src="includes/jasmid/midifile.js"></script>
    <script src="includes/jasmid/replayer.js"></script>
<!--    <script src="includes/jasmid/synth.js"></script>-->
<!--    <script src="includes/jasmid/audio.js"></script>-->
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "includes/php/header.php";
?>
<body>
<h1>Mines of Midia</h1>
<h2>Drums, Drums in the deep.</h2>
<form id="file_upload" method="post" enctype="multipart/form-data">
    <input type="file" name="midi_file" id="midi_file">
    <input type="submit" value="Upload">
</form>
<div id="song_guesses"></div>
<form id="search_song" hidden>
    <h3>Didn't find the song you were looking for? Search here.</h3>
    <input type="text" name="title" id="song_title" placeholder="Title">
    <input type="submit" value="Search">
</form>

<a href="player.html"><h2>Go to Player view!!! (Testing purposes)</h2></a>

<a href="http://jazz-soft.net/demo/GeneralMidiPerc.html" target="_blank">This could prove useful later...</a><br>
<a href="https://groovemonkee.com/pages/free-midi-loops" target="_blank">Might want to check out these drum loops...</a><br>
<a href="https://en.wikipedia.org/wiki/General_MIDI#Percussion" target="_blank">We'll probably need these too...</a><br>
</body>

<?php
include "includes/php/footer.php";
?>
<script src="/includes/js/shared.js"></script>
<!--suppress JSUnresolvedVariable -->
<script>
    $().ready(function () {
        var midiFile;
        $('#file_upload').submit(function (event) {
            event.preventDefault();
            $('#search_song').show();
            if ($('#midi_file').val() != null) {
                upload_file();
            }
        });
        $('#search_song').submit(function (event) {
            event.preventDefault();
            search_song();
        });

    });
</script>
</html>
