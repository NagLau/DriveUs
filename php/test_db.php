<?php
require_once './config.php';
if ($sql->connect_error) {
    die("Kapcsolódási hiba: " . $sql->connect_error);
}
echo "Adatbázis kapcsolat sikeres!";
?>