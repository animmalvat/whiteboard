<?php
    require('../db_config.php');
    require('../user.php');
    require('../faculty.php');
    session_start();
    if(!isset($_SESSION['faculty'])) {
        header("location: http://localhost/projectv2/php/user_login.page.php");
    }
    echo $_GET['semester'];
    echo $_GET['division'];

    $semester = $_GET['semester'];
    $division = $_GET['division'];
    $branch = $_SESSION['faculty']->getBranch();
    $sql = "delete from schedule where semester = '$semester' and division = '$division' and branch = '$branch'";
    if($conn->query($sql)) {
    } else {
        header("Location: http://localhost/projectv2/php/faculty/faculty_time_table.php");
    }
    $sql ="";
    for($j=1;$j<12;$j+=2) {
        $day = floor($j/2);
        for($i = 1;$i <= 6; $i++) {
            $lecture = $i;
            
            
            
            
            if(isset($_POST['s'.$i.$j]) && isset($_POST['s'.$i.($j+1)])) {
                $subject_id = $_POST['s'.$i.$j];
                $user_id = $_POST['s'.$i.($j+1)];
                
            } else {
                echo "defined nahi hai";
                $sql = "error";
                break 2;
            }
            
            //check if the subject was lab 
            if($subject_id == 'lab') {
                //if it was lab
                //fetch the lab id and batch 
                $lab_id = $_POST['ls'.$i.$j];
                $batch = $_POST['lsb'.$i.$j];
                $sql.="insert into schedule(user_id, subject_id, lecture, day, semester, division, branch, lab_id, batch) value('$user_id', '-1', '$lecture', '$day','$semester', '$division', '$branch', '$lab_id', '$batch');";
            } else {
                $sql.= "insert into schedule(user_id, subject_id, lecture, day, semester, division, branch) value('$user_id', '$subject_id', '$lecture', '$day','$semester', '$division', '$branch');";    
            }
    
            
        }  
        
    }
    if(strcmp($sql, "error") == 0) {
        echo "<script> alert('you must select proper subjects and faculties'); window.location = 'http://localhost/projectv2/php/faculty/faculty_time_table.php'</script>";
        
    }
    else if($result = $conn->multi_query($sql)) {
        echo "done";
        $semester=$_GET['semester'];
        $division=$_GET['division'];
        sleep(2);
        header("Location: http://localhost/projectv2/php/faculty/faculty_time_table_view_tt.php?semester=".$semester."&division=".$division);
    } else {
        echo $sql." there was some problem";
        echo "\n";
        echo $result;
    }
    
?>