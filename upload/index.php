<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:27 PM
 */

include "../includes/php/base.php";
include "../includes/php/general.php";

if(!$_SESSION['logged_in']){
    header("Location: /login.php");
}


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

    <title>Upload | Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="../favicon.png?v=3"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../includes/css/shared.css">
    <link rel="stylesheet" href="../includes/css/header.css">
    <link rel="stylesheet" href="../includes/css/footer.css">
    <script src='../includes/jasmid/stream.js'></script>
    <script type="application/javascript" src="../includes/jasmid/midifile.js"></script>
    <script src="../includes/jasmid/replayer.js"></script>
    <!--    <script src="includes/jasmid/synth.js"></script>-->
    <!--    <script src="includes/jasmid/audio.js"></script>-->
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "../includes/php/header.php";
?>
<body>

<form id="file_upload" method="post" enctype="multipart/form-data">
    <input type="file" name="midi_file" id="midi_file">
    <h4 id="file_name"></h4>
    <div id="submit_div" hidden>
        <input type="submit" value="Upload" id="submit">
    </div>
</form>
<button id="other_midi" hidden>Upload Another File</button>
<form id="search_song" hidden>
    <h3>Didn't find the song you were looking for?</h3>
    <input type="text" name="title" id="song_title" placeholder="Search Again">
    <input type="submit" value="Search">
</form>
<div id="song_guesses" hidden>
    <h3>No results for that search</h3>
</div>

<h1 id="loading" hidden>Loading...</h1>


<!--<a href="player.html"><h2>Go to Player view!!! (Testing purposes)</h2></a>-->
<!---->
<!--<a href="http://jazz-soft.net/demo/GeneralMidiPerc.html" target="_blank">This could prove useful later...</a><br>-->
<!--<a href="https://groovemonkee.com/pages/free-midi-loops" target="_blank">Might want to check out these drum loops...</a><br>-->
<!--<a href="https://en.wikipedia.org/wiki/General_MIDI#Percussion" target="_blank">We'll probably need these too...</a><br>-->
</body>

<script src="/includes/js/shared.js"></script>
<!--suppress JSUnresolvedVariable -->
<script>

    $().ready(function () {
        $('#other_midi').click(function(){
            $('#file_upload').show();
            $('#song_guesses').html('');
            $('#song_guesses').hide();
            $('#specify_song').hide();
        });
        $("input[type=file]").each(function () {
            var thisInput$ = $(this);
            var newElement = $("<input type='button' value='Choose File' />");
            newElement.click(function() {
                thisInput$.click();
            });
            thisInput$.after(newElement);
            thisInput$.hide();
        });
        var midiFile;
        $('#file_upload').submit(function (event) {
            event.preventDefault();
            $('#file_upload').hide();
            $('#search_song').show();
            $('#other_midi').show();
            $('#song_guesses').show();
            if ($('#midi_file').val() != null) {
                upload_file();
            }
        });
        $('#search_song').submit(function (event) {
            event.preventDefault();
            $('#file_upload').hide();
            $('#song_guesses').show();
            search_song();
        });
        $('#midi_file').change(function(){
            if($('#midi_file').prop('files')[0] != null){
                $('#file_name').html($('#midi_file').prop('files')[0].name);
                $('#submit_div').show();
            }else{
                $('#file_name').html('');
                $('#submit_div').hide();
            }
        });
    });
</script>
</html>
