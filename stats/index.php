<!doctype html>
<html>
<head>
<meta charset="utf-8">

<title>Stats - Murad Clinic</title>
<?php
$link = '../';
require $link . 'commons/includes.php';
?>
<script src='../canvasjs/canvasjs.min.js'></script>


<link rel='stylesheet' type='text/css' href='stats.css'>
</head>

<body style='width:100%;'>

	<?php
	//include header
	$link = '../';
	require $link . 'commons/header.php';
	?>


<div class='container'>

		<div class='heading'>
				<h2>Statistics</h2>
		</div>


		<label id='datelabel' style='margin-top:30px;font-size:17px;'>
			<i class="fa fa-calendar-o" aria-hidden="true"></i> Choose another Date:
		</label>

<div class='btn-group'>
		<button class='btn dateType' onClick="showDateField('single')">
				<i class="fa fa-calendar-plus-o" aria-hidden="true"></i> One Date</button>
		<button class='btn dateType' onClick="showDateField('range')">
				<i class="fa fa-calendar" aria-hidden="true"></i> A Range of Dates</button>
</div>

		<form method='get' action='index.php' class='show' class="form-inline">
			<div id='multiDatePicker' style='display:none;'>
				<p>Choose the starting date and ending date of your range. You will be shown combined statistics for all the days that lie within that range.</p>
				<input type='hidden' name='range'>
				<label for='from'>From:</label><input type='date' name='from' class='from form-control'><br>
				<label for='to'>To:</label><input type='date' name='to' class='to form-control'>
				<input type='submit' class='btn btn-primary'>
		</div>
	</form>



	<form method='get' action='index.php' class='show' class="form-inline">
		<div class='simple' style='display:none;'>
		<input type='date' name='date' class='form-control'>
		<input type='submit' class='btn btn-primary'>
	</div>
	</form>


<table width='100%'><!--main positioning table-->
	<tr><td width='50%'>

<?php
 require '../commons/database_connect.php';
$form=true;//for form validation





//generating the sql statement
	if (isset($_GET['date'])) {
		if  ($_GET['date']!='') {//check if date wasn't null
			//now we check if date is before today's date
			if( strtotime($_GET['date']) < time() ) {
			$date = $_GET['date'];
			$sql = "SELECT `PRICE`,`SEX` FROM `patients` WHERE `DATE`='$date' ORDER BY `ID` DESC LIMIT 0,9999999999999999999";
		} else {//if he selected a date in the  future
			$type_of_display='date';
		?>
		<script>
		alert("Please don't choose a date in the future.");
		</script>
		<?php
	}//if date was selected in future ELSE ends
		}
	}



	else if (isset($_GET{'range'}) && isset($_GET['from']) && isset($_GET['to'])) {

		if ($_GET['from']!='' && $_GET['to']!='') {
			$from = $_GET['from'];
			$to = $_GET['to'];
			if( strtotime($from) < time() && strtotime($to) < time() ) {
			$sql = "SELECT `PRICE`,`SEX`,`DATE` FROM `patients` WHERE `DATE` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `ID` DESC LIMIT 0,9999999999999999999";
		} else {
			$type_of_display='range';
			//if time is in future
			?>
			<script>
			alert("Please don't choose dates in the future.");
			</script>
			<?php
		}
	}

	} else {
		$sql = "SELECT `PRICE`,`SEX` FROM `patients` WHERE `DATE`=CURDATE() ORDER BY `ID` DESC LIMIT 0,9999999999999999999";
	}
