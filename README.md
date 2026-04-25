# Demo Project - Teaching Backend Development

A complete, beginner-friendly teaching project for university students learning **PHP**, **MySQL**, and **Web Development**. This project demonstrates core backend concepts using only procedural PHP with no frameworks.

---

## 📚 Project Overview

This is a **service e-commerce website** built to teach:

- ✅ Database design and SQL queries
- ✅ User authentication (login/register with password hashing)
- ✅ Session management ($_SESSION)
- ✅ CRUD operations (Create, Read, Update, Delete)
- ✅ Admin dashboards and role-based access
- ✅ Form handling and validation
- ✅ Secure coding practices

**Every line of code is heavily commented** to explain exactly what's happening — perfect for learning.

---

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

---

## 🎯 Feature Walkthrough

### 1. **Frontend Pages** (Public Access)

#### Homepage (`frontend/index.php`)
- Navigation bar with login/register links
- Hero section with call-to-action
- Features section highlighting the project
- Fully responsive design

#### Login (`frontend/login.php`)
- Email & password form
- Calls `loginUser()` function
- Session-based authentication
- Demo credentials displayed

#### Register (`frontend/register.php`)
- Full name, email, password form
- Calls `registerUser()` function
- Password confirmation validation
- Automatic login after registration

#### Products (`frontend/products.php`)
- Displays all products in a grid
- Shows: name, description, price
- Uses `getAllProducts()` function
- Responsive card layout

#### Profile (`frontend/profile.php`)
- Protected page (redirects if not logged in)
- Shows current user info
- Update name, email, password
- Calls `updateUser()` function

### 2. **Admin Dashboard** (`admin/index.php`)

- Protected page (admins only, redirects if not admin)
- Shows statistics: total users, products, orders
- Quick action buttons
- Sidebar navigation menu

### 3. **Product Management** (`admin/manage_products.php`)

**Full CRUD Operations:**
- ✅ **Create**: Add new product form
- ✅ **Read**: Display all products in table
- ✅ **Update**: Edit existing products
- ✅ **Delete**: Remove products

### 4. **User Management** (`admin/manage_users.php`)

- View all users in a table
- Delete user accounts
- Display user role and creation date
- Prevents deleting your own account

### 5. **Order Management** (`admin/manage_orders.php`)

- View all orders with user and product details
- Update order status (pending → completed → cancelled)
- Display order creation date
- Status color coding

---

## 🔐 Security Features

### Password Security
- ✅ Passwords hashed with `password_hash()` (bcrypt algorithm)
- ✅ Password verification with `password_verify()`
- ✅ Passwords never stored in plain text

### SQL Injection Prevention
- ✅ `mysqli_real_escape_string()` sanitizes all inputs
- ✅ Prepared statements used where necessary

### XSS Prevention
- ✅ `htmlspecialchars()` on all user-generated output
- ✅ Prevents malicious scripts from being injected

### Session Security
- ✅ Session-based authentication with `$_SESSION`
- ✅ Proper session destruction on logout

---

## 💻 Code Style & Best Practices

Every file follows these principles (as requested for teaching):

1. **Every file starts with a comment block** explaining its purpose
2. **Every function has comments** explaining parameters and return values
3. **Inline comments** explain complex SQL queries
4. **Functions are SHORT** (max 15 lines for readability)
5. **No OOP, No Frameworks** — pure procedural PHP
6. **No JavaScript frameworks** — vanilla JS only if needed
7. **All files are self-contained** and easy to read top-to-bottom
8. **"WEEK X" comments** show when each file is built in the curriculum

### Example Comment Structure
```php
<?php
/**
 * WEEK 1 - DATABASE CONNECTION
 * 
 * Explanation of what this file does
 * and how to use it...
 */

/**
 * FUNCTION NAME
 * 
 * @param type $param - Description
 * @return type - Description of return value
 * 
 * Explanation of what the function does
 */
function myFunction($param) {
    // Your code here
}
?>
```

---

## 📚 Learning Path (4 Weeks)

### Week 1: Database Setup
- `backend/db.php` — Database connection
- `backend/schema.sql` — SQL schema with sample data
- All `frontend/*.php` skeleton files
- `admin/*.php` skeleton files

### Week 2: Authentication
- `backend/auth.php` — All authentication functions
- `frontend/login.php` — Complete login with session
- `frontend/register.php` — Complete registration
- `frontend/products.php` — Display products
- `backend/products_db.php` — Product queries
- `frontend/logout.php` — Logout handler

