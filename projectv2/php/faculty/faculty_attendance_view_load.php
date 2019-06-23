<?php
    require('../db_config.php');
    require('../user.php');
    session_start();
    $semester = $_POST['semester'];
    $division = $_POST['division'];
    $sid = $_POST['s'];
    $date_picker = $_POST['date_picker'];
   
    $lecture = $_POST['lecture'];
    
    $sql = "select * from (select attendance.*, user.firstname, user.lastname, student.enrolment from attendance inner join user on user.id = attendance.user_id inner join student on user.id = student.user_id where semester='$semester' and division = '$division' and  lecture ='$lecture' and date='$date_picker') as t order by enrolment, date";
    
    if($results = $conn->query($sql)) {
        if($results->num_rows>0) {
            echo "<div id='table_container'>";
    echo "<div id='divtable'>";
        echo "<table>";
        $i = 1;
        echo "<tr>";
        echo "<th class='headcol'>";
        echo "Names";
        echo "</th>";
        $temp = 1;

        while($row = $results->fetch_assoc()) {
            
            if($temp == 1) {
                $date1 = $row['date'];
            }
            
            if($temp != 1) {
                if($date1==$row['date']) {
                    break;
                }
            }
            
            $temp =0;
            echo "<td >";
            echo $row['date'];
            echo "</td>";
        }
        echo "</tr>";
        mysqli_data_seek($results, 0);
        while($row = $results->fetch_assoc()) {
            if($i == 1) {
                $date = $row['date'];
            }
            
            if($date == $row['date']) {
                if($i==0) {
                    echo "</tr>";
                }
                echo "<tr>";    
                echo "<th class='headcol'>";
                echo $row['enrolment'];
                echo "</th>";
            }
            echo "<td>";
            if($row['present']) {
                echo "P";
            } else {
                echo "A";
            }
            echo "</td>";
        
            $i = 0;
            
            
        }
        echo "</table>";
        
    } else {
        echo "<span style='font-size:18px'>There is no attendance uploaded </span>";
    } }
echo "</div>";
echo "</div>";
    
?>