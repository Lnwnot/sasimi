<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['staff'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>คำสั่งซื้อ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sashimi Staff</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="orders.php">ดูคำสั่งซื้อ</a></li>
        <li class="nav-item"><a class="nav-link" href="tables.php">สถานะโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="../logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2>📦 คำสั่งซื้อทั้งหมด</h2>
  <table class="table table-bordered mt-3">
    <thead><tr><th>ชื่อผู้สั่ง</th><th>โต๊ะ</th><th>ยอดรวม</th><th>เวลา</th></tr></thead>
    <tbody>
    <?php while ($o = mysqli_fetch_assoc($orders)) { ?>
      <tr>
        <td><?= $o['customer_name'] ?></td>
        <td><?= $o['table_id'] ?></td>
        <td><?= $o['total_price'] ?> บาท</td>
        <td><?= $o['created_at'] ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
