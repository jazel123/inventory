<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-title {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 1.8em;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .dashboard-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.2em;
            margin-bottom: 15px;
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
            margin-top: 15px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .total-sales {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
            margin-top: 20px;
        }
        
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .chart-title {
            font-size: 1.1em;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Dashboard</h1>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-title">Total Products</div>
                <div class="stat-value"><?= $totalProducts ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">Today's Revenue</div>
                <div class="stat-value">₱<?= number_format($todaySales, 2) ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">Low Stock Items</div>
                <div class="stat-value"><?= count($lowStockProducts) ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">Critical Stock Items</div>
                <div class="stat-value">
                    <?= count(array_filter($lowStockProducts, fn($p) => $p['stocks'] < 5)) ?>
                </div>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="chart-container">
                <div class="chart-title">Sales Trend (Last 7 Days)</div>
                <canvas id="salesChart"></canvas>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">Stock Distribution</div>
                <canvas id="stockChart"></canvas>
            </div>
        </div>
        
        <div class="dashboard-section">
            <h2 class="section-title">Recent Sales</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Stocks Sold</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentSales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td><?= htmlspecialchars($sale['stocks']) ?></td>
                        <td>₱<?= number_format($sale['unit_price'], 2) ?></td>
                        <td>₱<?= number_format($sale['total'], 2) ?></td>
                        <td><?= htmlspecialchars($sale['sale_date']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total-sales">
                Total Sales: ₱<?= number_format($totalSales, 2) ?>
            </div>
        </div>
        
        <div class="dashboard-section">
            <h2 class="section-title">Stock Status</h2>
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

    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($dailySales, 'date')) ?>,
                datasets: [{
                    label: 'Daily Sales',
                    data: <?= json_encode(array_column($dailySales, 'total')) ?>,
                    borderColor: '#3498db',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(52, 152, 219, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Stock Chart
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'doughnut',
            data: {
                labels: ['Normal Stock', 'Low Stock', 'Critical Stock'],
                datasets: [{
                    data: [
                        <?= $totalProducts - count($lowStockProducts) ?>,
                        <?= count($lowStockProducts) - count(array_filter($lowStockProducts, fn($p) => $p['quantity'] < 5)) ?>,
                        <?= count(array_filter($lowStockProducts, fn($p) => $p['quantity'] < 5)) ?>
                    ],
                    backgroundColor: ['#2ecc71', '#f1c40f', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html> 