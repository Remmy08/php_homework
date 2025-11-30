<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Стена сообщений</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <?php if (isLoggedIn()): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Стена сообщений</h1>
            <div>
                Привет, <?= h($_SESSION['user_name']) ?>!
                <a href="index.php?page=logout" class="btn btn-outline-danger btn-sm ms-3">Выйти</a>
            </div>
        </div>
    <?php endif; ?>