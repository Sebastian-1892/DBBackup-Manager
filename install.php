<?php
session_start();
require_once __DIR__ . '/includes/lang.php';

// Prüfen ob bereits installiert
if (file_exists(__DIR__ . '/config/auth.php')) {
    header('Location: index.php');
    exit;
}

$currentLang = getCurrentLanguage();
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'] ?? '';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPassword = $_POST['db_password'] ?? '';
    $dbDatabase = $_POST['db_database'] ?? '';
    $dbName = $_POST['db_name'] ?? $dbDatabase;
    
    $adminUser = $_POST['admin_user'] ?? '';
    $adminPassword = $_POST['admin_password'] ?? '';
    $adminPasswordConfirm = $_POST['admin_password_confirm'] ?? '';
    
    // Validierung
    if (empty($dbHost) || empty($dbUser) || empty($dbDatabase)) {
        $error = t('error_fill_all_db_fields');
    } elseif (empty($adminUser) || empty($adminPassword)) {
        $error = t('error_fill_admin_fields');
    } elseif ($adminPassword !== $adminPasswordConfirm) {
        $error = t('error_passwords_not_match');
    } elseif (strlen($adminPassword) < 6) {
        $error = t('error_password_too_short');
    } else {
        // Config-Verzeichnis erstellen
        $configDir = __DIR__ . '/config';
        if (!is_dir($configDir)) {
            mkdir($configDir, 0700, true);
        }
        
        // Auth-Daten speichern
        $authFile = $configDir . '/auth.php';
        $authContent = "<?php\nreturn [\n";
        $authContent .= "    'username' => " . var_export($adminUser, true) . ",\n";
        $authContent .= "    'password_hash' => " . var_export(password_hash($adminPassword, PASSWORD_DEFAULT), true) . ",\n";
        $authContent .= "];\n";
        file_put_contents($authFile, $authContent);
        chmod($authFile, 0600);
        
        // Erste Datenbank speichern
        require_once __DIR__ . '/includes/config.php';
        addDatabase([
            'host' => $dbHost,
            'user' => $dbUser,
            'password' => $dbPassword,
            'database' => $dbDatabase,
            'name' => $dbName
        ]);
        
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('installation'); ?> - <?php echo t('app_name'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="ui raised very padded text container segment">
            <div class="language-selector-wrapper">
                <?php include __DIR__ . '/includes/language_selector.php'; ?>
            </div>
            <h1 class="ui center aligned header">
                <i class="database icon"></i>
                <?php echo t('app_name'); ?> - <?php echo t('installation'); ?>
            </h1>
            
            <?php if ($success): ?>
                <div class="ui success message">
                    <div class="header"><?php echo t('installation_success'); ?></div>
                    <p><?php echo t('installation_success_msg'); ?></p>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>
            <?php else: ?>
                <?php if ($error): ?>
                    <div class="ui error message">
                        <div class="header"><?php echo t('error'); ?></div>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>
                
                <form class="ui form" method="POST">
                    <h2 class="ui dividing header">
                        <i class="server icon"></i>
                        <?php echo t('db_connection'); ?>
                    </h2>
                    
                    <div class="field">
                        <label><?php echo t('db_host'); ?></label>
                        <input type="text" name="db_host" placeholder="<?php echo t('db_host_placeholder'); ?>" value="<?php echo htmlspecialchars($_POST['db_host'] ?? 'localhost'); ?>" required>
                    </div>
                    
                    <div class="ui two fields">
                        <div class="field">
                            <label><?php echo t('db_user'); ?></label>
                            <input type="text" name="db_user" placeholder="<?php echo t('username_placeholder'); ?>" value="<?php echo htmlspecialchars($_POST['db_user'] ?? ''); ?>" required>
                        </div>
                        <div class="field">
                            <label><?php echo t('db_password'); ?></label>
                            <input type="password" name="db_password" placeholder="<?php echo t('password_placeholder'); ?>" value="<?php echo htmlspecialchars($_POST['db_password'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="ui two fields">
                        <div class="field">
                            <label><?php echo t('db_database'); ?></label>
                            <input type="text" name="db_database" placeholder="<?php echo t('db_database'); ?>" value="<?php echo htmlspecialchars($_POST['db_database'] ?? ''); ?>" required>
                        </div>
                        <div class="field">
                            <label><?php echo t('db_name'); ?></label>
                            <input type="text" name="db_name" placeholder="<?php echo t('db_name_placeholder'); ?>" value="<?php echo htmlspecialchars($_POST['db_name'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <h2 class="ui dividing header">
                        <i class="lock icon"></i>
                        <?php echo t('admin_credentials'); ?>
                    </h2>
                    
                    <div class="field">
                        <label><?php echo t('admin_user'); ?></label>
                        <input type="text" name="admin_user" placeholder="<?php echo t('admin_user'); ?>" value="<?php echo htmlspecialchars($_POST['admin_user'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="ui two fields">
                        <div class="field">
                            <label><?php echo t('admin_password'); ?></label>
                            <input type="password" name="admin_password" placeholder="<?php echo t('admin_password_placeholder'); ?>" required>
                        </div>
                        <div class="field">
                            <label><?php echo t('admin_password_confirm'); ?></label>
                            <input type="password" name="admin_password_confirm" placeholder="<?php echo t('admin_password_confirm_placeholder'); ?>" required>
                        </div>
                    </div>
                    
                    <button class="ui primary fluid large button" type="submit">
                        <i class="checkmark icon"></i>
                        <?php echo t('start_installation'); ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
</body>
</html>

