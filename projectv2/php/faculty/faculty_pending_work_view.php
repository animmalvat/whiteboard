<?php 
    require('../db_config.php');
    require('../user.php');
    session_start();
    $user = $_SESSION['user'];
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $user_id = $user->getId();

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Comatible" content="IE-edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Faculty - News</title>
      <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/admin_users.css">
       
       
   </head>
   <body>
      <div class="side_panel" style="overflow: hidden; display: flex; flex-direction: column; ">
         <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php">                 <label for="profile_upload">                     <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?>                     <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100">                 </label>                 <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;">             </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
         </div>
         <!-- profile -->
         <div class="sidebar" style="overflow-y: auto;height:60%;">
            <ul>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_home.php" >Home</a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_news.php" > News </a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_pending_work.php" class="active">Pending Work</a></li>
                <?php 
                    
                    $sql = "select * from roles where roles='timetable_coordinator'";
                    if($results=$conn->query($sql)) {
                        $row = $results->fetch_assoc();
                        $roles_id = $row['id'];
                        
                        $sql = "select * from user_roles where user_id = '$user_id' and roles_id = '$roles_id'";
                        if($results = $conn->query($sql)) {
                            if($results->num_rows > 0) {
                                echo "<li><a href='http://localhost/projectv2/php/faculty/faculty_time_table.php'>Time Table </a></li>";
                            }
                        }
                    }
//                    $user = $_SESSION['user'];
//                    $id = $user->getId();
//                    $sql = "select * from class_coordinator where user_id = '$id'";
//                    if($results = $conn->query($sql)) {
//                        if($results->num_rows > 0) {
//                            echo "<li> <a href='http://localhost/projectv2/php/faculty/faculty_class.php'> Class </a> </li>";
//                            $row = $results->fetch_assoc();
//                            $_SESSION['class_id'] = $row['class_id'];
//                        }
//                    }
                ?>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_attendance.php">Attendance</a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_subject_material.php">Subject Material</a></li>
                <li><a href="http://localhost/projectv2/php/faculty/faculty_application.php">Application</a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_aboutus.php">About us</a></li>
                
                
            </ul>
         </div>
         <!--  sidebar -->
      </div>
      <!-- sidenel-->
      <section class="canvas">
         <div class="Search">
            <!-- Search form -->
            <form class="form-inline">
                
            </form>
         </div>
         <!-- end Search form -->
         <div class="btn1">
            <form action="http://localhost/projectv2/php/user_logout.php" method="get">
               <input type="submit" class="but" value ="Log Out">
            </form>
         </div>
         <!-- btn -->
      </section>
      <!-- canavs -->
      <section class="canvas fl-left">
         <!-- main section -->
         <div class="work1">
            <div class="news" style="width:80%; height:70%;" id="table">
                <div style="padding:15px;">
                    <h1>
                    List Of Pending Work
                    </h1>
                </div>
                <br>
                <div id="table_container" style="margin: 0 auto; width: 70%; height:60%;overflow-y:scroll; padding:10px; font-size:15px;">
                    
                    <?php
                        
                        $sql = "select * from (select pending_work.*, class.semester, class.division, class.branch from pending_work inner join class on pending_work.class_id = class.id) as d";
                        if($results = $conn->query($sql)) {
                            echo "<table style='width: 100%;'>";
                            
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
                        }
                    ?>
                    
                    
                </div>
                <div style="padding: 15px;">
                <a href="http://localhost/projectv2/php/faculty/faculty_pending_work.php"> Add New Work</a>
             </div>
                
            </div>
          </div>
      </section>
       <script src="../jquery-3.3.1.js"></script>
       <script>
            function onDeleteClick(event) {
                console.log(event.target.value);
                $.ajax({
                    url: "faculty_pending_work_delete.php",
                    data: ({"id":event.target.value}),
                    dataType: "text",
                    success: function(data) {
                        document.getElementById('table_container').innerHTML = data;
                    }
                })
            }
           
            function onEditClick(event) {
                var id = event.target.value;
                window.location = "http://localhost/projectv2/php/faculty/faculty_pending_work_edit.php?id=" + id;
            }
       </script>
      
   </body>
</html>