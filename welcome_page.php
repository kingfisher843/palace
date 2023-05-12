<?php
session_start();
if (!isset($_SESSION["registration"]){
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


    <h1>WELCOME TO THE PALACE! YOU ARE HERE FIRST TIME, BUT CERTAINLY NOT LAST!</h1>

    <br> <a href="index.php">Log in for the first time!</a>


  </body>
</html>
