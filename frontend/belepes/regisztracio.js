document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const email = document.getElementById('contactInput').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const personalId = document.getElementById('personalId').value;
    const licenseNumber = document.getElementById('licenseNumber').value;
    const username = email.split('@')[0];
    const messageDiv = document.getElementById('message');
    if (password !== confirmPassword) {
        messageDiv.textContent = 'A jelszavak nem egyeznek!';
        messageDiv.style.color = 'red';
    } else {
        localStorage.setItem('email', email);
        localStorage.setItem('username', username);
        localStorage.setItem('password', password);
        localStorage.setItem('personalId', personalId);
        localStorage.setItem('licenseNumber', licenseNumber);
        window.location.href = 'bejelentkezes.html';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const passwordLabel = document.getElementById("password-label");
    const confirmPasswordLabel = document.getElementById("confirm-password-label");
    const registerButton = document.getElementById("register-button");
    const loginButton = document.getElementById("login-button");
    let isHungarian = true;
    function switchLanguageR() {
        if (isHungarian) {
            pageTitle.textContent = "Registration";
            passwordLabel.textContent = "Password:";
            confirmPasswordLabel.textContent = "Confirm Password:";
            registerButton.textContent = "Register";
            loginButton.textContent = "Login";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Regisztráció";
            passwordLabel.textContent = "Jelszó:";
            confirmPasswordLabel.textContent = "Jelszó megerősítése:";
            registerButton.textContent = "Regisztráció";
            loginButton.textContent = "Bejelentkezés";
            switchButton.textContent = "Switch to English";
        }
        isHungarian = !isHungarian;
    }
    switchButton.addEventListener("click", switchLanguageR);
});

document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const email = document.getElementById('contactInput').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const personalId = document.getElementById('personalId').value;
    const licenseNumber = document.getElementById('licenseNumber').value;
    const username = email.split('@')[0];
    const messageDiv = document.getElementById('message');
    if (password !== confirmPassword) {
        messageDiv.textContent = 'A jelszavak nem egyeznek!';
        messageDiv.style.color = 'red';
    } else {
        localStorage.setItem('email', email);
        localStorage.setItem('username', username);
        localStorage.setItem('password', password);
        localStorage.setItem('personalId', personalId);
        localStorage.setItem('licenseNumber', licenseNumber);
        localStorage.setItem('isLoggedIn', 'true');
        window.location.href = '../profilom/profilom.html';
    }
});