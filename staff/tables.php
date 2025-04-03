<?php
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
