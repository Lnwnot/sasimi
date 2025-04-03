<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['admin'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_query);

if ($user['role'] != 'admin') {
    echo "<div class='alert alert-danger'>คุณไม่มีสิทธิ์เข้าถึงหน้านี้</div>";
    exit();
}

$tables = mysqli_query($conn, "SELECT * FROM tables");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการโต๊ะ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sashimi Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="manage_tables.php">จัดการโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_menu.php">จัดการเมนู</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_rewards.php">จัดการรางวัล</a></li>
        <li class="nav-item"><a class="nav-link" href="../logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <h2>สถานะโต๊ะ (เฉพาะผู้ดูแลระบบ)</h2>
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($tables)): ?>
            <div class="col-md-3 mb-3">
                <div class="card <?= $row['status'] == 'available' ? 'bg-success' : ($row['status'] == 'reserved' ? 'bg-warning' : 'bg-danger') ?> text-white">
                    <div class="card-body text-center">
                        <h5>โต๊ะ <?= $row['table_number'] ?></h5>
                        <p>สถานะ: <?= $row['status'] ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
</div>
</body>
</html>
