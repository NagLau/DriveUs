<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['torles_megerositve'])) {
    if (isset($_SESSION['felhAz'])) {
        $felhAz = $_SESSION['felhAz'];

        $stmt1 = $sql->prepare("DELETE FROM fizetesi_mod WHERE felhAz = ?");
        $stmt1->bind_param("i", $felhAz);
        $stmt1->execute();

        $stmt2 = $sql->prepare("DELETE FROM berlesi_elozmenyek WHERE felhAz = ?");
        $stmt2->bind_param("i", $felhAz);
        $stmt2->execute();

        $stmt3 = $sql->prepare("DELETE FROM felhasznalofiokok WHERE felhAz = ?");
        $stmt3->bind_param("i", $felhAz);
        
        if ($stmt3->execute()) {
            session_destroy();
            header("Location: index.php?uzenet=profil_torolve");
            exit();
        } else {
            echo "Hiba történt a felhasználó törlése során.";
        }
    } else {
        echo "Nincs bejelentkezve.";
    }
} else {
    echo "Érvénytelen kérés.";
}
?>
