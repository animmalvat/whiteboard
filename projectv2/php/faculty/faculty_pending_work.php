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
     <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/registration.css">

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
                <input type="submit" class="but" value="Log Out">
            </form>
        </div>
        <!-- btn -->
    </section>
    <!-- canavs -->
    <section class="canvas fl-left">
        <!-- main section -->
        <div class="work1">
            <div class="news" style="width:80%; height:70%;" id="table">
                <h1>
                    Please fill up the form for saving the pending work
                </h1>
                <form action="http://localhost/projectv2/php/faculty/faculty_pending_work_upload.php" method="get">
                    <br>
                    <br>

                    <?php
                        $sql = "select * from (select assigned_subject.*, subject.id as sid, subject.name from assigned_subject inner join subject on subject.id = assigned_subject.subject_id) as d where faculty_id = '$user_id'";
                        if($results = $conn->query($sql)) {
                            echo "<select class='input100' style='width:15%;' name='class'>";
                            while($row = $results->fetch_assoc()) {
                                
                                $s = "select * from class where semester = '".$row['semester']."' and division = '".$row['division']."' and branch = '".$row['branch']."'";
                                if($r = $conn->query($s)) {
                                    $ro = $r->fetch_assoc();
                                    echo "<option value=".$ro['id']."-".$row['name'].">";
                                    echo $row['semester']." ".$row['division']." ".$row['branch']." ".$row['name'] ;
                                    echo "</option>";       
                                }
                                
                            }
                            echo "</select>";
                        }
                    ?>

                    <br>
                    <br>
                    <div class="n-m" style="width:100%;">
                    <span>Title</span>
                    <input class="input100" style='width:35%;' type="text" name="title" />
                    <br>
                    <br>
                    <span>Date</span>

                    <input class="input100"  style="width:18%;" type="date" id='dd' name="date" data-date-inline-picker=true />
                    <br>
                    <br>

                    <span style="display: inline-block; vertical-align:top; "> Description </span>
                    &nbsp;
                    <textarea class='input100' cols="40" rows="4"  style="height:40%; width: 40%;" name="description"> </textarea>
                    <br><br>
                    <input class="but" type="submit" />
                    </div>
                </form>

                <!--                view all the pending work-->
                <div>
                    <br>
                    <span style="font-size:16px;">
                    <a href="http://localhost/projectv2/php/faculty/faculty_pending_work_view.php"> View All Pending Work</a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!--       to set the today's date-->
    <script>
        var datePicker = document.getElementById('dd');
        document.getElementById('dd').valueAsDate = new Date();

    </script>

</body>

</html>
