<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
</head>
<body>
    <div class="card">
        <h1>Add New Employee</h1>
        
        <form method="POST" action="/inventory/employees/create">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required 
                       placeholder="Enter employee name">
            </div>
            
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" required 
                       placeholder="Enter position">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required 
                       placeholder="Enter email">
            </div>
            
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" required 
                       placeholder="Enter phone number">
            </div>
            
            <button type="submit" class="btn btn-primary">Add Employee</button>
            <a href="/inventory/employees" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html> 