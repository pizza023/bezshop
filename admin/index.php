<?php
include 'check_admin.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h3>🛠 แอดมินระบบ BEZSHOP</h3>

    <div class="list-group mt-4">
        <a href="orders.php" class="list-group-item list-group-item-action">
            📦 จัดการคำสั่งซื้อ
        </a>
        <a href="products.php" class="list-group-item list-group-item-action">
            👟 จัดการสินค้า
        </a>
        <a href="topup.php" class="list-group-item list-group-item-action">
            💰 อนุมัติเติมเงิน
        </a>
        <a href="report.php" class="list-group-item list-group-item-action">
            📊 รายงานระบบ
        </a>

        <a href="../frontend/index.php" class="list-group-item list-group-item-action text-danger">
            ⬅ กลับหน้าเว็บ
        </a>
    </div>
</div>

</body>
</html>
