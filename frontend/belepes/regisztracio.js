document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const email = document.getElementById('contactInput').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const messageDiv = document.getElementById('message');
    if (password !== confirmPassword) {
        messageDiv.textContent = 'A jelszavak nem egyeznek!';
        messageDiv.style.color = 'red';
    } else {
        const verificationCode = Math.floor(1000 + Math.random() * 9000);
        localStorage.setItem('verificationCode', verificationCode);
        localStorage.setItem('email', email);
        localStorage.setItem('password', password);
        alert(`Ellenőrző kód elküldve a(z) ${email} címre: ${verificationCode}`);
        showVerificationModal(email);
    }
});

function showVerificationModal(email) {
    const modal = document.createElement('div');
    modal.innerHTML = `
        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #f5e050; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.3); text-align: center; width: 90%; max-width: 400px;">
            <h2 style="color: #1a1a1a; font-size: 1.8rem; margin-bottom: 20px;">Ellenőrzés</h2>
            <p style="color: #1a1a1a; font-size: 1.1rem; margin-bottom: 15px;">Írd be az email címedre küldött kódot:</p>
            <input type="text" id="verificationInput" placeholder="Kód" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;">
            <button onclick="verifyCode('${email}')" style="background: #b8860b; color: #fff; border: none; padding: 10px 20px; font-size: 1.1rem; border-radius: 5px; cursor: pointer; width: 100%; margin-bottom: 10px;">Tovább a bejelentkezéshez</button>
            <button onclick="closeVerificationModal()" style="background: #b8860b; color: #fff; border: none; padding: 10px 20px; font-size: 1.1rem; border-radius: 5px; cursor: pointer; width: 100%;">Vissza</button>
            <div id="verificationMessage" style="margin-top: 10px;"></div>
        </div>
    `;
    document.body.appendChild(modal);
}

function closeVerificationModal() {
    const modal = document.querySelector('div[style*="position: fixed"]');
    if (modal) {
        document.body.removeChild(modal);
    }
}

function verifyCode(email) {
    const inputCode = document.getElementById('verificationInput').value;
    const storedCode = localStorage.getItem('verificationCode');
    const messageDiv = document.getElementById('verificationMessage');
    if (inputCode === storedCode) {
        messageDiv.textContent = 'Sikeres ellenőrzés! Átirányítás...';
        messageDiv.style.color = 'green';
        setTimeout(() => {
            document.body.removeChild(document.body.lastChild);
            window.location.href = 'bejelentkezes.html';
        }, 1000);
    } else {
        messageDiv.textContent = 'Hibás kód!';
        messageDiv.style.color = 'red';
    }
}

document.getElementById('registrationForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const email = document.getElementById('contactInput').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const messageDiv = document.getElementById('message');
    if (password !== confirmPassword) {
        messageDiv.textContent = 'A jelszavak nem egyeznek!';
        messageDiv.style.color = 'red';
    } else {
        const verificationCode = Math.floor(1000 + Math.random() * 9000);
        localStorage.setItem('verificationCode', verificationCode);
        localStorage.setItem('email', email);
        localStorage.setItem('password', password);
        fetch('http://localhost:3000/send-verification-email', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, code: verificationCode })
        }).then(response => {
            if (response.ok) {
                showVerificationModal(email);
            } else {
                alert('Hiba történt az email küldésekor!');
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.querySelector(".language-switcher");
    const pageTitle = document.getElementById("page-title");
    const usernameLabel = document.getElementById("username-label");
    const passwordLabel = document.getElementById("password-label");
    const confirmPasswordLabel = document.getElementById("confirm-password-label");
    const registerButton = document.getElementById("register-button");
    const loginButton = document.getElementById("login-button");
    let isHungarian = true;
    function switchLanguageR() {
        if (isHungarian) {
            pageTitle.textContent = "Registration";
            usernameLabel.textContent = "Username:";
            passwordLabel.textContent = "Password:";
            confirmPasswordLabel.textContent = "Confirm Password:";
            registerButton.textContent = "Register";
            loginButton.textContent = "Login";
            switchButton.textContent = "Váltás Magyarra";
        } else {
            pageTitle.textContent = "Regisztráció";
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