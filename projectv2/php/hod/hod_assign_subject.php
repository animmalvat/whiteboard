<?php 
    require('../db_config.php');
    require('../user.php');
    require('../hod.php');
    session_start();
    $user = $_SESSION['user'];
    if(!isset($_SESSION['user']) && !isset($_SESSION['hod'])){
        header("http://localhost/projectv2/php/user_login_page.php");
    } else {
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
        <title>HOD - Home</title>
        <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
        <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
        <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
        <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn&apos;t work if you view the page via file:// -->
        <!--[if lt IE 9]>	<script src="<a href="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script">https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script</a>>	<script src="<a href="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script">https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script</a>>	<![endif]-->
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
                    <li><a href="http://localhost/projectv2/php/hod/hod_home.php" >Home</a></li>
                <li><a href="http://localhost/projectv2/php/hod/hod_assign_subject.php" class='active'>Subject Assigning</a></li>
                <li><a href="http://localhost/projectv2/php/hod/hod_time_table.php">Time Table Commitee</a></li>
                <li><a href="http://localhost/projectv2/php/hod/hod_class_coordinator.php">Class Coordinator</a></li>
                <li><a href="http://localhost/projectv2/php/hod/hod_faculty_feedback.php">Faculty Feedback</a></li>
               
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
            <div class="news" style="width:60%; left:30%; height:70%; padding-top: 4%;">
                <form action="http://localhost/projectv2/php/hod/subject_assigned.php" method="get">
                
                faculty
                <!--              php code for fetching faculty names-->
                <?php
                    $branch = $_SESSION['hod']->getBranch();
                    $sql = "select * from faculty inner join user on user.id = faculty.user_id where branch = '$branch'";
                    if($results = $conn->query($sql)) {
                        echo "<select name='faculty'>";
                        while($row = $results->fetch_assoc()) {
                            $id = $row['id'];
                            echo" <option value = '$id'>";
                            echo $row['firstname'];
                            echo " ";
                            echo $row['lastname'];
                            echo " </option>";
                        } 
                        echo "</select>";
                    } else {
                        echo "there was some error please try again";
                    }
                    ?>
                <br>
                <br>
                semester
                <select id="semester" onchange="onSemesterChange()" name="semester">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <br>
                <br>
                Subject
                
                <?php
                    $branch = $_SESSION['hod']->getBranch();
                    $sql = "select * from subject where branch = '$branch' and semester = '1'";
                    if($results = $conn->query($sql)) {
                        echo "<select id='subject' name='subject'>";
                        while($row = $results->fetch_assoc()) {
                            $sub_id = $row['id'];
                            echo "<option value='$sub_id'>";
                            echo $row['name'];
                            echo "</option>";
                        } echo "</select>";
                    } else {
                        echo "there was some error please try again";
                    }
                ?>
                
                <br>
                <br>
                class 
                
                <?php
                    
                    $sql = "select * from class where branch = '$branch' and semester = '1'";
                    if($results = $conn->query($sql)) {
                        echo "<select id='class' name='class'>";
                        while($row = $results->fetch_assoc()) {
                            $id = $row['id'];
                            echo "<option value='$id'>";
                            echo $row['semester'];
                            echo " ";
                            echo $row['branch'];
                            echo " ";
                            echo $row['division'];
                            echo "</option>";
                        } echo "</select>";
                    } else {
                        echo "there was some error please try again";
                    }
                ?>
                    <br>
                    <br>

                    <input type="submit" value="okay"/>
                </form>
                 <br>
            <br>
<!--                putting button so hod can see all the subjects and teachers assigned and delete some of them if they need to -->
            <a href="http://localhost/projectv2/php/hod/hod_view_assigned_subjects.php"> View All Assigned Subjects </a>
            </div>
            
        </section>
       
        <!-- endofsection -->
        <!-- /js-quary -->
<!--        ajax for subject selection -->
        <script src="../jquery-3.3.1.js"></script>
        <script>
            function onSemesterChange() {
                var semester = document.getElementById('semester').value;
                $.ajax({
                    url: "subject_load.php",
                    data: ({"semester": semester}), 
                    dataType: "text", 
                    success: function(d) {
                        $('#subject').html(d);
                        if(d == 'done') {
                            window.location ="http://localhost/projectv2/php/user_check_roles.php";
                        }
                    }   
                })
                
                $.ajax({
                    url: "class_load.php",
                    data: ({"semester": semester}), 
                    dataType: "text", 
                    success: function(d) {
                        $('#class').html(d);
                        if(d == 'done') {
                            window.location ="http://localhost/projectv2/php/user_check_roles.php";
                        }
                    }   
                })
        console.log("it is working bro");
            }
        </script>
        
        <script>
        function profileUpdated() {
            document.getElementById('profile_upload_form').submit();
        }

    </script>
        
        <script src="js/jquery.min.js"></script>
        <!-- /js -->
        <script src="lib/bxslider/dist/jquery.bxslider.min.js"></script>
        <!-- main.js -->
        <script src="js/min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCco29pL2yRek6xQIaT9DxpYgGfbx35Mps&callback=myMap"></script>
    </body>
</html>