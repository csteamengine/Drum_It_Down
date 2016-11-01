<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 11/1/16
 * Time: 2:51 PM
 */
include "includes/php/base.php";

$sql = "SELECT count(*) as count FROM upvotes WHERE file_id=24 AND active = 'yes'";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
echo "Count -- ".$result['count'];
exit;