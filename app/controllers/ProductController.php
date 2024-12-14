<?php
class ProductController extends Controller {
    private $model;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /inventory/auth/login');
            exit();
        }
        $this->model = new Product();
    }

    public function index() {
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        $products = $this->model->getAllProducts($categoryId);
        $categories = $this->model->getAllCategories();
        
        $this->render('products/index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $categoryId = $_POST['category_id'];
            $stocks = $_POST['stocks'];
            $price = $_POST['price'];
            
            // Handle image upload
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imageUrl = '/inventory/' . $uploadFile;
                }
            }
            
            $this->model->createProduct($name, $categoryId, $stocks, $price, $imageUrl);
            header('Location: /inventory/products');
            return;
        }
        
        $categories = $this->model->getAllCategories();
        $this->render('products/create', ['categories' => $categories]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $categoryId = $_POST['category_id'];
            $stocks = $_POST['stocks'];
            $price = $_POST['price'];
            
            // Handle image upload
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imageUrl = '/inventory/' . $uploadFile;
                    
                    // Delete old image if exists
                    $oldProduct = $this->model->getProductById($id);
                    if ($oldProduct && $oldProduct['image_url']) {
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/inventory' . $oldProduct['image_url'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }

            // Update the product
            $success = $this->model->updateProduct($id, $name, $categoryId, $stocks, $price, $imageUrl);
            
            if ($success) {
                header('Location: /inventory/products');
                exit;
            } else {
                // Handle error
                echo "Error updating product";
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'];
            
            $success = $this->model->deleteProduct($id);
            echo json_encode(['success' => $success]);
            return;
        }
    }

    public function edit($id = null) {
        if (!$id) {
            header('Location: /inventory/products');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $categoryId = $_POST['category_id'];
            $stocks = $_POST['stocks'];
            $price = $_POST['price'];
            
            // Handle image upload
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imageUrl = '/inventory/' . $uploadFile;
                    
                    // Delete old image if exists
                    $oldProduct = $this->model->getProductById($id);
                    if ($oldProduct && $oldProduct['image_url']) {
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/inventory' . $oldProduct['image_url'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }
            
            $this->model->updateProduct($id, $name, $categoryId, $stocks, $price, $imageUrl);
            header('Location: /inventory/products');
            return;
        }
        
        $product = $this->model->getProductById($id);
        if (!$product) {
            header('Location: /inventory/products');
            return;
        }
        
        $categories = $this->model->getAllCategories();
        $this->render('products/edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }
}