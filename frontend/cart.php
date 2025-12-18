<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

$result = mysqli_query($conn,"
    SELECT c.*, p.name, p.price
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = $uid
");

$total = 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ตะกร้าสินค้า</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">

<!-- 🔙 กลับหน้าแรก -->
<a href="index.php" class="btn btn-outline-secondary mb-3">
    ← กลับหน้าแรก
</a>

<h3>🛒 ตะกร้าสินค้า</h3>

<table class="table table-bordered mt-3 align-middle">
<tr class="text-center">
    <th>สินค้า</th>
    <th>ราคา</th>
    <th>จำนวน</th>
    <th>รวม</th>
    <th>ลบ</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ 
    $sum = $row['price'] * $row['qty'];
    $total += $sum;
?>
<tr class="text-center">
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= number_format($row['price']) ?></td>
    <td><?= $row['qty'] ?></td>
    <td><?= number_format($sum) ?></td>

    <!-- ❌ ปุ่มลบ -->
    <td>
        <a href="../backend/remove_cart.php?id=<?= $row['id'] ?>"
           class="btn btn-sm btn-outline-danger"
           onclick="return confirm('ลบสินค้านี้ออกจากตะกร้า?')">
           ✖
        </a>
    </td>
</tr>
<?php } ?>

<tr>
    <th colspan="3" class="text-end">รวมทั้งหมด</th>
    <th colspan="2"><?= number_format($total) ?> บาท</th>
</tr>
</table>

<?php if($total > 0){ ?>
<a href="checkout.php" class="btn btn-dark w-100 mt-3">
    ดำเนินการสั่งซื้อ
</a>
<?php } else { ?>
<div class="alert alert-warning text-center mt-3">
    ยังไม่มีสินค้าในตะกร้า
</div>
<?php } ?>

</div>
</body>
</html>
