<?php
//connect.php contains everything that is necessary to connect with mysql
require_once 'connect.php';

//new connection
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

//printing errors
if ($connection->connect_errno != 0) {

  echo "Error " . $connection->connect_errno;

} else {
//no errors; downloading data from client
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  $birthDate = $_POST["birthdate"];

  $is_user_taken = "SELECT * FROM users WHERE username='$username'";
//checking if $is_user_taken is a valid query
  if ($result = @connection->query($is_user_taken)){

    $taken = $result->num_rows;
//if username is taken, $result->num_rows is not equal 0
    if ($taken){
      echo "This name is already taken!";
    } else {
//inserting new user into database
      $new_user = "INSERT INTO users VALUES ('NULL','$username','$password',0,'$email')";

      if ($connection->query($new_user)) {
        echo ""
      }

      $connection->exit();
    }

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






}












 ?>
