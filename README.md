# 🛒 Jumia Clone – Data Structures Project  
A full eCommerce system inspired by **Jumia**, developed as part of a Data Structures course requirement.  
The project demonstrates real-world use of **arrays, associative arrays, trees, relational structures, and search algorithms** while providing a complete, functional shopping experience.

---

## 📌 Project Overview
This project implements a simplified version of the Jumia online marketplace.  
It includes:

- User authentication (Register/Login/Logout)
- Role-based dashboards (Admin, Seller, User)
- Product listing & details page
- Category filtering
- Cart management & checkout system
- Admin management for:
  - Users
  - Products (with image uploads)
  - Categories

---

## 🎯 Objective of the Assignment
The course task was:

> “Pick an organization like Amazon or Jumia and analyze the **data structures** they use.  
> Implement your findings by **designing an eCommerce website** that is running.  
> Deliverables:  
> ✔ PowerPoint Presentation  
> ✔ Running Website”

This project uses **Jumia** as the reference organization.

---

## 🧩 Data Structures Used
### 1️⃣ Arrays & Associative Arrays
Used for:
- Shopping cart (`$_SESSION['cart']`)
- Ordered product details
- Category display
- Product listing

### 2️⃣ Relational Structures (MySQL)
Tables simulate real marketplace relationships:

- `users` + `roles`
- `products` + `categories`
- `orders` + `order_items`

### 3️⃣ Trees (Category Navigation)
Categories act as a hierarchical structure:

```
Electronics
 ├── Phones
 ├── Laptops
 └── Accessories
Fashion
 ├── Men
 └── Women
```

### 4️⃣ Search Algorithms
Used in:
- Product search
- Category filtering
- Cart item lookup

### 5️⃣ Sessions (Hash Maps)
Session arrays manage:
- Logged-in user
- Cart
- Role permissions

---

## 🛠 Technologies Used
| Technology | Purpose |
|-----------|---------|
| PHP | Backend logic |
| MySQL | Database |
| HTML/CSS | UI |
| Bootstrap | Styling |
| Apache (XAMPP) | Local server |

---

## 📂 Project Structure

```
jumia_clone/
├── admin/
├── user/
├── seller/
├── uploads/
├── includes/
├── index.php
├── product.php
├── login.php
├── register.php
└── database.sql
```

---

## 🚀 Running the Project

### 1️⃣ Install XAMPP  
Start Apache + MySQL.

### 2️⃣ Copy project
```
C:/xampp/htdocs/jumia_clone
```

### 3️⃣ Import Database
- Open phpMyAdmin  
- Create database `jumia_clone`  
- Import `database.sql`

### 4️⃣ Access website
```
http://localhost/jumia_clone/
```

---

## 🧑‍💻 Default Admin Login
| Email | Password |
|--------|----------|
| admin@example.com | 123456 |

---

## 📝 License
Academic project for educational use only.

---

## 🤝 Contributors
- **Maina Collins** – Developer
