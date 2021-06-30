<?php
/*$password = 'UCZi7dEharGx7trDfkdXaUcP3th3';
$commonsalt = '2891874093287';

function RandomToken($length = 32){
    if(!isset($length) || intval($length) <= 8 ){
      $length = 32;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}

function Salt(){
    return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);
}

$salt = Salt();

$salted_hash = hash('sha256',$password.$commonsalt.$salt);
echo $salted_hash . '<br>';
echo $salt;*/




session_start();

if (isset($_SESSION['user']) && $_SESSION['user']!='') {
  header('Location:../index.php');
}
if (isset($_POST['username']) && isset($_POST['password'])) {
  if ($_POST['username']=='') {
    header('Location:index.php?error');
  }
  else if ($_POST['password']=='') {
    header('Location:index.php?error');
  }
  else {

    require '../commons/getResult.php';

    require '../commons/database_connect.php';

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $commonsalt = 'AllahHafiz';


    //check number of attempt
    $no_of_attempts = 0;
    $allow = false;
    $sql1 = "SELECT `no_of_attempts`, TIMESTAMPDIFF(MINUTE, `last_attempt`, NOW()) FROM `users` WHERE username='$username'";
    $result1 = getResult($sql1);
    if ($result1==false) {
      $allow=true;
    } else {

    while ($row1 = $result1->fetch_assoc()) {

      if ($row1['no_of_attempts']<3 || $row1['no_of_attempts']=='') {
        $allow = true;



        if ($row1['no_of_attempts']!='') {
          $no_of_attempts = $row1['no_of_attempts'];

          if ($row1["TIMESTAMPDIFF(MINUTE, `last_attempt`, NOW())"]>30) {//if the attempt is not first, but it was made after 30 minutes, reset number of attempts to one.
            $sql7 = "UPDATE `users` SET `no_of_attempts`='',`last_attempt`=NOW() WHERE username='$username'";
            $conn->query($sql7);
          }
          //echo "<script>alert('" . $no_of_attempts . "');</script>";
        }
      }
      else if ($row1['no_of_attempts']>2) {
        $minutes_to_last_attempt = $row1["TIMESTAMPDIFF(MINUTE, `last_attempt`, NOW())"];
        if ($minutes_to_last_attempt>30) {
          $allow = true;
        } else {
          $minutes_left = 30-$minutes_to_last_attempt;
          header('Location:index.php?error2&minutes=' . $minutes_left);
        }
      }
  }
}

  if ($allow==true) {
    $sql = "SELECT * FROM `users`";
    $login = false;
    $result = getResult($sql);
    while ($row = $result->fetch_assoc()) {
      $salted_hash = hash('sha256',$password.$commonsalt.$row['salt']);
      if ($username == $row['username'] && $salted_hash == $row['password']) {
        $login = true;
        $user = $row['ID'];

      }
    }//while loop ends
    if ($login==true) {
      $_SESSION['user'] = $user;
      $cookie_name = "user";
	$cookie_value = $user;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 5), "/", null, true, true); // 86400s = 1 day
      $sql8 = "UPDATE `users` SET `no_of_attempts`='0',`last_attempt`=NOW() WHERE username='$username'";
      $conn->query($sql8);
      header('Location:../index.php');
    } else {
      //username or password invalid, now we store the attempt number in db

      $no_of_attempts+=1;

      $sql2 = "UPDATE `users` SET `no_of_attempts`='$no_of_attempts',`last_attempt`=NOW() WHERE username='$username'";
      $conn->query($sql2);
      header('Location:index.php?error');
    }
  }//if allowed i.e. number of attempts<3
}
}

 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php
$preLink = '../';
require '../commons/includes.php';
 ?>
 <link rel='stylesheet' type='text/css' href='login.css'>
 <script src='../bootstrap/backstretch/backstretch.js'>
 </script>

 <!--commodo positive ssl secured-->
 <script type="text/javascript"> //<![CDATA[
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>

</head>

<body>
  <script>
    $.backstretch('../resources/background3.jpg');
  </script>
  <div class='intro_text'>
    <h1><b>WE</b>MR</h1>
    <h2>The all new smart EMR for your clinic, now completely free.</h2>
  </div>
  <div class='login'>
    <form action='index.php' method='post'>
      <div class='form-group'>
        <label for='username'>Username: </label>
      <input type='text' minlength='1' maxlength='40' name='username' placeholder='' class='form-control'>
    </div>
    <div class='form-group'>
      <label for='password'>Password:</label>
      <input type='password' maxlength='100' minlength='10' name='password' placeholder='' class='form-control'>
    </div>
      <button type='submit' class='btn btn-primary'>Log in</button> or
      <a href='../signup/'><button type='button' class='signup_button'>Sign up</button></a>

      <?php
      if (isset($_GET['error'])) {
        echo "<br><p>Invalid username/password.</p>";
      } else if (isset($_GET['error2'])) {
        echo "<br><p>You have exceeded 3 login attempts. Try again after " . $_GET['minutes'] . " minutes.</p>";
      }
       ?>
      </form>
  </div>


  <!--commodo positive ssl secured-->
  <script language="JavaScript" type="text/javascript">
TrustLogo("http://wehshi.website/resources/comodo_secure_seal_76x26_transp.png", "CL1", "none");
</script>
<a  href="https://www.positivessl.com/" id="comodoTL">Positive SSL</a>
</body>
</html>
