<?php


function getResult($sql) {
 $servername = 'localhost';
  $username = 'wehsdwzq_roohani';
  $password = '7XH7zMXbjDpyz4hc8LJR';
  $dbname = 'wehsdwzq_wemr';
  /*$servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_murad';*/

  $conn = new mysqli($servername, $username, $password, $dbname);
  //seeking connection to database
    if ($conn->connect_error) {
    	die("Connection to Database Failed.");
    } else {
      //database connection found


      $result = $conn->query($sql);
      if ($result->num_rows > 0) {return $result;}
      else {
        return false;
      }//if result rows>0
    }//else ends
  }//getResult function ends


?>

