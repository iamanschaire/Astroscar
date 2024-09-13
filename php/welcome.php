<?php

	session_start();
	
	if (!isset($_SESSION['registration_yes']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['registration_yes']);
	}
	
	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_password1'])) unset($_SESSION['fr_password1']);
	if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);
	if (isset($_SESSION['fr_rules'])) unset($_SESSION['fr_rules']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if (isset($_SESSION['e_rules'])) unset($_SESSION['e_rules']);
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Welcome - Astrology</title>
</head>

<body>
	
	Thank you for signing in!<br /><br />
	
	<a href="index.php">Log into your account!</a>
	<br /><br />

</body>
</html>