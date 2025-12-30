<?php
session_start();
require_once __DIR__ . '/includes/lang.php';

// Prüfen ob Installation bereits durchgeführt wurde
if (!file_exists(__DIR__ . '/config/auth.php')) {
    header('Location: install.php');
    exit;
}

// Prüfen ob User eingeloggt ist
require_once __DIR__ . '/includes/auth.php';
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Dashboard anzeigen
header('Location: dashboard.php');
exit;
?>

