document.addEventListener("DOMContentLoaded", function () {
    // Load stored profile data
    let storedUsername = localStorage.getItem("username") || "Nincs adat";
    let storedPersonalId = localStorage.getItem("personalId") || "Nincs adat";
    let storedLicenseNumber = localStorage.getItem("licenseNumber") || "Nincs adat";
    let storedProfileImage = localStorage.getItem("profileImage") || "";

    // Display current profile data
    document.getElementById("current-username").textContent = storedUsername;
    document.getElementById("current-personal-id").textContent = storedPersonalId;
    document.getElementById("current-license-number").textContent = storedLicenseNumber;
    if (storedProfileImage) {
        document.getElementById("current-profile-image").src = storedProfileImage;
        document.getElementById("current-profile-image").style.display = "block";
    }

    // Handle form submission
    document.getElementById("profile-form").addEventListener("submit", function (event) {
        event.preventDefault();
        let newUsername = document.getElementById("username").value;
        let newPersonalId = document.getElementById("personal-id").value;
        let newLicenseNumber = document.getElementById("license-number").value;

        // Update localStorage and display
        if (newUsername) {
            localStorage.setItem("username", newUsername);
            document.getElementById("current-username").textContent = newUsername;
        }
        if (newPersonalId) {
            localStorage.setItem("personalId", newPersonalId);
            document.getElementById("current-personal-id").textContent = newPersonalId;
        }
        if (newLicenseNumber) {
            localStorage.setItem("licenseNumber", newLicenseNumber);
            document.getElementById("current-license-number").textContent = newLicenseNumber;
        }
        alert('Adatok sikeresen frissítve!');
    });

    // Handle profile picture upload
    const profilePictureInput = document.createElement("input");
    profilePictureInput.type = "file";
    profilePictureInput.id = "profile-picture";
    profilePictureInput.accept = "image/*";
    profilePictureInput.style.display = "none";
    document.querySelector(".profile-form").appendChild(profilePictureInput);

    const uploadButton = document.createElement("button");
    uploadButton.textContent = "Profilkép feltöltése";
    uploadButton.type = "button";
    uploadButton.classList.add("btn", "btn-secondary", "w-100", "mt-3");
    document.querySelector(".profile-form").appendChild(uploadButton);

    uploadButton.addEventListener("click", function () {
        profilePictureInput.click();
    });

    profilePictureInput.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageData = e.target.result;
                localStorage.setItem("profileImage", imageData);
                document.getElementById("current-profile-image").src = imageData;
                document.getElementById("current-profile-image").style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
});

// Membership purchase functions
function openModal(packageName, price) {
    // Modal logic remains unchanged
    console.log(`Opening modal for ${packageName} at ${price} EUR`);
}

function closeModal() {
    // Modal logic remains unchanged
    console.log("Closing modal");
}

function purchasePackage() {
    // Purchase logic remains unchanged
    console.log("Purchasing package");
}

function closeTransactionModal() {
    // Transaction modal logic remains unchanged
    console.log("Closing transaction modal");
}