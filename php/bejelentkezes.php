<?php
session_start();
require_once './config.php';

$hibak = [];
$felhaszNev = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $felhaszNev = trim(filter_input(INPUT_POST, 'felhaszNev', FILTER_SANITIZE_STRING));
    $jelszo = trim($_POST['jelszo'] ?? '');

    if (empty($felhaszNev) || empty($jelszo)) {
        $hibak[] = 'Felhasználónév és jelszó megadása kötelező.';
    } else {
        $felhaszNev = $sql->real_escape_string($felhaszNev);
        $lekerdezes = "SELECT felhAz, felhaszNev, teljesNev, tagsag, jelszo FROM felhasznalofiokok WHERE felhaszNev = '$felhaszNev'";
        $eredmeny = $sql->query($lekerdezes);

        if ($eredmeny && $eredmeny->num_rows > 0) {
            $felhasznalo = $eredmeny->fetch_assoc();
            if (password_verify($jelszo, $felhasznalo['jelszo'])) {
                $_SESSION['felhAz'] = $felhasznalo['felhAz'];
                $_SESSION['felhaszNev'] = $felhasznalo['felhaszNev'];
                $_SESSION['teljesNev'] = $felhasznalo['teljesNev'];
                $_SESSION['tagsag'] = $felhasznalo['tagsag'];
                header("Location: ./profilom.php");
                exit;
            } else {
                $hibak[] = 'Hibás felhasználónév vagy jelszó.';
            }
        } else {
            $hibak[] = 'Hibás felhasználónév vagy jelszó.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés - DriveUs</title>
    <link rel="stylesheet" href="../css/bejelentkezes.css">
</head>
<body>
    <div class="container">
        <h1>Bejelentkezés</h1>
        <?php if (!empty($hibak)): ?>
            <div class="errors">
                <?php echo implode('<br>', array_map('htmlspecialchars', $hibak)); ?>
            </div>
        <?php endif; ?>
        <div id="message"></div>
        <form method="POST" action="bejelentkezes.php" id="loginForm">
            <label for="felhaszNev">Felhasználónév:</label>
            <input type="text" id="loginUsername" name="felhaszNev" value="<?php echo htmlspecialchars($felhaszNev); ?>" required>
            
            <label for="jelszo">Jelszó:</label>
            <input type="password" id="loginPassword" name="jelszo" required>
            
            <button type="submit" id="login-button">Bejelentkezés</button>
        </form>
        <p>Nincs fiókod? <a href="./regisztracio.php">Regisztráció</a></p>
        <a href="./admin.php" id="adminos">Adminisztrátor bejelentkezés</a>
    </div>
    <script src="../js/bejelentkezes.js"></script>
</body>
</html>