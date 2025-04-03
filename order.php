<?php
session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';

$menus = mysqli_query($conn, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สั่งอาหาร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
if (isset($_SESSION['admin'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sashimi Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="admin/manage_tables.php">จัดการโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/manage_menu.php">จัดการเมนู</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/manage_rewards.php">จัดการรางวัล</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php elseif (isset($_SESSION['customer'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="order.php">สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="reward_vouchers.php">แลกแต้ม</a></li>
        <li class="nav-item"><a class="nav-link" href="reservation_status.php">สถานะการจอง</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>
<?php
if (isset($_SESSION['admin'])): ?>

<?php elseif (isset($_SESSION['customer'])): ?>

<?php else: ?>

<?php endif; ?>


<div class="container mt-5">
    <h2 class="mb-4 text-center">🍱 สั่งอาหาร</h2>
    <form method="post" action="order_confirm.php">
        <div class="row">
            <?php while ($menu = mysqli_fetch_assoc($menus)) : ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $menu['name'] ?></h5>
                        <p class="card-text">ราคา <?= number_format($menu['price'], 2) ?> บาท</p>
                        <input type="number" class="form-control" name="quantity[<?= $menu['id'] ?>]" min="0" placeholder="จำนวน">
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">ยืนยันการสั่งซื้อ</button>
        </div>
    </form>
</div>
</body>
</html>
