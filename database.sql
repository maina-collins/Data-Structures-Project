-- Simple schema for jumia_clone (MySQL)
CREATE DATABASE IF NOT EXISTS jumia_clone DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE jumia_clone;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

INSERT INTO roles (name) VALUES ('admin'), ('seller'), ('customer');

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role_id INT DEFAULT 3,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  status VARCHAR(50) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


-- SEED DATA
INSERT INTO categories (name, description) VALUES
('Electronics','Phones, laptops, gadgets'),
('Fashion','Clothing and accessories'),
('Home Appliances','Household electronics');

INSERT INTO products (category_id,name,description,price,image) VALUES
(1,'Samsung Galaxy S22','Latest Samsung flagship phone',699.99,''),
(1,'HP Pavilion 15','Reliable laptop for home and work',549.00,''),
(2,'Men T-Shirt','Cotton t-shirt',12.50,''),
(3,'Air Fryer','Healthy cooking air fryer',89.99,'');

INSERT INTO users (username,email,password,role_id) VALUES
('admin','admin@example.com',PASSWORD('admin123'),1),
('seller1','seller@example.com',PASSWORD('seller123'),2),
('customer1','customer@example.com',PASSWORD('customer123'),3);


-- EXTRA: orders items table
CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT DEFAULT 1,
  price DECIMAL(10,2) DEFAULT 0,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

-- SEED USERS
INSERT INTO users (username,email,password,role_id) VALUES
('admin','admin@example.com','$2b$10$K9onrQ7KuIcd4Xp1ygC8vuhS14RMEcwrb1A1j/uJIOoGtWmNEaE6O',1),
('seller1','seller@example.com','$2b$10$gF3zVzZyRyi3OARPQIn2sOSF9cUdujO6h/aHdT9T.B/Qe/LwCN9r2',2),
('customer1','customer@example.com','$2b$10$1X96P/dElB6M2Uz1k.jjfOycxUWf5o/5TIDyO5osKVsMzG/Bxyu5G',3);
