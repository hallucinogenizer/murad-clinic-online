<?php
$link = '../';
 require $link . 'commons/database_connect.php';
	if (isset($_GET['id'])) {
		$sql0 = "DELETE FROM `patients` WHERE `ID`=" . $_GET['id'];
		if ($conn->query($sql0)) {
			echo "<script>window.location='index.php?success=true';</script>";
		} else {
			echo "<script>window.location='index.php?success=false';</script>";
		}
	}


?>
