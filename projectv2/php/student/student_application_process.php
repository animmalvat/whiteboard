<?php
    require('../db_config.php');
    require('../user.php');
    require('../student.php');
    session_start();

    $student = $_SESSION['student'];

    //check if session exists or not
    if(isset($_SESSION['user'])) {
        
    } else {
        echo "first login you idiot";
        header("Location: http://localhost/projectv2/php/user_login_page.php");
    }

    //check if the variables are set 
    if(isset($_POST['title']) && isset($_POST['description'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $user = $_SESSION['user'];
        $user_id = $user->getId();
        
        $date = date('Y/m/d');
        $date_file_name = date('Y-m-d');
        
        //check if user has uploaded something or not
        if(file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])) {
            //uploaded some attachment
            //setting file name for proper organisation
            $file_name = $user_id."".$title."".$date_file_name;
            
            //getting extention for further using it
            $file = new SplFileInfo($_FILES['attachment']['name']);
            $ext =  $file->getExtension();
            
            //moving file 
            move_uploaded_file($_FILES['attachment']['tmp_name'], "../../application/".$file_name.".".$ext);
            $file_name = $file_name.".".$ext;
            $sql = "insert into application(user_id, title, description, date, file_name) values('$user_id', '$title', '$description', '$date', '$file_name')";
        } else {
            //not uploaded anything
            $sql = "insert into application(user_id, title, description, date) values('$user_id', '$title', '$description', '$date')";
        }
        
        if($conn->query($sql)) {
            echo "the application was uploaded";
            //mail cc for further approval
            $name = $user->getFirstName();
            $name .= $user->getLastName();
            $email = $user->getEmail();
            
            $msg = "Application : \n";
            $msg.= "Student : $name \n";
            $msg.= "email : $email \n" ;
            $msg.= "Title: $title \n";
            $msg.= "Description: $description \n";
            
            
            $cc_id = $student->getCC();
            $sql = "select * from user where id = '$cc_id'";
            if($results = $conn->query($sql)) {
                $row = $results->fetch_assoc();
                $to = $row['email'];
                $subject = "White Board Application";
                $headers = "From: anim@whiteboard.com";
                mail($to, $subject, $msg, $headers);
            } else {
                echo "something went wrong";
            }
            header("Location: http://localhost/projectv2/php/student/student_application.php");
            
            
        } else {
            //redirect so user can try again
            echo "the application was not uploaded";
        }
    } else {
        header("Location: http://localhost/projectv2/php/student/student_application.php");
    }
?>