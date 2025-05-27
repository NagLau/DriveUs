<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>DRIVEUS - FŐOLDAL</title>
</head>
<body>
<header>
    <h1 id="cegnev">DriveUs</h1>
    <div class="menu-icon">☰</div> 
    <nav>
        <div class="close-icon">Bezárás ✕</div> 
        <a href="./kapcsolat.php">KAPCSOLAT</a>
        <a href="./autok.php">AUTÓK</a>
        <a href="./berleseim.php">BÉRLÉSEIM</a>
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
            <h1>DriveUs - A szabadság, ami mindig úton van.</h1>
            <p>Üdvözöljük a DriveUs autóbérlő weboldalán! Mi segítünk Önnek abban, hogy minden utazás egy felejthetetlen
                élmény legyen...</p>
        </section>
        <section class="card-container">
            <div class="card">
                <h4>Rugalmas bérlés</h4>
                <p>Rövid és hosszú távú autóbérlés egyaránt elérhető. Bármilyen típusú autóra van szüksége, mi
                    biztosítjuk Önnek a legjobb opciókat, hogy az Ön igényeihez leginkább passzoljon.</p>
            </div>
            <div class="card">
                <h4>Széles választék</h4>
                <p>A legújabb modellek és különféle típusok. Válasszon prémium, családi vagy sportautók közül, hogy
                    minden utazás kényelmes és élvezetes legyen.</p>
            </div>
            <div class="card">
                <h4>Kiváló állapotú autók</h4>
                <p>Minden járművet rendszeresen karbantartunk, hogy Ön biztos lehessen abban, hogy a legjobb minőséget
                    kapja. A biztonság és a megbízhatóság számunkra elsődleges.</p>
            </div>
            <div class="card">
                <h4>Versenyképes árak</h4>
                <p>Szolgáltatásainkhoz rendkívül versenyképes árakat kínálunk, hogy mindenki számára elérhetővé váljon a
                    prémium autóbérlés élménye.</p>
            </div>
            <div class="card">
                <h4>24/7 Ügyfélszolgálat</h4>
                <p>Ha bármilyen kérdése lenne, a nap 24 órájában elérhető ügyfélszolgálatunk mindig segít Önnek a
                    legjobb megoldásokkal.</p>
            </div>
        </section>
        <div class="row">
            <div class="col-6">
                <div class="gallery-container">
                    <button id="elozo" class="prev">❮</button>
<?php
    include './config.php';

    function convertGoogleDriveLink($url) {
        return "./image_proxy.php?url=" . urlencode($url);
    }

    if (!isset($sql) || $sql->connect_error) {
        die("Adatbázis kapcsolat sikertelen: " . ($sql ? $sql->connect_error : "Nincs kapcsolat"));
    }

    $sql_query = "SELECT kep_url FROM kepek";
    $result = $sql->query($sql_query);

    if (!$result) {
        die("SQL lekérdezés hiba: " . $sql->error);
    }

    if ($result->num_rows > 0) {
        $index = 0;
        while ($row = $result->fetch_assoc()) {
            $imageUrl = convertGoogleDriveLink($row['kep_url']);
            $displayClass = ($index === 0) ? 'active' : '';
            echo "<img src='$imageUrl' class='slide $displayClass' alt='Galéria kép'>";
            $index++;
        }
    } else {
        echo "<img src='kepek/hiba_kep.jpg' class='slide active' alt='Nincs kép'>";
    }

    $sql->close();
?>
                    <button id="kovetkezo" class="next">❯</button>
                </div>
            </div>
            <div class="col-6">
                <div> <!-- szöveg formázása -->
                    <p id="pp"> Az utazás nem csupán az úti célról szól, hanem magáról az élményről is. A DriveUs-nál arra
                        törekszünk, hogy minden út kényelmes és emlékezetes legyen. Nálunk egyszerű és gyors a bérlés folyamata,
                        rejtett költségek nélkül, így teljes nyugalomban indulhatsz útnak. Járműveinket rendszeresen
                        karbantartjuk, hogy mindig a legjobb minőséget biztosítsuk számodra. Legyen szó városi autózásról vagy
                        egy hosszabb országúti kalandról, nálunk megtalálod a tökéletes autót. Fedezd fel a vezetés szabadságát
                        velünk!</p>
                    <button id="foglalj" class="book-now" onclick="window.location.href='./autok.php'">
                        FOGLALJ MOST!
                    </button>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <img src="../assetts/logo.jpg" alt="DriveUs Logo" id="footer-img">
        <p id="email">Vegye fel velünk a kapcsolatot: <a href="mailto:driveus.car.rent@gmail.com">driveus.car.rent@gmail.com</a></p>
        <p id="footer_p">© 2025 DriveUs - Luxus autóbérlés</p>
    </footer>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="../js/script.js"></script>
</body>
</html>