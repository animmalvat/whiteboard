
<?php
require('../db_config.php');
require('../User.php');
require('../student.php');
                    $path    = '../../documents';
                    $files = scandir($path);
                    echo "<table>";
                    echo "<tr>";
                    $r = 1;
                    for($i = 2; $i < sizeof($files);$i++) {
                        $strs = explode("_", $files[$i]);
                        
                        if(strcmp($strs[3], $branch) == 0) {
                            $file = "../../documents/".$files[$i];
                            
                            
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
                            $r++;
                        }
                        
                    }
                    echo "</tr>";
                    echo "</table>";
                    
                    ?>