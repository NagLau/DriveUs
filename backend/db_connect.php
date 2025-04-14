<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "driveus";
$port = 3307;

try {
    $conn = new mysqli($host, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        throw new Exception("Kapcsolódási hiba: " . $conn->connect_error);
    }

    if (!$conn->set_charset("utf8")) {
        throw new Exception("Karakterkódolás beállítása sikertelen: " . $conn->error);
    }
} catch (Exception $e) {
    die("Hiba: " . $e->getMessage());
}
?>



