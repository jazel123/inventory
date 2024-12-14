<!DOCTYPE html>
<html>
<head>
    <title>Product Inventory</title>
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .product-category {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        
        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }
        
        .stock-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-normal {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .status-low {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-critical {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .product-price {
            font-size: 1.1em;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .filters {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .filter-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .search-box {
            flex: 1;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Product Inventory</h1>
        
        <div class="filters">
            <div class="filter-group">
                <div class="search-box">
                    <input type="text" 
                           class="form-control" 
                           placeholder="Search products..."
                           id="searchInput"
                           onkeyup="filterProducts()">
                </div>
                <select class="form-control" 
                        onchange="filterByCategory(this.value)">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="product-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?= htmlspecialchars($product['category_id']) ?>">
                <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="product-category">
                    <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                </div>
                <div class="product-info">
                    <div>
                        <span class="stock-status <?php 
                            if ($product['stocks'] < 5) echo 'status-critical';
                            else if ($product['stocks'] < 10) echo 'status-low';
                            else echo 'status-normal';
                        ?>">
                            Stock: <?= htmlspecialchars($product['stocks']) ?>
                        </span>
                    </div>
                    <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function filterProducts() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const name = product.querySelector('.product-name').textContent.toLowerCase();
                const category = product.querySelector('.product-category').textContent.toLowerCase();
                
                if (name.includes(filter) || category.includes(filter)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        function filterByCategory(categoryId) {
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                if (!categoryId || product.dataset.category === categoryId) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html> 