<?php
    require('db_config.php');
    require('User.php');
    require('hod.php');
    require('faculty.php');
    require('student.php');
    
    //first start the session
    session_start();

    //then load data
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $user_id = $user->getId();
        
        if(!file_exists($_FILES['profile_photo']['tmp_name'])){
            //there was some error
            //maybe redirect
            echo "there was some error in profile photo";
        } else {
            $profile_photo = $_FILES['profile_photo']['name'];
            $file = new SplFileInfo($profile_photo);
            $ext = $file->getExtension();
            
            // check for the file to be jpg extension only
            if(strcmp($ext, 'jpg') == 0 || strcmp($ext, 'jpeg') == 0) {
                if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], "../profile/".$user_id.".jpeg")) {
                    echo "upload complete";
                    if(isset($_SESSION['hod'])) {
                        echo "<script> alert('Profile Photo Uploaded'); </script>";
                        header('Refresh: 2, url= http://localhost/projectv2/php/hod/hod_home.php');
                    } else if(isset($_SESSION['faculty'])) {
                        header('Location: http://localhost/projectv2/php/faculty/faculty_home.php');
                    } else if(isset($_SESSION['student'])) {
                        header('Location: http://localhost/projectv2/php/student/student_home.php');
                        
                    }
                } else {
                    echo "upload failed";
                }
            } else {
                echo "please select jpg or jpeg file format only";
            }
        }
    } else {
        // no session variable for user 
        header('Location: http://localhost/projectv2/php/user_login_page.php');
    }
?>
