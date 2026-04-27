

## 📁 Project Structure

```
WEBPROGRAMMINGSECTION/
├── index.php                 # Root entry point (redirects to frontend)
├── backend/                  # PHP logic & database functions
│   ├── db.php               # Database connection
│   ├── schema.sql           # Database schema + sample data
│   ├── auth.php             # Login/register/logout functions
│   ├── products_db.php      # Product queries
│   ├── user_db.php          # User profile queries
│   └── admin_db.php         # Full CRUD functions for admin
├── frontend/                # Public-facing pages
│   ├── index.php            # Homepage
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   ├── products.php         # Product listing
│   ├── profile.php          # User profile & settings
│   ├── logout.php           # Logout handler
│   └── style.css            # Styling for frontend + admin
└── admin/                   # Admin-only pages
    ├── index.php            # Admin dashboard
    ├── manage_products.php  # Product CRUD
    ├── manage_users.php     # User management
    └── manage_orders.php    # Order management
```

---

## 🚀 Quick Start Guide

### Step 1: Install XAMPP

Download and install **XAMPP** from: https://www.apachefriends.org/

XAMPP includes Apache, MySQL, and PHP - everything needed.

**Windows:** Install to `C:\xampp`
**Mac:** Install to `/Applications/XAMPP`
**Linux:** Follow the XAMPP documentation

### Step 2: Place Project in htdocs

The project is already located at:
```
C:\xampp\htdocs\WEBPROGRAMMINGSECTION
```

This is the correct location for XAMPP to serve the files.

### Step 3: Start XAMPP

1. Open **XAMPP Control Panel**
2. Click **Start** next to "Apache"
3. Click **Start** next to "MySQL"

You should see green checkmarks next to both services.

### Step 4: Create the Database

1. Open your browser and go to: **http://localhost/phpmyadmin**
2. You should see the phpMyAdmin interface
3. Click on **"Import"** tab at the top
4. Click **"Choose File"** and select: `backend/schema.sql`
5. Click **"Import"** button

This creates:
- A database called `demo_db`
- Three tables: `users`, `products`, `orders`
- Sample data (2 users, 3 products, 2 orders)

### Step 5: Access the Website

Open your browser and go to:
```
http://localhost/WEBPROGRAMMINGSECTION
```

You should see the homepage with:
- Navigation bar
- Hero section
- Feature cards
- Footer

---

## 🔑 Default Login Credentials

### Admin Account
```
Email:    admin@demo.com
Password: admin123
Role:     Admin
```

### Regular User Account
```
Email:    john@demo.com
Password: user123
Role:     User
```

---

## 📖 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,      -- Hashed with password_hash()
    role ENUM('user', 'admin'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Products Table
```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Orders Table
```sql
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,               -- Foreign key to users
    product_id INT NOT NULL,            -- Foreign key to products
    quantity INT NOT NULL DEFAULT 1,
    status ENUM('pending', 'completed', 'cancelled'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```
