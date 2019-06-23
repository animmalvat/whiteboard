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
            
            
            $sql = "select * from (select subject.*, assigned_subject.semester as sem, assigned_subject.division, user.id as uid, user.firstname, user.lastname from assigned_subject inner join subject on assigned_subject.subject_id = subject.id inner join user on assigned_subject.faculty_id = user.id) as ss where ss.sem = '$semester' and branch = '$branch' and id = '$subject' and division = '$division';";
            if ($results = $conn->query($sql)) {
                while ($row = $results->fetch_assoc()) {
                    $name      = $row['firstname'][0] . " " . $row['lastname'][0];
                    $full_name = $row['firstname'] . " " . $row['lastname'];
                    $id        = $row['uid'];
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
        $sql = "select * from (select subject.*, assigned_subject.semester as sem, assigned_subject.division, user.id as uid, user.firstname, user.lastname from assigned_subject inner join subject on assigned_subject.subject_id = subject.id inner join user on assigned_subject.faculty_id = user.id) as ss where ss.sem = '$semester' and branch = '$branch' and id = '$subject' and division = '$division';";
        if ($results = $conn->query($sql)) {
            while ($row = $results->fetch_assoc()) {
                $name      = $row['firstname'][0] . " " . $row['lastname'][0];
                $full_name = $row['firstname'] . " " . $row['lastname'];
                $id        = $row['uid'];
                echo "<option value = '$id' title='$full_name'>";
                echo $name;
                echo "</option>";
            }
        }
        
    }
}

?>