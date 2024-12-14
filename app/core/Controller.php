<?php
abstract class Controller {
    protected function checkRole($allowedRoles = ['admin']) {
        if (!isset($_SESSION['user'])) {
            header('Location: /inventory/auth/login');
            exit();
        }

        $userRole = $_SESSION['user']['role'];
        
        if (!in_array($userRole, $allowedRoles)) {
            header('Location: /inventory/' . 
                  ($userRole === 'admin' ? 'dashboard' : 'employees/dashboard'));
            exit();
        }
    }

    protected function render($view, $data = []) {
        // Get the sales model for common data
        $salesModel = new Sales();
        $productModel = new Product();
        
        // Get products with low stock
        $products = $productModel->getAllProducts();
        $lowStockProducts = array_filter($products, function($product) {
            return $product['stocks'] < 10;
        });
        
        // Add common data for all views
        $commonData = [
            'todaySales' => $salesModel->getTodaySales(),
            'lowStockCount' => count($lowStockProducts),
            'criticalStockCount' => count(array_filter($lowStockProducts, function($p) {
                return $p['stocks'] < 5;
            }))
        ];
        
        // Merge common data with view-specific data
        $data = array_merge($data, $commonData);
        
        // Extract data to make variables available in view
        extract($data);
        
        // Start output buffering
        ob_start();
        require_once __DIR__ . "/../views/$view.php";
        $content = ob_get_clean();
        
        require_once __DIR__ . "/../views/layouts/app.php";
    }
}
