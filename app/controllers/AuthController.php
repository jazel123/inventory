<?php
class AuthController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                $this->render('auth/login', ['error' => 'Please enter both username and password']);
                return;
            }

            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            if (empty($username) || empty($password)) {
                $this->render('auth/login', ['error' => 'Please enter both username and password']);
                return;
            }
            
            $user = $this->model->login($username, $password);
            
            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Debug information
                echo "User role: " . $user['role'] . "<br>";
                echo "Session role: " . $_SESSION['role'] . "<br>";
                
                // Redirect based on role
                if ($_SESSION['role'] === 'admin') {
                    header('Location: /inventory/dashboard');
                } else {
                    header('Location: /inventory/employees/dashboard');
                }
                exit();
            }
            
            $this->render('auth/login', ['error' => 'Invalid username or password']);
            return;
        }
        
        $this->render('auth/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if all required fields are present
            if (!isset($_POST['username']) || !isset($_POST['email']) || 
                !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
                $this->render('auth/register', ['error' => 'All fields are required']);
                return;
            }

            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validate empty fields
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $this->render('auth/register', ['error' => 'All fields are required']);
                return;
            }
            
            // Validate passwords match
            if ($password !== $confirmPassword) {
                $this->render('auth/register', ['error' => 'Passwords do not match']);
                return;
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->render('auth/register', ['error' => 'Invalid email format']);
                return;
            }
            
            // Register user as employee by default
            if ($this->model->register($username, $email, $password, 'employee')) {
                header('Location: /inventory/auth/login');
                exit();
            }
            
            $this->render('auth/register', ['error' => 'Registration failed']);
            return;
        }
        
        $this->render('auth/register');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /inventory/auth/login');
        exit();
    }
}
