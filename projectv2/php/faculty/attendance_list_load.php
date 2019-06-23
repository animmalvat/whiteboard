<?php
    require('../db_config.php');
    require('../user.php');
    session_start();
    $semester = $_POST['semester'];
    $division = $_POST['division'];
    $sid = $_POST['s'];
    $date_picker = $_POST['date_picker'];
    $lecture = $_POST['lecture'];
    
    $sql = "select * from(select attendance.*, user.firstname, user.lastname, student.enrolment from attendance inner join student on attendance.user_id = student.user_id inner join user on user.id = attendance.user_id where semester = '$semester' and division = '$division' and lecture = '$lecture' and `date` = '$date_picker' and subject_id = '$sid') as t order by enrolment";
    
    if($results=$conn->query($sql)) {
        if($results->num_rows>0) {
                echo "Record Already Exists";
                echo "<form action='http://localhost/projectv2/php/faculty/attendance_upload.php' method='post'>";
            
                echo "<input type='hidden' name='semester' value='$semester'>";
                echo "<input type='hidden' name='division' value='$division'>";
                echo "<input type='hidden' name='date_picker' value='$date_picker'>";
                echo "<input type='hidden' name='subject_id' value='$sid'>";
                echo "<input type='hidden' name='lecture' value='$lecture'>";
                echo "<input type='hidden' name='edited' value='yes'>";
                while($row = $results->fetch_assoc()) {
                    $id = $row['user_id'];
                        
                        if($row['present']) {
                            echo "<label> <input type=checkbox checked name='$id'> ";    
                        } else {
                            echo "<label> <input type=checkbox name='$id'> ";
                        }
                        
                        echo $row['enrolment'];
                        echo " ";
                        echo $row['firstname'];
                        echo " ";
                        echo $row['lastname'];
                        echo "</label>";
                        echo "<br>";
                }
                    echo "<input type=submit value=submit>";
                    echo "</form>";
            } else {
                $sql = "select firstname, lastname, enrolment, student.user_id as sid from student inner join user on user.id = student.user_id inner join class on student.class_id = class.id where semester = '$semester' and division = '$division' order by enrolment";
                echo "<form action='http://localhost/projectv2/php/faculty/attendance_upload.php' method='post'>";
                
                echo "<input type='hidden' name='semester' value='$semester'>";
                echo "<input type='hidden' name='division' value='$division'>";
                echo "<input type='hidden' name='date_picker' value='$date_picker'>";
                echo "<input type='hidden' name='subject_id' value='$sid'>";
                echo "<input type='hidden' name='lecture' value='$lecture'>";
        
                if($results = $conn->query($sql)) {
                    if($results->num_rows>0) {
                    while($row = $results->fetch_assoc()) {
                        $id = $row['sid'];
                        

                        echo "<label> <input type=checkbox name='$id'> ";
                        echo $row['enrolment'];
                        echo " ";
                        echo $row['firstname'];
                        echo " ";
                        echo $row['lastname'];
                        echo "</label>";
                        echo "<br>";
                    }
                    echo "<input class='but' type=submit value=submit>";
                    echo "</form>";
                }else {
                        echo "<br>";
                    echo "<span style='font-size: 18px;'>";
                    echo "there are students in this class yet";
                    echo "</span>";
                    echo "<br>";
                        echo "<br>";
                    echo "<a class='but' href='http://localhost/projectv2/php/faculty/faculty_attendance.php'> Go Back </a>";
                }
                
                } 
            
            }
        } else {
                echo "there was some error related to sql";
        }
    

    
?>
