let emailRegex = /\S+@\S+\.\S+/;

// USER - VALIDACIJA ZA REGISTRACIJU NOVOG KORISNIKA

function validateRegisterUser() {


    let firstName = document.forms["registerForm"]["first_name"].value;
    let lastName = document.forms["registerForm"]["last_name"].value;
    let username = document.forms["registerForm"]["username"].value;
    let password1 = document.forms["registerForm"]["password_1"].value;
    let password2 = document.forms["registerForm"]["password_2"].value;
    let email = document.forms["registerForm"]["email"].value;
   
    let firstNameError = document.getElementById("firstNameError");
    let lastNameError = document.getElementById("lastNameError");
    let usernameError = document.getElementById("usernameError");
    let passwordError = document.getElementById("passwordError");
    let emailError = document.getElementById("emailError");

    let fErr, lErr, uErr, pErr, eErr;

    if (firstName.length === 0) {
        firstNameError.innerHTML = "Polje ime ne može biti prazno";
        firstNameError.style.color = "#a94442";
        fErr = false;
    }

    if (lastName.length === 0) {
        lastNameError.innerHTML = "Polje prezime ne može biti prazno";
        lastNameError.style.color = "#a94442";
        lErr = false;
    }

    if (username.length === 0) {
        usernameError.innerHTML = "Polje korisničko ime ne može biti prazno";
        usernameError.style.color = "#a94442";
        uErr = false;
    }

    if (password1 !== password2) {
        passwordError.innerHTML = "Sifre nisu iste";
        passwordError.style.color = "#a94442";
        pErr = false;
    }

    if (email.length === 0) {
        emailError.innerHTML = "Polje email ne može biti prazno";
        emailError.style.color = "#a94442";
        eErr = false;
    }

    if (!emailRegex.test(email)) {
        emailError.innerHTML = "Format email adrese nije validan";
        emailError.style.color = "#a94442";
        eErr = false;
    }

    if (fErr == false || lErr == false || uErr == false || pErr == false || eErr == false) {
        return false;
    } else {
        return true;
    }

}

// USER - VALIDACIJA ZA PRIJAVU POSTOJECEG KORISNIKA

function validateLoginUser() {
    let username = document.forms["loginForm"]["username"].value;
    let password = document.forms["loginForm"]["password"].value;

    let usernameError = document.getElementById("usernameError");
    let passwordError = document.getElementById("passwordError");

    let uErr, pErr;

    if (username.length === 0) {
        usernameError.innerHTML = "Polje korisničko ime ne može biti prazno";
        usernameError.style.color = "#a94442";
        uErr = false;
    }

    if (password == 0) {
        passwordError.innerHTML = "Polje šifra ne može biti prazno";
        passwordError.style.color = "#a94442";
        pErr = false;
    }

    if (uErr == false || pErr == false) {
        return false;
    } else {
        return true;
    }
    
}

// USER - VALIDACIJA ZA PROMJENU SIFRE

function validateForgotPassword() {

    let username = document.forms["forgtoPasswordForm"]["username"].value;
    let password1 = document.forms["forgtoPasswordForm"]["password"].value;
    let password2 = document.forms["forgtoPasswordForm"]["new_password"].value;

    let usernameError = document.getElementById("usernameError");
    let passwordError = document.getElementById("passwordError");
    let passwordError2 = document.getElementById("passwordError2");

    let fErr, lErr, uErr, pErr, pErr2;

    if (username.length === 0) {
        usernameError.innerHTML = "Polje korisničko ime ne može biti prazno";
        usernameError.style.color = "#a94442";
        uErr = false;
    }

    if (password1.length === 0) {
        passwordError.innerHTML = "Polje šifra ne može biti prazno";
        passwordError.style.color = "#a94442";
        uErr = false;
    }

    if (password2.length === 0) {
        passwordError2.innerHTML = "Polje nova šifra ne može biti prazno";
        passwordError2.style.color = "#a94442";
        uErr = false;
    }

    if (uErr == false || pErr == false || pErr2 == false) {
        return false;
    } else {
        return true;
    }
}

// ADMIN - VALIDACIJA DODAVANJE USERA

function validateRegisterUserAdmin() {
    console.log("radi");
    //RESET ERRORA

    let firstName = document.forms["adminRegisterUser"]["first_name"].value;
    let lastName = document.forms["adminRegisterUser"]["last_name"].value;
    let username = document.forms["adminRegisterUser"]["username"].value;
    let password1 = document.forms["adminRegisterUser"]["password_1"].value;
    let password2 = document.forms["adminRegisterUser"]["password_2"].value;
    let email = document.forms["adminRegisterUser"]["email"].value;
   
    let firstNameError = document.getElementById("firstNameError");
    let lastNameError = document.getElementById("lastNameError");
    let usernameError = document.getElementById("usernameError");
    let passwordError = document.getElementById("passwordError");
    let emailError = document.getElementById("emailError");

    let fErr, lErr, uErr, pErr, eErr;

    if (firstName.length === 0) {
        firstNameError.innerHTML = "Polje ime ne može biti prazno";
        firstNameError.style.color = "#a94442";
        fErr = false;
    }

    if (lastName.length === 0) {
        lastNameError.innerHTML = "Polje prezime ne može biti prazno";
        lastNameError.style.color = "#a94442";
        lErr = false;
    }

    if (username.length === 0) {
        usernameError.innerHTML = "Polje korisničko ime ne može biti prazno";
        usernameError.style.color = "#a94442";
        uErr = false;
    }

    if (password1 !== password2) {
        passwordError.innerHTML = "Sifre nisu iste";
        passwordError.style.color = "#a94442";
        pErr = false;
    }

    if (email.length === 0) {
        emailError.innerHTML = "Polje email ne može biti prazno";
        emailError.style.color = "#a94442";
        eErr = false;
    }

    if (!emailRegex.test(email)) {
        emailError.innerHTML = "Format email adrese nije validan";
        emailError.style.color = "#a94442";
        eErr = false;
    }

    if (fErr == false || lErr == false || uErr == false || pErr == false || eErr == false) {
        return false;
    } else {
        return true;
    }

}
