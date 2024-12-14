<?php
class Router {
    private $routes = [];

    public function __construct() {
        // Existing routes
        $this->addRoute('GET', '/inventory/products', 'ProductController', 'index');
        $this->addRoute('GET', '/inventory/products/create', 'ProductController', 'create');
        $this->addRoute('POST', '/inventory/products/create', 'ProductController', 'create');
        $this->addRoute('GET', '/inventory/auth/login', 'AuthController', 'login');
        $this->addRoute('POST', '/inventory/auth/login', 'AuthController', 'login');
        $this->addRoute('GET', '/inventory/auth/register', 'AuthController', 'register');
        $this->addRoute('POST', '/inventory/auth/register', 'AuthController', 'register');
        $this->addRoute('GET', '/inventory/auth/logout', 'AuthController', 'logout');
        $this->addRoute('GET', '/inventory/reports/stock', 'ReportController', 'stock');
        $this->addRoute('GET', '/inventory/reports/sales', 'ReportController', 'sales');
        $this->addRoute('GET', '/inventory/profile', 'ProfileController', 'index');
        $this->addRoute('POST', '/inventory/profile/update', 'ProfileController', 'update');
        $this->addRoute('POST', '/inventory/categories/create', 'CategoryController', 'create');
        $this->addRoute('POST', '/inventory/products/update', 'ProductController', 'update');
        $this->addRoute('POST', '/inventory/products/delete', 'ProductController', 'delete');
        $this->addRoute('GET', '/inventory/employees', 'EmployeeController', 'index');
        $this->addRoute('GET', '/inventory/employees/create', 'EmployeeController', 'create');
        $this->addRoute('POST', '/inventory/employees/create', 'EmployeeController', 'create');
        $this->addRoute('GET', '/inventory/dashboard', 'DashboardController', 'index');

        // Add new employee routes
        $this->addRoute('GET', '/inventory/employees/dashboard', 'EmployeeController', 'dashboard');
        $this->addRoute('GET', '/inventory/employees/products', 'EmployeeController', 'products');
        $this->addRoute('GET', '/inventory/employees/sales', 'EmployeeController', 'sales');
    }

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $path) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $controller = new $route['controller']();
                $action = $route['action'];
                $controller->$action();
                return;
            }
        }
        
        // If no route matches, show 404 error
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
