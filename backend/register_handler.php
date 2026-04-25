<?php
/**
 * REGISTER HANDLER
 * 
 * This file handles registration form submissions from frontend/register.php
 * It validates inputs, creates the user, and redirects accordingly.
 */

require 'auth.php';

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate: passwords must match
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match";
        header("Location: ../frontend/register.php");
        exit;
    }

    // Validate: all fields must be filled
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "All fields are required";
        header("Location: ../frontend/register.php");
        exit;
    }

    // Try to register
    if (registerUser($name, $email, $password)) {
        // Registration successful! Auto-login
        loginUser($email, $password);
        // Redirect to products page
        header("Location: ../frontend/products.php");
        exit;
    } else {
        // Registration failed (email exists)
        $_SESSION['register_error'] = "Email already exists. Please use a different email or login.";
        header("Location: ../frontend/register.php");
        exit;
    }
}

// If no POST data, redirect to register page
header("Location: ../frontend/register.php");
exit;
?>
