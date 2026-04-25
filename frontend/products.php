<?php
/**
 * WEEK 2 - PRODUCTS PAGE
 * 
 * This page displays all products in a grid layout.
 * It fetches products from the database using getAllProducts() function.
 * Users can view product details: name, description, price.
 */

require '../backend/auth.php';
require '../backend/products_db.php';

// Get all products from the database
$products = getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Demo Project</title>
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
                <a href="products.php" class="nav-link active">Products</a>
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php" class="nav-link">Profile</a>
                    <a href="logout.php" class="nav-link logout-btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Login</a>
                    <a href="register.php" class="nav-link register-btn">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <div class="container">
            <h1>Our Products</h1>

            <!-- PRODUCTS GRID -->
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <?php if (!empty($product['image_url'])): ?>
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-body">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="product-price">$<?php echo htmlspecialchars($product['price']); ?></p>
                            <a href="#" class="btn btn-secondary">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- If no products exist -->
            <?php if (empty($products)): ?>
                <p>No products available at this time.</p>
            <?php endif; ?>
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
