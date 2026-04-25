<?php
require 'db.php';


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

function getProductById($id) {
    global $connection;

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
