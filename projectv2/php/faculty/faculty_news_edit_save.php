<?php
    require('../db_config.php');
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['date']) ) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        
        $id = $_POST['id'];
        $sql = "update news set title = '$title', date ='$date', description = '$description' where id = '$id'";
        if($conn->query($sql)) {
            echo "done".$sql;
            echo "<br>";
            echo $id;
            echo '<script type="text/javascript">';
            echo 'alert("News was updated");';
            echo 'window.location="http://localhost/projectv2/php/faculty/faculty_news_view.php";';
            echo '</script>';
            
        } else {
            echo "not done".$sql;
        }
    } else {
        echo "what the hell man";
    }
?>