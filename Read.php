<?php
session_start();
    if(!isset($_SESSION['username'])){
        header('location: hod_login.php');
    }
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM Teacher WHERE Teacher_ID = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $Teacher_ID = $row["Teacher_ID"];
                $Name = $row["Name"];
                $Free_Periods = $row["Free_Periods"];
                $Subject = $row["Subject"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Teacher ID</label>
                        <p class="form-control-static"><?php echo $row["Teacher_ID"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["Name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Free Periods</label>
                        <p class="form-control-static"><?php echo $row["Free_Periods"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Subject</label>
                        <p class="form-control-static"><?php echo $row["Subject"]; ?></p>
                    </div>
                    <!-- TO BE FORMATED -->
                    <h3><b><u>Teacher Time Table :</u></b></h3>
                    <?PHP
                    try{
                        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch(PDOException $e){
                             die("ERROR: Could not connect. " . $e->getMessage());
                        }
                    $sql = "SELECT * FROM `$Teacher_ID`";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>DAY</th>";
                                        echo "<th>Period 1</th>";
                                        echo "<th>Period 2</th>";
                                        echo "<th>Period 3</th>";
                                        echo "<th>Period 4</th>";
                                        echo "<th>Period 5</th>";
                                        echo "<th>Period 6</th>";
                                        echo "<th>Period 7</th>";
                                        echo "<th>Period 8</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['DAY'] . "</td>";
                                        echo "<td>" . $row['Period 1'] . "</td>";
                                        echo "<td>" . $row['Period 2'] . "</td>";
                                        echo "<td>" . $row['Period 3'] . "</td>";
                                        echo "<td>" . $row['Period 4'] . "</td>";
                                        echo "<td>" . $row['Period 5'] . "</td>";
                                        echo "<td>" . $row['Period 6'] . "</td>";
                                        echo "<td>" . $row['Period 7'] . "</td>";
                                        echo "<td>" . $row['Period 8'] . "</td>";
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
                    
                    ?>


                    <p><a href="index-pdo-format.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>