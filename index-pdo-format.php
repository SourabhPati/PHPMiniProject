<?php session_start();
    if(!isset($_SESSION['username'])){
        header('location: hod_login.php');
    }
    if(isset($_GET['logout'])){
        $_SESSION=array();
        session_destroy();
        header('location:hod_login.php');
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Teachers' List</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Teacher</a>
                        <a href="index-pdo-format.php?logout=1" class="btn btn-danger pull-right margin">Logout</a> <!-- options to be added here-->
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';           
                    // Attempt select query execution
                    $sql = "SELECT Teacher_ID,Name FROM Teacher";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['Teacher_ID'] . "</td>";
                                        echo "<td>" . $row['Name'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['Teacher_ID'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon  glyphicon-eye-open'></span></a>";
                                            //Options to display timetable to be added here.
                                            echo "<a href='update.php?id=". $row['Teacher_ID'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['Teacher_ID'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                    <br><br>
                    <h4>Click below button to find a Teacher<h4><br>
                    <a href="locate.php" class="btn btn-primary">Locate a Teacher</a>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>