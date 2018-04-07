<?php
  session_start();
$username="";
$email="";
$errors=array();
$db = mysqli_connect('localhost','root','','admin_db');
  //for Login
  if(isset($_POST['admin_log'])){
    $username= mysqli_real_escape_string($db,$_POST['username']);
    $password= mysqli_real_escape_string($db,$_POST['password']);
    if(empty($username)){
        array_push($errors,"Username is Required");
    }
    if(empty($password)){
        array_push($errors,"Password is required");
    }
    if(count($errors)==0){
      $query="SELECT * FROM users WHERE username='$username' AND password='$password'";
      $results=mysqli_query($db,$query);
      if(mysqli_num_rows($results)==1){
        $_SESSION['username']=$username;
        $_SESSION['success']="You are now logged in";
        header('location: register.php');
      }
      else{
        array_push($errors,"Wrong username/password combination");
      }
    }
    }
  ?>
<?php
  if(!isset($_POST['login_hod'])){
  if(isset($_SESSION['username'])){
    echo "Session expired";
    $_SESSION=array();
  }
} ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Log in</title>
  <!--  <link rel="stylesheet" type="text/css" href="style.css"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-static-top">
   <div class="container">
     <div class="navbar-header">
       <a class="navbar-brand" href="index.php">Teacher Tracker</a>
     </div>
   </div>
  </nav>
    <h2>Admin LOGIN</h2>
  <div class="container col-md-4 col-md-offset-4">
    <form class="form-horizontal" method="post" action="adminlogin.php">
      <div class="form-group">
        <label class="control-label col-sm-2">Username</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" name="username">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2">Password</label>
        <div class="col-sm-5">
          <input type="password" class="form-control" name="password">
        </div>
      </div>
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="admin_log">Login</button>
      </div>
    </form>
  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
  </html>
