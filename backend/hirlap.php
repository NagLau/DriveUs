<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/hirlap.css">
    <title>DriveUs/HÍRLAP</title>
</head>
<body>
    <header>
        <h1 id="focim">DriveUs</h1>
        <nav>
            <a href="autok.html">AUTÓK</a>
            <a href="berleseim.html">BÉRLÉSEIM</a>
            <a href="profilom.html">PROFILOM</a>
            <a href="index.html">FŐOLDAL</a>
        </nav>
        <div id="google_translate_element"></div>
    </header>
    <main>
        <section class="intro">
            <h1>DriveUs Hírek és Újdonságok</h1>
            <p>Maradjon naprakész a legfrissebb hírekkel és ajánlatokkal a DriveUs világából! Itt található minden fontos információ az autóbérlés világából, új járműveinkről, promócióinkról és szolgáltatásainkról.</p>
        </section>
        <section class="news-container">
            <div class="news-card">
                <h4>Új prémium modellek elérhetők!</h4>
                <p>Örömmel értesítjük kedves ügyfeleinket, hogy a DriveUs kínálatában új prémium modellek is megjelentek! A legújabb autókat mostantól bérlésre kínáljuk, hogy még kényelmesebbé váljanak utazásai.</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>

            <div class="news-card">
                <h4>Különleges akciók és kedvezmények</h4>
                <p>A DriveUs most különleges kedvezményekkel várja! Kérjen akár 20%-os engedményt a hosszú távú bérlésre. Ne hagyja ki ezt a lehetőséget!</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>
            <div class="news-card">
                <h4>Új ügyfélszolgálati szolgáltatás</h4>
                <p>Az új ügyfélszolgálati rendszerünk biztosítja, hogy minden kérdését gyorsan és egyszerűen megválaszoljuk, akár telefonon, akár online chat-en keresztül. A nap 24 órájában elérhetőek vagyunk!</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>
            <div class="news-card">
                <h4>Új autókat vehetünk bérbe!</h4>
                <p>Mostantól újabb autók közül választhat! A legújabb családi és sportautó modellek már bérlésre is elérhetők. Ha hosszú utat tervez, nálunk mindig talál megfelelő járművet.</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>
            <div class="news-card">
                <h4>Új, kényelmes bérlési lehetőség</h4>
                <p>A DriveUs mostantól extra kényelmes bérlési lehetőséget kínál! Az új, egyszerűbb bérlés és gyors kiszolgálás biztosítja, hogy utazásai mindig zökkenőmentesek legyenek.</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>
            <div class="news-card">
                <h4>Év autója verseny</h4>
                <p>Csatlakozzon az "Év Autója" versenyhez! Töltsön el egy napot a legújabb modellek volánjánál, és szavazzon kedvencére, hogy milyen autókat szeretne legközelebb bérbe venni!</p>
                <a href="#">Tudj meg többet</a>
                <div class="more-details">
                    <p>A prémium modellek között megtalálható a legújabb elektromos luxusautó és a legjobb sportmodellek. Nézze meg kínálatunkat!</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <img src="../logo.jpg" alt="DriveUs Logo" id="footer-img">
        <p id="footer_p">Válogass prémium autóink közül, és indulj útnak stílusosan!</p>
    </footer>
    <script type="text/javascript">
        document.querySelectorAll('.news-card a').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); 
                const details = this.nextElementSibling;
                if (details) {
                    details.classList.toggle('show');
                }
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
