<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
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
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .product-actions {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px; /* Same as image height */
            background: linear-gradient(to bottom, 
                rgba(255, 255, 255, 0.9), 
                rgba(255, 255, 255, 0.7));
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            transition: opacity 0.3s;
        }
        
        .product-card:hover .product-actions {
            opacity: 1;
        }
        
        .action-btn {
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: transform 0.2s, background 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .edit-btn {
            background: #ffc107;
            color: #000;
        }
        
        .edit-btn:hover {
            background: #ffcd39;
            transform: scale(1.05);
        }
        
        .delete-btn {
            background: #dc3545;
            color: #fff;
        }
        
        .delete-btn:hover {
            background: #e4606d;
            transform: scale(1.05);
        }
        
        /* Existing styles */
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .product-card h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .product-info {
            margin-bottom: 5px;
            color: #666;
        }
        
        .product-category {
            display: inline-block;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-section h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.8rem;
        }

        .add-button {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(46, 204, 113, 0.2);
        }

        .add-button:before {
            content: '+';
            margin-right: 8px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .add-button:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }

        .add-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(46, 204, 113, 0.2);
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .add-button {
                width: 100%;
                justify-content: center;
            }
        }

        .image-upload-container {
            margin-bottom: 1.5rem;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            background: #f8f9fa;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .image-preview.dragover {
            border-color: #2ecc71;
            background: rgba(46, 204, 113, 0.1);
        }

        .upload-label {
            display: inline-block;
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .upload-label:hover {
            background: #2980b9;
        }

        .upload-input {
            display: none;
        }

        .preview-text {
            color: #666;
            font-size: 0.9rem;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(231, 76, 60, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .image-preview:hover .remove-image {
            display: flex;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-save {
            background: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-cancel {
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn i {
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="products-container">
        <div class="header-section">
            <h1>Products</h1>
            <a href="/inventory/products/create" class="add-button">Add New Product</a>
        </div>
        
        <!-- Add Product Form -->
        <div id="addProductForm" style="display: none;" class="mt-3">
            <!-- <h2>Add New Product</h2> -->
            <form method="POST" action="/inventory/products/create" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Image</label>
                    <input type="file" name="image" class="form-control" required 
                           accept="image/*">
                    <small class="form-text text-muted">Upload a product image (JPG, PNG, or GIF)</small>
                </div>

                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" required 
                           placeholder="Enter product name">
                </div>
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Stocks</label>
                    <input type="number" name="stocks" class="form-control" required 
                           placeholder="Enter stock" min="0">
                </div>
                
                <div class="form-group">
                    <label>Price (Peso)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required 
                           placeholder="Enter price" min="0">
                </div>
                
                <button type="submit" class="btn btn-primary">Add Product</button>
                <button type="button" class="btn btn-secondary" onclick="toggleAddProductForm()">Cancel</button>
            </form>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Product</h2>
                    <button class="close-modal" onclick="closeModal()">&times;</button>
                </div>
                <form id="editForm" method="POST" action="/inventory/products/update" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="id">
                    
                    <div class="form-group">
                        <label for="editName">Product Name</label>
                        <input type="text" id="editName" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <select id="editCategory" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="editStocks">Stocks</label>
                        <input type="number" id="editStocks" name="stocks" class="form-control" required min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="editPrice">Price (Peso)</label>
                        <input type="number" id="editPrice" name="price" class="form-control" required min="0" step="0.01">
                    </div>

                    <div class="form-group image-upload-container">
                        <label>Product Image</label>
                        <div class="image-preview" id="imagePreview">
                            <span class="preview-text">No image selected</span>
                            <button type="button" class="remove-image" id="removeImage">&times;</button>
                        </div>
                        <label class="upload-label" for="editImage">
                            Choose Image
                        </label>
                        <input type="file" id="editImage" name="image" class="upload-input" accept="image/*">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-cancel" onclick="closeModal()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filters mt-3">
            <select id="categoryFilter" class="form-control" onchange="filterProducts(this.value)">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Products Grid -->
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="product-actions">
                    <button class="action-btn edit-btn" onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="action-btn delete-btn" onclick="confirmDelete(<?= htmlspecialchars($product['id']) ?>, '<?= htmlspecialchars($product['name']) ?>')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <div class="product-category"><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?></div>
                <div class="product-info">Stocks: <?= htmlspecialchars($product['stocks']) ?></div>
                <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="close-modal" onclick="closeDeleteModal()">&times;</button>
            </div>
            <p>Are you sure you want to delete <span id="deleteProductName"></span>?</p>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn btn-danger" onclick="executeDelete()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('editImage');
            const imagePreview = document.getElementById('imagePreview');
            const previewText = imagePreview ? imagePreview.querySelector('.preview-text') : null;
            const removeButton = document.getElementById('removeImage');
            const modal = document.getElementById('editModal');
            const closeBtn = document.querySelector('.close');

            function filterByCategory(categoryId) {
                window.location.href = categoryId 
                    ? '/inventory/products?category=' + categoryId
                    : '/inventory/products';
            }

            function editProduct(product) {
                if (!product) return;

                const form = document.getElementById('editForm');
                const productId = document.getElementById('editProductId');
                const name = document.getElementById('editName');
                const category = document.getElementById('editCategory');
                const stocks = document.getElementById('editStocks');
                const price = document.getElementById('editPrice');
                const imagePreview = document.getElementById('imagePreview');
                const previewText = imagePreview ? imagePreview.querySelector('.preview-text') : null;
                const removeButton = document.getElementById('removeImage');
                const modal = document.getElementById('editModal');

                if (!form || !productId || !name || !category || !stocks || !price || !modal) {
                    console.error('Required form elements not found');
                    return;
                }

                // Use the existing update route
                form.action = '/inventory/products/update';
                
                // Set form values
                productId.value = product.id;
                name.value = product.name;
                category.value = product.category_id;
                stocks.value = product.stocks;
                price.value = product.price;
                
                // Update image preview
                if (imagePreview && previewText) {
                    const existingImg = imagePreview.querySelector('img');
                    if (existingImg) {
                        existingImg.remove();
                    }
                    
                    if (product.image_url) {
                        previewText.style.display = 'none';
                        const img = document.createElement('img');
                        img.src = product.image_url;
                        imagePreview.appendChild(img);
                        if (removeButton) removeButton.style.display = 'flex';
                    } else {
                        previewText.style.display = 'block';
                        if (removeButton) removeButton.style.display = 'none';
                    }
                }
                
                modal.style.display = 'block';
            }

            function closeModal() {
                const modal = document.getElementById('editModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }

            function deleteProduct(productId) {
                if (confirm('Are you sure you want to delete this product?')) {
                    fetch('/inventory/products/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to delete product');
                        }
                    });
                }
            }

            // Image handling
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && imagePreview && previewText) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewText.style.display = 'none';
                            
                            const existingImg = imagePreview.querySelector('img');
                            if (existingImg) {
                                existingImg.remove();
                            }
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            imagePreview.appendChild(img);
                            if (removeButton) removeButton.style.display = 'flex';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Modal close handlers
            if (closeBtn) {
                closeBtn.onclick = function() {
                    if (modal) modal.style.display = 'none';
                }
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // Make functions globally available
            window.filterByCategory = filterByCategory;
            window.editProduct = editProduct;
            window.closeModal = closeModal;
            window.deleteProduct = deleteProduct;
        });
    </script>
</body>
</html>