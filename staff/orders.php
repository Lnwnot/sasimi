<?php
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
