<?php
    include('user.php');
    include('db_config.php');
    include('crypt.php');
    
    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['contact'])
      && isset($_POST['email']) && isset($_POST['password']) ) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = encryption($password);
        $contact = $_POST['contact'];
        
        //check for already existing record
        $sql = "select * from user where email = '".$email."'";
        $results = $conn->query($sql);
        if($results->num_rows > 0) {
            //error
            echo "already existing user";
            header("Location: http://localhost/projectv2/php/user_registration_page.php?error_msg=User Already Exists.");
        } else {
            $activation_code = md5(rand());
            $sql = "insert into user(firstname, lastname, email, password, activation_code, contact)
            values ('$firstname', '$lastname', '$email', '$password', '$activation_code', '$contact')";
            if($conn->query($sql)) {
                //successful 
                //redirect to login page with success message
                echo "successful";
                sendVerificationMail($activation_code, $email);
                header("Location: http://localhost/projectv2/php/user_login_page.php?error_msg=Registration Successful, Please verify email.");
            } else {
                //some error occurred
                //redirect to registration page with error
                echo "some error occurred.";
                header("Location: http://localhost/projectv2/php/user_registration_page.php?error_msg=some problem occured.");
            }
            
        }
    } else {
        header("Location: http://projectv2/php/user_registration_page.php?error_msg=Sorry, There was
        some error.");
    }

    function sendVerificationMail($activation_code, $email) {
        $msg = "Please Verify your email id by clicking below link : \n";
        $msg.= "http://localhost/projectv2/php/verify.php?activation_code=".$activation_code."&email=".$email;
        $to = $email;
        $subject = "White Board Email Verification";
        $headers = "From: anim@whiteboard.com";
        mail($to, $subject, $msg, $headers);
    }

   
?>