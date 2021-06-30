<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Live Feed - Murad CLinic</title>

<!-- Latest compiled and minified CSS -->


<?php
$link = '../';
require $link . 'commons/includes.php';
echo "<link rel='stylesheet' type='text/css' href='" . $link . "viewlist/viewlist.css'>";
?>

</head>

<body style='width:100%;height:100%;'>

<?php

$link = '../';
require $link . 'commons/header.php';

?>
<div style='width:99%;margin-top:5px;text-align:right;'>
		<i class="fa fa-print" aria-hidden="true"></i>
		Press Ctrl+P to Print Record
</div>

<div class='' style='margin-top:30px;'>
<div class='container'>
<p id='total'></p>




<?php

require $link . 'commons/database_connect.php';
  $history_id = $_GET['id'];
	$sql = "SELECT * FROM `patients` WHERE `ID`='$history_id' OR `ORIGINAL_ID`='$history_id'";

	$result = $conn->query($sql);
	$img='';

    while($row = $result->fetch_assoc()) {
		echo "<table class='table show'>";
		if ($row['AGE']<14) {
			if ($row['SEX']=='Male') {$img='male kid.png';}
			else {$img='female kid.png';}
		}
		else if ($row['AGE']<25) {
			if ($row['SEX']=='Male') {$img='man.png';}
			else {$img='woman.png';}
		}
		else if ($row['AGE']<46) {
			if ($row['SEX']=='Male') {$img='older man.png';}
			else {$img='older woman.png';}
		}
		else if ($row['AGE']<101) {
			if ($row['SEX']=='Male') {$img='really old man.png';}
			else {$img='really old woman.png';}
		}

    echo "<tr id='" . $row['ID'] . "'><td class='image'><img src='" . $link . "resources/" . $img . "' width='100px' height='100px'></td><td class='name'><b>" . stripslashes($row['NAME']) . "</b><br>" . stripslashes($row['SEX']) . "</td></tr>";
    echo "<tr><td>";
				if ($row['AGE']!=0) {
				echo $row['AGE'] . " Years ";
			}
				if ($row['AGEMONTH']!=NULL && $row['AGEMONTH']!=0) {
					echo $row['AGEMONTH'] . ' Months ';
				}

				echo "Old<br>" . date('F j, Y',strtotime($row['DATE'])) . "</td><td class='pc'><b><h4>P/C & Treatment:</h4></b><p>"
				 . stripslashes($row['PC']) . "</p></td><td class='treatment'><b><h4>Treatment:</h4></b><p>" . stripslashes($row['TREATMENT']) . "</p></td><td class='tests'><b><h4>Tests:</h4></b>";


				 echo "" . stripslashes($row['TESTS_TEXT'])
				  . "</td><td class='price'><h4>Price:</h4><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";


    }

echo "</table>";
$conn->close();


?>
</div><!--container div-->
</div>
<script src='viewlist.js'></script>
</body>
</html>
