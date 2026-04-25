<?php
/**
 * WEEK 2 - PRODUCT DATABASE FUNCTIONS
 * 
 * This file contains functions for retrieving product data from the database.
 * - getAllProducts() - Get all products
 * - getProductById($id) - Get a single product by ID
 * 
 * Use these functions in frontend pages to display product information.
 */

// Make database connection available in this file
require 'db.php';

/**
 * GET ALL PRODUCTS
 * 
 * @return array - Returns array of all products, each with id, name, description, price, image_url
 * 
 * This function queries the database for all products and returns them as an array.
 */
function getAllProducts() {
    global $connection;
    
    // SELECT all columns (*) FROM products table
    // ORDER BY id to get them in the order they were created
    $query = "SELECT id, name, description, price, image_url FROM products ORDER BY id";
    
    // Execute the query
    $result = mysqli_query($connection, $query);
    
    // Create an array to store all products
    $products = array();
    
    // Loop through each row in the result
    // mysqli_fetch_assoc() returns ONE row as an associative array, or NULL when no more rows
    while ($row = mysqli_fetch_assoc($result)) {
        // Add this product to our array
        $products[] = $row;
    }
    
    // Return the complete array of products
    return $products;
}

/**
 * GET PRODUCT BY ID
 * 
 * @param int $id - The product ID to look up
 * @return array|null - Returns the product array if found, NULL if not found
 * 
 * This function queries the database for a specific product by its ID.
 */
function getProductById($id) {
    global $connection;
    
    // Sanitize the ID to prevent SQL injection
    $id = mysqli_real_escape_string($connection, $id);
    
    // SELECT all columns WHERE id matches the provided ID
    // LIMIT 1 because ID is unique and we only want one result
    $query = "SELECT id, name, description, price, image_url FROM products WHERE id = '$id' LIMIT 1";
    
    // Execute the query
    $result = mysqli_query($connection, $query);
    
    // Check if a product was found
    if (mysqli_num_rows($result) === 0) {
        // No product with this ID exists
        return null;
    }
    
    // Return the product as an associative array
    return mysqli_fetch_assoc($result);
}

?>
