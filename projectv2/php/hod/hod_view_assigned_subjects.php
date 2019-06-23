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
        <title>HOD - Assigned Subject</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
        <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
        <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
        <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
        
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
               <li><a href="http://localhost/projectv2/php/hod/hod_assign_subject.php" class="active">Subject Assigning</a></li>
               <li><a href="http://localhost/projectv2/php/hod/hod_time_table.php">Time Table Commitee</a></li>
              <li><a href="http://localhost/projectv2/php/hod/hod_class_coordinator.php"> Class Coordinator</a></li>
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
                <div style="padding: 2px; padding-bottom: 20px;">Search :
                    <input type="text" id="search_text"/>
                    <button onclick='onSearchClick(event)'> Go</button>
                </div>
                <div id="table_container" style="margin: 0 auto; width: 60%;height: 60%; overflow-y: scroll;">
                
                <?php
                    $sql = "select user.*, assigned_subject.semester, assigned_subject.branch, assigned_subject.id as asid, assigned_subject.division from assigned_subject inner join user on user.id = assigned_subject.faculty_id";
                    if($results = $conn->query($sql)) {
                        echo "<table>";
                        while($row = $results->fetch_assoc()) {
                            echo "<tr>";
                            
                            echo "<td>";
                            echo "<button value=".$row['asid']." onclick='onDeleteClick(event)'> delete </button>";
                            echo "</td>";
                            
                            echo "<td>";
                            echo $row['firstname'];
                            echo " ";
                            echo $row['lastname'];
                            
                            echo "</td>";
                            
                            echo "<td>";
                            echo $row['semester'];
                            echo "</td>";
                            
                            echo "<td>";
                            echo $row['branch'];
                            echo "</td>";
                            
                            echo "<td>";
                            echo $row['division'];
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                ?>
                    </div>
                <a href="subject_assigned.php">Go Back</a>
            </div>
            
        </section>
       <script>
        function profileUpdated() {
            document.getElementById('profile_upload_form').submit();
        }

    </script>
        
        <!-- endofsection -->
        <!-- /js-quary -->
<!--        ajax for subject selection -->
        <script src="../jquery-3.3.1.js"></script>
        <script>
            function onDeleteClick(event) {
                console.log(event.target.value);
                $.ajax({
                    url: "assigned_subject_delete.php",
                    data: ({"id":event.target.value}),
                    dataType: "text",
                    success: function(data) {
                        document.getElementById('table_container').innerHTML = data;
                    }
                })
            }
            
            function onSearchClick(event) {
                console.log(event.target.value);
                var search_text = document.getElementById('search_text').value;
                $.ajax({
                    url: "hod_subject_assigned_search.php",
                    data: ({"search_txt":search_text}),
                    dataType: "text",
                    success: function(data) {
                        document.getElementById('table_container').innerHTML = data;
                    }
                })
            }
        </script>
        
        
    </body>
</html>