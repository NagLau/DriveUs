// Load and display current data on page load
document.addEventListener("DOMContentLoaded", function () {
    // Load stored data
    let storedUsername = localStorage.getItem("username") || "Nincs adat";
    let storedPersonalId = localStorage.getItem("personalId") || "Nincs adat";
    let storedLicenseNumber = localStorage.getItem("licenseNumber") || "Nincs adat";
    let storedProfileImage = localStorage.getItem("profileImage") || "";

    // Display current data
    document.getElementById("current-username-display").textContent = storedUsername;
    document.getElementById("current-personal-id-display").textContent = storedPersonalId;
    document.getElementById("current-license-number-display").textContent = storedLicenseNumber;

    // Display current profile picture if exists
    if (storedProfileImage) {
        document.getElementById("current-profile-image").src = storedProfileImage;
        document.getElementById("current-profile-image").style.display = "block";
    }

    // Highlight user's current package
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
});

// Open modal for purchasing a package
function openModal(packageName, price) {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("package-name").innerText = packageName;
    document.getElementById("package-price").innerText = "Ár: " + price + " EUR";
}

// Close modal
function closeModal() {
    document.getElementById("modal").style.display = "none";
}

// Purchase package
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
        }
    }, 200);
}

// Close transaction modal
function closeTransactionModal() {
    document.getElementById("transaction-modal").style.display = "none";
}

// Card type detection
document.addEventListener("DOMContentLoaded", function () {
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
});

// Date validation for expiry date
document.addEventListener("DOMContentLoaded", function () {
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
});

// Profile picture preview and storage
document.getElementById("profile-picture").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const frame = document.querySelector(".profile-picture-frame");
            frame.innerHTML = `<img src="${e.target.result}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">`;
            // Store the image in localStorage
            localStorage.setItem("profileImage", e.target.result);
            // Update the current profile image display
            document.getElementById("current-profile-image").src = e.target.result;
            document.getElementById("current-profile-image").style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});

// Profile form submission with data storage
document.getElementById("profile-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let currentUsername = document.getElementById('current-username').value;
    let password = document.getElementById('password').value;

    if (!currentUsername || !password) {
        alert('A módosításhoz adja meg a jelenlegi felhasználónevét és jelszavát!');
        return;
    }

    // Store new data if provided
    let newUsername = document.getElementById("username").value;
    let newPersonalId = document.getElementById("personal-id").value;
    let newLicenseNumber = document.getElementById("license-number").value;

    if (newUsername) localStorage.setItem("username", newUsername);
    if (newPersonalId) localStorage.setItem("personalId", newPersonalId);
    if (newLicenseNumber) localStorage.setItem("licenseNumber", newLicenseNumber);

    // Update displayed data
    document.getElementById("current-username-display").textContent = newUsername || storedUsername;
    document.getElementById("current-personal-id-display").textContent = newPersonalId || storedPersonalId;
    document.getElementById("current-license-number-display").textContent = newLicenseNumber || storedLicenseNumber;

    alert('Adatok sikeresen frissítve!');
});