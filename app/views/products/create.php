<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
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
    </style>
</head>
<body>
    <div class="card">
        <h1 class="card-title">Add New Product</h1>
        
        <form method="POST" action="/inventory/products/create" enctype="multipart/form-data">
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
                       placeholder="Enter stocks" min="0">
                <div class="form-hint">Enter the initial stock quantity</div>
            </div>
            
            <div class="form-group">
                <label>Price (Peso)</label>
                <div class="input-group">
                    <input type="number" step="0.01" name="price" class="form-control" required 
                           placeholder="Enter price" min="0">
                </div>
            </div>

            <div class="form-group image-upload-container">
                <label>Product Image</label>
                <div class="image-preview" id="imagePreview">
                    <span class="preview-text">No image selected</span>
                    <button type="button" class="remove-image" id="removeImage">&times;</button>
                </div>
                <label class="upload-label" for="productImage">
                    Choose Image
                </label>
                <input type="file" id="productImage" name="image" class="upload-input" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Add Product</button>
        </form>
    </div>

    <script>
        // Image preview functionality
        const imageInput = document.getElementById('productImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewText = imagePreview.querySelector('.preview-text');
        const removeButton = document.getElementById('removeImage');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewText.style.display = 'none';
                    
                    // Remove existing preview if any
                    const existingImg = imagePreview.querySelector('img');
                    if (existingImg) {
                        existingImg.remove();
                    }
                    
                    // Create new preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreview.appendChild(img);
                    removeButton.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            }
        });

        // Remove image functionality
        removeButton.addEventListener('click', function(e) {
            e.preventDefault();
            imageInput.value = '';
            const img = imagePreview.querySelector('img');
            if (img) {
                img.remove();
            }
            previewText.style.display = 'block';
            this.style.display = 'none';
        });

        // Drag and drop functionality
        imagePreview.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        imagePreview.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        imagePreview.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                imageInput.files = e.dataTransfer.files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        });
    </script>
</body>
</html>