<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$uid=$_SESSION['user_id'];

$q=mysqli_query($conn,"
SELECT p.*
FROM favorites f
JOIN products p ON p.id=f.product_id
WHERE f.user_id=$uid
");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการโปรด</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
<a href="index.php" class="btn btn-outline-secondary mb-3">← กลับหน้าร้าน</a>
<h3>❤️ รายการโปรด</h3>

<div class="row mt-4">
<?php while($p=mysqli_fetch_assoc($q)){ ?>
<div class="col-md-4 mb-4">
<div class="card h-100">
<img src="../assets/img/<?= $p['image'] ?>" class="card-img-top">
<div class="card-body">
<h5><?= htmlspecialchars($p['name']) ?></h5>
<p><?= number_format($p['price']) ?> บาท</p>
<a href="product.php?id=<?= $p['id'] ?>" class="btn btn-dark w-100">ดูสินค้า</a>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</body>
</html>
