document.addEventListener("DOMContentLoaded", function () {
    const switchButton = document.getElementById("nyelves");
    const pageTitle = document.getElementById("page-title");
    const usernameLabel = document.getElementById("username-label");
    const passwordLabel = document.getElementById("password-label");
    const confirmPasswordLabel = document.getElementById("confirm-password-label");
    const registerButton = document.getElementById("register-button");
    const loginButton = document.getElementById("login-button");
    let isHungarian = true;
    function switchLanguage() {
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
    switchButton.addEventListener("click", switchLanguage);
});



const cards = document.querySelectorAll('.card');
const fullTextOverlay = document.createElement('div');
fullTextOverlay.classList.add('full-text-overlay');
document.body.appendChild(fullTextOverlay);
cards.forEach(card => {
    card.addEventListener('click', function() {
        const fullText = card.querySelector('.card-content').innerText;
        const fullTextContainer = document.createElement('div');
        fullTextContainer.classList.add('full-text-container');
        fullTextContainer.innerHTML = `
            <p>${fullText}</p>
        `;
        fullTextOverlay.innerHTML = ''; 
        fullTextOverlay.appendChild(fullTextContainer);
        fullTextOverlay.style.display = 'flex';
    });
});
fullTextOverlay.addEventListener('click', function() {
    closeOverlay();
});
function closeOverlay() {
    fullTextOverlay.style.display = 'none';
};

// ../js/script.js

let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
let autoSlideInterval;

// Képek közötti váltás
function moveSlide(direction) {
    // Előző kép elrejtése
    slides[currentSlide].classList.remove('active');

    // Új slide index kiszámítása
    currentSlide = (currentSlide + direction + slides.length) % slides.length;

    // Új kép megjelenítése
    slides[currentSlide].classList.add('active');
}

// Automatikus váltás indítása
function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        moveSlide(1); // Mindig a következő képre lép
    }, 4000); // 4000 ms = 4 másodperc
}

// Az első kép megjelenítése az oldal betöltésekor
if (slides.length > 0) {
    slides[0].classList.add('active');
    startAutoSlide(); // Automatikus váltás indítása
}

// Gombok eseménykezelése
document.getElementById('elozo').addEventListener('click', () => {
    // Automatikus váltás szüneteltetése
    clearInterval(autoSlideInterval);

    // Manuális váltás
    moveSlide(-1);

    // 5 másodperc szünet után újraindítjuk az automatikus váltást
    setTimeout(() => {
        startAutoSlide();
    }, 5000);
});

document.getElementById('kovetkezo').addEventListener('click', () => {
    // Automatikus váltás szüneteltetése
    clearInterval(autoSlideInterval);

    // Manuális váltás
    moveSlide(1);

    // 5 másodperc szünet után újraindítjuk az automatikus váltást
    setTimeout(() => {
        startAutoSlide();
    }, 5000);
});