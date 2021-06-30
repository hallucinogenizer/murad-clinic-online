<?php
$link = '../';
require $link . 'commons/database_connect.php';

$nameis=false;$ageis=false;$sexis=false;$dateis=false;$fromis=false;$tois=false;$ageMonthis=false;

if (isset($_GET['name'])) {if ($_GET['name']!='') {$name = $_GET['name'];$nameis=true;}}
if (isset($_GET['age'])) {if ($_GET['age']!='') {$age = $_GET['age'];$ageis=true;}}
if (isset($_GET['ageMonth'])) {if ($_GET['ageMonth']!=0) {$ageMonth = $_GET['ageMonth'];$ageMonthis=true;}}
if (isset($_GET['sex'])) {if ($_GET['sex']!='') {$sex = $_GET['sex'];$sexis=true;}}
if (isset($_GET['date'])) {if ($_GET['date']!='') {$date = $_GET['date'];$dateis=true;}}
if (isset($_GET['from'])) {if ($_GET['from']!='') {$date = $_GET['from'];$fromis=true;$dateis=false;}}
if (isset($_GET['to'])) {if ($_GET['to']!='') {$date = $_GET['to'];$tois=true;$dateis=false;}}
//$date = str_replace('/', '-', $date);
//echo date('Y-m-d', strtotime($date));

//$date = strtotime($_GET["date"]);
//$date = date('Y-m-d H:i:s', $date);
//echo $nameis. 'NAME<br>' . $ageis . 'AGE<br>' . $sexis. 'SEX<br>' . $dateis. 'DATE<br>' . $fromis. 'FROMO<br>' . $tois. 'TO<br>' . $ageMonthis;


if ($conn->connect_error) {
	die("Failed");
} else {
	$and=false;
	$sql = "SELECT `ID`, `NAME`, `AGE`,`AGEMONTH`, `SEX`, `DATE` FROM `patients` WHERE ";
	 if (!$nameis && !$ageis && !$ageMonthis && !$sexis && !$dateis && !$fromis && !$tois) {
		 $sql .= "1 " ;
	 }
	 if ($nameis) {$sql .= "`NAME` LIKE '%" . $name . "%' ";$and = true;}
	 if ($ageis) {
		 if ($and) {$sql .= "AND ";$and=false;}
		 $sql .= "`AGE`=$age ";
		 $and=true;
		 }//isset age
		 if ($ageMonthis) {
	 		if ($and) {$sql .= "AND ";$and=false;}
	 		$sql .= "`AGEMONTH`=$ageMonth ";
	 		$and=true;
	 		}//isset age
	 if ($sexis) {
		 if ($and) {$sql .= "AND ";$and=false;}
		 $sql .= "`SEX`='$sex' ";
		 $and=true;
	 }//isset sex
	  if ($dateis) {
		 if ($and) {$sql .= "AND ";$and=false;}
		 $sql .= "`DATE`='$date' ";
	 }//isset date
	 if ($fromis && $tois) {
		if ($and) {$sql .= "AND ";$and=false;}
		$from = $_GET['from'];
		$to = $_GET['to'];
		$sql .= "`DATE` BETWEEN '$from' AND '$to' ";
	}//isset date


	$sql .= " AND `ORIGINAL_ID` IS NULL ORDER BY `DATE` DESC LIMIT 18446744073709551615";

	$result = $conn->query($sql);


	if ($result->num_rows > 0) {

    // output data of each row
$tdDisplayed=false;
$monthDisplayed=false;
    while($row = $result->fetch_assoc()) {
			if (!isset($row['ORIGINAL_ID'])) {
				$row['ORIGINAL_ID']='';
			}
        echo "<tr id='" . $row['ID'] . "' onClick='getDetails(this)' data-original_id='" . $row['ORIGINAL_ID'] . "'><td>" . $row['ID'] . "</td><td class='name'>" . stripslashes($row['NAME']) . "</td>";


			if  ($row['AGE']!=0) {
				echo "<td class='age'>" . $row['AGE'] . " Years ";
				$tdDisplayed=true;
			}
			if ($row['AGEMONTH']!=0 && $row['AGEMONTH']!=NULL) {
				if ($tdDisplayed==false) {
					echo "<td class='age'>";
				}
				echo $row['AGEMONTH'] . " Months ";
				$monthDisplayed=true;
			}
			if ($tdDisplayed==true || $monthDisplayed==true) {
			echo "Old</td>";
		}
				echo "<td class='sex'>" . stripslashes($row['SEX']) . "</td><td class='date'>" . $row['DATE'] . "</td></tr>";

    }
} else {
    echo "<tr><td>--</td><td>No Results Found</td><td>--</td><td>--</td><td>--</td></tr>";
}
$conn->close();
}

?>
