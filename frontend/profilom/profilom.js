document.addEventListener("DOMContentLoaded", function () {
    let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    let loginLogoutBtn = document.getElementById("login-logout-btn");
    let registerBtn = document.getElementById("register-btn");
    loginLogoutBtn.textContent = isLoggedIn ? "Kijelentkezés" : "Bejelentkezés";

    if (!isLoggedIn) {
        document.getElementById("current-username-display").textContent = "Nincs adat";
        document.getElementById("current-personal-id-display").textContent = "Nincs adat";
        document.getElementById("current-license-number-display").textContent = "Nincs adat";
        document.getElementById("current-profile-image").src = "";
        document.getElementById("current-profile-image").style.display = "none";
    } else {
        document.getElementById("current-username-display").textContent = localStorage.getItem("username") || "Nincs adat";
        document.getElementById("current-personal-id-display").textContent = localStorage.getItem("personalId") || "Nincs adat";
        document.getElementById("current-license-number-display").textContent = localStorage.getItem("licenseNumber") || "Nincs adat";
        let storedProfileImage = localStorage.getItem("profileImage");
        if (storedProfileImage) {
            document.getElementById("current-profile-image").src = storedProfileImage;
            document.getElementById("current-profile-image").style.display = "block";
        }
    }

    let userPackage = localStorage.getItem("userPackage") || "Új tag";
    let headers = document.querySelectorAll("th");
    headers.forEach((header, index) => {
        if (header.textContent.trim() === userPackage) {
            document.querySelectorAll("tr").forEach(row => {
                let cell = row.children[index];
                if (cell) cell.classList.add("highlight");
            });
        }
    });

    const cardNumberInput = document.getElementById("card-number");
    const cardIcon = document.getElementById("card-icon");
    const cardTypes = {
        "Visa": { regex: /^4/, icon: "./visa_PNG4.png" },
        "MasterCard": { regex: /^5[1-5]/, icon: "./mastercard.png" },
        "American Express": { regex: /^3[47]/, icon: "./amex.png" },
        "Apple Pay": { regex: /Apple Pay/i, icon: "./Apple-Pay-Logo.png" },
        "Google Pay": { regex: /Google Pay/i, icon: "./googlepay.png" },
        "Maestro": { regex: /^(?:50|5[6-9]|6)/, icon: "./maestro.png" },
        "Revolut": { regex: /^(4169|4265|4354|4596|5111|5123|5300|5493|6761|6762|6763)/, icon: "./revolut.png" },
        "Samsung pay": { regex: /Samsung pay/i, icon: "./samsung-pay-logo.png" }
    };

    cardNumberInput.addEventListener("input", function () {
        const cardNumber = cardNumberInput.value.replace(/\D/g, "");
        let detectedCard = null;
        for (const [card, data] of Object.entries(cardTypes)) {
            if (data.regex.test(cardNumber)) {
                detectedCard = data.icon;
                break;
            }
        }
        if (detectedCard) {
            cardIcon.src = `ikonok/${detectedCard.split('/').pop()}`;
            cardIcon.style.display = "inline-block";
        } else {
            cardIcon.style.display = "none";
        }
    });

    const today = new Date();
    const day = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();
    const formattedDate = `${year}-${month}-${day}`;
    const expiryDateInput = document.getElementById("expiry-date");
    const dateError = document.getElementById("date-error");
    expiryDateInput.setAttribute("min", formattedDate);

    expiryDateInput.addEventListener("change", function () {
        const selectedDate = new Date(expiryDateInput.value);
        if (selectedDate < today) {
            dateError.style.display = "inline";
            expiryDateInput.setCustomValidity("A dátumnak nem lehet régebbinek lennie a mai napnál.");
        } else {
            dateError.style.display = "none";
            expiryDateInput.setCustomValidity("");
        }
    });

    loginLogoutBtn.addEventListener("click", function () {
        if (isLoggedIn) {
            localStorage.setItem("isLoggedIn", "false");
            loginLogoutBtn.textContent = "Bejelentkezés";
            document.getElementById("current-username-display").textContent = "Nincs adat";
            document.getElementById("current-personal-id-display").textContent = "Nincs adat";
            document.getElementById("current-license-number-display").textContent = "Nincs adat";
            document.getElementById("current-profile-image").src = "";
            document.getElementById("current-profile-image").style.display = "none";
            alert("Sikeresen kijelentkeztél!");
            isLoggedIn = false;
        } else {
            document.getElementById("login-modal").style.display = "flex";
        }
    });

    registerBtn.addEventListener("click", function () {
        if (!isLoggedIn) {
            document.getElementById("register-modal").style.display = "flex";
        }
    });

    document.getElementById("login-form").addEventListener("submit", function (event) {
        event.preventDefault();
        const email = document.getElementById("login-email").value;
        const password = document.getElementById("login-password").value;
        const storedEmail = localStorage.getItem("email");
        const storedPassword = localStorage.getItem("password");

        if (email === storedEmail && password === storedPassword) {
            localStorage.setItem("isLoggedIn", "true");
            loginLogoutBtn.textContent = "Kijelentkezés";
            document.getElementById("current-username-display").textContent = localStorage.getItem("username");
            document.getElementById("current-personal-id-display").textContent = localStorage.getItem("personalId");
            document.getElementById("current-license-number-display").textContent = localStorage.getItem("licenseNumber");
            let storedProfileImage = localStorage.getItem("profileImage");
            if (storedProfileImage) {
                document.getElementById("current-profile-image").src = storedProfileImage;
                document.getElementById("current-profile-image").style.display = "block";
            }
            closeLoginModal();
            alert("Sikeresen bejelentkeztél!");
            isLoggedIn = true;
        } else {
            alert("Hibás email vagy jelszó!");
        }
    });

    document.getElementById("register-form").addEventListener("submit", function (event) {
        event.preventDefault();
        const email = document.getElementById("register-email").value;
        const personalId = document.getElementById("register-personal-id").value;
        const licenseNumber = document.getElementById("register-license-number").value;
        const password = document.getElementById("register-password").value;
        const confirmPassword = document.getElementById("register-confirm-password").value;
        const username = email.split('@')[0];

        if (password !== confirmPassword) {
            alert("A jelszavak nem egyeznek!");
            return;
        }

        localStorage.setItem("email", email);
        localStorage.setItem("username", username);
        localStorage.setItem("personalId", personalId);
        localStorage.setItem("licenseNumber", licenseNumber);
        localStorage.setItem("password", password);
        localStorage.setItem("isLoggedIn", "true");

        document.getElementById("current-username-display").textContent = username;
        document.getElementById("current-personal-id-display").textContent = personalId;
        document.getElementById("current-license-number-display").textContent = licenseNumber;
        loginLogoutBtn.textContent = "Kijelentkezés";
        closeRegisterModal();
        alert("Sikeres regisztráció és bejelentkezés!");
        isLoggedIn = true;
    });
});