//generating the sql statement ends



	if (isset($sql)) {
	$result = $conn->query($sql);
	$counts=0;
	$total = 0;
	$male = 0;
	$female = 0;
	$other = 0;
	$income = array(); //this will sum up the income for each date separately.

    while($row = $result->fetch_assoc()) {
			$counts+=1;
			$total+=$row['PRICE'];
			//sum up the genders
			if($row['SEX']=='Male') {$male+=1;} else if ($row['SEX']=='Female') {$female +=1;} else if ($row['SEX']=='Other') {$other +=1;}

			//sum up the incomes of individual dates
			if (isset($_GET{'range'}) && isset($_GET['from']) && isset($_GET['to'])) {
					if (array_key_exists($row['DATE'],$income)) {
						$income[$row['DATE']]+=$row['PRICE'];
					} else {
						$income[$row['DATE']]=0;
						$income[$row['DATE']]+=$row['PRICE'];
					}
				}
    }//while  loop ends



		echo "<div class='show'><p style='font-size:14px;margin-bottom:-20px;'><i class='fa fa-clock-o' aria-hidden='true'></i> Currently displaying stats for date";
		//display currently set date
		//if he searched for date
		if (isset($_GET['date'])) {
		echo " <b>" . $_GET['date'] . "</b></p><br>";


		//if he searched for a range
	} else if (isset($_GET{'range'}) && isset($_GET['from']) && isset($_GET['to'])) {

		if ($_GET['from']!='' && $_GET['to']!='') {
			echo "s from <b>" . $_GET['from'] . "</b> to <b>" . $_GET['to'] . "</b>.</p><br>";
		}

	} else {
		//if he didn't search for anything, display today's date
		echo " <b>" . date("Y-m-d") . "</b></p><br>";
	}

	//common to all type of searches - printing the data obtained from the query




		echo "<h4><i class='fa fa-bed' aria-hidden='true'></i> Patient Stats</h4>";
		echo "<table class='table table-bordered stats'><tbody>";
		echo "<tr class='main_info'>
		<td>
		<span class='fa-stack'>
		<i class='fa fa-circle fa-stack-2x blue fa-fw' aria-hidden='true'></i>
		<i class='fa fa-users fa-stack-1x white fa-fw' aria-hidden='true'></i>
		</span>
		  Total Patients</td><td>" . $counts . "</td></tr></tbody>

			<tbody class='showDetails'>
			<tr style='cursor:pointer;' onClick='showDetails(this)' id='patientShow' class='showDetails'><td>
			<span class='fa-stack'>
			<i class='fa fa-circle fa-stack-2x fa-fw grey' id='patientArrowCircle' aria-hidden='true'></i>
			<i class='fa fa-angle-double-down fa-stack-1x white fa-fw' id='patientArrow' aria-hidden='true'></i>
			</span>
			<span id='toShowOrToHide1'>Show</span> Details</td><td></td></tr>
			</tbody>

			<tbody style='display:none;' id='patientdetails'>
			<tr>
			<td>
			<i class='fa fa-male grey fa-fw' aria-hidden='true'></i>
			</span>
			Male Patients</td><td><a href='#' id='Male' onClick='reDirectToSearchPatient(this.id)'>" . $male . "</a></td>
			</tr>


			<tr>
			<td>
			<i class='fa fa-female grey fa-fw' aria-hidden='true'></i>
			</span>
			Female Patients</td><td><a href='#' id='Female' onClick='reDirectToSearchPatient(this.id)'>" . $female . "</a></td>
			</tr>

			<tr>
			<td>
			<i class='fa fa-transgender-alt grey fa-fw' aria-hidden='true'></i>
			</span>
			Other Sex Patients</td><td><a href='#' id='Other' onClick='reDirectToSearchPatient(this.id)'>" . $other . "</a></td>
			</tr>";
			if ($counts!=0) {
			$average_charge = round($total/$counts);
		} else {
			$average_charge=0;
		}
			echo "<tr>
			<td>
			<i class='fa fa-user-o grey fa-fw' aria-hidden='true'></i>
			</span>
			Average Charged per Patient</td><td>" . $average_charge . "</td>
			</tr>

			</tbody>

			<tbody>
			<tr class='main_info'>
			<td>
			<span class='fa-stack'>
			<i class='fa fa-circle fa-stack-2x blue fa-fw' aria-hidden='true'></i>
			<i class='fa fa-money fa-stack-1x white fa-fw' aria-hidden='true'></i>
			</span>
			Total Charged</td><td>" . $total . "</td>
			</tr>
			</tbody>
			</table>";
			echo "<h4><i class='fa fa-credit-card' aria-hidden='true'></i> Expense Stats</h4>";
			echo "<table class='table table-bordered stats'>";
			$type_of_display = '';
			//if he didn't search for a date, generate SQL Statement based on today's date
		if (!isset($_GET['date']) && !isset($_GET['range'])) {
			$type_of_display = 'today';
			$sql2 = "SELECT `EXPENSE`,`DATE`,`TYPE` FROM `expense` WHERE `DATE`=CURDATE() ORDER BY `ID` LIMIT 0,999999999999999999";
		}

//generate SQL Statement if he asked for a range of dates
else if (isset($_GET{'range'}) && isset($_GET['from']) && isset($_GET['to'])) {

	if ($_GET['from']!='' && $_GET['to']!='') {
		$type_of_display = 'range';
		$from = $_GET['from'];
		$to = $_GET['to'];
		$sql2 = "SELECT `EXPENSE`,`DATE`,`TYPE` FROM `expense` WHERE `DATE` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `ID` LIMIT 0,999999999999";
		//transfer range dates to javascript
		echo "<script>
		window.from = '" . $from . "';
		window.to = '" . $to . "';
		</script>";
}

} else {
	if ($_GET['date']!=null) {
			$type_of_display = 'date';
			$date = $_GET['date'];
			$sql2 = "SELECT `EXPENSE`,`DATE`,`TYPE` FROM `expense` WHERE `DATE`='$date' ORDER BY `ID` LIMIT 0,99999999999";
			//transfer chosenDate variable to JavaScript
			echo "<script>
			window.chosenDate='" . $date . "';
			</script>";
	}//if date is not null
}
//pass the type of display variable to javascript
//so that if he clicks on the tiny number displayed next to type names in the Detailed Expense Stats table,
//he can be rediredted to the search page with correct info about the date of search
echo "<script>
window.type_of_display = '" . $type_of_display . "';
</script>";

	$result2 = $conn->query($sql2);
	$totalexpense = 0;
	$expenses = array(array(),array());

	//get names of types from file
		$types = array();
		//we will set the types names as "keys" of this array, each having an initial value of 1. For each entry in the table of a particular type, that type will get a 1 added to it. This way we count how many no. of expenses a type has.
		$myfile = fopen("../expenses/types_simple.txt",'r') or die("Unable to open file");
		$typestext = fread($myfile,filesize("../expenses/types_simple.txt"));
		fclose($myfile);
		while (strpos($typestext,'&&')!=FALSE) {
		$position = strpos($typestext,'&&');
		$onetype = substr($typestext,0,$position);
		$types[$onetype]=0;
		$typestext = substr($typestext,$position+2,strlen($typestext));
	}
	$onetype = substr($typestext,0,strlen($typestext));
	$types[$onetype]=0;
	//got names of types from file

	//the first subarray is for totalling TYPE, the second for DATE and they are wordkey-value arrays
	$count=0;
	while($row2 = $result2->fetch_assoc()) {
		$totalexpense += $row2['EXPENSE'];
		$types[$row2['TYPE']]+=1;
		if (!isset($expenses[0][$row2['TYPE']])) {
			$expenses[0][$row2['TYPE']]=0;
		}
		$expenses[0][$row2['TYPE']] +=$row2['EXPENSE']; //EXPENSE
		if (array_key_exists($row2['DATE'],$expenses[1])) {
		$expenses[1][$row2['DATE']] +=$row2['EXPENSE']; //DATE
	} else {$expenses[1][$row2['DATE']]=0;$expenses[1][$row2['DATE']] +=$row2['EXPENSE'];}
		$count+=1;
	}

//finding out the net income of each date.
$netincome = array();
foreach($income as $key => $value) {
	if (!array_key_exists($key, $expenses[1])) {
	$netincome[$key] = $value;
} else {
	$netincome[$key] = $value - $expenses[1][$key];
}
}



	echo "<tr>";

	echo "<tr class='main_info'><td>Total No. of Expenses</td><td>" . $count . "</td></tr>";

	echo "<tbody class='showDetails'>
	<tr style='cursor:pointer;' onClick='showDetails(this)' id='expenseShow' class='showDetails'><td>
	<span class='fa-stack'>
	<i class='fa fa-circle fa-stack-2x fa-fw grey' id='expenseArrowCircle' aria-hidden='true'></i>
	<i class='fa fa-angle-double-down fa-stack-1x white fa-fw' id='expenseArrow' aria-hidden='true'></i>
	</span>
	<span id='toShowOrToHide2'>Show</span> Details</td><td></td></tr>
	</tbody>";


	echo "<tbody id='expensedetails' style='display:none;'>";
//printing the individual dates' expenses
	foreach($expenses[1] as $key => $value) {
	echo "<tr><td>
	<i class='fa fa-calendar-plus-o fa-fw blue' aria-hidden='true'></i> Expense on <span class='date'>" . $key . "</span></td><td>" . $value . "</td></tr>";
	}

//printing the individual types' expenses
	foreach($expenses[0] as $key => $value) {
	echo "<tr><td>
	<i class='fa fa-usd fa-fw blue' aria-hidden='true'></i>" . $key . "
	<a href='#' onClick='reDirectToSearch(this.id)' id='" . $key . "'>
	<span class='grey'>(" . $types[$key] . ")</span>
	</a>
	</td><td>" . $value . "</td></tr>";
}
//prinited the individual types' expenses

//finding out which type has the highest (maximum) expense
if (count($expenses[0])>0) {
$greatest_type = array_search(max($expenses[0]),$expenses[0]);
}
if (count($expenses[1])>0) {
$greatest_date = array_search(max($expenses[1]),$expenses[1]);
}
if (count($netincome)>0) {
$greatest_net_income_date = array_search(max($netincome),$netincome);
}
if (count($income)>0) {
$greatest_income_date = array_search(max($income),$income);
}



//found whichi type has highest expense
if (count($expenses[0])>0) {
	echo "<tr class='red'>
	<td>
	<i class='fa fa-exclamation fa-fw' aria-hidden='true'></i>
	</span>
	Highest Expense</td><td>" . $greatest_type . "</td>
	</tr>";
}
	echo "</tbody>";
	echo "<tbody>";
	echo "<tr class='main_info'><td>
	<span class='fa-stack'>
	<i class='fa fa-circle fa-stack-2x blue fa-fw' aria-hidden='true'></i>
	<i class='fa fa-shopping-cart fa-stack-1x white fa-fw' aria-hidden='true'></i>
	</span>
	Total Expense</td><td>" . $totalexpense . "</td></tr>";
	$net = $total - $totalexpense;
	echo "<tr class='main_info'>
	<td>
	<span class='fa-stack'>
	<i class='fa fa-circle fa-stack-2x blue fa-fw' aria-hidden='true'></i>
	<i class='fa fa-balance-scale fa-stack-1x white fa-fw' aria-hidden='true'></i>
	</span>
	<b>Net Profit</b></td><td><b>" . $net . "</b></td></tr></tbody>
	";
	echo "</table></div>";


//passing on the data to JavaScript so the graphs can be plotted
echo "<script>
window.malePatients = " . $male . ";
window.femalePatients = " . $female . ";
window.otherPatients = " . $other . ";

</script>";
//data passed to JavaScript
$conn->close();
}//if connection was found

