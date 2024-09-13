<?php

	session_start();
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: account.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Astrology - account login</title>
	<link rel="stylesheet" href="main.css">
</head>

<body>
	
	<p><i>“One’s astrological horoscope may be compared metaphorically to one’s genetic heritage; <br>it cannot be changed, but we can do what we may with what we are given.”

</i><br>– Elizabeth Davis</p><br /><br />
	
	<div class="login">
	<form action="log-in.php" method="post" class="form" style="width: 500px; height: 350px; border: 0.125rem solid white; border-radius: 1.125rem; margin-left: 42.5rem; text-align: center;">
	<br>
		Login: <br /> <input type="text" name="login" placeholder="Insert your login..."/> <br />
		Password: <br /> <input type="password" name="password" placeholder="Insert your password..." /> <br /><br />
		<input type="submit" value="Sign In" class="submit" /><br><br>
		<a href="registration.php">Register - be a member of our astrological community!</a><br>
	</form>
</div>


	<br /><br />

	
<?php
	if(isset($_SESSION['error']))	echo $_SESSION['error'];
?>

</body>
</html>