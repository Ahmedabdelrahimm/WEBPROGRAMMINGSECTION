<?php
/**
 * WEEK 3 - USER PROFILE PAGE
 * 
 * This page displays and allows editing of the logged-in user's profile.
 * Shows: name, email
 * Allows updating: name, email, password
 * 
 * Guard: Redirects to login if user is not logged in.
 */

require '../backend/auth.php';
require '../backend/user_db.php';

// Check if user is logged in
// If not, redirect to login page
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Initialize variables
$error = '';
$success = '';
$user = getUserById($_SESSION['user_id']);

// Check if form was submitted
if ($_POST) {
    // Get form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validate: name and email must be provided
    if (empty($name) || empty($email)) {
        $error = "Name and email are required";
    }
    // If password is provided, check that both passwords match
    elseif (!empty($password) && $password !== $confirm_password) {
        $error = "Passwords do not match";
    }
    else {
        // Try to update the user
        if (updateUser($_SESSION['user_id'], $name, $email, $password)) {
            // Update successful! Refresh user data in session
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $user = getUserById($_SESSION['user_id']);
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Demo Project</title>
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
                <a href="products.php" class="nav-link">Products</a>
                <a href="profile.php" class="nav-link active">Profile</a>
                <a href="logout.php" class="nav-link logout-btn">Logout</a>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="form-container">
            <div class="form-card">
                <h1>My Profile</h1>

                <!-- Display success message -->
                <?php if ($success): ?>
                    <div class="success-message">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <!-- Display error message -->
                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- USER INFO FORM -->
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password (leave blank to keep current)</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password or leave blank">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>

                <!-- USER ROLE INFO -->
                <div class="user-info">
                    <p><strong>Account Type:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
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
