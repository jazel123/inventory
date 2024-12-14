<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        .report-container {
            padding: 20px;
        }
        
        .report-header {
            margin-bottom: 30px;
        }
        
        .report-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .report-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
        }
        
        .summary-title {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        
        .summary-value {
            font-size: 1.8em;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .report-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-critical {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .status-warning {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #2c3e50;
        }
        
        tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1>Stock Report</h1>
        </div>
        
        <div class="report-summary">
            <div class="summary-card">
                <div class="summary-title">Total Products</div>
                <div class="summary-value"><?= count($products) ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-title">Low Stock Items</div>
                <div class="summary-value"><?= count($lowStockProducts) ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-title">Critical Stock Items</div>
                <div class="summary-value">
                    <?= count(array_filter($lowStockProducts, fn($p) => $p['stocks'] < 5)) ?>
                </div>
            </div>
        </div>
        
        <div class="report-section">
            <h2 class="section-title">Low Stock Products (Less than 10 units)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Current Stocks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowStockProducts as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['stocks']) ?></td>
                        <td>
                            <?php if ($product['stocks'] < 5): ?>
                                <span class="status-badge status-critical">Critical</span>
                            <?php else: ?>
                                <span class="status-badge status-warning">Low</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>