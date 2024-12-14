<?php
class DashboardController extends Controller {
    private $productModel;
    private $salesModel;

    public function __construct() {
        session_start();
        $this->checkRole(['admin']);
        $this->productModel = new Product();
        $this->salesModel = new Sales();
    }

    public function index() {
        // Get low stock products (less than 10 units)
        $products = $this->productModel->getAllProducts();
        $lowStockProducts = array_filter($products, function($product) {
            return $product['stocks'] < 10;
        });

        // Get recent sales
        $recentSales = $this->salesModel->getRecentSales(5);

        // Get total sales for today
        $todaySales = $this->salesModel->getTodaySales();

        // Get total products
        $totalProducts = count($products);

        // Get total sales
        $totalSales = $this->salesModel->getTotalSales();

        // Get daily sales for the last 7 days
        $dailySales = $this->salesModel->getDailySales(7);

        $this->render('dashboard/index', [
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
            'todaySales' => $todaySales,
            'totalProducts' => $totalProducts,
            'totalSales' => $totalSales,
            'dailySales' => $dailySales
        ]);
    }
} 