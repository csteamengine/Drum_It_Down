<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 10/20/16
 * Time: 3:02 PM
 */

//FILE uploads done, just need to solidify naming convention.
//TODO name file based on midi file meta data, after searching spotify.

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
