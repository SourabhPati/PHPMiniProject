<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$Teacher_ID = $Name = $Subject = $Free_Periods = "";
$name_err = $FreeP_err = $subject_err = $ID_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_ID = $_POST["Teacher_ID"];
    if(empty($input_ID)){
        $ID_err = "Please enter an ID.";
    }
    elseif(!ctype_digit($input_ID)){
        $ID_err = 'Please enter a positive integer value.';
    }
    else
        $Teacher_ID = $input_ID;

    $input_name = trim($_POST["Name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["Name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }

    // Validate subject
    $input_subject = trim($_POST["Subject"]);
    if(empty($input_subject)){
        $subject_err = 'Please enter a subject.';
    }
    elseif(!filter_var(trim($_POST["Subject"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $subject_err = 'Please enter a valid subject.';
      }
     else{
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
        $sql = "INSERT INTO teacher (Teacher_ID,Name,Subject) VALUES (:Teacher_ID,:name,:Subject)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':Teacher_ID', $param_TeacherID);
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':Subject', $param_Subject);
          //  $stmt->bindParam(':Free_Periods', $param_Free_Periods);

            // Set parameters
            $param_TeacherID = $Teacher_ID;
            $param_name = $name;
            $param_Subject = $Subject;
            //$param_Free_Periods = $Free_Periods;

            // Attempt to execute the prepared statement
            try{
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
              //header("location: index.php");
              //exit();
            }
            }
            catch(PDOException $e)
            {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);



    $mon = explode(' ',$_POST['MON']);
    $tue = explode(' ',$_POST['TUE']);
    $wed = explode(' ',$_POST['WED']);
    $thur = explode(' ',$_POST['THU']);
    $fri = explode(' ',$_POST['FRI']);

    $count=substr_count(implode(" ",$mon),"Free")+substr_count(implode(" ",$tue),"Free")+substr_count(implode(" ",$wed),"Free")+substr_count(implode(" ",$thur),"Free")+substr_count(implode(" ",$fri),"Free");
      $sql5 = "UPDATE `teacher` SET Free_Periods = $count WHERE Teacher_ID = $Teacher_ID";
      $pdo->query($sql5);

    $sql2 = "CREATE TABLE `school`.`$Teacher_ID` ( `DAY` TEXT NOT NULL , `Period 1` TEXT NOT NULL , `Period 2` TEXT NOT NULL , `Period 3` TEXT NOT NULL , `Period 4` TEXT NOT NULL , `Period 5` TEXT NOT NULL , `Period 6` TEXT NOT NULL , `Period 7` TEXT NOT NULL , `Period 8` TEXT NOT NULL) ENGINE = InnoDB;";
    $pdo->query($sql2);

    $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"%s\")",implode("\",\"",$mon));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"%s\")",implode("\",\"",$tue));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\" %s\")",implode("\",\"",$wed));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\"  %s\")",implode("\",\"",$thur));
     $pdo->query($sqlINS);
      $sqlINS = sprintf("INSERT INTO `school`.`$Teacher_ID` (`DAY`, `Period 1`, `Period 2`, `Period 3`, `Period 4`, `Period 5`, `Period 6`, `Period 7`, `Period 8`) VALUES(\" %s\")",implode("\",\"",$fri));
     $pdo->query($sqlINS);
     header("location: index-pdo-format.php");
     exit();

    // Close connection
    unset($pdo);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Information :</title>
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
                        <h2>Teacher Information :</h2>
                    </div>
                    <p>Please fill this form and submit to add new teacher record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($ID_err)) ? 'has-error' : ''; ?>">
                            <label>Teacher ID</label>
                            <input type="text" name= "Teacher_ID" class="form-control" value="<?php echo $Teacher_ID; ?>">
                            <span class="help-block"><?php echo $ID_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="Name" class="form-control" value="<?php echo $Name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                            <label>Subject</label>
                            <textarea name="Subject" class="form-control"><?php echo $Subject; ?></textarea>
                            <span class="help-block"><?php echo $subject_err;?></span>
                        </div>
                      <!--  <div class="form-group <?php echo (!empty($FreeP_err)) ? 'has-error' : ''; ?>">
                            <label>Free Periods</label>
                            <input type="text" name="Free_Periods" class="form-control" value="<?php echo $Free_Periods; ?>">
                            <span class="help-block"><?php echo $FreeP_err;?></span>
                        </div>-->
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
                            <input type="text" name="THU" class="form-control">
                        </div>
                        <div class = "form-group">
                            <label>DAY-5 (FRI)</label>
                            <input type="text" name="FRI" class="form-control">
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index-pdo-format.php" class="btn btn-default">Cancel</a>
                        <br><br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
