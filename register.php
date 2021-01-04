<?php include('includes/functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/script.js"></script>
</head>
<body>

	<div class="top">Web servis za prijavu ispita</div>
	<header class="glava">
		<img id="logo" src="images/logo.png" alt="">
		<nav>
			<ul>
				<li><a href="login.php">Prijava</a></li>
				<li><a href="register.php">Registracija</a></li>
				<li><a href="promjena_sifre.php">Promjena šifre</a></li>
				<li><a href="#">Odjava</a></li>
			</ul>
		</nav>
	</header>

	<div class="header">
		<h2>Registracija korisnika</h2>
	</div>
	<form name="registerForm" action="register.php" onSubmit="return validateRegisterUser()" method="post">
		<div class="input-group">
			<label>Ime</label>
			<input type="text" name="first_name" placeholder="">
			<div id="firstNameError"></div>
		</div>
		<div class="input-group">
			<label>Prezime</label>
			<input type="text" name="last_name" value="">
			<div id="lastNameError"></div>
		</div>
		<div class="input-group">
			<label>Korisnicko ime</label>
			<input type="text" name="username" value="">
			<div id="usernameError"></div>
		</div>
		<div class="input-group">
			<label>Sifra</label>
			<input type="password" name="password_1" value="">
			<div id="passwordError"></div>
		</div>
		<div class="input-group">
			<label>Potvrda sirfe</label>
			<input type="password" name="password_2" value="">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email" value="">
			<div id="emailError"></div>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn">Registruj me</button>
		</div>
	</form>

	<footer></footer>
</body>
</html>