<?php
/**
 * WEEK 3 - PRODUCT MANAGEMENT
 * 
 * Admin page for full CRUD operations on products:
 * - View all products in a table
 * - Add new product
 * - Edit existing product
 * - Delete product
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
$edit_id = null;
$edit_product = null;

// Get all products
$products = getAllProducts();

// Handle DELETE product
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (deleteProduct($_GET['delete'])) {
        $success = "Product deleted successfully!";
        $products = getAllProducts(); // Refresh the list
    } else {
        $error = "Failed to delete product";
    }
}

// Check if we're in edit mode
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    // Find the product to edit
    foreach ($products as $product) {
        if ($product['id'] == $edit_id) {
            $edit_product = $product;
            break;
        }
    }
}

// Handle ADD or UPDATE product
if ($_POST) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

    // Validate inputs
    if (empty($name) || empty($price)) {
        $error = "Name and price are required";
    }
    elseif (!is_numeric($price)) {
        $error = "Price must be a number";
    }
    else {
        // Add or update
        if (empty($product_id)) {
            // ADD new product
            if (addProduct($name, $description, $price, $image_url)) {
                $success = "Product added successfully!";
                $edit_id = null;
                $edit_product = null;
                $products = getAllProducts();
            } else {
                $error = "Failed to add product";
            }
        } else {
            // UPDATE existing product
            if (updateProduct($product_id, $name, $description, $price, $image_url)) {
                $success = "Product updated successfully!";
                $edit_id = null;
                $edit_product = null;
                $products = getAllProducts();
            } else {
                $error = "Failed to update product";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
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
            <a href="manage_products.php" class="active">Products</a>
            <a href="manage_users.php">Users</a>
            <a href="manage_orders.php">Orders</a>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-content">
            <h1>Product Management</h1>

            <!-- SUCCESS/ERROR MESSAGES -->
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- ADD/EDIT FORM -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h2><?php echo $edit_id ? 'Edit Product' : 'Add New Product'; ?></h2>
                
                <form method="POST">
                    <?php if ($edit_id): ?>
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($edit_id); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" required value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4"><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($)</label>
                        <input type="number" id="price" name="price" step="0.01" required value="<?php echo $edit_product ? htmlspecialchars($edit_product['price']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="image_url">Image URL</label>
                        <input type="text" id="image_url" name="image_url" value="<?php echo $edit_product ? htmlspecialchars($edit_product['image_url']) : ''; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary"><?php echo $edit_id ? 'Update Product' : 'Add Product'; ?></button>
                    <?php if ($edit_id): ?>
                        <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- PRODUCTS TABLE -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h2>All Products</h2>

                <?php if (empty($products)): ?>
                    <p>No products found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?></td>
                                    <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                                    <td>
                                        <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-secondary" style="padding: 8px 12px; font-size: 14px;">Edit</a>
                                        <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-danger" style="padding: 8px 12px; font-size: 14px;" onclick="return confirm('Are you sure?')">Delete</a>
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
