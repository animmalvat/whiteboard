<?php 
    require('../db_config.php');
    require('../user.php');
    require('../student.php');
    session_start();
    $user = $_SESSION['user'];
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $user_id = $user->getId();
    $student = $_SESSION['student'];
    $branch = $student->getBranch();

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Comatible" content="IE-edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
       
      <title>Student - Subject Material</title>
      
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
     
   </head>
   <body>
      <div class="side_panel">
         <div class="profile" style="text-align:center;width: 100%;">
            <img src=<?php echo "http://localhost/projectv2/profile/".$user_id.".jpeg"?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100">
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
         </div>
         <!-- profile -->
         <div class="sidebar">
            <ul>
               <li><a href="http://localhost/projectv2/php/student/student_home.php" >Home</a></li>
               <li><a href="http://localhost/projectv2/php/student/student_application.php" >Application</a></li>
                <li><a class="active" href="http://localhost/projectv2/php/student/student_material_download.php">Study Material</a></li>
                <li><a href="http://localhost/projectv2/php/student/student_feedback.php">Faculty Feedback</a></li>
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
            <div class="news" style="width:80%; height:70%; padding: 5px; padding-bottom: 10px;">
                <h1 style="padding:40px;">Study Materials </h1>
                <div style="overflow-y:scroll; height:70%;">
                    
                    <?php
                    $path    = '../../documents';
                    $files = scandir($path);
                    echo "<table>";
                    echo "<tr>";
                    $r = 1;
                    $files_list = array();
                    for($i = 2; $i < sizeof($files);$i++) {
                        $strs = explode("_", $files[$i]);
                         
                        if(strcmp($strs[2], $branch) == 0) {
                             
                            $file = "../../documents/".$files[$i];
                            
                            
                            if(in_array($strs[1]." ".$strs[4], $files_list, TRUE)) {
                                //don't do anything
                            } else {
                            
                            if($r>6) {
                                echo "</tr>";
                                echo "<tr>";
                                $r = 1;
                            }
                            echo "<td>";
                            echo "<div style='float:left;padding:25px;'>";
                            
                            echo "<a href='$file' download> <img src='http://localhost/projectv2/images/document.png' height='100' width='100'></a>";
                            
                            echo "<div>";
                            $sql = "select * from subject where id = '$strs[1]'";
                            if($results = $conn->query($sql)) {
                                $row = $results->fetch_assoc();
                                echo $row['name'];
                                echo " ";
                            }
                            
                            
                            echo $strs[4];
                            echo "</div>";
                            echo "</div>";    
                            echo "</td>";
                            //adding file name to the list for further processing
                            $temp = $strs[1]." ".$strs[4];
                            
                            $files_list[] = $temp;
                            
                            $r++;}
                        }
                        
                    }
                    echo "</tr>";
                    echo "</table>";
                    
                    ?>
                    
                </div>
                
               
            </div>
          </div>
      </section>
      <!-- endofsection -->
       
      <!-- /js-quary -->
      <script src="js/jquery.min.js"></script>
      <script>
        function profileUpdated() {
            document.getElementById('profile_upload_form').submit();
        }

    </script>

   </body>
</html>