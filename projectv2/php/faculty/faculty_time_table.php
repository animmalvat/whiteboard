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

</head>

<body>
    <div class="side_panel" style="">
        <div class="profile" style="text-align:center;width: 100%;">
            <form id='profile_upload_form' enctype="multipart/form-data" method="post" action="http://localhost/projectv2/php/profile_photo_updated.php"> <label for="profile_upload"> <?php                          $path    = '../../profile';                         $files = scandir($path);  			$profile_photo = "";                         for($i =2; $i<sizeof($files); $i++) {                             $strs = explode(".", $files[$i]);                             if(strcmp($strs[0], $user_id) == 0) {                                 $profile_photo = $files[$i];                                 break;                             }                         }                     ?> <img src=<?php echo "http://localhost/projectv2/profile/".$profile_photo?> onerror=this.src="http://localhost/projectv2/profile/default.jpeg" class="img-circle" alt="Cinque Terre" align="center" width="100" height="100"> </label> <input id="profile_upload" onchange='profileUpdated()' name='profile_photo' type="file" style="display:none;"> </form>
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
                <br>
                <br>



                <form>
                    <h1>
                        Please select semester and division
                    </h1>
                    <br>

                    <h2 style="color: #aaa; font-size: 24px;">
                        To Create Time Table
                    </h2>
                    <br>


                    <select style='font-size:16px;' id="semester" name="semester" onchange="onSemesterChange()">
                        <script type="text/javascript">
                            var semester = document.getElementById('semester');
                            for (var i = 0; i < 8; i++) {
                                semester.innerHTML += "<option value =" + (i + 1) + "> " + (i + 1) + "    </option>";
                            }

                        </script>
                    </select>

                    <select style='font-size:16px;' id="division" name="division">

                    </select>
                    <script src="../jquery-3.3.1.js"></script>

                    <script type="text/javascript">
                        var semester = "";
                        var division = "";
                        onSemesterChange();

                        function onSemesterChange() {
                            var sem = document.getElementById('semester').value;


                            $.ajax({
                                url: "division_load.php",
                                data: ({
                                    "semester": sem
                                }),
                                dataType: "text",
                                success: function(data) {
                                    $('#division').html(data);
                                }
                            })
                        }

                    </script>
                    <br>
                    <br>

                    <button class='but' onclick="onClickProceed()"> Proceed</button>
                </form>
                <br>
                <br>
                <div style="position:absolute; bottom:0; width:100%; padding:60px;">

                    <a href="http://localhost/projectv2/php/faculty/faculty_time_table_view.php"> View All Time Table</a>
                    <br><br>
                    <a href="http://localhost/projectv2/php/faculty/faculty_time_table_free.php"> View All free faculties</a>
                    <br><br>
                    <a href="http://localhost/projectv2/php/faculty/faculty_time_table_own.php"> View My Time Table</a>
                </div>
                <div class='noteError' style='position:absolute; right:0;bottom:0; padding:10px;'>
                    Note: If Time Table already exists, old one will be replaced
                </div>
            </div>

        </div>
    </section>

    <script>
        function onClickProceed() {
            var sem = document.getElementById('semester').value;
            var div = document.getElementById('division').value;
            semester = sem;
            division = div;
            var table = document.getElementById('table');
            table.innerHTML = " ";
            var t = "<div style='position:absolute;width:100%;padding:60px;'> ";
            t += "<form style='width:100%;' action='http://localhost/projectv2/php/faculty/store_timetable.php?semester=" + sem + "&division=" + div + "' method='POST' style='margin-left:10%; margin-top:5%;'>";
            t += "<table>";
            for (var i = 0; i <= 6; i++) {
                t += "<tr style='border: 1px solid black;'>";
                var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var dayCounter = 0;
                for (var j = 1; j <= 12; j++) {
                    if (i == 0 && dayCounter < 6) {
                        t += "<th colspan=2 style='border: 1px solid black; min-width:50px;' id=t" + i + j + ">" + days[dayCounter] + " </th>";
                        dayCounter++;
                    } else if (i != 0) {
                        t += "<td style='border: 1px solid black; padding: 5px;' id=t" + i + j + ">  </td>";
                    }

                }
                t += "</tr>";

            }
            t += "</table> <br> <div><input type='submit' class='but' value='Submit' style=''/> <a class='but' href='http://localhost/projectv2/php/faculty/faculty_time_table.php'>Go Back </a> </form> </div></div>";
            table.innerHTML = t;
            subjectLoad(semester);

        }
        var subjectNames = "";

        function subjectLoad(sem) {
            $.ajax({
                url: "subject_load.php",
                data: ({
                    "semester": sem,
                    "lab_not_selected": true
                }),
                dataType: "text",
                success: function(data) {

                    for (var i = 1; i <= 6; i++) {
                        for (var j = 1; j <= 12; j++) {
                            if (j % 2 != 0) {
                                var k = " ";
                                k = i + "" + j;

                                document.getElementById("t" + k).innerHTML = "<select onchange='onSubjectChange(event)' id=s" + k + " name=s" + k + ">" + data + "</select>";


                            }
                        }
                    }

                }
            })
            setTimeout(f, 100);
        }

        function f() {
            var subject = document.getElementById("s11").value;
            $.ajax({
                url: "faculty_load.php",
                data: ({
                    "semester": semester,
                    "division": division,
                    "subject": subject
                }),
                dataType: "text",
                success: function(data) {

                    for (var i = 1; i <= 6; i++) {
                        for (var j = 1; j <= 12; j++) {
                            if (j % 2 == 0) {
                                var k = " ";
                                k = i + "" + j;

                                document.getElementById("t" + k).innerHTML = "<select id=s" + k + " name=s" + k + ">" + data + "</select>";

                            }
                        }
                    }
                }
            })

            setTimeout(fWithConflicts, 1000)
        }

        function fWithConflicts() {
            for (var i = 1; i <= 6; i++) {
                for (var j = 1; j <= 12; j++) {
                    if (j % 2 != 0) {
                        var k = " ";
                        k = i + "" + j;
                        var element = document.getElementById("s" + k);
                        var eve = new Event("change");
                        element.dispatchEvent(eve);


                    }
                }
            }
        }

        function onSubjectChange(event) {

            console.log(event.target.id);
            var i = event.target.id;
            var n = parseInt(i.slice(1))
            console.log("n" + n);
            var id = n + 1;
            console.log(id);
            if (id % 10 == 0) {
                id = i.slice(1, 2);
                id += "10";
                console.log(id);
            }

            var subject = event.target.value;
            if (subject == "lab") {
                $.ajax({
                    url: "faculty_time_table_lab_subject_load.php",
                    data: ({
                        "semester": semester,
                        "division": division,
                        "subject": subject,
                        "id": id,
                        "lab_not_selected": false
                    }),
                    dataType: "text",
                    success: function(data) {
                        var strTemp = "onLabSubjectChange(event, " + i + ")";
                        var tableElement = document.getElementById("t" + n);
                        tableElement.innerHTML += "<select onchange='" + strTemp + "' id=ls" + n + " name=ls" + n + ">" + data + "</select>";

                        var strTemp = "onLabSubjectChange(null, " + i + ")";

                        tableElement.innerHTML += "<select onchange='" + strTemp + "' id=lsb" + n + " name = lsb" + n + "> <option value='1'>  1 </option> <option value='2'>  2</option> <option value='3'> 3</option>  </select>";
                        document.getElementById("s" + n).value = "lab";

                        //lab option disabled
                        //                           var index = document.getElementById("s"+n).selectedIndex;
                        //                            document.getElementById("s"+n).options[index].disabled = true;
                        //                           var t = document.getElementById(i);
                        //                           onLabSubjectChange(null, t);
                    }
                })
            } else {

                var e = document.getElementById("s" + n).getElementsByTagName('option');
                var ls = document.getElementById("ls" + n);
                var lsb = document.getElementById("lsb" + n);
                if (ls != null) {
                    ls.parentNode.removeChild(ls);
                }

                if (lsb != null) {
                    lsb.parentNode.removeChild(lsb);
                }

                for (var i = 0; i < e.length; i++) {
                    e[i].disabled = false;
                }

                $.ajax({
                    url: "faculty_load.php",
                    data: ({
                        "semester": semester,
                        "division": division,
                        "subject": subject,
                        "id": id
                    }),
                    dataType: "text",
                    success: function(data) {
                        document.getElementById("t" + id).innerHTML = "<select id=s" + id + " name=s" + id + ">" + data + "</select>";
                    }
                })
            }

        }

        function onLabSubjectChange(event, i) {
            if (event == null) {
                var subject = document.getElementById("ls" + i.id.slice(1)).value;
            } else {
                var subject = event.target.value;
            }
            var i = i.id;
            console.log("i : " + i);
            var n = parseInt(i.slice(1))
            console.log("n" + n);
            var id = n + 1;
            console.log("lab badli");
            console.log(id);
            if (id % 10 == 0) {
                id = i.slice(1, 2);
                id += "10";
                console.log(id);
            }
            console.log("n : " + n);
            var batch = document.getElementById('lsb' + n).value;

            console.log(subject);
            $.ajax({
                url: "faculty_time_table_lab_faculty_load.php",
                data: ({
                    "semester": semester,
                    "division": division,
                    "subject": subject,
                    "id": id,
                    "batch": batch
                }),
                dataType: "text",
                success: function(data) {
                    document.getElementById("t" + id).innerHTML = "<select id=s" + id + " name=s" + id + ">" + data + "</select>";
                }
            })
        }

    </script>


</body>

</html>
