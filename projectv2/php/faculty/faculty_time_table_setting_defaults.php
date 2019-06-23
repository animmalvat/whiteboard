<?php
    require('../db_config.php');
    if(isset($_GET['semester']) && isset($_GET['division'])){
        $semester = $_GET['semester'];
        $division = $_GET['division'];
        $sql = "select * from (SELECT * FROM schedule where semester = '$semester' and division = '$division') as c inner join subject on subject.id = c.subject_id inner join user on user.id = c.user_id order by lecture, day";
        if($results = $conn->query($sql)) {
            
            //counters for the array
            $i=0;
            $j=0;
            
            while($row = $results->fetch_assoc()) {
                
                
                    $data[$j][$i] = $row['subject_id'];
                    
                    $i++;
                    $data[$j][$i] = $row['user_id'];
                    $i++;
                    if($row['day']==5) {
                        $j++;   
                        $i=0;
                    }
                    
                
            }
            
            echo json_encode($data);
        } else {
            echo "Error Sql ".$sql;
        }
    } else {
        echo "Error Getting";
    }
?>