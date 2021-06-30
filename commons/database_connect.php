<?php
$servername2 = 'localhost';
  $username2 = 'wehsdwzq_roohani';
  $password2 = '7XH7zMXbjDpyz4hc8LJR';
  $dbname2 = 'wehsdwzq_wemr';
  /*
  $servername2 = 'localhost';
    $username2 = 'root';
    $password2 = '';
    $dbname2 = 'db_murad';*/

  $conn = new mysqli($servername2, $username2, $password2, $dbname2);

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    ?>
    
    
  