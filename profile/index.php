<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 11/2/16
 * Time: 10:38 AM
 */


include "../includes/php/base.php";
include "../includes/php/general.php";

if(!$_SESSION['logged_in']){
    header("Location: /");
}

$action = $_GET['action'];
if($action != ''){
    switch($action){
        case 'change_image':
            $sql = "UPDATE users SET image='".$_GET['image_file']."' WHERE username='".$_SESSION['username']."'";
            $query = mysqli_query($conn, $sql);

            if(!$query){
                $json = array('code' => 404);
                echo json_encode($json);
                exit;
            }

            $json = array('code' => 200, 'image' => $_GET['image_file']);
            echo json_encode($json);
            exit;

            break;
        case 'upload_image':
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/user_images/";
            $target_file = $_SESSION['username'].".jpg";
            $fileType = pathinfo($target_file,PATHINFO_EXTENSION);

            if ( 0 < $_FILES['image_file']['error']  || pathinfo($target_file,PATHINFO_EXTENSION) != 'jpg') {
                echo 'ERROR UPLOADING FILE';
            } else {
                if(!file_exists($target_dir.$target_file)){
                    if(move_uploaded_file($_FILES['image_file']['tmp_name'], $target_dir.$target_file)){
                        echo $target_file;
                    }else{
                        echo "ERROR UPLOADING FILE";
                    }
                }else{
                    $count = 0;
                    $temp = basename($target_file, ".jpg");

                    while(file_exists($_SERVER['DOCUMENT_ROOT']."/user_images/".$temp.".jpg")){
                        $count++;
                        $temp = basename($target_file, ".jpg")."_".$count;
                    }
                    $target_file = $temp.".jpg";

                    move_uploaded_file($_FILES['image_file']['tmp_name'], "../user_images/".$target_file);
                    $sql = "UPDATE users SET image='".$target_file."' WHERE username='".$_SESSION['username']."'";
                    $query = mysqli_query($conn, $sql);

                    echo $target_file;
                }

            }
            exit;
            break;
        case 'update_info':
            $f_name = mysqli_real_escape_string($conn, $_GET['f_name']);
            $l_name = mysqli_real_escape_string($conn, $_GET['l_name']);
            $email = mysqli_real_escape_string($conn, $_GET['email']);
            $sql = "UPDATE users SET f_name='".$f_name."', l_name='".$l_name."', email='".$email."' WHERE username='".$_SESSION['username']."'";
            $query = mysqli_query($conn, $sql);
            if(!$query){
                $json = array('code' => 404, 'error' => mysqli_error($conn));
                echo json_encode($json);
                exit;
            }

            $json = array('code' => 200, 'f_name' => $f_name, 'l_name' => $l_name, 'email' => $email);
            echo json_encode($json);
            exit;
            break;
        default:

            break;
    }
}

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

    <title>Profile | Drum It Down</title>
    <link rel="icon" type="image/x-icon" href="/favicon.png?v=3"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/includes/css/shared.css">
    <link rel="stylesheet" href="/includes/css/header.css">
    <link rel="stylesheet" href="/includes/css/footer.css">
    <script src="/includes/js/jquery-2.2.4.min.js" type="application/javascript"></script>

</head>
<?php
include "../includes/php/header.php";

$sql = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
$query = mysqli_query($conn, $sql);

$sql_likes = "SELECT COUNT(*) as count FROM upvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND active='yes'";
$query_likes = mysqli_query($conn, $sql_likes);
$likes_result = mysqli_fetch_assoc($query_likes);

$sql_dislikes = "SELECT COUNT(*) as count FROM downvotes WHERE user_id=(SELECT id FROM users WHERE username='".$_SESSION['username']."') AND active='yes'";
$query_dislikes = mysqli_query($conn, $sql_dislikes);
$dislikes_result = mysqli_fetch_assoc($query_dislikes);

