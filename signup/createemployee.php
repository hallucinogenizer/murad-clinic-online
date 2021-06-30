<?php

//checking login status
session_start();
if ($_SESSION['user']=='') {
    header('Location:../login/index.php');
}
//checking login status ends

 ?>


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
  if (!isset($_POST['create'])) {
   ?>

   <div class='intro_text'>
     <h1><b>WE</b>MR</h1>
     <h2>The all new smart EMR for your clinic, now completely free.</h2>
   </div>

   <div class='login'>
<form method='post' action='createemployee.php'>
  <input type='hidden' name='create'>
  <button type='submit' class='btn btn-primary'>Create New Employee Account</button>
</form>
</div><!--<div class='login' ends-->

<?php
} else {
   require '../commons/database_connect.php';
      $code = rand(1000,1000000);
      $sql = "INSERT INTO `added_employee` (KEYVALUE) VALUES ($code)";
      if ($conn->query($sql)) {

?>
<div class='login'>
<h4>Ask your employee to visit<h4>
<h4><a href='wemr.pk/signup'>wemr.pk/signup</a></h4>
<h4>and enter the following key there:</h4>
<h1 style='font-size:50px;'><?php echo $code; ?></h1>
<a href='../index.php'><button type='button' class='btn btn-primary'>Return to Home Page</button></a>
</div>
<?php
      }
    
 ?>

 <?php

} ?>
</body>
</html>
