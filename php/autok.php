<?php
include './config.php';

if (!isset($sql) || $sql->connect_error) {
    die("Adatbázis kapcsolat hiba: " . ($sql ? $sql->connect_error : "Nincs kapcsolat"));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['filtered'])) {
    header('Location: ./autok.php?filtered=1');
    exit;
}

function convertGoogleDriveLink($url) {
    return "./image_proxy.php?url=" . urlencode($url);
}

$featured_car_file = './featured_car.json';

function hasWeekPassed($last_updated) {
    $one_week_in_seconds = 7 * 24 * 60 * 60;
    return (time() - $last_updated) >= $one_week_in_seconds;
}

$featured_car_data = ['car_id' => null, 'last_updated' => 0];
if (file_exists($featured_car_file)) {
    $featured_car_data = json_decode(file_get_contents($featured_car_file), true);
}

$featured_car = null;
$update_needed = !isset($featured_car_data['car_id']) || hasWeekPassed($featured_car_data['last_updated']);

if ($update_needed) {
    $sql_featured = "SELECT jarmuAz, rendszam, marka, modell, evjarat, uzemanyag, szin, hengerur,
                    kolcsonzesiAr, ulesekSzama, tipus, allapot, telephelyAz, kep_url
                    FROM jarmuvek
                    ORDER BY RAND()
                    LIMIT 1";

    $stmt_featured = $sql->prepare($sql_featured);
    if (!$stmt_featured) {
        die("Hiba a kiemelt autó lekérdezése során: " . $sql->error);
    }

    if (!$stmt_featured->execute()) {
        die("Hiba a kiemelt autó lekérdezés végrehajtása során: " . $stmt_featured->error);
    }

    $stmt_featured->bind_result(
        $jarmuAz, $rendszam, $marka, $modell, $evjarat, $uzemanyag, $szin, $hengerur,
        $kolcsonzesiAr, $ulesekSzama, $tipus, $allapot, $telephelyAz, $kep_url
    );

    if ($stmt_featured->fetch()) {
        $featured_car = [
            'jarmuAz' => $jarmuAz,
            'rendszam' => $rendszam,
            'marka' => $marka,
            'modell' => $modell,
            'evjarat' => $evjarat,
            'uzemanyag' => $uzemanyag,
            'szin' => $szin,
            'hengerur' => $hengerur,
            'kolcsonzesiAr' => $kolcsonzesiAr,
            'ulesekSzama' => $ulesekSzama,
            'tipus' => $tipus,
            'allapot' => $allapot,
            'telephelyAz' => $telephelyAz,
            'kep_url' => $kep_url
        ];

        $featured_car_data = [
            'car_id' => $jarmuAz,
            'last_updated' => time()
        ];
        file_put_contents($featured_car_file, json_encode($featured_car_data));
    }

    $stmt_featured->close();
} else {
    $sql_featured = "SELECT jarmuAz, rendszam, marka, modell, evjarat, uzemanyag, szin, hengerur,
                    kolcsonzesiAr, ulesekSzama, tipus, allapot, telephelyAz, kep_url
                    FROM jarmuvek
                    WHERE jarmuAz = ?";

    $stmt_featured = $sql->prepare($sql_featured);
    if (!$stmt_featured) {
        die("Hiba a kiemelt autó lekérdezése során: " . $sql->error);
    }

    $stmt_featured->bind_param("i", $featured_car_data['car_id']);
    if (!$stmt_featured->execute()) {
        die("Hiba a kiemelt autó lekérdezés végrehajtása során: " . $stmt_featured->error);
    }

    $stmt_featured->bind_result(
        $jarmuAz, $rendszam, $marka, $modell, $evjarat, $uzemanyag, $szin, $hengerur,
        $kolcsonzesiAr, $ulesekSzama, $tipus, $allapot, $telephelyAz, $kep_url
    );

    if ($stmt_featured->fetch()) {
        $featured_car = [
            'jarmuAz' => $jarmuAz,
            'rendszam' => $rendszam,
            'marka' => $marka,
            'modell' => $modell,
            'evjarat' => $evjarat,
            'uzemanyag' => $uzemanyag,
            'szin' => $szin,
            'hengerur' => $hengerur,
            'kolcsonzesiAr' => $kolcsonzesiAr,
            'ulesekSzama' => $ulesekSzama,
            'tipus' => $tipus,
            'allapot' => $allapot,
            'telephelyAz' => $telephelyAz,
            'kep_url' => $kep_url
        ];
    }

    $stmt_featured->close();
}

