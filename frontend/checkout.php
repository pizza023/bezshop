<?php
include '../config/db.php';
$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"
SELECT cart.*, products.price 
FROM cart 
JOIN products ON cart.product_id = products.id
WHERE cart.user_id=$user_id
");

$total = 0;
while($r=mysqli_fetch_assoc($q)){
    $total += $r['price'] * $r['qty'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="max-width:600px;">
<h3>ชำระเงิน</h3>

<form action="../backend/checkout_process.php" method="post">
<textarea name="address" class="form-control mb-3" placeholder="ที่อยู่จัดส่ง" required></textarea>

<select name="payment" class="form-control mb-3">
    <option value="COD">เก็บเงินปลายทาง</option>
    <option value="WALLET">Wallet</option>
</select>

<input type="hidden" name="total" value="<?= $total ?>">

<button class="btn btn-dark w-100">
ยืนยันการสั่งซื้อ (<?= number_format($total) ?> บาท)
</button>
</form>
</div>

</body>
</html>
