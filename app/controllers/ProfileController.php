<?php
class ProfileController extends Controller {
    private $userModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /inventory/auth/login');
            exit();
        }
        $this->userModel = new User();
    }

    public function index() {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $this->render('profile/index', ['user' => $user]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            
            if ($this->userModel->updateProfile($_SESSION['user_id'], $username, $email)) {
                $_SESSION['username'] = $username;
                header('Location: /inventory/profile');
                return;
            }
            
            $this->render('profile/index', ['error' => 'Update failed']);
            return;
        }
    }
}