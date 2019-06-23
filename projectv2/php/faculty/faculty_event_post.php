<?php
    require('../db_config.php');
    require('../User.php');
    require('../faculty.php');
    
    //start the session first
    session_start();

    //check if the logged in user is faculty and user indeed
    if(!isset($_SESSION['user']) && !isset($_SESSION['faculty'])) {
        //error
        //redirect
    } else {
        //get the values from the form
        $date = $_POST['date'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $semester = $_POST['semester'];
        
        echo $date;
        echo $title;
        echo $description;
        echo $semester;
        //get the branch from faculty session variable
        $faculty = $_SESSION['faculty'];
        $branch = $faculty->getBranch();
        
        //construct sql statement
        $sql = "insert into event(title, description, semester, branch, deadline) values('$title', '$description', '$semester', '$branch', '$date')";
            
        //fire the query on conn object
        if($conn->query($sql)) {
            echo "event uploaded";
        } else {
            echo "event couldn't be uploaded";
        }
    }
?>