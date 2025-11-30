<?php

function getDbConnection() {
    $host = '127.0.0.1';
    $db   = 'wall_db';
    $user = 'root';
    $pass = ''; 

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die('Подключение к БД не удалось: ' . $e->getMessage());
    }
}