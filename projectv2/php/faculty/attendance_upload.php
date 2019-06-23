<?php
    require('../user.php');
    require('../db_config.php');
    require('../faculty.php');
    session_start();
    
    if(!isset($_SESSION['user']) || !isset($_SESSION['faculty'])) {
        header("Location: http://localhost/projectv2/php/user_login_page.php");
    } else {
        $date = $_POST['date_picker'];
        echo $date;
        $semester = $_POST['semester'];
        $division = $_POST['division'];
        $sid = $_POST['subject_id'];
        $lecture = $_POST['lecture'];
        echo $sid;
        
        if(isset($_POST['edited'])) {
            $sql = "delete from attendance where semester = '$semester'' and division = '$division'' and subject_id = '$sid' and lecture = '$lecture'' and `date` = '$date'";
            if($results = $conn->query($sql)) {
                
            }
        }
        
        $sql = "select firstname, lastname, enrolment, student.user_id as sid from student inner join user on user.id = student.user_id inner join class on student.class_id = class.id where semester = '$semester' and division = '$division'";
        if($results = $conn->query($sql)) {
            $sql = "";
            while($row = $results->fetch_assoc()) {
                $id = $row['sid'];
                if(isset($_POST[$id])) {
                    $sql.= "insert into attendance(date, user_id, present, subject_id, semester, division, lecture) values ('$date', $id, TRUE , '$sid', '$semester', '$division', '$lecture');";
                } else {
                    $sql.= "insert into attendance(date, user_id, present, subject_id, semester, division, lecture) values ('$date', $id, FALSE , '$sid', '$semester', '$division', '$lecture');";
                }
            }
            if($conn->multi_query($sql)) {
                echo "done";
                $msg = "attendance was uploaded";
                echo "<script type='text/javascript'> alert('$msg');";
                echo "window.location = 'http://localhost/projectv2/php/faculty/faculty_attendance.php'; </script>";
                
            }
        }
    }
?>
