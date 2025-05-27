<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kijelentkezés</title>
</head>
<body>
<?php
    session_start();

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    session_start();
    $_SESSION['admin_logged_in'] = false;

    header("Location: admin_bejelentkezes.php");
    exit;
    ?>
</body>
</html>