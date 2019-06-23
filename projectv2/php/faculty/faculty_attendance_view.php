<?php 
    require('../db_config.php');
    require('../user.php');
    require('../faculty.php');
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
      <title>Faculty - Attendance</title>
      <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
     
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/attendance_table_view.css">

    
    


   </head>
   <body>
      <div class="side_panel">
         <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php">                 <label for="profile_upload">                     <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?>                     <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100">                 </label>                 <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;">             </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
         </div>
         <!-- profile -->
         <div class="sidebar">
            <ul>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_home.php" >Home</a></li>
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
               <li><a href="http://localhost/projectv2/php/faculty/faculty_attendance.php" class='active'>Attendance</a></li>
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
           
            <div class="news" id="container" style="width:80%; height:70%; overflow-y: scroll;">
                <h3>
                    Attendance 
                </h3>
               <?php
                    $user = $_SESSION['user'];
                    $user_id = $user->getId();
                    $sql = "select distinct semester, name, sid, division from (select schedule.*, subject.semester as sem, subject.name, subject.id as sid from schedule inner join subject on schedule.subject_id = subject.id where user_id = '$user_id') as ss";
                    if($results = $conn->query($sql)) {
                        echo "<select name=class id=class onchange='onClassChange()'>";
                        while($row = $results->fetch_assoc()) {
                            $sem = $row['semester'];
                            $div = $row['division'];
                            $sid = $row['sid'];
                            echo "<option value=".$sem.$div.$sid.">";
                            echo $sem."-";
                            echo $div."-";
                            echo $row['name'];
                            echo "</option>";                            
                        } echo "</select>";
                    } else {
                        echo "some problem";
                    }
                ?>
                <br>
                <br>
                <!--fetching lectures of that said subject--->
                <select id="lecture" name="lecture"> </select>
                
                <br>
                <br>
                <input class="input100" name="date_picker" type='date' id='dd' onchange="onClassChange()" data-date-inline-picker=true/>
                <br>
                <br>
                <button class='but' onclick="onProceedClick()">Proceed</button>
                <br>
                <br>
          <a href="http://localhost/projectv2/php/faculty/faculty_attendance.php"> Go Back</a>
            </div>
            

         
      </section>
       <script type="text/javascript" src="../jquery-3.3.1.js"> </script>
       
        <script type="text/javascript">
            setTimeout(onClassChange, 200);
                //called when class drop down is changed
                function onClassChange() {
                    var c = document.getElementById('class').value;
                    var semester = c[0];
                    var division = c[1];
                    var s = c.slice(2);
                    var date_picker = document.getElementById('dd').value;
                    console.log("subject id" + s);
                    
                    //ajax to get lectures for the desired subject
                    $.ajax({
                        url: "faculty_attendance_lecture_load.php",
                        type: "post",
                        data: ({"semester":semester, "division":division, "s":s, "date_picker": date_picker}),
                        dataType: "text",
                        success: function(data) {
                            document.getElementById('lecture').innerHTML = data;
                        }
                    })
                }
            
                //setting today's date by default 
                document.getElementById('dd').valueAsDate = new Date();
            
                //event function on proceed click 
                var onProceedClick = function(){
                    var c = document.getElementById('class').value;
                    var semester = c[0];
                    var division = c[1];
                    console.log(division);
                    var s = c.slice(2);
                    var date_picker = document.getElementById('dd').value;
                    var container = document.getElementById('container');
                    var lecture = document.getElementById('lecture').value;
                    container.innerHTML = "";
                    $.ajax({
                        url: "faculty_attendance_view_load.php",
                        type: "post",
                        data: ({"semester":semester, "division":division, "s":s, "date_picker": date_picker, "lecture" : lecture}),
                        dataType: "text",
                        success: function(data) {
                            var s = "<h3> Attendance " + semester + " " + division + " </h3>";
                            s+= data;
                            container.innerHTML = s;
                        }
                    })
                }
            </script>
      <!-- endofsection -->
      
   </body>
</html>