<?php
    require('../db_config.php');
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['class'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $class = $_POST['class'];
        $id = $_POST['id'];
        $sql = "update pending_work set title = '$title', date ='$date', description = '$description', class_id = '$class' where id = '$id'";
        if($conn->query($sql)) {
            echo "done".$sql;
            echo "<br>";
            echo $id;
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