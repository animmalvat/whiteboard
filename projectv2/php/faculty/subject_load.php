<?php
    require('../faculty.php');
    require('../db_config.php');
    require('../user.php');
    session_start();
    $lab_not_selected = $_GET['lab_not_selected'];
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost/projectv2/php/user_login_page.php");
    } else {
        $semester = $_GET['semester'];
        $faculty = $_SESSION['faculty'];
        $branch = $faculty->getBranch();
        $sql = "select * from subject where semester = '$semester' and branch = '$branch'";
        if($results = $conn->query($sql)) {
            while($row = $results->fetch_assoc()) {
                $name = $row['name'];
                $id = $row['id'];
                echo "<option value = '$id'>";
                echo $name;
                echo "</option>";
            }
        }
        
        if($lab_not_selected) {
            echo "<option value='lab'>";
            echo "Lab";
            echo "</option>";    
        }
        
    }
?>