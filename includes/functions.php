<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$first_name = "";
$last_name = "";
$username = "";
$password= "";
$email    = "";
$errors   = array(); 
$messages = array();
$success = array();
$fail = array();

// USER - HANDLER za register()
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
	// defined below to escape form values
	
	$first_name    =  e($_POST['first_name']);
	$last_name       =  e($_POST['last_name']);
	$username  =  e($_POST['username']);
	$password  =  e($_POST['password_1']);
	$email  =  e($_POST['email']);

	//PROVJERI DA LI VEC POSTOJI ISTI USERNAME / EMAIL 
	$sql_username = "SELECT * FROM users WHERE username='$username'";
	$sql_email = "SELECT * FROM users WHERE email='$email'";
	$res_username = mysqli_query($db, $sql_username);
	$res_email = mysqli_query($db, $sql_email);

	if (mysqli_num_rows($res_username) > 0) {
	  $name_error = "Greška - Korisničko ime već postoji"; 	
	  array_push($errors, $name_error);
	  
	} else if(mysqli_num_rows($res_email) > 0){
	  $email_error = "Greška - Email već postoji"; 	
	  array_push($errors,  $email_error); 
	  
	}

	// REGISTRUJ USERA AKO NE POSTOJE GRESKE U FORMI (USERNAME/EMAIL)
	if (count($errors) == 0) {
		//ENKRIPTUJ SIFRU PRIJE SNIMANJA U BAZU
		$password = md5($password);
		$query = "INSERT INTO users (first_name, last_name, username, password, email, activated) 
					VALUES('$first_name', '$last_name', '$username', '$password', '$email', 'false')";
		mysqli_query($db, $query);
		$_SESSION['success']  = "New user successfully created!!";
		//REDIRECT ON SUCCESS
		header('location: login.php');
	}
}


// call the create_user() function if create_btn is clicked
if (isset($_POST['create_btn'])) {
	create_user();
}

// ADMIN - DODAJ KORISNIKA
function create_user(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$first_name    =  e($_POST['first_name']);
	$last_name       =  e($_POST['last_name']);
	$username  =  e($_POST['username']);
	$password  =  e($_POST['password_1']);
	$email  =  e($_POST['email']);

	//encrypt the password before saving in the database
	$password = md5($password);

	$user_type = e($_POST['user_type']);
	$query = "INSERT INTO users (first_name, last_name, username, password, email, user_type) 
			VALUES('$first_name', '$last_name', '$username', '$password', '$email', '$user_type')";
	mysqli_query($db, $query);

	$_SESSION['success']  = "New user successfully created!!";
	header('location: admin_dashboard.php');				
			
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

// FUNKCIJA ZA PRIKAZ PORUKA SUCCESS 
function display_success() {
	global $success;

	if (count($success) > 0){
		echo '<div class="">';
			foreach ($success as $message){
				echo $message .'<br>';
			}
		echo '</div>';
	}
}	

// FUNKCIJA ZA PRIKAZ PORUKA FAIL 
function display_fail() {
	global $fail;

	if (count($fail) > 0){
		echo '<div class="">';
			foreach ($fail as $message){
				echo $message .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// EVENT HANDLER login()
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors, $success, $fail;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found

			// check if user is admin or user AND if account is activated
			$logged_in_user = mysqli_fetch_assoc($results);

			//account activation check
			if ($logged_in_user['activated'] == 'false') {
				header('location: login.php');
				exit();
			}

			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				//$_SESSION['success']  = "Uspješno ste se prijavili na servis";
				array_push($success, "Uspješno ste se prijavili na servis");
				header('location: admin/admin_dashboard.php');		  
			} else {
				$_SESSION['user'] = $logged_in_user;
				//$_SESSION['success']  = "Uspješno ste se prijavili na servis";
				array_push($success, "Uspješno ste se prijavili na servis");
				header('location: user/index.php');
			}
		} else {
			array_push($fail, "Pogrešno korisničko ime ili šifra");
		}
	}
}

// POZOVI updatePassword() funkciju kada se klikne updatePassword_btn
if (isset($_POST['updatePassword_btn'])) {
	updatePassword();
}

