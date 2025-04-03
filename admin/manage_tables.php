<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$tables = mysqli_query($conn, "SELECT * FROM tables");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_table'])) {
        $table_number = $_POST['table_number'];
        $capacity = $_POST['capacity'];
        mysqli_query($conn, "INSERT INTO tables (table_number, capacity) VALUES ('$table_number', '$capacity')");
        header("Location: manage_tables.php");
        exit();
    } elseif (isset($_POST['delete_table'])) {
        $id = $_POST['id'];
        mysqli_query($conn, "DELETE FROM tables WHERE id = '$id'");
        header("Location: manage_tables.php");
        exit();
    } elseif (isset($_POST['update_status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE tables SET status = '$status' WHERE id = '$id'");
        header("Location: manage_tables.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการโต๊ะ</title>
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
        <li class="nav-item"><a class="nav-link" href="../admin/manage_tables.php">จัดการโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="../admin/manage_menu.php">จัดการเมนู</a></li>
        <li class="nav-item"><a class="nav-link" href="../admin/manage_rewards.php">จัดการรางวัล</a></li>
        <li class="nav-item"><a class="nav-link" href=../logout.php>ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php elseif (isset($_SESSION['customer'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href=../booking.php>จองโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href=../menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=../order.php>สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=../reward_vouchers.php>แลกแต้ม</a></li>
        <li class="nav-item"><a class="nav-link" href=../reservation_status.php>สถานะการจอง</a></li>
        <li class="nav-item"><a class="nav-link" href=../logout.php>ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href=../menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=../login.php>เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href=../register.php>สมัครสมาชิก</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">🪑 จัดการโต๊ะอาหาร</h2>
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="number" name="table_number" class="form-control" placeholder="หมายเลขโต๊ะ" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="capacity" class="form-control" placeholder="จำนวนที่นั่ง" required>
        </div>
        <div class="col-md-4">
            <button type="submit" name="add_table" class="btn btn-primary w-100">➕ เพิ่มโต๊ะ</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead><tr><th>โต๊ะ</th><th>ที่นั่ง</th><th>สถานะ</th><th>แก้ไขสถานะ</th><th>ลบ</th></tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($tables)): ?>
            <tr>
                <td><?= $row['table_number'] ?></td>
                <td><?= $row['capacity'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <form method="post" class="d-flex">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <select name="status" class="form-select me-2">
                            <option value="available" <?= $row['status'] == 'available' ? 'selected' : '' ?>>ว่าง</option>
                            <option value="reserved" <?= $row['status'] == 'reserved' ? 'selected' : '' ?>>จองแล้ว</option>
                            <option value="occupied" <?= $row['status'] == 'occupied' ? 'selected' : '' ?>>ไม่ว่าง</option>
                        </select>
                        <button name="update_status" class="btn btn-warning btn-sm">อัปเดต</button>
                    </form>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('ต้องการลบโต๊ะนี้หรือไม่?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button name="delete_table" class="btn btn-sm btn-danger">ลบ</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