### Week 3: Admin & Profiles
- `backend/user_db.php` — User profile functions
- `frontend/profile.php` — User profile editing
- `backend/admin_db.php` — All CRUD functions
- `admin/index.php` — Dashboard
- `admin/manage_products.php` — Full product CRUD
- `admin/manage_users.php` — User management
- `admin/manage_orders.php` — Order management

### Week 4: Styling & Polish
- `frontend/style.css` — Professional responsive CSS
- Apply CSS to all pages
- Update admin with sidebar layout
- Clean up all PHP files with comments

---

## 🎓 Teaching Topics Covered

This project teaches these essential concepts:

| Topic | Location | Week |
|-------|----------|------|
| Database Connection | `backend/db.php` | 1 |
| SQL CREATE TABLE | `backend/schema.sql` | 1 |
| Password Hashing | `backend/auth.php` | 2 |
| Session Management | `backend/auth.php` | 2 |
| Form Handling | `frontend/login.php` | 2 |
| Role-Based Access | `admin/*.php` | 3 |
| CRUD Operations | `backend/admin_db.php` | 3 |
| SQL JOINs | `backend/admin_db.php` | 3 |
| Responsive Design | `frontend/style.css` | 4 |
| Security Best Practices | All files | Throughout |

---

## 🛠 Troubleshooting

### "Connection failed: Unknown database 'demo_db'"
- ✅ Make sure you imported `backend/schema.sql` in phpMyAdmin
- ✅ Confirm MySQL service is running in XAMPP Control Panel

### "404 Not Found"
- ✅ Make sure XAMPP Apache service is running
- ✅ Check the URL: `http://localhost/WEBPROGRAMMINGSECTION`
- ✅ Don't forget the trailing slash

### "Cannot modify header information"
- ✅ This usually means `header()` was called after output
- ✅ Make sure no HTML/whitespace appears before `<?php`

### "Call to undefined function mysqli_query()"
- ✅ Ensure MySQL extension is enabled in XAMPP
- ✅ In XAMPP Control Panel, click "Config" next to Apache
- ✅ Check that `php.ini` has `extension=mysqli` enabled

### Login doesn't work
- ✅ Try demo credentials: `admin@demo.com` / `admin123`
- ✅ Check phpMyAdmin to ensure users table has data
- ✅ Verify database connection in `backend/db.php`

---

## 📝 Sample Data Included

### Admin User
- **Name:** Admin
- **Email:** admin@demo.com
- **Password:** admin123
- **Role:** Admin

### Regular User
- **Name:** John Doe
- **Email:** john@demo.com
- **Password:** user123
- **Role:** User

### Products
1. Web Design Package — $299 — "A full professional website design service"
2. SEO Optimization — $149 — "Boost your search engine rankings"
3. Logo Design — $99 — "Custom logo design for your brand"

### Sample Orders
- John has 1 completed order (Web Design Package)
- John has 1 pending order (SEO Optimization)

---

## 🎯 Next Steps for Students

After exploring this project:

1. **Modify the database** — Add new tables or columns
2. **Add more pages** — Create a contact form, about page
3. **Extend functionality** — Add product reviews, ratings
4. **Improve styling** — Customize CSS with your own design
5. **Add validation** — Enhance form validation
6. **Learn frameworks** — Graduate to Laravel, Symfony, etc.

---

## 💡 Key Takeaways

- **Procedural PHP works fine** for small projects
- **Database design matters** — Good schema makes coding easier
- **Security first** — Always hash passwords, sanitize inputs, prevent SQL injection
- **Comments are your friend** — They help you and others understand code
- **Keep it simple** — Avoid over-engineering; solve the problem
- **Test everything** — Before deploying, test all features

---

## 📞 Support

If you encounter issues:

1. Check the **Troubleshooting** section above
2. Review the **inline comments** in the PHP files
3. Check **phpMyAdmin** to verify database setup
4. Verify XAMPP services are running
5. Check **browser console** (F12) for JavaScript errors

---

## 📄 License

This teaching project is provided as-is for educational purposes.

---

## 👨‍🎓 Made for Learning

Built with ❤️ to help university students understand:
- How the web works
- How databases store data
- How PHP connects frontend and backend
- How to build complete applications

Happy learning! 🚀

---

**Last Updated:** April 2026
**Compatible with:** PHP 7.0+, MySQL 5.7+, XAMPP
