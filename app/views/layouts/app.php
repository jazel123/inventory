<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Inventory System' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
        }

        .content {
            flex: 1;
            padding: 30px;
            margin-left: 250px;
        }

        .content-full {
            flex: 1;
            padding: 30px;
            margin-left: 0;
        }

        .welcome-text {
            padding: 15px;
            font-size: 18px;
            margin-bottom: 30px;
            color: white;
        }

        .section-header {
            color: #95a5a6;
            font-size: 14px;
            text-transform: uppercase;
            margin: 20px 0 10px;
            padding-left: 15px;
        }

        .menu-item {
            display: block;
            padding: 12px 15px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #34495e;
        }

        .menu-item.active {
            background-color: #3498db;
        }

        /* Enhanced Input Fields */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .form-hint {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            padding-left: 35px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
        }

        /* Mini Dashboard Styles */
        .mini-dashboard {
            background: #34495e;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .mini-dashboard:hover {
            transform: translateY(-2px);
        }

        .mini-stat {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mini-stat:last-child {
            border-bottom: none;
        }

        .mini-stat-title {
            color: #95a5a6;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .mini-stat-value {
            color: white;
            font-size: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php 
        // Get the current route
        $currentRoute = $_SERVER['REQUEST_URI'];
        
        // Check if we're on login or register page
        $isAuthPage = strpos($currentRoute, '/auth/login') !== false || 
                     strpos($currentRoute, '/auth/register') !== false;
        
        // Only show sidebar if not on auth pages
        if (!$isAuthPage): 
        ?>
            <div class="sidebar">
                <div class="welcome-text">
                    Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </div>
                
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <!-- Admin Menu -->
                    <div class="section-header">MENU</div>
                    <a href="/inventory/dashboard" class="menu-item">Dashboard</a>
                    
                    <div class="section-header">PRODUCTS</div>
                    <a href="/inventory/products" class="menu-item">Products</a>
                    
                    <div class="section-header">EMPLOYEES</div>
                    <a href="/inventory/employees" class="menu-item">Manage Employees</a>
                    
                    <div class="section-header">REPORTS</div>
                    <a href="/inventory/reports/stock" class="menu-item">Stock Report</a>
                    <a href="/inventory/reports/sales" class="menu-item">Sales Report</a>
                <?php else: ?>
                    <!-- Employee Menu -->
                    <div class="section-header">MENU</div>
                    <a href="/inventory/employees/dashboard" class="menu-item">Dashboard</a>
                    <a href="/inventory/employees/products" class="menu-item">View Products</a>
                    <a href="/inventory/employees/sales" class="menu-item">My Sales</a>
                <?php endif; ?>
                
                <div class="section-header">SETTINGS</div>
                <a href="/inventory/profile" class="menu-item">Profile</a>
                <a href="/inventory/auth/logout" class="menu-item">Logout</a>
            </div>
        <?php endif; ?>
        
        <div class="<?= $isAuthPage ? 'content-full' : 'content' ?>">
            <?= $content ?>
        </div>
    </div>
</body>
</html> 