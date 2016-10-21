<?php
/**
 * Created by PhpStorm.
 * User: adm_gcs
 * Date: 10/19/2016
 * Time: 4:54 PM
 */

####################################################
################ Preprocessing  ####################
####################################################

include "includes/php/base.php";

mysqli_select_db($conn, 'drumsinthedeep');
$sql = "SELECT * FROM users";
$query = mysqli_query($conn, $sql);



?>

<!DOCTYPE html>
<html>
<head>
    <title>Example PHP</title>
</head>
<body>
<?php
//We use a while loop to loop through each result.
//This is usefule, because it will not start if the result brings back 0 results.
while($result = mysqli_fetch_assoc($query)){
    example($result['username']);
    ?>
    <h1><?= $result['username']?></h1>
    <?php
}
?>

</body>
<script>
    //Some js code here!
</script>
</html>

<?php
#####################################################
################ PHP Functions ######################
#####################################################
function example($username){
    echo $username;
}