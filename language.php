<?php
/**
 * Sprachauswahl Handler
 */
session_start();
require_once __DIR__ . '/includes/lang.php';

$lang = $_GET['lang'] ?? $_POST['lang'] ?? '';

if (!empty($lang) && setLanguage($lang)) {
    // Zurück zur vorherigen Seite oder zum Dashboard
    $redirect = $_GET['redirect'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit;
}

header('Location: index.php');
exit;

