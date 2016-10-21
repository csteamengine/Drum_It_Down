<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:27 PM
 */

include "includes/php/base.php";
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
    <link rel="icon" type="image/x-icon" href="includes/images/favicon.png" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/css/shared.css">
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <script src='includes/jasmid/stream.js'></script>
    <script type="application/javascript" src="includes/jasmid/midifile.js"></script>
    <script src="includes/jasmid/replayer.js"></script>
    <script src="includes/jasmid/synth.js"></script>
    <script src="includes/jasmid/audio.js"></script>
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "includes/php/header.php";
?>
<body>
    <form id="file_upload" method="post" enctype="multipart/form-data">
        <input type="file" name="midi_file" id="midi_file">
        <input type="submit" value="Upload">
    </form>
    <div id="song_guesses"></div>
    <form id="search_song">
        <h3>Didn't find the song you were looking for? Search here.</h3>
        <input type="text" name="title" id="song_title" placeholder="Title">
        <input type="submit" value="Search">
    </form>
</body>

<?php
include "includes/php/footer.php";
?>
<script src="/includes/js/shared.js"></script>
<script>
    var midiFile;
    $('#file_upload').submit(function(event){
        event.preventDefault();
       if($('#midi_file').val() != null){
           upload_file();
       }
    });
    $('#search_song').submit(function(event){
        event.preventDefault();
        search_song();
    })
    function upload_file(){

        var file_data = $('#midi_file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('midi_file', file_data);



        $.ajax({
            url: '/includes/php/upload.php', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
                if(php_script_response != "ERROR UPLOADING FILE"){
                    parse_midi(php_script_response, $('#midi_file').prop('files')[0].name);
                    if(midiFile == "Error: Could not find a drum track."){
                        console.log("Error");
                    }else{
                        //parsing was successful

                    }
                }
            }
        });

        setTimeout(function(){
            guess_track_info();
        }, 1000);

    }

    //This goes through all of the events with subtype trackName and queries spotify to see if any of those trackNames are a relevant title
//    Eventually, this information will be put in the dom, asking them if the midi file is any of the following tracks.
//    If not, they can search spotify by searching the song name.
    function guess_track_info(){
        if(midiFile != null){
            console.log(midiFile);
            //An array that I'm storing all the spotify result in. Not going to work for the final product, due to cl
            var top_hits = [];
            var search_term = "";
            var limit = 1;
            for(i = 0;i<midiFile.tracks.length;i++){
                for(j =0;j<midiFile.tracks[i].length; j++){
                    if(midiFile.tracks[i][j].subtype == "trackName" && midiFile.tracks[i][j].text != ""){
                        search_term = encodeURI(midiFile.tracks[i][j].text.trim());
                        var url = "https://api.spotify.com/v1/search?q="+ search_term +"&type=track&limit=" + limit;
                        $.getJSON(url, function(result){

                            if(result.tracks.items.length > 0){
                                top_hits.push(result.tracks.items[0].name + " -- " + result.tracks.items[0].artists[0].name);
                            }
                        });
                    }
                }
            }
            if(midiFile.header.original_file_name != null){
                limit = 5;
                search_term = encodeURI(midiFile.header.original_file_name.trim().replace('.mid', ''));
                search_term = search_term.replace(' ', '%20');
                url = "https://api.spotify.com/v1/search?q="+ search_term +"&type=track&limit=" + limit;
                $.getJSON(url, function(result){
                    if(result.tracks.items.length > 0){
                        for(m = 0;m<result.tracks.items.length;m++){
                            top_hits.push(result.tracks.items[m].name + " -- " + result.tracks.items[m].artists[0].name );
                        }
                    }

                });
            }

        }
    }
    function search_song(){
        if($('#song_title').val() != ""){
            limit = 10;
            search_term = encodeURI($('#song_title').val());
            url = "https://api.spotify.com/v1/search?q="+ search_term +"&type=track&limit=" + limit;
            $.getJSON(url, function(result){
                if(result.tracks.items.length > 0){
                    for(m = 0;m<result.tracks.items.length;m++){
                        console.log(result.tracks.items[m].name + " -- " + result.tracks.items[m].artists[0].name );
                    }
                }

            });
        }
    }
</script>
</html>
