<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Palace</title>
  </head>
  <body>
To register, please fill all of these fields:
<br>
<form method="post" action="new_user.php">
Username: <br>
<input name="username" type="text" required><br>
<p><?=$_POST["username_taken"];?></p>
Password: <br>
<input name="password" type="password" minlength="8" required><br>
E-mail adress:<br>
<input name="email" type="text" pattern="[A-Za-z]+@[a-z]+.[a-z]+" required><br>
Date of birth:<br>
<input name="birthdate" type="date" min="1907-03-04" required><br>
<br><input type="submit" value="I'm ready!">
  </body>
  </html>
