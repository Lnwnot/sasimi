<?php
session_start();
if (!isset($_SESSION['staff'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>คำสั่งซื้อทั้งหมด</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="orders.php">Sashimi Staff</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="orders.php">ดูคำสั่งซื้อ</a></li>
        <li class="nav-item"><a class="nav-link" href="tables.php">สถานะโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="../logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
  <h2 class="mb-4 text-center">📦 คำสั่งซื้อของลูกค้า</h2>
  <p>** ระบบคำสั่งซื้อจริงสามารถเพิ่มได้ภายหลัง **</p>
</div>
</body>
</html>
