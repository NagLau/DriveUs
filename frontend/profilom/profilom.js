document.addEventListener("DOMContentLoaded", function () {
    let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    let loginLogoutBtn = document.getElementById("login-logout-btn");
    let registerBtn = document.getElementById("register-btn");
    let currentUsernameInput = document.getElementById("current-username");
    let passwordInput = document.getElementById("password");
    let usernameInput = document.getElementById("username");
    let personalIdInput = document.getElementById("personal-id");
    let licenseNumberInput = document.getElementById("license-number");
    let profilePictureInput = document.getElementById("profile-picture");
    let updateProfileBtn = document.getElementById("egy");
    let uploadProfilePictureBtn = document.getElementById("ketto");

    loginLogoutBtn.textContent = isLoggedIn ? "Kijelentkezés" : "Bejelentkezés";

    if (!isLoggedIn) {
        document.getElementById("current-username-display").textContent = "";
        document.getElementById("current-personal-id-display").textContent = "";
        document.getElementById("current-license-number-display").textContent = "";
        document.getElementById("current-profile-image").src = "";
        document.getElementById("current-profile-image").style.display = "none";
        currentUsernameInput.value = "";
        passwordInput.value = "";
        usernameInput.value = "";
        personalIdInput.value = "";
        licenseNumberInput.value = "";
        currentUsernameInput.disabled = true;
        passwordInput.disabled = true;
        usernameInput.disabled = true;
        personalIdInput.disabled = true;
        licenseNumberInput.disabled = true;
        profilePictureInput.disabled = true;
        updateProfileBtn.disabled = false;
        uploadProfilePictureBtn.disabled = false;
    } else {
        document.getElementById("current-username-display").textContent = localStorage.getItem("username") || "";
        document.getElementById("current-personal-id-display").textContent = localStorage.getItem("personalId") || "";
        document.getElementById("current-license-number-display").textContent = localStorage.getItem("licenseNumber") || "";
        let storedProfileImage = localStorage.getItem("profileImage");
        if (storedProfileImage) {
            document.getElementById("current-profile-image").src = storedProfileImage;
            document.getElementById("current-profile-image").style.display = "block";
        }
        currentUsernameInput.value = localStorage.getItem("username") || "";
        passwordInput.value = "";
        usernameInput.value = "";
        personalIdInput.value = "";
        licenseNumberInput.value = "";
        currentUsernameInput.disabled = false;
        passwordInput.disabled = false;
        usernameInput.disabled = false;
        personalIdInput.disabled = false;
        licenseNumberInput.disabled = false;
        profilePictureInput.disabled = false;
        updateProfileBtn.disabled = false;
        uploadProfilePictureBtn.disabled = false;
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
            document.getElementById("current-username-display").textContent = "";
            document.getElementById("current-personal-id-display").textContent = "";
            document.getElementById("current-license-number-display").textContent = "";
            document.getElementById("current-profile-image").src = "";
            document.getElementById("current-profile-image").style.display = "none";
            currentUsernameInput.value = "";
            passwordInput.value = "";
            usernameInput.value = "";
            personalIdInput.value = "";
            licenseNumberInput.value = "";
            currentUsernameInput.disabled = true;
            passwordInput.disabled = true;
            usernameInput.disabled = true;
            personalIdInput.disabled = true;
            licenseNumberInput.disabled = true;
            profilePictureInput.disabled = true;
            updateProfileBtn.disabled = false;
            uploadProfilePictureBtn.disabled = false;
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
            localStorage.setItem("email", email);
            loginLogoutBtn.textContent = "Kijelentkezés";
            document.getElementById("current-username-display").textContent = localStorage.getItem("username");
            document.getElementById("current-personal-id-display").textContent = localStorage.getItem("personalId");
            document.getElementById("current-license-number-display").textContent = localStorage.getItem("licenseNumber");
            let storedProfileImage = localStorage.getItem("profileImage");
            if (storedProfileImage) {
                document.getElementById("current-profile-image").src = storedProfileImage;
                document.getElementById("current-profile-image").style.display = "block";
            }
            currentUsernameInput.value = localStorage.getItem("username") || "";
            passwordInput.value = "";
            usernameInput.value = "";
            personalIdInput.value = "";
            licenseNumberInput.value = "";
            currentUsernameInput.disabled = false;
            passwordInput.disabled = false;
            usernameInput.disabled = false;
            personalIdInput.disabled = false;
            licenseNumberInput.disabled = false;
            profilePictureInput.disabled = false;
            updateProfileBtn.disabled = false;
            uploadProfilePictureBtn.disabled = false;
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
        currentUsernameInput.value = username;
        passwordInput.value = "";
        usernameInput.value = "";
        personalIdInput.value = "";
        licenseNumberInput.value = "";
        currentUsernameInput.disabled = false;
        passwordInput.disabled = false;
        usernameInput.disabled = false;
        personalIdInput.disabled = false;
        licenseNumberInput.disabled = false;
        profilePictureInput.disabled = false;
        updateProfileBtn.disabled = false;
        uploadProfilePictureBtn.disabled = false;
        closeRegisterModal();
        alert("Sikeres regisztráció és bejelentkezés!");
        isLoggedIn = true;
    });

    document.getElementById("ketto").addEventListener("click", function(event) {
        let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
        if (!isLoggedIn) {
            alert("Jelentkezz be vagy regisztrálj az adatok frissítéséhez!");
            return;
        }
        document.getElementById("profile-picture").click();
    });

    let adminAttempts = 3;
    let adminLockout = localStorage.getItem("adminLockout");
    if (adminLockout) {
        let lockoutTime = new Date(adminLockout);
        let now = new Date();
        if (now < lockoutTime) {
            document.getElementById("admin-username").disabled = true;
            document.getElementById("admin-password").disabled = true;
            document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = true;
            document.getElementById("admin-attempts").textContent = `Próbáld újra ${Math.ceil((lockoutTime - now) / 60000)} perc múlva!`;
            setTimeout(() => {
                localStorage.removeItem("adminLockout");
                document.getElementById("admin-username").disabled = false;
                document.getElementById("admin-password").disabled = false;
                document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = false;
                document.getElementById("admin-attempts").textContent = "";
                adminAttempts = 3;
            }, lockoutTime - now);
        } else {
            localStorage.removeItem("adminLockout");
        }
    }

    document.getElementById("admin-login-form").addEventListener("submit", function(event) {
        event.preventDefault();
        const username = document.getElementById("admin-username").value;
        const password = document.getElementById("admin-password").value;
        if (username === "DriveUsAdmin" && password === "ADMIN2025") {
            localStorage.setItem("isAdminLoggedIn", "true");
            closeAdminLoginModal();
            window.location.href = "../admin/admin_fooldal.html";
        } else {
            adminAttempts--;
            if (adminAttempts > 0) {
                document.getElementById("admin-attempts").textContent = `Hibás adatok! ${adminAttempts} próbálkozásod maradt.`;
            } else {
                document.getElementById("admin-attempts").textContent = "Próbáld újra 30 perc múlva!";
                document.getElementById("admin-username").disabled = true;
                document.getElementById("admin-password").disabled = true;
                document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = true;
                let lockoutTime = new Date();
                lockoutTime.setMinutes(lockoutTime.getMinutes() + 30);
                localStorage.setItem("adminLockout", lockoutTime);
                setTimeout(() => {
                    localStorage.removeItem("adminLockout");
                    document.getElementById("admin-username").disabled = false;
                    document.getElementById("admin-password").disabled = false;
                    document.getElementById("admin-login-form").querySelector("button[type='submit']").disabled = false;
                    document.getElementById("admin-attempts").textContent = "";
                    adminAttempts = 3;
                }, 30 * 60 * 1000);
            }
        }
    });
});

