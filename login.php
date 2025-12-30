<?php
session_start();
require_once __DIR__ . '/includes/lang.php';

// Prüfen ob bereits installiert
if (!file_exists(__DIR__ . '/config/auth.php')) {
    header('Location: install.php');
    exit;
}

// Prüfen ob bereits eingeloggt
require_once __DIR__ . '/includes/auth.php';
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$currentLang = getCurrentLanguage();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (login($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = t('invalid_credentials');
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('login'); ?> - <?php echo t('app_name'); ?></title>
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
                <i class="lock icon"></i>
                <?php echo t('login_title'); ?>
            </h1>
            
            <?php if ($error): ?>
                <div class="ui error message">
                    <div class="header"><?php echo t('error'); ?></div>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            
            <form class="ui form" method="POST">
                <div class="field">
                    <label><?php echo t('username'); ?></label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="<?php echo t('username_placeholder'); ?>" required autofocus>
                    </div>
                </div>
                
                <div class="field">
                    <label><?php echo t('password'); ?></label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="<?php echo t('password_placeholder'); ?>" required>
                    </div>
                </div>
                
                <button class="ui primary fluid large button" type="submit">
                    <i class="sign in icon"></i>
                    <?php echo t('sign_in'); ?>
                </button>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
</body>
</html>

