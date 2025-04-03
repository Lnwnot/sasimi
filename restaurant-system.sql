

-- เพิ่มคอลัมน์ role เพื่อแยกแอดมินและลูกค้า
ALTER TABLE users MODIFY role ENUM('admin', 'staff', 'customer') DEFAULT 'customer';

-- เพิ่มผู้ใช้แบบลูกค้าตัวอย่าง
INSERT INTO users (username, password, role) VALUES ('customer1', MD5('123456'), 'customer');


-- เพิ่มคะแนนให้กับผู้ใช้ (เฉพาะลูกค้า)
ALTER TABLE users ADD COLUMN points INT DEFAULT 0;


-- เพิ่มระดับสมาชิก
ALTER TABLE users ADD COLUMN membership ENUM('bronze', 'silver', 'gold') DEFAULT 'bronze';

-- ตารางการแลกคะแนน
CREATE TABLE IF NOT EXISTS rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    points_required INT,
    discount_value DECIMAL(10,2)
);

-- เพิ่มตัวอย่าง reward
INSERT INTO rewards (name, points_required, discount_value) VALUES
('ส่วนลด 10 บาท', 10, 10.00),
('ส่วนลด 20 บาท', 20, 20.00);


-- เพิ่มลูกค้าทดสอบ ถ้ายังไม่มี
INSERT IGNORE INTO users (username, password, role, points, membership)
VALUES ('customer1', MD5('123456'), 'customer', 0, 'bronze');


CREATE TABLE IF NOT EXISTS vouchers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    reward_id INT,
    status ENUM('active', 'used') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reward_id) REFERENCES rewards(id),
    FOREIGN KEY (username) REFERENCES users(username)
);
