<?php
class ReportController extends Controller {
    private $productModel;
    private $salesModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /inventory/auth/login');
            exit();
        }
        $this->productModel = new Product();
        $this->salesModel = new Sales();
    }

    public function stock() {
        $products = $this->productModel->getAllProducts();
        $lowStockProducts = array_filter($products, function($product) {
            return $product['stocks'] < 10;
        });
        
        $this->render('reports/stock', [
            'products' => $products,
            'lowStockProducts' => $lowStockProducts
        ]);
    }

    public function sales() {
        $sales = $this->salesModel->getSalesReport();
        $dailySales = $this->salesModel->getDailySales();
        
        $totalSales = array_reduce($sales, function($carry, $sale) {
            return $carry + ($sale['stocks'] * $sale['price']);
        }, 0);
        
        $this->render('reports/sales', [
            'sales' => $sales,
            'dailySales' => $dailySales,
            'totalSales' => $totalSales
        ]);
    }
}