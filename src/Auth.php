<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = getDbConnection();
    }

    public function register($name, $email, $password, $password_confirm) {
        if ($password !== $password_confirm) {
            return 'Пароли не совпадают';
        }

        if (strlen($password) < 6) {
            return 'Пароль должен быть не менее 6 символов';
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return 'Email уже занят';
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);

        return true;
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return 'Неверный email или пароль';
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function getCurrentUser() {
        if (!isLoggedIn()) return null;
        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
}