<?php
 $msg = "click below link for resetting: \n";
    
        $to = "malvat.anim0@gmail.com";
        $subject = "Reset You Password";
        $headers = "From: anim@whiteboard.com";
        if(mail($to, $subject, $msg, $headers)) {
            echo "mail sent";
        } else {
            echo "mail not sent";
        }

?>