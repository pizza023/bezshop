<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$order_id = intval($_GET['id']);
$uid = $_SESSION['user_id'];

// ดึงข้อมูลออเดอร์
$order = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM orders 
    WHERE id=$order_id AND user_id=$uid
"));

if(!$order){
    die("ไม่พบคำสั่งซื้อ");
}

// ดึงสินค้าในออเดอร์
$items = mysqli_query($conn,"
    SELECT oi.*, p.name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายละเอียดคำสั่งซื้อ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h3>📦 รายละเอียดคำสั่งซื้อ #<?= $order_id ?></h3>

<p>
<strong>สถานะ:</strong>
<?php
if($order['status']=='pending') echo '<span class="badge bg-warning">รอแอดมินอนุมัติ</span>';
if($order['status']=='approved') echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
if($order['status']=='shipped') echo '<span class="badge bg-primary">จัดส่งแล้ว</span>';
?>
</p>

<table class="table table-bordered mt-3">
<tr class="table-dark">
<th>สินค้า</th>
<th>ราคา</th>
<th>จำนวน</th>
<th>รวม</th>
</tr>

<?php while($i=mysqli_fetch_assoc($items)){ ?>
<tr>
<td><?= htmlspecialchars($i['name']) ?></td>
<td><?= number_format($i['price']) ?></td>
<td><?= $i['quantity'] ?></td>
<td><?= number_format($i['price'] * $i['quantity']) ?></td>
</tr>
<?php } ?>

</table>

<h5 class="text-end">รวมทั้งหมด: <?= number_format($order['total_price']) ?> บาท</h5>

<a href="orders.php" class="btn btn-dark mt-3">⬅ กลับ</a>

</div>
</body>
</html>
