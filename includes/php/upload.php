<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 10/20/16
 * Time: 3:02 PM
 */

//FILE uploads done, just need to solidify naming convention.
//TODO name file based on midi file meta data, after searching spotify.
include 'base.php';
$action = $_GET['action'];

if($action != ""){
    switch($action){
        case 'rename':
            $file = "temp";
            if(file_exists($_SERVER['DOCUMENT_ROOT']."/midi_files/".$file."_1.mid")){
                $count = 1;
                while(file_exists($_SERVER['DOCUMENT_ROOT']."/midi_files/".$file."_".$count.".mid")){
                    $count++;
                }
                $file = "temp_".--$count.".mid";
            }else{
                $file = "temp.mid";
            }
            //We know that the last temp_n.mid is the one we want to change

            $title = mysqli_real_escape_string($conn,$_GET['title']);
            $artist = mysqli_real_escape_string($conn,$_GET['artist']);
            $album = mysqli_real_escape_string($conn,$_GET['album']);
            $duration = mysqli_real_escape_string($conn,$_GET['duration']);
            $spotify_id = mysqli_real_escape_string($conn,$_GET['spotify_id']);
            $spotify_url = mysqli_real_escape_string($conn,$_GET['spotify_url']);
            $spotify_popularity = mysqli_real_escape_string($conn,$_GET['spotify_popularity']);
            $preview_url = mysqli_real_escape_string($conn,$_GET['preview_url']);
            $spotify_uri = mysqli_real_escape_string($conn,$_GET['spotify_uri']);
            $image_url = mysqli_real_escape_string($conn,$_GET['image_url']);
            $file_name = str_replace(' ', '_', $title)."_".str_replace(' ', '_', $artist)."_".str_replace(' ', '_', $album);
            $count = 1;

            while(file_exists($_SERVER['DOCUMENT_ROOT']."/midi_files/".$file_name."_".$count.".mid")){
                $count++;
            }
            $file_name = $file_name."_".$count.".mid";
            $rename = rename($_SERVER['DOCUMENT_ROOT']."/midi_files/".$file, $_SERVER['DOCUMENT_ROOT']."/midi_files/".$file_name);
            if(!$rename){
                $json = array('code' => 404, 'error' => 'Failed to rename the file.', 'file_name' => $_SERVER['DOCUMENT_ROOT']."/midi_files/".$file_name, 'old' => $_SERVER['DOCUMENT_ROOT']."/midi_files/".$file);
                echo json_encode($json);
                exit;
            }
            $sql = "SELECT * FROM tracks WHERE spotify_id = '".$spotify_id."'";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) == 0){

                $sql_track = "INSERT INTO tracks (title, artist, album, duration, spotify_id, spotify_url, spotify_popularity, preview_url, spotify_uri, image_url) VALUES ('".$title."','".$artist."','".$album."',".$duration.",'".$spotify_id."','".$spotify_url."',".$spotify_popularity.",'".$preview_url."','".$spotify_uri."','".$image_url."')";
                $query_track = mysqli_query($conn, $sql_track);
                if(!$query_track){
                    $json = array('code' => 404, 'error' => 'Failed to save track information. ', 'query' => $sql_track, 'sql_error' => mysqli_error($conn));
                    echo json_encode($json);
                    exit;
                }
                $id = mysqli_insert_id($conn);

            }else{
                $result = mysqli_fetch_assoc($query);
                $id = $result['id'];
            }


            $sql = "INSERT INTO midi_files (track_id, file_name) VALUES (".$id.", '".$file_name."')";
            $query = mysqli_query($conn, $sql);
            if(!$query){
                $json = array('code' => 404, 'error' => 'Failed to save file information.', 'sql_error' => mysqli_error($conn), 'sql' => $sql);
                echo json_encode($json);
                exit;
            }

            $json = array('code' => 200, 'track' => $id, 'file' => mysqli_insert_id($conn));
            echo json_encode($json);
            exit;

            break;
        case 'upload':
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/midi_files/";
            $target_file = "temp.mid";
            $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
            //$filename = $_GET['filename'];

            if ( 0 < $_FILES['midi_file']['error']  || pathinfo($target_file,PATHINFO_EXTENSION) != 'mid') {
                echo 'ERROR UPLOADING FILE';
            } else {
                if(!file_exists($target_dir.$target_file)){
                    if(move_uploaded_file($_FILES['midi_file']['tmp_name'], $target_dir.$target_file)){
                        echo $target_file;
                    }else{
                        echo "ERROR UPLOADING FILE";
                    }
                }else{
                    $count = 0;
                    $temp = basename($target_file, ".mid");

                    while(file_exists($_SERVER['DOCUMENT_ROOT']."/midi_files/".$temp.".mid")){
                        $count++;
                        $temp = basename($target_file, ".mid")."_".$count;
                    }
                    $target_file = $temp.".mid";

                    move_uploaded_file($_FILES['midi_file']['tmp_name'], "../../midi_files/".$target_file);
                    echo $target_file;
                }

            }
            exit;

    }

}
