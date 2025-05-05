<?php
session_start();
require_once './config.php';

$felhAz = $_SESSION['felhAz'] ?? null;
$alert_message = '';

if (!$felhAz) {
    header("Location: ./bejelentkezes.php");
    exit;
}

// Profil szerkesztés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profil_frissites'])) {
    $uj_teljesNev = $sql->real_escape_string(trim($_POST['teljesNev'] ?? ''));
    $uj_felhaszNev = $sql->real_escape_string(trim($_POST['felhaszNev'] ?? ''));
    $uj_szemIgSzam = $sql->real_escape_string(trim($_POST['szemIgSzam'] ?? ''));
    $uj_jogositvanySzam = $sql->real_escape_string(trim($_POST['jogositvanySzam'] ?? ''));
    $uj_eMail = $sql->real_escape_string(trim($_POST['eMail'] ?? ''));
    $uj_telSzam = $sql->real_escape_string(trim($_POST['telSzam'] ?? ''));
    $uj_jelszo = $_POST['password'] ?? '';

    $lekerdezes = "SELECT jelszo FROM felhasznalofiokok WHERE felhAz = '$felhAz'";
    $eredmeny = $sql->query($lekerdezes);
    $felhasznalo = $eredmeny->fetch_assoc();

    if (password_verify($uj_jelszo, $felhasznalo['jelszo'])) {
        $frissites = "UPDATE felhasznalofiokok SET ";
        $updates = [];
        if (!empty($uj_teljesNev)) {
            $updates[] = "teljesNev = '$uj_teljesNev'";
            $_SESSION['teljesNev'] = $uj_teljesNev;
        }
        if (!empty($uj_felhaszNev)) {
            $updates[] = "felhaszNev = '$uj_felhaszNev'";
            $_SESSION['felhaszNev'] = $uj_felhaszNev;
        }
        if (!empty($uj_szemIgSzam)) {
            $updates[] = "szemIgSzam = '$uj_szemIgSzam'";
        }
        if (!empty($uj_jogositvanySzam)) {
            $updates[] = "jogositvanySzam = '$uj_jogositvanySzam'";
        }
        if (!empty($uj_eMail)) {
            $updates[] = "eMail = '$uj_eMail'";
        }
        if (!empty($uj_telSzam)) {
            $updates[] = "telSzam = '$uj_telSzam'";
        }

        // Profilkép kezelése
        if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../Uploads/'; //NE IDE MENTSE EZT A SZART HANEM VALAHO
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $file_name = $felhAz . '_' . basename($_FILES['profile-picture']['name']);
            $upload_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['profile-picture']['tmp_name'], $upload_path)) {
                $updates[] = "profilkep = '$upload_path'";
            } else {
                $alert_message = '<div class="alert alert-danger">Hiba a profilkép feltöltése során.</div>';
            }
        }

        if (!empty($updates)) {
            $frissites .= implode(", ", $updates) . " WHERE felhAz = '$felhAz'";
            if ($sql->query($frissites)) {
                $alert_message = '<div class="alert alert-success">Profil sikeresen frissítve!</div>';
            } else {
                $alert_message = '<div class="alert alert-danger">Hiba történt a profil frissítése során: ' . $sql->error . '</div>';
            }
        } else {
            $alert_message = '<div class="alert alert-danger">Nincs megadva új adat a frissítéshez.</div>';
        }
    } else {
        $alert_message = '<div class="alert alert-danger">Hibás jelszó!</div>';
    }
}

