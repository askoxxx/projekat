<?php 
include('../includes/functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<div class="top">Web servis za prijavu ispita</div>
	<header class="glava">
		<img id="logo" src="../images/logo.png" alt="">
		<nav>
			<ul>
				<li><a href="#">Prijava</a></li>
				<li><a href="../register.php">Registracija</a></li>
				<li><a href="../promjena_sifre.php">Promjena šifre</a></li>
				<li><a href="../includes/odjava.php">Odjava</a></li>
			</ul>
		</nav>
	</header>
	
	<div class="header">
		<?php  if (isset($_SESSION['user'])) : ?>
		<h2>Korisnik: <?php echo $_SESSION['user']['username']; ?></h2>

		<?php endif ?>
	</div>
	<div class="content">

		<div class="user_commands">
			<form method="POST">
			<ul>
                    <li id="get_users" name="get_users_btn"><a href="pregled_korisnika.php">Pregled korisnika</a></li>
                    <li id="create_user" name="create_user_btn"><a href="dodaj_korisnika.php">Dodaj Korisnika</a></li>
                    <li id="delete_user" name="delete_user_btn"><a href="izbrisi_korisnika.php">Izbrisi Korisnika</a></li>
                    <li id="activate_user" name="activate_user_btn"><a href="aktiviraj_korisnika.php">Aktiviraj Korisnika</a></li>
					<li id="get_all_user_prijave"><a href="izlistaj_sve_prijave.php">Izlistaj sve prijave ispita</a></li>
				</ul>
			</form>
		</div>

	</div>

	<div id="database_content">
		<form method="POST">
			
		

		</form>
	</div>
	<footer></footer>
</body>
<!--MORAM OVAKO POSTAVITI STYLE ZA TABELU, NE RADI IZ CSS-FAJLA-->
<style>

	table {
	font-family: Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	width: 80%;
	margin: auto;
	}

	td, th {
	border: 1px solid #ddd;
	padding: 8px;
	}

	table tr:nth-child(even){
		background-color: #f2f2f2;
	}

	table tr:hover {
		background-color: #ddd;
	}

	th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #345AAA;
		color: white;
	}

	#filter_table {
		background-image: url('/css/searchicon.png'); /* Add a search icon to input */
		background-position: 10px 12px; /* Position the search icon */
		background-repeat: no-repeat; /* Do not repeat the icon image */
		width: 100%; /* Full-width */
		font-size: 16px; /* Increase font-size */
		padding: 12px 20px 12px 40px; /* Add some padding */
		border: 1px solid #ddd; /* Add a grey border */
		margin-bottom: 12px; /* Add some space below the input */
		margin-top: 50px;
	}

	form, .content {
		width: 100% !important;
		margin: 0px auto;
		padding: 20px;
		background: white;
		border-radius:0;
		margin: 0;
		padding: 0;
		margin-top: 30px;
		border: 0;
	}

	.user_commands ul {
		padding: 0;
		margin: 0 auto;
	}


	.user_commands li  a {
		display: inline-block;
		margin: 0 auto;
		width: 100%;
		margin-bottom: 5px;
		padding: 10px;
		text-align: center;
	}

	.user_commands a {
		background-color:  #345AAA;
		color: white;
	}

	.user_commands a:hover {
		opacity: .5;
	}

	.user_commands a {
		text-decoration: none;
	}


</style>
<script>
	function filterTable() {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("filter_table");
	filter = input.value.toUpperCase();
	table = document.getElementById("user_ispiti_table");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[2];
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}
</script>
</html>
