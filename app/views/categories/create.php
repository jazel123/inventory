<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <div class="form-container">
        <h1>Add New Category</h1>
        
        <form method="POST" action="/inventory/categories/create">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Add Category</button>
        </form>
    </div>
</body>
</html>