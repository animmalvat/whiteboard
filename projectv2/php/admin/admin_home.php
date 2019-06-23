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
    <title>Admin - Home</title>
    <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
    <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
</head>

<body>
    <div class="side_panel">
        <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php"> <label for="profile_upload"> <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?> <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100"> </label> <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;"> </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
        </div>
        <!-- profile -->
        <div class="sidebar">
            <ul>
                <li><a href="http://localhost/projectv1/php/student/student_profile.php" class="active">Home</a></li>
                <li><a href="http://localhost/projectv2/php/admin/admin_users.php">Users</a> </li>
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
                <input type="submit" class="but" value="Log Out">
            </form>
        </div>
        <!-- btn -->
    </section>
    <!-- canavs -->
    <section class="canvas fl-left">
        <!-- main section -->
        <div class="work1">
            <div class="news">
                <h3>News</h3>
                <ul>
                    <li>6th august mid semester commencing</li>
                    <li>16th october aduition for junoon 2018</li>
                </ul>
            </div>
            <!--  news -->
            <div class="Attendance">
                <!-- baaki -->
                <h3>
                    Attendance
                </h3>
            </div>
            <div class="Schedule">
                <h3>Schedule</h3>
                <ul>
                    <li>Advance Java</li>
                    <li>Dot Net</li>
                    <li>Web Technologies</li>
                    <li>DCDR</li>
                    <li>Lab DCDR</li>
                </ul>
            </div>
            <!-- schedule -->
            <div class="Progress">
                <!--   baaki -->
                <h3>
                    Progress
                </h3>
            </div>
            <div class="pendingwork">
                <h3>Pending Work</h3>
                <ul>
                    <li>26th august: Submit AJ: Assignmnet 6</li>
                    <li>30th august: Submit WT: Assignmnet 4</li>
                    <li>30th august: DCDR:Clear module 7</li>
                </ul>
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