$is_filtered = isset($_GET['filtered']) && $_GET['filtered'] == '1' && (isset($_GET['car-type']) || isset($_GET['color']) || isset($_GET['brand']));

if (!$is_filtered) {
    $tipus = 'all';
    $szin = 'all';
    $marka = 'all';
} else {
    $tipus = isset($_GET['car-type']) && !empty($_GET['car-type']) ? $_GET['car-type'] : 'all';
    $szin = isset($_GET['color']) && !empty($_GET['color']) ? $_GET['color'] : 'all';
    $marka = isset($_GET['brand']) && !empty($_GET['brand']) ? $_GET['brand'] : 'all';
}

$sql_query = "SELECT jarmuAz, rendszam, marka, modell, evjarat, uzemanyag, szin, hengerur,
        kolcsonzesiAr, ulesekSzama, tipus, allapot, telephelyAz, kep_url
        FROM jarmuvek WHERE 1=1";

$params = [];
$types = "";

if ($tipus !== 'all') {
    $sql_query .= " AND tipus = ?";
    $params[] = $tipus;
    $types .= "s";
}

if ($szin !== 'all') {
    $sql_query .= " AND szin = ?";
    $params[] = $szin;
    $types .= "s";
}

if ($marka !== 'all') {
    $sql_query .= " AND marka = ?";
    $params[] = $marka;
    $types .= "s";
}

