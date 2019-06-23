<?php 
    require('../db_config.php');
    require('../user.php');
    require('../faculty.php');
    session_start();
    $user = $_SESSION['user'];
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $user_id = $user->getId();
    $faculty = $_SESSION['faculty'];
    

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Comatible" content="IE-edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Faculty - Home</title>
      <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.8.0/p5.js"></script>
       <script src="attendance_pie_chart.js"></script>
       <script src="../jquery-3.3.1.js"></script>
      
   </head>
    
    <script>
        function attendance_load(){
             $.ajax({
                url: "attendance_load_percentage.php",
                dataType: "text",
                success: function(data) {
                    startPieChart(data);
                }
            })
        }
        
        function startPieChart(data){
            startDrawing(data);
        }
    </script>
   <body onload="attendance_load()">
      <div class="side_panel" style="">
         <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php">                 <label for="profile_upload">                     <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?>                     <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100">                 </label>                 <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;">             </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
         </div>
         <!-- profile -->
         <div class="sidebar" style="overflow-y: auto;height:60%;">
            <ul>
               <li><a href="#" class="active">Home</a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_news.php"> News </a></li>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_pending_work.php">Pending Work</a></li>
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
            <div class="news hover-effect">
               <h3>News</h3>
               <div style="overflow-y: auto; height:60%;">
                <?php
                   $date = date("Y-m-d");
                    $sql = "select * from news where date > '$date'";
                    if($result = $conn->query($sql)) {
                        echo "<ul>";
                        while($row = $result->fetch_assoc()) {
                            $t = $row['description'];
                            echo "<li title='$t'>";
                            echo $row['date'];
                            echo " ";
                            echo $row['title'];
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "Please refresh the page";
                    }
                ?>
<!--
               <ul>
                  <li>26th august: Submit AJ: Assignmnet 6</li>
                  <li>30th august: Submit WT: Assignmnet 4</li>
                  <li>30th august: DCDR:Clear module 7</li>
               </ul>
-->             </div>
            </div>
            <!--  news -->
            <div class="Attendance hover-effect" id="Attendance">
               <!-- baaki -->
               <h3>
                  Attendance
               </h3>
            </div>
            <div class="Schedule hover-effect">
               <h3>Schedule</h3>
               <?php
                
                    $day = date('1');
                    $day -= 1;
                    $sql = "select schedule.*, subject.name from schedule inner join subject on subject.id = schedule.subject_id where user_id = '$user_id' and day = '$day' order by day, lecture";
                
                    if($results = $conn->query($sql)) {
                        $row = $results->fetch_assoc();
                        $lec = 1;
                        echo "<ul>";
                        while(true) {
                            if($lec > 6) {
                                break;
                            }
                            echo "<li>";
                            if($lec == $row['lecture']) {
                                echo $row['semester'];
                                echo " ";
                                echo $row['division'];
                                echo " ";
                                echo $row['name'];    
                                $row = $results->fetch_assoc();
                            } else {
                                echo "Free";
                            }
                            $lec++;
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "there was some error";
                    }
                    
                ?>
            </div>
            <!-- schedule -->
            <div class="Progress hover-effect">
               <!--   baaki -->
               <h3>
                  Progress
               </h3>
                
                <br>
                <div style="font-size:18px;">
                    Class' Progress at glance <br> (Future Work)
                </div>
            </div>
            <div class="pendingwork hover-effect">
               <h3>Pending Work</h3>
               <div style="font-size:18px;">
                    Faculty Pending Work <br> (Future Work)
                </div>
            </div>
         </div>
      </section>
      <!-- endofsection -->
      <!-- /js-quary -->
      <script src="js/jquery.min.js"></script>
      <!-- /js -->
      <script src="lib/bxslider/dist/jquery.bxslider.min.js"></script>
      <!-- main.js -->
      <script src="js/min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCco29pL2yRek6xQIaT9DxpYgGfbx35Mps&callback=myMap"></script>
   </body>
</html>