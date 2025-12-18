<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

$result = mysqli_query($conn,"
    SELECT *
    FROM orders
    WHERE user_id = $uid
    ORDER BY id DESC
");
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

<h3>📦 คำสั่งซื้อของฉัน</h3>

<table class="table table-bordered mt-3 align-middle">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>วันที่สั่ง</th>
    <th>ยอดรวม</th>
    <th>ชำระเงิน</th>
    <th>สถานะ</th>
    <th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php if(mysqli_num_rows($result)==0){ ?>
<tr>
    <td colspan="6" class="text-center text-muted">
        ยังไม่มีคำสั่งซื้อ
    </td>
</tr>
<?php } ?>

<?php while($o=mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $o['id'] ?></td>
    <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
    <td><?= number_format($o['total_price']) ?> บาท</td>
    <td><?= htmlspecialchars($o['payment_method']) ?></td>
    <td>
        <?php
        if($o['status']=='pending') echo '<span class="badge bg-warning">รอแอดมินอนุมัติ</span>';
        if($o['status']=='approved') echo '<span class="badge bg-success">อนุมัติแล้ว</span>';
        if($o['status']=='shipped') echo '<span class="badge bg-primary">จัดส่งแล้ว</span>';
        ?>
    </td>
    <td>
        <a href="order_detail.php?id=<?= $o['id'] ?>"
           class="btn btn-outline-dark btn-sm">
           ดูรายละเอียด
        </a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<a href="index.php" class="btn btn-dark">⬅ กลับหน้าแรก</a>

</div>
</body>
</html>
