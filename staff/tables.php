<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['staff'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';
$tables = mysqli_query($conn, "SELECT * FROM tables");
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สถานะโต๊ะ</title>
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
  <h2>🪑 สถานะโต๊ะ</h2>
  <table class="table table-bordered">
    <thead><tr><th>โต๊ะ</th><th>ที่นั่ง</th><th>สถานะ</th></tr></thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($tables)) { ?>
      <tr>
        <td><?= $row['table_number'] ?></td>
        <td><?= $row['capacity'] ?></td>
        <td><span class="badge bg-<?php
          echo $row['status'] === 'available' ? 'success' : ($row['status'] === 'reserved' ? 'warning' : 'danger');
        ?>"><?= $row['status'] ?></span></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
