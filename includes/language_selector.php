<?php
/**
 * Sprachauswahl-Komponente
 */
require_once __DIR__ . '/lang.php';
$currentLang = getCurrentLanguage();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="ui compact menu language-selector">
    <div class="ui simple dropdown item">
        <i class="world icon"></i>
        <span class="hide-mobile"><?php echo AVAILABLE_LANGUAGES[$currentLang]['flag']; ?> <?php echo t('language'); ?></span>
        <span class="show-mobile"><?php echo AVAILABLE_LANGUAGES[$currentLang]['flag']; ?></span>
        <i class="dropdown icon"></i>
        <div class="menu">
            <?php foreach (AVAILABLE_LANGUAGES as $code => $lang): ?>
                <a class="item <?php echo $code === $currentLang ? 'active' : ''; ?>" 
                   href="language.php?lang=<?php echo $code; ?>&redirect=<?php echo urlencode($currentPage); ?>">
                    <?php echo $lang['flag']; ?> <?php echo $lang['name']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    if (typeof $ !== 'undefined') {
        $('.language-selector .dropdown').dropdown();
    }
});
</script>

