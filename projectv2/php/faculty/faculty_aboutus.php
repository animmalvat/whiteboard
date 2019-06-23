<?php 
require('../db_config.php');
require('../user.php');
    session_start();
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $firstname = $user->getFirstName();
        $lastname = $user->getLastName();
        $user_id = $user->getId();
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Comatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Faculty - About Us</title>
    <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
    <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/student_about.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn&apos;t work if you view the page via file:// -->
    <!--[if lt IE 9]>	<script src="<a href="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script">https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script</a>>	<script src="<a href="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script">https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script</a>>	<![endif]-->

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
                <li><a href="http://localhost/projectv1/php/student/student_aboutus.php" class='active'>About us</a></li>
                 
                 
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
    <div class="box">
        <div class="co-form">
            <div class="heading">
                <h3 style="padding-bottom: 5px;">White Board</h3>

            </div>
            <div class="heading" style="font-size: 18px;">
                <span style="font-size:20px;">
                    <b>Front End Developer</b> : Helly Patel <br> <br>
                    <b>UI DESIGNER</b> : Helly Patel and <a href="http://animmalvat.ml" style="color:#323232;"> Anim Malvat </a> <br> <br>
                    <b>Back End Developer</b> : Rushabh Rathod and Anim Malvat<br>
                </span>
            </div>
            <div class="contact-us" style="font-size: 16px">
                <b> Contact Us </b>: malvat.anim0@gmail.com
            </div>
        </div>

    </div>

</body>

</html>
