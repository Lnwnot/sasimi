<?php
include 'includes/db.php';
session_start();

// เช็คว่ามีการจองโต๊ะหรือยัง
if (!isset($_SESSION['reservation_id'])) {
    header("Location: booking.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สั่งอาหาร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ + สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="reward_vouchers.php">แลกแต้มเป็นบัตร</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>



<div class="container mt-5">
    <h2 class="mb-4">สั่งอาหาร</h2>
    <form action="order_confirm.php" method="post">
        <div class="mb-3">
            <label class="form-label">เมนู:</label>
            <select name="menu_item" class="form-select">
                <option value="ข้าวปั้นแซลมอน">ข้าวปั้นแซลมอน</option>
                <option value="ซูชิรวม">ซูชิรวม</option>
                <option value="ราเมง">ราเมง</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">จำนวน:</label>
            <input type="number" name="qty" class="form-control" value="1">
        </div>
        <button type="submit" class="btn btn-success">ยืนยันการสั่งอาหาร</button>
    </form>
</div>
</body>
</html>
