<?php
session_start();
require_once __DIR__ . '/includes/lang.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();
require_once __DIR__ . '/includes/config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'get') {
    // Datenbank-Daten für Bearbeitung abrufen
    $id = $_GET['id'] ?? '';
    $db = getDatabase($id);
    if ($db) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'db' => $db]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => t('error_database_not_found')]);
    }
    exit;
}

if ($action === 'add') {
    $host = $_POST['host'] ?? '';
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';
    $database = $_POST['database'] ?? '';
    $name = $_POST['name'] ?? $database;
    
    if (empty($host) || empty($user) || empty($database)) {
        $_SESSION['message'] = t('error_fill_required_fields');
        $_SESSION['message_type'] = 'error';
    } else {
        addDatabase([
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'database' => $database,
            'name' => $name
        ]);
        $_SESSION['message'] = t('database_added');
        $_SESSION['message_type'] = 'success';
    }
    header('Location: dashboard.php');
    exit;
}

if ($action === 'edit') {
    $id = $_POST['id'] ?? '';
    $host = $_POST['host'] ?? '';
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';
    $database = $_POST['database'] ?? '';
    $name = $_POST['name'] ?? $database;
    
    $db = getDatabase($id);
    if (!$db) {
        $_SESSION['message'] = t('error_database_not_found');
        $_SESSION['message_type'] = 'error';
    } else {
        // Wenn Passwort leer ist, das alte beibehalten
        if (empty($password)) {
            $password = $db['password'];
        }
        
        updateDatabase($id, [
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'database' => $database,
            'name' => $name
        ]);
        $_SESSION['message'] = t('database_updated');
        $_SESSION['message_type'] = 'success';
    }
    header('Location: dashboard.php');
    exit;
}

if ($action === 'delete') {
    $id = $_POST['id'] ?? '';
    
    if (deleteDatabase($id)) {
        $_SESSION['message'] = t('database_deleted');
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = t('error_delete_failed');
        $_SESSION['message_type'] = 'error';
    }
    header('Location: dashboard.php');
    exit;
}

header('Location: dashboard.php');
exit;

