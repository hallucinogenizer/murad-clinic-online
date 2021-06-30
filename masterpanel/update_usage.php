<?php

require '../commons/getResult.php';
require '../commons/database_connect.php';
$userID = $_COOKIE['user'];
$newRecord=false;
$noEndingTime=false;
$sql0 = "SELECT `ID`,`STARTING TIME`, `ENDING TIME`,`DATE`, TIMESTAMPDIFF(SECOND, `STARTING TIME`, NOW()), TIMESTAMPDIFF(SECOND, `ENDING TIME`, NOW()) FROM  `usage_stats` WHERE `DATE`=CURDATE() AND `USER`='$userID' ORDER BY `ID` DESC LIMIT 1";
$result = getResult($sql0);
if ($result==false) {
  $sql1 = "INSERT INTO `usage_stats`(`STARTING TIME`, `DATE`,`USER`) VALUES (NOW(),CURDATE(),'$userID')";
  $conn->query($sql1);
} else {
  while ($row = $result->fetch_assoc()) {
    echo '1';
    $id = $row['ID'];
    if ($row['ENDING TIME']==null || $row['ENDING TIME']=='') {
      $noEndingTime=true;
      echo '2';
        if ($row["TIMESTAMPDIFF(SECOND, `STARTING TIME`, NOW())"]>120) {
          echo '3';
          $newRecord = true;
        }
    } else {
      echo '4';

        if ($row["TIMESTAMPDIFF(SECOND, `ENDING TIME`, NOW())"]>120) {
          echo '5';
          $newRecord = true;
        }
    }
  }


  if ($noEndingTime==true || $newRecord==false) {
    echo '6';
    $sql3 = "UPDATE `usage_stats` SET `ENDING TIME`=NOW() WHERE `ID`='$id'";
    $conn->query($sql3);
  }
  if ($newRecord==true) {
    echo '7';
    $sql4 = "INSERT INTO `usage_stats`(`STARTING TIME`,`DATE`,`USER`) VALUES (NOW(),CURDATE(),'$userID')";
    $conn->query($sql4);
  }

}
 ?>
