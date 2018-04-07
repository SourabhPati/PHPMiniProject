<?php include('server.php')?>
<?php
  
?>
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
<h2>HOD login</h2>
<div class="container col-md-4 col-md-offset-4">
  <form class="form-horizontal" method="post" action="hod_login.php">
    <?php include('errors.php')?>
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
      <button type="submit" class="btn btn-default" name="login_hod">Login</button>
    </div>
  </form>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
