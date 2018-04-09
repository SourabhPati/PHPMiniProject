<?php
session_start();
    if(!isset($_SESSION['username'])){
        header('location: adminlogin.php');
    }
  session_start();
  $username="";
  $email="";
  $errors=array();
  $db = mysqli_connect('localhost','root','','HOD');
  if(isset($_POST['reg_hod'])){
    $username=mysqli_real_escape_string($db,$_POST['username']);
    $email=mysqli_real_escape_string($db,$_POST['email']);
    $password_1=mysqli_real_escape_string($db,$_POST['password_1']);
    $password_2=mysqli_real_escape_string($db,$_POST['password_2']);
    if(empty($username)){array_push($errors,"username is required");}
    if(empty($email)){array_push($errors,"Email is required");}
    if(empty($password_1)){array_push($errors,"password is required");}
    if($password_1!=$password_2){array_push($errors,"The two passwords do not match");}
    $sql="SELECT * FROM users WHERE username = '$username' OR email= '$email' LIMIT 1";
    $result = mysqli_query($db,$sql);
    $user =mysqli_fetch_assoc($result);
      if($user){
      if($user['username']===$username){array_push($errors,"Username already exists");}
      if($user['email']===$email){array_push($errors,"email already exists");}
    }
    if(count($errors) ==0){
      $password=md5($password_1);
      $sql="Insert INTO users (username, email, password) VALUES('$username', '$email', '$password')";
      mysqli_query($db,$sql);
      $_SESSION['username'] = $username;
      $_SESSION['success']="You are now logged in";
      header('location:hod_login.php');
    }
  }
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Register HODs</title>
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <!-- navigation bar -->
  <nav class="navbar navbar-inverse navbar-static-top">
 <div class="container">
   <div class="navbar-header">
     <a class="navbar-brand" href="index.php">Teacher Tracker</a>
   </div>
 </div>
</nav>
<!-- navigation ends -->

  <h2>Welcome Admin </h2>
  <h3>Register HOD</h3>
<div class="container col-md-4 col-md-offset-4">
  <form method="post" action="register.php">
    <?php include('errors.php')?>
    <div class="input-group">
      <label class="control-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?php echo $username;?>">
    </div>
    <div class="input-group">
      <label class="control-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?php echo $email;?>">
    </div>
    <div class="input-group">
      <label class="control-label">Password</label>
      <input type="password" class="form-control" name="password_1">
    </div>
    <div class="input-group">
      <label class="control-label">Confirm Password</label>
      <input type="password" class="form-control" name="password_2">
    </div>
    <div class="input-group">
      <br>
      <button type="submit" class="btn btn-default" name="reg_hod">Register</button>
  </form>
</div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
