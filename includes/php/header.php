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
        <a href="/browse/" class="header_link" id="browse">Browse</a>
        <a href="/upload/" class="header_link" id="upload">Upload</a>
        <a href="/?action=logout" class="header_link" id="logout">Logout</a>
        <a href="/" class="header_link" id="home_link">Home</a>
        <h2 id="drums_title">Drums, Drums in the deep.</h2>
    <?php
    }else{
        ?>
        <h1 id="header_title">Mines of MIDIa</h1>
        <a href="/browse/" class="header_link" id="browse_logged_out">Browse</a>
        <a href="/" class="header_link" id="login_link_header">Login</a>
        <h2 id="drums_title">Drums, Drums in the deep.</h2>

    <?php
    }
    ?>
</header>
