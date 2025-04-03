<?php
session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';
$user = $_SESSION['customer'];
$res = mysqli_query($conn, "SELECT r.*, t.table_number FROM reservations r LEFT JOIN tables t ON r.table_id = t.id WHERE r.customer_name = '$user'");
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สถานะการจอง</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
if (isset($_SESSION['customer'])):
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="order.php">สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="reward_vouchers.php">แลกแต้ม</a></li>
        <li class="nav-item"><a class="nav-link active" href="reservation_status.php">สถานะการจอง</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>
<div class="container mt-5">
  <h2 class="mb-4 text-center">📅 สถานะการจอง</h2>
  <table class="table table-bordered">
    <thead><tr><th>วันที่</th><th>เวลา</th><th>จำนวนคน</th><th>โต๊ะ</th><th>ยกเลิก</th></tr></thead>
    <tbody>
      <?php while($r = mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?= $r['date'] ?></td>
        <td><?= $r['time'] ?></td>
        <td><?= $r['people'] ?></td>
        <td><?= $r['table_number'] ?></td>
        <td>
          <a href="cancel_reservation.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการยกเลิก?')">ยกเลิก</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
