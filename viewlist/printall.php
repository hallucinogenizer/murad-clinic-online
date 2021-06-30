<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Live Feed - Murad CLinic</title>

<?php
$link = '../';
require $link . 'commons/includes.php';
?>
<link rel="stylesheet" type='text/css' href='viewlist.css'>

<style>
div.header {
  background-color:white!important;
  margin-bottom:-30px!important;
}
h1.header {
  color:black!important;
}
table.show {
  width:100%!important;
}
.black {
  color:black;
}
.white {
  color:white;
}
body {
  background-image:none;
}
</style>
<script>
function defaultShowMore(x) {
	$(document).ready(function(){
		var i;
		for (i=1;i<=x;i++) {
			showNext();
		}
	});
}


function showDateField(type) {
  //this function is called when he clicks on one of the two buttons of Date selection
  if (type=='single') {//if he wants to search for a single date

    //see if the multi date selector is visible
    if ($('#multiDatePicker').css('display')=='block') {
      $('#multiDatePicker').slideToggle(500);//if yes, hide it
      window.setTimeout("$('.simple').slideToggle(500);",700);
    }
    else {
      $('.simple').slideToggle(500);
    }

  }//if type==simple
  else if (type=='range') {
    //check if the single date selector is visible
    if ($('.simple').css('display')=='block') {
      $('.simple').slideToggle(500);//hide it
      window.setTimeout("$('#multiDatePicker').slideToggle(500);",700);//show the multi-date selector
    }
    else {
      $('#multiDatePicker').slideToggle(500);
    }
  }
}


</script>

</head>

<body style='width:100%;height:100%;'>

<?php

$link = '../';
require $link . 'commons/header.php';

?>

<div class='' style='margin-top:30px;width:90%;margin-left:auto;margin-right:auto;'>

  <!--date changer-->
  <label id='datelabel' style='margin-top:30px;'><i class='fa fa-calendar-plus-o fa-fw blue' aria-hidden='true'></i> Choose another Date:</label>
  <table border='1' cellpadding='5px'><tr>
  	<td><a class='dateType' onClick="showDateField('single')" href='#'>One Date</a></td>
  	<td><a class='dateType' onClick="showDateField('range')" href='#'>A Range of Dates</a></td>
  </tr></table>

  <form method='get' action='printall.php' class='show' class="form-inline">
  	<div id='multiDatePicker' class='hidden'>
  		<p>Choose the starting date and ending date of your range. You will be shown combined statistics for all the days that lie within that range.</p>
  		<input type='hidden' name='range'>
  		<label for='from'>From:</label><input type='date' name='from' class='from form-control'><br>
  		<label for='to'>To:</label><input type='date' name='to' class='to form-control'>
  		<input type='submit' class='btn btn-primary'>
  </div>
  </form>



  <form method='get' action='printall.php' class='show' class="form-inline">
  <div class='hidden simple'>
  <input type='date' name='date' class='form-control' class='hidden'>
  </div>
  <div class='hidden simple'>
  <input type='submit' class='btn btn-primary'>
  </form>
  </div>
  </form>



<p id='total'></p>


<?php

require $link . 'commons/database_connect.php';

	$sql = "SELECT * FROM `patients` WHERE `DATE`=CURDATE() ORDER BY `NAME` LIMIT 0,9999999999999999999";

  //if he searched for a single date
	if (isset($_GET['date'])) {
		if ($_GET['date']!='') {
		$date = $_GET['date'];
		$sql = "SELECT * FROM `patients` WHERE `DATE`='$date' ORDER BY `NAME` LIMIT 0,9999999999999999999";
	}//not null
}//isset
else if (isset($_GET['range']) && isset($_GET['from']) && isset($_GET['to'])) {
	if ($_GET['from']!='' && $_GET['to']!='') {
		$from = $_GET['from'];
		$to = $_GET['to'];
	$sql = "SELECT * FROM `patients` WHERE `DATE` BETWEEN '$from' AND '$to' ORDER BY `NAME` LIMIT 0,9999999999999999999";
}//not null
}

	$result = $conn->query($sql);
	$count=0;
	$divnumber=1;
	$img='';
	$total = 0;
  echo "<table width='100%' class='table table-bordered show'>";
    while($row = $result->fetch_assoc()) {

		$count+=1;
		$total+=$row['PRICE'];

        echo "<tr id='" . $row['ID'] . "'><td class='name'><b>" . stripslashes($row['NAME']) . "</b><br>" . $row['AGE'] . " y/o<br>" . stripslashes($row['SEX']) . "</td><td class='pc'><h5>P/C:</h5><p>" . stripslashes($row['PC']) . "</p></td><td class='treatment'><h5>Treatment:</h5><p>" . stripslashes($row['TREATMENT']) . "</p></td><td class='tests'><h5>Tests:</h5><ul><li>" . str_replace('FALASHOLA123','</li><li>',stripslashes($row['TESTS'])) . "</li></ul></td><td class='price'><h6>Price:</h6><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";

  }
  echo "</table>";
	echo "<script>window.totaldiv = " . $divnumber . ";</script>";
	echo "<p>
  <span class='fa-stack'>
  <i class='fa fa-circle fa-stack-2x black fa-fw' aria-hidden='true'></i>
  <i class='fa fa-money fa-stack-1x white fa-fw' aria-hidden='true'></i>
  </span>
  <b>Total Charged: Rs. " . $total . "/-</b></p>";

	$sql2 = "SELECT `EXPENSE` FROM `expense` WHERE `DATE`=CURDATE() ORDER BY `ID` DESC LIMIT 0,9999999999999999999";

  //if he searched for a single date
  if (isset($_GET['date'])) {
    if ($_GET['date']!='') {
    $date = $_GET['date'];
    $sql2 = "SELECT EXPENSE FROM `expense` WHERE `DATE`='$date' ORDER BY `ID` DESC LIMIT 0,9999999999999999999";
  }//not null
  }//isset
  else if (isset($_GET['range']) && isset($_GET['from']) && isset($_GET['to'])) {
  if ($_GET['from']!='' && $_GET['to']!='') {
    $from = $_GET['from'];
    $to = $_GET['to'];
  $sql = "SELECT `EXPENSE` FROM `expense` WHERE `DATE` BETWEEN '$from' AND '$to' ORDER BY `ID` DESC LIMIT 0,9999999999999999999";
  }//not null
  }


	$result2 = $conn->query($sql2);
	$expense = 0;

	while($row2 = $result2->fetch_assoc()) {
		$expense+=$row2['EXPENSE'];
	}

	echo "<p>
  <span class='fa-stack'>
  <i class='fa fa-circle fa-stack-2x black fa-fw' aria-hidden='true'></i>
  <i class='fa fa-shopping-cart fa-stack-1x white fa-fw' aria-hidden='true'></i>
  </span>
  <b>Today's Expense: Rs. " . $expense . "/-</b></p>";


	$net = $total - $expense;

	echo "<p>
  <span class='fa-stack'>
  <i class='fa fa-circle fa-stack-2x black fa-fw' aria-hidden='true'></i>
  <i class='fa fa-balance-scale fa-stack-1x white fa-fw' aria-hidden='true'></i>
  </span>
  <b>Net Profit: Rs. " . $net . "/-</b></p>";
$conn->close();


?>



</body>
</html>
