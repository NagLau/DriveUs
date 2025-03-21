document.addEventListener("DOMContentLoaded", function () {
    let loginButton = document.getElementById("login-button");
    if (loginButton) {
        loginButton.addEventListener("click", login);
    } else {
        console.error("HIBA: Nem található a login gomb!");
    }
});
function login() {
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();
    let errorMessage = document.getElementById("error-message");
    if (!username || !password) {
        errorMessage.textContent = "Minden mezőt ki kell tölteni!";
        errorMessage.style.color = "red";
        return;
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "admin_login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let responseText = xhr.responseText.trim(); 
                console.log(responseText);  
                if (responseText === "Sikeres bejelentkezés!") {
                    window.location.href = "admin_fooldal.html"; 
                } else {
                    errorMessage.textContent = responseText; 
                    errorMessage.style.color = "red";
                }
            } else {
                console.error('HTTP Error: ' + xhr.status); 
                errorMessage.textContent = "Hálózati hiba!";
                errorMessage.style.color = "red";
            }
        }
    };
    xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
}
