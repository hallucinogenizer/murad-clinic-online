
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<?php
  $preLink = '../';
  require '../commons/includes.php';
?>
   <link rel='stylesheet' type='text/css' href='../login/login.css'>
   <script src='../bootstrap/backstretch/backstretch.js'>
   </script>
  </head>

  <body>
    <script>
      $.backstretch('../resources/background3.jpg');
    </script>
  <?php
  if (!isset($_POST['keyvalue']) && !isset($_POST['password']) && !isset($_POST['signup'])) {
   ?>

   <div class='intro_text'>
     <h1><b>WE</b>MR</h1>
     <h2>The all new smart EMR for your clinic, now completely free.</h2>
   </div>


   <div class='login'>
<form method='post' action='index.php' class='form-inline'>
  <input type='number' name='keyvalue' placeholder='Enter your key here' maxlength='20' class='form-control'>
  <button type='submit' class='btn btn-primary'>Create My Account</button>
</div>
  <p class='error'>
    <?php
      if (isset($_GET['incomplete'])) {
        echo "Please fill all fields.";
      } else if (isset($_GET['mismatchedpasswords'])) {
        echo "Please enter the same password in both fields.";
      } else if (isset($_GET['usernameexists'])) {
        echo "This username is already taken. Please choose another one.";
      } else if (isset($_GET['passwordlength'])) {
        echo "Your password must at least be 10 characters long and must not exceed 100 characters.";
      }
    ?>
  </p>
</form>
<?php
} else if (isset($_POST['keyvalue']) && !isset($_POST['password'])){
   require '../commons/database_connect.php';
      $code = $_POST['keyvalue'];
      $sql = "SELECT * FROM `added_employee`";
      $result = $conn->query($sql);
      $id = 0;
      while ($row = $result->fetch_assoc()) {
        if ($row['KEYVALUE']==$code) {
          $id = $row['ID'];
        }
      }
      if ($id!=0) {
      $sql2 = "DELETE FROM `added_employee` WHERE `ID`='$id'";
      if ($conn->query($sql2)) {
?>

<div class='intro_text'>
  <h1><b>WE</b>MR</h1>
  <h2>The all new smart EMR for your clinic, now completely free.</h2>
</div>

<div class='login'>
<form type='form' name='form2' method='post' action='index.php'>
  <div class='form-group'>
    <label for='username'>Choose a username</label>
    <input type='text' name='username' placeholder='' class='form-control'>
  </div>
  <div class='form-group'>
  <label for='password'>Choose a password</label>
    <input type='password' name='password' placeholder='' id='pass1' minlength='10' maxlength='100' class='form-control'>
  </div>
  <div class='form-group'>
    <label for='password2'>Choose a password</label>
    <input type='password' name='password2' placeholder='' id='pass2' minlength='10' maxlength='100' class='form-control'>
  </div>
  <input type='hidden' name='signup'>
  <button type='submit' class='btn btn-primary'>Sign Up</button>
</form>
</div>
<?php
      }
    } else {
      echo "Wrong key. <a href='index.php'>Try again.</a>";
    }


 ?>

 <?php

} else if (isset($_POST['signup']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {
   require '../commons/database_connect.php';


  $username = mysqli_real_escape_string($conn,$_POST['username']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);
  $password2 = mysqli_real_escape_string($conn,$_POST['password2']);

  if ($username=='' || $password =='' || $password2=='') {
    header('Location:index.php?incomplete');
  }
  else if ($password != $password2) {
    header('Location:index.php?mismatchedpasswords');
  } else if (strlen($password)<10 || strlen($password)>100) {
    header('Location:index.php?passwordlength');
  } else {
    //check if username exists
     require 'commons/database_connect.php';
     
    $sql5 = "SELECT `username` FROM `users` WHERE 1";
    $result5 = $conn->query($sql5);
    while ($row5 = $result5->fetch_assoc()) {
      if ($username == $row5['username']) {
          header('Location:index.php?usernameexists');
      }
    }


    $commonsalt = 'AllahHafiz';

    function RandomToken($length = 32){
        if(!isset($length) || intval($length) <= 8 ){
          $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }

    function Salt(){
        return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);
    }

    $salt = Salt();

    $salted_hash = hash('sha256',$password.$commonsalt.$salt);


    $sql4 = "INSERT INTO `users` (username, password, salt) VALUES ('$username','$salted_hash','$salt')";
    if ($conn->query($sql4)) {
        header('Location:../login/index.php');
    }
  }

}?>
</body>
</html>
