document.getElementById('loginForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const loginEmail = document.getElementById('loginUsername').value;
    const loginPassword = document.getElementById('loginPassword').value;
    const messageDiv = document.getElementById('message');
    const storedEmail = localStorage.getItem('email');
    const storedPassword = localStorage.getItem('password');
    if (loginEmail === storedEmail && loginPassword === storedPassword) {
        localStorage.setItem('isLoggedIn', 'true');
        messageDiv.textContent = 'Sikeres bejelentkezés!';
        messageDiv.style.color = 'green';
        setTimeout(() => {
            window.location.href = '../fooldal/index.html';
        }, 500);
    } else {
        messageDiv.textContent = 'Hibás email vagy jelszó!';
        messageDiv.style.color = 'red';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const mainTitle = document.getElementById("main-title");
    const usernameLabel = document.getElementById("username-label");
    const passwordLabel = document.getElementById("password-label");
    const loginButton = document.getElementById("login-button");
    const registerButton = document.getElementById("register-button");
    let isHungarian = true;
    function switchLanguage() {
        if (isHungarian) {
            pageTitle.textContent = "Login";
            mainTitle.textContent = "Login";
            usernameLabel.textContent = "Email:";
            passwordLabel.textContent = "Password:";
            loginButton.textContent = "Login";
            registerButton.textContent = "Register";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Bejelentkezés";
            mainTitle.textContent = "Bejelentkezés";
            usernameLabel.textContent = "Email:";
            passwordLabel.textContent = "Jelszó:";
            loginButton.textContent = "Bejelentkezés";
            registerButton.textContent = "Regisztráció";
            switchButton.textContent = "Switch to English";
        }
        isHungarian = !isHungarian;
    }
    switchButton.addEventListener("click", switchLanguage);
});

document.getElementById('loginForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const loginEmail = document.getElementById('loginUsername').value;
    const loginPassword = document.getElementById('loginPassword').value;
    const messageDiv = document.getElementById('message');
    const storedEmail = localStorage.getItem('email');
    const storedPassword = localStorage.getItem('password');
    if (loginEmail === storedEmail && loginPassword === storedPassword) {
        localStorage.setItem('isLoggedIn', 'true');
        messageDiv.textContent = 'Sikeres bejelentkezés!';
        messageDiv.style.color = 'green';
        setTimeout(() => {
            window.location.href = '../profilom/profilom.html';
        }, 500);
    } else {
        messageDiv.textContent = 'Hibás email vagy jelszó!';
        messageDiv.style.color = 'red';
    }
});