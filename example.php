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

$sql = "SELECT * FROM users";
$query = mysqli_query($conn, $sql);
while($result = mysqli_fetch_assoc($query)){
    echo $result['username'];
}

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
<h1>Hello World!</h1>
</body>
<script>
    //Some js code here!
</script>
</html>

<?php
#####################################################
################ PHP Functions ######################
#####################################################
function example(){
    echo "This is an example function";
}