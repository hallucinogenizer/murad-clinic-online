<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Expenses - Murad Clinic</title>
<!-- Latest compiled and minified CSS -->
<?php
$link = '../';
require $link . 'commons/includes.php';
 ?>
 <link rel='stylesheet' href='../font-awesome/css/font-awesome.min.css'>
<link rel="stylesheet" type='text/css' href='expenses.css'>

<script src='preload.js'></script>
</head>

<body style='width:100%;'>

<?php

require $link . 'commons/printToTable.php';
echo "<script>var showing=false;</script>";

//code for adding an expense after form was submitted and landed on this page wiith GET data

//see if the required fields were set
if (isset($_GET['expense']) && isset($_GET['type']) && isset($_GET['date'])) {

//check if a required field was set but was empty, if so return error
if ($_GET['expense']==null) {echo "<script>alert('Please enter an expense.');</script>";}
if ($_GET['type']==null) {echo "<script>alert('Please choose a type of expense.');</script>";}
if ($_GET['date']==null) {echo "<script>alert('Please enter a date.');</script>";}

//not proceed with generating the SQL Query if none of the required fields was null
if ($_GET['date']!=null && $_GET['expense']!=null && $_GET['type']!=null) {

  //setting up the connection
  require  $link . 'commons/database_connect.php';

  //getting the $_GET[''] variables and storing them in php normal variables
  $type = $_GET['type'];
  $expense = $_GET['expense'];
  $date = $_GET['date'];

  if ($conn->connect_error) {
  	die("Connection to Database Failed.");
  } else {
    //connection found

    $titlefound=false;//the TITLE Field was optional. We will generate an SQL Query Statement depending on whether or not the user provided a TITLE.
      $sql = "INSERT INTO `expense`(`TYPE`, `EXPENSE`, `DATE`"; //this part of the statement will remain the same whether the TITLE is provided or not


      if (isset($_GET['title'])) {//make sure that he did give a title
        if ($_GET['title']!=null) {//make sure the title wasn't empty
          $titlefound=true;
          $title = $_GET['title'];
          $sql.=", `TITLE`";//increment this to the sql statement
        }//if title ain't null
      }//if isset title
      $sql.=") VALUES('$type', '$expense', '$date'";//increment to the SQL Statement - this part will be the same whether TITLE is present or not
      if ($titlefound) {$sql.=", '$title'";} //If title  is present, increment this to the SQL Statemnet
      $sql.=")";//the last part of the SQL Statement - remains same regardless of whether TITLE was given or not


    if ($conn->query($sql)==TRUE) {
      echo "<script>showModal('Success', 'Your expense has been successfully added.');</script>";//display a Bootstrap MODAL showing Success message. Bootstrap Modal has been defined in commons/modal.php
    } else {
      //echo mysqli_error($conn); We don't want to show the user  a scary PHP Error
      echo "<script>showModal('Failed', 'Your expense has NOT been added.');</script>";
    }
    $conn->close();

  }//if connection didn't fail 'else'
}//isn't null
}//isset
$link = '../';
require $link . 'commons/header.php';
 ?>








<table class='main_item' style='width:100%;'>
<tr>

<td align='center'>
<div class='main_item' onClick="$('#add_expense').slideToggle('fast');">
<i class="fa fa-plus-circle" aria-hidden="true"></i>
<p>Add Expense</p>
</div>
</td>


<td align='center'>
<div class='main_item' onClick="showerRedirect()">
<i class="fa fa-eye" aria-hidden="true"></i>
<p>View/Edit Expenses</p>
</div>
</td>

</tr>
</table>


<div class='container'>
<div id='add_expense'>

<form type='post' action='index.php' name='form' class='form-inline' method='get' action='index.php'>


<label for='type' class='first'>Type of Expense:</label>

<select name='type' id='select_type' class='form-control' required>

<?php
$myfile = fopen("types.txt", "r") or die("Unable to open file!");
$typestext = fread($myfile,filesize("types.txt"));
fclose($myfile);
echo $typestext;
echo "<option id='addnew'>Add new type</option>";
echo "<option id='removeold'>Delete a type</option>";
?>

</select>



<label for='expense'>Expense:</label>
<input type='number' name='expense' class='form-control' placeholder='Rupees' required>

