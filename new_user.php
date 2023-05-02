


<?php

require_once 'connect.php';

$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0)
{
echo "Error " . $connection->connect_errno;

} else {

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$birthdate = $_POST["birthdate"];


  //date in mm/dd/yyyy format
  $birthDate = "12/17/1983";
  //explode the date to get month, day and year
  $birthDate = explode("/", $birthDate);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));
  echo "Age is:" . $age;




$is_user_taken = "SELECT * FROM users WHERE username='$username'";

if ($result = @connection->query($is_user_taken)){

$taken = $result->num_rows;
if ($num_rows){
  echo "This name is already taken!";
} else {
  $new_user = "INSERT INTO users VALUES ('NULL','$username','$password',0,'$email')";

if ($connection->query($new_user)) {
    echo ""
}

  $connection->exit();
}

}







}












 ?>
