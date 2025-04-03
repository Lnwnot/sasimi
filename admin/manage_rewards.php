<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"));
if ($user['role'] != 'admin') {
    echo "<div class='alert alert-danger'>คุณไม่มีสิทธิ์เข้าถึงหน้านี้</div>";
    exit();
}

// Add reward
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['points'], $_POST['discount'])) {
    $name = $_POST['name'];
    $points = intval($_POST['points']);
    $discount = floatval($_POST['discount']);
    mysqli_query($conn, "INSERT INTO rewards (name, points_required, discount_value) VALUES ('$name', $points, $discount)");
}

// Delete reward
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM rewards WHERE id = $id");
}

$rewards = mysqli_query($conn, "SELECT * FROM rewards");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการของรางวัล</title>
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
    <h2>จัดการของรางวัล (Reward)</h2>
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="ชื่อรางวัล" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="points" class="form-control" placeholder="แต้มที่ใช้" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="discount" class="form-control" placeholder="ส่วนลด (บาท)" step="0.01" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success w-100">เพิ่ม</button>
        </div>
    </form>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ชื่อรางวัล</th>
                <th>แต้มที่ใช้</th>
                <th>ส่วนลด</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($rewards)): ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['points_required'] ?></td>
                    <td><?= $row['discount_value'] ?> บาท</td>
                    <td><a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">ลบ</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</div>
</body>
</html>
