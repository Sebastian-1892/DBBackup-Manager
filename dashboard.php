<?php
session_start();
require_once __DIR__ . '/includes/lang.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();
require_once __DIR__ . '/includes/config.php';

$currentLang = getCurrentLanguage();
$databases = getDatabases();
$message = '';
$messageType = '';

// Nachrichten aus Session holen
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'] ?? 'success';
    unset($_SESSION['message'], $_SESSION['message_type']);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('dashboard'); ?> - <?php echo t('app_name'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="ui stackable grid">
                <div class="ten wide column">
                    <h1 class="ui header">
                        <i class="database icon"></i>
                        <div class="content">
                            <?php echo t('app_name'); ?>
                            <div class="sub header"><?php echo t('manage_backups'); ?></div>
                        </div>
                    </h1>
                </div>
                <div class="three wide column right aligned">
                    <div class="language-selector-wrapper">
                        <?php include __DIR__ . '/includes/language_selector.php'; ?>
                    </div>
                </div>
                <div class="three wide column right aligned">
                    <a href="logout.php" class="ui red button">
                        <i class="sign out icon"></i>
                        <?php echo t('logout'); ?>
                    </a>
                </div>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="ui <?php echo $messageType; ?> message">
                <i class="close icon"></i>
                <div class="header"><?php echo $messageType === 'success' ? t('success') : t('error'); ?></div>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="ui stackable grid">
            <div class="sixteen wide column">
                <div class="ui clearing segment">
                    <h2 class="ui left floated header">
                        <i class="server icon"></i>
                        <?php echo t('databases'); ?>
                    </h2>
                    <button class="ui right floated primary button" onclick="$('#add-db-modal').modal('show')">
                        <i class="plus icon"></i>
                        <?php echo t('add_database'); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <?php if (empty($databases)): ?>
            <div class="ui placeholder segment">
                <div class="ui icon header">
                    <i class="database icon"></i>
                    <?php echo t('no_databases'); ?>
                </div>
                <button class="ui primary button" onclick="$('#add-db-modal').modal('show')">
                    <?php echo t('add_first_database'); ?>
                </button>
            </div>
        <?php else: ?>
            <div class="database-list">
                <?php foreach ($databases as $db): ?>
                    <div class="database-list-item">
                        <div class="database-info">
                            <div class="database-header">
                                <h3 class="database-name">
                                    <i class="server icon"></i>
                                    <?php echo htmlspecialchars($db['name']); ?>
                                </h3>
                                <span class="database-meta"><?php echo htmlspecialchars($db['database']); ?></span>
                            </div>
                            <div class="database-details">
                                <div class="detail-item">
                                    <i class="server icon"></i>
                                    <span class="detail-label"><?php echo t('host'); ?>:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($db['host']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="user icon"></i>
                                    <span class="detail-label"><?php echo t('user'); ?>:</span>
                                    <span class="detail-value"><?php echo htmlspecialchars($db['user']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="lock icon"></i>
                                    <span class="detail-label"><?php echo t('password'); ?>:</span>
                                    <span class="detail-value password-display"><?php echo str_repeat('*', strlen($db['password'])); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="database-actions">
                            <button class="ui blue button" onclick="editDatabase('<?php echo htmlspecialchars($db['id']); ?>')">
                                <i class="edit icon"></i>
                                <?php echo t('edit'); ?>
                            </button>
                            <button class="ui green button" onclick="createBackup('<?php echo htmlspecialchars($db['id']); ?>')">
                                <i class="download icon"></i>
                                <?php echo t('backup'); ?>
                            </button>
                            <button class="ui red button" onclick="deleteDatabase('<?php echo htmlspecialchars($db['id']); ?>')">
                                <i class="trash icon"></i>
                                <?php echo t('delete'); ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal: Datenbank hinzufügen -->
    <div class="ui modal" id="add-db-modal">
        <i class="close icon"></i>
        <div class="header">
            <i class="plus icon"></i>
            <?php echo t('add_database_title'); ?>
        </div>
        <div class="content">
            <form class="ui form" id="add-db-form" method="POST" action="db_action.php">
                <input type="hidden" name="action" value="add">
                <div class="field">
                    <label><?php echo t('db_host'); ?></label>
                    <input type="text" name="host" placeholder="<?php echo t('db_host_placeholder'); ?>" required>
                </div>
                <div class="ui two fields">
                    <div class="field">
                        <label><?php echo t('username'); ?></label>
                        <input type="text" name="user" placeholder="<?php echo t('username_placeholder'); ?>" required>
                    </div>
                    <div class="field">
                        <label><?php echo t('password'); ?></label>
                        <input type="password" name="password" placeholder="<?php echo t('password_placeholder'); ?>">
                    </div>
                </div>
                <div class="ui two fields">
                    <div class="field">
                        <label><?php echo t('db_database'); ?></label>
                        <input type="text" name="database" placeholder="<?php echo t('db_database'); ?>" required>
                    </div>
                    <div class="field">
                        <label><?php echo t('db_name'); ?></label>
                        <input type="text" name="name" placeholder="<?php echo t('db_name_placeholder'); ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <div class="ui cancel button"><?php echo t('cancel'); ?></div>
            <button class="ui primary button" onclick="$('#add-db-form').submit()">
                <i class="checkmark icon"></i>
                <?php echo t('add'); ?>
            </button>
        </div>
    </div>
    
    <!-- Modal: Datenbank bearbeiten -->
    <div class="ui modal" id="edit-db-modal">
        <i class="close icon"></i>
        <div class="header">
            <i class="edit icon"></i>
            <?php echo t('edit_database_title'); ?>
        </div>
        <div class="content">
            <form class="ui form" id="edit-db-form" method="POST" action="db_action.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit-db-id">
                <div class="field">
                    <label><?php echo t('db_host'); ?></label>
                    <input type="text" name="host" id="edit-db-host" required>
                </div>
                <div class="ui two fields">
                    <div class="field">
                        <label><?php echo t('username'); ?></label>
                        <input type="text" name="user" id="edit-db-user" required>
                    </div>
                    <div class="field">
                        <label><?php echo t('password'); ?></label>
                        <input type="password" name="password" id="edit-db-password" placeholder="<?php echo t('password_keep_empty'); ?>">
                    </div>
                </div>
                <div class="ui two fields">
                    <div class="field">
                        <label><?php echo t('db_database'); ?></label>
                        <input type="text" name="database" id="edit-db-database" required>
                    </div>
                    <div class="field">
                        <label><?php echo t('db_name'); ?></label>
                        <input type="text" name="name" id="edit-db-name">
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <div class="ui cancel button"><?php echo t('cancel'); ?></div>
            <button class="ui primary button" onclick="$('#edit-db-form').submit()">
                <i class="checkmark icon"></i>
                <?php echo t('save'); ?>
            </button>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <script>
        $('.ui.modal').modal();
        $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
        });
        
        function editDatabase(id) {
            // Datenbank-Daten laden
            fetch('db_action.php?action=get&id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#edit-db-id').val(data.db.id);
                        $('#edit-db-host').val(data.db.host);
                        $('#edit-db-user').val(data.db.user);
                        $('#edit-db-database').val(data.db.database);
                        $('#edit-db-name').val(data.db.name);
                        $('#edit-db-password').val('');
                        $('#edit-db-modal').modal('show');
                    }
                });
        }
        
        function createBackup(id) {
            if (confirm('<?php echo t('confirm_backup'); ?>')) {
                window.location.href = 'backup.php?id=' + id;
            }
        }
        
        function deleteDatabase(id) {
            if (confirm('<?php echo t('confirm_delete'); ?>')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'db_action.php';
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = id;
                form.appendChild(actionInput);
                form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>

