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



let currentIndex = 0;
const images = document.querySelectorAll('.gallery img');
const totalImages = images.length;
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
function showImage(index) {
    images.forEach(img => img.classList.remove('show'));
    images[index].classList.add('show');
}
function startAutoSlide() {
    setInterval(() => {
        currentIndex = (currentIndex + 1) % totalImages; 
        showImage(currentIndex);
    }, 3000);
}
prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
    showImage(currentIndex);
});
nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
    showImage(currentIndex);
});
startAutoSlide();
showImage(currentIndex);
document.querySelector(".menu-icon").addEventListener("click", function() {
    document.querySelector("nav").classList.toggle("active");
});

