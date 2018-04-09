<?php

require_once "config.php";


$err = $Teacher_ID = $ID_err = '';
$period = $day = $location = '';

date_default_timezone_set('Asia/Kolkata');

if(date('l')=="Sunday" || date('l')=="Saturday")
	$err = "Its a holiday today .";									//Error messages to be made more appealing .
elseif(date('H')<8)
	$err = "College not yet started .";
elseif(date('H')==15 && date('i')>40)
	$err = "Can't locate teacher beyond college hours .";
elseif(date('H')>15)
	$err = "Can't locate teacher beyond college hours .";
elseif(date('H')==11 && date('i')>30)
	$err = "Its Lunch break now .";
elseif(date('H')==12 && date('i')<20)
	$err = "Its Lunch break now .";

if(empty($err))
{
	$day = date('l');
	$day = strtoupper(substr($day,0,3));
	if(date('H')== 8 && date('i')<50)
		$period = "Period 1";
	elseif(date('H')==8 && date('i')>=50)
		$period = "Period 2";
	elseif (date('H')==9 && date('i')<40)
		$period = "Period 2";
	elseif(date('H')==9 && date('i')>50)
		$period = "Period 3";
	elseif(date('H')==10 && date('i')<=40)
		$period = "Period 3";
	elseif(date('H')==10 && date('i')>40)
		$period = "Period 4";
	elseif(date('H')==11 && date('i')<=30)
		$period = "Period 4";
	elseif(date('H')==12 && date('i')>20)
		$period = "Period 5";
	elseif(date('H')==13 && date('i')<=10)
		$period = "Period 5";
	elseif(date('H')==13 && date('i')>10)
		$period = "Period 6";
	elseif(date('H')==14 && date('i')<=00)
		$period = "Period 6";
	elseif(date('H')==14 && date('i')>00)
		$period = "Period 7";
	elseif(date('H')==14 && date('i')<=50)
		$period = "Period 7";
	elseif(date('H')==14 && date('i')>50)
		$period = "Period 8";
	elseif(date('H')==15 && date('i')<=40)
		$period = "Period 8";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_ID = $_POST["Teacher_ID"];
    if(empty($input_ID)){
        $ID_err = "Please enter an ID.";
    }
    else
   		$Teacher_ID = $input_ID;
   	if(empty($err))
    {
    	try{
   			$sql = "SELECT `$period` FROM `$Teacher_ID` WHERE DAY= '$day'";
    		if($result = $pdo->query($sql)){
       			if($result->rowCount() > 0){

       			$row = $result->fetch(PDO::FETCH_ASSOC);
       			$location = $row["$period"];
       			echo "Teacher Located Successfully.";

       			} else{
           			 echo "<p class='lead'><em>No records were found.</em></p>";
        		}

  			}else{
        		echo "ERROR: Not able to execute $sql. " . $mysqli->error;
    		}
	}
	catch(PDOException $e){
		echo "Could not locate the teacher due to internal error";
        $err = "Teacher with ID :- $Teacher_ID is not resgistered";
	}
	}
}
//header("location: index-pdo-format.php");
  //  exit();

    // Close connection
    unset($pdo);
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
                <div class="col-md-20">
                    <div class="page-header">
                        <h2>Teacher Location :</h2>
                    </div>
                    <p>Please enter a teacher ID to locate him/her.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    	<div class="form-group <?php echo (!empty($ID_err)) ? 'has-error' : ''; ?>">
                    	<label>Teacher ID</label>
                            <input type="text" name= "Teacher_ID" class="form-control" value="<?php echo $Teacher_ID; ?>">
                            <span class="help-block"><?php echo $ID_err;?></span>
                        </div>
                    <?php
                    	if(isset($_POST['submit']) && empty($err)==0) :
                    ?>
                    	<p><h3><?PHP echo $err; ?></h3></p>
                    	<br>
                    <?php endif ?>
                    <?PHP
                        if(isset($_POST['submit']) && empty($err)) :
                        ?>
                        <p><h3><?PHP
                        if($location == "Free")
                        	echo "Teacher is currently present in the Staff room";
                        else
                        	echo "Teacher is currently present at hall number $location"; ?></h3></p>
                        <br>
                    <?php endif ?>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="index-pdo-format.php" class="btn btn-default">BACK</a>
                        <br><br><br><br>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>