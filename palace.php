<?php
session_start();
if ($_SESSION['status'] != true || !isset($_SESSION["status"])){
  header('Location: index.php');
  exit();
}
  $date_of_birth = $_SESSION["date_of_birth"];
  function checkForBirthday($date_of_birth): bool
  {
    $birth = new DateTime($date_of_birth);
    $today = new DateTime();
    echo $birth->format("d-m");
    if ($birth->format("d-m") == $today->format("d-m")){
      return true;
    } else {
      return false;

    }
  }

  if(checkForBirthday($date_of_birth)){
    $_SESSION["b-day"] = "<br><span id='b-day'>Happy birthday! Thank you for choosing us!</span><br>";
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
  <p>Hello,<?= $_SESSION["username"];?>!<br/>
You are successfully logged into your account!<br/>
Your e-mail: <?=$_SESSION["email"]?><br/>
Your amount of gold: <?=$_SESSION["coins"];?><br/>
<button id="logout_button"><a href="logout.php">LOG OUT</a></button>

You were born <?=$_SESSION["date_of_birth"];?>
<?php
echo $_SESSION["b-day"];
unset($_SESSION["b-day"]);
?>


</body>
</html>
