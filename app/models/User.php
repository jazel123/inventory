<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($username, $email, $password, $role = 'employee') {
        try {
            $hashedPassword = hash('sha256', $password);
            
            $stmt = $this->db->prepare(
                "INSERT INTO users (username, email, password, role) 
                 VALUES (?, ?, ?, ?)"
            );
            return $stmt->execute([$username, $email, $hashedPassword, $role]);
        } catch (PDOException $e) {
            // Log error if needed
            return false;
        }
    }

    public function login($username, $password) {
        try {
            $hashedPassword = hash('sha256', $password);
            
            $stmt = $this->db->prepare(
                "SELECT id, username, email, password, role 
                 FROM users 
                 WHERE username = ? 
                 AND password = ?"
            );
            $stmt->execute([$username, $hashedPassword]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Debug information
                var_dump($user);
                return $user;
            }
            
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $username, $email) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $id]);
    }
}
