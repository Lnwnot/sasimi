<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['customer'];
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];
$points = $user['points'];

$rewards = mysqli_query($conn, "SELECT * FROM rewards");
$vouchers = mysqli_query($conn, "SELECT v.*, r.name, r.discount_value 
    FROM vouchers v 
    JOIN rewards r ON v.reward_id = r.id 
    WHERE v.user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แลกแต้ม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['admin'])): ?>
          <li class="nav-item"><a class="nav-link" href="admin/manage_tables.php">จัดการโต๊ะ</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/manage_menu.php">จัดการเมนู</a></li>
          <li class="nav-item"><a class="nav-link" href="admin/manage_rewards.php">จัดการรางวัล</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
        <?php elseif (isset($_SESSION['staff'])): ?>
          <li class="nav-item"><a class="nav-link" href="staff/orders.php">ดูคำสั่งซื้อ</a></li>
          <li class="nav-item"><a class="nav-link" href="staff/tables.php">สถานะโต๊ะ</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
        <?php elseif (isset($_SESSION['customer'])): ?>
          <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ</a></li>
          <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
          <li class="nav-item"><a class="nav-link" href="order.php">สั่งอาหาร</a></li>
          <li class="nav-item"><a class="nav-link active" href="reward_vouchers.php">แลกแต้ม</a></li>
          <li class="nav-item"><a class="nav-link" href="reservation_status.php">สถานะการจอง</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="text-center mb-4">🎁 แลกแต้มเป็นบัตรส่วนลด</h2>
  <p class="text-end">คุณมีคะแนน: <strong><?= $points ?></strong> แต้ม</p>

  <h5>แลกรางวัล</h5>
  <form method="post" action="redeem.php" class="row g-3 align-items-center mb-4">
    <div class="col-auto">
      <select name="reward_id" class="form-select">
        <option value="">-- ไม่เลือก --</option>
        <?php while ($r = mysqli_fetch_assoc($rewards)) { ?>
          <option value="<?= $r['id'] ?>"><?= $r['name'] ?> (<?= $r['points_required'] ?> แต้ม)</option>
        <?php } ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">แลกแต้ม</button>
    </div>
  </form>

  <h4 class="mt-4">📜 บัตรส่วนลดของคุณ</h4>
  <table class="table table-striped table-hover">
    <thead><tr><th>ชื่อบัตร</th><th>ส่วนลด</th><th>สถานะ</th></tr></thead>
    <tbody>
    <?php
    if ($vouchers && mysqli_num_rows($vouchers) > 0) {
        while ($v = mysqli_fetch_assoc($vouchers)) {
            echo "<tr>";
            echo "<td>{$v['name']}</td>";
            echo "<td>{$v['discount_value']} บาท</td>";
            echo "<td>" . ($v['status'] === 'active' ? 'ใช้งานได้' : 'ใช้แล้ว') . "</td>";
            echo "</tr>";
        }
    } else {
        echo '<tr><td colspan="3">❌ ไม่มีบัตรส่วนลด หรือเกิดข้อผิดพลาด</td></tr>';
    }
    ?>
    </tbody>
  </table>
</div>
</body>
</html>
