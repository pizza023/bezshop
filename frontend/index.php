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

/* cart count */
$cartCount = 0;
if($uid){
    $c = mysqli_fetch_assoc(
        mysqli_query($conn,"
            SELECT SUM(qty) total FROM cart WHERE user_id=$uid
        ")
    );
    $cartCount = $c['total'] ?? 0;
}

/* category filter */
$category = $_GET['category'] ?? 'all';
$where = $category!='all' ? "WHERE category='$category'" : '';

$result = mysqli_query($conn,"SELECT * FROM products $where");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>BEZSHOP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

<style>
body{ background:#f5f5f5; }
.sidebar{
    background:#fff;
    min-height:100vh;
    border-right:1px solid #eee;
}
.sidebar a{
    display:block;
    padding:12px 18px;
    color:#000;
    text-decoration:none;
    font-weight:500;
}
.sidebar a.active,
.sidebar a:hover{
    background:#000;
    color:#fff;
}
.product-card{
    border:none;
    transition:.2s;
}
.product-card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}
.fav-btn{
    position:absolute;
    top:10px;
    right:10px;
    background:#fff;
    border-radius:50%;
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 2px 6px rgba(0,0,0,.2);
    text-decoration:none;
}
.fav-btn.red{ color:#e74c3c; }
.fav-btn.white{ color:#aaa; }
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <span class="navbar-brand fw-bold fs-4">BEZSHOP</span>

    <div class="d-flex align-items-center">
        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){ ?>
            <a href="../admin/index.php" class="btn btn-dark me-3">🛠 ADMIN</a>
        <?php } ?>

        <?php if($user){ ?>
            <span class="me-3">
                👤 <b><?= htmlspecialchars($user['username']) ?></b>
                | 💰 <?= number_format($user['balance']) ?> บาท
            </span>

            <a href="favorites.php" class="btn btn-outline-danger me-2">❤️</a>

            <a href="cart.php" class="btn btn-outline-dark me-2">
                🛒
                <?php if($cartCount>0){ ?>
                    <span class="badge bg-dark"><?= $cartCount ?></span>
                <?php } ?>
            </a>

            <a href="../backend/logout.php" class="btn btn-dark">Logout</a>
        <?php } else { ?>
            <a href="login.php" class="btn btn-outline-dark">Login</a>
        <?php } ?>
    </div>
</nav>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-2 sidebar p-0">
    <h6 class="px-3 mt-3 text-muted">หมวดหมู่</h6>
    <a href="index.php" class="<?= $category=='all'?'active':'' ?>">ทั้งหมด</a>
    <a href="?category=running" class="<?= $category=='running'?'active':'' ?>">🏃 รองเท้าวิ่ง</a>
    <a href="?category=volleyball" class="<?= $category=='volleyball'?'active':'' ?>">🏐 รองเท้าวอลเลย์บอล</a>
    <a href="?category=casual" class="<?= $category=='casual'?'active':'' ?>">👟 รองเท้าใส่สบาย</a>
</div>

<!-- PRODUCTS -->
<div class="col-md-10 p-4">
<div class="row">

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<?php
$isFav=false;
if($uid){
    $f=mysqli_query($conn,"
        SELECT id FROM favorites
        WHERE user_id=$uid AND product_id={$row['id']}
    ");
    $isFav=mysqli_num_rows($f)>0;
}
?>

<div class="col-md-3 mb-4">
<div class="card product-card h-100 position-relative">

<?php if($user){ ?>
<a href="../backend/toggle_favorite.php?id=<?= $row['id'] ?>"
   class="fav-btn <?= $isFav?'red':'white' ?>">❤️</a>
<?php } ?>

<a href="product.php?id=<?= $row['id'] ?>">
<img src="../assets/img/<?= $row['image'] ?>" class="card-img-top">
</a>

<div class="card-body d-flex flex-column">
    <h6><?= htmlspecialchars($row['name']) ?></h6>
    <p class="fw-bold"><?= number_format($row['price']) ?> บาท</p>

    <?php if($row['stock']<=0){ ?>
        <span class="badge bg-danger">สินค้าหมด</span>
    <?php } elseif($user){ ?>
        <a href="../backend/add_cart.php?id=<?= $row['id'] ?>"
           class="btn btn-dark mt-auto">เพิ่มลงตะกร้า</a>
    <?php } ?>
</div>

</div>
</div>

<?php } ?>

</div>
</div>

</div>
</div>

</body>
</html>
