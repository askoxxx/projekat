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
		<h2>Prijava korisnika</h2>
	</div>
	<form method="POST" name="loginForm" action="login.php" onSubmit="return validateLoginUser()">
		<div class="input-group">
			<label>Korisničko ime</label>
			<input type="text" name="username" >
			<div id="usernameError"></div>
		</div>
		<div class="input-group">
			<label>Šifra</label>
			<input type="password" name="password">
			<div id="passwordError"></div>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Prijavi me</button>
		</div>
	</form>

	<footer></footer>
</body>
</html>
