<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/20/2016
 * Time: 8:17 AM
 */
function get_spotify_key(){
    $dir =  dirname($_SERVER['DOCUMENT_ROOT']);
    $parent = basename(dirname($_SERVER['PHP_SELF']));
    $file = $dir."/spotify.txt";


    $json = "";
    if (file_exists($file))
    {
        // Note: You should probably do some more checks
        // on the filetype, size, etc.
        $contents = file_get_contents($file);

        // Note: You should probably implement some kind
        // of check on filetype

        $json = $contents;
    }
    return $json;
}