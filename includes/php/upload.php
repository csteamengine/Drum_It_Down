<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 10/20/16
 * Time: 3:02 PM
 */

//FILE uploads done, just need to solidify naming convention.
//TODO name file based on midi file meta data, after searching spotify.

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
                $file = "temp_".$count.".mid";
            }else{
                $file = "temp.mid";
            }
            //TODO rename temp.mid and return the information to the client.
            //TODO get all the GET variables that are passed in and rename the file and store the info in the database.
            //Store the new midi file in the db and point it towards the corresponding track.
            //Use rename() to rename the file to a relevant file name
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
