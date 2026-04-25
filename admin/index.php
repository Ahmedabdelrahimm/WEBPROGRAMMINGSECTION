<?php
/**
 * WEEK 3 - ADMIN DASHBOARD
 * 
 * This page displays the admin dashboard with summary statistics:
 * - Total number of users
 * - Total number of products
 * - Total number of orders
 * 
 * Guard: Only admins can access. Redirects to login if not admin.
 */

require '../backend/auth.php';
require '../backend/admin_db.php';

// Check if user is admin
// If not, redirect to login page
if (!isAdmin()) {
    header("Location: ../frontend/login.php");
    exit;
}

// Get statistics for the dashboard
$users = getAllUsers();
$products = getAllProducts();
$orders = getAllOrders();

// Count totals
$total_users = count($users);
$total_products = count($products);
$total_orders = count($orders);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Demo Project</title>
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
                <a href="index.php" class="nav-link active">Dashboard</a>
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
            <a href="index.php" class="active">Dashboard</a>
            <a href="manage_products.php">Products</a>
            <a href="manage_users.php">Users</a>
            <a href="manage_orders.php">Orders</a>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-content">
            <h1>Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

            <!-- STATISTICS CARDS -->
            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
                
                <!-- TOTAL USERS CARD -->
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="color: #3498db;">Total Users</h3>
                    <p style="font-size: 32px; color: #3498db; font-weight: bold;"><?php echo $total_users; ?></p>
                    <a href="manage_users.php" style="color: #3498db;">Manage Users →</a>
                </div>

                <!-- TOTAL PRODUCTS CARD -->
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="color: #27ae60;">Total Products</h3>
                    <p style="font-size: 32px; color: #27ae60; font-weight: bold;"><?php echo $total_products; ?></p>
                    <a href="manage_products.php" style="color: #27ae60;">Manage Products →</a>
                </div>

                <!-- TOTAL ORDERS CARD -->
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <h3 style="color: #e74c3c;">Total Orders</h3>
                    <p style="font-size: 32px; color: #e74c3c; font-weight: bold;"><?php echo $total_orders; ?></p>
                    <a href="manage_orders.php" style="color: #e74c3c;">Manage Orders →</a>
                </div>

            </div>

            <!-- QUICK ACTIONS -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 20px 0;">
                <h2>Quick Actions</h2>
                <p>
                    <a href="manage_products.php" class="btn btn-primary" style="margin-right: 10px;">Add Product</a>
                    <a href="manage_users.php" class="btn btn-secondary">View Users</a>
                </p>
            </div>
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Demo Project - Admin Dashboard</p>
        </div>
    </footer>
</body>
</html>
