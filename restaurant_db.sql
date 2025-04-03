
CREATE DATABASE IF NOT EXISTS restaurant_db;
USE restaurant_db;

DROP TABLE IF EXISTS vouchers, order_items, orders, reservations, menu, tables, rewards, users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    points INT DEFAULT 0,
    membership ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze'
);

CREATE TABLE tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_number INT NOT NULL,
    capacity INT NOT NULL,
    status ENUM('available', 'reserved', 'occupied') DEFAULT 'available'
);

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    people INT NOT NULL,
    table_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (table_id) REFERENCES tables(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    menu_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (menu_id) REFERENCES menu(id)
);

CREATE TABLE rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    points_required INT,
    discount_value DECIMAL(10,2)
);

CREATE TABLE vouchers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    reward_id INT,
    status ENUM('active', 'used') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reward_id) REFERENCES rewards(id),
    FOREIGN KEY (username) REFERENCES users(username)
);

-- ตัวอย่างข้อมูล
INSERT INTO users (username, password, role) VALUES 
('admin', MD5('admin123'), 'admin'),
('customer1', MD5('123456'), 'customer');

INSERT INTO tables (table_number, capacity) VALUES 
(1, 4), (2, 4), (3, 2);

INSERT INTO menu (name, price) VALUES 
('ข้าวปั้นแซลมอน', 120.00), 
('ซูชิรวม', 200.00), 
('ราเมง', 150.00);

INSERT INTO rewards (name, points_required, discount_value) VALUES 
('ส่วนลด 10 บาท', 10, 10.00),
('ส่วนลด 20 บาท', 20, 20.00);
