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
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/main.css ">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/admin_users.css">
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
                <li><a href="http://localhost/projectv2/php/admin/admin_home.php">Home</a></li>
                <li><a href="http://localhost/projectv2/php/admin/admin_users.php" class='active'>Users</a> </li>
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
        <div class="news" style="width:80%; height:70%; padding: 5px; padding-bottom: 10px;">
            <div style="padding: 2px; padding-bottom: 20px;">Search :
                <input type="text" id="search_text" />
                <button onclick='onSearchClick(event)'> Go</button>
            </div>
            <div id="table_container" style=" height: 80%; width: 60%; margin: 0 auto; overflow-y: scroll; overflow-x: hidden;">
                <?php
                        $sql = "select * from user";
                        if($results = $conn->query($sql)) {
                            echo "<table>";
                            echo "<tr> <th> Id </th> <th> First Name </th> <th> Last Name </th> 
                            <th> E Mail </th> <th> Contact </th> <th> Delete ? </th>";
                            $id = " ";
                            while($row = $results->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>";
                                echo $row['id'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['firstname'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['lastname'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['email'];
                                echo "</td>";
                                echo "<td>";
                                echo $row['contact'];
                                echo "</td>";
                                echo "<td>";
                                $id = $row['id'];
                                echo "<button value=".$id." onclick='onDeleteClick(event)'> Delete </button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo"</table>";
                        } else {
                            echo "there was some error";
                        }
                        ?>
            </div>
        </div>
        <script src="../jquery-3.3.1.js"></script>
        <script>
            function onDeleteClick(event) {
                console.log(event.target.value);
                $.ajax({
                    url: "admin_users_delete.php",
                    data: ({
                        "id": event.target.value
                    }),
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
                    url: "admin_users_search.php",
                    data: ({
                        "search_txt": search_text
                    }),
                    dataType: "text",
                    success: function(data) {
                        document.getElementById('table_container').innerHTML = data;
                    }
                })
            }

        </script>
    </section>
    <!-- endofsection -->
</body>

</html>
