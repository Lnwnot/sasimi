<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['customer'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"));
$points = $user['points'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reward_id'])) {
    $reward_id = intval($_POST['reward_id']);
    $reward_query = mysqli_query($conn, "SELECT * FROM rewards WHERE id = $reward_id") or die(mysqli_error($conn));
    $reward = mysqli_fetch_assoc($reward_query);

    if ($reward && $points >= $reward['points_required']) {
        // หักแต้ม
        mysqli_query($conn, "UPDATE users SET points = points - {$reward['points_required']} WHERE username = '$username'");
        // บันทึกเป็น voucher
        mysqli_query($conn, "INSERT INTO vouchers (username, reward_id, status) VALUES ('$username', $reward_id, 'active')");
        $msg = "<div class='alert alert-success'>✅ คุณแลก <strong>{$reward['name']}</strong> สำเร็จแล้ว!</div>";
        $points -= $reward['points_required']; // update local value
    } else {
        $msg = "<div class='alert alert-danger'>❌ คะแนนของคุณไม่เพียงพอ</div>";
    }
}

$rewards = mysqli_query($conn, "SELECT * FROM rewards");
$vouchers = mysqli_query($conn, "SELECT v.id, r.name, r.discount_value, v.status FROM vouchers v 
    JOIN rewards r ON v.reward_id = r.id WHERE v.username = '$username'");
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แลกแต้มเป็นบัตรส่วนลด</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ + สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href="reward_vouchers.php">แลกแต้มเป็นบัตร</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>






<div class="container mt-5">
  <h2 class="mb-4">🎁 แลกแต้มเป็นบัตรส่วนลด</h2>
  <?= $msg ?>
  <p>คุณมีคะแนน: <strong><?= $points ?></strong> แต้ม</p>
  <div class="card shadow p-4 mb-4 bg-white">
  <h4 class="mb-3">แลกรางวัล</h4>
  <form method="post" class="row g-3 align-items-end">
    <div class="col-md-6">
      <label class="form-label">เลือกรางวัล</label>
      <select name="reward_id" class="form-select" required>
        <option value="none">-- ไม่เลือก --</option>
        <?php while($r = mysqli_fetch_assoc($rewards)): ?>
          <option value="<?= $r['id'] ?>"><?= $r['name'] ?> (<?= $r['points_required'] ?> แต้ม)</option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <button class="btn btn-primary w-100">แลกแต้ม</button>
    </div>
  </form>

  <hr>
  <h4 class="mt-4">📜 บัตรส่วนลดของคุณ</h4>
  <table class="table table-striped table-hover">
    <thead><tr><th>ชื่อบัตร</th><th>ส่วนลด</th><th>สถานะ</th></tr></thead>
    <tbody>
      <?php while($v = mysqli_fetch_assoc($vouchers)): ?>
        <tr>
          <td><?= $v['name'] ?></td>
          <td><?= $v['discount_value'] ?> บาท</td>
          <td><?= $v['status'] === 'active' ? 'ใช้งานได้' : 'ใช้แล้ว' ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