<label for='date'>Date:</label>
<input type='date' name='date' class='form-control' id='dateField' required>

<label for='title'>Add Title:</label>
<input type='text' name='title' class='form-control'>

<input type='submit' class='btn btn-primary'>

</form>
</div><!--add_expense div ends-->







<?php

include '../commons/modal.php';


if (isset($_GET['success'])) {

?>
<script>
showModal('Success','Your selected Type has been deleted.')
</script>

<?php
} else if (isset($_GET['failed'])) {

?>
<script>
showModal('Failed','Your selected Type could not be deleted.')
</script>
<?php
}




//advanced search options
include '../commons/advancedsearchoptions.php';






//print today's expenses - normal
if (isset($_GET['show'])) {

?>
<script>
  $('#advanceddisplayer').fadeIn();
  showing=true;
</script>
<?php
  $result = getResult("SELECT * FROM `expense` WHERE `DATE`=CURDATE() ORDER BY `ID` LIMIT 0,9999999999");
  if ($result==false) {echo "No result found";} else {
    printToTable($result);
}//if result is not false
}







if (isset($_GET['searching'])) {

  $sql = "SELECT * FROM `expense`";

  if (isset($_GET['searchdate']) || isset($_GET['searchtype']) || isset($_GET['searchtitle']) || isset($_GET['searchexpense'])) {

    $and=false;
    if (isset($_GET['searchdate'])) {
      if ($_GET['searchdate']!=NULL) {
        $date = $_GET['searchdate'];
        $sql.=" WHERE `DATE`='$date'";
        $and=true;
      }// date  not null
    }

    if (isset($_GET['searchtype'])) {
      if ($_GET['searchtype']!=NULL) {
        if ($and) {$sql.=" AND";} else {$sql.=" WHERE";$and=true;}
        $type = $_GET['searchtype'];
        $sql.=" `TYPE`='$type'";
      }// type not null
    }

    if (isset($_GET['searchtitle'])) {
      if ($_GET['searchtitle']!=NULL) {
        if ($and) {$sql.=" AND";} else {$sql.=" WHERE";$and=true;}
        $title = $_GET['searchtitle'];
        $sql.=" `TITLE`='$title'";
      }// title  not null
    }

    if (isset($_GET['searchexpense'])) {
      if ($_GET['searchexpense']!=NULL) {
        if ($and) {$sql.=" AND";} else {$sql.=" WHERE";}
        $expense = $_GET['searchexpense'];
        $sql.=" `EXPENSE`='$expense'";
      }// expense  not null
    }



    }
    if (!isset($_GET['range'])) {
    $result = getResult($sql);
      if ($result==false) {
    echo "No result found.";
      } else {
    printToTable($result);
  }
  }//something isset



?>
<script>
$(document).ready(function(){
  $('table.show').css('margin-top','30px');
  $('#advancedsearchoptions').css('margin-top','30px');

  if (isset($_GET['comingfromstatspage'])) {
    $comingfromstatspage = true;

  } else {
    $comingfromstatspage = false;
  }
  if ($comingfromstatspage==false) {
  $('#advancedsearchoptions').fadeIn();
}
});
</script>
<?php

}//if he's searching for something ends




//if he is searching for a RANGE starts


if  (isset($_GET['range'])) {


$from = $_GET['from'];
$to = $_GET['to'];
$sql = "SELECT * FROM `expense` WHERE `DATE` BETWEEN '" . $from . "' AND '" . $to . "' ";
if (isset($_GET['searchtype'])) {
  if ($_GET['searchtype']!='') {
    $searchtype = $_GET['searchtype'];
    $sql.="AND `TYPE`='$searchtype' ";
  }
}
$sql.="ORDER BY `ID` LIMIT 0,9999999999";
$result = getResult($sql);
if ($result!=false) {
printToTable($result);
} else {
    echo "No Expenses found.";
}

?>


<script>
$(document).ready(function(){
  $('#advanceddisplayer').fadeIn();
  $('#continue').attr('onClick','location.reload();')
});
</script>



<?php
}
//range search ENDS

?>
<script src='expenses.js'>
</script>

</div><!--container div ends-->
</body>
</html>
