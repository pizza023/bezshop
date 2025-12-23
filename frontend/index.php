<?php
session_start();
include '../config/db.php';

$user = null;
$uid = 0;

if(isset($_SESSION['user_id'])){
    $uid = $_SESSION['user_id'];
    $user = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT username,balance FROM users WHERE id=$uid")
    );
}

/* นับตะกร้า */
$cartCount = 0;
if($uid){
    $c = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT SUM(qty) total FROM cart WHERE user_id=$uid")
    );
    $cartCount = $c['total'] ?? 0;
}

/* หมวดหมู่ */
$cat = $_GET['cat'] ?? '';
$where = $cat ? "WHERE category='$cat'" : '';
$result = mysqli_query($conn,"SELECT * FROM products $where");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>BEZSHOP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/blue.css">
<script src="../assets/js/popup.js" defer></script>
</head>

<body>

<!-- 🔵 Popup -->
<div id="popup">
  <div class="popup-box">
    <span class="close" onclick="closePopup()">×</span>
    <img src="../assets/img/promo.png">
  </div>
</div>

<!-- 🔵 Navbar -->
<nav class="topbar">
  <div class="logo">BEZSHOP</div>

  <div class="topbar-right">
    <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){ ?>
      <a href="../admin/index.php" class="btn btn-dark me-2">ADMIN</a>
    <?php } ?>

    <?php if($user){ ?>
      <span class="me-3">👤 <?= $user['username'] ?> | 💰 <?= number_format($user['balance']) ?></span>
      <a href="favorites.php" class="icon">❤️</a>
      <a href="cart.php" class="icon">🛒 <?= $cartCount ?></a>
      <a href="../backend/logout.php" class="btn btn-outline-dark ms-2">Logout</a>
    <?php } else { ?>
      <a href="login.php" class="btn btn-outline-dark">Login</a>
    <?php } ?>
  </div>
</nav>

<div class="main">

<!-- 🔵 Sidebar -->
<aside class="sidebar">
  <h5>หมวดหมู่</h5>
  <a href="index.php">ทั้งหมด</a>
  <a href="index.php?cat=running">รองเท้าวิ่ง</a>
  <a href="index.php?cat=volleyball">รองเท้าวอลเลย์บอล</a>
  <a href="index.php?cat=casual">รองเท้าใส่สบาย</a>
</aside>

<!-- 🔵 Products -->
<section class="content">
  <h4 class="mb-4">สินค้าแนะนำ</h4>

  <div class="row">
  <?php while($row=mysqli_fetch_assoc($result)){ ?>

    <?php
    $isFav=false;
    if($uid){
      $f=mysqli_query($conn,"SELECT id FROM favorites WHERE user_id=$uid AND product_id={$row['id']}");
      $isFav=mysqli_num_rows($f)>0;
    }
    ?>

    <div class="col-md-4 mb-4">
      <div class="product-card">

        <?php if($user){ ?>
        <a href="../backend/toggle_favorite.php?id=<?= $row['id'] ?>"
           class="fav <?= $isFav?'active':'' ?>">❤️</a>
        <?php } ?>

        <a href="product.php?id=<?= $row['id'] ?>">
          <img src="../assets/img/<?= $row['image'] ?>">
        </a>

        <div class="p-3">
          <h6><?= $row['name'] ?></h6>
          <p class="price"><?= number_format($row['price']) ?> บาท</p>

          <?php if($row['stock']<=0){ ?>
            <span class="badge bg-danger">หมด</span>
          <?php } elseif($user){ ?>
            <a href="../backend/add_cart.php?id=<?= $row['id'] ?>"
               class="btn btn-primary w-100">เพิ่มลงตะกร้า</a>
          <?php } else { ?>
            <a href="login.php" class="btn btn-primary w-100">Login เพื่อซื้อ</a>
          <?php } ?>
        </div>

      </div>
    </div>

  <?php } ?>
  </div>
</section>

</div>

</body>
</html>
