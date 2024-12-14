<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .error {
            background-color: #ff6b6b;
            color: white;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }

        .password-requirements {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon input {
            padding-left: 35px;
        }

        .form-group .hint {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Create Account</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/inventory/auth/register">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required 
                       placeholder="Choose a username"
                       minlength="3">
                <div class="hint">Username must be at least 3 characters long</div>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required 
                       placeholder="Enter your email address">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required 
                       placeholder="Create a strong password"
                       minlength="6">
                <div class="password-requirements">
                    Password must be at least 6 characters long
                </div>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required 
                       placeholder="Confirm your password"
                       minlength="6">
            </div>
            
            <button type="submit">Create Account</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="/inventory/auth/login">Login</a></p>
        </div>
    </div>
</body>
</html> 