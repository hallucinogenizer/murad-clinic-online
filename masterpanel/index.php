<?php
session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <link rel='stylesheet' type='text/css' href='../commons/common.css'>
</head>
<body>
  <?php
  if (!isset($_POST['username']) && !isset($_POST['password']) && !isset($_SESSION['login']) && !isset($_COOKIE['login'])) {
    require 'masterheader.php';
   ?>


<form action='index.php' method='post'>
  <input type='text' name='username' placeholder='Username'>
  <input type='password' name='password' placeholder='Password'>
  <input type='submit'>
</form>
  <?php
} else if (isset($_POST['username']) && isset($_POST['password']) && !isset($_SESSION['login']) && !isset($_COOKIE['login'])) {
  $usernamelogin = $_POST['username'];
  $password = $_POST['password'];

  $commonsalt = 'AllahHafiz';

  $salt = "lbhYHSMmMYV9oig3xKeDpU.YOJOHjOEJ4fsBDwR9w9Y=";

  $salted_hash = hash('sha256',$password.$commonsalt.$salt);
  //password= zgNqYvrgnPzmrVJd5F
  if ($salted_hash=="a2682d2ef55678e7d463a7a7001a85461a0684db3c6dc2c6546485857118a1cc" && $usernamelogin == 'hallucinogenizer') {
    //login successful
    session_start();
    $_SESSION['login']=true;
    $cookie_name = "login";
    $cookie_value = "true";
    setcookie($cookie_name, $cookie_value, time() + (2* 86400 * 30), "/", null, true, true); // 86400 = 1 day and 2* means two days
    Header('Location:index.php');
  }
} else if (isset($_COOKIE['login']) && $_COOKIE['login']==true) {
    $_SESSION['login']==true;
    Header('Location:panel.php');
}
   ?>
</body>
</html>
