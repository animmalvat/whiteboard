<?php
    require('../db_config.php');
    if(isset($_GET['title']) && isset($_GET['description']) && isset($_GET['date'])) {
        $title = $_GET['title'];
        $description = $_GET['description'];
        $date = $_GET['date'];
        $sql = "insert into news (title, date, description) values ('$title', '$date', '$description')";
        if($conn->query($sql)) {
            echo "done".$sql;
            echo '<script type="text/javascript">';
            echo 'alert("News was saved");';
            echo 'window.location="http://localhost/projectv2/php/faculty/faculty_news.php";';
            echo '</script>';
            
        } else {
            echo "not done".$sql;
        }
    } else {
        echo "what the hell man";
    }
?>