<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Palace</title>
  </head>
  <body>

<?php
require_once "connect.php";


$connection = @new mysqli($host,$db_user,$db_password,$db_name);

if ($connection->connect_errno != 0)
{
echo "Error " . $connection->connect_errno;

} else {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $find_user = "SELECT * FROM users WHERE username ='$username' AND password ='$password'";

//check if query is valid, not if record exists;
  if ($result = @$connection->query($find_user)){

    $existing_users = $result->num_rows;
    if ($existing_users){

      $record = $result->fetch_assoc();
      $_SESSION["username"] = $record["username"];
      $_SESSION["email"] = $record["email"];
      $_SESSION["status"] = true;
      header('Location: palace.php');
      $result->close();

    } else {
      $_SESSION["login_error"] = '<span style="color:red">Wrong login or password!</span>';
      header('Location: index.php');
    }

  }

$connection->close();
}


?>

</body>
</html>
