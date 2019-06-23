<?php
    require('db_config.php');
    require('crypt.php');
    $email = $_GET['email'];
    echo "$email";
    $password = $_POST['password'];
    $password = encryption($password);
    $sql = "update user set password = '$password' where email = '$email'";
    if($conn->query($sql)) {
        echo "thai gayu change";
        header('Location: http://localhost/projectv2/php/user_login_page.php');
    } else {
        echo "nai thayu ";
    }
?>