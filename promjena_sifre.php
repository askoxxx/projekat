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
	<?php echo display_success(); ?>
	<?php echo display_fail(); ?>
	<div class="top">Web servis za prijavu ispita</div>
	<header class="glava">
		<img id="logo" src="images/logo.png" alt="">
		<nav>
			<ul>
				<li><a href="login.php">Prijava</a></li>
				<li><a href="register.php">Registracija</a></li>
				<li><a href="">Promjena šifre</a></li>
				<li><a href="">Odjava</a></li>
			</ul>
		</nav>
	</header>

	<div class="header">
		<h2>Promjena šifre</h2>
	</div>
	<form method="post" action="promjena_sifre.php" name="forgtoPasswordForm" onSubmit="return validateForgotPassword()">

		<?php echo display_error(); ?>

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
			<label>Nova šifra</label>
			<input type="password" name="new_password">
			<div id="passwordError2"></div>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="updatePassword_btn">Promijeni šifru</button>
		</div>
	</form>

	<footer></footer>
</body>
</html>