?>


</td><!--main positioning table-->



<td>
	<!--the pie chart for male/female patients-->
	<div id="patientPieChart" style="height: 400px; width: 100%;"></div>

</td>
</tr>
<tr>
<td align='center' style='padding-top:40px;padding-bottom:40px;width:50%;'>
	<!--the expense types  pie  chart-->
	<div id="expenseTypesPieChart" style="height: 400px; width: 90%;"></div>
</td>

<td align='center' style='padding-top:40px;padding-bottom:40px;width:50%;'>
<!--the expense types  column  chart-->
<div id='expenseTypesColumnChart' style='height:400px;width:90%;'></div>
</td>
</tr>
</table><!--main posiioning table ends-->




<!--the next graph will only be displayed if user is searching for a range-->

<?php
if ($type_of_display=='range') {
?>

<!--the expenses for dates line  chart-->
<div id='datesExpensesLineChart' style='height:400px;width:90%;text-align:center;margin-top:100px;margin-bottom:40px;'></div>


<!--the income for each date line chart-->
<div id='datesIncomesLineChart' style='height:400px;width:90%;text-align:center;margin-top:200px;margin-bottom:40px;'></div>



<!--the net income for each date line  chart-->
<div id='datesNetIncomesLineChart' style='height:400px;width:90%;text-align:center;margin-top:200px;margin-bottom:40px;'></div>


<?php
}
?>




