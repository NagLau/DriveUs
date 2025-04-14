<?php
include 'db_connect.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['felhAz'])) {
    header("Location: bejentkezes.php");
    exit();
}

$felhAz = $_SESSION['felhAz'];
$stmt = $conn->prepare("SELECT be.*, j.marka, j.modell, j.kolcsonzesiAr 
                        FROM berlesi_elozmenyek be 
                        JOIN jarmuvek j ON be.jarmuAz = j.jarmuAz 
                        WHERE be.felhAz = :felhAz");
$stmt->execute(['felhAz' => $felhAz]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/berleseim.css">
    <title>DriveUs/BÉRLÉSEIM</title>
</head>
<body>
    <header>
        <h1 id="focim">DriveUs</h1>
        <nav>
            <a href="hirlap.php">HÍRLAP</a>
            <a href="autok.php">AUTÓK</a>
            <a href="profilom.php">PROFILOM</a>
            <a href="index.php">FŐOLDAL</a>
        </nav>
        <div id="google_translate_element"></div>
    </header>
    <main>
        <section class="intro">
            <h1>Az Ön Bérlései</h1>
            <p>Itt találhatók a DriveUs-nál végzett autóbérléseivel kapcsolatos részletek és státuszok.</p>
        </section>
        <section class="berles-container">
            <?php if (isset($rentals) && count($rentals) > 0): ?>
                <?php foreach ($rentals as $rental): ?>
                    <div class="berles-card">
                        <h4>Bérlés: <?php echo htmlspecialchars($rental['marka'] . ' ' . $rental['modell']); ?></h4>
                        <p><strong>Időtartam:</strong> <?php echo htmlspecialchars($rental['foglalas_kezdete']) . ' - ' . htmlspecialchars($rental['foglalas_vege']); ?></p>
                        <p><strong>Ár:</strong> <?php echo htmlspecialchars($rental['kolcsonzesiAr']) . ' Ft/nap'; ?></p>
                        <p><strong>Állapot:</strong> Foglalt</p> <!-- Státusz manuálisan beállítva, mivel nincs külön státusz mező -->
                        <a class="more-info">További részletek</a>
                        <div class="more-details">
                            <p>Rendszám: <?php echo htmlspecialchars($rental['rendszam']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nincsenek bérlései.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <img src="../ceg_logo.png" alt="DriveUs Logo" id="footer-img">
        <p id="footer_p">Válogass prémium autóink közül, és indulj útnak stílusosan!</p>
    </footer>
    <script type="text/javascript">
        document.querySelectorAll('.more-info').forEach(function(link) {
            link.addEventListener('click', function() {
                const details = this.nextElementSibling;
                details.classList.toggle('show');
            });
        });
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="script.js"></script>
</body>
</html>
        <nav>
            <a href="../hirlap/hirlap.html">HÍRLAP</a>
            <a href="../autok/autok.php">AUTÓK</a>
            <a href="../profilom/profilom.php">PROFILOM</a>
            <a href="../fooldal/index.php">FŐOLDAL</a>
        </nav>
        <div id="google_translate_element"></div>
    </header>
    <main>
        <section class="intro">
            <h1>Az Ön Bérlései</h1>
            <p>Itt találhatók a DriveUs-nál végzett autóbérléseivel kapcsolatos részletek és státuszok.</p>
        </section>
        <section class="berles-container">
            <?php if (isset($rentals) && count($rentals) > 0): ?>
                <?php foreach ($rentals as $rental): ?>
                    <div class="berles-card">
                        <h4>Bérlés: <?php echo htmlspecialchars($rental['name']); ?></h4>
                        <p><strong>Időtartam:</strong> <?php echo htmlspecialchars($rental['start_date']) . ' - ' . htmlspecialchars($rental['end_date']); ?></p>
                        <p><strong>Ár:</strong> <?php echo htmlspecialchars($rental['price']) . ' Ft'; ?></p>
                        <p><strong>Állapot:</strong> <?php echo htmlspecialchars($rental['status']); ?></p>
                        <a class="more-info">További részletek</a>
                        <div class="more-details">
                            <p>Ez a bérlés részletei...</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nincsenek bérlései.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <img src="logo.png" alt="DriveUs Logo" id="footer-img">
        <p id="footer_p">Válogass prémium autóink közül, és indulj útnak stílusosan!</p>
    </footer>
    <script type="text/javascript">
        document.querySelectorAll('.more-info').forEach(function(link) {
            link.addEventListener('click', function() {
                const details = this.nextElementSibling;
                details.classList.toggle('show');
            });
        });
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="script.js"></script>
</body>
</html>