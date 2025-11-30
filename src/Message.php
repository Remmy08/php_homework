<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

class Message {
    private $db;

    public function __construct() {
        $this->db = getDbConnection();
    }

    public function create($user_id, $content) {
        $content = trim($content);
        if (empty($content)) return false;

        $stmt = $this->db->prepare("INSERT INTO messages (user_id, content) VALUES (?, ?)");
        return $stmt->execute([$user_id, $content]);
    }

    public function getAll() {
        $stmt = $this->db->query("
            SELECT m.*, u.name as author_name 
            FROM messages m 
            JOIN users u ON m.user_id = u.id 
            ORDER BY m.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.name as author_name 
            FROM messages m 
            JOIN users u ON m.user_id = u.id 
            WHERE m.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $user_id, $content) {
        $msg = $this->getById($id);
        if (!$msg || $msg['user_id'] != $user_id) return false;

        $created = new DateTime($msg['created_at']);
        $now = new DateTime();
        $diff = $now->diff($created)->h + ($now->diff($created)->days * 24);

        if ($diff > HOURS_TO_EDIT) {
            return false; 
        }

        $stmt = $this->db->prepare("UPDATE messages SET content = ? WHERE id = ?");
        return $stmt->execute([$content, $id]);
    }

    public function delete($id, $user_id) {
        $msg = $this->getById($id);
        if (!$msg || $msg['user_id'] != $user_id) return false;

        $created = new DateTime($msg['created_at']);
        $now = new DateTime();
        $diff = $now->diff($created)->h + ($now->diff($created)->days * 24);

        if ($diff > HOURS_TO_EDIT) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function canEditOrDelete($message) {
        if ($_SESSION['user_id'] != $message['user_id']) return false;

        $created = new DateTime($message['created_at']);
        $now = new DateTime();
        $hours = $now->diff($created)->h + ($now->diff($created)->days * 24);

        return $hours <= HOURS_TO_EDIT;
    }
}