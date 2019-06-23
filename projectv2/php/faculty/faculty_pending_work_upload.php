<?php
    require('../db_config.php');
    if(isset($_GET['title']) && isset($_GET['description']) && isset($_GET['date']) && isset($_GET['class'])) {
        $title = $_GET['title'];
        $description = $_GET['description'];
        $date = $_GET['date'];
        $class_str = $_GET['class'];
        $class_str = explode("-", $class_str);
        $class = $class_str[0];
        $subject_name = $class_str[1];
        $sql = "insert into pending_work (title, date, description, class_id, subject_name) values ('$title', '$date', '$description', '$class', '$subject_name')";
        if($conn->query($sql)) {
            echo "done".$sql;
            echo '<script type="text/javascript">';
            echo 'alert("Pending Work was saved");';
            echo 'window.location="http://localhost/projectv2/php/faculty/faculty_pending_work_view.php";';
            echo '</script>';
            
        } else {
            echo "not done".$sql;
        }
    } else {
        echo "what the hell man";
    }
?>