<?php
session_start();
require_once './config.php';

$felhAz = $_SESSION['felhAz'] ?? null;
$alert_message = '';

if (!$felhAz) {
    header("Location: ./bejelentkezes.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/berleseim.css">
    <title>DRIVEUS - BÉRLÉSEIM</title>
</head>
<body>
    <header>
        <h1 id="cegnev">DriveUs</h1>
        <div class="menu-icon">☰</div> 
        <nav>
            <div class="close-icon">Bezárás ✕</div> 
            <a href="./index.php">FŐOLDAL</a>
            <a href="./autok.php">AUTÓK</a>
            <a href="./kapcsolat.php">KAPCSOLAT</a>
            <a href="./profilom.php">PROFILOM</a>
        </nav>
        <div id="google_translate_element"></div>
        <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
        }
    </script>
    </header>
    <main>
        <section class="intro">
            <h1>Az Ön Bérlései</h1>
            <p>Itt találhatók a DriveUs-nál végzett autóbérléseivel kapcsolatos részletek és státuszok.</p>
        </section>
        <section class="berles-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="active">Jelenleg zajlik</button>
                <button class="tab-btn" data-tab="pending">Függőben lévő</button>
                <button class="tab-btn" data-tab="future">Közelgő</button>
                <button class="tab-btn" data-tab="completed">Befejezett</button>
            </div>
            <div class="tab-content" id="active"></div>
            <div class="tab-content" id="pending"></div>
            <div class="tab-content" id="future"></div>
            <div class="tab-content" id="completed"></div>
        </section>
        <section class="summary">
            <h2>Összegzés</h2>
            <div class="summary-content" id="summary-content"></div>
        </section>
    </main>
    <footer>
        <img src="../assetts/logo.jpg" alt="DriveUs Logo" id="footer-img">
        <p id="email">Vegye fel velünk a kapcsolatot: <a href="mailto:driveus.car.rent@gmail.com">driveus.car.rent@gmail.com</a></p>
        <p id="footer_p">© 2025 DriveUs - Luxus autóbérlés</p>
    </footer>
    
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="../js/berleseim.js"></script>
</body>
</html>