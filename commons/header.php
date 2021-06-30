<!--Header code starts-->
<?php
header("X-XSS-Protection: 1; mode=block");
//checking login status
session_start();
if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {
  $_SESSION['user']=$_COOKIE['user'];
    header('Location:' . $link . 'login/index.php');
}
//checking login status ends


//outputing the User's name before Logout logout button
require $link . 'commons/database_connect.php';
$userID = $_COOKIE['user'];
$sql0 = "SELECT `username` FROM `users` WHERE `ID`='$userID' LIMIT 0,1";
$result0 = $conn->query($sql0);
$userName = '';
while ($row0 = $result0->fetch_assoc()) {
  $userName = $row0['username'];
}

//creating logout button
echo "<a href='" . $link . "login/logout.php'><div id='logout_button'><p>Welcome " . $userName . "</p><i class='fa fa-power-off' aria-hidden='true'></i> Click to Logout</div></a>";

?>
<script>
//set up an Interval function to record the usage stats
window.setInterval(function(){
  <?php
  echo "$.get('" . $link . "masterpanel/update_usage.php',{});";
  ?>
},30000);
</script>
<?php

require $link . 'commons/getResult.php';
$sql = "SELECT `VALUE`,`ADDITIONAL_INFO` FROM `site_info` WHERE `INFO_TYPE`='CLINIC NAME' LIMIT 1";
$result = getResult($sql);
$clinic_name = '';
$additional_name_info = array();
while($row = $result->fetch_assoc()) {
    $clinic_name = $row['VALUE'];
    $additional_name_info = unserialize(stripslashes($row['ADDITIONAL_INFO']));
}
?>

<div class='header'>
  <?php
  //$array = array('NOIMG','CAP');
  //echo serialize($array);
  ?>

<?php
if ($additional_name_info['IMG'] == 'TRUE') {
    echo "<table><tr><td style='padding-right:10px;'><a href='" . $link . "index.php'><img src='" . $link . $additional_name_info['IMGSRC'] ."' height='60rem'></a></td><td>";
}
 ?>
<a class='main' href='<?php echo $link;  ?>index.php'>
  <h1 class='header' data-toggle='tooltip' title='Go to Home Page'>
    <?php
    if ($additional_name_info['CAP'] == 'FALSE') {
        echo $clinic_name;
    } else if ($additional_name_info['CAP'] == 'TRUE')  {
        echo strtoupper($clinic_name);
    }
     ?>
  </h1></a>


  <?php
  if ($additional_name_info['IMG'] == 'TRUE') {
      echo "</td></tr></table>";
  }
   ?>

</div>
<!--Header code ends-->
