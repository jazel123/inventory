[
    'method' => 'GET',
    'path' => '/inventory/products',
    'controller' => 'ProductsController',
    'action' => 'index'
]

$routes[] = [
    'method' => 'POST',
    'path' => '/inventory/products/edit/{id}',
    'controller' => 'ProductController',
    'action' => 'edit'
];

// Employee routes
$routes[] = [
    'method' => 'GET',
    'path' => '/inventory/employees/dashboard',
    'controller' => 'EmployeeController',
    'action' => 'dashboard'
];

$routes[] = [
    'method' => 'GET',
    'path' => '/inventory/employees/products',
    'controller' => 'EmployeeController',
    'action' => 'products'
];

$routes[] = [
    'method' => 'GET',
    'path' => '/inventory/employees/sales',
    'controller' => 'EmployeeController',
    'action' => 'sales'
]; 