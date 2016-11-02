<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:50 PM
 */
//error_reporting(-1);
//ini_set('display_errors', 'On');

session_start();


//Comment out this secion and replace the connection info with your local stuff.
//This connection is for a live mysql database that you have to have IP access to,
//So it won't work for you.
//########################################
$this_file = str_replace('se329_project_3', '', $_SERVER['DOCUMENT_ROOT']);
$sql_file = $this_file.'/drums_config.txt';

$json = "";
if (file_exists($sql_file))
{
    // Note: You should probably do some more checks
    // on the filetype, size, etc.
    $contents = file_get_contents($sql_file);

    // Note: You should probably implement some kind
    // of check on filetype

    $json = $contents;
}
if($json == ""){
    echo "No file contents";
}
$json = json_decode($json);

$dbhost = $json->{'host'};
$dbname = $json->{'database'}; // the name of the database that you are going to use for this project

$dbuser = $json->{'username'}; // the username that you created, or were given, to access your database
$dbpass = $json->{'password'}; // the password that you created, or were given, to access your database
$port = $json->{'port'};

//#############################################



//Uncomment this section for your local database.
//#############################################
//$dbhost = 'localhost';
//$dbname = 'YOUR MYSQL DATABASE NAME'; // the name of the database that you are going to use for this project
//
//$dbuser = "YOUR MYSQL USERNAME"; // the username that you created, or were given, to access your database
//$dbpass = 'YOUR MYSQL PASSWORD'; // the password that you created, or were given, to access your database
//$port = 3306;
//#############################################


$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname,$port);

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
