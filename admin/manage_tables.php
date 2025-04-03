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
        <thead><tr><th>โต๊ะ</th><th>ที่นั่ง</th><th>สถานะ</th><th>ลบ</th></tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($tables)): ?>
            <tr>
                <td><?= $row['table_number'] ?></td>
                <td><?= $row['capacity'] ?></td>
                <td><?= $row['status'] ?></td>
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
