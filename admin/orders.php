<?php
include 'check_admin.php';

$result = mysqli_query($conn,"
    SELECT o.*, u.username 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการคำสั่งซื้อ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">

<h3 class="mb-4">📦 คำสั่งซื้อทั้งหมด</h3>

<table class="table table-bordered align-middle">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>ผู้ใช้</th>
    <th>ยอดรวม</th>
    <th>ชำระเงิน</th>
    <th>สถานะ</th>
    <th width="180">จัดการ</th>
</tr>
</thead>

<tbody>
<?php while($o = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $o['id'] ?></td>
    <td><?= htmlspecialchars($o['username']) ?></td>
    <td><?= number_format($o['total_price']) ?> บาท</td>
    <td><?= htmlspecialchars($o['payment_method']) ?></td>
    <td>
        <?php
            if($o['status']=='pending') echo '<span class="badge bg-warning">รออนุมัติ</span>';
            if($o['status']=='approved') echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
            if($o['status']=='shipped') echo '<span class="badge bg-primary">จัดส่งแล้ว</span>';
        ?>
    </td>
    <td>
        <?php if($o['status']=='pending'){ ?>
            <a href="approve_order.php?id=<?= $o['id'] ?>&status=approved"
               class="btn btn-success btn-sm w-100 mb-1">
               ✔ อนุมัติ
            </a>
        <?php } ?>

        <?php if($o['status']=='approved'){ ?>
            <a href="approve_order.php?id=<?= $o['id'] ?>&status=shipped"
               class="btn btn-primary btn-sm w-100">
               🚚 จัดส่งแล้ว
            </a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<a href="index.php" class="btn btn-dark mt-3">⬅ กลับ Dashboard</a>

</div>
</body>
</html>
