<?php
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/Message.php';

$auth = new Auth();
$message = new Message();

$page = $_GET['page'] ?? 'wall';

if (!isLoggedIn() && !in_array($page, ['login', 'register'])) {
    redirect('index.php?page=login');
}

switch ($page) {
    case 'login':
        require __DIR__ . '/../templates/login.php';
        break;
    case 'register':
        require __DIR__ . '/../templates/register.php';
        break;
    case 'logout':
        $auth->logout();
        redirect('index.php?page=login');
        break;
    case 'wall':
    default:
        requireLogin();
        require __DIR__ . '/../templates/wall.php';
        break;
}