<?php
    require('../db_config.php');
    session_start();

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date('Y-m-d');
    $user_id = $_POST['faculty'];
    
    $sql = "insert into feedback(title, description, date, user_id) values('$title', '$description', '$date', '$user_id')";
    if($conn->query($sql)) {
        echo "done";
    } else {
        echo "not done";
    }
    
    echo "<a href='http://localhost/projectv2/php/student/student_feedback.php'> Go back </a>";
?>