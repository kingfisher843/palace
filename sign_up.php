<?php
//connect.php contains everything that is necessary to connect with mysql
require_once 'connect.php';

session_start();



function validate():bool
{

  //checking if there was a submit
  if (isset($_POST["email"]))
  {
    $valid = true;
    $username = $_POST["username"];
    //USERNAME
    //checking length of nickname; not both at once to make different error message
    if (strlen($username) < 5){
      $valid = false;
      $_SESSION["e_nick"] = "<span id='error'>This nickname is too short! <br>
      Please use 5-15 alphanumeric characters. </span><br>";
    } elseif (strlen($username) > 15) {
      $valid = false;
      $_SESSION["e_nick"] = "<span id='error'>This nickname is too long! <br>
      Please use 5-15 alphanumeric characters. </span><br>";
    }
//checking if username contains of only alphanumeric characters
    if(!ctype_alnum($username)){
      $valid = false;
      $_SESSION["e_nick"] = "<span id='error'>This nickname contains invalid characters! <br>
      Please use 5-15 alphanumeric characters. </span><br>";
    }
//E-MAIL
    $email = $_POST["email"];

    $sanit_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($sanit_email, FILTER_SANITIZE_EMAIL)=== FALSE || $email != $sanit_email){
      $_SESSION["e_email"] = "<span id='error'>Wrong e-mail, do better. </span><br>";
    }
    //PASSWORD
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    //checking password length
    if (strlen($password) < 8 || strlen($password) > 20){
    $valid = false;
    $_SESSION["e_password"] = "<span id='error'> Password should consist of 8 or more characters (the upper limit is 20). </span><br>";
    }
    //checking if password was correctly repeated
    if ($password !== $password2){
      $valid = false;
      $_SESSION["e_password"] = "<span id='error'> Type the same password in each field! </span><br>";
    }

    $password_hash = $password_hash($password, PASSWORD_DEFAULT);

    /**
    *@TODO: HANDLE DATE
    */
    //CHECKBOX - TERMS & CONDITIONS
    if(!isset($_POST["terms"])){
    $valid = false;
    $_SESSION["e_terms"] = "<span id='error'> Please tick this checkbox. If you didn't read the terms, please do - proper knowledge and communitation are key to making this expierence best! </span><br>";
    }
    //if there was no submit, validation shouldn't start at all.
    } else {
    $valid = false;
    }
    return $valid;
}

if (validate()){
  echo 'Super! Wszystko powinno się udać :3';

  /**
  * @todo insert data into database basically creating a new account
  *
  */

}

/**
* @param string $birthDate (in format "dd-mm-yy")
* @return int $age (in years)
*/
function birthDateToAge(string $birthDate): int
{
  $today = date("Y-m-d");

$diff = date_diff(date_create($birthDate), date_create($today));

return $diff->format('%y');
}
//minlength="5" maxlength="15"
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Palace</title>
    <link rel='stylesheet' href='stylesheet.css'>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>



<h3>To register, please fill all of these fields:</h3><br>
<form method="post" action="">
Username: <br>
<input name="username" type="text"><br>
<?php
if(isset($_SESSION["e_nick"])){
  echo $_SESSION["e_nick"];
  unset($_SESSION["e_nick"]);
}
?>
E-mail adress:<br>
<input name="email" type="text" ><br>
<?php
if(isset($_SESSION["e_email"])){
  echo $_SESSION["e_email"];
  unset($_SESSION["e_email"]);
}
?>
Password: <br>
<input name="password" type="password" minlength="8"><br>
Repeat password:<br>
<input name="password2" type="password" minlength="8" ><br>
<?php
if(isset($_SESSION["e_password"])){
  echo $_SESSION["e_password"];
  unset($_SESSION["e_password"]);
}
?>
Date of birth:<br>
<input name="birthdate" type="date" placeholder="dd-mm-yyyy" min="1907-03-04" ><br>

<label>
  <input name="terms" type="checkbox">
I have read the terms and conditions of <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUXbmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXA%3D' target='_blank'>Palace</a>
</label>
<?php
if(isset($_SESSION["e_password"])){
  echo $_SESSION["e_password"];
  unset($_SESSION["e_password"]);
}
?>
<div class="g-recaptcha" data-sitekey="6Lewy-AlAAAAAJNx3fwN0hRZuKURua92CChROQgZ"></div>
<br><input type="submit" value="I'm ready!">
</form>



  </body>
  </html>
