<?php
session_start();
require_once './config.php';

$hibak = [];
$siker = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teljesNev = trim(filter_input(INPUT_POST, 'teljesNev', FILTER_SANITIZE_STRING));
    $szemIgSzam = trim(filter_input(INPUT_POST, 'szemIgSzam', FILTER_SANITIZE_STRING));
    $jogositvanySzam = trim(filter_input(INPUT_POST, 'jogositvanySzam', FILTER_SANITIZE_STRING));
    $eMail = trim(filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL));
    $telSzam = trim(filter_input(INPUT_POST, 'telSzam', FILTER_SANITIZE_STRING));
    $felhaszNev = trim(filter_input(INPUT_POST, 'felhaszNev', FILTER_SANITIZE_STRING));
    $jelszo = trim($_POST['jelszo']);
    $jelszo_megerosites = trim($_POST['jelszo_megerosites']);
    $aszf = isset($_POST['aszf']);

    if (empty($teljesNev)) $hibak[] = "Teljes név megadása kötelező.";
    if (empty($szemIgSzam) || !preg_match('/^[0-9]{6}[A-Z]{2}$/', $szemIgSzam)) $hibak[] = "Érvényes személyi igazolvány szám (6 számjegy + 2 betű) szükséges.";
    if (empty($jogositvanySzam) || !preg_match('/^[0-9]{6}[A-Z]{2}$/', $jogositvanySzam)) $hibak[] = "Érvényes jogosítvány szám (6 számjegy + 2 betű) szükséges.";
    if (empty($eMail) || !filter_var($eMail, FILTER_VALIDATE_EMAIL)) $hibak[] = "Érvényes e-mail cím szükséges.";
    if (empty($telSzam) || !preg_match('/^\+36[0-9]{9}$/', $telSzam)) $hibak[] = "Érvényes telefonszám (+36xxxxxxxxx) szükséges.";
    if (empty($felhaszNev)) $hibak[] = "Felhasználónév megadása kötelező.";
    if (empty($jelszo) || strlen($jelszo) < 8) $hibak[] = "A jelszónak legalább 8 karakterből kell állnia.";
    if ($jelszo !== $jelszo_megerosites) $hibak[] = "A jelszavak nem egyeznek.";
    if (!$aszf) $hibak[] = "El kell fogadnod az Általános Szerződési Feltételeket.";

    if (empty($hibak)) {
        $szemIgSzam = $sql->real_escape_string($szemIgSzam);
        $jogositvanySzam = $sql->real_escape_string($jogositvanySzam);
        $felhaszNev = $sql->real_escape_string($felhaszNev);
        $eMail = $sql->real_escape_string($eMail);

        $lekerdezes = "SELECT COUNT(*) AS count FROM felhasznalofiokok WHERE szemIgSzam = '$szemIgSzam' OR jogositvanySzam = '$jogositvanySzam' OR felhaszNev = '$felhaszNev' OR eMail = '$eMail'";
        $eredmeny = $sql->query($lekerdezes);
        $sor = $eredmeny->fetch_assoc();

        if ($sor['count'] > 0) {
            $hibak[] = "A személyi igazolvány szám, jogosítvány szám, felhasználónév vagy e-mail már létezik.";
        }
    }

    if (empty($hibak)) {
        $hashedJelszo = password_hash($jelszo, PASSWORD_BCRYPT);
        $teljesNev = $sql->real_escape_string($teljesNev);
        $telSzam = $sql->real_escape_string($telSzam);

        $lekerdezes = "INSERT INTO felhasznalofiokok (teljesNev, szemIgSzam, jogositvanySzam, eMail, telSzam, felhaszNev, jelszo, tagsag) VALUES ('$teljesNev', '$szemIgSzam', '$jogositvanySzam', '$eMail', '$telSzam', '$felhaszNev', '$hashedJelszo', 'új tag')";
        if ($sql->query($lekerdezes)) {
            $siker = "Sikeres regisztráció! Most bejelentkezhetsz.";
        } else {
            $hibak[] = "A regisztráció sikertelen: " . $sql->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztráció - DriveUs</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bejelentkezes.css">
</head>
<body>
    <div class="container">
        <h2>Regisztráció</h2>
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
        <form method="POST" action="">
            <div class="mb-3">
                <label for="teljesNev">Teljes név:</label>
                <input type="text" id="teljesNev" name="teljesNev" value="<?php echo isset($teljesNev) ? htmlspecialchars($teljesNev) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="szemIgSzam">Személyi igazolvány szám (pl. 123456AB):</label>
                <input type="text" id="szemIgSzam" name="szemIgSzam" value="<?php echo isset($szemIgSzam) ? htmlspecialchars($szemIgSzam) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jogositvanySzam">Jogosítvány szám (pl. 123456AB):</label>
                <input type="text" id="jogositvanySzam" name="jogositvanySzam" value="<?php echo isset($jogositvanySzam) ? htmlspecialchars($jogositvanySzam) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="eMail">E-mail:</label>
                <input type="email" id="eMail" name="eMail" value="<?php echo isset($eMail) ? htmlspecialchars($eMail) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telSzam">Telefonszám (pl. +36201234567):</label>
                <input type="text" id="telSzam" name="telSzam" value="<?php echo isset($telSzam) ? htmlspecialchars($telSzam) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="felhaszNev">Felhasználónév:</label>
                <input type="text" id="felhaszNev" name="felhaszNev" value="<?php echo isset($felhaszNev) ? htmlspecialchars($felhaszNev) : ''; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jelszo">Jelszó:</label>
                <input type="password" id="jelszo" name="jelszo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jelszo_megerosites">Jelszó megerősítése:</label>
                <input type="password" id="jelszo_megerosites" name="jelszo_megerosites" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>
                    <input type="checkbox" name="aszf" <?php echo isset($aszf) && $aszf ? 'checked' : ''; ?>>
                    Elfogadom az <a href="../assetts/driveus_aszf.pdf" target="_blank">Általános Szerződési Feltételeket</a>.
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Regisztráció</button>
        </form>
        <p>Már van fiókod? <a href="./bejelentkezes.php">Bejelentkezés</a></p>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>