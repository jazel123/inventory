<?php
class Employee {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllEmployees() {
        $stmt = $this->db->query("SELECT * FROM employees ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmployee($name, $position, $email, $phone) {
        $stmt = $this->db->prepare(
            "INSERT INTO employees (name, position, email, phone) 
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$name, $position, $email, $phone]);
    }

    public function getUserByCredentials($email, $password) {
        $stmt = $this->db->prepare("
            SELECT id, name, email, position, role, password
            FROM employees 
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Don't store password in session
            return $user;
        }
        return false;
    }

    public function isAdmin($userId) {
        $stmt = $this->db->prepare("
            SELECT role FROM employees WHERE id = ?
        ");
        $stmt->execute([$userId]);
        $role = $stmt->fetchColumn();
        return $role === 'admin';
    }

    public function registerEmployee($name, $email, $password) {
        try {
            // Check if email already exists
            $stmt = $this->db->prepare("SELECT id FROM employees WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return false; // Email already exists
            }

            // Insert new employee
            $stmt = $this->db->prepare("
                INSERT INTO employees (name, email, password, role, position) 
                VALUES (?, ?, ?, 'employee', 'Staff')
            ");
            return $stmt->execute([$name, $email, $password]);
        } catch (PDOException $e) {
            // Log error if needed
            return false;
        }
    }
} 