$stmt = $sql->prepare($sql_query);
if (!$stmt) {
    die("Hiba a lekérdezés előkészítése során: " . $sql->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    die("Hiba a lekérdezés végrehajtása során: " . $stmt->error);
}

$stmt->bind_result(
    $jarmuAz, $rendszam, $marka, $modell, $evjarat, $uzemanyag, $szin, $hengerur,
    $kolcsonzesiAr, $ulesekSzama, $tipus, $allapot, $telephelyAz, $kep_url
);

$jarmuvek = [];
while ($stmt->fetch()) {
    $jarmuvek[] = [
        'jarmuAz' => $jarmuAz,
        'rendszam' => $rendszam,
        'marka' => $marka,
        'modell' => $modell,
        'evjarat' => $evjarat,
        'uzemanyag' => $uzemanyag,
        'szin' => $szin,
        'hengerur' => $hengerur,
        'kolcsonzesiAr' => $kolcsonzesiAr,
        'ulesekSzama' => $ulesekSzama,
        'tipus' => $tipus,
        'allapot' => $allapot,
        'telephelyAz' => $telephelyAz,
        'kep_url' => $kep_url
    ];
}

$stmt->close();
$sql->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRIVEUS – AUTÓK</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/autok.css">
</head>
<body>
<header>
    <div id="cegnev" >DriveUs</div>
    <div class="menu-icon">☰</div> 
    <nav>
    <div class="close-icon">Bezárás ✕</div> 
        <a href="./index.php">FŐOLDAL</a>
        <a href="./kapcsolat.php">KAPCSOLAT</a>
        <a href="./profilom.php">PROFILOM</a>
        <a href="./berleseim.php">BÉRLÉSEIM</a>
    </nav>
    <div id="google_translate_element"></div>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
</header>

<main>
    <section class="hero">
        <h1>Bérelj prémium autót, és indulj útnak stílusosan!</h1>
        <p>Válaszd ki álmaid autóját, és foglald le egyszerűen.</p>
        <a href="#ajanlatok" class="btn-primary">Ajánlatok megtekintése</a>
    </section>

    <section class="filter-container">
        <h2 id="aktualis">Aktuális ajánlataink</h2>
        <p id="szuroszoveg">Autó szűrő</p>
        <form action="./autok.php" method="GET" class="filter-form">
            <div>
                <label for="tipus">Autó típus:</label>
                <select id="tipus" name="car-type">
                    <option value="all" <?php echo $tipus == 'all' ? 'selected' : ''; ?>>Összes</option>
                    <option value="Sedan" <?php echo $tipus == 'Szedán' ? 'selected' : ''; ?>>Szedán</option>
                    <option value="SUV" <?php echo $tipus == 'SUV' ? 'selected' : ''; ?>>SUV</option>
                    <option value="Kupe" <?php echo $tipus == 'Kupé' ? 'selected' : ''; ?>>Kupé</option>
                    <option value="Hatchback" <?php echo $tipus == 'Hatchback' ? 'selected' : ''; ?>>Hatchback</option>
                    <option value="Kabrio" <?php echo $tipus == 'Kabrió' ? 'selected' : ''; ?>>Kabrió</option>
                </select>
            </div>
            <div>
                <label for="szin">Szín:</label>
                <select id="szin" name="color">
                    <option value="all" <?php echo $szin == 'all' ? 'selected' : ''; ?>>Összes</option>
                    <option value="Fekete" <?php echo $szin == 'Fekete' ? 'selected' : ''; ?>>Fekete</option>
                    <option value="Szurke" <?php echo $szin == 'Szürke' ? 'selected' : ''; ?>>Szürke</option>
                    <option value="Feher" <?php echo $szin == 'Fehér' ? 'selected' : ''; ?>>Fehér</option>
                    <option value="Piros" <?php echo $szin == 'Piros' ? 'selected' : ''; ?>>Piros</option>
                    <option value="Narancssarga" <?php echo $szin == 'Narancssárga' ? 'selected' : ''; ?>>Narancssárga</option>
                    <option value="Sarga" <?php echo $szin == 'Sárga' ? 'selected' : ''; ?>>Sárga</option>
                    <option value="Zold" <?php echo $szin == 'Zöld' ? 'selected' : ''; ?>>Zöld</option>
                    <option value="Kek" <?php echo $szin == 'Kék' ? 'selected' : ''; ?>>Kék</option>
                    <option value="Lila" <?php echo $szin == 'Lila' ? 'selected' : ''; ?>>Lila</option>
                </select>
            </div>
            <div>
                <label for="marka">Márka:</label>
                <select id="marka" name="brand">
                    <option value="all" <?php echo $marka == 'all' ? 'selected' : ''; ?>>Összes</option>
                    <option value="Aston Martin" <?php echo $marka == 'Aston Martin' ? 'selected' : ''; ?>>Aston Martin</option>
                    <option value="BMW" <?php echo $marka == 'BMW' ? 'selected' : ''; ?>>BMW</option>
                    <option value="Ferrari" <?php echo $marka == 'Ferrari' ? 'selected' : ''; ?>>Ferrari</option>
                    <option value="Mercedes-Benz" <?php echo $marka == 'Mercedes-Benz' ? 'selected' : ''; ?>>Mercedes-Benz</option>
                    <option value="Ford" <?php echo $marka == 'Ford' ? 'selected' : ''; ?>>Ford</option>
                    <option value="Honda" <?php echo $marka == 'Honda' ? 'selected' : ''; ?>>Honda</option>
                    <option value="Porsche" <?php echo $marka == 'Porsche' ? 'selected' : ''; ?>>Porsche</option>
                    <option value="Toyota" <?php echo $marka == 'Toyota' ? 'selected' : ''; ?>>Toyota</option>
                </select>
            </div>
            <input type="hidden" name="filtered" value="1">
            <button type="submit" class="filter-btn">Szűrés</button>
        </form>
    </section>

    <section class="featured-car">
        <h2>Kiemelt ajánlatunk</h2>
        <?php if ($featured_car): ?>
            <div class="featured-card">
                <img src="<?php echo htmlspecialchars(convertGoogleDriveLink($featured_car['kep_url'])); ?>"
                     alt="<?php echo htmlspecialchars($featured_car['marka'] . ' ' . $featured_car['modell']); ?>"
                     onerror="this.style.display='none';">
                <div class="featured-info">
                    <h3><?php echo htmlspecialchars($featured_car['marka'] . ' ' . $featured_car['modell']); ?></h3>
                    <button onclick="openCarDetailsPage(
                        '<?php echo htmlspecialchars($featured_car['marka'] . ' ' . $featured_car['modell']); ?>',
                        '<?php echo htmlspecialchars(convertGoogleDriveLink($featured_car['kep_url'])); ?>',
                        [
                            '<?php echo htmlspecialchars($featured_car['hengerur'] . ' hengerűrtartalom'); ?>',
                            '<?php echo htmlspecialchars($featured_car['evjarat'] . ' évjárat'); ?>',
                            '<?php echo htmlspecialchars($featured_car['uzemanyag'] . ' üzemanyag'); ?>',
                            '<?php echo htmlspecialchars($featured_car['kolcsonzesiAr'] . ' Ft/nap'); ?>',
                            '<?php echo htmlspecialchars($featured_car['ulesekSzama'] . ' ülés'); ?>'
                        ],
                        '<?php echo htmlspecialchars($featured_car['kolcsonzesiAr'] . ' Ft/nap'); ?>'
                    )">Érdekel</button>
                </div>
            </div>
        <?php else: ?>
            <p>Nincs kiemelt ajánlat jelenleg.</p>
        <?php endif; ?>
    </section>

    <section id="ajanlatok" class="cars">
        <div class="car-container">
            <?php if (empty($jarmuvek)): ?>
                <p>Nincs találat a megadott szűrési feltételekkel.</p>
            <?php else: ?>
                <?php foreach ($jarmuvek as $jarmu): ?>
                    <div class="car-card">
                        <img src="<?php echo htmlspecialchars(convertGoogleDriveLink($jarmu['kep_url'])); ?>"
                             alt="<?php echo htmlspecialchars($jarmu['marka'] . ' ' . $jarmu['modell']); ?>"
                             onerror="this.style.display='none';">
                        <h3><?php echo htmlspecialchars($jarmu['marka']); ?></h3>
                        <button onclick="openCarDetailsPage(
                            '<?php echo htmlspecialchars($jarmu['marka'] . ' ' . $jarmu['modell']); ?>',
                            '<?php echo htmlspecialchars(convertGoogleDriveLink($jarmu['kep_url'])); ?>',
                            [
                                '<?php echo htmlspecialchars($jarmu['hengerur'] . ' cm³ hengerűrtartalom'); ?>',
                                '<?php echo htmlspecialchars($jarmu['evjarat'] . ' évjárat'); ?>',
                                '<?php echo htmlspecialchars($jarmu['uzemanyag'] . ' üzemanyag'); ?>',
                                '<?php echo htmlspecialchars($jarmu['kolcsonzesiAr'] . ' Ft/nap'); ?>',
                                '<?php echo htmlspecialchars($jarmu['ulesekSzama'] . ' ülés'); ?>'
                            ],
                            '<?php echo htmlspecialchars($jarmu['kolcsonzesiAr'] . ' Ft/nap'); ?>'
                        )">Érdekel</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <img src="../assetts/logo.jpg" alt="DriveUs Logo" id="footer-img" onerror="console.error('A logo.jpg betöltése sikertelen'); this.style.display='none';">
    <p id="email">Vegye fel velünk a kapcsolatot: <a href="mailto:driveus.car.rent@gmail.com">driveus.car.rent@gmail.com</a></p>
    <p id="footer_p">© 2025 DriveUs - Luxus autóbérlés</p>
</footer>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="../js/autok.js"></script>
</body>
</html>