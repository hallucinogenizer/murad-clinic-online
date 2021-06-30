<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search Patient - Murad Clinic</title>
<!-- Latest compiled and minified CSS -->
<?php
$link = '../';
require $link . 'commons/includes.php';
?>
<link rel='stylesheet' type='text/css' href='searchpatient.css'>

</head>

<body style='width:100%;height:100%;'>

<?php
$link = '../';
require $link . 'commons/header.php';
 ?>



<div class='container' style='margin-top:4%;'>
  <div class='heading'>
  <h3>Search Patient</h3>
  </div>
<form class='' id='form1'>
	<div class='form-group'>
		<table><tr><td><input type='text' name='name' minlength='2' placeholder='Name' class='form-control' size='50' id='namefield' required></td>
      <td>  <input type='number' name='age' minlength='1' maxlength='3' placeholder='Age (Y)' class='form-control' maxlength='2' style='width:100px;' id='agefield'></td>
      <td>  <input type='number' name='ageMonth' minlength='1' maxlength='3' placeholder='Age (M)' class='form-control' maxlength='2' style='width:100px;' id='ageMonthField'></td>
        <td><select name='sex' class='form-control' id='sexfield' required><option value=''>Select Sex</option><option value='Male'>&#9794; Male</option>
        <option value='Female'>&#9792; Female</option><option value='Other'>&#9893; Other</option></select></td>


  <td align='left'>
        Choose a date:<table cellpadding='1px'>
          <tr>
            <td onClick="showDatePicker('single')"><button type='button' class='dateType'>One Date</button></td>
            <td onClick="showDatePicker('range')"><button type='button' class='dateType'>A Range of Dates</button></td>
          </tr>
        </table>
  </td>
</tr></table>

    <div id='singleDateDiv' class='hidden'>
      <label for='date'>Date:</label>
        <input type='date' name='date' class='form-control' id='datefield' value=''>
      </div>

        <div id='rangeFields'>
          <table class='tofromTable'><tr><td>
          <label for='from'>From:</label></td>
          <td>
            <label for='from'>To:</label></td><td></td></tr>
          <tr><td>
        <input type='date' name='from' class='form-control' id='fromField'></td>
      <td>
        <input type='date' name='to' class='form-control' id='toField'></td>
      <td></tr>
      </table>
      </div>
        <button type='button' class='btn btn-primary' onClick='search(false)' id='searchButton'>Search</button>
	</div>
    </form>

    <table class='table table-hover search_results'>
    	<thead class='thead-light'>
    		<tr>
            	<th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Previous Visit</th>
            </tr>
    	</thead>
    	<tbody class='append'>
        	<tr><td></td><td>Enter Search Query</td><td></td><td></td><td></td></tr>
        </tbody>
    </table>


<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style='overflow:auto;'>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<div class='btn-group'>
      <button type='button' id='newPatient' class='btn btn-primary' onClick='reDirect()'>&#9977; Extend Record</button>
      <button type='button' id='deletePatient' class='btn btn-danger' onClick='deletePatient()'>&#128465; Delete Record</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
</div>



<!--Second modal starts-->

<!-- The Modal -->
<div class="modal fade" id="SuccessModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">
		<?php
		if (isset($_GET['success'])) {
			if ($_GET['success']=='true') {
				echo "Record Successfully Deleted.";
			} else if ($_GET['success']=='false') {
				echo "Record Not Deleted. Consult Rohan.";
			}
		}
		?>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!--Second modal ends-->



<?php
	if (isset($_GET['success'])) {
		echo "<script>$('#SuccessModal').modal('show');</script>";
	}
  if (isset($_GET['sex']) && isset($_GET['date'])) {

    echo "<script>
    window.sex = '" . $_GET['sex'] . "';
    window.date = '" . $_GET['date'] . "';
    window.searchAyiHai = true;
    </script>";
  }
  else if (isset($_GET['from']) && isset($_GET['to'])) {
    echo "<script>
    window.from = '" . $_GET['from'] . "';
    window.to = '" . $_GET['to'] . "';
    window.sex = '" . $_GET['sex'] . "';
    window.rangeAyiHai = true;
    </script>";
  }
?>



<script src='search.js'>
</script>
</body>
</html>
