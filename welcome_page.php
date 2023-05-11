<?php
session_start();
if (isset($_SESSION["status"]) && $_SESSION["status"] === true) {
  header('Location: palace.php');
  exit();
} elseif (!isset($_SESSION["registration"]){
  header('Location: index.php');
} else {
  unset($_SESSION["registration"]);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Palace</title>
    <link rel="stylesheet" href="stylesheet.css">
 </head>
  <body>


    WELCOME TO THE PALACE! YOU ARE HERE FIRST TIME, BUT CERTAINLY NOT LAST!

    <br> <a href="index.php">Log in!</a>


  </body>
</html>
