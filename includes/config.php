<?php
/**
 * Konfigurations-Verwaltung
 */

function getDatabases() {
    $configFile = __DIR__ . '/../config/databases.php';
    if (!file_exists($configFile)) {
        return [];
    }
    return include $configFile;
}

function saveDatabases($databases) {
    $configDir = __DIR__ . '/../config';
    if (!is_dir($configDir)) {
        mkdir($configDir, 0700, true);
    }
    
    $configFile = $configDir . '/databases.php';
    $content = "<?php\nreturn " . var_export($databases, true) . ";\n";
    file_put_contents($configFile, $content);
    chmod($configFile, 0600);
}

function addDatabase($dbData) {
    $databases = getDatabases();
    $id = uniqid('db_', true);
    $databases[$id] = [
        'id' => $id,
        'host' => $dbData['host'],
        'user' => $dbData['user'],
        'password' => $dbData['password'],
        'database' => $dbData['database'],
        'name' => $dbData['name'] ?? $dbData['database']
    ];
    saveDatabases($databases);
    return $id;
}

function updateDatabase($id, $dbData) {
    $databases = getDatabases();
    if (isset($databases[$id])) {
        $databases[$id] = array_merge($databases[$id], [
            'host' => $dbData['host'],
            'user' => $dbData['user'],
            'password' => $dbData['password'],
            'database' => $dbData['database'],
            'name' => $dbData['name'] ?? $dbData['database']
        ]);
        saveDatabases($databases);
        return true;
    }
    return false;
}

function deleteDatabase($id) {
    $databases = getDatabases();
    if (isset($databases[$id])) {
        unset($databases[$id]);
        saveDatabases($databases);
        return true;
    }
    return false;
}

function getDatabase($id) {
    $databases = getDatabases();
    return $databases[$id] ?? null;
}

