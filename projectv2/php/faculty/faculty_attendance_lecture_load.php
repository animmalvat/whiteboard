<?php
    require('../db_config.php');
    require('../user.php');
    session_start();
    $semester = $_POST['semester'];
    $division = $_POST['division'];
    $sid = $_POST['s'];
    $date_picker = $_POST['date_picker'];
    
    $dt = strtotime($date_picker);
    $day = date('N', $dt);
    $day -= 1;
    $sql = "select * from schedule where semester = '$semester' and division ='$division' and subject_id = '$sid' and day ='$day'";


    if($results = $conn->query($sql)) {
        if($results->num_rows <= 0) {
            echo "<option> There isn't any lecture </option>"   ;
        } else {
            while($row = $results->fetch_assoc()) {

                echo "<option value=";
                echo $row['lecture'];
                echo ">";
                echo $row['lecture'];
                echo "</option>";

            }    
        }
    }
    
?>