<?php
include 'db_connect.php';
session_start();

// Ha a felhasználó már be van jelentkezve, irányítsd át az index.php oldalra
if (isset($_SESSION['felhAz'])) {
    header("Location: index.php");
    exit();
}

// Kijelentkezés kezelése
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: bejentkezes.php");
    exit();
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['loginUsername']);
    $password = $_POST['loginPassword'];

    // Felhasználó keresése az adatbázisban
    $stmt = $conn->prepare("SELECT * FROM felhasznaloifiokok WHERE felhaszNev = :felhaszNev");
    $stmt->execute(['felhaszNev' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ellenőrizzük, hogy a felhasználó létezik-e, és a jelszó helyes-e
    if ($user && password_verify($password, $user['jelszo'])) {
        // Sikeres bejelentkezés: Mentsük a session változókat
        $_SESSION['felhAz'] = $user['felhAz'];
        $_SESSION['username'] = $user['felhaszNev'];
        // Átirányítás az index.php oldalra (a driveus mappában található)
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Helytelen felhasználónév vagy jelszó!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">Bejelentkezés</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bejelentkezes.css">
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1 id="main-title">Bejelentkezés</h1>
        <div id="google_translate_element"></div>
        <?php if ($error_message): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="bejelentkezes.php">
            <label for="loginUsername" id="username-label">Felhasználónév:</label>
            <input type="text" id="loginUsername" name="loginUsername" placeholder="Felhasználónév" required>
            <label for="loginPassword" id="password-label">Jelszó:</label>
            <input type="password" id="loginPassword" name="loginPassword" placeholder="Jelszó" required>
            <button type="submit" id="login-button">Bejelentkezés</button>
        </form>
        <div id="message"></div>
        <button id="register-button" onclick="window.location.href='regisztracio.php'" class="btn btn-link">Regisztráció</button>
        <p><a id="adminos" href="admin/index.html" class="btn btn-warning">Belépés az Admin oldalra</a></p>
    </div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="bejelentkezes.js"></script>
</body>
</html>