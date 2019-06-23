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
       
      <title>Student - Application</title>
      
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
       <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/registration.css">
     
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
               <li><a href="http://localhost/projectv2/php/student/student_home.php" >Home</a></li>
                <li><a href="http://localhost/projectv2/php/student/student_application.php">Application</a></li>
                <li><a href="http://localhost/projectv2/php/student/student_material_download.php">Study Material</a></li>
                <li><a class="active" href="http://localhost/projectv2/php/student/student_feedback.php">Faculty Feedback</a></li>
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
                <h1 style="padding:40px;">Feed Back</h1>
                <form method="post" action="http://localhost/projectv2/php/student/student_feedback_post.php">
                <div class="n-m" style="width: 100%;">
                    
                <?php
                    $sql = "select user.* from faculty inner join user on user.id = faculty.user_id where branch = '$branch'";
                    
                    echo "<select style='font-size:16px;' name='faculty'>";
                    if($results = $conn->query($sql)) {
                        
                        echo $results->num_rows;
                        while($row = $results->fetch_assoc()) {
                            $f_id = $row['id'];
                            echo "<option value='$f_id'>";
                            
                            echo $row['firstname'];
                            echo " ";
                            echo $row['lastname'];
                            echo "</option>";
                        }
                    } else {
                        //something went wrong with database
                        //echo "problem";
                    }
                    echo "</select>";
                ?>
                    <br>
                    <br>
                    <span style="padding:10px;"> Title </span>
                    <input class="input100" style="width: 30%;" type="text" name="title"/>
                    <br>
                    <br>
                    
                    
                    <span style="display: inline-block; vertical-align:top; "> Description </span>
                    &nbsp;
                    <textarea cols="40" rows ="4" name="description" style="width:40%;height:50%;" class="input100" > </textarea>
                    <br><br>
                    <input class="but" type="submit"/> 
                    </div>
                </form>
               
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