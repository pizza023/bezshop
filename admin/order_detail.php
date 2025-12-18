<?php
include 'check_admin.php';

$order_id = intval($_GET['id']);

// ดึงออเดอร์
$order = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT o.*, u.username 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id=$order_id
"));

if(!$order){
    die("ไม่พบออเดอร์");
}

// ดึงสินค้าในออเดอร์
$items = mysqli_query($conn,"
    SELECT oi.*, p.name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id=$order_id
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายละเอียดคำสั่งซื้อ (Admin)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h3>🛠 รายละเอียดคำสั่งซื้อ #<?= $order_id ?></h3>

<p><strong>ลูกค้า:</strong> <?= htmlspecialchars($order['username']) ?></p>
<p><strong>สถานะ:</strong> <?= $order['status'] ?></p>

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

<h5 class="text-end">รวม: <?= number_format($order['total_price']) ?> บาท</h5>

<?php if($order['status']=='pending'){ ?>
<a href="approve_order.php?id=<?= $order_id ?>&status=approved"
   class="btn btn-success mt-3">
   ✔ อนุมัติคำสั่งซื้อ
</a>
<?php } ?>

<a href="orders.php" class="btn btn-dark mt-3">⬅ กลับ</a>

</div>
</body>
</html>
