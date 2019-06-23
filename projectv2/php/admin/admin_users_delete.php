<?php
    require('../db_config.php');
    if(isset($_GET['id'])) {
        
    } else {
        header("Location : http://localhost/projectv2/php/user_login_page.php");
    }
    $sql1 = "delete from user where id = ".$_GET['id']."";
    if($conn->multi_query($sql1)) {
        $sql = "select * from user";
        if($results = $conn->query($sql)) {
            echo "<table>";
            echo "<tr> <th> Id </th> <th> First Name </th> <th> Last Name </th> 
            <th> E Mail </th> <th> Contact </th> <th> Delete ? </th>";
            $id = " ";
            while($row = $results->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                echo $row['id'];
                echo "</td>";
                echo "<td>";
                echo $row['firstname'];
                echo "</td>";
                echo "<td>";
                echo $row['lastname'];
                echo "</td>";
                echo "<td>";
                echo $row['email'];
                echo "</td>";
                echo "<td>";
                echo $row['contact'];
                echo "</td>";
                echo "<td>";
                $id = $row['id'];
                echo "<button value='$id' onclick='onDeleteClick(event)'> Delete </button>";
                
                echo "</td>";
                echo "</tr>";
            }
            echo"</table>";
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