function openModal(packageName, price) {
    let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    document.getElementById("modal").style.display = "flex";
    document.getElementById("package-name").innerText = packageName;
    document.getElementById("package-price").innerText = "Ár: " + price + " EUR";

    const cardNumberInput = document.getElementById("card-number");
    const expiryDateInput = document.getElementById("expiry-date");
    const cvvInput = document.getElementById("cvv");
    const storeCardCheckbox = document.getElementById("store-card");
    const purchaseButton = document.querySelector("#modal .modal-content button[onclick='purchasePackage()']");

    if (!isLoggedIn) {
        cardNumberInput.disabled = true;
        expiryDateInput.disabled = true;
        cvvInput.disabled = true;
        storeCardCheckbox.disabled = true;
        purchaseButton.disabled = true;
    } else {
        cardNumberInput.disabled = false;
        expiryDateInput.disabled = false;
        cvvInput.disabled = false;
        storeCardCheckbox.disabled = false;
        purchaseButton.disabled = false;
    }
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

function purchasePackage() {
    let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    if (!isLoggedIn) {
        alert("Jelentkezz be vagy regisztrálj a tagság vásárlásához!");
        return;
    }

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

function openAdminLoginModal() {
    document.getElementById("login-modal").style.display = "none";
    document.getElementById("admin-login-modal").style.display = "flex";
}

function closeAdminLoginModal() {
    document.getElementById("admin-login-modal").style.display = "none";
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
    let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    if (!isLoggedIn) {
        alert("Jelentkezz be vagy regisztrálj az adatok frissítéséhez!");
        return;
    }
    let currentUsername = document.getElementById('current-username').value;
    let password = document.getElementById('password').value;
    let storedPassword = localStorage.getItem("password") || "";

    if (!currentUsername || !password) {
        alert('A módosításhoz adja meg a jelenlegi felhasználónevét és jelszavát!');
        return;
    }

    if (password !== storedPassword) {
        alert('Hibás jelszó, az adatok módosítása nem lehetséges!');
        return;
    }

    let storedUsername = localStorage.getItem("username") || "";
    let storedPersonalId = localStorage.getItem("personalId") || "";
    let storedLicenseNumber = localStorage.getItem("licenseNumber") || "";

    let newUsername = document.getElementById("username").value;
    let newPersonalId = document.getElementById("personal-id").value;
    let newLicenseNumber = document.getElementById("license-number").value;

    if (newUsername) localStorage.setItem("username", newUsername);
    if (newPersonalId) localStorage.setItem("personalId", newPersonalId);
    if (newLicenseNumber) localStorage.setItem("licenseNumber", newLicenseNumber);

    document.getElementById("current-username-display").textContent = newUsername || storedUsername;
    document.getElementById("current-personal-id-display").textContent = newPersonalId || storedPersonalId;
    document.getElementById("current-license-number-display").textContent = newLicenseNumber || storedLicenseNumber;
    document.getElementById("current-username").value = newUsername || storedUsername;

    alert('Adatok sikeresen frissítve!');
});