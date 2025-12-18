<?php
include 'check_admin.php';

$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM users WHERE role='user'")
)['total'];

$totalOrders = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM orders")
)['total'];

$totalSales = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT SUM(total_price) total FROM orders WHERE status!='pending'")
)['total'];

$totalTopup = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT SUM(amount) total FROM wallet_logs WHERE type='topup'")
)['total'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายงานระบบ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<h3>📊 รายงานสรุประบบ</h3>

<div class="row mt-4">
<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5>👤 ผู้ใช้</h5>
<h3><?= $totalUsers ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5>📦 ออเดอร์</h5>
<h3><?= $totalOrders ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5>💰 ยอดขาย</h5>
<h3><?= number_format($totalSales) ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5>➕ เติมเงิน</h5>
<h3><?= number_format($totalTopup) ?></h3>
</div>
</div>
</div>
</div>

<a href="index.php" class="btn btn-dark mt-4">⬅ กลับ Dashboard</a>
</div>
</body>
</html>
