<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Palace</title>
    <link rel='stylesheet' href='stylesheet.css'>
  </head>
  <body>
<h3>To register, please fill all of these fields:</h3>
<br>
<form method="post" action="new_user.php">
Username (): <br>
<input name="username" type="text" required><br>
<p><?=$_POST["username_taken"];?></p>
Password: <br>
<input name="password" type="password" minlength="8" required><br>
E-mail adress:<br>
<input name="email" type="email" required><br>
Date of birth:<br>
<input name="birthdate" type="date" placeholder="dd-mm-yyyy" min="1907-03-04" required><br>
I have read the terms and conditions of <a href='terms.html'>Palace</a>
<input name="rules" type="checkbox" required><br>
<br><input type="submit" value="I'm ready!">
  </body>
  </html>
