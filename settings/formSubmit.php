<?php
 //if he wants to change the name
 require '../commons/database_connect.php';



if (isset($_POST['clinic_name'])) {
  $clinic_name = mysqli_real_escape_string($conn, $_POST['clinic_name']);



  if ($conn->connect_error) {
    die("Connection to Database Failed. Contact the developers.");
  } else {


    if (!isset($_POST['isCapitalized'])) {
      $isCapitalized='FALSE';
    } else {
      $isCapitalized='TRUE';
    }

    if (!isset($_POST['hasImage'])) {
      $hasImage='FALSE';
    } else {
      $hasImage='TRUE';
    }

  //first we need to get the current additional_info into an array, then we change the specific value we want in that array and  then put it back into the database
  $sql = "SELECT `ADDITIONAL_INFO` FROM `site_info` WHERE `INFO_TYPE`='CLINIC NAME' LIMIT 1";

  $result = getResult($sql);

  $additional_name_info = array();
  while($row = $result->fetch_assoc()) {
      $additional_name_info = unserialize($row['ADDITIONAL_INFO']);
  }



$additional_name_info['CAP'] = $isCapitalized;



//handling the image upload (if any)
if ($_FILES['logo']['size'] > 0) {
  if ($hasImage=='TRUE') {
  $target_dir = "../uploads/";//for saving it rn
  $target_dir2 = "uploads/";//so that files in other directories can use it without a 404 error
$target_file = $target_dir . basename($_FILES["logo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if($check !== false) {

        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
  $temp = explode(".", $_FILES["logo"]["name"]);
  $newfilename = round(microtime(true)) . '.' . end($temp);
    $uploadOk = 0;
}
// Check file size
if ($_FILES["logo"]["size"] > 20000000) {
  echo "
  <script>
  showModal('Failed','Maximum file size is 20Mb. Upload a smaller file or compress this one.');
  </script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "
  <script>
  showModal('Failed','Only JPG,JPEG,PNG and GIF Files are allowed. Try again with a valid file.');
  </script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "
  <script>
  showModal('Failed','The file " . basename( $_FILES["logo"]["name"]) . " could not be uploaded.');
  </script>";
// if everything is ok, try to upload file
} else {
  //changing file name - adding random number
  $temp = explode(".", $_FILES["logo"]["name"]);
  $newfilename = round(microtime(true)) . '.' . end($temp);

    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_dir . $newfilename)) {
        echo "
        <script>
        showModal('Success','The file " . basename( $_FILES["logo"]["name"]) . " has been uploaded.');
        </script>";

    } else {
      echo "
      <script>
      showModal('Failed','The file " . basename( $_FILES["logo"]["name"]) . " could not be uploaded.');
      </script>";
    }
}

}//if $hasImage=='TRUE'
}


$additional_name_info['IMG'] = $hasImage;
if ($_FILES['logo']['size'] > 0) {
  $additional_name_info['IMGSRC'] = $target_dir2 . $newfilename;
}
$serializedAdditionalInfo = addslashes(serialize($additional_name_info));

$sql2 = "UPDATE `site_info` SET `VALUE`='$clinic_name',`ADDITIONAL_INFO`='$serializedAdditionalInfo' WHERE `INFO_TYPE`='CLINIC NAME'";

  if ($conn->query($sql2) == TRUE) {
    //kamyabi ki naveed suna di jaye
    echo "
    <script>
    showModal('Success','The name of the Clinic has been changed.');
    </script>
    ";
  } else {

    echo "
    <script>
    showModal('Failure','The name of the Clinic could not be changed.');
    </script>
    ";
  }

  }



}//if clinic name isset
 ?>