// PROMIJENI SIFRU 
function updatePassword() {

	//POZOVI DA BI IMAO PRISTUP BAZI_PODATAKA U FUNKCIJI
	global $db, $success, $fail, $username, $password, $new_password;

	$username  =  e($_POST['username']);
	$password  =  e($_POST['password']);
	$new_password = e($_POST['new_password']);
	
	//HESOVANJE PASSWORDA
	$password = md5($password);
	$new_password = md5($new_password);

	//PROVJERI DA LI POSTOJ USERNAME / PASSWORD 
	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {
		$query = "UPDATE users SET password='$new_password' WHERE username='$username'";
		mysqli_query($db, $query);
 	
		array_push($success, "PROMJENA ŠIFRE USPJEŠNA");
	} else {
		array_push($fail, "PROMJENA ŠIFRE NEUSPJEŠNA");
	}


}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}




// USER - GET SVE PRIJAVLJENE ISPITE ZA USERA
function getRegisteredIspiti() {
	global $db, $id;
	//GET TRENUTNI USER ID
	$id = $_SESSION['user']['id'];


	$query = "SELECT users.first_name, users.last_name, ispiti.naziv, ispiti.skracenica, ispiti.semestar, ispiti.godina
			FROM users
			INNER JOIN users_ispiti
				ON users.id = users_ispiti.id_user
			INNER JOIN ispiti
				ON ispiti.id = users_ispiti.id_ispit
			WHERE users.id = '$id'";
	
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='user_ispiti_table'>";
		echo "<tr>";
		echo "<th>Ime</th>";
		echo "<th>Prezime</th>";
		echo "<th>Naziv ispita</th>";
		echo "<th>Skracenica</th>";
		echo "<th>Semestar</th>";
		echo "<th>Godina</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["naziv"] ."</td><td>". $row["skracenica"] ."</td><td>". $row["semestar"] ."</td><td>". $row["godina"]; 
		}

		echo "</table>";
		
	} else {
		echo "UPIT NEUSPJESAN";
	}
}



//USER - ODJAVI ISPIT
function odjaviIspit() {
	global $db, $id;
	//GET TRENUTNI USER ID
	$id = $_SESSION['user']['id'];


	$query = "SELECT users.first_name, users.last_name, ispiti.naziv, ispiti.skracenica, ispiti.semestar, ispiti.godina
			FROM users
			INNER JOIN users_ispiti
				ON users.id = users_ispiti.id_user
			INNER JOIN ispiti
				ON ispiti.id = users_ispiti.id_ispit
			WHERE users.id = '$id'";
	
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='user_ispiti_table'>";

		echo "<tr>";
		echo "<th>Ime</th>";
		echo "<th>Prezime</th>";
		echo "<th>Naziv ispita</th>";
		echo "<th>Skracenica</th>";
		echo "<th>Semestar</th>";
		echo "<th>Godina</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["naziv"] ."</td><td>". $row["skracenica"] ."</td><td>". $row["semestar"] ."</td><td>". $row["godina"]; 
		}

		echo "</table>";		
		//echo "<input type='text' id='filter_table' onkeyup='filterTable()' placeholder='Naziv ispita za brisanje'>";
	} else {
		echo "UPIT NEUSPJESAN";
	}
}

// EVENT HANDLER login()
if (isset($_POST['brisi_ispit_btn'])) {
	brisiIspit();
}

//USER - BRISI ISPIT
function brisiIspit() {
	global $db, $id, $ispitNaziv, $ispitId;
	//GET TRENUTNI USER ID
	$userId = $_SESSION['user']['id'];
	$ispitNaziv  =  e($_POST['naziv_ispita']);

	$query = "SELECT id FROM ispiti WHERE naziv = '$ispitNaziv'"; 
	$idResult = mysqli_query($db, $query);

	if (mysqli_num_rows($idResult) > 0) {
		
		while ($row = mysqli_fetch_assoc($idResult)) {
			$ispitId = $row["id"]; 
		}
	} else {
		echo "ID upit neuspjesan";
	}

	$query = "DELETE FROM users_ispiti WHERE id_user = '$userId' AND id_ispit = '$ispitId'"; 
	$deleteResult = mysqli_query($db, $query);

}


