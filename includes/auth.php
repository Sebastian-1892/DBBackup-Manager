<?php
/**
 * Authentifizierungs-Funktionen
 */

function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function login($username, $password) {
    $authFile = __DIR__ . '/../config/auth.php';
    if (!file_exists($authFile)) {
        return false;
    }
    
    $auth = include $authFile;
    if (password_verify($password, $auth['password_hash'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

function logout() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

