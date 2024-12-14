<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts($categoryId = null) {
        if ($categoryId) {
            $stmt = $this->db->prepare("
                SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ?
            ");
            $stmt->execute([$categoryId]);
        } else {
            $stmt = $this->db->query("
                SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id
            ");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $categoryId, $stocks, $price, $imageUrl = null) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, category_id, stocks, price, image_url) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $categoryId, $stocks, $price, $imageUrl]);
    }

    public function updateProduct($id, $name, $categoryId, $stocks, $price, $imageUrl = null) {
        try {
            if ($imageUrl !== null) {
                $stmt = $this->db->prepare("
                    UPDATE products 
                    SET name = ?, 
                        category_id = ?, 
                        stocks = ?, 
                        price = ?, 
                        image_url = ? 
                    WHERE id = ?
                ");
                return $stmt->execute([$name, $categoryId, $stocks, $price, $imageUrl, $id]);
            } else {
                $stmt = $this->db->prepare("
                    UPDATE products 
                    SET name = ?, 
                        category_id = ?, 
                        stocks = ?, 
                        price = ?
                    WHERE id = ?
                ");
                return $stmt->execute([$name, $categoryId, $stocks, $price, $id]);
            }
        } catch (PDOException $e) {
            // Log error
            error_log("Error updating product: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM products p 
            JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 