// Tagság vásárlás kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tagsag'])) {
    $uj_tagsag_input = trim($_POST['tagsag']);
    $tagsag_map = [
        'Bronz tag' => 'bronz',
        'Ezüst tag' => 'ezüst',
        'Arany tag' => 'arany'
    ];
    $osszeg_map = [
        'bronz' => 10,
        'ezüst' => 20,
        'arany' => 30
    ];
    $uj_tagsag = isset($tagsag_map[$uj_tagsag_input]) ? $tagsag_map[$uj_tagsag_input] : null;
    $valid_tagsagok = ['bronz', 'ezüst', 'arany'];

    if ($uj_tagsag && in_array($uj_tagsag, $valid_tagsagok)) {
        $fizetesi_mod = isset($_POST['store-card']) && $_POST['store-card'] ? 'Kártya' : 'Egyszeri kártya';
        $kartyaSzam = isset($_POST['store-card']) && $_POST['store-card'] ? $sql->real_escape_string($_POST['card-number'] ?? '') : NULL;
        $osszeg = $osszeg_map[$uj_tagsag];

        $lekerdezes = "SELECT teljesNev, felhaszNev FROM felhasznalofiokok WHERE felhAz = '$felhAz'";
        $eredmeny = $sql->query($lekerdezes);
        $felhasznalo = $eredmeny->fetch_assoc();

        $frissites = "UPDATE felhasznalofiokok SET tagsag = '$uj_tagsag' WHERE felhAz = '$felhAz'";
        $fizetes_beszuras = "INSERT INTO fizetesi_mod (nev, fizetesi_mod, osszeg, felhAz, teljesNev, kartyaSzam) 
                            VALUES ('{$felhasznalo['felhaszNev']}', '$fizetesi_mod', $osszeg, $felhAz, '{$felhasznalo['teljesNev']}', " . ($kartyaSzam ? "'$kartyaSzam'" : "NULL") . ")";

        if ($sql->query($frissites) && $sql->query($fizetes_beszuras)) {
            $alert_message = '<div class="alert alert-success">Sikeresen megvásároltad a(z) ' . ucfirst($uj_tagsag) . ' tagságot!</div>';
            $_SESSION['tagsag'] = $uj_tagsag;
        } else {
            $alert_message = '<div class="alert alert-danger">Hiba történt a tagság vásárlása során: ' . $sql->error . '</div>';
        }
    } else {
        $alert_message = '<div class="alert alert-danger">Érvénytelen tagság típus: ' . htmlspecialchars($uj_tagsag_input) . '</div>';
    }
}

// Kijelentkezés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kijelentkezes'])) {
    session_destroy();
    header("Location: ./index.php");
    exit;
}

