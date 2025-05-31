<?php

$ordner = __DIR__; // aktueller Ordner
if (is_writable($ordner)) {
    echo "✅ Ordner ist beschreibbar.";
} else {
    echo "❌ Ordner ist NICHT beschreibbar.";
}

// Konfiguration
$host     = 'localhost';
$user     = 'user';
$password = 'password';
$database = 'datenbank';

// Backup-Dateiname
$date     = date('Y-m-d_H-i-s');
$filename = "backup_{$database}_{$date}.sql";

// Verbindung aufbauen
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$backupSql = "-- Backup von {$database} am {$date}\n\n";
$conn->set_charset("utf8");

// Alle Tabellen abrufen
$tablesResult = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $tablesResult->fetch_row()) {
    $tables[] = $row[0];
}

// Jede Tabelle durchgehen
foreach ($tables as $table) {
    $createTableResult = $conn->query("SHOW CREATE TABLE `$table`");
    $createRow = $createTableResult->fetch_assoc();
    $backupSql .= "--\n-- Struktur für Tabelle `$table`\n--\n\n";
    $backupSql .= "DROP TABLE IF EXISTS `$table`;\n";
    $backupSql .= $createRow['Create Table'] . ";\n\n";

    $backupSql .= "--\n-- Daten für Tabelle `$table`\n--\n\n";

    $dataResult = $conn->query("SELECT * FROM `$table`");
    while ($row = $dataResult->fetch_assoc()) {
        $values = array_map(function($val) use ($conn) {
            if ($val === null) return 'NULL';
            return "'" . $conn->real_escape_string($val) . "'";
        }, array_values($row));
        $backupSql .= "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
    }

    $backupSql .= "\n";
}

// Backup-Datei speichern
file_put_contents($filename, $backupSql);
$conn->close();

echo "Backup erfolgreich erstellt: <a href='$filename'>$filename</a>";
