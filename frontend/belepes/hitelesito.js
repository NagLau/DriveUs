document.addEventListener("DOMContentLoaded", function () {
    const profileEmail = document.getElementById('profileEmail');
    profileEmail.textContent = localStorage.getItem('email') || 'Nincs megadva';
});

document.getElementById('profileForm')?.addEventListener('submit', function (event) {
    event.preventDefault();
    const newEmail = document.getElementById('newEmail').value;
    const newPassword = document.getElementById('newPassword').value;
    const messageDiv = document.getElementById('message');
    if (newEmail) localStorage.setItem('email', newEmail);
    if (newPassword) localStorage.setItem('password', newPassword);
    messageDiv.textContent = 'Adatok sikeresen frissítve!';
    messageDiv.style.color = 'green';
    document.getElementById('profileEmail').textContent = localStorage.getItem('email');
    setTimeout(() => {
        messageDiv.textContent = '';
    }, 2000);
});