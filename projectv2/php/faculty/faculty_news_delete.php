<?php
    require('../db_config.php');
    if(isset($_GET['id'])) {
        
    } else {
        header("Location : http://localhost/projectv2/php/user_login_page.php");
    }
    $sql1 = "delete from news where id = ".$_GET['id']."";
    if($conn->query($sql1)) {
        $sql = "select * from news order by date";
    if($results = $conn->query($sql)) {
        echo "<table style=>";
        while($row = $results->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row['title'];
            echo "</td>";

            echo "<td>";
            echo $row['date'];
            echo "</td>";

            echo "<td>";
            echo $row['description'];
            echo "</td>";
            
           $id = $row['id'];

            echo "<td>";
            echo "<button value='$id' class='but' onclick='onDeleteClick(event)'> Delete </button>";
            echo "</td>";

            echo "<td>";
            echo "<button value='$id' class ='but' onclick='onEditClick(event)'> Edit </button>";
            echo "</td>";

            echo "</tr>";
        }   
        echo '<div style="font-size:16px; padding:15px; position:absolute; bottom:0; left:43%;">
                    <a href="http://localhost/projectv2/php/faculty/faculty_news.php"> Add New News</a>
                        </div>';
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