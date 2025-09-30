<?php 

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input
    $username = $sql->real_escape_string($username);
    $email = $sql->real_escape_string($email);
    $password = $sql->real_escape_string($password);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')");



    $success = false;
    $error_message = '';
    
    if ($sql->affected_rows > 0) {
        $success = true;
    } else {
        $error_message = $sql->error;
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Health Article</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('health1.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 35px;
            width: 350px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .signup-title {
            color: white;
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 18px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .form-input:focus {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
        }

        .signup-btn {
            width: 100%;
            padding: 18px;
            background: white;
            border: none;
            border-radius: 25px;
            color: #333;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 30px 0 25px 0;
        }

        .signup-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        .social-signup {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .login-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 25px;
        }

        .login-link a {
            color: white;
            text-decoration: underline;
            font-weight: 600;
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
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
    <div class="signup-container">
        <h1 class="signup-title">SIGN UP</h1>
        
        <form action="register.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-input" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <input type="email" class="form-input" name="email" placeholder="Email Address" required>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-input" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" name="submit" class="signup-btn">Sign up</button>
            
            <div class="social-signup">
                Sign up with Facebook or Google
            </div>
            
            <div class="login-link">
                Already have an account <a href="login.php">Sign In</a>
            </div>
            
            <div class="footer-text">
                created by #allcornerflex
            </div>
        </form>
    </div>

    <div class="corner-buttons">
        <div class="corner-btn">↗️</div>
        <div class="corner-btn">🔄</div>
    </div>

    <?php if (isset($success) && $success): ?>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'User registered successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'login.php';
        });
    </script>
    <?php elseif (isset($error_message) && !empty($error_message)): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Error: <?php echo $error_message; ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    <?php endif; ?>
</body>
</html>