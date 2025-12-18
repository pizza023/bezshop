<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

$result = mysqli_query($conn,"
    SELECT f.id AS fid, p.*
    FROM favorites f
    JOIN products p ON f.product_id = p.id
    WHERE f.user_id = $uid
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
<h3>❤️ รายการโปรดของฉัน</h3>

<div class="row mt-4">
<?php while($row=mysqli_fetch_assoc($result)){ ?>
<div class="col-md-4 mb-4">
    <div class="card">
        <img src="../assets/img/<?= $row['image'] ?>" class="card-img-top">
        <div class="card-body">
            <h5><?= $row['name'] ?></h5>
            <p><?= number_format($row['price']) ?> บาท</p>

            <a href="../backend/add_cart.php?id=<?= $row['id'] ?>"
               class="btn btn-dark w-100 mb-2">🛒 เพิ่มตะกร้า</a>

            <a href="../backend/remove_favorite.php?id=<?= $row['fid'] ?>"
               class="btn btn-outline-danger w-100">ลบ</a>
        </div>
    </div>
</div>
<?php } ?>
</div>

<a href="index.php" class="btn btn-secondary">← กลับหน้าแรก</a>
</div>
</body>
</html>
