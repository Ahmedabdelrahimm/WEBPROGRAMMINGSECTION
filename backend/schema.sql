-- WEEK 1 - DATABASE SCHEMA
-- This SQL file creates the complete database structure for the demo project
-- Run this file in phpMyAdmin to set up the database

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS demo_db;
USE demo_db;

-- ===== USERS TABLE =====
-- Stores all user account information
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===== PRODUCTS TABLE =====
-- Stores product/service information
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===== ORDERS TABLE =====
-- Stores customer orders
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ===== SAMPLE DATA =====

-- Insert admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@demo.com', 'admin123', 'admin');

-- Insert regular user (password: user123)
INSERT INTO users (name, email, password, role) VALUES
('John Doe', 'john@demo.com', 'user123', 'user');

-- Insert sample products
INSERT INTO products (name, description, price, image_url) VALUES
('Web Design Package', 'A full professional website design service', 299.00, 'images/web-design.jpg'),
('SEO Optimization', 'Boost your search engine rankings', 149.00, 'images/seo.jpg'),
('Logo Design', 'Custom logo design for your brand', 99.00, 'images/logo.jpg');

-- Insert sample orders
INSERT INTO orders (user_id, product_id, quantity, status) VALUES
(2, 1, 1, 'completed'),
(2, 2, 1, 'pending');
