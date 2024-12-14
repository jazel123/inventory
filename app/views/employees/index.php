<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
    <style>
        .employee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .employee-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .employee-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .employee-position {
            color: #666;
            margin-bottom: 10px;
        }
        
        .employee-contact {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Employees</h1>
        
        <div class="action-buttons">
            <a href="/inventory/employees/create" class="btn btn-primary">Add New Employee</a>
        </div>

        <div class="employee-grid">
            <?php foreach ($employees as $employee): ?>
            <div class="employee-card">
                <div class="employee-name"><?= htmlspecialchars($employee['name']) ?></div>
                <div class="employee-position"><?= htmlspecialchars($employee['position']) ?></div>
                <div class="employee-contact">
                    <div>Email: <?= htmlspecialchars($employee['email']) ?></div>
                    <div>Phone: <?= htmlspecialchars($employee['phone']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 