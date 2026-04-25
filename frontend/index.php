<?php
/**
 * WEEK 1 - HOMEPAGE SKELETON
 * 
 * This is the main landing page that users see when they visit the site.
 * It displays the header, hero section, and footer.
 * 
 * Week 4: Will add CSS styling and make it responsive.
 */

require '../backend/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Demo Project</title>
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
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to Our Demo Project</h1>
                <p>A teaching project to learn PHP, MySQL, and Web Development</p>
                <?php if (!isLoggedIn()): ?>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                <?php else: ?>
                    <a href="products.php" class="btn btn-primary">Browse Products</a>
                <?php endif; ?>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section class="features">
            <div class="container">
                <h2>Features</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>User Authentication</h3>
                        <p>Secure login and registration system with password hashing</p>
                    </div>
                    <div class="feature-card">
                        <h3>Product Catalog</h3>
                        <p>Browse and view detailed product information</p>
                    </div>
                    <div class="feature-card">
                        <h3>User Profiles</h3>
                        <p>Manage your personal information and account settings</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Demo Project. Built for teaching PHP &amp; Web Development.</p>
            <p>Made with ❤️ for University Students</p>
        </div>
    </footer>
</body>
</html>
