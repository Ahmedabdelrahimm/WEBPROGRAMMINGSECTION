<?php
/**
 * WEEK 3 - USER MANAGEMENT
 * 
 * Admin page for managing users:
 * - View all users in a table
 * - Delete user account
 * 
 * Guard: Only admins can access.
 */

require '../backend/auth.php';
require '../backend/admin_db.php';

// Check if user is admin
if (!isAdmin()) {
    header("Location: ../frontend/login.php");
    exit;
}

// Initialize variables
$error = '';
$success = '';

// Get all users
$users = getAllUsers();

// Handle DELETE user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    // Prevent deleting the current admin user
    if ($_GET['delete'] == $_SESSION['user_id']) {
        $error = "You cannot delete your own account";
    } else {
        if (deleteUser($_GET['delete'])) {
            $success = "User deleted successfully!";
            $users = getAllUsers(); // Refresh the list
        } else {
            $error = "Failed to delete user";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="../frontend/style.css">
</head>
<body>
    <!-- HEADER / NAVIGATION -->
    <header class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <a href="index.php">DemoProject Admin</a>
            </div>
            <nav class="navbar-menu">
                <a href="index.php" class="nav-link">Dashboard</a>
                <a href="../frontend/index.php" class="nav-link">View Site</a>
                <a href="../frontend/logout.php" class="nav-link logout-btn">Logout</a>
            </nav>
        </div>
    </header>

    <!-- ADMIN LAYOUT -->
    <div class="admin-container">
        <!-- SIDEBAR NAVIGATION -->
        <aside class="admin-sidebar">
            <h3>Admin Menu</h3>
            <a href="index.php">Dashboard</a>
            <a href="manage_products.php">Products</a>
            <a href="manage_users.php" class="active">Users</a>
            <a href="manage_orders.php">Orders</a>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-content">
            <h1>User Management</h1>

            <!-- SUCCESS/ERROR MESSAGES -->
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- USERS TABLE -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h2>All Users</h2>

                <?php if (empty($users)): ?>
                    <p>No users found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span style="padding: 4px 8px; background-color: <?php echo $user['role'] === 'admin' ? '#e74c3c' : '#27ae60'; ?>; color: white; border-radius: 4px;">
                                            <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars(date('M d, Y', strtotime($user['created_at']))); ?></td>
                                    <td>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger" style="padding: 8px 12px; font-size: 14px;" onclick="return confirm('Are you sure? This cannot be undone.')">Delete</a>
                                        <?php else: ?>
                                            <span style="color: #999;">(Your Account)</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Demo Project - Admin</p>
        </div>
    </footer>
</body>
</html>
