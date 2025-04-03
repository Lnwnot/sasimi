<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['reservation_id'])) {
    $item = $_POST["menu_item"];
    $qty = intval($_POST["qty"]);
    $reservation_id = $_SESSION["reservation_id"];

    // Insert order
    mysqli_query($conn, "INSERT INTO orders (reservation_id) VALUES ($reservation_id)");
    $order_id = mysqli_insert_id($conn);

    // Add item to order_items
    $menu = mysqli_query($conn, "SELECT * FROM menu WHERE name = '$item' LIMIT 1");
    $menu_item = mysqli_fetch_assoc($menu);
    $menu_id = $menu_item['id'];
    mysqli_query($conn, "INSERT INTO order_items (order_id, menu_id, quantity) VALUES ($order_id, $menu_id, $qty)");

    // Get customer name and add points
    $name = $_SESSION['customer'];

    // 1 point per item ordered
    // อัปเดตระดับสมาชิกอัตโนมัติ
    $updated = mysqli_query($conn, "SELECT points FROM users WHERE username = '$name'");
    $p = mysqli_fetch_assoc($updated)['points'];
    $level = 'bronze';
    if ($p >= 50) $level = 'gold';
    elseif ($p >= 20) $level = 'silver';
    mysqli_query($conn, "UPDATE users SET membership = '$level' WHERE username = '$name'");

    mysqli_query($conn, "UPDATE users SET points = points + $qty WHERE username = '$name'");

    echo "<div class='container mt-5'>";
    echo "<h2 class='text-success'>✅ คุณได้สั่ง: $item จำนวน $qty ที่</h2>";
    echo "<p>ได้รับคะแนนสะสม: <strong>$qty</strong> แต้ม</p>";
    echo "<a href='menu.php' class='btn btn-primary mt-3'>กลับไปหน้าเมนู</a>";
    echo "</div>";
}
else {
    echo "<div class='alert alert-danger'>ไม่สามารถสั่งอาหารได้</div>";
}
?>
