<?php
session_start();
include 'includes/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_SESSION['customer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];

    $query = "SELECT * FROM tables WHERE capacity >= $people AND status = 'available' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $table = mysqli_fetch_assoc($result);
        $table_id = $table['id'];

        $insert = "INSERT INTO reservations (customer_name, date, time, people, table_id)
                   VALUES ('$name', '$date', '$time', '$people', '$table_id')";
        mysqli_query($conn, $insert);

        $reservation_id = mysqli_insert_id($conn);
        $_SESSION['reservation_id'] = $reservation_id;

        mysqli_query($conn, "UPDATE tables SET status = 'reserved' WHERE id = $table_id");

        header("Location: order.php");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>❌ ไม่มีโต๊ะว่างที่สามารถรองรับจำนวนคนที่ระบุได้</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จองโต๊ะ</title>
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
        <li class="nav-item"><a class="nav-link" href=logout.php>ออกจากระบบ</a></li>
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
        <li class="nav-item"><a class="nav-link" href=booking.php>จองโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href=menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=order.php>สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=reward_vouchers.php>แลกแต้ม</a></li>
        <li class="nav-item"><a class="nav-link" href=reservation_status.php>สถานะการจอง</a></li>
        <li class="nav-item"><a class="nav-link" href=logout.php>ออกจากระบบ</a></li>
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
        <li class="nav-item"><a class="nav-link" href=menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=login.php>เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href=register.php>สมัครสมาชิก</a></li>
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
    <h2 class="mb-4">จองโต๊ะ</h2>
    <?= $msg ?>
    <form method="post">
        
        <div class="mb-3">
            <label class="form-label">วันที่:</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">เวลา:</label>
            <input type="time" name="time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">จำนวนคน:</label>
            <input type="number" name="people" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">จองโต๊ะ</button>
    </form>
</div>
</body>
</html>
