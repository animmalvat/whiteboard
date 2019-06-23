<?php
require('../db_config.php');
require('../student.php');
require('../user.php');
session_start();
$user = $_SESSION['user'];
$user_id = $user->getId();
$sql = "select * from attendance where user_id = '$user_id'";
if($result = $conn->query($sql)) {
    $total = $result->num_rows;
    $present = 0;
    while($row = $result->fetch_assoc()) {
        if($row['present']) {
            $present++;
        }
    }
    echo $present/$total*100;
} else{
    //problem encountered
}
?>