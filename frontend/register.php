<?php
require '../backend/auth.php';

// Initialize variables
$error = '';
$success = '';

// Check if form was submitted
if ($_POST) {
    // Get form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validate: passwords must match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    }
    // Validate: all fields must be filled
    elseif (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    }
    else {
        // Try to register the user
        if (registerUser($name, $email, $password)) {
            // Registration successful! Now log them in automatically
            loginUser($email, $password);
            // Redirect to products page
            header("Location: products.php");
            exit;
        } else {
            // Registration failed (usually email already exists)
            $error = "Email already exists. Please use a different email or login.";
        }
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
    <title>Register - Demo Project</title>
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
                <a href="login.php" class="nav-link">Login</a>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="form-container">
            <div class="form-card">
                <h1>Create Account</h1>

                <!-- Display error message if registration failed -->
                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- REGISTRATION FORM -->
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter a password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>

                <p class="form-footer">
                    Already have an account? <a href="login.php">Login here</a>
                </p>
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
