<?php
/**
 * WEEK 3 - ADMIN DATABASE FUNCTIONS
 * 
 * This file contains all CRUD (Create, Read, Update, Delete) functions for admin management:
 * 
 * PRODUCTS:
 *   - getAllProducts() - Get all products
 *   - addProduct($name, $description, $price, $image_url) - Add new product
 *   - updateProduct($id, $name, $description, $price, $image_url) - Update product
 *   - deleteProduct($id) - Delete product
 * 
 * USERS:
 *   - getAllUsers() - Get all users
 *   - deleteUser($id) - Delete user
 * 
 * ORDERS:
 *   - getAllOrders() - Get all orders with user and product details
 *   - updateOrderStatus($id, $status) - Change order status
 * 
 * Use these functions in admin pages to manage all data.
 */

// Make database connection available in this file
require 'db.php';

// ===== PRODUCT FUNCTIONS =====

/**
 * GET ALL PRODUCTS
 * 
 * @return array - Array of all products
 */
function getAllProducts() {
    global $connection;
    
    $query = "SELECT id, name, description, price, image_url FROM products ORDER BY id";
    $result = mysqli_query($connection, $query);
    $products = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}

/**
 * ADD PRODUCT
 * 
 * @param string $name - Product name
 * @param string $description - Product description
 * @param float $price - Product price
 * @param string $image_url - Product image URL
 * @return bool - TRUE if successful, FALSE if failed
 */
function addProduct($name, $description, $price, $image_url) {
    global $connection;
    
    // Sanitize all inputs
    $name = mysqli_real_escape_string($connection, $name);
    $description = mysqli_real_escape_string($connection, $description);
    $price = mysqli_real_escape_string($connection, $price);
    $image_url = mysqli_real_escape_string($connection, $image_url);
    
    // INSERT new product into products table
    $query = "INSERT INTO products (name, description, price, image_url) VALUES ('$name', '$description', '$price', '$image_url')";
    
    return mysqli_query($connection, $query);
}

/**
 * UPDATE PRODUCT
 * 
 * @param int $id - Product ID
 * @param string $name - New product name
 * @param string $description - New product description
 * @param float $price - New product price
 * @param string $image_url - New product image URL
 * @return bool - TRUE if successful, FALSE if failed
 */
function updateProduct($id, $name, $description, $price, $image_url) {
    global $connection;
    
    // Sanitize all inputs
    $id = mysqli_real_escape_string($connection, $id);
    $name = mysqli_real_escape_string($connection, $name);
    $description = mysqli_real_escape_string($connection, $description);
    $price = mysqli_real_escape_string($connection, $price);
    $image_url = mysqli_real_escape_string($connection, $image_url);
    
    // UPDATE product where ID matches
    $query = "UPDATE products SET name = '$name', description = '$description', price = '$price', image_url = '$image_url' WHERE id = '$id'";
    
    return mysqli_query($connection, $query);
}

/**
 * DELETE PRODUCT
 * 
 * @param int $id - Product ID to delete
 * @return bool - TRUE if successful, FALSE if failed
 */
function deleteProduct($id) {
    global $connection;
    
    $id = mysqli_real_escape_string($connection, $id);
    
    // DELETE product where ID matches
    $query = "DELETE FROM products WHERE id = '$id'";
    
    return mysqli_query($connection, $query);
}

// ===== USER FUNCTIONS =====

/**
 * GET ALL USERS
 * 
 * @return array - Array of all users
 */
function getAllUsers() {
    global $connection;
    
    $query = "SELECT id, name, email, role, created_at FROM users ORDER BY id";
    $result = mysqli_query($connection, $query);
    $users = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    
    return $users;
}

/**
 * DELETE USER
 * 
 * @param int $id - User ID to delete
 * @return bool - TRUE if successful, FALSE if failed
 */
function deleteUser($id) {
    global $connection;
    
    $id = mysqli_real_escape_string($connection, $id);
    
    // DELETE user where ID matches
    $query = "DELETE FROM users WHERE id = '$id'";
    
    return mysqli_query($connection, $query);
}

// ===== ORDER FUNCTIONS =====

/**
 * GET ALL ORDERS
 * 
 * @return array - Array of all orders with user and product details
 */
function getAllOrders() {
    global $connection;
    
    // SELECT orders with user names and product names
    // JOIN users to get user name
    // JOIN products to get product name
    $query = "SELECT 
                o.id, 
                o.user_id, 
                u.name as user_name,
                o.product_id,
                p.name as product_name,
                o.quantity,
                o.status,
                o.created_at
              FROM orders o
              JOIN users u ON o.user_id = u.id
              JOIN products p ON o.product_id = p.id
              ORDER BY o.id DESC";
    
    $result = mysqli_query($connection, $query);
    $orders = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    
    return $orders;
}

/**
 * UPDATE ORDER STATUS
 * 
 * @param int $id - Order ID to update
 * @param string $status - New status (pending, completed, cancelled)
 * @return bool - TRUE if successful, FALSE if failed
 */
function updateOrderStatus($id, $status) {
    global $connection;
    
    $id = mysqli_real_escape_string($connection, $id);
    $status = mysqli_real_escape_string($connection, $status);
    
    // UPDATE order status where ID matches
    $query = "UPDATE orders SET status = '$status' WHERE id = '$id'";
    
    return mysqli_query($connection, $query);
}

?>
