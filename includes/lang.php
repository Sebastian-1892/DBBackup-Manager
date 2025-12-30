<?php
/**
 * Sprachverwaltungssystem
 */

// Verfügbare Sprachen
define('AVAILABLE_LANGUAGES', [
    'de' => ['name' => 'Deutsch', 'flag' => '🇩🇪'],
    'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
    'it' => ['name' => 'Italiano', 'flag' => '🇮🇹'],
    'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
    'en' => ['name' => 'English', 'flag' => '🇬🇧']
]);

// Standardsprache
define('DEFAULT_LANGUAGE', 'de');

// Sprachdateien-Verzeichnis
define('LANG_DIR', __DIR__ . '/../lang');

// Aktuelle Sprache aus Session oder Browser ermitteln
function getCurrentLanguage() {
    if (isset($_SESSION['language']) && isset(AVAILABLE_LANGUAGES[$_SESSION['language']])) {
        return $_SESSION['language'];
    }
    
    // Browser-Sprache ermitteln
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (isset(AVAILABLE_LANGUAGES[$browserLang])) {
            return $browserLang;
        }
    }
    
    return DEFAULT_LANGUAGE;
}

// Sprache setzen
function setLanguage($lang) {
    if (isset(AVAILABLE_LANGUAGES[$lang])) {
        $_SESSION['language'] = $lang;
        return true;
    }
    return false;
}

// Übersetzungen laden
$translations = [];
function loadTranslations($lang = null) {
    global $translations;
    
    if ($lang === null) {
        $lang = getCurrentLanguage();
    }
    
    $langFile = LANG_DIR . '/' . $lang . '.php';
    if (file_exists($langFile)) {
        $translations = include $langFile;
    } else {
        // Fallback auf Standardsprache
        $langFile = LANG_DIR . '/' . DEFAULT_LANGUAGE . '.php';
        if (file_exists($langFile)) {
            $translations = include $langFile;
        }
    }
}

// Übersetzungsfunktion
function t($key, $default = null) {
    global $translations;
    
    if (empty($translations)) {
        loadTranslations();
    }
    
    if (isset($translations[$key])) {
        return $translations[$key];
    }
    
    return $default !== null ? $default : $key;
}

// Übersetzungen beim ersten Laden initialisieren
if (session_status() === PHP_SESSION_ACTIVE || !headers_sent()) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    loadTranslations();
}

