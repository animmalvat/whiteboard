<?php

require('../db_config.php');
require('../faculty.php');
session_start();
$faculty = $_SESSION['faculty'];
$branch = $faculty->getBranch();

    $file = $_FILES['material']['name'];
    $file_size = $_FILES['material']['size'];
    $file_tmp = $_FILES['material']['tmp_name'];
    $type = $_FILES['material']['type'];
    $file = new SplFileInfo($file);
    $s = date('Y-d-m-h-i-s');
    
    $subject = $_POST['subject'];
    $s.="_";
    $s.=$subject;
    $s.="_";
    $s.=$branch;
    $s.="_";
    $title = $_POST['title'].".";
    $s.="_".$title;
    $s.=$file->getExtension();
    echo $file->getExtension();
    echo "<br>";
    echo $file_size;
    echo "<br>";
    echo $s;
    echo "<br>";
    
    echo $file_tmp;
    if(move_uploaded_file($_FILES['material']['tmp_name'], "../../documents/".$s)) {
        echo "uploaded";
        //header("Location: http://localhost/projectv2/php/faculty/faculty_home.php");
        } else {
        echo "not uploaded";
    }
header("Location: http://localhost/projectv2/php/faculty/faculty_subject_material.php");

?>