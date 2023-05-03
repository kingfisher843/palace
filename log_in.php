<?php
session_start();

if(!isset($_POST["username"]) || !isset($_POST["password"])){
header("Location: index.php");
}
//connect.php contains everything that is necessary to connect with mysql
require_once "connect.php";

//new connection
$connection = @new mysqli($host,$db_user,$db_password,$db_name);

//printing errors
if ($connection->connect_errno != 0)
{
echo "Error " . $connection->connect_errno;

} else {
  //no errors; downloading data from client
  $username = $_POST["username"];
  $password = $_POST["password"];

  $username = htmlentities($username,ENT_QUOTES,"UTF-8");
  $password = htmlentities($password,ENT_QUOTES,"UTF-8");




//check if query is valid, not if record exists;
  if ($result = @$connection->query(
    sprintf("SELECT * FROM users WHERE username ='%s' AND password ='%s'",
     mysqli_real_escape_string($connection,$username),
     mysqli_real_escape_string($connection,$password)))){

    $existing_users = $result->num_rows;
//if there is existing user with provided username and password, $existing_users === 1
    if ($existing_users){

      $record = $result->fetch_assoc();
      $_SESSION["user_id"] = $record["user_id"];
      $_SESSION["username"] = $record["username"];
      $_SESSION["email"] = $record["email"];
      $_SESSION["status"] = true;
      unset($_SESSION["login_error"]);
      header('Location: palace.php');
//closing the result to save little kittens
      $result->close();

    } else {
      $_SESSION["login_error"] = '<span id=error>Wrong login or password!</span>';
      header('Location: index.php');
    }

  }
//closing the connection to save even more little kittens
$connection->close();
}


?>