// Felhasználó adatainak lekérése
$lekerdezes = "SELECT teljesNev, felhaszNev, szemIgSzam, jogositvanySzam, eMail, telSzam, tagsag, profilkep FROM felhasznalofiokok WHERE felhAz = '$felhAz'";
$eredmeny = $sql->query($lekerdezes);
$felhasznalo_adatok = $eredmeny->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilom - DriveUs</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/profilom.css">
</head>
<body>
    <header>
        <h1 class="logo">DriveUs</h1>
        <nav>
            <a href="./index.php">FŐOLDAL</a>
            <a href="./autok.php">AUTÓK</a>
            <a href="./kapcsolat.php">KAPCSOLAT</a>
            <a href="./berleseim.php">BÉRLÉSEIM</a>
        </nav>
        <div id="google_translate_element"></div>
        <script>
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
            }
        </script>
    </header>

    <div class="container">
        <?php echo $alert_message; ?>

        <div class="profile-info card">
            <h2>Jelenlegi adatok</h2>
            <div class="profile-data-box">
                <p>Teljes név: <span id="current-teljesNev-display"><?php echo htmlspecialchars($felhasznalo_adatok['teljesNev'] ?? ''); ?></span></p>
                <p>Felhasználónév: <span id="current-felhaszNev-display"><?php echo htmlspecialchars($felhasznalo_adatok['felhaszNev'] ?? ''); ?></span></p>
                <p>Email: <span id="current-email-display"><?php echo htmlspecialchars($felhasznalo_adatok['eMail'] ?? ''); ?></span></p>
                <p>Telefonszám: <span id="current-telSzam-display"><?php echo htmlspecialchars($felhasznalo_adatok['telSzam'] ?? ''); ?></span></p>
                <p>Személyi szám: <span id="current-szemIgSzam-display"><?php echo htmlspecialchars($felhasznalo_adatok['szemIgSzam'] ?? ''); ?></span></p>
                <p>Jogosítványszám: <span id="current-jogositvanySzam-display"><?php echo htmlspecialchars($felhasznalo_adatok['jogositvanySzam'] ?? ''); ?></span></p>
                <p>Jelenlegi tagság: <span id="current-membership-display"><?php echo htmlspecialchars(ucfirst($felhasznalo_adatok['tagsag'] ?? 'új tag')); ?></span></p>
                <div class="profile-img-container">
                    <?php if ($felhasznalo_adatok['profilkep']): ?>
                        <img id="current-profile-image" src="<?php echo htmlspecialchars($felhasznalo_adatok['profilkep']); ?>" alt="Profilkép" class="profile-picture-frame">
                    <?php else: ?>
                        <img id="current-profile-image" src="" alt="Profilkép" style="display: none;">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="profile-update-section card">
            <h2>Adatok módosítása</h2>
            <button id="editProfileBtn" class="btn btn-primary">Profil szerkesztése</button>
            <form id="profile-form" class="profile-form" style="display: none;" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="profil_frissites" value="1">
                <div class="mb-3">
                    <label for="teljesNev">Teljes név:</label>
                    <input type="text" id="teljesNev" name="teljesNev" value="<?php echo htmlspecialchars($felhasznalo_adatok['teljesNev'] ?? ''); ?>" class="form-control">
                
                    <label for="felhaszNev">Felhasználónév:</label>
                    <input type="text" id="felhaszNev" name="felhaszNev" value="<?php echo htmlspecialchars($felhasznalo_adatok['felhaszNev'] ?? ''); ?>" class="form-control">
               
                    <label for="eMail">Email:</label>
                    <input type="email" id="eMail" name="eMail" value="<?php echo htmlspecialchars($felhasznalo_adatok['eMail'] ?? ''); ?>" class="form-control">
                
                    <label for="telSzam">Telefonszám:</label>
                    <input type="text" id="telSzam" name="telSzam" value="<?php echo htmlspecialchars($felhasznalo_adatok['telSzam'] ?? ''); ?>" class="form-control">
                
                    <label for="szemIgSzam">Személyi szám:</label>
                    <input type="text" id="szemIgSzam" name="szemIgSzam" value="<?php echo htmlspecialchars($felhasznalo_adatok['szemIgSzam'] ?? ''); ?>" class="form-control">
                
                    <label for="jogositvanySzam">Jogosítványszám:</label>
                    <input type="text" id="jogositvanySzam" name="jogositvanySzam" value="<?php echo htmlspecialchars($felhasznalo_adatok['jogositvanySzam'] ?? ''); ?>" class="form-control">
                
                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                
                    <label for="profile-picture">Profilkép:</label>
                    <input type="file" id="profile-picture" name="profile-picture" accept="image/*" class="form-control">
                </div>
                <button type="submit" id="egy" class="btn btn-primary">Mentés</button>
                <button type="button" id="ketto" class="btn btn-secondary">Profilkép feltöltése</button>
            </form>
        </div>

        <div class="membership-section card">
            <h2 class="text-center mb-4">Tagság előnyök</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Előnyök</th>
                        <th>Új tag</th>
                        <th>Bronz tag</th>
                        <th>Ezüst tag</th>
                        <th>Arany tag</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Okosfoglalás</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                    </tr>
                    <tr>
                        <td>Kedvezményes kuponok</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                    </tr>
                    <tr>
                        <td>Kiemelt támogatás</td>
                        <td></td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                    </tr>
                    <tr>
                        <td>Nincs lemondási díj</td>
                        <td></td>
                        <td></td>
                        <td class="checkmark">✔</td>
                        <td class="checkmark">✔</td>
                    </tr>
                    <tr>
                        <td>Maximális kedvezmény</td>
                        <td></td>
                        <td>20%</td>
                        <td>30%</td>
                        <td>40%</td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                <button class="btn btn-primary" onclick="openModal('Bronz tag', 10)">Havi bronz tag vásárlása (10 EUR)</button>
                <button class="btn btn-primary" onclick="openModal('Ezüst tag', 20)">Havi ezüst tag vásárlása (20 EUR)</button>
                <button class="btn btn-primary" onclick="openModal('Arany tag', 30)">Havi arany tag vásárlása (30 EUR)</button>
            </div>
        </div>

        <div id="modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">×</span>
                <h2 id="package-name"></h2>
                <p id="package-price"></p>
                <form method="POST" action="">
                    <input type="hidden" name="tagsag" id="package-name-input">
                    <div class="mb-3">
                        <label for="card-number">Kártyaszám:</label>
                        <input type="text" id="card-number" name="card-number" class="form-control" required>
                        <img id="card-icon" src="" alt="Kártya ikon" style="display: none; height: 20px;">
                    </div>
                    <div class="mb-3">
                        <label for="expiry-date">Lejárati dátum:</label>
                        <input type="date" id="expiry-date" name="expiry-date" class="form-control" required>
                        <span id="date-error" style="color: red; display: none;">A dátumnak nem lehet régebbinek lennie a mai napnál.</span>
                    </div>
                    <div class="mb-3">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label><input type="checkbox" id="store-card" name="store-card"> Kártya adatainak tárolása</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Vásárlás</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <img src="../assetts/logo.jpg" alt="DriveUs Logo" id="footer-img">
        <div class="button-container">
            <form method="POST" style="display: inline;">
                <input type="hidden" name="kijelentkezes" value="1">
                <button type="submit" id="login-logout-btn" class="btn btn-link">Kijelentkezés</button>
            </form>
            <a href="./profilszerk.php" class="btn btn-link">Profil szerkesztése</a>
        </div>
        <p id="footer_p">© 2025 DriveUs - Luxus autóbérlés</p>
    </footer>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/profilom.js"></script>
</body>
</html>