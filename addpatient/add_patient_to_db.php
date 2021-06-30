<?php
$link = '../';
 require $link . 'commons/database_connect.php';


 if (!isset($_POST['name']) || $_POST['name']=='') {$name = '';}
 else {$name = addslashes($_POST['name']);}

 if (!isset($_POST['age']) || $_POST['age']=='') {$age = 0;}
 else {$age = addslashes($_POST['age']);}

 if (!isset($_POST['ageMonth']) || $_POST['ageMonth']=='') {$ageMonth = 0;}
 else {$ageMonth = addslashes($_POST['ageMonth']);}

 if (!isset($_POST['sex']) || $_POST['sex']=='') {$sex = '';}
 else {$sex = addslashes($_POST['sex']);}

 if (!isset($_POST['pc']) || $_POST['pc']=='') {$pc = '';}
 else {$pc = addslashes($_POST['pc']);}

 if (!isset($_POST['treatment']) || $_POST['treatment']=='') {$treatment = '';}
 else {$treatment = addslashes($_POST['treatment']);}

 if (!isset($_POST['tests_text']) || $_POST['tests_text']=='') {$tests_text = '';}
 else {$tests_text = addslashes($_POST['tests_text']);}

 if (!isset($_POST['tests']) || $_POST['tests']=='') {$tests = '';}
 else {$tests = addslashes($_POST['tests']);}

 if (!isset($_POST['price']) || $_POST['price']=='') {$price = 0;}
 else {$price = addslashes($_POST['price']);}



    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $sql = "INSERT INTO `patients`(`NAME`, `AGE`, `AGEMONTH` ,`SEX`, `DATE`, `PC`, `TREATMENT`, `TESTS`, `PRICE`, `TESTS_TEXT`,`ORIGINAL_ID`) VALUES ('$name','$age','$ageMonth','$sex',CURDATE(),'$pc','$treatment','$tests','$price','$tests_text',$id)";
    } else {
      $sql = "INSERT INTO `patients`(`NAME`, `AGE`, `AGEMONTH` ,`SEX`, `DATE`, `PC`, `TREATMENT`, `TESTS`, `PRICE`, `TESTS_TEXT`) VALUES ('$name','$age','$ageMonth','$sex',CURDATE(),'$pc','$treatment','$tests','$price','$tests_text')";
    }

    if ($conn->query($sql)==TRUE) {
      echo "Success";
    } else {
      echo $sql;
      //echo mysqli_error($conn);
    }
$conn->close();
?>
