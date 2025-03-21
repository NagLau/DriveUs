document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const messageDiv = document.getElementById('message');
    if (password !== confirmPassword) {
        messageDiv.textContent = 'A jelszavak nem egyeznek!';
        messageDiv.style.color = 'red';
    } else {
        localStorage.setItem('username', username);
        localStorage.setItem('password', password);
        messageDiv.textContent = 'Sikeres regisztráció! Átirányítás a bejelentkezési oldalra...';
        messageDiv.style.color = 'green';
        setTimeout(() => {
            window.location.href = 'bejelentkezes.html';
        }, 2000);
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const mainTitle = document.getElementById("main-title");
    const usernameLabel = document.getElementById("username-label");
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
            passwordLabel.textContent = "Password:";
            confirmPasswordLabel.textContent = "Confirm Password:";
            registerButton.textContent = "Register";
            loginButton.textContent = "Login";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Regisztráció";
            mainTitle.textContent = "Regisztráció";
            usernameLabel.textContent = "Felhasználónév:";
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



function updatePlaceholder() {
    const contactType = document.getElementById("contactType").value;
    const contactInput = document.getElementById("contactInput");
    const contactLabel = document.getElementById("contact-label");

    if (contactType === "email") {
        contactLabel.textContent = "E-mail cím:";
        contactInput.placeholder = "E-mail";
        contactInput.type = "email";
    } else {
        contactLabel.textContent = "Telefonszám:";
        contactInput.placeholder = "Telefonszám";
        contactInput.type = "tel";
    }
};