function openModal(packageName, price) {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("package-name").innerText = packageName;
    document.getElementById("package-price").innerText = "Ár: " + price + " EUR";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function purchasePackage() {
    let packageName = document.getElementById("package-name").innerText;
    let storeCard = document.getElementById("store-card").checked;
    let userBalance = 50;
    let packagePrice = parseFloat(document.getElementById("package-price").innerText.replace("Ár: ", "").replace(" EUR", ""));
    let transactionStatus = userBalance >= packagePrice ? "Sikeres vásárlás!" : "Tranzakció elutasítva";
    let cardStorageStatus = storeCard ? "A kártya adatait eltároltuk!" : "A kártya adatait nem tároltuk el";

    closeModal();
    setTimeout(() => {
        document.getElementById("transaction-status").innerText = transactionStatus;
        document.getElementById("card-storage-status").innerText = cardStorageStatus;
        document.getElementById("transaction-modal").style.display = "flex";
        if (userBalance >= packagePrice) {
            localStorage.setItem("userPackage", packageName);
            let headers = document.querySelectorAll("th");
            headers.forEach((header, index) => {
                document.querySelectorAll("tr").forEach(row => {
                    let cell = row.children[index];
                    if (cell) cell.classList.remove("highlight");
                });
                if (header.textContent.trim() === packageName) {
                    document.querySelectorAll("tr").forEach(row => {
                        let cell = row.children[index];
                        if (cell) cell.classList.add("highlight");
                    });
                }
            });
        }
    }, 200);
}

function closeTransactionModal() {
    document.getElementById("transaction-modal").style.display = "none";
}

function closeLoginModal() {
    document.getElementById("login-modal").style.display = "none";
}

function closeRegisterModal() {
    document.getElementById("register-modal").style.display = "none";
}

document.getElementById("profile-picture").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            localStorage.setItem("profileImage", e.target.result);
            document.getElementById("current-profile-image").src = e.target.result;
            document.getElementById("current-profile-image").style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById("profile-form").addEventListener("submit", function(event) {
    event.preventDefault();
    let currentUsername = document.getElementById('current-username').value;
    let password = document.getElementById('password').value;

    if (!currentUsername || !password) {
        alert('A módosításhoz adja meg a jelenlegi felhasználónevét és jelszavát!');
        return;
    }

    let storedUsername = localStorage.getItem("username") || "Nincs adat";
    let storedPersonalId = localStorage.getItem("personalId") || "Nincs adat";
    let storedLicenseNumber = localStorage.getItem("licenseNumber") || "Nincs adat";

    let newUsername = document.getElementById("username").value;
    let newPersonalId = document.getElementById("personal-id").value;
    let newLicenseNumber = document.getElementById("license-number").value;

    if (newUsername) localStorage.setItem("username", newUsername);
    if (newPersonalId) localStorage.setItem("personalId", newPersonalId);
    if (newLicenseNumber) localStorage.setItem("licenseNumber", newLicenseNumber);

    document.getElementById("current-username-display").textContent = newUsername || storedUsername;
    document.getElementById("current-personal-id-display").textContent = newPersonalId || storedPersonalId;
    document.getElementById("current-license-number-display").textContent = newLicenseNumber || storedLicenseNumber;

    alert('Adatok sikeresen frissítve!');
});