<script>
//expense types chart starts
$(document).ready(function(){

	var expenseTypesPieChart = new CanvasJS.Chart("expenseTypesPieChart",
	{
		animationEnabled:true,
	  colorSet:  "customColorSet1",
	  theme: "theme2",
		backgroundColor:'transparent',
	  title:{
	    text: "Graph of the Types of Expenses",
	    fontFamily:'Century Gothic',
	    fontWeight:'bold',
			fontSize:26
	  },
	  axisY:{
	 labelFontFamily: "tahoma"
	  },
	  subtitles: [{
	    text:"Shows the contribution of each Type of Expense in making the Total Expense",
	    fontFamily:'tahoma',
	    fontSize:12
	  }],

	  data: [
	  {
	    type: "pie",
	    //showInLegend: true,
	    //legendText: "{indexLabel}",
			toolTipContent: "{y} - #percent %",
			yValueFormatString: "#0.#,,. Million",
	    dataPoints: [
				<?php
				$numItems = count($expenses[0]);
				$i=0;
					foreach ($expenses[0] as $key => $value) {
						echo "{  y: " . $value . ", indexLabel: '" . $key . "', indexLabelFontColor: 'grey', indexLabelFontFamily:'Helvetica', indexLabelFontSize: 16, indexLabelFontWeight:100}";
						if(++$i === $numItems) {
					    break;
					  } else {
							echo ",";
						}
					}
				?>
	    ]
	  }
	  ]
	});
	expenseTypesPieChart.render();
	//expense types pie chart ends



	//expense types column chart starts
	var expenseTypesColumnChart = new CanvasJS.Chart("expenseTypesColumnChart",
	{
		animationEnabled:true,
	  colorSet:  "customColorSet1",
	  theme: "theme2",
		backgroundColor:'transparent',
	  title:{
	    text: "Graph of the Types of Expenses",
	    fontFamily:'Century Gothic',
	    fontWeight:'bold',
			fontSize:26
	  },
	  axisY:{
	 labelFontFamily: "tahoma"
	  },
	  subtitles: [{
	    text:"Shows the contribution of each Type of Expense in making the Total Expense",
	    fontFamily:'tahoma',
	    fontSize:12
	  }],

	  data: [
	  {
	    type: "column",
	    //showInLegend: true,
	    //legendText: "{indexLabel}",
	    dataPoints: [
				<?php
				$numItems = count($expenses[0]);
				$i=0;
					foreach ($expenses[0] as $key => $value) {
						echo "{  y: " . $value . ", indexLabel: '" . $key . "', indexLabelFontColor: '#4a4a4a', indexLabelFontFamily:'Helvetica', indexLabelFontSize: 16}";
						if(++$i === $numItems) {
					    break;
					  } else {
							echo ",";
						}
					}
				?>
	    ]
	  }
	  ]
	});
	expenseTypesColumnChart.render();
	//expense types column chart ends here



	//date expense line chart starts here
	var datesExpensesLineChart = new CanvasJS.Chart("datesExpensesLineChart",
	{
		animationEnabled:true,
		colorSet:  "customColorSet1",
		theme: "theme2",
		backgroundColor:'transparent',
		title:{
			text: "Graph of the Expenses on various Days",
			fontFamily:'Century Gothic',
			fontWeight:'bold',
			fontSize:26
		},
		axisY:{
	 labelFontFamily: "tahoma"
		},
		subtitles: [{
			text:"Shows the variation of Expense over the range of dates you selected",
			fontFamily:'tahoma',
			fontSize:12
		}],

		data: [
		{
			type: "line",
			color:'red',
			dataPoints: [
				<?php
				$numItems = count($expenses[1]);
				$i=0;
				foreach ($expenses[1] as $key => $value) {
						if ($key==$greatest_date) {
							echo "{  y: " . $value . ", indexLabel: '" . $key . "' , markerColor: 'yellow', indexLabelFontColor: 'blue'}";
						} else {
							echo "{  y: " . $value . ", indexLabel: '" . $key . "',  indexLabelFontColor: 'black'}";
						}

					if(++$i === $numItems) {
						break;
					} else {
						echo ",";
					}
				}
			?>
			]
		}
		]
	});
	datesExpensesLineChart.render();
	//date expense line chart ends here



	//date income line chart starts here
	var datesIncomesLineChart = new CanvasJS.Chart("datesIncomesLineChart",
	{
		animationEnabled:true,
		colorSet:  "customColorSet1",
		theme: "theme2",
		backgroundColor:'transparent',
		title:{
			text: "Graph of the Income on various Days",
			fontFamily:'Century Gothic',
			fontWeight:'bold',
			fontSize:26
		},
		axisY:{
	 labelFontFamily: "tahoma"
		},
		subtitles: [{
			text:"Shows the variation of Income (Total money earned from patients) over the range of dates you selected",
			fontFamily:'tahoma',
			fontSize:12
		}],

		data: [
		{
			type: "line",
			color:'blue',
			//showInLegend: true,

			//legendText: "{indexLabel}",
			dataPoints: [
				<?php
				$numItems = count($income);
				$i=0;
					foreach ($income as $key => $value) {
							if ($key==$greatest_income_date) {
								echo "{  y: " . $value . ", indexLabel: '" . $key . "' , markerColor: 'yellow', indexLabelFontColor: 'blue'}";
							} else {
								echo "{  y: " . $value . ", indexLabel: '" . $key . "',  indexLabelFontColor: 'black'}";
							}

						if(++$i === $numItems) {
							break;
						} else {
							echo ",";
						}
					}
				?>
			]
		}
		]
	});
	datesIncomesLineChart.render();
	//date income line chart ends here





	//date net income line chart starts here
	var datesNetIncomesLineChart = new CanvasJS.Chart("datesNetIncomesLineChart",
	{
		animationEnabled:true,
		colorSet:  "customColorSet1",
		theme: "theme2",
		backgroundColor:'transparent',
		title:{
			text: "Graph of the NET Income on various Days",
			fontFamily:'Century Gothic',
			fontWeight:'bold',
			fontSize:26
		},
		axisY:{
	 labelFontFamily: "tahoma"
		},
		subtitles: [{
			text:"Shows the variation of NET Income (Income - Expense) over the range of dates you selected",
			fontFamily:'tahoma',
			fontSize:12
		}],

		data: [
		{
			type: "line",
			color:'green',
			//showInLegend: true,

			//legendText: "{indexLabel}",
			dataPoints: [
				<?php
				$numItems = count($netincome);
				$i=0;
					foreach ($netincome as $key => $value) {
							if ($key==$greatest_net_income_date) {
								echo "{  y: " . $value . ", indexLabel: '" . $key . "' , markerColor: 'blue', indexLabelFontColor: 'green'}";
							} else {
								echo "{  y: " . $value . ", indexLabel: '" . $key . "',  indexLabelFontColor: 'black'}";
							}

						if(++$i === $numItems) {
							break;
						} else {
							echo ",";
						}
					}
				?>
			]
		}
		]
	});
	datesNetIncomesLineChart.render();
	//date net income line chart ends here








});
</script>

<script src='stats.js'>
</script>



</div>

</body>
</html>
