<?php
class Sales {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSalesReport() {
        $stmt = $this->db->query("
            SELECT 
                p.name as product_name,
                s.stocks,
                s.price as unit_price,
                s.sale_date,
                (s.stocks * s.price) as total
            FROM sales s
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDailySales($days = 7) {
        $stmt = $this->db->prepare("
            SELECT 
                DATE(s.sale_date) as date,
                SUM(s.stocks * p.price) as total
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE s.sale_date >= DATE_SUB(CURRENT_DATE, INTERVAL ? DAY)
            GROUP BY DATE(s.sale_date)
            ORDER BY date ASC
        ");
        $stmt->bindValue(1, $days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentSales($limit) {
        $stmt = $this->db->prepare("
            SELECT 
                s.id,
                p.name as product_name,
                s.stocks,
                p.price as unit_price,
                (s.stocks * p.price) as total,
                s.sale_date
            FROM sales s
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodaySales() {
        $stmt = $this->db->prepare("
            SELECT SUM(s.stocks * p.price) as total
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE DATE(s.sale_date) = CURRENT_DATE
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalSales() {
        $stmt = $this->db->prepare("
            SELECT SUM(s.stocks * p.price) as total
            FROM sales s
            JOIN products p ON s.product_id = p.id
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTodaySalesByEmployee($employeeId) {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(total), 0) as total 
            FROM sales 
            WHERE employee_id = ? 
            AND DATE(sale_date) = CURDATE()
        ");
        $stmt->execute([$employeeId]);
        return $stmt->fetchColumn();
    }

    public function getProductsSoldTodayByEmployee($employeeId) {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(stocks), 0) as total 
            FROM sales 
            WHERE employee_id = ? 
            AND DATE(sale_date) = CURDATE()
        ");
        $stmt->execute([$employeeId]);
        return $stmt->fetchColumn();
    }

    public function getTransactionsTodayByEmployee($employeeId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM sales 
            WHERE employee_id = ? 
            AND DATE(sale_date) = CURDATE()
        ");
        $stmt->execute([$employeeId]);
        return $stmt->fetchColumn();
    }

    public function getRecentActivitiesByEmployee($employeeId, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT 
                s.sale_date as timestamp,
                CONCAT('Sold ', s.stocks, ' ', p.name, ' for ₱', s.total) as description
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE s.employee_id = ?
            ORDER BY s.sale_date DESC
            LIMIT ?
        ");
        $stmt->execute([$employeeId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 