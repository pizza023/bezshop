<?php
session_start();
include '../config/db.php';

$id = (int)$_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE id=$id"));
if(!$p){ die('ไม่พบสินค้า'); }

$uid = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($p['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<div class="container mt-5">

<a href="index.php" class="btn btn-outline-secondary mb-3">← กลับหน้าร้าน</a>

<div class="row">
<div class="col-md-6">
    <img src="../assets/img/<?= $p['image'] ?>" class="img-fluid rounded shadow">
</div>

<div class="col-md-6">
    <h2><?= htmlspecialchars($p['name']) ?></h2>
    <h4 class="text-danger"><?= number_format($p['price']) ?> บาท</h4>
    <p class="text-muted mt-3"><?= nl2br($p['description']) ?></p>
    <p>📦 คงเหลือ <b><?= $p['stock'] ?></b> ชิ้น</p>

    <?php if($p['stock']<=0){ ?>
        <span class="badge bg-danger">สินค้าหมด</span>
    <?php } elseif($uid){ ?>
        <a href="../backend/add_cart.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-lg mt-3">
            🛒 เพิ่มลงตะกร้า
        </a>
    <?php } else { ?>
        <a href="login.php" class="btn btn-dark btn-lg mt-3">Login เพื่อซื้อ</a>
    <?php } ?>
</div>
</div>
</div>
</body>
</html>
