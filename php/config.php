<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "driveus";
$port = 3307;

try {
    $sql = new mysqli($host, $username, $password, $dbname, $port);

    if ($sql->connect_error) {
        throw new Exception("Kapcsolódási hiba: " . $sql->connect_error);
    }

    if (!$sql->set_charset("utf8")) {
        throw new Exception("Karakterkódolás beállítása sikertelen: " . $sql->error);
    }
} catch (Exception $e) {
    die("Hiba: " . $e->getMessage());
}
?>