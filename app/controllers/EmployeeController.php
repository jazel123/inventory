<?php
class EmployeeController extends Controller {
    private $model;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /inventory/auth/login');
            exit();
        }
        $this->model = new Employee();
    }

    public function index() {
        $this->checkRole(['admin']);
        $employees = $this->model->getAllEmployees();
        $this->render('employees/index', ['employees' => $employees]);
    }

    public function dashboard() {
        $this->checkRole(['employee']);
        
        // Get sales model
        $salesModel = new Sales();
        
        // Get today's statistics
        $todaySales = $salesModel->getTodaySalesByEmployee($_SESSION['user_id']);
        $productsSoldToday = $salesModel->getProductsSoldTodayByEmployee($_SESSION['user_id']);
        $transactionsToday = $salesModel->getTransactionsTodayByEmployee($_SESSION['user_id']);
        
        // Get recent activities
        $recentActivities = $salesModel->getRecentActivitiesByEmployee($_SESSION['user_id'], 5);
        
        $this->render('employees/dashboard', [
            'todaySales' => $todaySales,
            'productsSoldToday' => $productsSoldToday,
            'transactionsToday' => $transactionsToday,
            'recentActivities' => $recentActivities
        ]);
    }

    public function products() {
        $productModel = new Product();
        $products = $productModel->getAllProducts();
        $categories = $productModel->getAllCategories();
        
        $this->render('employees/products', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
} 