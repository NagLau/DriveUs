<?php
session_start();
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kijelentkezés - DriveUs</title>
    <link rel="stylesheet" href="../css/bejelentkezes.css">
    <meta http-equiv="refresh" content="2;url=./index.php">
</head>
<body>
    <div class="container">
        <h2>Sikeres kijelentkezés</h2>
        <p>Sikeresen kijelentkeztünk. Hamarosan átirányítunk a főoldalra...</p>
    </div>
</body>
</html>
