<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 11/2/2016
 * Time: 8:27 AM
 */

include "includes/php/base.php";

if($_SESSION['logged_in']){
    header("Location: /");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Drum It Down</title>
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <link rel="icon" type="image/x-icon" href="/favicon.png?v=1"/>
    <link rel="stylesheet" href="includes/css/login.css">
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
    <body>
    <?php
    include "includes/php/header.php";

    ?>
    <div id="overlay"></div>
    <form id="login" action="/" class="shown">
        <h1>Login</h1>
        <h3 id="alert_login"></h3>
        <input id="username" type="text" placeholder="Username" >
        <input type="password" id="password" placeholder="Password">
        <input type="submit" id="submit_login" value="Login">
        <h4 class="login_links" id="signup_link">New to Drum It Down? Sign Up Now!</h4>
    </form>

    <form id="signup" class="">
        <h1>Sign Up</h1>
        <h3 id="alert_signup"></h3>
        <input id="username_signup" type="text" placeholder="Username" >
        <input id="f_name" type="text" placeholder="First Name">
        <input id="l_name" type="text" placeholder="Last Name">
        <input id="email" type="text" placeholder="Email">
        <input type="password" id="password_signup" placeholder="Password">
        <input type="password" id="password_verify" placeholder="Confirm Password">
        <input type="submit" value="Sign Up" id="submit_signup">
        <h4 class="login_links" id="login_link">Already have an account? Login Now!</h4>

    </form>
    </body>
</html>
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
                    window.location = "/";
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
        var email = $('#email').val();
        var f_name = $('#f_name').val();
        var l_name = $('#l_name').val();
        if(username != "" && email != "" && password != "" && password_confirm != "" && password == password_confirm){
            $.getJSON('index.php?action=sign_up&username='+username+'&email='+email+'&password='+password+'&password_verify='+password_confirm+'&f_name='+f_name+'&l_name='+l_name,function(json){
                if(json.code != 200){
                    alert.html(json.error);
                }else{
                    window.location.reload();
                }
            });
        }else{
            if(username == ""){
                alert.html('Username and Password cannot be blank.');
            }else if(email == ""){
                alert.html('Email cannot be blank.');
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