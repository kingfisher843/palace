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
//checking length of nickname; not both at once to make different error message
    if (strlen($username)< 5){
      $valid = false;
      $_SESSION["e_nick"] = "<span id='error'>This nickname is too short! <br>
      Please use 5-15 alphanumeric characters. </span><br>";
    } elseif (strlen($username)> 15) {
      $valid = false;
      $_SESSION["e_nick"] = "<span id='error'>This nickname is too long! <br>
      Please use 5-15 alphanumeric characters. </span><br>";
    }

  //if there was no submit, validation shouldn't start at all.
  } else {
    $valid = false;
  }
  return $valid;
}
if (validate()){
  echo 'Super!';

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
<input name="username" type="text" required><br>
<?php
if(isset($_SESSION["e_nick"])){
  echo $_SESSION["e_nick"];
  unset($_SESSION["e_nick"]);
}
?>
Password: <br>
<input name="password" type="password" minlength="8" ><br>
Repeat password:<br>
<input name="password2" type="password" minlength="8" ><br>
E-mail adress:<br>
<input name="email" type="email" ><br>
Date of birth:<br>
<input name="birthdate" type="date" placeholder="dd-mm-yyyy" min="1907-03-04" ><br>

<label>
  <input name="terms" type="checkbox" >
I have read the terms and conditions of <a href='terms.html' target='_blank'>Palace</a>
</label>
<div class="g-recaptcha" data-sitekey="6Lewy-AlAAAAAJNx3fwN0hRZuKURua92CChROQgZ"></div>
<br><input type="submit" value="I'm ready!">
</form>



  </body>
  </html>
