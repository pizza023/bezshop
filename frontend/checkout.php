<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ดึงของในตะกร้า */
$q = mysqli_query($conn,"
    SELECT c.*, p.price, p.name
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = $user_id
");

if(mysqli_num_rows($q)==0){
    die("ตะกร้าว่าง");
}

$total = 0;
$items = [];
while($r=mysqli_fetch_assoc($q)){
    $sum = $r['price'] * $r['qty'];
    $total += $sum;
    $items[] = $r;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ชำระเงิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5" style="max-width:650px;">

<h3 class="mb-4">🧾 ยืนยันการสั่งซื้อ</h3>

<!-- 🔍 รายการสินค้า -->
<table class="table table-bordered mb-4">
<tr class="table-dark">
    <th>สินค้า</th>
    <th>ราคา</th>
    <th>จำนวน</th>
    <th>รวม</th>
</tr>
<?php foreach($items as $i){ ?>
<tr>
    <td><?= htmlspecialchars($i['name']) ?></td>
    <td><?= number_format($i['price']) ?></td>
    <td><?= $i['qty'] ?></td>
    <td><?= number_format($i['price']*$i['qty']) ?></td>
</tr>
<?php } ?>
<tr>
    <th colspan="3" class="text-end">รวมทั้งหมด</th>
    <th><?= number_format($total) ?> บาท</th>
</tr>
</table>

<!-- ✅ ฟอร์มสั่งซื้อ -->
<form method="post" action="../backend/place_order.php">

    <label class="mb-1">ที่อยู่จัดส่ง</label>
    <textarea name="address"
              class="form-control mb-3"
              required></textarea>

    <label class="mb-1">วิธีชำระเงิน</label>
    <select name="payment_method"
            class="form-control mb-4"
            required>
        <option value="wallet">💰 Wallet</option>
        <option value="cod">🚚 เก็บเงินปลายทาง</option>
    </select>

    <button class="btn btn-dark w-100 py-2">
        ยืนยันสั่งซื้อ (<?= number_format($total) ?> บาท)
    </button>

</form>

<a href="cart.php" class="btn btn-outline-secondary w-100 mt-3">
    ← กลับตะกร้า
</a>

</div>
</body>
</html>
