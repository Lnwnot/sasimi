# Sashimi Restaurant System

ระบบจองโต๊ะ สั่งอาหาร และแลกแต้มด้วย PHP + MySQL

## โครงสร้าง

- index.php: หน้าแรก
- login.php / register.php / logout.php
- menu.php: เมนูอาหาร
- booking.php: จองโต๊ะ + สั่งอาหาร
- reward_vouchers.php: แลกแต้มเป็นบัตรส่วนลด
- admin/: จัดการโต๊ะ เมนู รางวัล
- includes/db.php: เชื่อมต่อฐานข้อมูล

## การใช้งาน

1. นำเข้าฐานข้อมูลจาก `restaurant_db.sql`
2. วางโฟลเดอร์ลงใน `htdocs`
3. เข้าใช้งานผ่าน `http://localhost/sasimi/`
