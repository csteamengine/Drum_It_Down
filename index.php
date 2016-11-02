<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 10/31/16
 * Time: 10:51 AM
 */

include "includes/php/base.php";
include "includes/php/general.php";

if(!$_SESSION['logged_in']){
    $action = $_GET['action'];
    if($action != ""){
        switch($action){
            case 'login':
                $sql = "SELECT * FROM users WHERE username='".mysqli_real_escape_string($conn, $_GET['username'])."'";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) > 0){
                    $password = mysqli_real_escape_string($conn, $_GET['password']);
                    $result = mysqli_fetch_assoc($query);
                    if(password_verify($password, $result['password'])){
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $_GET['username'];
                        $json = array('code' => 200);
                        echo json_encode($json);
                        exit;
                    }else{
                        $json = array('code' => 404, 'error' => 'Incorrect Username or Password');
                        echo json_encode($json);
                        exit;
                    }
                }else{
                    $json = array('code' => 404, 'error' => 'Incorrect Username or Password');
                    echo json_encode($json);
                    exit;
                }

                break;
            case 'sign_up':
                $username = mysqli_real_escape_string($conn, $_GET['username']);
                $password = mysqli_real_escape_string($conn, $_GET['password']);
                $password_verify = mysqli_real_escape_string($conn, $_GET['password_verify']);
                $email = mysqli_real_escape_string($conn, $_GET['email']);
                $f_name = mysqli_real_escape_string($conn,  $_GET['f_name']);
                $l_name = mysqli_real_escape_string($conn, $_GET['l_name']);

                if($password != $password_verify){
                    $json = array('code' => 404, 'error' => "Your passwords do not match.");
                    echo json_encode($json);
                    exit;
                }

                $sql = "SELECT * FROM users WHERE username='".$username."'";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) > 0){
                    $json = array('code' => 404, 'error' => 'Username Taken.');
                    echo json_encode($json);
                    exit;
                }


                $sql = "INSERT INTO users (f_name, l_name, username, email, password) VALUES ('".$f_name."','".$l_name."','".$username."','".$email."','".password_hash($password, PASSWORD_BCRYPT)."')";
                $query = mysqli_query($conn, $sql);
                if(!$query){
                    $json = array('code' => 404, 'error' => mysqli_error($conn));
                    echo json_encode($json);
                    exit;
                }else{
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    $json = array('code' => 200);
                    echo json_encode($json);
                    exit;
                }
                break;

            default:

                break;
        }
    }
}else{
    if($_GET['action'] == 'logout'){
        session_destroy();
        header("Location: /");
    }
}

    include "includes/php/header.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="/favicon.png?v=1"/>
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
<body>
<h1 id="welcome" class="title">Welcome to Mines of MIDIa.</h1>
    <div id="content">

        <div id="icons">
            <img class="icon" id="upload_icon" src="includes/images/upload.png">
            <img class="icon" src="includes/images/right.png">
            <img class="icon" src="includes/images/search.png">
            <img class="icon" src="includes/images/right.png">
            <img class="icon" src="includes/images/drum.png">
        </div>
        <div id="icon_text">
            <h3 class="icon_text">Upload a MIDI file</h3>
            <h3 class="icon_text">Search for a Spotify song</h3>
            <h3 class="icon_text">Drum away!</h3>
        </div>
    </div>
    <div class="info">
        <div class="info_item left">
            <h1 class="title">Visual Drumming</h1>
            <p>Mines of MIDIa is a revolutionary tool for drummers of all skill sets to learn to play new songs the way the pros do. With a virtual drum kit that plays back any song exactly as written, you can learn any song quickly and accurately.</p>
        </div>
        <img src="/includes/images/drum.png" class="info_image right">
    </div>
    <div class="info">
        <div class="info_item right">
            <h1 class="title">Spotify Matching</h1>
            <p>With the ability to match your files up with a Spotify track, you can be sure your song is playing at the right tempo. </p>
        </div>
        <img src="/includes/images/spotify.png" class="info_image left">
    </div>
    <div class="info">
        <div class="info_item left">
            <h1 class="title">Ensuring Accuracy</h1>
            <p>Mines of MIDIa has a voting system to ensure the uploaded files are accurate. If you come across a high quality file, give it an upvote so more drummers can learn it. If it is inaccurate, give it a downvote.</p>
        </div>
        <img src="/includes/images/target.png" class="info_image right">
    </div>
    <div id="get_started">
        <h1 id="get_started_title" class="title">Get Started Today!</h1>
        <a href="/login.php"> <button id="signup_start">Sign Up</button></a>
        <a href="/login.php"><button id="login_start">Login</button></a>
    </div>
</body>
</html>
    <?php
    include "includes/php/footer.php";

