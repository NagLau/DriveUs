<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$max_attempts = 3;  
$lockout_time = 600; 
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}
if ($_SESSION['login_attempts'] >= $max_attempts) {
    $remaining_time = ($_SESSION['last_attempt_time'] + $lockout_time) - time();
    if ($remaining_time > 0) {
        echo "Túl sok sikertelen próbálkozás. Próbáld újra " . ceil($remaining_time / 60) . " perc múlva.";
        exit;
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "Hiányzó adatok!";
    exit;
}
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$valid_username = "DriveUSADMIN"; 
$valid_password = "1234"; 

if ($username === $valid_username && $password === $valid_password) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['login_attempts'] = 0;
    echo "Sikeres bejelentkezés!";
} else {
    $_SESSION['login_attempts']++; 
    $_SESSION['last_attempt_time'] = time();
    echo "Hibás felhasználónév vagy jelszó!";
}
?>
