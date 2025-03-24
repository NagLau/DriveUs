document.addEventListener("DOMContentLoaded", function () {
    const profileEmail = document.getElementById('profileEmail');
    const personalId = document.getElementById('personalId');
    const licenseNumber = document.getElementById('licenseNumber');
    profileEmail.textContent = localStorage.getItem('email') || 'Nincs megadva';
    personalId.textContent = localStorage.getItem('personalId') || 'Nincs megadva';
    licenseNumber.textContent = localStorage.getItem('licenseNumber') || 'Nincs megadva';
});

document.getElementById('profileForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const newEmail = document.getElementById('newEmail').value;
    const newPassword = document.getElementById('newPassword').value;
    const newPersonalId = document.getElementById('newPersonalId').value;
    const newLicenseNumber = document.getElementById('newLicenseNumber').value;
    const messageDiv = document.getElementById('message');
    if (newEmail) localStorage.setItem('email', newEmail);
    if (newPassword) localStorage.setItem('password', newPassword);
    if (newPersonalId) localStorage.setItem('personalId', newPersonalId);
    if (newLicenseNumber) localStorage.setItem('licenseNumber', newLicenseNumber);
    messageDiv.textContent = 'Adatok sikeresen frissítve!';
    messageDiv.style.color = 'green';
    document.getElementById('profileEmail').textContent = localStorage.getItem('email');
    document.getElementById('personalId').textContent = localStorage.getItem('personalId');
    document.getElementById('licenseNumber').textContent = localStorage.getItem('licenseNumber');
    setTimeout(() => {
        messageDiv.textContent = '';
    }, 2000);
});