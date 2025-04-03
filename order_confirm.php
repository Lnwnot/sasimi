<?php
session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';

$total = 0;
$items = [];

if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $menu_id => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) {
            $menu_result = mysqli_query($conn, "SELECT * FROM menu WHERE id = $menu_id");
            $menu = mysqli_fetch_assoc($menu_result);
            $subtotal = $qty * $menu['price'];
            $total += $subtotal;
            $items[] = [
                'name' => $menu['name'],
                'qty' => $qty,
                'price' => $menu['price'],
                'subtotal' => $subtotal
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยืนยันการสั่งอาหาร</title>
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


<div class="container mt-5">
    <h2 class="mb-4 text-center">✅ ยืนยันคำสั่งซื้อ</h2>
    <?php if ($total > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr><th>เมนู</th><th>จำนวน</th><th>ราคา/หน่วย</th><th>รวม</th></tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'], 2) ?></td>
                <td><?= number_format($item['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h4 class="text-end">รวมทั้งหมด: <?= number_format($total, 2) ?> บาท</h4>
    <?php else: ?>
        <p class="text-center">❌ คุณยังไม่ได้เลือกเมนูใดเลย</p>
    <?php endif; ?>
</div>
</body>
</html>
