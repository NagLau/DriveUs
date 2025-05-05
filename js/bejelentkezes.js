document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById('loginForm');
    const messageDiv = document.getElementById('message');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            const username = document.getElementById('loginUsername').value;
            const password = document.getElementById('loginPassword').value;

            if (!username || !password) {
                event.preventDefault();
                messageDiv.textContent = 'Felhasználónév és jelszó megadása kötelező!';
                setTimeout(() => messageDiv.textContent = '', 3000);
            }
        });
    }
});