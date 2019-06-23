<?php
    require('../db_config.php');
    $approve = $_GET['approve'];
    $id = $_GET['id'];
    
    $sql = "select * from (select user.*, application.id as app_id, application.title, application.description, application.date from user inner join application on application.user_id = user.id) as t where app_id = '$id'";
    if($results = $conn->query($sql)) {
        $row = $results->fetch_assoc();
        //mailing back to the student for the approval
        $name = $row['firstname'];
        $name .= " ";
        $name .= $row['lastname'];
        $title = $row['title'];
        $description = $row['description'];
        
        $msg = "Application : \n";
        $msg.= "Student : $name \n";
        $msg.= "Title: $title \n";
        $msg.= "Description: $description \n";
        if($approve == 1) {
            $msg.= "your application was approved";
        } else {
            $msg.= "your application was not approved";            
        }
        $to = $row['email'];
        $subject = "White Board Application";
        $headers = "From: anim@whiteboard.com";
        mail($to, $subject, $msg, $headers);
           
    }
    

    $sql = "update application set approved ='$approve' where id = '$id'";
    if($conn->query($sql)) {
        $sql = "select user.*, application.id as app_id, application.title, application.description, application.date, application.approved, student.enrolment from user inner join application on application.user_id = user.id inner join student on user.id = student.user_id where approved = '2'";
        if($results = $conn->query($sql)) {
            echo "<table style=>";
            while($row = $results->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                echo $row['firstname'];
                echo " ";
                echo $row['lastname'];
                echo "</td>";

                echo "<td>";
                echo $row['enrolment'];
                echo "</td>";

                echo "<td>";
                echo $row['title'];
                echo "</td>";

                echo "<td style='overflow-y: scroll'>";
                echo $row['description'];
                echo "</td>";

                echo "<td>";
                echo $row['date'];
                echo "</td>";

                $id = $row['app_id'];

                echo "<td>";
                echo "<button value='$id' onclick='onApproveClick(event)'> approve </button>";
                echo "</td>";

                echo "<td>";
                echo "<button value='$id' onclick='onRejectClick(event)'> reject </button>";
                echo "</td>";

                echo "</tr>";
            }   
            echo "</table>";
            echo "<a href=http://localhost/projectv2/php/faculty/faculty_pending_work.php'> View All Applications</a>";
        }
    } else {
        echo "please try again later, we are facing some problems";
    }
?>
