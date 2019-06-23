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
    
    
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Comatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student - Home</title>
    <!-- 	<link rel="shortcut icon" type="images/X" href="imgs\M.png"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
    <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
    <!--       p5 js for attendnace pie chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.8.0/p5.js"></script>
    <script src="attendance_pie_chart.js"></script>
    <script src="../jquery-3.3.1.js"></script>
</head>
<script>
    function attendance_load() {
        $.ajax({
            url: "attendance_load_percentage.php",
            dataType: "text",
            success: function(data) {
                startPieChart(data);
            }
        })
    }

    function startPieChart(data) {
        startDrawing(data);
    }

</script>

<body onload="attendance_load()">
    <div class="side_panel">
        <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php"> <label for="profile_upload">
                    <?php
                        $path    = '../../profile';                         
                        $files = scandir($path);  			
                        $profile_photo = "";
                        for($i =2; $i<sizeof($files); $i++) {
                            $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {
                                $profile_photo = $files[$i];
                                break;
                            }
                        }
                        ?>
                    <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100"> </label> <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;">
            </form>
            <h3 style="vertical-align:middle; margin:auto; width: 100%;"><?php echo $firstname; echo " " ;echo $lastname; ?></h3>
        </div>
        <!-- profile -->
        <div class="sidebar">
            <ul>
                <li><a href="http://localhost/projectv2/php/student/student_home.php" class="active">Home</a></li>
                <li><a href="http://localhost/projectv2/php/student/student_application.php">Application</a></li>
                <li><a href="http://localhost/projectv2/php/student/student_material_download.php">Study Material</a></li>
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
                <input type="submit" class="but" value="Log Out">
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
                            $sql = "select * from news";
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
                            -->
                </div>
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
                        $student = $_SESSION['student'];
                        $class_id = $student->getClassId();
                        $sql = "select * from class where id = '$class_id'";
                        if($results = $conn->query($sql)) {
                            
                            if($rows = $results->fetch_assoc()) {
                                $semester = $rows['semester'];
                                $division = $rows['division'];
                                $day = date('1');
                                $day -= 1;
                                $sql = "select * from (select schedule.*, subject.name, subject.semester as sem from schedule inner join subject on subject.id = schedule.subject_id) as t where semester = '$semester' and division = '$division' and day = '$day'";
                                if($results = $conn->query($sql)) {
                                    echo "<ul>";
                                    if($results->num_rows <=0) {
                                        echo "Have Fun";
                                    }
                                    
                                    while($row = $results->fetch_assoc()) {
                                        echo "<li>";
                                        echo $row['name'];
                                        echo "</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "there was some error";
                                }
                            }
                        } else {
                            echo "class maj problem chhe";
                        }
                        ?>
                <!--
                        <ul>
                           <li>Advance Java</li>
                           <li>Dot Net</li>
                           <li>Web Technologies</li>
                           <li>DCDR</li>
                           <li>Lab DCDR</li>
                        </ul>
                        -->
            </div>
            <!-- schedule -->
            <div class="Progress  hover-effect">
                <!--   baaki -->
                <h3>
                    Progress
                </h3>
                
                <br>
                <div style="font-size:18px;">
                Personal Progress at glance <br> (Future Work)
                </div>
            </div>
            <div class="pendingwork  hover-effect" style="overflow-x:hidden; position:fixed; overflow:hidden;">
                <h3>Pending Work</h3>
                <div style="overflow-y: scroll; height:60%;width:100%;">
                    <?php
                            $sql = "select * from pending_work where class_id = '$class_id'";
                            if($result = $conn->query($sql)) {
                                echo "<ul>";
                                while($row = $result->fetch_assoc()) {
                                    $t = $row['description'];
                                    echo "<li title='$t'>";
                                    echo $row['date'];
                                    echo " ";
                                    echo $row['title'];
                                    echo " ";
                                    echo $row['subject_name'];
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
                            -->
                </div>
            </div>
        </div>
    </section>
    <!-- endofsection -->
    <!-- /js-quary -->
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
