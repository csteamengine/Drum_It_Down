<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:50 PM
 */

?>

<header>
    <?php
    if($_SESSION['logged_in']){
        ?>
        <h1 id="header_title">Mines of MIDIa</h1>
        <a href="/browse/" class="header_link logged_in" id="browse">Browse</a>
        <a href="/upload/" class="header_link" id="upload">Upload</a>
        <p id="header_username"><?= $_SESSION['username'] ?></p>
        <a href="/" class="header_link" id="home_link">Home</a>
        <h2 id="drums_title">Drums, Drums in the deep.</h2>
        <img src="/includes/images/user.png" id="user_icon">
        <div id="header_dropdown" hidden>
            <a href="/profile/" class="dropdown_link">Profile</a>
            <a href="/?action=logout" class="dropdown_link">Logout</a>
        </div>
    <?php
    }else{
        ?>
        <h1 id="header_title">Mines of MIDIa</h1>
        <a href="/browse/" class="header_link" id="browse_logged_out">Browse</a>
        <?php
        if(strpos(basename($_SERVER['PHP_SELF']), 'login.php') !== false){
            ?>
            <a href="/" class="header_link" id="login_link_header">Home</a>
            <?php
        }else{
            ?>
            <a href="/login.php" class="header_link" id="login_link_header">Login</a>
            <?php
        }
        ?>
        <h2 id="drums_title">Drums, Drums in the deep.</h2>

    <?php
    }
    ?>
</header>
<script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

<script>
    var dropdown = $("#header_dropdown");
    var username_header = $('#header_username');
    var user_icon = $('#user_icon');
    $(document).mouseup(function (e)
    {
        if (!(dropdown.is(e.target) || username_header.is(e.target) || user_icon.is(e.target)) // if the target of the click isn't the container...
            && dropdown.has(e.target).length === 0) // ... nor a descendant of the container
        {
            dropdown.hide();
        }
    });

    username_header.click(function(){
        dropdown.toggle();
    });
    user_icon.click(function(){
        dropdown.toggle();
    });
</script>