<?php
$id = $_GET['ID'];
$history = false;
$no_of_histories = 0;
$link = '../';
require $link .  'commons/database_connect.php';

		//to get latest record, we first check whether or not a record of this patient exists in the patients_history table
		$sql0 = "SELECT * FROM `patients` WHERE `ID`='$id' OR `ORIGINAL_ID`='$id' ORDER BY `ID` DESC";
		$result = $conn->query($sql0);
			$history = true;
			$no_of_histories = $result->num_rows;//aik patients wala aur aik patients_history wala
		

$only_one = 0;

    while($row = $result->fetch_assoc()) {
			$only_one = $only_one+1;
			if ($only_one<2) {
			if ($history==true) {
				echo "<tr><td><h3>Showing Latest Record</h3></td></tr>";
				echo "<tr><td><span style='color:red;'>" . $no_of_histories . " record(s) found </span>";
				echo "<a href='patienthistory.php?id=" . $id . "'><button>See Patient History</button></a></td></tr>";
			}
        echo "<tr><td><h4>P/C:</h4><p>" . stripslashes($row['PC']) . "</p></td></tr><tr><td><h4>Treatment:</h4><p>" . stripslashes($row['TREATMENT']) . "</p></td></tr><tr><td><h4>Tests:</h4>";
				echo stripslashes($row['TESTS_TEXT']) . "</td></tr><tr><td><h5>Price:</h5><p>Rs. " . $row['PRICE'] . "/-</p></td></tr>";
}
}

$conn->close();




?>
