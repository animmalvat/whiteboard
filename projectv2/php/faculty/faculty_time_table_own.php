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
      <title>Faculty - Time Table</title>
      <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/time_table_view.css">
       
   </head>
   <body>
      <div class="side_panel" style="">
         <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php">                 <label for="profile_upload">                     <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?>                     <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100">                 </label>                 <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;">             </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
         </div>
         <!-- profile -->
         <div class="sidebar" style="overflow-y: auto;height:60%;">
            <ul>
               <li><a href="http://localhost/projectv2/php/faculty/faculty_home.php">Home</a></li>
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
                                echo "<li><a href='http://localhost/projectv2/php/faculty/faculty_time_table.php' class='active'>Time Table </a></li>";
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
                <br>
                <br>
                <div id='timetableown'>
                
                <?php
                    $sql = "    select schedule.*, subject.name from schedule inner join subject on subject.id = schedule.subject_id where user_id='$user_id' order by lecture, day";
                
                    if($results = $conn->query($sql)) {
                        if($results->num_rows <= 0) {
                            echo "There is no time table created";
                        } else  {
                            echo "<table id='table_itself' style='border: 1px black solid;'>";
                            echo "<tr>
                                <td > Monday </td>
                                <td > Tuesday </td>
                                <td > Wednesday </td>
                                <td > Thursday </td>
                                <td > Friday </td>
                                <td > Saturday </td>
                            </tr>";
                            
                            $lec = 1;
                            $dday = 0;
                            $row = $results->fetch_assoc();
                            echo "<tr>";
                            while(true) {
                                if($dday>5) {
                                    $lec++;
                                    $dday=0;
                                    echo "</tr>";
                                    echo "<tr>";
                                }
                                if($lec>6) {
                                    break;
                                }
                                if($dday == 0 && $lec == 1){
                                    //echo "<tr>";
                                }
                                echo "<td>";
                               if($row['lecture'] == $lec && $row['day'] == $dday) {
                                   echo $row['semester'];
                                   echo " ";
                                   echo $row['division'];
                                   echo " ";
                                    echo $row['name'];
                                   $row = $results->fetch_assoc();
                               } else {
                                   echo "Free";
                               }
                                echo "</td>";
                                $dday++;
                                
                                

                            }
                            echo "</table>";
                        }
                    }
                ?>
                </div>
                    <br><br>
                <a href="http://localhost/projectv2/php/faculty/faculty_time_table.php"> Go Back</a> 
                <br>
                <br>
                <button class = "but" onclick='demoFromHTML()'>Download as PDF</button>
             </div>
          </div>
       </section>
       
       
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
       <script>
        function demoFromHTML() {
            var pdf = new jsPDF('l', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#timetableown')[0];
            
            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function (element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 10,
                width: 700
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('time-table.pdf');
            }, margins);
        }
       </script>
   </body>
</html>