if(mysqli_num_rows($query) > 0){
    $result = mysqli_fetch_assoc($query);
    ?>
    <body>
        <div class="grid">
            <div id="overall_user_info" class="item">
                <div id="user_image" style="background: url('/user_images/<?= $result['image'] ?>') center no-repeat; background-size: cover;">
                    <div id="image_overlay">
                        <h3>Click to Change Image</h3>
                    </div>
                </div>
                <h1 id="user_name"><?= $result['username'] ?></h1>
                <h2 id="member_since">Member since: <?= date('F Y',strtotime($result['created'])); ?></h2>
                <h3 id="liked_files">
                    <div><img src="/includes/images/upvote.png" class="like_icon"> <?= $likes_result['count']  ?></div>
                    <div><img src="/includes/images/downvote.png" class="like_icon"> <?= $dislikes_result['count']  ?></div>
                </h3>
            </div>
            <form id="change_info" class="item">
                <h1>Contact Information</h1>
                <div id="alert_div">
                    <h2 id="alert"></h2>
                </div>
                <div class="form_item"><h3>First Name: </h3>
                    <input type="text" placeholder="First Name" id="f_name" value="<?= $result['f_name']  ?>"><br>
                </div>
                <div class="form_item">
                    <h3>Last Name: </h3>
                    <input type="text" placeholder="Last Name" id="l_name" value="<?= $result['l_name']  ?>"><br>
                </div>
                <div class="form_item">
                    <h3>Email: </h3>
                    <input type="text" placeholder="Email" id="email" value="<?= $result['email']  ?>">
                </div>
                <input type="submit" value="Update Info" id="submit_user">
            </form>
        </div>
    <form id="change_image" hidden enctype="multipart/form-data" action="index.php">
        <input type="hidden" name="action" value="upload_image">
        <input type="hidden" name="image_val" id="image_val" value="<?= $result['image'] ?>">
        <div class="image_grid">
            <div class="image_choice" id="default.png" style="background: url('/user_images/default.png') center no-repeat; background-size: 100%;"></div>
            <div class="image_choice" id="default_1.png" style="background: url('/user_images/default_1.png') center no-repeat; background-size: 100%;"></div>
            <div class="image_choice" id="default_2.png" style="background: url('/user_images/default_2.png') center no-repeat; background-size: 100%;"></div>

        </div>
        <h2 id="splitter">Or</h2>
        <input type="file" name="image_file"  id="image_file">
        <button id="cancel_change">Cancel</button>
        <input type="submit" id="submit_change" value="Submit">
    </form>

    </body>

<?php
}else{
    ?>
    <body>
        <h1 id="no_user">No Info found for this user.</h1>
        <a href="/login.php"><button id="login_user_button">Login</button></a>

    </body>

<?php
}
?>
<script src="/includes/js/shared.js" type="application/javascript"></script>
<script>
    $('#change_info').submit(function(event){
        event.preventDefault();
        $.getJSON('/profile/index.php?action=update_info&f_name=' +$('#f_name').val() +'&l_name=' +$('#l_name').val()+ '&email=' + $('#email').val(), function(result){
            if(result.code == 200){
                $('#alert').html("Information Updated");
                $('#alert').removeClass('error');

            }else{
                $('#alert').html('Information Could not be updated');
                $('#alert').addClass('error');
            }
        });
    });
    $('#image_overlay').click(function(){
       $('#change_image').show();
    });
    $('#cancel_change').click(function(event){
        event.preventDefault();
        $('#change_image').hide();
    });

    $(".image_choice").click(function() {
        var hasit = false;
        if($(this).hasClass('selected_image')){
            hasit = true;
        }
        $('.image_choice').removeClass('selected_image');
        if(!hasit){
            $(this).addClass('selected_image');
            $('#image_val').val($(this).attr('id'));
        }
    });
    $('#change_image').submit(function(event){
        if($('#image_file').val() == ''){
            event.preventDefault();
            //TODO change image to default image
            $.getJSON('index.php?action=change_image&image_file='+$('#image_val').val(),function(result){
                if(result.code == 200){
                    $('#user_image').css('background', "url('/user_images/"+result.image+"') center no-repeat" );
                    $('#user_image').css('background-size', 'cover');
                    $('#user_icon').attr('src', '/user_images/'+result.image);
                    $('#change_image').hide();
                }
            });
        }else{
            event.preventDefault();
            upload_image();
        }
    });
</script>
</html>