<?php
/**
 * WEEK 2 - LOGOUT PAGE
 * 
 * This page logs out the current user and redirects to login page.
 * It calls logoutUser() from auth.php to destroy the session.
 */

require '../backend/auth.php';

// Call the logout function to destroy session
logoutUser();

// Redirect to login page
header("Location: login.php");
exit;
?>
