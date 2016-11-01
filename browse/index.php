<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/25/2016
 * Time: 10:01 AM
 */

include "../includes/php/base.php";
include "../includes/php/general.php";


if($_GET['action'] != ""){
    $action = $_GET['action'];
    switch($action){
        case 'search':
            $track = $_GET['track'];
            $sql = "SELECT * FROM midi_files WHERE track_id = (SELECT id FROM tracks WHERE spotify_id='".$track."')";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                $result = mysqli_fetch_assoc($query);
                $sql2 = "SELECT * FROM tracks WHERE spotify_id='".$track."'";
                $query2 = mysqli_query($conn, $sql2);
                $result2 = mysqli_fetch_assoc($query2);
                $json = array('code' => 200, 'track' => $result2, 'file' => $result, 'number' => $_GET['number']);
                echo json_encode($json);
                exit;
            }else{
                $json = array('code' => 404, 'error' => 'No Search Results', 'number' => $_GET['number']);
                echo json_encode($json);
                exit;
            }
            break;
        default:

            break;

    }
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

    <title>Browse | Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="/favicon.png?v=3"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/includes/css/shared.css">
    <link rel="stylesheet" href="/includes/css/header.css">
    <link rel="stylesheet" href="/includes/css/footer.css">
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "../includes/php/header.php";
?>
<body>

<div id="popular" class="grid">
    <div class="item" id="search_songs_div">
        <form id="search_songs_form">
            <input type="text" id="search_songs" placeholder="Search Songs">
            <button id="search_songs_button">Search</button>
        </form>
        <div id="results"></div>
    </div>
    <div class="item" id="popular_files">
        <h1>Popular Files</h1>
        <?php
        $sql = "SELECT * FROM midi_files mf INNER JOIN tracks tr WHERE mf.track_id = tr.id GROUP BY tr.title ORDER BY mf.popularity DESC LIMIT 5";
        $query = mysqli_query($conn, $sql);
        while($result = mysqli_fetch_assoc($query)){
            $string = $result['title']." -- ".$result['artist'];
            ?>
            <p onclick="relocate(<?= $result['id'] ?>)" class="song <?= strlen($string) > 30 ? 'marquee' : '' ?>"><?= $string  ?></p>
            <?php
        }
        ?>
    </div>
    <div class="item" id="popular_songs">
        <h1>Popular Tracks</h1>

        <?php
        $sql = "SELECT * FROM tracks ORDER BY popularity DESC LIMIT 5";
        $query = mysqli_query($conn, $sql);
        while($result = mysqli_fetch_assoc($query)){
            $string = $result['title']." -- ".$result['artist'];
            ?>
            <p onclick="relocate(<?= $result['id'] ?>)" class="song <?= strlen($string) > 30 ? 'marquee' : '' ?>"><?= $string  ?></p>
            <?php
        }
        ?>
    </div>
</div>
<div id="all_songs" hidden>
<!--    TODO display a list of all the songs we have, with lots of information about them-->
<!--    When Clicked, it will take them to the player.php page and start playing.-->
</div>
</body>
<script>
    function relocate(id){
        window.location = '/player/?action=play&file='+id;
    }
    $('#search_songs_form').submit(function(event){
        event.preventDefault();
        $('#results').html('');
        if($('#search_songs').val() != ""){
            var limit = 5;
            var search_term = encodeURI($('#search_songs').val());
            var url = "https://api.spotify.com/v1/search?q=" + search_term + "&type=track&limit=" + limit;
            $.getJSON(url, function (result) {
                for(i = 0;i< 5;i++){
                    var new_url = "/browse/index.php?action=search&track="+ result.tracks.items[i].id + '&number='+i;
                    $.getJSON(new_url, function (result2) {
                        var results = $('#results');
                        console.log(result2);
                        if(result2.code == 200){
                            var classAdd = "";
                            var string = result2.track.title + ' -- ' + result2.track.artist;
                            if(string.length > 30){
                                classAdd = "marquee";
                            }
                            results.append(
                                '<p onclick="relocate('+ result2.file.id +')" class="song '+ classAdd+'">'+string+'</p>'
                            );
                        }
                        if(result2.number ==4 ){
                            if(results.html() == ""){
                                results.append(
                                    '<p class="song " style="text-align: center; width: 100%; pointer-events: none;">No Search Results</p>'
                                )
                            }
                        }
                    });

                }

            });


        }

    });
</script>
</html>