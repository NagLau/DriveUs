<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="../css/admin_bejelentkezes.css">
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['admin_logged_in'])) {
        $_SESSION['admin_logged_in'] = false;
    }

    if ($_SESSION['admin_logged_in'] === true) {
        if (file_exists('admin_fooldal.php')) {
            header("Location: admin_fooldal.php");
            exit;
        } else {
            die("Hiba: Az admin_fooldal.php fájl nem található. Kérlek, ellenőrizd a fájl helyét.");
        }
    }

    include 'config.php';

    $check_user = $sql->query("SELECT * FROM admin WHERE felhasznaloNev = 'admindriveus2025'");
    if ($check_user->num_rows == 0) {
        $stmt = $sql->prepare("INSERT INTO admin (felhasznaloNev, jelszo) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $username = 'admindriveus2025';
        $password = 'driveus2025';
        if ($stmt->execute()) {
            $stmt->close();
        } else {
            die("Hiba a felhasználó létrehozása során: " . $stmt->error);
        }
    }

    $error_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $sql->prepare("SELECT jelszo FROM admin WHERE felhasznaloNev = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['jelszo'];

            if ($password === $stored_password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                if (file_exists('admin_fooldal.php')) {
                    header("Location: admin_fooldal.php");
                    exit;
                } else {
                    $error_message = "Hiba: Az admin_fooldal.php fájl nem található. Kérlek, ellenőrizd a fájl helyét.";
                }
            } else {
                $error_message = "Hibás felhasználónév vagy jelszó!";
            }
        } else {
            $error_message = "Hibás felhasználónév vagy jelszó!";
        }
        $stmt->close();
    }

    $sql->close();
    ?>

    <div class="login-container">
        <h2>Admin Bejelentkezés</h2>
        <form method="POST">
            <input type="text" id="username" name="username" placeholder="Felhasználónév" required>
            <input type="password" id="password" name="password" placeholder="Jelszó" required>
            <button type="submit" id="login-button">Belépés</button>
        </form>
        <button onclick="window.location.href='./bejelentkezes.php'" class="backButton">Vissza</button>
        <p class="error" id="error-message"><?php echo $error_message; ?></p>
    </div>

    <script src="../js/admin_bejelentkezes.js"></script>
</body>
</html>