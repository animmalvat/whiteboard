<?php
    require('../db_config.php');
    if(isset($_GET['search_txt'])) {
        $txt = $_GET['search_txt'];
        
         $sql = "select user.*, assigned_subject.semester, assigned_subject.branch, assigned_subject.id as asid, assigned_subject.division from assigned_subject inner join user on user.id = assigned_subject.faculty_id where firstname like '".$txt."%' or lastname like '".$txt."%'";
        
        if($results = $conn->query($sql)) {
            echo "<table>";
            while($row = $results->fetch_assoc()) {
                echo "<tr>";

                echo "<td>";
                echo "<button value=".$row['asid']." onclick='onDeleteClick(event)'> delete </button>";
                echo "</td>";

                echo "<td>";
                echo $row['firstname'];
                echo " ";
                echo $row['lastname'];

                echo "</td>";

                echo "<td>";
                echo $row['semester'];
                echo "</td>";

                echo "<td>";
                echo $row['branch'];
                echo "</td>";

                echo "<td>";
                echo $row['division'];
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        header("Location : http://localhost/projectv2/php/user_login_page.php");
    }
    
?>