<?php
spl_autoload_register(function ($class) {
    // Define the directories to look in
    $directories = [
        'app/core/',
        'app/controllers/',
        'app/models/'
    ];

    // Loop through directories
    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();

// Define routes
$router->addRoute('GET', '/products', 'ProductController', 'index');
$router->addRoute('GET', '/products/create', 'ProductController', 'create');
$router->addRoute('POST', '/products/create', 'ProductController', 'create');
$router->addRoute('GET', '/auth/login', 'AuthController', 'login');
$router->addRoute('POST', '/auth/login', 'AuthController', 'login');
$router->addRoute('GET', '/auth/register', 'AuthController', 'register');
$router->addRoute('POST', '/auth/register', 'AuthController', 'register');
$router->addRoute('GET', '/auth/logout', 'AuthController', 'logout');
$router->addRoute('GET', '/reports/stock', 'ReportController', 'stock');
$router->addRoute('GET', '/reports/sales', 'ReportController', 'sales');
$router->addRoute('GET', '/profile', 'ProfileController', 'index');
$router->addRoute('POST', '/profile/update', 'ProfileController', 'update');
$router->addRoute('POST', '/categories/create', 'CategoryController', 'create');
$router->addRoute('POST', '/products/update', 'ProductController', 'update');
$router->addRoute('POST', '/products/delete', 'ProductController', 'delete');
$router->addRoute('GET', '/employees', 'EmployeeController', 'index');
$router->addRoute('GET', '/employees/create', 'EmployeeController', 'create');
$router->addRoute('POST', '/employees/create', 'EmployeeController', 'create');
$router->addRoute('GET', '/dashboard', 'DashboardController', 'index');

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
