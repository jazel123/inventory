<!DOCTYPE html>
<html>
<head>
    <title>Profile Settings</title>
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .profile-header {
            margin-bottom: 30px;
        }
        
        .profile-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .profile-section {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 36px;
            color: #6c757d;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        
        .form-hint {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-1px);
        }
        
        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Profile Settings</h1>
        </div>
        
        <div class="profile-section">
            <div class="profile-avatar">
                <?= strtoupper(substr($user['username'], 0, 1)) ?>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="/inventory/profile/update">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" 
                           class="form-control" 
                           name="username" 
                           value="<?= htmlspecialchars($user['username']) ?>" 
                           required>
                    <div class="form-hint">This is your display name</div>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           value="<?= htmlspecialchars($user['email']) ?>" 
                           required>
                    <div class="form-hint">We'll never share your email with anyone else</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>