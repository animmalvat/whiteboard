<?php
    require('../db_config.php');
    if(isset($_GET['id'])) {
        
    } else {
        header("Location : http://localhost/projectv2/php/user_login_page.php");
    }
    $sql1 = "delete from pending_work where id = ".$_GET['id']."";
    if($conn->query($sql1)) {
        $sql = "select * from (select pending_work.*, class.semester, class.division, class.branch from pending_work inner join class on pending_work.class_id = class.id) as d";
    if($results = $conn->query($sql)) {
        echo "<table style='style:100%;'>";
        while($row = $results->fetch_assoc()) {
            
            echo "<tr>";
            echo "<td>";
            echo $row['title'];
            echo "</td>";

            echo "<td>";
            echo $row['date'];
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

            $id = $row['id'];

            echo "<td>";
            echo "<button value='$id' class='but' onclick='onDeleteClick(event)'> Delete </button>";
            echo "</td>";

            echo "<td>";
            echo "<button value='$id' class='but' onclick='onEditClick(event)'> Edit </button>";
            echo "</td>";

            echo "</tr>";
        }   
            echo "</table>";
        } else {
            echo "there was some error";
            echo $sql;
        }
    } else {
        echo "there was some error";
        echo $_GET['id'];
        echo $sql1;
    }
  
?>