<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<head>
<!-- Latest compiled and minified CSS -->


<!-- jQuery library -->

<?php
require 'commons/includes.php';
?>

<link rel='stylesheet' type='text/css' href='murad.css'>

</head>

<body style='width:100%;'>

<?php
$link = '';
require 'commons/header.php';
?>

<table class='main_item' style='width:100%;'>
<tr>

<td align='center'>
<a href='addpatient/'><div class='main_item' id='left'>

<i class="fa fa-user-circle" aria-hidden="true"></i>
<p>Add Patient</p>
</div></a>
</td>

<td align='center'>
<a href='searchpatient/'><div class='main_item' id='middle'>

<i class="fa fa-search" aria-hidden="true"></i>
<p>Search Patient</p>
</div></a>
</td>


<td align='center'>
<a href='viewlist/'><div class='main_item right'>

<i class="fa fa-list" aria-hidden="true"></i>
<p>View Patient List</p>
</div></a>
</td>


<td align='center'>
<a href='stats/'><div class='main_item middle_right'>

<i class="fa fa-line-chart" aria-hidden="true"></i>
<p>View Stats</p>
</div></a>
</td>

</tr>


<tr>
<td align='center'>
<a href='expenses/'><div class='main_item bottom_left' id='left'>

<i class="fa fa-credit-card" aria-hidden="true"></i>
<p>Manage Expenses</p>
</div></a>
</td>

<td align='center'>
<a href='settings/'><div class='main_item bottom_left'>

<i class="fa fa-gear" aria-hidden="true"></i>
<p>Settings</p>
</div></a>
</td>


<td></td>
<td></td>
</tr>
</table>

</body>
</html>
