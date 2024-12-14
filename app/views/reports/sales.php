<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        .report-container {
            padding: 20px;
        }
        
        .report-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <div class="report-container">
        <h1>Sales Report</h1>
        
        <div class="report-section">
            <h2>Recent Sales</h2>
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
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td><?= htmlspecialchars($sale['quantity']) ?></td>
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
    </div>
</body>
</html> 