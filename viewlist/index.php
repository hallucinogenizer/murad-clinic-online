<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Live Feed - Murad CLinic</title>

<!-- Latest compiled and minified CSS -->


<?php
$link = '../';
require $link . 'commons/includes.php';
?>

<link rel="stylesheet" type='text/css' href='viewlist.css'>

<script>
function defaultShowMore(x) {
	$(document).ready(function(){
		var i;
		for (i=1;i<=x;i++) {
			showNext();
		}
	});
}
</script>

</head>

<body style='width:100%;height:100%;'>

<?php

$link = '../';
require $link . 'commons/header.php';

?>
<div style='width:99%;margin-top:5px;text-align:right;'>
	<a href='printall.php'>
		<i class="fa fa-print" aria-hidden="true"></i>
		Print All</a>
</div>

<div class='' style='margin-top:30px;'>

<p id='total'></p>




<?php

require $link . 'commons/database_connect.php';

	$sql = "SELECT * FROM `patients` WHERE `DATE`=CURDATE() ORDER BY `ID` DESC LIMIT 0,9999999999999999999";


	$result = $conn->query($sql);
	$count=0;
	$divnumber=1;
	$img='';
	$total = 0;
    while($row = $result->fetch_assoc()) {

		$count+=1;
		$total+=$row['PRICE'];
		if ($count==1) {echo "<table class='table show sublist" . $divnumber . "'>";}
		else if ($count%15==0) {
			$divnumber+=1;
			if (!isset($_GET['showmore'])) {
				echo "</table><table class='table sublist" . $divnumber . "'>";}
				else {//if showmore isset
					if ($_GET['showmore']==$divnumber) {
						echo "</table><table class='table show sublist" . $divnumber . "'>";
					}
				}
			}



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


        echo "<tr id='" . $row['ID'] . "'><td class='image'><img src='" . $link . "resources/" . $img . "' width='100px' height='100px'></td><td class='name'><b>" . stripslashes($row['NAME']) . "</b><br>";

				if ($row['AGE']!=0) {
				echo $row['AGE'] . " Years ";
			}
				if ($row['AGEMONTH']!=NULL && $row['AGEMONTH']!=0) {
					echo $row['AGEMONTH'] . ' Months ';
				}

				echo "Old<br>" . stripslashes($row['SEX']) . "</td><td class='pc'><h5>P/C & Treatment:</h5><p>"
				 . stripslashes($row['PC']) . "</p></td><td class='treatment'><h5>Treatment:</h5><p>" . stripslashes($row['TREATMENT']) . "</p></td><td class='tests'><h5>Tests:</h5>";


				if ($row['TESTS']!='null') {
				 echo "<ul><li>" . str_replace('FALASHOLA123','</li><li>',stripslashes($row['TESTS'])) . "</li>";

					 if ($row['TESTS_TEXT']!='') {
						 echo "<li>" . stripslashes($row['TESTS_TEXT'])
						  . "</li></ul></td><td class='price'><h6>Price:</h6><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";
						} else {
							echo "</ul></td><td class='price'><h6>Price:</h6><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";
						}


			 } else {
				 echo "" . stripslashes($row['TESTS_TEXT'])
				  . "</td><td class='price'><h6>Price:</h6><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";
			 }

    }

	echo "</table>";


$conn->close();


?>
<div class='expand_tests' onClick='showNext()'>
    	<span onClick='showNext()'>Show More</span>
        <span style='float:right;'><img src='<?php echo $link . "resources/down_arrow.png"; ?>' width='10px'></span>
    </div>
</div>
<script src='viewlist.js'></script>
</body>
</html>
