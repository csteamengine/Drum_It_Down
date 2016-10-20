<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/20/2016
 * Time: 9:12 AM
 */

include "../includes/php/general.php";
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
$code = $_GET['code'];

//TODO need to figure out how to get access token using authorization code.
//Need to do a POST request to spotify, but I cant get it to work.

$keys = get_spotify_key();
$keys = json_decode($keys);
$client_id = $keys->{'api_id'};
$client_secret = $keys->{'api_key'};
$redirect_uri = "http://localhost:8888";
$base64 = base64_encode($client_id.":".$client_secret);
if (isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
    $url = 'https://accounts.spotify.com/api/token';
    $params = array(
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => "http://localhost/login",
        "grant_type" => "authorization_code"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

    $output = curl_exec($ch);
    echo $output;
    $info = curl_getinfo($ch);
    echo json_encode($info);
    exit;
    curl_close($ch);

}
//else {
//
//    $url = "https://accounts.spotify.com/api/token";
//
//    $params = array(
//        "response_type" => "code",
//        "client_id" => YOUR_CLIENT_ID,
//        "redirect_uri" => 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
//        "scope" => "https://www.googleapis.com/auth/plus.me"
//    );
//
//    $request_to = $url . '?' . http_build_query($params);
//
//    header("Location: " . $request_to);
//}


//$url = 'https://accounts.spotify.com/api/token';
//$data = array('grant_type' => 'authorization_code', 'code' => $code, 'redirect_uri' => $redirect_uri);
//
//// use key 'http' even if you send the request to https://...
//$options = array(
//    'http' => array(
//        'header'  => "Authorization: Basic ".$base64,
//        'method'  => 'POST',
//        'content' => http_build_query($data)
//    )
//);
//$context  = stream_context_create($options);
//$result = file_get_contents($url, false, $context);
//if ($result === FALSE) { /* Handle error */ }
//
//var_dump($result);