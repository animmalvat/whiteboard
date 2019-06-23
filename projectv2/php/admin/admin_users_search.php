<?php
    require('../db_config.php');
    if(isset($_GET['search_txt'])) {
        $txt = $_GET['search_txt'];
        
        $sql = "select * from user where firstname like '".$txt."%' or lastname like '".$txt."%'";
        if($results = $conn->query($sql)) {
            
            if($results->num_rows <= 0 ){
                echo "there are no results";
            } else {
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
            }
            
        } else {
            echo "there was some error123";
            echo $sql;
        }
    } else {
        header("Location : http://localhost/projectv2/php/user_login_page.php");
    }
    
    ?>