function getSveIspite() {
	global $db, $id;
	//GET TRENUTNI USER ID
	$id = $_SESSION['user']['id'];
	
	$query = "SELECT ispiti.naziv, ispiti.skracenica, ispiti.semestar, ispiti.godina FROM ispiti";
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='user_ispiti_table'>";
		echo "<tr>";
		echo "<th>Naziv</th>";
		echo "<th>Skracenica</th>";
		echo "<th>Semestar</th>";
		echo "<th>Godina</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr><td>". $row["naziv"] ."</td><td>". $row["skracenica"] ."</td><td>". $row["semestar"] ."</td><td>". $row["godina"]; 
		}

		echo "</table>";
		
	} else {
		echo "UPIT NEUSPJESAN";
	}
}


//HANDLER prijaviIspit()
if (isset($_POST['prijavi_ispit_btn'])) {
	prijaviIspit();
}

//USER - PRIJAVI ISPIT
function prijaviIspit() {
	
	global $db, $id, $ispitId;

	//GET TRENUTNI USER ID I NAZIV ISPITA
	$id = $_SESSION['user']['id'];
	$ispitNaziv  =  e($_POST['naziv_ispita']);

	$ispitIdQuery = "SELECT id FROM ispiti WHERE naziv = '$ispitNaziv'"; 
	$idResult = mysqli_query($db, $ispitIdQuery);

	//KOVERTUJ NAZIV ISPITA U ID ISPITA
	if (mysqli_num_rows($idResult) > 0) {
		while ($row = mysqli_fetch_assoc($idResult)) {
			$ispitId = $row["id"]; 
		}
		echo "FETCH U BAZU UPSJESAN";
	} else {
		echo "FETCH NEUSPJESAN";
	}

	//TEST DA LI JE PREDMET VEC PRIJAVLJEN ISPIT
	$query = "SELECT users.first_name, users.last_name, ispiti.naziv, ispiti.skracenica, ispiti.semestar, ispiti.godina
			FROM users
			INNER JOIN users_ispiti
				ON users.id = users_ispiti.id_user
			INNER JOIN ispiti
				ON ispiti.id = users_ispiti.id_ispit
			WHERE users.id = '$id' AND id_ispit = '$ispitId'";

	$result = mysqli_query($db, $query);

	if (mysqli_num_rows($result) > 0) {
		echo "GREŠKA: ISPIT JE VEĆ PRIJAVLJEN";
	} else {
		//UPIS U BAZU
		$insertQuery = "INSERT INTO users_ispiti(id_user, id_ispit) VALUES('$id', '$ispitId');";
		mysqli_query($db, $insertQuery);
		echo "ISPIT USPJEŠNO PRIJAVLJEN";
	}
}


//ADMIN - PREGLED KORISNIKA

// EVENT HANDLER getUsers()
if (isset($_POST['get_users_btn'])) {
	getUsers();
}

function getUsers() {

	global $db;

	$query = "SELECT first_name, last_name, username, email FROM users"; 
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='users_table'>";
		echo "<tr>";
		echo "<th>Ime</th>";
		echo "<th>Prezime</th>";
		echo "<th>Korisničko ime</th>";
		echo "<th>Email</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["username"] ."</td><td>". $row["email"]; 
		}

		echo "</table>";
		
	} else {
		echo "UPIT NEUSPJESAN";
	}

}


// EVENT HANDLER getSveprijave()
if (isset($_POST['get_all_user_prijave_btn'])) {
	getSveprijave();
}

// ADMIN - GET SVE PRIJAVE ISPITA SVIH USERA
function getSveprijave() {
	global $db;

	$query = "SELECT users.first_name, users.last_name, ispiti.naziv, ispiti.skracenica, ispiti.semestar, ispiti.godina
			FROM users
			INNER JOIN users_ispiti
				ON users.id = users_ispiti.id_user
			INNER JOIN ispiti
				ON ispiti.id = users_ispiti.id_ispit";
	
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='all_ispiti_table'>";
		echo "<tr>";
		echo "<th>Ime</th>";
		echo "<th>Prezime</th>";
		echo "<th>Naziv ispita</th>";
		echo "<th>Skracenica</th>";
		echo "<th>Semestar</th>";
		echo "<th>Godina</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["naziv"] ."</td><td>". $row["skracenica"] ."</td><td>". $row["semestar"] ."</td><td>". $row["godina"]; 
		}

		echo "</table>";
		
	} else {
		echo "UPIT NEUSPJESAN";
	}
}

