<?php
class CategoryController extends Controller {
    private $model;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /inventory/auth/login');
            exit();
        }
        $this->model = new Category();
    }

    public function index() {
        $categories = $this->model->getAllCategories();
        $this->render('categories/index', ['categories' => $categories]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $this->model->createCategory($name, $description);
            header('Location: /inventory/categories');
            return;
        }
        
        $this->render('categories/create');
    }
}
