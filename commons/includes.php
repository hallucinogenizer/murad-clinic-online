<?php
if (!isset($link)) {
  $link='';
}
echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>

<script src='" . $link . "bootstrap/popper.min.js'></script>

<!-- Latest compiled JavaScript -->
<script src='" . $link . "bootstrap/js/tether.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel='stylesheet' type='text/css' href='" . $link . "commons/common.css'>";
if (!isset($_COOKIE['clinicTheme'])) {
?>
  <script>
	  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
	  setCookie('clinicTheme','blue.css',365);
	  location.reload();
  </script>
  <?php
} else {
  $clinicTheme = $_COOKIE['clinicTheme'];
}
echo "<link rel='stylesheet' type='text/css' href='" . $link . "commons/themes/" . $_COOKIE['clinicTheme'] . "'>
<link class='theme' rel='stylesheet' type='text/css' href='" . $link . "'>";
?>
