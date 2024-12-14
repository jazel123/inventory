<!DOCTYPE html>
<html>
<head>
    <title>Login - Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f6fa;
            font-family: 'Roboto', sans-serif;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .form-group input::placeholder {
            color: #a0aec0;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background-color: #fff5f5;
            color: #c53030;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #feb2b2;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #4a5568;
            font-size: 14px;
        }

        .register-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .input-icon {
            position: relative;
        }

        .input-icon input {
            padding-left: 40px;
        }

        .input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Welcome Back</h1>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/inventory/auth/login">
            <div class="form-group">
                <label>Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" required 
                           placeholder="Enter your username"
                           minlength="3"
                           pattern="[a-zA-Z0-9]+"
                           title="Username can only contain letters and numbers">
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" required 
                           placeholder="Enter your password"
                           minlength="6">
                </div>
            </div>
            
            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="register-link">
            <p>Don't have an account? <a href="/inventory/auth/register">Create Account</a></p>
        </div>
    </div>
</body>
</html> 