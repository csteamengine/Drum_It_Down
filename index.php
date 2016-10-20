<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:27 PM
 */

session_start();
include "includes/php/base.php";
include "includes/php/general.php";

$api = get_spotify_key();
$api = json_decode($api);



####################################################
###############   Preprocessing   ##################
####################################################


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mines of Midia</title>
    <link rel="icon" type="image/x-icon" href="includes/images/favicon.png" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="includes/css/shared.css">
    <link rel="stylesheet" href="includes/css/header.css">
    <link rel="stylesheet" href="includes/css/footer.css">
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "includes/php/header.php";
?>
<body>
    <div id="login">
        <a href="https://accounts.spotify.com/authorize/?client_id=246bfa3fab5c4e57935bf30f1627d2b0&response_type=code&redirect_uri=http://localhost:8888/login&scope=user-read-private%20user-read-email&state=34fFs29kd09">Login With Spotify</a>
    </div>
</body>

<?php
include "includes/php/footer.php";
?>
<script>

</script>
</html>
