document.addEventListener("DOMContentLoaded", () => {
    // Profil szerkesztés űrlap kezelése
    const editProfileBtn = document.getElementById("editProfileBtn");
    const profileForm = document.getElementById("profile-form");
  
    if (profileForm) {
      profileForm.style.display = "none";
    }
  
    if (editProfileBtn) {
      editProfileBtn.addEventListener("click", () => {
        profileForm.style.display = profileForm.style.display === "none" ? "block" : "none";
      });
    }
  
    // Tagság táblázat kiemelése
    const userPackage = (document.getElementById("current-membership-display")?.textContent.toLowerCase() || "új tag").trim();
    const headers = document.querySelectorAll(".table th");
    headers.forEach((header, index) => {
      if (header.textContent.trim().toLowerCase() === userPackage) {
        document.querySelectorAll(".table tbody tr").forEach((row) => {
          const cell = row.children[index];
          if (cell) {
            cell.classList.add("highlight");
          }
        });
      }
    });
  
    // Kártyatípus felismerés
    const cardNumberInput = document.getElementById("card-number");
    const cardIcon = document.getElementById("card-icon");
    const cardTypes = {
      Visa: { regex: /^4/, icon: "visa_PNG4.png" },
      MasterCard: { regex: /^5[1-5]/, icon: "mastercard.png" },
      "American Express": { regex: /^3[47]/, icon: "amex.png" },
    };
  
    if (cardNumberInput && cardIcon) {
      cardNumberInput.addEventListener("input", () => {
        const cardNumber = cardNumberInput.value.replace(/\s/g, "");
        let detectedCard = null;
  
        Object.entries(cardTypes).forEach(([cardType, { regex, icon }]) => {
          if (regex.test(cardNumber)) {
            detectedCard = icon;
          }
        });
  
        if (detectedCard) {
          cardIcon.src = `../ikonok/${detectedCard}`;
          cardIcon.style.display = "inline-block";
        } else {
          cardIcon.style.display = "none";
        }
      });
    }
  
    // Lejárati dátum ellenőrzés
    const today = new Date();
    const day = String(today.getDate()).padStart(2, "0");
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const year = today.getFullYear();
    const formattedDate = `${year}-${month}-${day}`;
    const expiryDateInput = document.getElementById("expiry-date");
    const dateError = document.getElementById("date-error");
  
    if (expiryDateInput && dateError) {
      expiryDateInput.setAttribute("min", formattedDate);
  
      expiryDateInput.addEventListener("change", () => {
        const selectedDate = new Date(expiryDateInput.value);
        if (selectedDate < today) {
          dateError.style.display = "inline";
          expiryDateInput.setCustomValidity("A dátumnak nem lehet régebbinek lennie a mai napnál.");
        } else {
          dateError.style.display = "none";
          expiryDateInput.setCustomValidity("");
        }
      });
    }
  
    // Profilkép feltöltés gomb
    const uploadProfilePictureBtn = document.getElementById("ketto");
    if (uploadProfilePictureBtn) {
      uploadProfilePictureBtn.addEventListener("click", () => {
        document.getElementById("profile-picture")?.click();
      });
    }
  });
  
  // Modális ablak kezelése
  function openModal(packageName, price) {
    const modal = document.getElementById("modal");
    const packageNameElement = document.getElementById("package-name");
    const packagePriceElement = document.getElementById("package-price");
    const packageNameInput = document.getElementById("package-name-input");
  
    if (modal && packageNameElement && packagePriceElement && packageNameInput) {
      modal.style.display = "flex";
      packageNameElement.innerText = packageName;
      packagePriceElement.innerText = `Ár: ${price} EUR`;
      packageNameInput.value = packageName;
    }
  }
  
  function closeModal() {
    const modal = document.getElementById("modal");
    if (modal) {
      modal.style.display = "none";
    }
  }