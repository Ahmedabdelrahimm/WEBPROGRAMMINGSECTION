<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function loginUser($email, $password) {
    global $connection;

    $query = "SELECT id, name, email, password, role FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    
    // If no user found with this email, login fails
    if (mysqli_num_rows($result) === 0) {
        return false;
    }
    
    // Get the user's data from database
    $user = mysqli_fetch_assoc($result);
    
    // Check if the plain text password matches the password in the database
    if ($password === $user['password']) {
        // Password matches! Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    
    return false;
}


function registerUser($name, $email, $password) {
    global $connection;
    
    // Check if email already exists
    $checkQuery = "SELECT id FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($connection, $checkQuery);
    
    // If email already exists, registration fails
    if (mysqli_num_rows($checkResult) > 0) {
        return false;
    }


    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
    
    // Execute the query
    if (mysqli_query($connection, $query)) {
        return true; // Registration successful
    }
    
    return false; // Query failed
}


function logoutUser() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session completely
    session_destroy();
}

function isLoggedIn() {
    // Check if the user_id session variable has been set
    return isset($_SESSION['user_id']);
}


function isAdmin() {
    // Must be logged in AND must have admin role
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

?>
