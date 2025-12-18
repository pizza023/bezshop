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

/* 🔢 นับจำนวนสินค้าในตะกร้า */
$cartCount = 0;
if($uid){
    $c = mysqli_fetch_assoc(
        mysqli_query($conn,"
            SELECT SUM(qty) AS total
            FROM cart
            WHERE user_id = $uid
        ")
    );
    $cartCount = $c['total'] ?? 0;
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>BEZSHOP</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<!-- 🔝 Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm px-4 d-flex justify-content-between">
    <span class="navbar-brand fw-bold fs-4">BEZSHOP</span>

    <div class="d-flex align-items-center">

        <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){ ?>
            <a href="../admin/index.php" class="btn btn-dark me-3 px-3">
                🛠 ADMIN
            </a>
        <?php } ?>

        <?php if($user){ ?>
            <span class="me-3 text-nowrap">
                👤 <strong><?= htmlspecialchars($user['username']); ?></strong>
                | 💰 <strong><?= number_format($user['balance']); ?></strong> บาท
            </span>

            <!-- ❤️ รายการโปรด -->
            <a href="favorites.php" class="btn btn-outline-danger me-2">❤️</a>

            <!-- 🛒 ตะกร้า + badge -->
            <a href="cart.php" class="btn btn-outline-dark me-2">
                🛒
                <?php if($cartCount > 0){ ?>
                    <span class="badge bg-dark"><?= $cartCount ?></span>
                <?php } ?>
            </a>

            <!-- Wallet -->
            <a href="wallet.php" class="btn btn-outline-dark me-2">Wallet</a>

            <!-- Logout -->
            <a href="../backend/logout.php" class="btn btn-dark">Logout</a>

        <?php } else { ?>
            <a href="login.php" class="btn btn-outline-dark">Login</a>
        <?php } ?>

    </div>
</nav>

<!-- 🛍️ สินค้า -->
<div class="container mt-5">
    <h3 class="mb-4">สินค้าใหม่</h3>

    <div class="row">
    <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <?php
        // ❤️ เช็คว่ามีในรายการโปรดหรือยัง
        $isFav = false;
        if($uid){
            $favCheck = mysqli_query($conn,"
                SELECT id FROM favorites
                WHERE user_id=$uid AND product_id={$row['id']}
            ");
            if(mysqli_num_rows($favCheck) > 0){
                $isFav = true;
            }
        }
        ?>

        <div class="col-md-4 mb-4">
            <div class="card product-card h-100">

                <img src="../assets/img/<?= $row['image']; ?>" class="card-img-top">

                <div class="card-body d-flex flex-column">
                    <h5><?= htmlspecialchars($row['name']); ?></h5>
                    <p class="text-muted"><?= number_format($row['price']); ?> บาท</p>

                    <?php if($user){ ?>

                        <?php if($isFav){ ?>
                            <button class="btn btn-danger w-100 mb-2" disabled>
                                ❤️ อยู่ในรายการโปรด
                            </button>
                        <?php } else { ?>
                            <a href="../backend/add_favorite.php?id=<?= $row['id']; ?>"
                               class="btn btn-outline-danger w-100 mb-2">
                               ❤️ เพิ่มรายการโปรด
                            </a>
                        <?php } ?>

                        <a href="../backend/add_cart.php?id=<?= $row['id']; ?>"
                           class="btn btn-dark w-100 mt-auto">
                           เพิ่มลงตะกร้า
                        </a>

                    <?php } else { ?>
                        <a href="login.php" class="btn btn-dark w-100">
                            Login เพื่อซื้อสินค้า
                        </a>
                    <?php } ?>
                </div>

            </div>
        </div>

    <?php } ?>
    </div>
</div>

</body>
</html>
