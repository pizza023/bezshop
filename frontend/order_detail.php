<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$order_id = (int)$_GET['id'];

/* ดึง order */
$order = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM orders
    WHERE id=$order_id AND user_id=$uid
"));

if(!$order){
    die("ไม่พบคำสั่งซื้อ");
}

/* ดึงสินค้าใน order */
$items = mysqli_query($conn,"
    SELECT oi.*, p.name, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id=$order_id
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
<div class="container mt-5" style="max-width:800px;">

<h3 class="mb-3">📦 คำสั่งซื้อ #<?= $order['id'] ?></h3>

<p>
<b>สถานะ:</b>
<?php
if($order['status']=='pending') echo '⏳ รอแอดมินอนุมัติ';
if($order['status']=='approved') echo '✅ อนุมัติแล้ว';
if($order['status']=='shipped') echo '🚚 จัดส่งแล้ว';
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
    <td>
        <img src="../assets/img/<?= $i['image'] ?>" width="50">
        <?= htmlspecialchars($i['name']) ?>
    </td>
    <td><?= number_format($i['price']) ?></td>
    <td><?= $i['quantity'] ?></td>
    <td><?= number_format($i['price']*$i['quantity']) ?></td>
</tr>
<?php } ?>

<tr>
    <th colspan="3" class="text-end">ยอดรวม</th>
    <th><?= number_format($order['total_price']) ?> บาท</th>
</tr>
</table>

<a href="orders.php" class="btn btn-dark">⬅ กลับคำสั่งซื้อ</a>

</div>
</body>
</html>
