<?php
include 'db_connect.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['felhAz'])) {
    header("Location: bejentkezes.php");
    exit();
}

$felhAz = $_SESSION['felhAz'];
$stmt = $conn->prepare("SELECT * FROM felhasznalofiokok WHERE felhAz = :felhAz");
$stmt->execute(['felhAz' => $felhAz]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $personal_id = $_POST['personal-id'];
    $license_number = $_POST['license-number'];
    $password = $_POST['password'];

    if ($password === $user['jelszo']) { // Note: In this schema, passwords are not hashed. In a real application, you should hash passwords!
        $stmt = $conn->prepare("UPDATE felhasznalofiokok SET felhaszNev = :felhaszNev, szemIgSzam = :szemIgSzam, jogositvanySzam = :jogositvanySzam WHERE felhAz = :felhAz");
        $stmt->execute([
            'felhaszNev' => $new_username,
            'szemIgSzam' => $personal_id,
            'jogositvanySzam' => $license_number,
            'felhAz' => $felhAz
        ]);

        $_SESSION['username'] = $new_username;
        echo "<p>Adatok frissítve!</p>";
    } else {
        echo "<p>Helytelen jelszó!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profilom.css">
    <title>DriveUs/PROFILOM</title>
</head>
<body>
    <header>
        <h1 id="focim">DriveUs</h1>
        <nav>
            <a href="hirlap.php">HÍRLAP</a>
            <a href="autok.php">AUTÓK</a>
            <a href="berleseim.php">BÉRLÉSEIM</a>
            <a href="index.php">FŐOLDAL</a>
        </nav>
        <div id="google_translate_element"></div>
    </header>
    <div class="profile-update-container">
        <h2>Profil adatok frissítése</h2>
        <form id="profile-form" method="POST" action="profilom.php">
            <div class="profile-section">
                <div class="left-align-fields">
                    <label for="current-username">Jelenlegi felhasználónév:</label>
                    <input type="text" id="current-username" value="<?php echo htmlspecialchars($user['nev']); ?>" readonly>
                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="left-align-fields">
                    <label for="username">Új felhasználónév:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['nev']); ?>">
                    <label for="personal-id">Személyi szám:</label>
                    <input type="text" id="personal-id" name="personal-id" value="<?php echo htmlspecialchars($berlo['szemelyiigszam'] ?? ''); ?>">
                    <label for="license-number">Jogosítványszám:</label>
                    <input type="text" id="license-number" name="license-number" value="<?php echo htmlspecialchars($berlo['jogostivanyszam'] ?? ''); ?>">
                </div>
            </div>
            <button type="submit">Adatok frissítése</button>
        </form>
    </div>
    <footer>
        <img src="./ceg_logo.png" alt="DriveUs Logo" id="footer-img">
        <p id="footer_p">Válogass prémium autóink közül, és indulj útnak stílusosan!</p>
    </footer>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>