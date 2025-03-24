let generatedCode = null;

document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const verificationCode = document.getElementById('verificationCode').value;
    const verificationSection = document.getElementById('verificationSection');
    const messageDiv = document.getElementById('message');

    if (verificationSection.style.display === 'none') {
        if (password !== confirmPassword) {
            messageDiv.textContent = 'A jelszavak nem egyeznek!';
            messageDiv.style.color = 'red';
            return;
        }
        generatedCode = Math.floor(1000 + Math.random() * 9000).toString();
        alert(`Visszaigazoló kód elküldve a(z) ${email} e-mail címre: ${generatedCode}`);
        verificationSection.style.display = 'block';
        messageDiv.textContent = 'Kérjük, adja meg az e-mailben kapott kódot!';
        messageDiv.style.color = 'blue';
    } else {
        if (verificationCode !== generatedCode) {
            messageDiv.textContent = 'Hibás visszaigazoló kód!';
            messageDiv.style.color = 'red';
        } else {
            localStorage.setItem('username', username);
            localStorage.setItem('password', password);
            localStorage.setItem('email', email);
            messageDiv.textContent = 'Sikeres regisztráció! Átirányítás a bejelentkezési oldalra...';
            messageDiv.style.color = 'green';
            generatedCode = null;
            verificationSection.style.display = 'none';
            setTimeout(() => {
                window.location.href = 'bejelentkezes.html';
            }, 2000);
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const mainTitle = document.getElementById("main-title");
    const usernameLabel = document.getElementById("username-label");
    const emailLabel = document.getElementById("email-label");
    const passwordLabel = document.getElementById("password-label");
    const confirmPasswordLabel = document.getElementById("confirm-password-label");
    const registerButton = document.getElementById("register-button");
    const loginButton = document.getElementById("login-button");
    let isHungarian = true;
    function switchLanguageR() {
        if (isHungarian) {
            pageTitle.textContent = "Registration";
            mainTitle.textContent = "Registration";
            usernameLabel.textContent = "Username:";
            emailLabel.textContent = "Email:";
            passwordLabel.textContent = "Password:";
            confirmPasswordLabel.textContent = "Confirm Password:";
            registerButton.textContent = "Register";
            loginButton.textContent = "Login";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Regisztráció";
            mainTitle.textContent = "Regisztráció";
            usernameLabel.textContent = "Felhasználónév:";
            emailLabel.textContent = "E-mail:";
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