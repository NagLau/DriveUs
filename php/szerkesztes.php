<?php
session_start();
require_once './config.php';

$felhAz = $_SESSION['felhAz'] ?? null;
$alert_message = '';

if (!$felhAz) {
    header("Location: ./bejelentkezes.php");
    exit;
}

$hibak = [];
$frissitendoMezok = [];
$siker = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lekerdezes = "SELECT jelszo FROM felhasznalofiokok WHERE felhAz = '$felhAz'";
    $eredmeny = $sql->query($lekerdezes);
    $lekerdezett_adatok = $eredmeny->fetch_assoc();

    $regiJelszo = trim(filter_input(INPUT_POST, 'regijelszo', FILTER_SANITIZE_STRING));
    if (empty($regiJelszo)) {
        $hibak[] = "Régi jelszó megadása kötelező.";
    }
    if (!password_verify($regiJelszo, $lekerdezett_adatok['jelszo'])) {
        $hibak[] = "A régi jelszó nem megfelelő.";
    }
    
    if (isset($_POST['teljesNev'])) {
        $teljesNev = trim(filter_input(INPUT_POST, 'teljesNev', FILTER_SANITIZE_STRING));
        if (!empty($teljesNev)) {
            $frissitendoMezok['teljesNev'] = $sql->real_escape_string($teljesNev);
        }
    }
    
    if (isset($_POST['szemIgSzam'])) {
        $szemIgSzam = trim(filter_input(INPUT_POST, 'szemIgSzam', FILTER_SANITIZE_STRING));
        if (!empty($szemIgSzam)) {
            if (!preg_match('/^[0-9]{6}[A-Z]{2}$/', $szemIgSzam)) {
                $hibak[] = "Érvényes személyi igazolvány szám (6 számjegy + 2 betű) szükséges.";
            } else {
                $check = $sql->query("SELECT felhAz FROM felhasznalofiokok WHERE szemIgSzam = '".$sql->real_escape_string($szemIgSzam)."' AND felhAz != $felhAz");
                if ($check->num_rows > 0) {
                    $hibak[] = "Ez a személyi igazolvány szám már használatban van.";
                } else {
                    $frissitendoMezok['szemIgSzam'] = $sql->real_escape_string($szemIgSzam);
                }
            }
        }
    }
    
    if (isset($_POST['jogositvanySzam'])) {
        $jogositvanySzam = trim(filter_input(INPUT_POST, 'jogositvanySzam', FILTER_SANITIZE_STRING));
        if (!empty($jogositvanySzam)) {
            if (!preg_match('/^[0-9]{6}[A-Z]{2}$/', $jogositvanySzam)) {
                $hibak[] = "Érvényes jogosítvány szám (6 számjegy + 2 betű) szükséges.";
            } else {
                $check = $sql->query("SELECT felhAz FROM felhasznalofiokok WHERE jogositvanySzam = '".$sql->real_escape_string($jogositvanySzam)."' AND felhAz != $felhAz");
                if ($check->num_rows > 0) {
                    $hibak[] = "Ez a jogosítvány szám már használatban van.";
                } else {
                    $frissitendoMezok['jogositvanySzam'] = $sql->real_escape_string($jogositvanySzam);
                }
            }
        }
    }
    
    if (isset($_POST['eMail'])) {
        $eMail = trim(filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL));
        if (!empty($eMail)) {
            if (!filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
                $hibak[] = "Érvényes e-mail cím szükséges.";
            } else {
                $check = $sql->query("SELECT felhAz FROM felhasznalofiokok WHERE eMail = '".$sql->real_escape_string($eMail)."' AND felhAz != $felhAz");
                if ($check->num_rows > 0) {
                    $hibak[] = "Ez az e-mail cím már használatban van.";
                } else {
                    $frissitendoMezok['eMail'] = $sql->real_escape_string($eMail);
                }
            }
        }
    }
    
    if (isset($_POST['telSzam'])) {
        $telSzam = trim(filter_input(INPUT_POST, 'telSzam', FILTER_SANITIZE_STRING));
        if (!empty($telSzam)) {
            if (!preg_match('/^\+36[0-9]{9}$/', $telSzam)) {
                $hibak[] = "Érvényes telefonszám (+36xxxxxxxxx) szükséges.";
            } else {
                $frissitendoMezok['telSzam'] = $sql->real_escape_string($telSzam);
            }
        }
    }
    
    if (isset($_POST['felhaszNev'])) {
        $felhaszNev = trim(filter_input(INPUT_POST, 'felhaszNev', FILTER_SANITIZE_STRING));
        if (!empty($felhaszNev)) {
            $check = $sql->query("SELECT felhaz FROM felhasznalofiokok WHERE felhaszNev = '".$sql->real_escape_string($felhaszNev)."' AND felhAz != $felhAz");
            if ($check->num_rows > 0) {
                $hibak[] = "Ez a felhasználónév már foglalt.";
            } else {
                $frissitendoMezok['felhaszNev'] = $sql->real_escape_string($felhaszNev);
            }
        }
    }
    
    if (isset($_POST['ujjelszo']) && isset($_POST['jelszo_megerosites'])){
        $jelszo = trim($_POST['ujjelszo']);
        $jelszo_megerosites = trim($_POST['jelszo_megerosites']);

        if (!empty($jelszo) && !empty($jelszo_megerosites)) {
            $result = $sql->query("SELECT jelszo FROM felhasznalofiokok WHERE felhAz = $felhAz");
            $user = $result->fetch_assoc();
            if (empty($jelszo) || strlen($jelszo) < 8) {
                $hibak[] = "Az új jelszónak legalább 8 karakterből kell állnia.";
            } elseif ($jelszo !== $jelszo_megerosites) {
                $hibak[] = "Az új jelszavak nem egyeznek.";
            } else {
                $frissitendoMezok['jelszo'] = password_hash($jelszo, PASSWORD_BCRYPT);
            }
            }
        }
    }

    if (empty($hibak) && !empty($frissitendoMezok)) {
        $updateSql = "UPDATE felhasznalofiokok SET ";
        $updates = [];
        foreach ($frissitendoMezok as $field => $value) {
            $updates[] = "$field = '$value'";
        }
        $updateSql .= implode(', ', $updates);
        $updateSql .= " WHERE felhAz = $felhAz";
        
        if ($sql->query($updateSql)) {
            $siker = "A profil adataid sikeresen frissítve lettek!";
        } else {
            $hibak[] = "Hiba történt a frissítés során: " . $sql->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilom</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bejelentkezes.css">
</head>
<body>
    <div class="container">
        <h1>Profil frissítése</h1>
        <div id="google_translate_element"></div>
        <script>
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
            }
        </script>
        <?php if ($siker): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($siker); ?></div>
        <?php endif; ?>
        <?php if ($hibak): ?>
            <div class="alert alert-danger">
                <?php foreach ($hibak as $hiba): ?>
                    <p><?php echo htmlspecialchars($hiba); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" id="profileForm">
            <label for="felhaszNev">Új Felhasználónév:</label>
            <input type="text" id="felhaszNev" name="felhaszNev" placeholder="Felhasználónév">
            <label for="teljesNev">Új Teljes név:</label>
            <input type="text" id="teljesNev" name="teljesNev" placeholder="Teljes név">
            <label for="eMail">Új E-mail:</label>
            <input type="email" id="eMail" name="eMail" placeholder="Új email">
            <label for="szemIgSzam">Új Személyigazolvány szám:</label>
            <input type="text" id="szemIgSzam" name="szemIgSzam" placeholder="Új személyi szám">
            <label for="jogositvanySzam">Új Jogosítványszám:</label>
            <input type="text" id="jogositvanySzam" name="jogositvanySzam" placeholder="Új jogosítványszám">
            <label for="telSzam">Új telefonszám:</label>
            <input type="text" id="telSzam" name="telSzam" placeholder="Új telefonszám">
            <label for="ujjelszo">Új jelszó:</label>
            <input type="password" id="ujjelszo" name="ujjelszo" placeholder="Új jelszó">
            <label for="jelszo_megerosites">Új jelszó megerősítése:</label>
            <input type="password" id="jelszo_megerosites" name="jelszo_megerosites" placeholder="Új jelszó megerősítése">
            <label for="regijelszo">Régi jelszó:</label>
            <input type="password" id="regijelszo" name="regijelszo" placeholder="Régi jelszó">
            <button type="submit">Mentés</button>
        </form>
        <div id="message"></div>
        <button onclick="window.location.href='./profilom.php'" class="btn btn-primary">Vissza</button>
    </div>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>