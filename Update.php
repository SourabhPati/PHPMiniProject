<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$Teacher_ID = $Name = $Subject = $Free_Periods = "";
$name_err = $FreeP_err = $subject_err = $ID_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    $input_ID = $_POST["id"];
    if(empty($input_ID)){
        $ID_err = "Please enter an ID.";
    }
    else
        $Teacher_ID = $input_ID;
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate subject
    $input_subject = trim($_POST["Subject"]);
    if(empty($input_subject)){
        $subject_err = 'Please enter a subject.';     
    } else{
        $Subject = $input_subject;
    }
    
    // Validate Free_PeriodS
    /*$input_freeP = trim($_POST["Free_Periods"]);
    if(empty($input_freeP)){
        $FreeP_err = "Please enter the number of free periods per week.";     
    } elseif(!ctype_digit($input_freeP)){
        $FreeP_err = 'Please enter a positive integer value.';
    } else{
        $Free_Periods = $input_freeP;
    }*/
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($subject_err) && empty($ID_err)){
        // Prepare an insert statement
        $sql = "UPDATE teacher SET Name=:name,Subject=:Subject WHERE Teacher_ID = :Teacher_ID;";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':Teacher_ID', $param_TeacherID);
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':Subject', $param_Subject);
            //$stmt->bindParam(':Free_Periods', $param_Free_Periods);
            
            // Set parameters
            $param_TeacherID = $Teacher_ID;
            $param_name = $name;
            $param_Subject = $Subject;
            //$param_Free_Periods = $Free_Periods;
            
            // Attempt to execute the prepared statement
                      // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
              //  header("location: index.php");
              //  exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
         
        // Close statement
        unset($stmt);   
    }
    

    $mon = explode(' ',$_POST['MON']);
    $tue = explode(' ',$_POST['TUE']);
    $wed = explode(' ',$_POST['WED']);
    $thu = explode(' ',$_POST['thu']);
    $fri = explode(' ',$_POST['FRI']);


    $count=substr_count(implode(" ",$mon),"Free")+substr_count(implode(" ",$tue),"Free")+substr_count(implode(" ",$wed),"Free")+substr_count(implode(" ",$thu),"Free")+substr_count(implode(" ",$fri),"Free");
      $sql5 = "UPDATE `teacher` SET Free_Periods = $count WHERE Teacher_ID = $Teacher_ID";
      $pdo->query($sql5);


    $SQLdelete = "DROP TABLE `school`.`$Teacher_ID`;";
    $pdo->query($SQLdelete);

    $sql2 = "CREATE TABLE `school`.`$Teacher_ID` ( `DAY` TEXT NOT NULL , `Period 1` TEXT NOT NULL , `Period 2` TEXT NOT NULL , `Period 3` TEXT NOT NULL , `Period 4` TEXT NOT NULL , `Period 5` TEXT NOT NULL , `Period 6` TEXT NOT NULL , `Period 7` TEXT NOT NULL , `Period 8` TEXT NOT NULL) ENGINE = InnoDB;";
    $pdo->query($sql2);

    $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"%s\")",implode("\",\"",$mon));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"%s\")",implode("\",\"",$tue));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\" %s\")",implode("\",\"",$wed));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"  %s\")",implode("\",\"",$thu));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\" %s\")",implode("\",\"",$fri));
     $pdo->query($sqlINS);
        // Close statement
        unset($stmt);
    }
    header("location: index-pdo-format.php");
    exit();
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT Teacher_ID,Name FROM teacher WHERE Teacher_ID = :Teacher_ID";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':Teacher_ID', $param_TeacherID);
            
            // Set parameters
            $param_TeacherID = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $ID = $row["Teacher_ID"];
                    $name = $row["Name"];
                  //  $Subject = $row["Subject"];
                  //  $Free_Periods = $row["Free_Periods"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                <div class="col-md-15">
                    <div class="page-header">
                        <h2>Update Details for Teacher with ID <?php echo $_GET['id']; ?></h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $Name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                            <label>Subject</label>
                            <textarea name="Subject" class="form-control"><?php echo $Subject; ?></textarea>
                            <span class="help-block"><?php echo $subject_err;?></span>
                        </div>
                        <!--<div class="form-group <?php echo (!empty($FreeP_err)) ? 'has-error' : ''; ?>">
                            <label>Free Periods</label>
                            <input type="text" name="Free_Periods" class="form-control" value="<?php echo $Free_Periods; ?>">
                            <span class="help-block"><?php echo $FreeP_err;?></span>
                        </div>-->
                        <!--Input aid msgs to be added -->
                        <div class = "form-group">
                            <label>DAY-1 (MON)</label>
                            <input type="text" name="MON" class="form-control">
                        </div>
                        <div class = "form-group">
                            <label>DAY-2 (TUE)</label>
                            <input type="text" name="TUE" class="form-control">
                        </div>
                        <div class = "form-group">
                            <label>DAY-3 (WED)</label>
                            <input type="text" name="WED" class="form-control">
                        </div>
                        <div class = "form-group">
                            <label>DAY-4 (THU)</label>
                            <input type="text" name="thu" class="form-control">
                        </div>
                        <div class = "form-group">
                            <label>DAY-5 (FRI)</label>
                            <input type="text" name="FRI" class="form-control">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index-pdo-format.php" class="btn btn-default">Cancel</a>
                        <br><br>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>