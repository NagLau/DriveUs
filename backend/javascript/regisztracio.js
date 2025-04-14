// Placeholder frissítése a kapcsolattartási mód alapján
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
}

// Kliensoldali validáció
function validateForm() {
    const username = document.getElementById('username').value.trim();
    const contactType = document.getElementById('contactType').value;
    const contact = document.getElementById('contactInput').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const messageDiv = document.getElementById('message');
    const passwordMessageDiv = document.getElementById('password-message');

    // Üresítsd ki a korábbi hibaüzeneteket
    messageDiv.innerHTML = '';
    passwordMessageDiv.innerHTML = '';

    // Felhasználónév ellenőrzése (legalább 3 karakter)
    if (username.length < 3) {
        messageDiv.innerHTML = "<p class='error'>A felhasználónévnek legalább 3 karakterből kell állnia!</p>";
        return false;
    }

    // E-mail vagy telefonszám ellenőrzése
    if (contactType === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(contact)) {
            messageDiv.innerHTML = "<p class='error'>Érvénytelen e-mail formátum!</p>";
            return false;
        }
    } else if (contactType === 'phone') {
        const phoneRegex = /^[0-9]{10,}$/;
        if (!phoneRegex.test(contact)) {
            messageDiv.innerHTML = "<p class='error'>Érvénytelen telefonszám formátum! Legalább 10 számjegy szükséges.</p>";
            return false;
        }
    }

    // Jelszó ellenőrzése: legalább 8 karakter, betű és szám
    const passwordRegexLetter = /[A-Za-z]/;
    const passwordRegexNumber = /[0-9]/;
    if (password.length < 8 || !passwordRegexLetter.test(password) || !passwordRegexNumber.test(password)) {
        passwordMessageDiv.innerHTML = "<p class='error'>A jelszónak legalább 8 karakterből kell állnia, és tartalmaznia kell betűt és számot!</p>";
        return false;
    }

    // Jelszó megerősítése ellenőrzése
    if (password !== confirmPassword) {
        passwordMessageDiv.innerHTML = "<p class='error'>A jelszó és a jelszó megerősítése nem egyezik!</p>";
        return false;
    }

    return true; // Ha minden validáció sikeres, az űrlap elküldhető
}

// Űrlap elküldésének kezelése
document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();

    // Validáció futtatása
    if (!validateForm()) {
        return; // Ha a validáció nem sikerül, ne folytassuk
    }

    // Ha a kliensoldali validáció sikeres, elküldjük az űrlapot a szerverre
    this.submit();
});

// Nyelvváltás kezelése és inicializálás
document.addEventListener("DOMContentLoaded", function () {
    // Biztosítjuk, hogy a username mező üres legyen az oldal betöltésekor
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.value = ''; // Mindig üresre állítjuk az oldal betöltésekor
    }

    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const mainTitle = document.getElementById("page-title"); // main-title helyett page-title, mert csak egy h1 van
    const usernameLabel = document.getElementById("username-label");
    const passwordLabel = document.getElementById("password-label");
    const confirmPasswordLabel = document.getElementById("confirm-password-label");
    const registerButton = document.getElementById("register-button");
    const loginButton = document.getElementById("login-button");
    const contactLabel = document.getElementById("contact-label");
    let isHungarian = true;

    function switchLanguageR() {
        if (isHungarian) {
            pageTitle.textContent = "Registration";
            mainTitle.textContent = "Registration";
            usernameLabel.textContent = "Username:";
            contactLabel.textContent = "Contact Method:";
            passwordLabel.textContent = "Password:";
            confirmPasswordLabel.textContent = "Confirm Password:";
            registerButton.textContent = "Register";
            loginButton.textContent = "Login";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Regisztráció";
            mainTitle.textContent = "Regisztráció";
            usernameLabel.textContent = "Felhasználónév:";
            contactLabel.textContent = "Kapcsolattartási mód:";
            passwordLabel.textContent = "Jelszó:";
            confirmPasswordLabel.textContent = "Jelszó megerősítése:";
            registerButton.textContent = "Regisztráció";
            loginButton.textContent = "Bejelentkezés";
            switchButton.textContent = "Switch to English";
        }
        isHungarian = !isHungarian;

        // Placeholder frissítése a nyelvváltás után
        updatePlaceholder();
    }

    if (switchButton) {
        switchButton.addEventListener("click", switchLanguageR);
    }
});