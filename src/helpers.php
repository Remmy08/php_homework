<?php
session_start();

const HOURS_TO_EDIT = 1; 

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('/public/index.php?page=login');
    }
}