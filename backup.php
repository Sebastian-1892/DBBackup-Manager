<?php
session_start();
require_once __DIR__ . '/includes/lang.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();
require_once __DIR__ . '/includes/config.php';

$id = $_GET['id'] ?? '';

if (empty($id)) {
    $_SESSION['message'] = t('error_no_db_id');
    $_SESSION['message_type'] = 'error';
    header('Location: dashboard.php');
    exit;
}

$db = getDatabase($id);
if (!$db) {
    $_SESSION['message'] = t('error_database_not_found');
    $_SESSION['message_type'] = 'error';
    header('Location: dashboard.php');
    exit;
}

// Backup-Verzeichnis erstellen
$backupDir = __DIR__ . '/backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0700, true);
}

// Backup-Dateiname
$date = date('Y-m-d_H-i-s');
$filename = "backup_{$db['database']}_{$date}.sql";
$filepath = $backupDir . '/' . $filename;

try {
    // Verbindung aufbauen
    $conn = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
    
    if ($conn->connect_error) {
        throw new Exception("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }
    
    $backupSql = "-- Backup von {$db['database']} am {$date}\n";
    $backupSql .= "-- Host: {$db['host']}\n";
    $backupSql .= "-- Benutzer: {$db['user']}\n\n";
    
    $conn->set_charset("utf8");
    
    // Alle Tabellen abrufen
    $tablesResult = $conn->query("SHOW TABLES");
    if (!$tablesResult) {
        throw new Exception("Fehler beim Abrufen der Tabellen: " . $conn->error);
    }
    
    $tables = [];
    while ($row = $tablesResult->fetch_row()) {
        $tables[] = $row[0];
    }
    
    if (empty($tables)) {
        $backupSql .= "-- Keine Tabellen gefunden.\n";
    } else {
        // Jede Tabelle durchgehen
        foreach ($tables as $table) {
            $createTableResult = $conn->query("SHOW CREATE TABLE `$table`");
            if (!$createTableResult) {
                continue;
            }
            
            $createRow = $createTableResult->fetch_assoc();
            $backupSql .= "--\n-- Struktur für Tabelle `$table`\n--\n\n";
            $backupSql .= "DROP TABLE IF EXISTS `$table`;\n";
            $backupSql .= $createRow['Create Table'] . ";\n\n";
            
            $backupSql .= "--\n-- Daten für Tabelle `$table`\n--\n\n";
            
            $dataResult = $conn->query("SELECT * FROM `$table`");
            if ($dataResult) {
                while ($row = $dataResult->fetch_assoc()) {
                    $values = array_map(function($val) use ($conn) {
                        if ($val === null) return 'NULL';
                        return "'" . $conn->real_escape_string($val) . "'";
                    }, array_values($row));
                    $backupSql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
                }
            }
            
            $backupSql .= "\n";
        }
    }
    
    // Backup-Datei speichern
    file_put_contents($filepath, $backupSql);
    chmod($filepath, 0600);
    $conn->close();
    
    // Datei zum Download anbieten
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
    
} catch (Exception $e) {
    $_SESSION['message'] = t('error_backup_failed') . ' ' . $e->getMessage();
    $_SESSION['message_type'] = 'error';
    header('Location: dashboard.php');
    exit;
}

