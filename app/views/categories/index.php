<!DOCTYPE html>
<html>
<head>
    <title>Categories List</title>
</head>
<body>
    <div class="categories-container">
        <h1>Categories</h1>
        <a href="/inventory/categories/create" class="btn-add">Add New Category</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['id']) ?></td>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td><?= htmlspecialchars($category['description']) ?></td>
                    <td><?= htmlspecialchars($category['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>