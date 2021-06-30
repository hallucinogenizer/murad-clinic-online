<?php
$success=false;
$category = $_GET['category'];


//delete from first file
$DELETE = "<option value='" . $category . "'>" . $category . "</option>";
$myfile = fopen('types.txt','r') or die('Unable to open file.');
$typestext = fread($myfile,filesize("types.txt"));
fclose($myfile);

$typestext = str_replace($DELETE,'', $typestext);
  $myfile = fopen('types.txt','w') or die('Unable to open file.');
  if (fwrite($myfile,$typestext)) {$success=true;}
  fclose($myfile);

//first delete ends



//delete from first file
$DELETE = "&&" . $category;
$myfile = fopen('types_simple.txt','r') or die('Unable to open file.');
$typestext = fread($myfile,filesize("types_simple.txt"));
fclose($myfile);

$typestext = str_replace($DELETE, '', $typestext);
  $myfile = fopen('types_simple.txt','w') or die('Unable to open file.');
  if (fwrite($myfile,$typestext)) {
    if ($success) {echo "Success";}
    else {echo "Failed.";}
  } else {echo "Failed.";}
  fclose($myfile);



?>
