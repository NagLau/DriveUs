<?php
include 'db_connect.php';
session_start();

$error_message = '';
$password_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $contactType = $_POST['contactType'];
    $contact = trim($_POST['contactInput']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Jelszó validáció
    if ($password !== $confirmPassword) {
        $password_error = "A jelszó és a jelszó megerősítése nem egyezik!";
    }

    if (empty($password_error) && (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password))) {
        $password_error = "A jelszónak legalább 8 karakterből kell állnia, és tartalmaznia kell betűt és számot!";
    }

    // Kapcsolattartási mód validáció
    if (empty($password_error) && $contactType == 'email' && !filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Érvénytelen e-mail formátum!";
    }
    if (empty($password_error) && empty($error_message) && $contactType == 'phone' && !preg_match('/^[0-9]{10,}$/', $contact)) {
        $error_message = "Érvénytelen telefonszám formátum! Legalább 10 számjegy szükséges.";
    }

    if (empty($error_message) && empty($password_error)) {
        $contactField = ($contactType == 'phone') ? 'telSzam' : 'eMail';
        $stmt_check = $conn->prepare("SELECT * FROM felhasznalofiokok WHERE $contactField = :contact");
        $stmt_check->execute(['contact' => $contact]);

        if ($stmt_check->rowCount() > 0) {
            $error_message = "A $contactType már regisztrálva van!";
        } else {
            $stmt_check_username = $conn->prepare("SELECT * FROM felhasznalofiokok WHERE felhaszNev = :felhaszNev");
            $stmt_check_username->execute(['felhaszNev' => $username]);
            if ($stmt_check_username->rowCount() > 0) {
                $error_message = "A felhasználónév már foglalt!";
            } else {
                try {
                    // Jelszó titkosítása (a séma szerint most nincs titkosítva, de itt megjegyzésként jelzem, hogy kellene)
                    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare("INSERT INTO felhasznalofiokok (felhaszNev, jelszo, teljesNev, szemIgSzam, jogositvanySzam, eMail, eloHivSzam, telSzam, tagsag) VALUES (:felhaszNev, :jelszo, :teljesNev, :szemIgSzam, :jogositvanySzam, :eMail, :eloHivSzam, :telSzam, 'új')");
                    $stmt->execute([
                        'felhaszNev' => $username,
                        'jelszo' => $password, // A séma szerint nincs titkosítva, de élesben titkosítani kellene
                        'teljesNev' => $username, // Helykitöltő, később frissíthető a profilban
                        'szemIgSzam' => substr(uniqid(), 0, 8), // Helykitöltő
                        'jogositvanySzam' => substr(uniqid(), 0, 8), // Helykitöltő
                        'eMail' => ($contactType == 'email') ? $contact : NULL,
                        'eloHivSzam' => ($contactType == 'phone') ? 36 : 0, // Ha nem telefonszám, akkor 0 (előző hiba javítása)
                        'telSzam' => ($contactType == 'phone') ? $contact : 0 // Ha nem telefonszám, akkor 0 (jelenlegi hiba javítása)
                    ]);

                    header("Location: bejelentkezes.php");
                    exit();
                } catch (PDOException $e) {
                    $error_message = "Hiba történt: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bejelentkezes.css">
</head>
<body>
    <div class="container">
        <h1>Regisztráció</h1>
        <div id="google_translate_element"></div>
        <form id="registrationForm" method="POST" action="regisztracio.php" autocomplete="off">
            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" placeholder="Felhasználónév" required autocomplete="off">
            <label for="contactType">Kapcsolattartási mód:</label>
            <select id="contactType" name="contactType" onchange="updatePlaceholder()">
                <option value="email">E-mail</option>
                <option value="phone">Telefonszám</option>
            </select>
            <input type="text" id="contactInput" name="contactInput" placeholder="E-mail vagy telefonszám" required>
            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" placeholder="Jelszó" required>
            <label for="confirmPassword">Jelszó megerősítése:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Jelszó megerősítése" required>
            <div id="password-message">
                <?php if ($password_error): ?>
                    <p class="error"><?php echo htmlspecialchars($password_error); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Regisztráció</button>
        </form>
        <div id="message">
            <?php if ($error_message): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </div>
        <button onclick="window.location.href='bejentkezes.php'" class="btn btn-link">Bejelentkezés</button>
    </div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
        function updatePlaceholder() {
            const contactType = document.getElementById('contactType').value;
            const contactInput = document.getElementById('contactInput');
            contactInput.placeholder = contactType === 'email' ? 'E-mail' : 'Telefonszám';
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>