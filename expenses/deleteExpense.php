<?php
 require '../commons/database_connect.php';
    //database connection found
    $id = $_GET['ID'];
    $sql = "DELETE FROM `expense` WHERE `ID`=$id";
    if ($conn->query($sql)) {
      echo "Success";
    } else {
      echo "Failed";
    }

    ?>
