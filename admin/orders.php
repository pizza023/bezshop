<?php
include 'check_admin.php';

$result = mysqli_query($conn,"
    SELECT o.*, u.username 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.id DESC
");
?>

<!doctype html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ADMIN ORDERS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">

<!-- 🔙 ปุ่มย้อนกลับ -->
<a href="index.php" class="btn btn-outline-secondary mb-3">
    ← กลับ Dashboard
</a>

<h3 class="mb-3">📦 จัดการคำสั่งซื้อ</h3>

<table class="table table-bordered align-middle">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>User</th>
    <th>Total</th>
    <th>Status</th>
    <th width="120">Action</th>
</tr>
</thead>

<tbody>
<?php if(mysqli_num_rows($result)==0){ ?>
<tr>
    <td colspan="5" class="text-center text-muted">
        ยังไม่มีคำสั่งซื้อ
    </td>
</tr>
<?php } ?>

<?php while($o=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?= $o['id'] ?></td>
<td><?= htmlspecialchars($o['username']) ?></td>
<td><?= number_format($o['total_price'],2) ?> บาท</td>
<td>
    <?php
        if($o['status']=='pending') echo '<span class="badge bg-warning">รออนุมัติ</span>';
        if($o['status']=='approved') echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
        if($o['status']=='shipped') echo '<span class="badge bg-primary">จัดส่งแล้ว</span>';
    ?>
</td>
<td>
<?php if($o['status']=='pending'){ ?>
    <a class="btn btn-success btn-sm w-100"
       href="approve_order.php?id=<?= $o['id'] ?>">
       ✔ อนุมัติ
    </a>
<?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</body>
</html>
