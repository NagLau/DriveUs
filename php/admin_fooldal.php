<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Oldal</title>
    <link rel="stylesheet" href="../css/admin_fooldal.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: admin_bejelentkezes.php");
        exit;
    }

    include 'config.php';

    $message = '';
    $message_class = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add_image') {
            $kep_url = $_POST['kep_url'];
            $jarmuAz = $_POST['jarmuAz'];
            if (!empty($kep_url) && !empty($jarmuAz)) {
                $stmt = $sql->prepare("INSERT INTO kepek (kep_url, jarmuAz, archivalva) VALUES (?, ?, 0)");
                $stmt->bind_param("si", $kep_url, $jarmuAz);
                if ($stmt->execute()) {
                    $message = "Kép sikeresen hozzáadva!";
                    $message_class = 'success';
                } else {
                    $message = "Hiba a kép hozzáadása során: " . $sql->error;
                    $message_class = 'error';
                }
                $stmt->close();
            } else {
                $message = "A kép URL és a jármű azonosító nem lehet üres!";
                $message_class = 'error';
            }
        }

        if ($action === 'edit_image') {
            $id = $_POST['id'];
            $kep_url = $_POST['kep_url'];
            $jarmuAz = $_POST['jarmuAz'];
            if (!empty($kep_url) && !empty($jarmuAz)) {
                $stmt = $sql->prepare("UPDATE kepek SET kep_url = ?, jarmuAz = ? WHERE Az = ?");
                $stmt->bind_param("sii", $kep_url, $jarmuAz, $id);
                if ($stmt->execute()) {
                    $message = "Kép sikeresen szerkesztve!";
                    $message_class = 'success';
                } else {
                    $message = "Hiba a kép szerkesztése során: " . $sql->error;
                    $message_class = 'error';
                }
                $stmt->close();
            } else {
                $message = "A kép URL és a jármű azonosító nem lehet üres!";
                $message_class = 'error';
            }
        }

        if ($action === 'delete_image') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("DELETE FROM kepek WHERE Az = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Kép sikeresen törölve!";
                $message_class = 'success';
            } else {
                $message = "Hiba a kép törlése során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'archive_image') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("UPDATE kepek SET archivalva = 1 WHERE Az = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Kép sikeresen archiválva!";
                $message_class = 'success';
            } else {
                $message = "Hiba a kép archiválása során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'restore_image') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("UPDATE kepek SET archivalva = 0 WHERE Az = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Kép sikeresen visszaállítva!";
                $message_class = 'success';
            } else {
                $message = "Hiba a kép visszaállítása során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'add_car') {
            $rendszam = $_POST['rendszam'];
            $marka = $_POST['marka'];
            $modell = $_POST['modell'];
            $evjarat = $_POST['evjarat'];
            $uzemanyag = $_POST['uzemanyag'];
            $szin = $_POST['szin'];
            $hengeres = !empty($_POST['hengeres']) ? $_POST['hengeres'] : 0;
            $kolcsonzesiAr = $_POST['kolcsonzesiAr'];
            $ulesekSzama = $_POST['ulesekSzama'];
            $tipus = $_POST['tipus'];
            $allapot = $_POST['allapot'];
            $telephelyAz = isset($_POST['telephelyAz']) && !empty($_POST['telephelyAz']) ? $_POST['telephelyAz'] : 0;
            $kep_url = $_POST['kep_url'];

            if (!empty($rendszam) && !empty($marka) && !empty($modell) && !empty($evjarat) && !empty($kolcsonzesiAr) && !empty($kep_url) && !empty($telephelyAz)) {
                $stmt = $sql->prepare("INSERT INTO jarmuvek (rendszam, marka, modell, evjarat, uzemanyag, szin, hengerur, kolcsonzesiAr, ulesekSzama, tipus, allapot, telephelyAz, kep_url, archivalva) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
                $stmt->bind_param("sssissiiissis", $rendszam, $marka, $modell, $evjarat, $uzemanyag, $szin, $hengeres, $kolcsonzesiAr, $ulesekSzama, $tipus, $allapot, $telephelyAz, $kep_url);
                if ($stmt->execute()) {
                    $message = "Autó sikeresen hozzáadva!";
                    $message_class = 'success';
                } else {
                    $message = "Hiba az autó hozzáadása során: " . $sql->error;
                    $message_class = 'error';
                }
                $stmt->close();
            } else {
                $message = "A kötelező mezők (rendszám, márka, modell, évjárat, napi ár, kép URL, telephely ID) nem lehetnek üresek!";
                $message_class = 'error';
            }
        }

        if ($action === 'edit_car') {
            $id = $_POST['id'];
            $rendszam = $_POST['rendszam'];
            $marka = $_POST['marka'];
            $modell = $_POST['modell'];
            $evjarat = $_POST['evjarat'];
            $uzemanyag = $_POST['uzemanyag'];
            $szin = $_POST['szin'];
            $hengeres = !empty($_POST['hengeres']) ? $_POST['hengeres'] : 0;
            $kolcsonzesiAr = $_POST['kolcsonzesiAr'];
            $ulesekSzama = $_POST['ulesekSzama'];
            $tipus = $_POST['tipus'];
            $allapot = $_POST['allapot'];
            $telephelyAz = isset($_POST['telephelyAz']) && !empty($_POST['telephelyAz']) ? $_POST['telephelyAz'] : 0;
            $kep_url = $_POST['kep_url'];

            $stmt = $sql->prepare("UPDATE jarmuvek SET rendszam = ?, marka = ?, modell = ?, evjarat = ?, uzemanyag = ?, szin = ?, hengerur = ?, kolcsonzesiAr = ?, ulesekSzama = ?, tipus = ?, allapot = ?, telephelyAz = ?, kep_url = ? WHERE jarmuAz = ?");
            $stmt->bind_param("sssissiiisssisi", $rendszam, $marka, $modell, $evjarat, $uzemanyag, $szin, $hengeres, $kolcsonzesiAr, $ulesekSzama, $tipus, $allapot, $telephelyAz, $kep_url, $id);
            if ($stmt->execute()) {
                $message = "Autó sikeresen szerkesztve!";
                $message_class = 'success';
            } else {
                $message = "Hiba az autó szerkesztése során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'delete_car') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("DELETE FROM jarmuvek WHERE jarmuAz = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Autó sikeresen törölve!";
                $message_class = 'success';
            } else {
                $message = "Hiba az autó törlése során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'archive_car') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("UPDATE jarmuvek SET archivalva = 1 WHERE jarmuAz = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Autó sikeresen archiválva!";
                $message_class = 'success';
            } else {
                $message = "Hiba az autó archiválása során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }

        if ($action === 'restore_car') {
            $id = $_POST['id'];
            $stmt = $sql->prepare("UPDATE jarmuvek SET archivalva = 0 WHERE jarmuAz = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = "Autó sikeresen visszaállítva!";
                $message_class = 'success';
            } else {
                $message = "Hiba az autó visszaállítása során: " . $sql->error;
                $message_class = 'error';
            }
            $stmt->close();
        }
    }

    if (!empty($message)) {
        echo "<p class='message $message_class'>$message</p>";
    }

    $vehicles = $sql->query("SELECT jarmuAz, marka, modell FROM jarmuvek WHERE archivalva = 0");

    $result_images = $sql->query("SELECT * FROM kepek WHERE archivalva = 0");
    if (!$result_images) {
        echo "<p class='message error'>Hiba a képek lekérdezése során: " . $sql->error . "</p>";
    }

    $result_archived_images = $sql->query("SELECT * FROM kepek WHERE archivalva = 1");
    if (!$result_archived_images) {
        echo "<p class='message error'>Hiba az archivált képek lekérdezése során: " . $sql->error . "</p>";
    }

    $result_cars = $sql->query("SELECT * FROM jarmuvek WHERE archivalva = 0");
    if (!$result_cars) {
        echo "<p class='message error'>Hiba az autók lekérdezése során: " . $sql->error . "</p>";
    }

    $result_archived_cars = $sql->query("SELECT * FROM jarmuvek WHERE archivalva = 1");
    if (!$result_archived_cars) {
        echo "<p class='message error'>Hiba az archivált autók lekérdezése során: " . $sql->error . "</p>";
    }
    ?>

    <header>
        <nav class="navbar">
            <div class="navbar-brand">
                <h2>Admin Panel</h2>
            </div>
            <ul class="navbar-menu">
                <li><a href="logout.php">Kijelentkezés</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <div id="resultModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal('resultModal')">×</span>
                <p id="resultMessage"></p>
            </div>
        </div>

        <div id="editImageModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal('editImageModal')">×</span>
                <h3>Kép szerkesztése</h3>
                <form id="editImageForm">
                    <input type="hidden" name="action" value="edit_image">
                    <input type="hidden" name="id" id="editImageId">
                    <label for="edit_jarmuAz">Jármű:</label>
                    <select name="jarmuAz" id="edit_jarmuAz" required>
                        <option value="">Válassz járművet</option>
                        <?php
                        $vehicles->data_seek(0);
                        while ($vehicle = $vehicles->fetch_assoc()): ?>
                            <option value="<?php echo $vehicle['jarmuAz']; ?>">
                                <?php echo htmlspecialchars($vehicle['jarmuAz'] . ' - ' . $vehicle['marka'] . ' ' . $vehicle['modell']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>
                    <label for="edit_kep_url">Google Drive Link:</label>
                    <input type="text" name="kep_url" id="edit_kep_url" placeholder="Pl. https://drive.google.com/..." required>
                    <button type="submit">Mentés</button>
                </form>
            </div>
        </div>

        <div id="editCarModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal('editCarModal')">×</span>
                <h3>Autó szerkesztése</h3>
                <form id="editCarForm">
                    <input type="hidden" name="action" value="edit_car">
                    <input type="hidden" name="id" id="editCarId">
                    <label for="edit_rendszam">Rendszám:</label>
                    <input type="text" name="rendszam" id="edit_rendszam" placeholder="Pl. ABC123" required><br>
                    <label for="edit_marka">Márka:</label>
                    <input type="text" name="marka" id="edit_marka" placeholder="Pl. Toyota" required><br>
                    <label for="edit_modell">Modell:</label>
                    <input type="text" name="modell" id="edit_modell" placeholder="Pl. Corolla" required><br>
                    <label for="edit_evjarat">Évjárat:</label>
                    <input type="number" name="evjarat" id="edit_evjarat" placeholder="Pl. 2020" required><br>
                    <label for="edit_uzemanyag">Üzemanyag:</label>
                    <select name="uzemanyag" id="edit_uzemanyag">
                        <option value="Benzin">Benzin</option>
                        <option value="Dízel">Dízel</option>
                        <option value="Elektromos">Elektromos</option>
                        <option value="Hibrid">Hibrid</option>
                    </select><br>
                    <label for="edit_szin">Szín:</label>
                    <input type="text" name="szin" id="edit_szin" placeholder="Pl. Fekete"><br>
                    <label for="edit_hengeres">Hengerűrtartalom (cm³):</label>
                    <input type="number" name="hengeres" id="edit_hengeres" placeholder="Pl. 2000" step="0.1"><br>
                    <label for="edit_kolcsonzesiAr">Napi Bérlési Ár (Ft):</label>
                    <input type="number" name="kolcsonzesiAr" id="edit_kolcsonzesiAr" placeholder="Pl. 15000" required><br>
                    <label for="edit_ulesekSzama">Ülések Száma:</label>
                    <input type="number" name="ulesekSzama" id="edit_ulesekSzama" placeholder="Pl. 5"><br>
                    <label for="edit_tipus">Típus:</label>
                    <select name="tipus" id="edit_tipus">
                        <option value="Szedán">Szedán</option>
                        <option value="SUV">SUV</option>
                        <option value="Kupé">Kupé</option>
                        <option value="Kabrió">Kabrió</option>
                        <option value="Hatchback">Hatchback</option>
                    </select><br>
                    <label for="edit_allapot">Állapot:</label>
                    <select name="allapot" id="edit_allapot">
                        <option value="elérhető">Elérhető</option>
                        <option value="kikölcsönzött">Kikölcsönzött</option>
                    </select><br>
                    <label for="edit_telephelyAz">Telephely ID:</label>
                    <input type="number" name="telephelyAz" id="edit_telephelyAz" placeholder="Pl. 1" required><br>
                    <label for="edit_kep_url">Kép URL (Google Drive Link):</label>
                    <input type="text" name="kep_url" id="edit_kep_url" placeholder="Pl. https://drive.google.com/..." required><br>
                    <button type="submit">Mentés</button>
                </form>
            </div>
        </div>

        <h1>Üdvözöllek az Admin oldalon, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>

        <h2>Képnézegető Kezelése</h2>
        <h3>Új Kép Hozzáadása</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add_image">
            <label for="jarmuAz">Jármű:</label>
            <select name="jarmuAz" id="jarmuAz" required>
                <option value="">Válassz járművet</option>
                <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                    <option value="<?php echo $vehicle['jarmuAz']; ?>">
                        <?php echo htmlspecialchars($vehicle['jarmuAz'] . ' - ' . $vehicle['marka'] . ' ' . $vehicle['modell']); ?>
                    </option>
                <?php endwhile; ?>
            </select><br>
            <label for="kep_url">Google Drive Link:</label>
            <input type="text" name="kep_url" id="kep_url" placeholder="Pl. https://drive.google.com/..." required>
            <button type="submit">Hozzáadás</button>
        </form>

        <h3>Képek Listája</h3>
        <table>
            <thead>
                <tr>
                    <th>Kép AZ</th>
                    <th>Kép URL</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_images && $result_images->num_rows > 0) {
                    while ($row = $result_images->fetch_assoc()): ?>
                        <tr data-id="<?php echo $row['Az']; ?>">
                            <td><?php echo htmlspecialchars($row['Az']); ?></td>
                            <td><?php echo htmlspecialchars($row['kep_url']); ?></td>
                            <td>
                                <!--<button onclick="showEditImageForm(<?php echo $row['Az'] ?? 0; ?>, '<?php echo htmlspecialchars($row['kep_url']); ?>', <?php echo $row['jarmuAz'] ?? 0; ?>)">Szerkesztés</button>-->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_image">
                                    <input type="hidden" name="id" value="<?php echo $row['Az']; ?>">
                                    <button type="submit" data-action="delete">Törlés</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="archive_image">
                                    <input type="hidden" name="id" value="<?php echo $row['Az']; ?>">
                                    <button type="submit" data-action="archive">Archiválás</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='3'>Nincsenek képek az adatbázisban.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Archivált Képek Listája</h3>
        <table>
            <thead>
                <tr>
                    <th>Kép AZ</th>
                    <th>Kép URL</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_archived_images && $result_archived_images->num_rows > 0) {
                    while ($row = $result_archived_images->fetch_assoc()): ?>
                        <tr data-id="<?php echo $row['Az']; ?>">
                            <td><?php echo htmlspecialchars($row['Az']); ?></td>
                            <td><?php echo htmlspecialchars($row['kep_url']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="restore_image">
                                    <input type="hidden" name="id" value="<?php echo $row['Az']; ?>">
                                    <button type="submit">Visszaállítás</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_image">
                                    <input type="hidden" name="id" value="<?php echo $row['Az']; ?>">
                                    <button type="submit" data-action="delete">Törlés</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='3'>Nincsenek archivált képek az adatbázisban.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Autók Kezelése</h2>
        <h3>Új Autó Hozzáadása</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add_car">
            <label for="rendszam">Rendszám:</label>
            <input type="text" name="rendszam" id="rendszam" placeholder="Pl. ABC123" required><br>
            <label for="marka">Márka:</label>
            <input type="text" name="marka" id="marka" placeholder="Pl. Toyota" required><br>
            <label for="modell">Modell:</label>
            <input type="text" name="modell" id="modell" placeholder="Pl. Corolla" required><br>
            <label for="evjarat">Évjárat:</label>
            <input type="number" name="evjarat" id="evjarat" placeholder="Pl. 2020" required><br>
            <label for="uzemanyag">Üzemanyag:</label>
            <select name="uzemanyag" id="uzemanyag">
                <option value="Benzin">Benzin</option>
                <option value="Dízel">Dízel</option>
                <option value="Elektromos">Elektromos</option>
                <option value="Hibrid">Hibrid</option>
            </select><br>
            <label for="szin">Szín:</label>
            <input type="text" name="szin" id="szin" placeholder="Pl. Fekete"><br>
            <label for="hengeres">Hengerűrtartalom (cm³):</label>
            <input type="number" name="hengeres" id="hengeres" placeholder="Pl. 2000" step="0.1"><br>
            <label for="kolcsonzesiAr">Napi Bérlési Ár (Ft):</label>
            <input type="number" name="kolcsonzesiAr" id="kolcsonzesiAr" placeholder="Pl. 15000" required><br>
            <label for="ulesekSzama">Ülések Száma:</label>
            <input type="number" name="ulesekSzama" id="ulesekSzama" placeholder="Pl. 5"><br>
            <label for="tipus">Típus:</label>
            <select name="tipus" id="tipus">
                <option value="Szedán">Szedán</option>
                <option value="SUV">SUV</option>
                <option value="Kupé">Kupé</option>
                <option value="Kabrió">Kabrió</option>
                <option value="Hatchback">Hatchback</option>
            </select><br>
            <label for="allapot">Állapot:</label>
            <select name="allapot" id="allapot">
                <option value="elérhető">Elérhető</option>
                <option value="kikölcsönzött">Kikölcsönzött</option>
            </select><br>
            <label for="telephelyAz">Telephely ID:</label>
            <input type="number" name="telephelyAz" id="telephelyAz" placeholder="Pl. 1" required><br>
            <label for="kep_url">Kép URL (Google Drive Link):</label>
            <input type="text" name="kep_url" id="kep_url" placeholder="Pl. https://drive.google.com/..." required><br>
            <button type="submit">Hozzáadás</button>
        </form>

        <h3>Autók Listája</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rendszám</th>
                    <th>Márka</th>
                    <th>Modell</th>
                    <th>Évjárat</th>
                    <th>Üzemanyag</th>
                    <th>Szín</th>
                    <th>Henger</th>
                    <th>Napi Ár</th>
                    <th>Ülések</th>
                    <th>Típus</th>
                    <th>Állapot</th>
                    <th>Telephely ID</th>
                    <th>Kép URL</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_cars && $result_cars->num_rows > 0) {
                    while ($row = $result_cars->fetch_assoc()): ?>
                        <tr data-id="<?php echo $row['jarmuAz']; ?>">
                            <td><?php echo $row['jarmuAz']; ?></td>
                            <td><?php echo htmlspecialchars($row['rendszam']); ?></td>
                            <td><?php echo htmlspecialchars($row['marka']); ?></td>
                            <td><?php echo htmlspecialchars($row['modell']); ?></td>
                            <td><?php echo $row['evjarat']; ?></td>
                            <td><?php echo htmlspecialchars($row['uzemanyag']); ?></td>
                            <td><?php echo htmlspecialchars($row['szin']); ?></td>
                            <td><?php echo $row['hengerur']; ?></td>
                            <td><?php echo $row['kolcsonzesiAr']; ?></td>
                            <td><?php echo $row['ulesekSzama']; ?></td>
                            <td><?php echo htmlspecialchars($row['tipus']); ?></td>
                            <td><?php echo htmlspecialchars($row['allapot']); ?></td>
                            <td><?php echo $row['telephelyAz']; ?></td>
                            <td><?php echo htmlspecialchars($row['kep_url']); ?></td>
                            <td>
                                <!--<button onclick="showEditCarForm(
                                    <?php echo $row['jarmuAz'] ?? 0; ?>,
                                    '<?php echo htmlspecialchars($row['rendszam']); ?>',
                                    '<?php echo htmlspecialchars($row['marka']); ?>',
                                    '<?php echo htmlspecialchars($row['modell']); ?>',
                                    <?php echo $row['evjarat'] ?? 0; ?>,
                                    '<?php echo htmlspecialchars($row['uzemanyag']); ?>',
                                    '<?php echo htmlspecialchars($row['szin']); ?>',
                                    <?php echo $row['hengerur'] ?? 0; ?>,
                                    <?php echo $row['kolcsonzesiAr'] ?? 0; ?>,
                                    <?php echo $row['ulesekSzama'] ?? 0; ?>,
                                    '<?php echo htmlspecialchars($row['tipus']); ?>',
                                    '<?php echo htmlspecialchars($row['allapot']); ?>',
                                    <?php echo $row['telephelyAz'] ?? 0; ?>,
                                    '<?php echo htmlspecialchars($row['kep_url']); ?>'
                                )">Szerkesztés</button>-->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_car">
                                    <input type="hidden" name="id" value="<?php echo $row['jarmuAz']; ?>">
                                    <button type="submit" data-action="delete">Törlés</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="archive_car">
                                    <input type="hidden" name="id" value="<?php echo $row['jarmuAz']; ?>">
                                    <button type="submit" data-action="archive">Archiválás</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='16'>Nincsenek autók az adatbázisban.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Archivált Autók Listája</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rendszám</th>
                    <th>Márka</th>
                    <th>Modell</th>
                    <th>Évjárat</th>
                    <th>Üzemanyag</th>
                    <th>Szín</th>
                    <th>Henger</th>
                    <th>Napi Ár</th>
                    <th>Ülések</th>
                    <th>Típus</th>
                    <th>Állapot</th>
                    <th>Telephely ID</th>
                    <th>Kép URL</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_archived_cars && $result_archived_cars->num_rows > 0) {
                    while ($row = $result_archived_cars->fetch_assoc()): ?>
                        <tr data-id="<?php echo $row['jarmuAz']; ?>">
                            <td><?php echo $row['jarmuAz']; ?></td>
                            <td><?php echo htmlspecialchars($row['rendszam']); ?></td>
                            <td><?php echo htmlspecialchars($row['marka']); ?></td>
                            <td><?php echo htmlspecialchars($row['modell']); ?></td>
                            <td><?php echo $row['evjarat']; ?></td>
                            <td><?php echo htmlspecialchars($row['uzemanyag']); ?></td>
                            <td><?php echo htmlspecialchars($row['szin']); ?></td>
                            <td><?php echo $row['hengerur']; ?></td>
                            <td><?php echo $row['kolcsonzesiAr']; ?></td>
                            <td><?php echo $row['ulesekSzama']; ?></td>
                            <td><?php echo htmlspecialchars($row['tipus']); ?></td>
                            <td><?php echo htmlspecialchars($row['allapot']); ?></td>
                            <td><?php echo $row['telephelyAz']; ?></td>
                            <td><?php echo htmlspecialchars($row['kep_url']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="restore_car">
                                    <input type="hidden" name="id" value="<?php echo $row['jarmuAz']; ?>">
                                    <button type="submit">Visszaállítás</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_car">
                                    <input type="hidden" name="id" value="<?php echo $row['jarmuAz']; ?>">
                                    <button type="submit" data-action="delete">Törlés</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile;
                } else {
                    echo "<tr><td colspan='16'>Nincsenek archivált autók az adatbázisban.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php $sql->close(); ?>
    </div>

    <script src="admin_scripts.js"></script>
</body>
</html>