<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		$birthday = $_POST['birthday'];
		$time = $_POST['time'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$lat = $_POST['latitude'];
		$lng = $_POST['longitude'];
		
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$wszystko_OK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}	

		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano rules?
		if (!isset($_POST['rules']))
		{
			$wszystko_OK=false;
			$_SESSION['e_rules']="Potwierdź akceptację rulesu!";
		}				
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		$_SESSION['birthday'] = $birthday;
		$_SESSION['time'] = $time;
		$_SESSION['city'] = $city;
		$_SESSION['country'] = $country;
		$_SESSION['lat'] = $lat;
		$_SESSION['lng'] = $lng;
		if (isset($_POST['rules'])) $_SESSION['fr_rules'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$result = $connection->query("SELECT id FROM register WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$num_mails = $result->num_rows;
				if($num_mails>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$result = $connection->query("SELECT id FROM register WHERE user='$nick'");
				
				if (!$result) throw new Exception($connection->error);
				
				$num_nicks = $result->num_rows;
				if($num_nicks>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					
					if ($connection->query("INSERT INTO register VALUES (NULL, '$nick', '$password_hash', '$email', '$birthday', '$time', '$city', '$country', '$lat', '$lng')"))
					{
						$_SESSION['registration_yes']=true;
						header('Location: welcome.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
					
				}
				
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server Error</span>';
			echo '<br />Developer info: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Astrology - registration</title>
	<link rel="stylesheet" href="main2.css">
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<h1>Registration</h1>
	<form method="post">
	
		Nickname: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name="nick" /><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		Type the password: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_password1']))
			{
				echo $_SESSION['fr_password1'];
				unset($_SESSION['fr_password1']);
			}
		?>" name="password1" /><br />
		
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>		
		
		Type password again: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_password2']))
			{
				echo $_SESSION['fr_password2'];
				unset($_SESSION['fr_password2']);
			}
		?>" name="password2" /><br />

		Birthday: <br /> <input type="date" value="<?php
			if (isset($_SESSION['birthday']))
			{
				echo $_SESSION['birthday'];
				unset($_SESSION['birthday']);
			}
		?>" name="birthday" /><br />

		Time of birth: <br /> <input type="time" value="<?php
			if (isset($_SESSION['time']))
			{
				echo $_SESSION['time'];
				unset($_SESSION['time']);
			}
		?>" name="time" /><br />

			<div class="form-group col-md-6 ">
                <label>Country</label><br>
                
                <select class="form-control"  onchange="getCities()" name="country" id="country" value="" required>
                  <option value=>--The Whole World--</option>
                  <option value="PL">Poland</option>
                  <option value="GB">United Kingdom</option>
                  <option value="US">United States</option>
                </select>
                  
              </div>

		<div class="form-group col-md-6">
                <label>Place of Birth</label><br>
                <input name="city" class="form-control" value="" type="text" onchange="getLocation()" list="citylist" id="city" required/>
                <datalist name="citylist" id="citylist">
   
                  </datalist>
              </div>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../natal-chart-main/getLocations.js"></script>
    <script type="text/javascript" src="../natal-chart-main/app_uncompressed.js"></script>
		<div class="form-group col-md-6 ">
                <label>Latitude</label><br>
                <input class="form-control" id="latitude" name="latitude" type="number" step="any" min="-90" max="90" value="" readonly></input>
              </div>
              <div class="form-group col-md-6 ">
                <label>Longitude</label><br>
                <input class="form-control" id="longitude" name="longitude" type="number" step="any" min="-180" max="180" value="" readonly></input>
              </div>
            </div>
		<br />		
		
		<label>
			<input type="checkbox" name="rules" class="checkbox"<?php
			if (isset($_SESSION['fr_rules']))
			{
				echo "checked";
				unset($_SESSION['fr_rules']);
			}
				?>/> Accept all the terms
		</label>
		
		<?php
			if (isset($_SESSION['e_rules']))
			{
				echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
				unset($_SESSION['e_rules']);
			}
		?>	
		
		<br />
		
		<input type="submit" value="Register" />
		
	</form>

</body>
</html>