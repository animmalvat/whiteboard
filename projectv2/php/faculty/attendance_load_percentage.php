<?php
require('../db_config.php');
$sql = "select * from attendance where user_id = 18";
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
