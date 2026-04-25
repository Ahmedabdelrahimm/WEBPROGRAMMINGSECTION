<?php
/**
 * WEEK 2 - LOGIN PAGE
 * 
 * This page displays a login form and handles user login.
 * When user submits the form, it calls loginUser() from auth.php
 * If successful, redirects to products page. If failed, shows error message.
 */

require '../backend/auth.php';

// Initialize error message variable
$error = '';

// Check if form was submitted (check if $_POST array contains data)
if ($_POST) {
    // Get email and password from the form
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Call loginUser() to authenticate
    if (loginUser($email, $password)) {
        // Login successful! Check if user is admin
        if (isAdmin()) {
            // Redirect admin to admin dashboard
            header("Location: ../admin/index.php");
        } else {
            // Redirect regular user to products page
            header("Location: products.php");
        }
        exit;
    } else {
        // Login failed - set error message to display to user
        $error = "Invalid email or password";
    }
}

// If already logged in, redirect to products page
if (isLoggedIn()) {
    header("Location: products.php");
    exit;
}
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

                <!-- LOGIN FORM -->
                <form method="POST">
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