//HANDLER - GET USERE KOJE TREBA AKTIVIRATI
if (isset($_POST['activate_user_btn'])) {
	getInactiveUsers();
}

// ADMIN - GET USERE KOJE TREBA AKTIVIRATI
function getInactiveUsers() {

	global $db, $email;

	$query = "SELECT first_name, last_name, username, email FROM users WHERE activated = 'false'"; 
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) > 0) {

		echo "<table id='users_table'>";
		echo "<tr>";
		echo "<th>Ime</th>";
		echo "<th>Prezime</th>";
		echo "<th>Korisničko ime</th>";
		echo "<th>Email</th>";
		echo "</tr>";

		while ($row = mysqli_fetch_assoc($results)) {
			$email = $row["email"];
			echo "<tr><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["username"] ."</td><td>". $row["email"]; 
		}

		echo "</table>";
		
	} else {
		//echo "UPIT NEUSPJESAN";
	}
}

//HANDLER - ADMIN AKTIVIRAJ USERA
if (isset($_POST['activate_user_btn'])) {
	activateUser();
}

//ADMIN - AKTIVIRAJ USERA
function activateUser() {

	global $db, $username;

	//GET USERNAME ZA AKTIVACIJU
	$username = e($_POST['username']);

	$query = "UPDATE users SET activated = true WHERE username = '$username'";
	mysqli_query($db, $query);

}


//HANDLER - ADMIN IZBRISI USERA
if (isset($_POST['delete_user_btn'])) {
	deleteUser();
}

//ADMIN - IZBRISI USERA
function deleteUser() {
	
	global $db, $username;

	$username = e($_POST['user_to_delete']);

	$query = "DELETE FROM users WHERE username = '$username'";
	mysqli_query($db, $query);

}

//HANDLER - USER IZMIJENI ISPIT
if (isset($_POST['izmijeni_ispit_btn'])) {
	updateExam();
}

//USER - IZMIJENI ISPIT
function updateExam() {

	global $db, $oldIspitId, $newIspitId, $currentUser;
	$nameOldIspit  =  e($_POST['ispit_za_promjeniti']);
	$nameNewIspit  =  e($_POST['novi_ispit']);

	//echo $nameOldIspit;
	//echo $nameNewIspit;

	$nameOldIspit = "SELECT id FROM ispiti WHERE naziv = '$nameOldIspit'"; 
	$idResult = mysqli_query($db, $nameOldIspit);

	//KOVERTUJ NAZIV OLD_ISPITA U ID ISPITA
	if (mysqli_num_rows($idResult) > 0) {
		while ($row = mysqli_fetch_assoc($idResult)) {
			$oldIspitId = $row["id"]; 
		}
		//echo "FETCH U BAZU UPSJESAN";
	} else {
		//echo "FETCH NEUSPJESAN";
	}

	$nameNewIspit = "SELECT id FROM ispiti WHERE naziv = '$nameNewIspit'"; 
	$idResult = mysqli_query($db, $nameNewIspit);

	//KOVERTUJ NAZIV NEW_ISPITA U ID ISPITA
	if (mysqli_num_rows($idResult) > 0) {
		while ($row = mysqli_fetch_assoc($idResult)) {
			$newIspitId = $row["id"]; 
		}
		//echo "FETCH U BAZU UPSJESAN";
	} else {
		//echo "FETCH NEUSPJESAN";
	}

	//GET ID TRENUTNOG USERA
	$currentUser = $_SESSION['user']['id'];

	$query = "UPDATE users_ispiti SET id_ispit = '$newIspitId' WHERE id_user = '$currentUser' AND id_ispit = '$oldIspitId'";
	mysqli_query($db, $query);

}













