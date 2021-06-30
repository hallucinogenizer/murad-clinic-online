<!--advanced search options -->
<div style='text-align:right;width:100%;margin-top:30px;display:none;' id='advanceddisplayer'>
  <a href='#' onClick="$('#advancedsearchoptions').slideToggle();" style='font-size:14px;'>Advanced Search Options</a>
</div>



<div id='advancedsearchoptions' class='hidden'>
  <form type='post' action='index.php' name='form' method='get' action='index.php'>

<table width='90%'><tr>
  <td>
  <label for='searchtype' class='first'>Type of Expense:</label>
</td>
<td>

  <label for='searchexpense'>Expense:</label>
</td>

<td>
<label for='searchtitle'>Add Title:</label>
</td>
</tr>

<tr>
  <td>
  <select name='searchtype' id='select_type' class='form-control'>

  <?php
  echo "<option value=''>Select</option>";
  echo $typestext;
  echo "<option>Add new type</option>";
  ?>

  </select>
</td>

<td>

  <input type='number' name='searchexpense' class='form-control' placeholder='Rupees'>
</td>
<td>
  <input type='text' name='searchtitle' class='form-control' placeholder='Optional'>
</td>
</tr></table>
  <label for='searchdate'>Date:</label>
  <input type='date' name='searchdate' class='form-control' id='dateField'>

  <a href='#' onClick="pickMultipleDates()" style='font-size:14px;'>Pick Multiple Dates</a><br>




  <input type='hidden' name='searching'>

  <input type='submit' class='btn btn-primary'>

  </form>
</div><!--advancedsearchoptions div ends-->
