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


                $sql = "INSERT INTO users (f_name, l_name, username, password) VALUES ('".$f_name."','".$l_name."','".$username."','".password_hash($password, PASSWORD_BCRYPT)."')";
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

?>
<?php
if($_SESSION['logged_in']){
    include "includes/php/header.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="favicon.png?v=3"/>
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
    <div id="content">
        <h1>Welcome to Mines of MIDIa.</h1>
        <h3>Add some information about what the website does, and how to use it.</h3>
        <h3>Give an introduction on what steps to take, and blah blah blah</h3>
        <h3>Created by a bunch of cool geniuses and what not.</h3>
    </div>
    <div id="links">
        <a id="upload_link" href="/upload/">Upload a new track</a>
        <a id="browse_link" href="/browse/">Browse existing tracks</a>
    </div>
</body>
</html>
    <?php
    include "includes/php/footer.php";
}else{
    include "includes/php/header.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mines of Midia</title>
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <link rel="icon" type="image/x-icon" href="favicon.png?v=3"/>
    <link rel="stylesheet" href="includes/css/login.css">
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
    <body>
    <div id="overlay"></div>
    <form id="login" action="/" class="shown">
        <h1>Login</h1>
        <h3 id="alert_login"></h3>
        <input id="username" type="text" placeholder="Username" >
        <input type="password" id="password" placeholder="Password">
        <input type="submit" id="submit_login" value="Login">
        <h4 class="login_links" id="signup_link">New to Mines of MIDIa? Sign Up Now!</h4>
    </form>

    <form id="signup" class="">
        <h1>Sign Up</h1>
        <h3 id="alert_signup"></h3>
        <input id="username_signup" type="text" placeholder="Username" >
        <input id="f_name" type="text" placeholder="First Name">
        <input id="l_name" type="text" placeholder="Last Name">
        <input type="password" id="password_signup" placeholder="Password">
        <input type="password" id="password_verify" placeholder="Confirm Password">
        <input type="submit" value="Sign Up" id="submit_signup">
        <h4 class="login_links" id="login_link">Already have an account? Login Now!</h4>

    </form>
    </body>
</html>
    <?php
    include "includes/php/footer.php";
}
?>
<script>
    $('#login').submit(function(event){
        event.preventDefault();
        var alert = $('#alert_login');
        alert.html('');
        var username = $('#username').val();
        var password = $('#password').val();
        if(username != "" && password != ""){
            $.getJSON('index.php?action=login&username='+username+'&password='+password,function(json){
                if(json.code != 200){
                    alert.html(json.error);
                }else{
                    window.location.reload();
                }
            });
        }else{
            alert.html('Username and Password cannot be blank.');
        }
    });
    $('#signup').submit(function(event){
        event.preventDefault();
        var alert = $('#alert_signup');
        alert.html('');
        var username = $('#username_signup').val();
        var password = $('#password_signup').val();
        var password_confirm = $('#password_verify').val();
        var f_name = $('#f_name').val();
        var l_name = $('#l_name').val();
        if(username != "" && password != "" && password_confirm != "" && password == password_confirm){
            $.getJSON('index.php?action=sign_up&username='+username+'&password='+password+'&password_verify='+password_confirm+'&f_name='+f_name+'&l_name='+l_name,function(json){
                if(json.code != 200){
                    alert.html(json.error);
                }else{
                    window.location.reload();
                }
            });
        }else{
            if(username == ""){
                alert.html('Username and Password cannot be blank.');
            }else if(password == ""){
                alert.html('Username and Password cannot be blank.');
            }else if(password != password_confirm){
                alert.html('Passwords do not match.');
            }
        }
    });
    $('#signup_link').click(function(){
        $('#signup').addClass('shown');
        $('#login').removeClass('shown');
    });
    $('#login_link').click(function(){
        $('#signup').removeClass('shown');
        $('#login').addClass('shown');
    });
</script>