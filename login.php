<?php 

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize input
    $username = $sql->real_escape_string($username);
    $password = $sql->real_escape_string($password);

    // Check if user exists
    $result = $sql->query("SELECT * FROM users WHERE username = '$username'");

    $login_success = false;
    $error_message = '';
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $login_success = true;
        } else {
            $error_message = 'Invalid password!';
        }
    } else {
        $error_message = 'User not found!';
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Health Article</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('health2.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px 35px;
            width: 350px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 45px 15px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-input:focus {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #8BC34A;
        }

        .remember-me label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #8BC34A, #689F38);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #7CB342, #558B2F);
            transform: translateY(-1px);
        }

        .signup-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .signup-link a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            margin-top: 25px;
        }

        .corner-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .corner-btn {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .corner-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Login</h1>
        <p class="login-subtitle">Welcome back please login to your account</p>
        
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-input" name="username" placeholder="User Name" required>
                <span class="input-icon">👤</span>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-input" name="password" placeholder="Password" required>
                <span class="input-icon">👁️</span>
            </div>
            
            <div class="remember-me">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
            
            <div class="signup-link">
                Don't have an account? <a href="register.php">Signup</a>
            </div>
            
            <div class="footer-text">
                Created by originalspire
            </div>
        </form>
    </div>

    <div class="corner-buttons">
        <div class="corner-btn">↗️</div>
        <div class="corner-btn">🔄</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($login_success) && $login_success): ?>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Login successful!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'watchpage.php';
        });
    </script>
    <?php elseif (isset($error_message) && !empty($error_message)): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo $error_message; ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    <?php endif; ?>
</body>
</html>