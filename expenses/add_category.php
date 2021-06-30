<?php
$success=false;
$category = $_GET['category'];


$myfile =  fopen("types.txt",'a') or die("Unable to open file.");
$text = "<option value='" . $category . "'>" . $category . "</option>";
if(fwrite($myfile,$text)!=FALSE) {$success=true;}

$myfile2 =  fopen("types_simple.txt",'a') or die("Unable to open file.");
$text2 = "&&" . $category;
if(fwrite($myfile2,$text2)!=FALSE) {$success=true;}

if($success) {echo "Success";} else {echo "Failed";}

fclose($myfile);
?>
