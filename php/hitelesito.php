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
        <div id="google_translate_element"></div>
        <script>
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'hu'}, 'google_translate_element');
            }
        </script>
        <h2>Profil információk</h2>
        <p>Felhasználónév: <span id="profileEmail"></span></p>
        <p>Személyi szám: <span id="personalId"></span></p>
        <p>Jogosítványszám: <span id="licenseNumber"></span></p>
        <button id="editProfileBtn" class="btn btn-primary">Profil szerkesztése</button>
        <form id="profileForm" style="display: none;">
            <label for="newEmail">Új email:</label>
            <input type="email" id="newEmail" name="newEmail" placeholder="Új email">
            <label for="newPersonalId">Új személyi szám:</label>
            <input type="text" id="newPersonalId" name="newPersonalId" placeholder="Új személyi szám">
            <label for="newLicenseNumber">Új jogosítványszám:</label>
            <input type="text" id="newLicenseNumber" name="newLicenseNumber" placeholder="Új jogosítványszám">
            <label for="newPassword">Új jelszó:</label>
            <input type="password" id="newPassword" name="newPassword" placeholder="Új jelszó">
            <button type="submit">Mentés</button>
        </form>
        <div id="message"></div>
        <button onclick="window.location.href='./index.php'" class="btn btn-link">Vissza</button>
    </div>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="../js/hitelesito.js"></script>
</body>
</html>