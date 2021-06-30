<!--Header code starts-->
<?php

//checking login status

session_start();
if (isset($_COOKIE['login'])) {
    $_SESSION['login']==true;
    header('Location:index.php');
}

//checking login status ends

//creating logout button
echo "<a href='logout.php'><div id='logout_button'><i class='fa fa-power-off' aria-hidden='true'></i> Logout</div></a>";
?>
<div class="header">
<a class="main" href="index.php">
  <h1 class="header" data-toggle="tooltip" title="Go to Home Page">Master Panell</h1></a>
</div>
<!--Header code ends-->
