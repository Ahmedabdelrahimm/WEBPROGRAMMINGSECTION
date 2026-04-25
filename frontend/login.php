<?php
/**
 * LOGIN PAGE - GATEWAY
 * 
 * This page displays the login form.
 * Form submissions are handled by backend/login_handler.php
 */

require '../backend/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isAdmin()) {
        header("Location: ../admin/index.php");
    } else {
        header("Location: products.php");
    }
    exit;
}

// Get error message from session if exists
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Demo Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- HEADER / NAVIGATION -->
    <header class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <a href="index.php">DemoProject</a>
            </div>
            <nav class="navbar-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="register.php" class="nav-link">Register</a>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="form-container">
            <div class="form-card">
                <h1>Login</h1>
                
                <!-- Display error message if login failed -->
                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- LOGIN FORM - Posts to backend handler -->
                <form method="POST" action="../backend/login_handler.php">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <p class="form-footer">
                    Don't have an account? <a href="register.php">Register here</a>
                </p>

                <!-- DEMO CREDENTIALS -->
                <div class="demo-info">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Email: <code>john@demo.com</code></p>
                    <p>Password: <code>user123</code></p>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Demo Project</p>
        </div>
    </footer>
</body>
</html>
