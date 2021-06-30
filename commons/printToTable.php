<?php



  function printToTable($result) {

      echo "<table class='table table-striped show'><th>TYPE</th><th>EXPENSE</th><th>TITLE</th><th>DATE</th><th>Delete Entry</th>";
    //declare total variables
    $totals = array("commontotal"=>0, "Lab"=>0, "Utility Bills"=>0, "Equipment"=>0, "Medicine"=>0, "Staff Salary"=>0, "Miscellaneous"=>0);


    //getting types of expenses in an array
    $myfile = fopen("types_simple.txt", "r") or die("Unable to open file!");
    $typestext2 = fread($myfile,filesize("types_simple.txt"));
    fclose($myfile);

    $types_array = array();
    while (strpos($typestext2,"&&")!=FALSE) {
        $position = strpos($typestext2,"&&");
        $onetype = substr($typestext2,0,$position);//this gets the name of one type
        $typestext2 = substr($typestext2,$position+2,strlen($typestext2));
        array_push($types_array,$onetype);
    }//looping through typestext2
    array_push($types_array,$typestext2);

    //printing the expenses into a table
    while($row = $result->fetch_assoc()) {

      //summing to totals
      $totals['commontotal']+=$row['EXPENSE'];

      if ($row['TYPE']=='Lab') {$totals['Lab']+=$row['EXPENSE'];}
      for ($i=1;$i<sizeof($types_array);$i++) {
        if ($row['TYPE']==$types_array[$i]) {$totals[$types_array[$i]]+=$row['EXPENSE'];}
      }

      if  (!isset($row['TITLE']) || $row['TITLE']==null) {$row['TITLE']='N/A';}
      echo "<tr><td>";
      echo $row['TYPE'] . "</td><td>Rs. " . $row['EXPENSE'] . "/-</td><td>" . $row['TITLE'] . "</td><td>" . $row['DATE'] . "</td><td>&#128465;<a style='color:red;cursor:pointer;' onClick='deleteExpense(this)' id='" . $row['ID'] . "' class='del'> Delete</a></td></tr>";

    }//while loop ends

  echo "</table>";


  echo "<table class='table table-bordered show'><tr><th>Super Total</th>";
  for ($i=0;$i<sizeof($types_array);$i++) {
    echo "<th>" . $types_array[$i] . "</th>";
  }
echo "</tr><tr><td>" . $totals['commontotal'] . "</td>";
  for ($i=0;$i<sizeof($types_array);$i++) {
    echo "<td>" . $totals[$types_array[$i]] . "</td>";
  }
  echo "</tr></table>";
}

//FUNCTOINS HAVE BEEN CREATED
?>
