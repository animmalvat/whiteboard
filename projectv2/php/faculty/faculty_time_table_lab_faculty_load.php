<?php
require('../faculty.php');
require('../db_config.php');
require('../user.php');
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/projectv2/php/user_login_page.php");
} else {
    $semester = $_GET['semester'];
    $division = $_GET['division'];
    $subject  = $_GET['subject'];
    $faculty  = $_SESSION['faculty'];
    $branch   = $faculty->getBranch();
    $batch = $_GET['batch'];
    
    if (isset($_GET['id'])) {
        //find faculties that have already lecture somewhere
        $d_id      = $_GET['id'];
        $lecture = $d_id[0];
        $day     = ((int)substr($d_id, 1)/2) - 1;
        echo $lecture;
        echo $day;
        $sql     = "select * from schedule where lecture = '$lecture' and day = '$day'";
        if ($results1 = $conn->query($sql)) {
            $i = 0;
            while($r = $results1->fetch_assoc()) {
                $f_id[$i]['user_id'] = $r['user_id'];    
                $f_id[$i]['class'] = $r['semester']."".$r['division'];
                $i++;
            }
            
            
            $sql = "select * from (select lab_subjects_assigned.*, lab_subjects.subject_id, user.firstname, user.lastname from lab_subjects_assigned inner join lab_subjects on lab_subjects_assigned.lab_id = lab_subjects.id inner join user on user.id = lab_subjects_assigned.user_id) as d where subject_id = '$subject' and division = '$division' and semester = '$semester' and branch = '$branch' and batch = '$batch'";
            if ($results = $conn->query($sql)) {
                while ($row = $results->fetch_assoc()) {
                    $name      = $row['firstname'][0] . " " . $row['lastname'][0];
                    $full_name = $row['firstname'] . " " . $row['lastname'];
                    $id        = $row['user_id'];
                    $temp = 0;
                    foreach($f_id as $value) {
                        if($id == $value['user_id']) {
                            $title = $full_name." already lecture in ".$value['class'];
                            echo "<option disabled='true' value = '$id' title='$title'>";
                            echo $name;
                            echo "</option>"; 
                            $temp = 1;
                            break;
                        }
                    }
                    if($temp ==0) {
                        echo "<option value = '$id' title='$full_name'>";
                        echo $name;
                        echo "</option>";
                    }
                    
                }
            }
        }
    } else {
        $sql = "select * from (select lab_subjects_assigned.*, lab_subjects.subject_id, user.firstname, user.lastname from lab_subjects_assigned inner join lab_subjects on lab_subjects_assigned.lab_id = lab_subjects.id inner join user on user.id = lab_subjects_assigned.user_id) as d where subject_id = '$subject' and division = '$division' and semester = '$semester' and branch = '$branch' and batch = '$batch'";
        if ($results = $conn->query($sql)) {
            while ($row = $results->fetch_assoc()) {
                $name      = $row['firstname'][0] . " " . $row['lastname'][0];
                $full_name = $row['firstname'] . " " . $row['lastname'];
                $id        = $row['user_id'];
                echo "<option value = '$id' title='$full_name'>";
                echo $name;
                echo "</option>";
            }
        }
        
    }
}

?>