<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * LOGIN USER
 * 
 * @param string $email - The user's email address
 * @param string $password - The user's plain text password (NOT hashed yet)
 * @return bool - TRUE if login successful, FALSE if failed
 * 
 * This function:
 * 1. Finds the user in the database by email
 * 2. Verifies the password matches using password_verify()
 * 3. Stores user data in $_SESSION if successful
 */
function loginUser($email, $password) {
    global $connection;
    
    // Query database for user with this email
    $query = "SELECT id, name, email, password, role FROM users WHERE email = '" . mysqli_real_escape_string($connection, $email) . "'";
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
    
    // Password doesn't match
    return false;
}

/**
 * REGISTER USER
 * 
 * @param string $name - The user's full name
 * @param string $email - The user's email address
 * @param string $password - The user's plain text password
 * @return bool - TRUE if registration successful, FALSE if email already exists
 * 
 * This function:
 * 1. Hashes the password using password_hash() for security
 * 2. Inserts the new user into the database
 * 3. Returns false if email already exists
 */
function registerUser($name, $email, $password) {
    global $connection;
    
    // Check if email already exists
    $checkQuery = "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($connection, $email) . "'";
    $checkResult = mysqli_query($connection, $checkQuery);
    
    // If email already exists, registration fails
    if (mysqli_num_rows($checkResult) > 0) {
        return false;
    }
    
    // Store the password as plain text
    // NOTE: In production, you should ALWAYS hash passwords for security!
    // This is for teaching purposes only.
    
    // Insert new user into database
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
    
    // Execute the query
    if (mysqli_query($connection, $query)) {
        return true; // Registration successful
    }
    
    return false; // Query failed
}

/**
 * LOGOUT USER
 * 
 * @return void
 * 
 * Destroys the session and clears all user data
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session completely
    session_destroy();
}

/**
 * CHECK IF USER IS LOGGED IN
 * 
 * @return bool - TRUE if user is logged in, FALSE if not
 * 
 * Checks if $_SESSION['user_id'] exists
 * This is set in loginUser() when a user successfully logs in
 */
function isLoggedIn() {
    // Check if the user_id session variable has been set
    return isset($_SESSION['user_id']);
}

/**
 * CHECK IF USER IS ADMIN
 * 
 * @return bool - TRUE if logged in user is admin, FALSE if not
 * 
 * Checks both:
 * 1. User is logged in
 * 2. User's role is 'admin'
 */
function isAdmin() {
    // Must be logged in AND must have admin role
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

?>
