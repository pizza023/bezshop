<?php
session_start();
include '../config/db.php';
$uid=$_SESSION['user_id'];
$q=mysqli_query($conn,"SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>คำสั่งซื้อของฉัน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<a href="index.php" class="btn btn-outline-secondary mb-3">← กลับร้าน</a>

<h3>📦 คำสั่งซื้อของฉัน</h3>

<table class="table table-bordered mt-3">
<thead class="table-dark">
<tr>
<th>#</th>
<th>วันที่</th>
<th>ยอด</th>
<th>ชำระเงิน</th>
<th>สถานะ</th>
</tr>
</thead>
<tbody>
<?php while($o=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $o['id'] ?></td>
<td><?= date('d/m/Y H:i',strtotime($o['created_at'])) ?></td>
<td><?= number_format($o['total_price']) ?> บาท</td>
<td><?= $o['payment_method'] ?></td>
<td><?= $o['status'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</body>
</html>
