<!doctype html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Expenses - Murad Clinic</title>
<!-- Latest compiled and minified CSS -->

<?php
$link = '../';
require $link . 'commons/includes.php';
 ?>
<link rel='stylesheet' type='text/css' href='settings.css'>
<link rel='stylesheet' type='text/css' href='../bootstrap/pretty-checkbox.css'>
<script src='themeChanger.js'></script>
</head>

<body style='width:100%;'>



<?php
$link = '../';
require $link . 'commons/header.php';
include $link . 'commons/modal.php';
?>
<script src='../commons/modal.js'></script>
<?php
require 'formSubmit.php';
?>

<div class='container'>

  <div class='heading'>
    <h3>Settings</h3>
  </div>
<!--navigation bar-->
  <nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">General</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Patient Data</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Expenses</a>
      </li>
    </ul>

  </div>
</nav>

<div class='content_container'>
<form class='form-inline roohaniform' method='post' action='index.php' enctype='multipart/form-data'>
  <label for='clinic_name'>Clinic Name:</label>
  <input type='text' class='form-control' name='clinic_name' value="<?php echo $clinic_name; ?>">


  <div class="pretty p-default">
        <input type="checkbox" name='isCapitalized' value='TRUE' <?php
        if ($additional_name_info['CAP']=='TRUE') {
          echo "checked";
        }

       ?>
><!--ye sahi lagaya hai-->
        <div class="state">
            <label for='isCapitalized'>Show in capital letters</label>
        </div>
    </div>

    <div class="pretty p-default">
          <input type="checkbox" id='hasImage' name='hasImage' value='TRUE' <?php
          if ($additional_name_info['IMG']=='TRUE') {
            echo "checked";
          }

         ?>
  ><!--ye sahi lagaya hai-->
          <div class="state">
              <label for='hasImage'>Show Logo Image</label>
          </div>
      </div>

      <div id='logoImageUploader'>
      <input type='file' name='logo' class='form-control'>

      <?php
  if ($additional_name_info['IMGSRC']!='NULL') {
    echo "<script>window.imagehai=true;</script>";
  } else {
    echo "<script>window.imagehai=false;</script>";
  }
  ?>
    </div>
    <a id='changeImage' href='' style='font-size:14px;'>Change Image</a>

  <input type='submit' class='btn btn-primary' value='Change' style='margin-left:10px;'>
</form><br>
<!--logo title and image changer ends-->

<!--theme color changer starts-->
<table><tr>
<td>Choose a color scheme:</td>
<td data-themelink='blue.css' class='themeOption' title='Default'><div id='blueSelect' class='themeSelect'></div></td>
<td data-themelink='orange.css' class='themeOption' title='Orange'><div id='orangeSelect' class='themeSelect'></div></td>
<td data-themelink='pink.css' class='themeOption' title='Pink'><div id='pinkSelect' class='themeSelect'></div></td>
<td data-themelink='greyscale.css' class='themeOption' title='Greyscale'><div id='greySelect' class='themeSelect'></div></td>
</tr></table>

<!--theme color changer ends-->

<!--Employee Account Creator starts-->
<table><tr>
<td style='vertical-align:middle;'><p>Create an account for an employee: </p></td>
<td style='vertical-align:middle;'><a href='../signup/createemployee.php'><button type='button' class='btn btn-primary' style='padding-top:4px;padding-bottom:4px;'>Create Account</button></a></td>
</tr></table>

</div><!--content-container div ends-->

</div>

<script src='settings.js'></script>
</body>

</html>
