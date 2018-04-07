<?php
session_start();
$username="";
$email="";
$errors=array();
$db = mysqli_connect('localhost','root','','HOD');
  //for Login
  if(isset($_POST['login_hod'])){
    $username= mysqli_real_escape_string($db,$_POST['username']);
    $password= mysqli_real_escape_string($db,$_POST['password']);
    $password=md5($password);
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
        header('location: index-pdo-format.php');
      }
      else{
        array_push($errors,"Wrong username/password combination");
      }
    }
    }
 ?>
