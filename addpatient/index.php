<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Patient - Murad Clinic</title>

<!-- Latest compiled and minified CSS -->
<?php
$link = '../';
require $link . 'commons/includes.php';
?>
<link rel="stylesheet" type='text/css' href='addpatient.css'>

<?php
if (isset($_GET['id'])) {
	echo "<script>window.idhai=true;</script>";
$id = $_GET['id'];
echo "<script>window.id = " . $id . ";</script>";

 require $link . 'commons/database_connect.php';

	$sql = "SELECT `NAME`,`AGE`,`AGEMONTH`,`SEX`,`PC`,`TREATMENT`,`PRICE`,`TESTS_TEXT`,`TESTS` FROM `patients` WHERE `ID`=$id";
	$result = $conn->query($sql);



    while($row = $result->fetch_assoc()) {
        $name = $row['NAME'];
		$age = $row['AGE'];
		$ageMonth = $row['AGEMONTH'];
		$sex = $row['SEX'];
		$pc = $row['PC'];
		$treatment = $row['TREATMENT'];
		$price = $row['PRICE'];
		$tests = str_replace('FALASHOLA123',', ',$row['TESTS']);
		$tests_text = $row['TESTS_TEXT'];
		if ($tests=='null') {
			$tests = '';
		}
		if ($tests!='') {
			$tests_text = ', ' . $tests_text;
		}
    }

$conn->close();




}

?>

</head>

<body style='width:100%;height:100%;'>
<p id='demo'></p>
<?php
$link = '../';
require $link . 'commons/header.php';
?>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Error in Form</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<div class='container' style='margin-top:4%;'>

<div class='heading'>
<h3>Add Patient</h3>
</div>


<form class='form-inline' id='form1' action='#'>
	<div class='form-group'>
		<input type='text' name='name' minlength='2' placeholder='Name' class='form-control' size='50' id='namefield'  value="<?php if  (isset($_GET['id'])) {echo $name;} ?>" required autofocus>
        <input type='number' name='age' minlength='1' maxlength='3'placeholder='Age (Years)' class='form-control' maxlength='2' style='width:150px;' id='agefield' value="<?php if  (isset($_GET['id'])) {echo $age;} ?>" required>
				<input type='number' name='age' minlength='1' maxlength='3'placeholder='Age (Months)' class='form-control' maxlength='2' style='width:150px;' id='ageMonthField' value="<?php if  (isset($_GET['id'])) {echo $ageMonth;} ?>">
        <select name='sex' class='form-control' id='sexfield' value="" required><option value='Male' >&#9794; Male</option>
        <option value='Female' <?php if (isset($_GET['id'])) {if($sex=='Female') {echo "selected";}} ?>>&#9792; Female</option><option value='Other' <?php if (isset($_GET['id'])) {if($sex=='Other') {echo "selected";}} ?>>&#9893; Other</option></select>
        <input type='date' name='date' class='form-control hidden' id='datefield' style='display:none;' disabled>
	</div>
    </form>
    <form action='#'>
    <div class='form-group'>
    	<br><textarea placeholder="P/C & Treatment" rows='3' class='form-control' id='pcfield'><?php if  (isset($_GET['id'])) {echo $pc;} ?></textarea><br>
    	<textarea class='form-control' rows='3' placeholder="Treatment" id='treatmentfield' style='display:none;'><?php if  (isset($_GET['id'])) {echo $treatment;} ?></textarea>
			<textarea name='tests_text' rows='3' id='tests_text' placeholder='Prescribe a test' class='form-control'><?php if  (isset($_GET['id'])) {echo $tests;echo $tests_text;} ?></textarea><br>
        <input type='number' name='price' class='form-control' placeholder='Price' id='pricefield' value="<?php if  (isset($_GET['id'])) {echo $price;} ?>">
    </div>
		<a href='addpatient.php'><button type='button' id='newPatient' class='btn' style='display:none;'>&#9977; New Patient</button></a>
		<button type='button' id='submit' onClick='submitForm()' class='btn btn-primary'>&#8658; Submit</button>
</form>




</div>





<script src='addpatient.js'></script>
</body>
</html>
