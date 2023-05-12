<?php
//connect.php is necessary for mysql connection


session_start();



  //checking if there was a submit
  if (isset($_POST["email"]))
  {
    $valid = true;

    //USERNAME
    $username = $_POST["username"];
    //checking length of nickname; not both at once to make different error message
    if (strlen($username) < 5 || strlen($username) > 15){
      $valid = false;
      $_SESSION["e_username"] = "<span id='error'>This nickname is too short or too long! <br/>
      Please use 5-15 alphanumeric characters. </span><br/>";
    }
    //checking if username contains of only alphanumeric characters
    if(!(ctype_alnum($username))){
      $valid = false;
      $_SESSION["e_username"] = "<span id='error'>This nickname contains invalid characters! <br/>
      Please use 5-15 alphanumeric characters. </span><br/>";
    }

    //E-MAIL
    $email = $_POST["email"];

    $sanit_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($sanit_email, FILTER_SANITIZE_EMAIL) === FALSE || $email != $sanit_email){
      $_SESSION["e_email"] = "<span id='error'>Wrong e-mail, do better. </span><br/>";
    }
    if (!$_POST["email"]){
      $_SESSION["e_email"] = "<span id='error'>It shouldn't be that empty. </span><br/>";
    }
    //PASSWORD
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    //checking password length
    if (strlen($password) < 8 || strlen($password) > 20){
      $valid = false;
      $_SESSION["e_password"] = "<span id='error'> Password should consist of 8 or more characters (the upper limit is 20). </span><br/>";
      //checking if password was correctly repeated
    } elseif ($password !== $password2){
      $valid = false;
      $_SESSION["e_password"] = "<span id='error'> Type the same password in each field! </span><br/>";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    //DATE OF BIRTH
    $birthDate = $_POST["birthdate"];
    if(!validateDate($birthDate)){
      $_SESSION["e_date"] = "<span id='error'> Don't know how you managed to get incorrect data format. Try again! </span><br/>";
    } elseif (birthDateToAge($birthDate) < 4 || birthDateToAge($birthDate) > 200) {
      $_SESSION["e_date"] = "<span id='error'> It seems to be very clear you wasn't really born then! </span><br/>";
    }
    //CHECKBOX - TERMS & CONDITIONS
    if(!(isset($_POST["terms"]))){
    $valid = false;
    $_SESSION["e_terms"] = "<span id='error'> Please tick this checkbox.
    If you didn't read the terms, please do - proper knowledge and
     communitation are key to making this expierence best! </span><br>";
    }
    //RECAPTCHA
    $secret_captcha = "6Lewy-AlAAAAALYJ9KZsHTiF6XvVEROxiG5hE5Em";
    $im_only_human = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_captcha.'&response='.$_POST["g-recaptcha-response"]);
    $response = json_decode($im_only_human);
    if (!($response->success)){
      $valid = false;
    $_SESSION["e_captcha"] = "<span id='error'> Confirm you are not WALL-E! </span><br>";
    }
    //checking if email and password are used first time
    require_once 'connect.php';
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
      $connection = new mysqli($host,$db_user,$db_password,$db_name);
      if ($connection->connect_errno !== 0)
      {
        throw new Exception(mysqli_connect_errno());

      } else {
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");

          if (!$result){
           throw new Exception($connection->error);
         } else {

           $email_used = $result->num_rows;

           if($email_used){
             $valid = false;
             $_SESSION["e_email"] = "<span id='error'>This email is already registered in our system!</span><br/>";
           }
         }
         $result = $connection->query("SELECT user_id FROM users WHERE username='$username'");

           if (!$result){
            throw new Exception($connection->error);
          } else {

            $username_used = $result->num_rows;

            if($username_used){
              $valid = false;
              $_SESSION["e_username"] = "<span id='error'>This username is taken!</span><br/>";
            }
          }
          if ($valid == true){

            if($new_user = $connection->query("INSERT INTO users VALUES (NULL,'$username','$password_hash',200,'$email','$birthDate')")){
              $_SESSION["registration"] = true;
              header("Location: welcome_page.php");

            } else {
              throw new \Exception($connection->error);

            }
          }

         $connection->close();
      }

    } catch (\Exception $e) {
      echo "<span id='error'> Server is not responding. Sorry for trouble.</span>";
      echo "<span id='error'> For geeks & developers:".$e."</span>";

    }


    //if there was no submit, validation shouldn't start at all.
    } else {
    $valid = false;
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

/**
* @param string $date
* optional @param string $format
*/
//note that this function is not made by me, but it's simple and works as planned.
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
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
<form method="post">
Username: <br>
<input name="username" type="text"><br>
<?php
if(isset($_SESSION["e_username"])){
  echo $_SESSION["e_username"];
  unset($_SESSION["e_username"]);
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
<input name="password" type="password"><br>
Repeat password:<br>
<input name="password2" type="password" ><br>
<?php
if(isset($_SESSION["e_password"])){
  echo $_SESSION["e_password"];
  unset($_SESSION["e_password"]);
}
?>
Date of birth:<br>
<input name="birthdate" type="date" placeholder="dd-mm-yyyy" min="1907-03-04" ><br>
<?php
if(isset($_SESSION["e_date"])){
  echo $_SESSION["e_date"];
  unset($_SESSION["e_date"]);
}
?>
<label>
  <input name="terms" type="checkbox">
I have read the terms and conditions of <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUXbmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXA%3D' target='_blank'>Palace</a>
</label><br>
<?php
if(isset($_SESSION["e_terms"])){
  echo $_SESSION["e_terms"];
  unset($_SESSION["e_terms"]);
}
?>
<div class="g-recaptcha" data-sitekey="6Lewy-AlAAAAAJNx3fwN0hRZuKURua92CChROQgZ"></div><br>
<?php
if(isset($_SESSION["e_captcha"])){
  echo $_SESSION["e_captcha"];
  unset($_SESSION["e_captcha"]);
}
?>

<br><input type="submit" value="I'm ready!">
</form>



  </body>
  </html>
